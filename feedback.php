<?php	
	require_once("inc/config.php");
	require_once("inc/ShinkaBannerAd.php"); 
	require_once("inc/functions.php"); 

	if (isset($_GET['mxit_transaction_res'])&&($_GET['mxit_transaction_res']<>0)) 
	{
		header("Location: ".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."error.php?mxit_transaction_res=".$_GET['mxit_transaction_res'] );
	}
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Feedback/Help/About/More Info</title>
</head>

<body>
<h1>Urban Dictionary</h1>
<p>My name is <strong>Tawanda Kembo</strong> &amp; I am glad you have seen value in this app. </p>
<p>If you have any suggestions on how I can improve this app to give you a better experience when you use it, the fastest way to reach me is via email. My email address is <strong>tkembo@gmail.com</strong>.</p>
<p> Also, I have made this application opensource so if you are developer feel free to fork it on GitHub, contribute or to help me with refactoring the code. The GitHub repository for this application (and others I have worked on) is at <strong>https://github.com/tkembo?tab=repositories</strong>.</p>
<p>If you like this application, then you will probably like other applications I have developed and these are:</p>
<ul>
	<li>Murphy's Laws (<strong>murphyslaws</strong>)</li>
    
    <li>Devil's Dictionary (<strong>devilsdictionary</strong>)</li>
</ul>
<p>You can find out more about me on: <strong>http://about.me/tawandakembo</strong></p>
</p>
 <b><a href="clear_screen.html">a</a>) </b><a href="clear_screen.html">Clear screen</a><br/>            
			<b><a href="index.php">b</a>) </b><a href="index.php">Go to Home Screen </a>
       <br />
        <?php
  			$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
		?>
		<img src="<?php echo $googleAnalyticsImageUrl; ?>" style="display:none;"/> 
        <br/>
        
        <?php
			 /*
			 * Create shinka banner ad object.
			 * Can be done at top of page, and re-used to display multiple banners on page.
			 */
			$ShinkaBannerAd = new ShinkaBannerAd($config);	
		
			/*
			 * Do a server ad request to populate the BannerAd object with a new banner.
			 * This can be done multiple times with the same ShinkaBannerAd object to get new banners for the same user
			 */	  
		
			/**
			 * Get a text banner for this user, and display it
			 */
			$ShinkaBannerAd->doServerAdRequest('text');
			print $ShinkaBannerAd->generateHTMLFromAd();
		?>      
            
</body>
</html>