<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

$current_user = wp_get_current_user();

global $wpdb;
$message = "";
if (isset($_GET['a']) && $_GET['a'] == '1')
{
    $sql .= 'INSERT INTO `'.DEX_RESERVATIONS_CONFIG_TABLE_NAME.'` (`'.TDE_RESERVATIONCONFIG_TITLE.'`,`'.TDE_RESERVATIONCONFIG_USER.'`,`'.TDE_RESERVATIONCONFIG_PASS.'`,`'.TDE_RESERVATIONCONFIG_LANG.'`,`'.TDE_RESERVATIONCONFIG_CPAGES.'`,`'.TDE_RESERVATIONCONFIG_MSG.'`,`'.TDE_RESERVATIONCALDELETED_FIELD.'`,calendar_mode) '.
            ' VALUES("","'.$_GET["name"].'","","ENG","1","Please, select your reservation.","0","true");';

    $wpdb->query($sql);   

    $results = $wpdb->get_results('SELECT `'.TDE_RESERVATIONCONFIG_ID.'` FROM `'.DEX_RESERVATIONS_CONFIG_TABLE_NAME.'` ORDER BY `'.TDE_RESERVATIONCONFIG_ID.'` DESC LIMIT 0,1');        
    $wpdb->query('UPDATE `'.DEX_RESERVATIONS_CONFIG_TABLE_NAME.'` SET `'.TDE_RESERVATIONCONFIG_TITLE.'`="cal'.$results[0]->id.'" WHERE `'.TDE_RESERVATIONCONFIG_ID.'`='.$results[0]->id);           
    $message = "Item added";
} 
else if (isset($_GET['u']) && $_GET['u'] != '')
{
    $wpdb->query('UPDATE `'.DEX_RESERVATIONS_CONFIG_TABLE_NAME.'` SET conwer='.$_GET["owner"].',`'.TDE_RESERVATIONCALDELETED_FIELD.'`='.$_GET["public"].',`'.TDE_RESERVATIONCONFIG_USER.'`="'.$_GET["name"].'" WHERE `'.TDE_RESERVATIONCONFIG_ID.'`='.intval($_GET['u']));           
    $message = "Item updated";        
}
else if (isset($_GET['d']) && $_GET['d'] != '')
{
    $wpdb->query('DELETE FROM `'.DEX_RESERVATIONS_CONFIG_TABLE_NAME.'` WHERE `'.TDE_RESERVATIONCONFIG_ID.'`='.$_GET['d']);       
    $message = "Item deleted";
}


if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>
<div class="wrap">
<h1>CP Reservation Calendar</h1>




<script type="text/javascript">
 function cp_addItem()
 {
    var calname = document.getElementById("cp_itemname").value;
    document.location = 'admin.php?page=dex_reservations&a=1&r='+Math.random()+'&name='+encodeURIComponent(calname);       
 }
 
 function cp_updateItem(id)
 {
    var calname = document.getElementById("calname_"+id).value;
    var owner = document.getElementById("calowner_"+id).options[document.getElementById("calowner_"+id).options.selectedIndex].value;    
    if (owner == '')
        owner = 0;
    var is_public = (document.getElementById("calpublic_"+id).checked?"0":"1");
    document.location = 'admin.php?page=dex_reservations&u='+id+'&r='+Math.random()+'&public='+is_public+'&owner='+owner+'&name='+encodeURIComponent(calname);    
 }
 
 function cp_manageSettings(id)
 {
    document.location = 'admin.php?page=dex_reservations&cal='+id+'&r='+Math.random();
 }
 
 function cp_BookingsList(id)
 {
    document.location = 'admin.php?page=dex_reservations&cal='+id+'&list=1&r='+Math.random();
 }
 
 function cp_deleteItem(id)
 {
    if (confirm('Are you sure that you want to delete this item?'))
    {        
        document.location = 'admin.php?page=dex_reservations&d='+id+'&r='+Math.random();
    }
 }
 
</script>


<div id="normal-sortables" class="meta-box-sortables">


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar List / Items List</span></h3>
  <div class="inside">
  
  
  <table cellspacing="1"> 
   <tr>
    <th align="left">ID</th><th align="left">Calendar Name</th><th align="left">Owner</th><th align="left">Public</th><th align="left">&nbsp; &nbsp; Options</th>
   </tr> 
<?php  

  $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." ORDER BY ID DESC" );                                                                     

  $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_RESERVATIONS_CONFIG_TABLE_NAME );                                                                     
  foreach ($myrows as $item)   
      if (cp_reservation_is_administrator() || ($current_user->ID == $item->conwer))
      {
?>
   <tr> 
    <td nowrap><?php echo $item->id; ?></td>
    <td nowrap><input type="text" style="width:100px;" <?php if (!cp_reservation_is_administrator()) echo ' readonly '; ?>name="calname_<?php echo $item->id; ?>" id="calname_<?php echo $item->id; ?>" value="<?php echo esc_attr($item->uname); ?>" /></td>
    
    <?php if (cp_reservation_is_administrator()) { ?>
    <td nowrap>
      <select name="calowner_<?php echo $item->id; ?>" id="calowner_<?php echo $item->id; ?>">
       <option value="0"<?php if (!$item->conwer) echo ' selected'; ?>></option>
       <?php foreach ($users as $user) { 
       ?>
          <option value="<?php echo $user->ID; ?>"<?php if ($user->ID."" == $item->conwer) echo ' selected'; ?>><?php echo $user->user_login; ?></option>
       <?php  } ?>
      </select>
    </td>    
    <?php } else { ?>
        <td nowrap>
        <?php echo $current_user->user_login; ?>
        </td>
    <?php } ?>
    
    <td nowrap align="center">
       <?php if (cp_reservation_is_administrator()) { ?> 
         &nbsp; &nbsp; <input type="checkbox" name="calpublic_<?php echo $item->id; ?>" id="calpublic_<?php echo $item->id; ?>" value="1" <?php if (!$item->caldeleted) echo " checked "; ?> />
       <?php } else { ?>  
         <?php if (!$item->caldeleted) echo "Yes"; else echo "No"; ?> 
       <?php } ?>   
    </td>    
    <td nowrap>&nbsp; &nbsp; 
                             <?php if (cp_reservation_is_administrator()) { ?> 
                               <input type="button" name="calupdate_<?php echo $item->id; ?>" value="Update" onclick="cp_updateItem(<?php echo $item->id; ?>);" /> &nbsp; 
                             <?php } ?>    
                             <input type="button" name="calmanage_<?php echo $item->id; ?>" value="Settings " onclick="cp_manageSettings(<?php echo $item->id; ?>);" /> &nbsp;                              
                          
    </td>
   </tr>
<?php  
      } 
?>   
     
  </table> 
    
<br /><br />
<div style="border:1px solid #664444;background-color:#FDFDC8;width:90%;padding-left:10px;padding-right:10px;font-size:12px;">
    <p><strong>Upgrade notice:</strong><br /><br />
        This plugin is the <strong>free version of the CP Reservation Calendar</strong>. If you already have the pro version please use your personal download link to update it to the latest pro version.<br />
        <br /><strong>Important note:</strong> There is a more advanced plugin named <strong><a href="http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form?cpapp=up#download">Booking Calendar Contact Form</a></strong> developed based in this one that contains all the features present in this plugin plus a large additional set of features in both free and commercial versions, including (also in <strong>free version</strong>):
    <br >
    <br >&nbsp; - Season prices management
    <br >&nbsp; - Supports bookings of a fixed length, example weekly bookings
    <br >&nbsp; - Price structure can be defined for each number of days
    <br >&nbsp; - Calendar configurable settings: date format, min/max dates, block dates, mark holidays, select working weekdays, calendar pages
    <br >&nbsp; - Better jQuery based calendar
    <br >&nbsp; - Language & translations support
    <br >&nbsp; - Printable list of bookings
    <br >&nbsp; - Many additional configuiration settings
    <br >&nbsp; - ... and a lot more of features
<br /><br />

 To see the plugin details go to the <strong><a href="http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form?cpapp=up#download">Booking Calendar Contact Form</a></strong> page.</p>
</div>    
    
   
  </div>    
 </div> 
 
  
</div> 


[<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/cp-reservation-calendar" target="_blank">Help</a>]
</form>
</div>














