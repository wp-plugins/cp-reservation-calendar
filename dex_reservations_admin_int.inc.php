<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

if (!defined('CP_CALENDAR_ID'))
    define ('CP_CALENDAR_ID',1);

global $wpdb; 
$mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.DEX_RESERVATIONS_CONFIG_TABLE_NAME .' WHERE `'.TDE_RESERVATIONCONFIG_ID.'`='.CP_CALENDAR_ID); 


if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['dex_reservations_post_options'] ) )
    echo "<div id='setting-error-settings_updated' class='updated settings-error'> <p><strong>Settings saved.</strong></p></div>";

$current_user = wp_get_current_user();

if (cp_reservation_is_administrator() || $mycalendarrows[0]->conwer == $current_user->ID) { 

?>
<div class="wrap">
<h2>CP Reservation Calendar - Manage Calendar Availability</h2>

<input type="button" name="backbtn" value="Back to items list..." onclick="document.location='admin.php?page=dex_reservations';">

<form method="post" name="dexconfigofrm" action=""> 
<input name="dex_reservations_post_options" type="hidden" id="1" />
<input name="dex_item" type="hidden" value="<?php echo intval($_GET["cal"]); ?>" />
   
<div id="normal-sortables" class="meta-box-sortables">

 <hr />
 <h3>These calendar settings applies only to: <?php echo $mycalendarrows[0]->uname; ?></h3>

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar Configuration / Administration</span></h3>
  <div class="inside">
  
   <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('TDE_RCalendar/all-css-admin.css', __FILE__); ?>" />
   <script>
   var pathCalendar = "<?php echo cp_reservation_get_site_url(); ?>";
   var pathCalendar_full = pathCalendar + "/wp-content/plugins/<?php echo basename(dirname(__FILE__));?>/TDE_RCalendar";
   var minDateConfigTDE = "";  //month/day/year like this "10/5/2008" or "now" for current date
   var maxDateConfigTDE = "";  //month/day/year like this "10/5/2008" or "now" for current date
   var dex_global_date_format = '<?php echo dex_reservations_get_option('calendar_dateformat', DEX_RESERVATIONS_DEFAULT_CALENDAR_DATEFORMAT); ?>';
   var dex_global_start_weekday = '<?php echo dex_reservations_get_option('calendar_weekday', DEX_RESERVATIONS_DEFAULT_CALENDAR_WEEKDAY); ?>';
   </script>
   <script type="text/javascript" src="<?php echo plugins_url('TDE_RCalendar/all-scripts.js', __FILE__); ?>"></script>     
   
   <div style="padding:10px"><div id="caladmin">   
     <input name="selDay_start<?php echo CP_CALENDAR_ID; ?>" type="hidden" id="selDay_start<?php echo CP_CALENDAR_ID; ?>" />
     <input name="selMonth_start<?php echo CP_CALENDAR_ID; ?>" type="hidden" id="selMonth_start<?php echo CP_CALENDAR_ID; ?>" />
     <input name="selYear_start<?php echo CP_CALENDAR_ID; ?>" type="hidden" id="selYear_start<?php echo CP_CALENDAR_ID; ?>" />
     <input name="selDay_end<?php echo CP_CALENDAR_ID; ?>" type="hidden" id="selDay_end<?php echo CP_CALENDAR_ID; ?>" />
     <input name="selMonth_end<?php echo CP_CALENDAR_ID; ?>" type="hidden" id="selMonth_end<?php echo CP_CALENDAR_ID; ?>" />
     <input name="selYear_end<?php echo CP_CALENDAR_ID; ?>" type="hidden" id="selYear_end<?php echo CP_CALENDAR_ID; ?>" />
     <div style="z-index:1000;">
       <div id="containerRCalendar<?php echo CP_CALENDAR_ID; ?>"></div>
     </div>   
   </div></div>   

   <script type="text/javascript">initCalendar('<?php echo CP_CALENDAR_ID; ?>','<?php echo TDE_RESERVATIONDEFAULT_CALENDAR_LANGUAGE; ?>',true,<?php echo dex_reservations_get_option('calendar_mode',DEX_RESERVATIONS_DEFAULT_CALENDAR_MODE); ?>,'<?php _e('Select Start Date'); ?>','<?php _e('Select End Date'); ?>','<?php _e('Cancel Selection'); ?>','<?php _e('Successfully'); ?>');</script>   
   
   <div style="clear:both;height:20px" ></div>   
   <div id="demo" class="yui-navset" style="padding-left:10px;width:690px;"></div>
   <div style="clear:both;height:20px" ></div>      
   
  </div>    
 </div> 
 
 <hr />
   
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Public Calendar Settings</span></h3>
  <div class="inside"> 
   
   <table class="form-table">
        <tr valign="top">        
        <th scope="row">Calendar language</th>
        <td>
             <?php $value = dex_reservations_get_option('calendar_language',DEX_RESERVATIONS_DEFAULT_CALENDAR_LANGUAGE); ?>
             <select name="calendar_language">               
               <option value="DE" <?php if ($value == 'DE') echo ' selected="selected"'; ?>>German</option>
               <option value="DU" <?php if ($value == 'DU') echo ' selected="selected"'; ?>>Dutch</option>
               <option value="EN" <?php if ($value == 'EN') echo ' selected="selected"'; ?>>English</option>
               <option value="FR" <?php if ($value == 'FR') echo ' selected="selected"'; ?>>French</option>
               <option value="IT" <?php if ($value == 'IT') echo ' selected="selected"'; ?>>Italian</option>
               <option value="JP" <?php if ($value == 'JP') echo ' selected="selected"'; ?>>Japanese</option>
               <option value="PT" <?php if ($value == 'PT') echo ' selected="selected"'; ?>>Portuguese</option>               
               <option value="SP" <?php if ($value == 'SP') echo ' selected="selected"'; ?>>Spanish</option>            
            </select>
        </td>
        </tr>

          
        <tr valign="top">        
        <th scope="row">Date format</th>
        <td>           
             <?php $value = dex_reservations_get_option('calendar_dateformat',DEX_RESERVATIONS_DEFAULT_CALENDAR_DATEFORMAT); ?>
             <select name="calendar_dateformat">               
               <option value="0" <?php if ($value == '0') echo ' selected="selected"'; ?>>mm/dd/yyyy</option>
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>dd/mm/yyyy</option>         
             </select>           
        </td>
        </tr>
     
        <tr valign="top">        
        <th scope="row">Start weekday</th>
        <td>
             <?php $value = dex_reservations_get_option('calendar_weekday',DEX_RESERVATIONS_DEFAULT_CALENDAR_WEEKDAY); ?>
             <select name="calendar_weekday">               
               <option value="0" <?php if ($value == '0') echo ' selected="selected"'; ?>>Sunday</option>
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>Monday</option>
               <option value="2" <?php if ($value == '2') echo ' selected="selected"'; ?>>Tuesday</option>         
               <option value="3" <?php if ($value == '3') echo ' selected="selected"'; ?>>Wednesday</option>         
               <option value="4" <?php if ($value == '4') echo ' selected="selected"'; ?>>Thursday</option>         
               <option value="5" <?php if ($value == '5') echo ' selected="selected"'; ?>>Friday</option>         
               <option value="6" <?php if ($value == '6') echo ' selected="selected"'; ?>>Saturday</option>
             </select>         
        </td>
        </tr>      
     
<?php if (false) { ?>      
        <tr valign="top">        
        <th scope="row">Calendar Pages</th>
        <td>           
             <?php $value = dex_reservations_get_option('calendar_pages',DEX_RESERVATIONS_DEFAULT_CALENDAR_PAGES); ?>
             <select name="calendar_pages">               
               <option value="1" <?php if ($value == '1') echo ' selected="selected"'; ?>>1</option>
               <option value="2" <?php if ($value == '2') echo ' selected="selected"'; ?>>2</option>         
               <option value="3" <?php if ($value == '3') echo ' selected="selected"'; ?>>3</option>         
               <option value="4" <?php if ($value == '4') echo ' selected="selected"'; ?>>4</option>         
               <option value="5" <?php if ($value == '5') echo ' selected="selected"'; ?>>5</option>         
               <option value="6" <?php if ($value == '6') echo ' selected="selected"'; ?>>6</option>         
               <option value="7" <?php if ($value == '7') echo ' selected="selected"'; ?>>7</option>         
               <option value="8" <?php if ($value == '8') echo ' selected="selected"'; ?>>8</option>         
               <option value="9" <?php if ($value == '9') echo ' selected="selected"'; ?>>9</option>         
               <option value="10" <?php if ($value == '10') echo ' selected="selected"'; ?>>10</option>         
               <option value="11" <?php if ($value == '11') echo ' selected="selected"'; ?>>11</option>         
               <option value="12" <?php if ($value == '12') echo ' selected="selected"'; ?>>12</option>         
             </select>           
        </td>
        </tr>           
<?php } ?>      
        
        <tr valign="top">        
        <th scope="row">Reservation Mode</th>
        <td>
             <?php $value = dex_reservations_get_option('calendar_mode',DEX_RESERVATIONS_DEFAULT_CALENDAR_MODE); ?>
             <select name="calendar_mode">               
               <option value="true" <?php if ($value == 'true') echo ' selected="selected"'; ?>>Partial Days</option>
               <option value="false" <?php if ($value == 'false') echo ' selected="selected"'; ?>>Complete Days</option>
             </select>                       
             <br /> 
             <em style="font-size:11px;">Complete day means that the first and the last days booked are charged as full days; Partial Day means that they are charged as half-days only.</em>
        </td>
        </tr>
                
        
        <tr valign="top">        
        <th scope="row">Minimum  available date</th>
        <td><input type="text" name="calendar_mindate" size="40" value="<?php echo esc_attr(dex_reservations_get_option('calendar_mindate',DEX_RESERVATIONS_DEFAULT_CALENDAR_MINDATE)); ?>" /><br />
         <em style="font-size:11px;">Examples: 2012-10-25, today, today + 3 days</em>
        </td>
        </tr>
        
        <tr valign="top">        
        <th scope="row">Maximum available date</th>
        <td>
         <input type="text" name="calendar_maxdate" size="40" value="<?php echo esc_attr(dex_reservations_get_option('calendar_maxdate',DEX_RESERVATIONS_DEFAULT_CALENDAR_MAXDATE)); ?>" /><br />
         <em style="font-size:11px;">Examples: 2012-10-25, today, today + 3 days</em>
        </td>
        </tr>
        
   </table>   

  </div>    
 </div>

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Paypal Payment Configuration</span></h3>
  <div class="inside">

    <table class="form-table">
        <tr valign="top">        
        <th scope="row">Enable Paypal Payments?</th>
        <td>                   
          <select name="enable_paypal">           
           <option value="1" selected>Yes</option>
          </select>
         </td>
        </tr>    
    
        <tr valign="top">        
        <th scope="row">Paypal email</th>
        <td><input type="text" name="paypal_email" size="40" value="<?php echo esc_attr(dex_reservations_get_option('paypal_email',DEX_RESERVATIONS_DEFAULT_PAYPAL_EMAIL)); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Request cost (per day)</th>
        <td><input type="text" name="request_cost" value="<?php echo esc_attr(dex_reservations_get_option('request_cost',DEX_RESERVATIONS_DEFAULT_COST)); ?>" /></td>
        </tr>
        
        
        <tr valign="top">
        <th scope="row">Paypal product name</th>
        <td><input type="text" name="paypal_product_name" size="50" value="<?php echo esc_attr(dex_reservations_get_option('paypal_product_name',DEX_RESERVATIONS_DEFAULT_PRODUCT_NAME)); ?>" /></td>
        </tr>        
        
        <tr valign="top">
        <th scope="row">Currency</th>
        <td><input type="text" name="currency" value="<?php echo esc_attr(dex_reservations_get_option('currency',DEX_RESERVATIONS_DEFAULT_CURRENCY)); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">URL to return after successful  payment</th>
        <td><input type="text" name="url_ok" size="70" value="<?php echo esc_attr(dex_reservations_get_option('url_ok',DEX_RESERVATIONS_DEFAULT_OK_URL)); ?>" /></td>
        </tr>        
        
        <tr valign="top">
        <th scope="row">URL to return after an incomplete or cancelled payment</th>
        <td><input type="text" name="url_cancel" size="70" value="<?php echo esc_attr(dex_reservations_get_option('url_cancel',DEX_RESERVATIONS_DEFAULT_CANCEL_URL)); ?>" /></td>
        </tr>        
        
        
        <tr valign="top">
        <th scope="row">Paypal language</th>
        <td><input type="text" name="paypal_language" value="<?php echo esc_attr(dex_reservations_get_option('paypal_language',DEX_RESERVATIONS_DEFAULT_PAYPAL_LANGUAGE)); ?>" /></td>
        </tr>  
        
        <tr valign="top">
        <th scope="row">Discount Codes</th>
        <td> 
           <div id="dex_nocodes_availmsg"><em>Not available in this version.</em></div>          
           
        </td>
        </tr>  
                   
     </table>  

  </div>    
 </div>    
 
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Notification Settings</span></h3>
  <div class="inside">
     <table class="form-table">    
        <tr valign="top">
        <th scope="row">Notification "from" email</th>
        <td><input type="text" name="notification_from_email" size="40" value="<?php echo esc_attr(dex_reservations_get_option('notification_from_email', DEX_RESERVATIONS_DEFAULT_PAYPAL_EMAIL)); ?>" /></td>
        </tr>             
        <tr valign="top">
        <th scope="row">Send notification to email</th>
        <td><input type="text" name="notification_destination_email" size="40" value="<?php echo esc_attr(dex_reservations_get_option('notification_destination_email', DEX_RESERVATIONS_DEFAULT_PAYPAL_EMAIL)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email subject confirmation to user</th>
        <td><input type="text" name="email_subject_confirmation_to_user" size="70" value="<?php echo esc_attr(dex_reservations_get_option('email_subject_confirmation_to_user', DEX_RESERVATIONS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email confirmation to user</th>
        <td><textarea cols="70" rows="5" name="email_confirmation_to_user"><?php echo dex_reservations_get_option('email_confirmation_to_user', DEX_RESERVATIONS_DEFAULT_CONFIRMATION_EMAIL); ?></textarea></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email subject notification to admin</th>
        <td><input type="text" name="email_subject_notification_to_admin" size="70" value="<?php echo esc_attr(dex_reservations_get_option('email_subject_notification_to_admin', DEX_RESERVATIONS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL)); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Email notification to admin</th>
        <td><textarea cols="70" rows="5" name="email_notification_to_admin"><?php echo dex_reservations_get_option('email_notification_to_admin', DEX_RESERVATIONS_DEFAULT_NOTIFICATION_EMAIL); ?></textarea></td>
        </tr>                                                
     </table>  
  </div>    
 </div>  
 
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Captcha Verification</span></h3>
  <div class="inside">
     <table class="form-table">    
        <tr valign="top">
        <th scope="row">Use Captcha Verification?</th>
        <td colspan="5">
          <?php $option = dex_reservations_get_option('dexcv_enable_captcha', TDE_RESERVATIONDEFAULT_dexcv_enable_captcha); ?>
          <select name="dexcv_enable_captcha">           
           <option value="false"<?php if ($option == 'false') echo ' selected'; ?>>No</option>
          </select>
          <br />
          <em>* Not available in this version.</em>
        </td>
        </tr>
        
        <tr valign="top">
         <th scope="row">Width:</th>
         <td><input type="text" name="dexcv_width" size="10" value="<?php echo esc_attr(dex_reservations_get_option('dexcv_width', TDE_RESERVATIONDEFAULT_dexcv_width)); ?>"  onblur="generateCaptcha();"  /></td>
         <th scope="row">Height:</th>
         <td><input type="text" name="dexcv_height" size="10" value="<?php echo esc_attr(dex_reservations_get_option('dexcv_height', TDE_RESERVATIONDEFAULT_dexcv_height)); ?>" onblur="generateCaptcha();"  /></td>
         <th scope="row">Chars:</th>
         <td><input type="text" name="dexcv_chars" size="10" value="<?php echo esc_attr(dex_reservations_get_option('dexcv_chars', TDE_RESERVATIONDEFAULT_dexcv_chars)); ?>" onblur="generateCaptcha();"  /></td>
        </tr>             

        <tr valign="top">
         <th scope="row">Min font size:</th>
         <td><input type="text" name="dexcv_min_font_size" size="10" value="<?php echo esc_attr(dex_reservations_get_option('dexcv_min_font_size', TDE_RESERVATIONDEFAULT_dexcv_min_font_size)); ?>" onblur="generateCaptcha();"  /></td>
         <th scope="row">Max font size:</th>
         <td><input type="text" name="dexcv_max_font_size" size="10" value="<?php echo esc_attr(dex_reservations_get_option('dexcv_max_font_size', TDE_RESERVATIONDEFAULT_dexcv_max_font_size)); ?>" onblur="generateCaptcha();"  /></td>        
         <td colspan="2" rowspan="">
           Preview:<br />
             <br />
            <img src="<?php echo plugins_url('/captcha/captcha.php', __FILE__); ?>"  id="captchaimg" alt="security code" border="0"  />            
         </td> 
        </tr>             
                

        <tr valign="top">
         <th scope="row">Noise:</th>
         <td><input type="text" name="dexcv_noise" size="10" value="<?php echo esc_attr(dex_reservations_get_option('dexcv_noise', TDE_RESERVATIONDEFAULT_dexcv_noise)); ?>" onblur="generateCaptcha();" /></td>
         <th scope="row">Noise Length:</th>
         <td><input type="text" name="dexcv_noise_length" size="10" value="<?php echo esc_attr(dex_reservations_get_option('dexcv_noise_length', TDE_RESERVATIONDEFAULT_dexcv_noise_length)); ?>" onblur="generateCaptcha();" /></td>        
        </tr>          
        

        <tr valign="top">
         <th scope="row">Background:</th>
         <td><input type="text" name="dexcv_background" size="10" value="<?php echo esc_attr(dex_reservations_get_option('dexcv_background', TDE_RESERVATIONDEFAULT_dexcv_background)); ?>" onblur="generateCaptcha();" /></td>
         <th scope="row">Border:</th>
         <td><input type="text" name="dexcv_border" size="10" value="<?php echo esc_attr(dex_reservations_get_option('dexcv_border', TDE_RESERVATIONDEFAULT_dexcv_border)); ?>" onblur="generateCaptcha();" /></td>        
        </tr>    
        
        <tr valign="top">
         <th scope="row">Font:</th>
         <td>
            <select name="dexcv_font" onchange="generateCaptcha();" >
              <option value="font-1.ttf"<?php if ("font-1.ttf" == dex_reservations_get_option('dexcv_font', TDE_RESERVATIONDEFAULT_dexcv_font)) echo " selected"; ?>>Font 1</option>
              <option value="font-2.ttf"<?php if ("font-2.ttf" == dex_reservations_get_option('dexcv_font', TDE_RESERVATIONDEFAULT_dexcv_font)) echo " selected"; ?>>Font 2</option>
              <option value="font-3.ttf"<?php if ("font-3.ttf" == dex_reservations_get_option('dexcv_font', TDE_RESERVATIONDEFAULT_dexcv_font)) echo " selected"; ?>>Font 3</option>
              <option value="font-4.ttf"<?php if ("font-4.ttf" == dex_reservations_get_option('dexcv_font', TDE_RESERVATIONDEFAULT_dexcv_font)) echo " selected"; ?>>Font 4</option>
            </select>            
         </td>              
        </tr>                          
           
        
     </table>  
  </div>    
 </div>     
 
  <div id="metabox_basic_settings" class="postbox" >
    <h3 class='hndle' style="padding:5px;"><span>Note</span></h3>
    <div class="inside">
     To insert this form in a post/page, use the dedicated icon 
     <?php print '<img hspace="5" src="'.plugins_url('/images/dex_apps.gif', __FILE__).'" alt="'.__('Insert Reservation Calendar').'" />';     ?>
     which has been added to your Upload/Insert Menu, just below the title of your Post/Page.
     <br /><br />
    </div>
  </div>  
  
</div> 


<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"  /></p>

[<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/cp-reservation-calendar" target="_blank">Help</a>]
</form>
</div>
<script type="text/javascript">
 function generateCaptcha()
 {            
    var d=new Date();
    var f = document.dexconfigofrm;    
    var qs = "?width="+f.dexcv_width.value;
    qs += "&height="+f.dexcv_height.value;
    qs += "&letter_count="+f.dexcv_chars.value;
    qs += "&min_size="+f.dexcv_min_font_size.value;
    qs += "&max_size="+f.dexcv_max_font_size.value;
    qs += "&noise="+f.dexcv_noise.value;
    qs += "&noiselength="+f.dexcv_noise_length.value;
    qs += "&bcolor="+f.dexcv_background.value;
    qs += "&border="+f.dexcv_border.value;
    qs += "&font="+f.dexcv_font.options[f.dexcv_font.selectedIndex].value;
    qs += "&rand="+d;
         
    document.getElementById("captchaimg").src= "<?php echo plugins_url('/captcha/captcha.php', __FILE__); ?>"+qs;
 }       
         
 generateCaptcha();         
         
</script>



<?php } else { ?>
  <br /> 
  The current user logged in doesn't have enough permissions to edit this calendar. This user can edit only his/her own calendars. Please log in as administrator to get access to all calendars.

<?php } ?>











