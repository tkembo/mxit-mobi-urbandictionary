<?php	
	require_once("inc/config.php");
	require_once("inc/ShinkaBannerAd.php"); 
	require_once("inc/functions.php"); 

	if (isset($_GET['mxit_transaction_res'])&&($_GET['mxit_transaction_res']<>0)) 
	{
		header("Location: ".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."error.php?mxit_transaction_res=".$_GET['mxit_transaction_res'] );
	}
	
	//Pick one featured recordset
$maxRows_featuredWordsRecordset = 1;
$pageNum_featuredWordsRecordset = 0;
if (isset($_GET['pageNum_featuredWordsRecordset'])) {
  $pageNum_featuredWordsRecordset = $_GET['pageNum_featuredWordsRecordset'];
}
$startRow_featuredWordsRecordset = $pageNum_featuredWordsRecordset * $maxRows_featuredWordsRecordset;

mysql_select_db($database_mxit_devilsdictionary, $mxit_devilsdictionary);
$query_featuredWordsRecordset = "SELECT * FROM word WHERE is_featured = 1 AND approved = 1 ORDER BY RAND()";
$query_limit_featuredWordsRecordset = sprintf("%s LIMIT %d, %d", $query_featuredWordsRecordset, $startRow_featuredWordsRecordset, $maxRows_featuredWordsRecordset);
$featuredWordsRecordset = mysql_query($query_limit_featuredWordsRecordset, $mxit_devilsdictionary) or die(mysql_error());
$row_featuredWordsRecordset = mysql_fetch_assoc($featuredWordsRecordset);

if (isset($_GET['totalRows_featuredWordsRecordset'])) {
  $totalRows_featuredWordsRecordset = $_GET['totalRows_featuredWordsRecordset'];
} else {
  $all_featuredWordsRecordset = mysql_query($query_featuredWordsRecordset);
  $totalRows_featuredWordsRecordset = mysql_num_rows($all_featuredWordsRecordset);
}
$totalPages_featuredWordsRecordset = ceil($totalRows_featuredWordsRecordset/$maxRows_featuredWordsRecordset)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Urban Dictionary</title>
</head>

<body>
<h1>Urban Dictionary</h1>

  <?php //do { ?>
      <b>Random Word: </b>
      <br />
      
	  <b><?php echo $row_featuredWordsRecordset['word'];?></b>, <?php echo $row_featuredWordsRecordset['definition'];?>
    <?php //} while ($row_featuredWordsRecordset = mysql_fetch_assoc($featuredWordsRecordset)); ?>

<br /><br />

<br />
You can type in the word whose definition you want to submit (<strong>Enter the word only!</strong> You will enter the definition in the next screen):
<form action="submit_definition.php" method="get" name="searchWordForm">
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
			$ShinkaBannerAd->doServerAdRequest('text');
			print $ShinkaBannerAd->generateHTMLFromAd();
		?>  

<br>
        <p>
        	<strong><a href="feedback.php">f1</a>) <a href="feedback.php">Feedback/Help/About/More Info</a></strong>
            <br />
            <strong><a href="feedback.php">f2</a>) <a href="submit.php">Submit your own word</a>
            </p>     	
</body>
</html>
<?php
mysql_free_result($featuredWordsRecordset);
?>
