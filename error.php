<?php
  $GA_ACCOUNT = "MO-28800751-1";
  $GA_PIXEL = "ga.php";

  function googleAnalyticsGetImageUrl() {
    global $GA_ACCOUNT, $GA_PIXEL;
    $url = "";
    $url .= $GA_PIXEL . "?";
    $url .= "utmac=" . $GA_ACCOUNT;
    $url .= "&utmn=" . rand(0, 0x7fffffff);

    $referer = $_SERVER["HTTP_REFERER"];
    $query = $_SERVER["QUERY_STRING"];
    $path = $_SERVER["REQUEST_URI"];

    if (empty($referer)) {
      $referer = "-";
    }
    $url .= "&utmr=" . urlencode($referer);

    if (!empty($path)) {
      $url .= "&utmp=" . urlencode($path);
    }

    $url .= "&guid=ON";

    return $url;
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <meta name="mxit" content="clearscreen" />
        <title>Error</title>
        </head>
    <body>
    	<?php
			if (isset($_GET['mxit_transaction_res'])) {
				switch($_GET['mxit_transaction_res']){
					case 1:
						echo"MXit tells us that you chose not to confirm the payment request. I wonder why?";
					break;
					case 2:
						echo"Mxit tells us that you gave them an invalid MXit login name or password (authentication failure).";
					break;
					case 3:
						echo"MXit tells us that your account is locked (e.g. because of multiple authentication failures).";
					break;
					case 4:
						echo"MXit tells us that you have insufficient funds. You need to get more MXit Moola.";
					break;
					case 5:
						echo"MXit tells us that the ransaction timed out before a response was received from you.";
					break;
					case 6:
						echo"MXit tells us that you logged out without confirming or rejecting the transaction.";
					break;
					default:
						echo"A technical system error occurred. Sorry!";
					break;
				}
				
			}
		?>
        <br/>
        Click <a href="clear_screen.html">here</a> to clear the screen.
        <br /><br />
        <a href="index.php">Home</a>
        
        <?php
			$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
			echo '<img src="' . $googleAnalyticsImageUrl . '" />';
		?>
    </body>
</html>