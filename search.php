<?php	
	require_once("inc/config.php");
	require_once("inc/ShinkaBannerAd.php"); 
	require_once("inc/functions.php"); 

	if (isset($_GET['mxit_transaction_res'])&&($_GET['mxit_transaction_res']<>0)) 
	{
		header("Location: ".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."error.php?mxit_transaction_res=".$_GET['mxit_transaction_res'] );
	}
	
	//Pick ten results at a time
$maxRows_searchResultsRecordset = 10;
$pageNum_searchResultsRecordset = 0;
if (isset($_GET['pageNum_searchResultsRecordset'])) {
  $pageNum_searchResultsRecordset = $_GET['pageNum_searchResultsRecordset'];
}
$startRow_searchResultsRecordset = $pageNum_searchResultsRecordset * $maxRows_searchResultsRecordset;

$colname_searchResultsRecordset = "-1";
if (isset($_GET['searchTextBox'])) {
  $colname_searchResultsRecordset = $_GET['searchTextBox'];
}
mysql_select_db($database_mxit_urbandictionary, $mxit_urbandictionary);
$query_searchResultsRecordset = sprintf("SELECT * FROM word WHERE word LIKE '%s%s' AND approved = 1 ORDER BY word ASC", 
GetSQLValueString($colname_searchResultsRecordset, "text"),
GetSQLValueString('%', "text"));
$query_limit_searchResultsRecordset = sprintf("%s LIMIT %d, %d", $query_searchResultsRecordset, $startRow_searchResultsRecordset, $maxRows_searchResultsRecordset);
$searchResultsRecordset = mysql_query($query_limit_searchResultsRecordset, $mxit_urbandictionary) or die(mysql_error());
$row_searchResultsRecordset = mysql_fetch_assoc($searchResultsRecordset);

if (isset($_GET['totalRows_searchResultsRecordset'])) {
  $totalRows_searchResultsRecordset = $_GET['totalRows_searchResultsRecordset'];
} else {
  $all_searchResultsRecordset = mysql_query($query_searchResultsRecordset);
  $totalRows_searchResultsRecordset = mysql_num_rows($all_searchResultsRecordset);
}
$totalPages_searchResultsRecordset = ceil($totalRows_searchResultsRecordset/$maxRows_searchResultsRecordset)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Urban Dictionary - Search Results</title>
</head>

<body>
<h1>Urban Dictionary</h1>
<br />
<b><?php echo $totalRows_searchResultsRecordset; ?> Results:</b>
<br /><br />
  <?php do { ?>
	  <b><?php echo $row_searchResultsRecordset['word'];?></b>, <?php echo $row_searchResultsRecordset['definition'];?><br />
    <?php } while ($row_searchResultsRecordset = mysql_fetch_assoc($searchResultsRecordset)); ?>

<b><a href="clear_screen.html">a</a>) </b><a href="clear_screen.html">Clear screen</a><br/>            
			<b><a href="index.php">b</a>) </b><a href="index.php">Back to home screen</a><br/>
            <?php 
			$next_page = $pageNum_searchResultsRecordset + 1;
			
			if (($totalRows_searchResultsRecordset) > ($next_page*10)){
          		echo "<b><a href=\"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/search.php?pageNum_searchResultsRecordset=".$next_page."&searchTextBox=".$colname_searchResultsRecordset."\">c</a>) </b><a href=\"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/search.php?pageNum_searchResultsRecordset=".$next_page."&searchTextBox=".$colname_searchResultsRecordset."\"><b>See 10 more results</b></a>";
				
          }else
		  echo "<br/>Those are all the results we have right now.<br/> <b>Search for another word</b> by typing it (or the first few letters) here<br/>
<form action=\"search.php\" method=\"get\" name=\"searchWordForm\">
<input name=\"searchTextBox\" type=\"text\" />
<input name=\"submitButton\" type=\"submit\"  />
</form>";
          ?>

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
