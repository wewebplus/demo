<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="print-barcode.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
$mytxt = (empty($_POST["mytxt"])?'xx123456789':$_POST["mytxt"]);
?>
<div class="boxinput">
<form name="myBarcode" id="myBarcode" method="post" action="?">
	text <input type="text" name="mytxt" id="mytxt" value="<?php echo $mytxt?>" />
    <input type="submit" id="btsubmit" value="Gen" />
</form>
</div>
<p>Text: “<?php echo $mytxt?>”</p>
<p>Code Type: “Code128”</p>
<p><img alt="testing" height="60" src="php-barcode-master/barcode.php?size=40&text=<?php echo $mytxt?>" /></p>
</body>
</html>
