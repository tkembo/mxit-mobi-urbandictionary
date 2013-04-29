<?php
	
	//Configuration for Shinka Banners
	$config = array('AdUnitID_320'  => '366558',
                    'RESIZE_IMAGES' => TRUE,
                    'REFERER'       => 'urbandictionary',
                    'TESTUSER'      => 'tkembo');
	
	//Configuration for Google Analytics
	$GA_ACCOUNT = "MO-28800751-1";
	$GA_PIXEL = "ga.php";
	
	//DB Settings
	$hostname_mxit_devilsdictionary = "us-cdbr-azure-west-b.cleardb.com";
	$database_mxit_devilsdictionary = "mxiturbandictionary";
	$username_mxit_devilsdictionary = "bcb8a82d9a9ece";
	$password_mxit_devilsdictionarys = "e3771f06";
	$mxit_devilsdictionary = mysql_pconnect($hostname_mxit_devilsdictionary, $username_mxit_devilsdictionary, $password_mxit_devilsdictionarys) or trigger_error(mysql_error(),E_USER_ERROR); 
	
?>