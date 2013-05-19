<?php	
	require_once("inc/config.php");
	require_once("inc/ShinkaBannerAd.php"); 
	require_once("inc/functions.php"); 
	
	$is_featured = 0;
	$approved = 0;

  $insertSQL = sprintf("INSERT INTO word (word, definition, is_featured, approved) VALUES ('%s', '%s', %s, %s)",
                       
                       GetSQLValueString($_POST['word'], "text"),
                       GetSQLValueString($_POST['definition'], "text"),
                       GetSQLValueString($is_featured, "int"),
                       GetSQLValueString($approved, "int"));
					   

mysql_select_db($database_mxit_urbandictionary, $mxit_urbandictionary);
//die($insertSQL);
  $Result1 = mysql_query($insertSQL, $mxit_urbandictionary) or die(mysql_error());

  $insertGoTo = "thank_you.php";
  header(sprintf("Location: %s", $insertGoTo));
?>
