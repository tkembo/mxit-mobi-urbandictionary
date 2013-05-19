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
	$hostname_mxit_urbandictionary = "localhost";
	$database_mxit_urbandictionary = "mxiturbandictionary";
	$username_mxit_urbandictionary = "root";
	$password_mxit_urbandictionarys = "";
	/*
	$hostname_mxit_urbandictionary = "us-cdbr-azure-west-b.cleardb.com";
	$database_mxit_urbandictionary = "mxiturbandictionary";
	$username_mxit_urbandictionary = "bcb8a82d9a9ece";
	$password_mxit_urbandictionarys = "e3771f06";
	*/
	$mxit_urbandictionary = mysql_pconnect($hostname_mxit_urbandictionary, $username_mxit_urbandictionary, $password_mxit_urbandictionarys) or trigger_error(mysql_error(),E_USER_ERROR); 
	
?>