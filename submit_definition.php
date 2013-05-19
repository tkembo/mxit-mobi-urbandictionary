<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Urban Dictionary</title>
</head>

<body>
<h1>You're almost done</h1>
<strong> Now enter the definition of "<?php echo $_GET['word'];?>" </strong>
<p>You will be asked to submit the definition in the next screen </p>
<form id="form1" name="form1" method="post" action="submit.php">
  <input type="text" name="definition" id="word" />
  <input type="hidden" name="word" id="word" value="<?php echo $_GET['word'];?>" />
  <input type="submit" name="button" id="button" value="Submit" />
</form>
  	
</body>
</html>

