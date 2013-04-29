<?php

$header = $imageData = '';

/**
 * Ensure that the query string contains the correct URL
 */
$url = 'http:\/\/ox-i.shinka.sh\/bba\/';

if (!isset($_GET['url']) || !preg_match("/^$url/", $_GET['url'])) {
    exit;
}

/**
 * Get the original width and height from the query string
 */
$width = $_GET['width'];
$height = $_GET['height'];

/**
 * Get the device width from the query string, otherwise default to 120px
 */
if (isset($_GET['device']) && !empty($_GET['device']))
{
    $deviceWidth = $_GET['device'];
}
else
{
    $deviceWidth = 120;
}

/**
 * Get info about the source banner image
 */
$info = getimagesize($_GET['url']);

/**
 * Get the raw image content from the Shinka ad server
 */
$raw = file_get_contents($_GET['url']);

/**
 * Only attempt to resize the banner if: 
 *
 * 1. The GD library is installed (imagecopyresampled function exists)
 * 2. The device width is less than the original banner width
 */
if (function_exists('imagecopyresampled') && $deviceWidth < $width) {
    /**
     * Create a source image object from the raw image data
     */
    $source = imagecreatefromstring($raw);

    /**
     * Only attempt to resize the banner if there is a valid source object
     */
    if ($source !== false) {
        if ($deviceWidth > ($width+10)) {
            $newwidth = ($deviceWidth-10);
        } else {
            $newwidth = $deviceWidth;
        }

        /**
         * Calculate the new height, maintaining the aspect ratio
         */
        $newheight = (($newwidth / $_GET['width']) * $_GET['height']);

        /**
         * Create the output image object with the new width and height
         */
        $output = imagecreatetruecolor($newwidth, $newheight);

        imagecopyresampled($output, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        ob_start();
        imagepng($output, null);
        $imageData = ob_get_contents();
        ob_end_clean();
    } else {
        $imageData = $raw;
    }
} else {
    $imageData = $raw;
}

/**
 * Send the header and output the binary image data
 */
$header = ($imageData == $raw) ? $info['mime'] : 'image/png';
header('Content-Type: '. $header);
echo $imageData;