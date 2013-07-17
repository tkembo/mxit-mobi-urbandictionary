<?php
	/*
	 * Global VARs
	 */
	
	$clear_screen = '<meta name="mxit" content="clearscreen" />';
	$launch_in_browser = 'onclick="window.open(this.href); return false;"';

	function getUserDetails() {
      if (!empty($_SERVER["HTTP_X_MXIT_USERID_R"])) {
  
          //user data is present
          $data->useragent = $_SERVER["HTTP_X_DEVICE_USER_AGENT"];
          $data->contact = $_SERVER["HTTP_X_MXIT_CONTACT"];
          $data->nick = $_SERVER["HTTP_X_MXIT_NICK"];
          $data->userid = $_SERVER["HTTP_X_MXIT_USERID_R"];
          $data->locations = $_SERVER["HTTP_X_MXIT_LOCATION"];
          $data->profile = $_SERVER["HTTP_X_MXIT_PROFILE"];
          $data->pixels = $_SERVER["HTTP_UA_PIXELS"];
      } else {
          //user data is not present
          $data = NULL;
      }
      return $data;
    }
	
	function userHasGraphicsMarkup() {
		$user_data = getUserDetails();    	
		if (empty($user_data->userid)) {
			// not in MXit, a browser, as good as graphics markup
			return true;
		}
		$loc = $user_data->locations;
		$parts = explode(',', $loc);

		if (array_key_exists(8, $parts)) {
			$features = intval(trim($parts[7]));
			if (($features & 4194304) == 4194304) {
				return true;
			}
		}	
		
		return false;
	}
    
	function getMXitTableTitle() {
		if (userHasGraphicsMarkup()) {
			// Has Gaming/Graphics capabilities
			return "mxit:table:full";
		}
		return "e";
	}
	
    function showImages(){
    	
		$mxit_user = isMXitUser();
		$show_images = true;
		
		if($mxit_user){
	    	//See if we have cookies for the user
			$ua = getSession("ua_device");
	
	    	if(empty($ua)){
				//Get the device UA
		    	$ua = deviceAgent();
				
				//If not we need to pull our list in to memory
		    	$phone_list = getPhoneList();
	
		    	//See if its in our list
			if ($phone_list) {
				foreach($phone_list['0'] as $device){
					$device = strtolower($device);
	
					if($device == $ua){
						$show_images = false;
						saveSession("ua_bool", "false");
						saveSession("ua_device", $ua);
						
						break;
					}
					else{
						$show_images = true;
						saveSession("ua_bool", "true");
						saveSession("ua_device", $ua);
					}
				}		
			}	
	    	}
	    	else{
	    		$ua_bool = getSession("ua_bool");
	    		
	    		if($ua_bool == "false"){
	    			$show_images = false;
	    		}
	    		else{
	    			$show_images = true;
	    		}
	    	}
		}
		//Return the result
	    return $show_images;
    }
    
    function getPhoneList(){
	    $url = "[{ \"0\" : \"Nokia/5000\",	\"1\" : \"Motorola/V360\"}]";

	//"http://frlinrnd02.de.mxit.com/botproxy_test/mxit_mobi_library/phones.json";   
	 
	    //$ch = curl_init($url);
	    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	    //$data = curl_exec($ch);
	    //curl_close($ch);
	    $data = $url; //either this or above
	    $resultArray = json_decode($data, true);

	    return $resultArray;
	}
	
	function deviceAgent(){
		$user_data = getUserDetails();    	
    	$ua = $user_data->useragent;
		$ua = strtolower($ua);
		
		return $ua;
	}
	
	function isMXitUser(){
		$user_data = getUserDetails();    	
  	
    	if(!empty($user_data->userid)){
    		return true;
    	}
    	else{
    		return false;
    	}
	}
	
	function getSession($session_name){
		$session = $_SESSION["$session_name"];
	    	
	   	if(empty($session)){
	    	$session = $_COOKIE["$session_name"];
	    }
		return $session;
	}
	
	function saveSession($session_name, $data){
		setcookie("$session_name", "$data");
		$_SESSION["$session_name"] = $data;;
	}
	
	function clearSession(){
		saveSession("ua_device", "");
    	saveSession("ua_bool", "");
	}
	
