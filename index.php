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

mysql_select_db($database_mxit_urbandictionary, $mxit_urbandictionary);
$query_featuredWordsRecordset = "SELECT * FROM word WHERE is_featured = 1 AND approved = 1 ORDER BY RAND()";
$query_limit_featuredWordsRecordset = sprintf("%s LIMIT %d, %d", $query_featuredWordsRecordset, $startRow_featuredWordsRecordset, $maxRows_featuredWordsRecordset);
$featuredWordsRecordset = mysql_query($query_limit_featuredWordsRecordset, $mxit_urbandictionary) or die(mysql_error());
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
<b>Browse by Number</b>
<br />
<a href="letter.php?letter=1&pageNum_wordsRecordset=0">1</a>&nbsp;
<a href="letter.php?letter=2&pageNum_wordsRecordset=0">2</a>&nbsp;
<a href="letter.php?letter=4&pageNum_wordsRecordset=0">4</a>&nbsp;

<br /><br />
<b>Browse by Letter</b>
<br />
<a href="letter.php?letter=a&pageNum_wordsRecordset=0">A</a>&nbsp;
<a href="letter.php?letter=b&pageNum_wordsRecordset=0">B</a>&nbsp;
<a href="letter.php?letter=c&pageNum_wordsRecordset=0">C</a>&nbsp;
<a href="letter.php?letter=d&pageNum_wordsRecordset=0">D</a>&nbsp;
<a href="letter.php?letter=e&pageNum_wordsRecordset=0">E</a>&nbsp;
<a href="letter.php?letter=f&pageNum_wordsRecordset=0">F</a>&nbsp;
<a href="letter.php?letter=g&pageNum_wordsRecordset=0">G</a>&nbsp;
<a href="letter.php?letter=h&pageNum_wordsRecordset=0">H</a>&nbsp;
<a href="letter.php?letter=i&pageNum_wordsRecordset=0">I</a>&nbsp;
<a href="letter.php?letter=j&pageNum_wordsRecordset=0">J</a>&nbsp;
<a href="letter.php?letter=k&pageNum_wordsRecordset=0">K</a>&nbsp;
<a href="letter.php?letter=l&pageNum_wordsRecordset=0">L</a>&nbsp;
<a href="letter.php?letter=m&pageNum_wordsRecordset=0">M</a>&nbsp;
<a href="letter.php?letter=n&pageNum_wordsRecordset=0">N</a>&nbsp;
<a href="letter.php?letter=o&pageNum_wordsRecordset=0">O</a>&nbsp;
<a href="letter.php?letter=p&pageNum_wordsRecordset=0">P</a>&nbsp;
<a href="letter.php?letter=q&pageNum_wordsRecordset=0">Q</a>&nbsp;
<a href="letter.php?letter=r&pageNum_wordsRecordset=0">R</a>&nbsp;
<a href="letter.php?letter=s&pageNum_wordsRecordset=0">S</a>&nbsp;
<a href="letter.php?letter=t&pageNum_wordsRecordset=0">T</a>&nbsp;
<a href="letter.php?letter=u&pageNum_wordsRecordset=0">U</a>&nbsp;
<a href="letter.php?letter=v&pageNum_wordsRecordset=0">V</a>&nbsp;
<a href="letter.php?letter=w&pageNum_wordsRecordset=0">W</a>&nbsp;
<a href="letter.php?letter=x&pageNum_wordsRecordset=0">X</a>&nbsp;
<a href="letter.php?letter=y&pageNum_wordsRecordset=0">Y</a>&nbsp;
<a href="letter.php?letter=z&pageNum_wordsRecordset=0">Z</a>
<br />
<br />
<b>Alternatively, </b>
<br />
You can type in the word (or the first few letters of the word) you wish to search for
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
			$ShinkaBannerAd->doServerAdRequest('text');
			print $ShinkaBannerAd->generateHTMLFromAd();
		?>  

<br>
        <p>
        	<strong><a href="feedback.php">f1</a>) <a href="feedback.php">Feedback/Help/About/More Info</a></strong>
            <br />
            <strong><a href="feedback.php">f2</a>) <a href="submit_word.php">Submit your own word</a>
            </p>     	
</body>
</html>
<?php
mysql_free_result($featuredWordsRecordset);
?>
