<?php	
	require_once("inc/config.php");
	require_once("inc/functions.php"); 
	require_once("inc/mxit_core.php");
	
	$show_images = showImages();
	
	if (isset($_GET['mxit_transaction_res'])&&($_GET['mxit_transaction_res']<>0)) 
	{
		header("Location: ".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."error.php?mxit_transaction_res=".$_GET['mxit_transaction_res'] );
	}
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>About this Urban Dictionary</title>
</head>

<body>
<h1>Urban Dictionary</h1>
<p><?php
//To dynamically resize my avatar

$user_details = getUserDetails();
		$screen_size = $user_details->pixels;
		
		if($show_images){	
			$width = floor(0.50*(substr($screen_size, 0, 3)));
			$height = floor(0.50*(substr($screen_size, 0, 3)));
			print '<img src="./images/tawanda_avatar.png" width="' . $width . '" height="' . $height . '"  align="left"/>';
		}
?>
My name is <strong>Tawanda Kembo</strong> &amp; I am glad you're using this app. </p>
<p>If you have any suggestions on how I can improve this app to give you a better experience when you use it, the fastest way to reach me is via email. My email address is <a href="mailto:tkembo@gmail.com" onclick="window.open(this.href); return false;">tawanda@gmail.com</a>.</p>
<p> Also, I have made this application opensource so feel free to fork it on <a href="https://github.com/tkembo?tab=repositories" onclick="window.open(this.href); return false;">GitHub</a>.</p>
<p>If you like this application, then you will probably like other applications I have developed and these are:</p>
<ul>
	<li><a href="mxit://[mxit_recommend:Refresh]/Referral?from=urbandictionary&to=murphyslaws" type="mxit/service-navigation">murphyslaws</a></li>
	<li><a href="mxit://[mxit_recommend:Refresh]/Referral?from=urbandictionary&to=devilsdictionary" type="mxit/service-navigation">devilsdictionary</a></li>
</ul>
<p>
	Just click on the link above to add the app
</p>
<p>
<br>
 You should also <a href="mxit://[mxit_recommend]/Recommend?service_name=urbandictionary" type="mxit/service-navigation">Invite your friends to check this app out</a>
</p>
<p>You can read more about me on: <a href="http://about.me/tawandakembo" onclick="window.open(this.href); return false;">http://about.me/tawandakembo</a></p>
</p>
 <b><a href="clear_screen.html">a</a>) </b><a href="clear_screen.html">Clear screen</a><br/>            
			<b><a href="index.php">b</a>) </b><a href="index.php">Go to Home Screen </a>
       <br />
        <?php
  			$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
		?>
		<img src="<?php echo $googleAnalyticsImageUrl; ?>" style="display:none;"/>      
            
</body>
</html>