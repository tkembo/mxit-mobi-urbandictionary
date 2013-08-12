<?php	
	require_once("inc/config.php");
	require_once("inc/ShinkaBannerAd.php"); 
	require_once("inc/functions.php"); 

	?>
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Urban Dictionary</title>
</head>

<body>
<?php
	$phrase1 = "You're the greatest";
	$phrase2 = "We should create a statue for you!";
	$phrase3 = "Your parents raised you well!";
	$phrase4 = "Why can't the whole world be like you?";
	$rand_num = rand(1,4);
?>
<h1>
	<?php 
	
		switch ($rand_num){
			case 1:
			echo $phrase1;
			break;
			case 2:
			echo $phrase2;
			break;
			case 3:
			echo $phrase3;
			break;
			case 4:
			echo $phrase4;
			break;
			
			
		}
	?>
</h1>
<p>I really appreciate you taking your time out to submit new words. Just give me a  few hours to review the definition you have submitted. I just want to make sure your definition isn't something that will offend other users</p>
<p>Could you also <br>
			<a href="mxit://[mxit_recommend]/Recommend?service_name=urbandictionary" type="mxit/service-navigation">invite your friends to check this app out</a></p>
<b><a href="index.php">b</a>) </b><a href="index.php">Back to home screen</a><br/>

<b>Search for another word</b> by typing it (or the first few letters) here<br/>
<form action="search.php" method="get" name="searchWordForm">
<input name="searchTextBox" type="text" />
<input name="submitButton" type="submit"  />
</form>

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
			$ShinkaBannerAd->doServerAdRequest('image');
			print $ShinkaBannerAd->generateHTMLFromAd();
		?>  

<br>
        <p><strong><a href="feedback.php">f1</a>) <a href="feedback.php">About this app</a></strong>
            <br />
            <strong><a href="submit_word.php">f2</a>) <a href="submit_word.php">Submit your own word</a>
            </p>    	
</body>
</html>
<?php
mysql_free_result($searchResultsRecordset);
?>
