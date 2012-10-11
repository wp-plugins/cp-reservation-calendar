<?php
$_PASSWORD = "PASSWORD HERE!!";  


error_reporting(7);
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
session_start();

if ($_GET["logout"]=="true")
{
    $_SESSION["passwordAdmin"] = "";
    echo "<script>document.location='admin.php'</script>";
}
  
if ($_POST["passAdmin"] == $_PASSWORD)
{
    $_SESSION["passwordAdmin"] = $_POST["passAdmin"];
}

require "config.inc.php";
$headerLine = "<?php exit(); ?>\n";
$fd = fopen ($filename, "r");
$contents = "";
$line = fgets ($fd);
$contents = @fread ($fd, filesize ($filename));
$contents = str_replace("\r","",$contents);
fclose ($fd);
  
if (isset($_POST["newcal"]) && $_POST["newcal"]!="")
{
	$i = 1;
    while (file_exists("database/eventsRCalendar".$i.".txt"))
    {
        $i++;	
    }    
    $fd = fopen ("database/eventsRCalendar".$i.".txt", "w");
    fclose ($fd);
    $fd = fopen ($filename, "w");
    $contents = $headerLine.$contents;
    fwrite ($fd, $contents.$i."\n".$_POST["newcal"]."\n".$_POST["newuser"]."\n".$_POST["newpass"]."\n".$_POST["newlang"]."\n".$_POST["newmode"]."\n".$_POST["newmsg1"]."\n".$_POST["newmsg2"]."\n".$_POST["newmsg3"]."\n".$_POST["newmsg4"]."\n*-*\n");
    fclose ($fd);
    
    echo '<script>document.location="admin.php";</script>';
}
if (isset($_GET["action"]) && $_GET["action"]=="del" && isset($_GET["id"]))
{
	if (file_exists("database/eventsRCalendar".$_GET["id"].".txt")) 
	{
		unlink("database/eventsRCalendar".$_GET["id"].".txt");
	}   
    $calendars = explode("\n*-*\n", $contents);
    $string = "";
    for ($i=0;$i<count($calendars)-1;$i++)
    {
        $calendardata = explode("\n", $calendars[$i]);
        if ($calendardata[0]!=$_GET["id"])
            $string .= $calendars[$i]."\n*-*\n";
    }
    $fd = fopen ($filename, "w");
    fwrite ($fd, $headerLine.$string);
    fclose ($fd); 
    echo '<script>document.location="admin.php";</script>'; 
}
if (isset($_POST["edit"]) && $_POST["id"]!="")
{
	$calendars = explode("\n*-*\n", $contents);
    $string = "";
	for ($i=0;$i<count($calendars)-1;$i++)
    {
        $calendardata = explode("\n", $calendars[$i]);
        if ($calendardata[0]==$_POST["id"])
            $string .= $_POST["id"]."\n".$_POST["cal"]."\n".$_POST["user"]."\n".$_POST["pass"]."\n".$_POST["lang"]."\n".$_POST["mode"]."\n".$_POST["msg1"]."\n".$_POST["msg2"]."\n".$_POST["msg3"]."\n".$_POST["msg4"]."\n*-*\n";
        else    
            $string .= $calendars[$i]."\n*-*\n";
    }
    $fd = fopen ($filename, "w");
    fwrite ($fd, $headerLine.$string);
    fclose ($fd);
    echo '<script>document.location="admin.php";</script>';
}

$calendars = explode("\n*-*\n", $contents);
for ($i=0;$i<count($calendars)-1;$i++)
{
      $calendardata = explode("\n", $calendars[$i]);
      $cal[$i] = array ("id"=> $calendardata[0], "name"=> $calendardata[1], "user"=> $calendardata[2], "pass"=> $calendardata[3], "lang"=> $calendardata[4], "mode"=> $calendardata[5], "msg1"=> $calendardata[6], "msg2"=> $calendardata[7], "msg3"=> $calendardata[8], "msg4"=> $calendardata[9]);
}      
      

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reservation Calendar Admin</title>
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
#tablelist 
{
	border-right:1px solid #cccccc;
	border-bottom:1px solid #cccccc;
	color:#000000;
	font-size:11px;
}
#tablelist  a
{
	text-decoration:underline;
}
#tablelist td
{
	border-top:1px solid #cccccc;
	border-left:1px solid #cccccc;
	padding:2px;
}
#tablelist td table td
{
	border:0px;
}
.fixedwidth
{
	width:120px;
}
-->
</style>
<script>
function _delete(id)
{
	if (confirm('Are you sure delete it?'))
	    document.location = 'admin.php?action=del&id='+id;
}
function _rename(id)
{
	_cancel();
	document.getElementById("text"+id).style.display="none";
	document.getElementById("text_rename"+id).style.display="";
}
function _cancel()
{
	<?php
	for ($i=0;$i<count($cal);$i++)
	{
		echo 'document.getElementById("text'.$cal[$i]["id"].'").style.display="";';
		echo 'document.getElementById("text_rename'.$cal[$i]["id"].'").style.display="none";';
	}
	?>
}


function _import(id)
{
	document.location = 'admin.php?action=del&id='+id;
}
function _admin(id)
{
	document.location = 'index.php?id='+id;
}
function validate()
{
	if (document.getElementById("newcal").value == "")
	    alert('Calendar Name is required');
	else if (document.getElementById("newuser").value == "")
	    alert('User Name is required'); 
	else if (document.getElementById("newpass").value == "")
	    alert('Password is required'); 
	else 
	    return true;
	return false;    
}
function validate2(id)
{
	if (document.getElementById("cal"+id).value == "")
	    alert('Calendar Name is required');
	else if (document.getElementById("user"+id).value == "")
	    alert('User Name is required'); 
	else if (document.getElementById("pass"+id).value == "")
	    alert('Password is required'); 
	else 
	    return true;
	return false;    
}
</script>
</head>

<body>
<div id="container">
	<div id="div_body">
		

		
		
<?php
if (($_POST["passAdmin"] == $_PASSWORD && $_PASSWORD!="PASSWORD HERE!!") || ($_SESSION["passwordAdmin"] == $_PASSWORD && $_PASSWORD!="PASSWORD HERE!!"))
{
?>		
	<div style="float:right"><a href="?logout=true" class="action_anchor">log out</a></div><div id="div_logo"></div>	
	   
    <form name="newform" action="#" method="post" onsubmit="return validate();">		
    <fieldset style="margin-bottom:10px;"><legend><b>Add New Calendar</b></legend>
    <table>
        <tr>
            <td>Calendar Name<br /><input type="text" name="newcal" id="newcal" class="fixedwidth"></td>
            <td>User Name<br /><input type="text" name="newuser" id="newuser" class="fixedwidth"></td>
            <td>Password<br /><input type="text" name="newpass" id="newpass" class="fixedwidth"></td>
            <td>Language<br /><select name="newlang" class="fixedwidth"><option value="ENG" selected>English</option>
                <option value="SP">Spanish</option>
                <option value="FR">French</option>
                <option value="IT">Italian</option>
                <option value="DE">German</option>
                <option value="JP">Japanese</option>
                <option value="PT">Portuguese</option>
                <option value="DU">Dutch</option>
              </select></td>
            <td>Mode<br /><select name="newmode" class="fixedwidth"><option value="total" selected>Complete Day</option>
                <option value="partial">Partial Day</option>
              </select></td>
        </tr>
        <tr>
            <td>Messages<br /><input type="text" name="newmsg1" id="newmsg1" class="fixedwidth" value="Select Start Date"></td>
            <td>&nbsp;<br /><input type="text" name="newmsg2" id="newmsg2" class="fixedwidth" value="Select End Date"></td>
            <td>&nbsp;<br /><input type="text" name="newmsg3" id="newmsg3" class="fixedwidth" value="Cancel Selection"></td>
            <td>&nbsp;<br /><input type="text" name="newmsg4" id="newmsg4" class="fixedwidth" value="Successfully"></td>
            <td>&nbsp;<br /><input type="submit" name="send" value="Add"></td>
        </tr>
    </table>
    </fieldset>
    </form>
    
    <?php
    if (count($cal)>0)
    {
        echo '<table width="100%" cellpadding="0" cellspacing="0" id="tablelist">';
        echo '<tr style="background-color:#787878;color:#ffffff;font-weight:bold;"><td colspan="2">Calendars</td></tr>';
    }    
    for ($i=0;$i<count($cal);$i++)
    {
    	echo '<tr style="background-color:#d8d8d8"><td>'.$cal[$i]["name"].'</td><td align="right"><a href="javascript:_admin(\''.$cal[$i]["id"].'\')">ADMIN</a>&nbsp; &nbsp;<a href="export-csv.php?id='.$cal[$i]["id"].'&type=0&name='.$cal[$i]["name"].'">EXPORT TO CSV</a>&nbsp; &nbsp;<!--<a href="javascript:_import(\''.$cal[$i]["id"].'\')">IMPORT FROM CSV</a>&nbsp; &nbsp;--><a href="javascript:_rename(\''.$cal[$i]["id"].'\')">EDIT</a>&nbsp; &nbsp;<a href="javascript:_delete(\''.$cal[$i]["id"].'\')">DELETE</a></td></tr>';
    	echo '<tr id="text'.$cal[$i]["id"].'"><td colspan="2" >Code inside head tag  <span style="color:#888888"> (click to select)</span>';
    	echo '<br /><input name="paypallink" value="&lt;script type=&quot;text/javascript&quot; src=&quot;TDE_RCalendar/public.js&quot;&gt;&lt;/script&gt;" style="border: 1px dotted #cccccc; width: 99%; color: rgb(221, 0, 0); font-size: 10px; font-family: verdana;" onclick="this.focus(); this.select();" type="text">';
    	echo '<br />Code in the place where you want to show the calendar<span style="color:#888888"> (click to select)</span>';
    	echo '<br /><textarea  name="paypallink" style="margin-bottom:10px;height:135px;border: 1px dotted #cccccc; width: 99%; color: rgb(221, 0, 0); font-size: 10px; font-family: verdana;" onclick="this.focus(); this.select();" >
&lt;input name=&quot;selDay_start'.$cal[$i]["id"].'&quot; type=&quot;hidden&quot; id=&quot;selDay_start'.$cal[$i]["id"].'&quot; onChange=&quot;changeDate(\''.$cal[$i]["id"].'\')&quot; /&gt;
&lt;input name=&quot;selMonth_start'.$cal[$i]["id"].'&quot; type=&quot;hidden&quot; id=&quot;selMonth_start'.$cal[$i]["id"].'&quot; onChange=&quot;changeDate(\''.$cal[$i]["id"].'\')&quot; /&gt;
&lt;input name=&quot;selYear_start'.$cal[$i]["id"].'&quot; type=&quot;hidden&quot; id=&quot;selYear_start'.$cal[$i]["id"].'&quot; onChange=&quot;changeDate(\''.$cal[$i]["id"].'\')&quot; /&gt;
&lt;input name=&quot;selDay_end'.$cal[$i]["id"].'&quot; type=&quot;hidden&quot; id=&quot;selDay_end'.$cal[$i]["id"].'&quot; onChange=&quot;changeDate(\''.$cal[$i]["id"].'\')&quot; /&gt;
&lt;input name=&quot;selMonth_end'.$cal[$i]["id"].'&quot; type=&quot;hidden&quot; id=&quot;selMonth_end'.$cal[$i]["id"].'&quot; onChange=&quot;changeDate(\''.$cal[$i]["id"].'\')&quot; /&gt;
&lt;input name=&quot;selYear_end'.$cal[$i]["id"].'&quot; type=&quot;hidden&quot; id=&quot;selYear_end'.$cal[$i]["id"].'&quot; onChange=&quot;changeDate(\''.$cal[$i]["id"].'\')&quot; /&gt;
&lt;div style=&quot;z-index:'.$cal[$i]["id"].'000;&quot;&gt;
    &lt;div id=&quot;containerRCalendar'.$cal[$i]["id"].'&quot;&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;script type=&quot;text/javascript&quot;&gt;initCalendar(\''.$cal[$i]["id"].'\',\''.$cal[$i]["lang"].'\',false,'.(($cal[$i]["mode"]=="partial")?"true":"false").',\''.$cal[$i]["msg1"].'\',\''.$cal[$i]["msg2"].'\',\''.$cal[$i]["msg3"].'\',\''.$cal[$i]["msg4"].'\');&lt;/script&gt;</textarea>'; 
    	echo '</td></tr>';
    	
    	echo '<tr id="text_rename'.$cal[$i]["id"].'" style="display:none"><td colspan="2" ><form name="newform'.$cal[$i]["id"].'" action="#" method="post"  onsubmit="return validate2(\''.$cal[$i]["id"].'\');">		
    <b>Edit Calendar</b>
    <table>
        <tr>
            <td>Calendar Name<br /><input type="text" name="cal" id="cal'.$cal[$i]["id"].'" value="'.$cal[$i]["name"].'" class="fixedwidth"></td>
            <td>User Name<br /><input type="text" name="user" id="user'.$cal[$i]["id"].'" value="'.$cal[$i]["user"].'" class="fixedwidth"></td>
            <td>Password<br /><input type="text" name="pass" id="pass'.$cal[$i]["id"].'" value="'.$cal[$i]["pass"].'" class="fixedwidth"></td>
            <td>Language<br /><select name="lang" id="lang'.$cal[$i]["id"].'" class="fixedwidth">
                <option value="ENG" '.(($cal[$i]["lang"]!="SP" && $cal[$i]["lang"]!="FR" && $cal[$i]["lang"]!="IT" && $cal[$i]["lang"]!="DE" && $cal[$i]["lang"]!="JP" && $cal[$i]["lang"]!="PT" && $cal[$i]["lang"]!="DU")?"selected":"").'>English</option>
                <option value="SP" '.(($cal[$i]["lang"]=="SP")?"selected":"").'>Spanish</option>
                <option value="FR" '.(($cal[$i]["lang"]=="FR")?"selected":"").'>French</option>
                <option value="IT" '.(($cal[$i]["lang"]=="IT")?"selected":"").'>Italian</option>
                <option value="DE" '.(($cal[$i]["lang"]=="DE")?"selected":"").'>German</option>
                <option value="JP" '.(($cal[$i]["lang"]=="JP")?"selected":"").'>Japanese</option>
                <option value="PT" '.(($cal[$i]["lang"]=="PT")?"selected":"").'>Portuguese</option>
                <option value="DU" '.(($cal[$i]["lang"]=="DU")?"selected":"").'>Dutch</option>
              </select></td>
            <td>Mode<br /><select name="mode" id="mode'.$cal[$i]["id"].'" class="fixedwidth">
                <option value="total" '.(($cal[$i]["mode"]!="partial")?"selected":"").'>Complete Day</option>
                <option value="partial" '.(($cal[$i]["mode"]=="partial")?"selected":"").'>Partial Day</option>
              </select></td>
        </tr>
        <tr>
            <td>Messages<br /><input type="text" name="msg1" id="msg1'.$cal[$i]["id"].'" class="fixedwidth" value="'.$cal[$i]["msg1"].'"></td>
            <td>&nbsp;<br /><input type="text" name="msg2" id="msg2'.$cal[$i]["id"].'" class="fixedwidth" value="'.$cal[$i]["msg2"].'"></td>
            <td>&nbsp;<br /><input type="text" name="msg3" id="msg3'.$cal[$i]["id"].'" class="fixedwidth" value="'.$cal[$i]["msg3"].'"></td>
            <td>&nbsp;<br /><input type="text" name="msg4" id="msg4'.$cal[$i]["id"].'" class="fixedwidth" value="'.$cal[$i]["msg4"].'"></td>      
            <td>&nbsp;<br /><input type="submit" name="edit" value="Save"><input type="button" name="send" onclick="javascript:_cancel()" value="Cancel"><input type="hidden" name="id" value="'.$cal[$i]["id"].'"></td>
        </tr>
    </table>
    </form>';
    	echo '</td></tr>';
    }
    if (count($cal)>0)
        echo '</table>';
    ?>
<?php
}
else
{
?>
       <div id="div_logo"></div>
       
<h1>Advanced Administration (optional)</h1>
<div style="float:left; padding-left: 15px; width:300px;text-align:left;margin-right:20px;">       
       <form action="#" method="post" name="form1">
        <b>Password: </b><br />
        <input type="password" name="passAdmin" ><br />
        <input type="submit" name="Submit" value="Enter">
       </form>
<p style="font-size:11px;">If you <strong>don't know the password</strong> to access this page or if this is the <strong>first time that you try to access</strong> 
it then you can check/modify the password into the file <em>"admin/admin.php"</em> in the first line of code.</p>        
</div>      
  
<div style="float:left; font-size:11px;width:370px;text-align:left;border:1px solid #aaaaaa;background-color:#ffffcc;padding: 5px">       
This is an <strong>optional</strong> administration page that you can use for:
<ul>
<li>Adding New calendars (optional alternative for the same feature available from Dreamweaver).</li>
<li>Get the code required to show a calendar in a web page (optional alternative for the same feature available from Dreamweaver).</li>
<li>Edit the calendar's name and access information.</li>
<li>Delete the calendars.</li>
<li>Export the calendar data in CSV (Excel) format.</li>
</ul>

</div>
<div style="clear:both;"></div>
<br />
        <h3 style="font-size:11px;"><b>Calendars List:</b> <a href="index.php">Click here to return to the calendars administration</a></h3>
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