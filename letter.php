<?php	
	require_once("inc/config.php");
	require_once("inc/ShinkaBannerAd.php"); 
	require_once("inc/functions.php"); 

	if (isset($_GET['mxit_transaction_res'])&&($_GET['mxit_transaction_res']<>0)) 
	{
		header("Location: ".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."error.php?mxit_transaction_res=".$_GET['mxit_transaction_res'] );
	}
	
	//Pick one featured recordset
$maxRows_wordsRecordset = 10;
$pageNum_wordsRecordset = 0;
if (isset($_GET['pageNum_wordsRecordset'])) {
  $pageNum_wordsRecordset = $_GET['pageNum_wordsRecordset'];
}
$startRow_wordsRecordset = $pageNum_wordsRecordset * $maxRows_wordsRecordset;
$counter = $startRow_wordsRecordset+1;
$colname_wordsRecordset = "-1";
if (isset($_GET['letter'])) {
  $colname_wordsRecordset = $_GET['letter'];
}
mysql_select_db($database_mxit_urbandictionary, $mxit_urbandictionary);
$query_wordsRecordset = sprintf("SELECT word, definition FROM word WHERE word LIKE '%s%s' AND approved = 1 ORDER BY word ASC", GetSQLValueString($colname_wordsRecordset, "text"),
GetSQLValueString("%", "text"));
$query_limit_wordsRecordset = sprintf("%s LIMIT %d, %d", $query_wordsRecordset, $startRow_wordsRecordset, $maxRows_wordsRecordset);
$wordsRecordset = mysql_query($query_limit_wordsRecordset, $mxit_urbandictionary) or die(mysql_error());
$row_wordsRecordset = mysql_fetch_assoc($wordsRecordset);

if (isset($_GET['totalRows_wordsRecordset'])) {
  $totalRows_wordsRecordset = $_GET['totalRows_wordsRecordset'];
} else {
  $all_wordsRecordset = mysql_query($query_wordsRecordset);
  $totalRows_wordsRecordset = mysql_num_rows($all_wordsRecordset);
}
$totalPages_wordsRecordset = ceil($totalRows_wordsRecordset/$maxRows_wordsRecordset)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Urban Dictionary | Browse By Letter</title>
</head>

<body>
<h1>Urban Dictionary</h1>
<b>Browse by letter</b>
<br /><br />
  <?php do { ?>
  	<?php echo $counter.". ";
	$counter++?>
    <b><?php echo $row_wordsRecordset['word']; ?></b>,&nbsp;
      <?php echo $row_wordsRecordset['definition']; ?>
    <br/>
    <?php } while ($row_wordsRecordset = mysql_fetch_assoc($wordsRecordset)); ?>
    
    <b><a href="clear_screen.html">a</a>) </b><a href="clear_screen.html">Clear screen</a><br/>            
			<b><a href="index.php">b</a>) </b><a href="index.php">Home (Browse by letter)</a><br/>
            <?php 
			$next_page = $_GET['pageNum_wordsRecordset'] + 1;
			
			if ($totalPages_wordsRecordset >= ($next_page+1)){
          		echo "<b><a href=\"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/letter.php?pageNum_wordsRecordset=".$next_page."&letter=".$_GET['letter']."\">c</a>) </b><a href=\"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/letter.php?pageNum_wordsRecordset=".$next_page."&letter=".$_GET['letter']."\"><b>See 10 more definitions</b></a>";
				
          }else
		  echo "<br/><b>Those are all the definitions we have in this category.</b><br/> <b>Thank you!</b>";
          ?>
          <br /><br />
<b>Alternatively, </b><br />
You can type in the word (or the first few letters of the word) you wish to search for
<form action="search.php" method="get" name="searchWordForm">
<input name="searchTextBox" type="text" />
<input name="submitButton" type="submit"  />
</form>
<br />
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
			<br>
			<a href="mxit://[mxit_recommend]/Recommend?service_name=urbandictionary" type="mxit/service-navigation">Invite your friends to check this app out</a>
            </p>     	
</body>
</html>
<?php
mysql_free_result($wordsRecordset);
?>
