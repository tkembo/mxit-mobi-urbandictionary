<?php
require_once('MxitUser.php');

/**
 * Shinka banner ad library for PHP
 */
class ShinkaBannerAd
{
    /**
     * Constant values so that we rather use the variable name,
     * and NOT hard code the text string values in the code in multiple places
     */
    const API_SERVER = 'http://ox-d.shinka.sh/ma/1.0/arj';
    const TYPE_IMAGE = 'image';
    const TYPE_HTML = 'html';
    const TYPE_INVALID = 'invalid';
    const TARGET_MXIT = 'mxit';
    const TARGET_SELF = '_self';

    /**
     * The fields we need to set in the constructor so that we have enough info
     * to later do multiple Server Ad requests using this BannerAd object
     */
    protected $_requestParam_age;
    protected $_requestParam_gender;
    protected $_requestParam_device;
    protected $_requestParam_deviceWidth;	
    protected $_requestParam_country;
    protected $_requestParam_xid;
    protected $_clientDeviceIP;
    protected $_adUnitIDToUse;

    /**
     * whizpool: variable defination to save the ad object we get from shinka
     */
    protected $_ad;

    /**
     * The actual fields of this BannerAd which we get from OpenX after we have done a ServerAd request
     */
    protected $_type;
    protected $_mediaUrl;
    protected $_mediaHeight;
    protected $_mediaWidth;
    protected $_alt;
    protected $_target;
    protected $_beacon;
    protected $_click;
    protected $_html;

    /**
     * Configuration settings
     *
     */
    protected $_AD_TYPE;
    protected $_AdUnitID_320;
    protected $_AdUnitID_216;
    protected $_AdUnitID_168;
    protected $_AdUnitID_120;
    protected $_RESIZE_IMAGES;
    protected $_REFERER;
    protected $_TIMEOUT;
    protected $_TESTUSER;

    public function __construct($config='')
    {
        /**
         * Throw exception if config parameters are not set
         */
        if ($config == '')
            throw new Exception('No configuration specified, refer to documentation for an example');

        /**
         * Throw exception if config parameters are not set correctly
         */
        if (!is_array($config) || count($config) < 2)
            throw new Exception('Incorrect configuration specified, refer to documentation for an example');

        /**
         * Throw exception if AdUnitID_320 is not set
         */
        if (!isset($config['AdUnitID_320']))
            throw new Exception('AdUnitID_320 configuration is missing');

        /**
         * Throw exception if REFERER is not set
         */
        if (!isset($config['REFERER']))
            throw new Exception('REFERER configuration is missing');

        /**
         * Set configuration
         */
        $this->_REFERER = $config['REFERER'];
        $this->_TIMEOUT = isset($config['TIMEOUT']) ? $config['TIMEOUT'] : 1;
        $this->_RESIZE_IMAGES = isset($config['RESIZE_IMAGES']) ? $config['RESIZE_IMAGES'] : FALSE;
        $this->_TESTUSER = isset($config['TESTUSER']) ? $config['TESTUSER'] : 'm0000000000';

        $this->_AdUnitID_320 = $config['AdUnitID_320'];

        $sizes = array('216', '168', 120);

        foreach ($sizes as $size)
        {
            /**
             * Throw exception if Only 1 AD Unit is specified, and image resizing is disabled
             */
            if ($this->_RESIZE_IMAGES === FALSE && !isset($config['AdUnitID_'. $size]))
                throw new Exception('AdUnitID_'. $size .' must be specified if image resizing is disabled');

            $this->{'_AdUnitID_'. $size} = isset($config['AdUnitID_'. $size]) ? $config['AdUnitID_'. $size] : NULL;
        }

        $mxitUser = new MxitUser();
        $tempAge = $mxitUser->getAge();
        $this->_requestParam_age = floor($tempAge);		
        $this->_requestParam_gender = ($mxitUser->getGender() == 1) ? 'male' : 'female';		
        $this->_requestParam_device = $mxitUser->getDeviceUserAgent();
        $this->_requestParam_deviceWidth = $mxitUser->getDeviceWidth();
        $this->_requestParam_country = $mxitUser->getCurrentCountryId();		
        $this->_requestParam_xid = $mxitUser->getMxitUserId();		
        $this->_clientDeviceIP = $_SERVER['HTTP_X_FORWARDED_FOR'];	

        /**
         * Decide which AdUnitID to use based on the user device width
         */
        $deviceWidth = $this->_requestParam_deviceWidth;

        /**
         * Debugging
         */
        if ($this->_requestParam_xid == $this->_TESTUSER)
            print 'DeviceWidth:'. $deviceWidth . '<br/>'; 

        if ($this->_RESIZE_IMAGES === TRUE)
        {
            $this->_adUnitIDToUse = $this->_AdUnitID_320;			
        }
        else
        {
            if ($deviceWidth >= 320) 
            {
                $this->_adUnitIDToUse = $this->_AdUnitID_320;			
            }
            elseif ($deviceWidth >= 216)
            {
                $this->_adUnitIDToUse = $this->_AdUnitID_216;
            }
            elseif ($deviceWidth >= 168)
            {
                $this->_adUnitIDToUse = $this->_AdUnitID_168;
            }
            else
            {
                $this->_adUnitIDToUse = $this->_AdUnitID_120;
            }
        }

        /**
         * Debugging
         */
        if ($this->_requestParam_xid == $this->_TESTUSER)
            print 'AdUnitIDToUse:' . $this->_adUnitIDToUse . '<br/>';	
    }

    public function doServerAdRequest($adType='image')
    {
        /**
         * Throw exception if an unknown AD_TYPE is specified
         */
        if ($adType != 'image' && strtolower($adType) != 'text')
        {
            throw new Exception("Invalid ad type specified - Only 'image' or 'text' are supported");
        }

        $this->_AD_TYPE = strtolower($adType);

        /**
         * Debugging
         */
        if ($this->_requestParam_xid == $this->_TESTUSER)
            print 'Type Requested: '. ucfirst($this->_AD_TYPE) .' Ad<br/>';

        $BannerRequest = array(
                'c.age' => $this->_requestParam_age,
                'c.gender' => $this->_requestParam_gender,
                'c.device' => $this->_requestParam_device,
                'c.country' => $this->_requestParam_country,
                'xid' => $this->_requestParam_xid,
                );

        $BannerRequest['auid'] = $this->_adUnitIDToUse;

        /**
         * Following is a http call to server, sending get parameters and headers
         */
        $get = $this::API_SERVER .'?'. http_build_query($BannerRequest); //api server address and get parameters to be sent
        $ch = curl_init();

        /**
         * Debugging
         */
        if ($this->_requestParam_xid == $this->_TESTUSER)
            print 'URLUsed: ' . $get . '<br/>';

        /**
         * Defining headers to be sent with the call
         */
        curl_setopt($ch, CURLOPT_URL, $get);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla Compatible');
        curl_setopt($ch, CURLOPT_REFERER, $this->_REFERER);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Forwarded-For: '.$this->_clientDeviceIP)); //'Content-length: '.strlen($BannerRequest) 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_TIMEOUT);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->_TIMEOUT);

        /**
         * Get the Ad object in json format
         */
        $this->_ad = curl_exec($ch); 
        curl_close($ch); 

        /**
         * decoding the json response		
         */
        $decodedBody = json_decode($this->_ad); 

        if (isset($decodedBody->ads->version) && $decodedBody->ads->version == 1) {
            if (isset($decodedBody->ads->count) && $decodedBody->ads->count > 0) {
                if (isset($decodedBody->ads->ad)) {	

                    /**
                     * Debugging
                     */
                    if ($this->_requestParam_xid == $this->_TESTUSER)
                        print 'Decoding ad...<br/>';

                    $ad = $decodedBody->ads->ad[0];

                    switch ($ad->type) {
                        case 'image':
                            try {	
                                /**
                                 * Debugging
                                 */
                                if ($this->_requestParam_xid == $this->_TESTUSER)
                                    print 'Type Received: Image Ad<br/>';

                                $creative = $ad->creative[0];

                                $this->_mediaUrl = $creative->media;
                                $this->_mediaHeight = $creative->height;
                                $this->_mediaWidth = $creative->width;
                                $this->_alt = $creative->alt;						
                                $this->_beacon = $creative->tracking->impression;
                                $this->_click = $creative->tracking->click;				
                                $this->_type = $this::TYPE_IMAGE;

                                /**
                                 * Debugging
                                 */
                                if ($this->_AD_TYPE == 'image' && $this->_requestParam_xid == $this->_TESTUSER)
                                    print '_mediaUrl: '.$creative->media.'<br/>';

                                if($creative->target == self::TARGET_MXIT || $creative->target == self::TARGET_SELF)
                                {
                                    $this->_target = '';
                                }
                                else
                                {
                                    $this->_target = "onclick='window.open(this.href); return false;'";
                                }

                                /**
                                 * Debugging
                                 */
                                if ($this->_requestParam_xid == $this->_TESTUSER)
                                    print '_target: '.$this->_target.'<br/>';							

                            } catch (Exception $e) {
                                $this->_type = $this::TYPE_INVALID;
                            }
                            break;
                        case 'html':
                            try {
                                /**
                                 * Debugging
                                 */
                                if ($this->_requestParam_xid == $this->_TESTUSER)
                                    print 'Type Received: HTML Ad<br/>';

                                $this->_html = $ad->html;
                                $this->_type = $this::TYPE_HTML;
                            } catch (Exception $e) {
                                $this->_type = $this::TYPE_INVALID;
                            }
                            break;	
                    }
                }
                else
                {
                    /**
                     * Debugging
                     */
                    if ($this->_requestParam_xid == $this->_TESTUSER)
                    {
                        print 'No ad returned: <br/>';
                        print $this->_ad .'<br/>';
                    }
                }				
            }
            else
            {
                /**
                 * Debugging
                 */
                if ($this->_requestParam_xid == $this->_TESTUSER)
                    print 'Error 3: No ads returned<br>';
            }
        }
        else
        {
            /**
             * Debugging
             */
            if ($this->_requestParam_xid == $this->_TESTUSER)
                print 'Error 4: Ads version not set<br>';
        }		
    }

    public function generateHTMLFromAd()  
    {
        /**
         * Debugging
         */
        if ($this->_requestParam_xid == $this->_TESTUSER)
            print 'Generating HTML...<br/>';

        $output = '';

        if ($this->_type == self::TYPE_IMAGE) // if add type is image
        {	
            if ($this->_AD_TYPE == 'image' && $this->_RESIZE_IMAGES === TRUE)
            {
                /**
                 * With on the fly resizing:
                 */
                $imageURL = '/image-resizer.php?url='
                          . urlencode($this->_mediaUrl)
                          . '&width=' . $this->_mediaWidth
                          . '&height=' . $this->_mediaHeight
                          . '&device=' . $this->_requestParam_deviceWidth;
            }
            else 
            {
                /**
                 * No resizing:
                 */
                $imageURL = $this->_mediaUrl;			
            }

            /**
             * Debugging
             */
            if ($this->_AD_TYPE == 'image' && $this->_requestParam_xid == $this->_TESTUSER)
            {
                print 'Image URL: ' . $imageURL . '<br/>';
                print 'Image Link: <a href="' . $imageURL . '" onclick="window.open(this.href); return false;">link</a><br />';
            }

            if ($this->_AD_TYPE == 'image')
            {
                $imageHTML_Tag = '<img src="' .$imageURL. '" align="middle" />';

                $output .= $imageHTML_Tag .'<br />';
            }

            $output .= '<a href="' .$this->_click. '" '.$this->_target. '>' . $this->_alt . '</a>';

            $this->registerImpression($this->_beacon);
            return $output;
        }
        elseif($this->_type == self::TYPE_HTML) // if ad type is html
        {
            //$output.= "<a href=".$this->_click." ".$this->_target.">";
            $output .= $this->_html;
            //$output.= "</a>";

            $this->registerImpression($this->_beacon);
            return $output;
        }
        else // if ad type is not image or html
        {
            $this->_type = self::TYPE_INVALID;
            return '';
        }
    }

    public function getType()
    {
        return $this->_type;
    }

    public function isValid()
    {
        if ($this->getType() == self::TYPE_INVALID) 
        {
            return false;
        } 
        else 
        {
            return true;
        }
    }

    public function getMediaUrl()
    {
        return $this->_mediaUrl;
    }

    public function getMediaHeight()
    {
        return $this->_mediaHeight;
    }

    public function getMediaWidth()
    {
        return $this->_mediaWidth;
    }

    public function getAlt()
    {
        return $this->_alt;
    }

    public function getTarget()
    {
        return $this->_target;
    }

    public function getBeacon()
    {
        return $this->_beacon;
    }

    public function getClick()
    {
        return $this->_click;
    }

    public function getHtml()
    {
        return $this->_html;
    }	

    public function registerImpression($impression)
    {
        $get = $impression;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $get);		
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla Compatible');
        curl_setopt($ch, CURLOPT_REFERER, $this->_REFERER);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Forwarded-For: '. $this->_clientDeviceIP));		
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_TIMEOUT);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->_TIMEOUT);

        $impression_result = curl_exec($ch);
        curl_close($ch);		
        return $impression_result;		
    }
}