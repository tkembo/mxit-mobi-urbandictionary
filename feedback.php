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
<h1>Urban's Dictionary</h1>
<p>
	Applicaition developed by: <strong>Tawanda Kembo</strong>
</p>
<p>
	Feel to to email suggestions/feedback/comments/complaints to <strong>tkembo@gmail.com</strong>
</p>
<p>
Other Mxit Applications by Tawanda Kembo
<ul>
	<li>Murphy's Laws (<strong>muphyslaws</strong>)</li>
    <li>ZiFM Stereo (<strong>zifm</strong>)</li>
    <li>Devil's Dictionary (<strong>devilsdictionary</strong>)</li>
</ul>
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