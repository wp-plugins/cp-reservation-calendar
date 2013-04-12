<?php

if ( !defined('DEX_AUTH_INCLUDE') )
{
    echo 'Direct access not allowed.';
    exit;
}

global $wpdb;
if (defined('DEX_CALENDAR_USER') && DEX_CALENDAR_USER != 0)
    $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_RESERVATIONS_CONFIG_TABLE_NAME." WHERE conwer=".DEX_CALENDAR_USER." AND caldeleted=0" );
else if (defined('DEX_CALENDAR_FIXED_ID'))
    $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_RESERVATIONS_CONFIG_TABLE_NAME." WHERE id=".DEX_CALENDAR_FIXED_ID." AND caldeleted=0" );
else
    $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_RESERVATIONS_CONFIG_TABLE_NAME." WHERE caldeleted=0" );

define ('CP_CALENDAR_ID',1);

?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('TDE_RCalendar/all-css.css', __FILE__); ?>" />
<script>
var pathCalendar = "<?php echo cp_reservation_get_site_url(); ?>";
var pathCalendar_full = pathCalendar + "/wp-content/plugins/<?php echo basename(dirname(__FILE__));?>/TDE_RCalendar";
var minDateConfigTDE = "<?php $value = dex_reservations_get_option('calendar_mindate', DEX_RESERVATIONS_DEFAULT_CALENDAR_MINDATE); if ($value != '') echo date("n/j/Y", strtotime($value)); ?>";  //month/day/year like this "10/5/2008" or "now" for current date
var maxDateConfigTDE = "<?php $value = dex_reservations_get_option('calendar_maxdate', DEX_RESERVATIONS_DEFAULT_CALENDAR_MAXDATE); if ($value != '') echo date("n/j/Y",strtotime($value)); ?>";  //month/day/year like this "10/5/2008" or "now" for current date
var dex_global_date_format = '<?php echo dex_reservations_get_option('calendar_dateformat', DEX_RESERVATIONS_DEFAULT_CALENDAR_DATEFORMAT); ?>';
var dex_global_start_weekday = '<?php echo dex_reservations_get_option('calendar_weekday', DEX_RESERVATIONS_DEFAULT_CALENDAR_WEEKDAY); ?>';
</script>
<script type="text/javascript" src="<?php echo plugins_url('TDE_RCalendar/all-scripts.js', __FILE__); ?>"></script>
<form class="cpp_form" name="FormEdit" action="<?php get_site_url(); ?>" method="post" onsubmit="return doValidate(this);">
 <input name="dex_reservations_post" type="hidden" id="1" />
<?php if (count($myrows) < 2) { ?>
  <div style="display:none">
<?php } else {?>
<?php
  echo __("Calendar").":";
?>
  <div>
<?php } ?>
<br />
<select name="dex_item" id="dex_item" onchange="dex_updateItem()">
<?php
  foreach ($myrows as $item)
      echo '<option value='.$item->id.'>'.$item->uname.'</option>';
?>
</select>

<br /><br />
</div>
<?php
  echo __("Select start and end dates").":";
?>
<?php foreach ($myrows as $item) {  ?>
    <div id="calarea_<?php echo $item->id; ?>" style="display:none">
     <input name="selDay_start<?php echo $item->id; ?>" type="hidden" id="selDay_start<?php echo $item->id; ?>" /><input name="selMonth_start<?php echo $item->id; ?>" type="hidden" id="selMonth_start<?php echo $item->id; ?>" /><input name="selYear_start<?php echo $item->id; ?>" type="hidden" id="selYear_start<?php echo $item->id; ?>" /><input name="selDay_end<?php echo $item->id; ?>" type="hidden" id="selDay_end<?php echo $item->id; ?>" /><input name="selMonth_end<?php echo $item->id; ?>" type="hidden" id="selMonth_end<?php echo $item->id; ?>" /><input name="selYear_end<?php echo $item->id; ?>" type="hidden" id="selYear_end<?php echo $item->id; ?>" />
     <div style="z-index:1000;">
       <div id="containerRCalendar<?php echo $item->id; ?>"></div>
     </div>
     <div style="clear:both;"></div>
    </div>
<?php } ?>
<div id="selddiv" style="font-weight: bold;margin-top:5px;padding:3px;"></div>
<script type="text/javascript">
 var dex_current_calendar_item;
 function dex_updateItem()
 {
    document.getElementById("calarea_"+dex_current_calendar_item).style.display = "none";
    var i = document.FormEdit.dex_item.options.selectedIndex;
    var selecteditem = document.FormEdit.dex_item.options[i].value;
    dex_do_init(selecteditem);
 }
 function dex_do_init(id)
 {
    dex_current_calendar_item = id;
    document.getElementById("calarea_"+dex_current_calendar_item).style.display = "";
    initCalendar('1','<?php echo dex_reservations_get_option('calendar_language', DEX_RESERVATIONS_DEFAULT_CALENDAR_LANGUAGE); ?>',false,<?php echo dex_reservations_get_option('calendar_mode',DEX_RESERVATIONS_DEFAULT_CALENDAR_MODE); ?>,'<?php _e('Select Start Date'); ?>','<?php _e('Select End Date'); ?>','<?php _e('Cancel Selection'); ?>','<?php _e('Successfully'); ?>');
    document.getElementById("selddiv").innerHTML = "";
 }
 dex_do_init(<?php echo $myrows[0]->id; ?>);
 function doValidate(form)
 {
    if (form.phone.value == '')
    {
        alert('<?php _e('Please enter a valid phone number'); ?>.');
        return false;
    }
    if (form.email.value == '')
    {
        alert('<?php _e('Please enter a valid email address'); ?>.');
        return false;
    }
    if (form.name.value == '')
    {
        alert('<?php _e('Please write your name'); ?>.');
        return false;
    }
    if (document.getElementById("selDay_start"+dex_current_calendar_item).value == '' || document.getElementById("selDay_end"+dex_current_calendar_item).value == '')
    {
        alert('<?php _e('Please select start and end dates'); ?>.');
        return false;
    }
    return true;
 }
</script>


<br />


<?php _e('Your phone number'); _e("(starting with '+ country code')");?>:<br />
<input type="text" name="phone" value=""><br />

<?php _e('Your name'); ?>:<br />
<input type="text" name="name" value=""><br />

<?php _e('Your email'); ?>:<br />
<input type="text" name="email" value=""><br />

<?php _e('Comments/Questions'); ?>:<br />
<textarea name="question" style="width:100%"></textarea><br />

<input type="submit" name="subbtn" value="<?php _e("Continue"); ?>">
</form>


