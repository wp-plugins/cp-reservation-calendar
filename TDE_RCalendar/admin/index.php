<?php
error_reporting(7);
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
session_start();

if ($_GET["logout"]=="true")
{
    $_SESSION["username"] = "";
    $_SESSION["password"] = "";
    echo "<script>document.location='index.php'</script>";
}

require "config.inc.php";
$fd = fopen ($filename, "r");
$contents = "";
$line = fgets ($fd);
$contents = @fread ($fd, filesize ($filename));
$contents = str_replace("\r","",$contents);
fclose ($fd);
$calendars = explode("\n*-*\n", $contents);
$name = '';
$user = '';
$pass = '';
for ($i=0;$i<count($calendars)-1;$i++)
{
      $calendardata = explode("\n", $calendars[$i]);
      if ($_GET["id"]==$calendardata[0])
      {
          $name = $calendardata[1];
          $user = $calendardata[2];
          $pass = $calendardata[3];
          $lang = $calendardata[4];
          if ($calendardata[5]=="partial")
              $mode = "true";
          else
              $mode = "false";    
      }
}   


$_SESSION["username"] = $_POST["username"];
$_SESSION["password"] = $_POST["password"];
  
if (($_POST["username"] == $user) && ($_POST["password"] == $pass))
{
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["password"] = $_POST["password"];
} 
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo (($name=="")?"Reservation Calendar":$name)?> Admin</title>
<style type="text/css">
<!--
body{
	margin : 0px 0px 0px 0px;
	font: 15px Arial, Helvetica, sans-serif;
	background-color : #787878;	
	color : #5C5C5C;
}
#container {
	text-align : center;
}

#div_body{
	width : 741px;
	
	min-height : 500px;
	height: auto !important;
	height:500px;
	
	background-color : #FFFFFF;
	clear : both;
	text-align : justify;
	margin : auto;
	padding: 16px;
}

#div_logo{
	width : 237px;
	height : 56px;
	background-image : url(../logo.gif);
	margin-bottom : 20px;
}

h1{
	font-size:15px;
	padding : 5px;
	
}
h3{
	font-size:15px;
	font-weight:normal;
}
a{
	color : #739E40;
	font-weight:normal;
	text-decoration:none;
}
-->
</style>
</head>

<body>
<div id="container">
	<div id="div_body">
	    <?php
        if ( (($user != "") && ($_POST["username"] == $user) && ($_POST["password"] == $pass)) || (($user != "") && ($_SESSION["username"] == $user) && ($_SESSION["password"] == $pass)))
        {
        ?> 
        <div style="float:right"><a href="?logout=true" class="action_anchor">log out</a></div>		<div id="div_logo"></div>
        <script language='JavaScript' type='text/javascript' src='../admin.js'></script>
        <input name="selDay<?php echo $_GET["id"]?>"   type="hidden" id="selDay<?php echo $_GET["id"]?>"  onChange="changeDate('<?php echo $_GET["id"]?>')">
        <input name="selMonth<?php echo $_GET["id"]?>"  type="hidden" id="selMonth<?php echo $_GET["id"]?>" onChange="changeDate('<?php echo $_GET["id"]?>')">
        <input name="selYear<?php echo $_GET["id"]?>"   type="hidden" id="selYear<?php echo $_GET["id"]?>" onChange="changeDate('<?php echo $_GET["id"]?>')">
        <div id="containerRCalendar<?php echo $_GET["id"]?>">
        </div>
        
        <script type="text/javascript">initCalendar("<?php echo $_GET["id"]?>","<?php echo $lang?>",true,<?php echo $mode?>);</script>
        <?php
        }
        else if (is_numeric($_GET["id"]))
        {
        ?>
        <div id="div_logo"></div>
        <form action="#" method="post" name="form1">
        <table width="170" border="0" cellspacing="5" cellpadding="5">
          <tr>
            <td>UserName:</td>
            <td><input type="text" name="username"></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input type="password" name="password"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Enter"></td>
          </tr>
        </table></form>
        <?php
        }
        else
        {    
		?>
		<div id="div_logo"></div>

		<h1>Reservation Calendar Admin</h1>
        <h3>Select the calendar to admin...</h3>
        <?php
        for ($i=0;$i<count($calendars)-1;$i++)
        {
              $calendardata = explode("\n", $calendars[$i]);
              echo '<a href="index.php?id='.$calendardata[0].'">'.$calendardata[1].'</a><br />';
        }   
        ?>
        <h3 style="font-size:11px;"><b>Advanced Administration:</b> <a href="admin.php">Click here to go to the Advanced Administration</a></h3>
		<?php
	    }
		?>
		<div class="end"></div>
	</div>
	<div id="div_footer">
		<a href="http://www.topdreamweaverextensions.com" target="_blank">www.topdreamweaverextensions.com All right reserved</a>
	</div>
</div>
</body>
</html>