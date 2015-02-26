<?php
/*
Plugin Name: CP Reservation Calendar
Plugin URI: http://wordpress.dwbooster.com/calendars/cp-reservation-calendar
Description: This plugin allows you to easily insert reservation forms into your WP website.
Version: 1.1.6
Author: CodePeople.net
Author URI: http://codepeople.net
License: GPL
*/


/* initialization / install / uninstall functions */


define('DEX_RESERVATIONS_DEFAULT_CALENDAR_LANGUAGE', 'EN');
define('DEX_RESERVATIONS_DEFAULT_CALENDAR_DATEFORMAT', 'false');
define('DEX_RESERVATIONS_DEFAULT_CALENDAR_WEEKDAY', '0');
define('DEX_RESERVATIONS_DEFAULT_CALENDAR_MINDATE', 'today');
define('DEX_RESERVATIONS_DEFAULT_CALENDAR_MAXDATE', '');
define('DEX_RESERVATIONS_DEFAULT_CALENDAR_PAGES', 1);

define('DEX_RESERVATIONS_DEFAULT_ENABLE_PAYPAL', 1);
define('DEX_RESERVATIONS_DEFAULT_PAYPAL_EMAIL','put_your@email_here.com');
define('DEX_RESERVATIONS_DEFAULT_PRODUCT_NAME','Reservation');
define('DEX_RESERVATIONS_DEFAULT_COST','25');
define('DEX_RESERVATIONS_DEFAULT_OK_URL',get_site_url());
define('DEX_RESERVATIONS_DEFAULT_CANCEL_URL',get_site_url());
define('DEX_RESERVATIONS_DEFAULT_CURRENCY','USD');
define('DEX_RESERVATIONS_DEFAULT_PAYPAL_LANGUAGE','EN');

define('DEX_RESERVATIONS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL', 'Thank you for your request...');
define('DEX_RESERVATIONS_DEFAULT_CONFIRMATION_EMAIL', "We have received your request with the following information:\n\n%INFORMATION%\n\nThank you.\n\nBest regards.");
define('DEX_RESERVATIONS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL','New reservation requested...');
define('DEX_RESERVATIONS_DEFAULT_NOTIFICATION_EMAIL', "New reservation made with the following information:\n\n%INFORMATION%\n\nBest regards.");

define('DEX_RESERVATIONS_DEFAULT_CP_CAL_CHECKBOXES',"");
define('DEX_RESERVATIONS_DEFAULT_EXPLAIN_CP_CAL_CHECKBOXES',"1.00 | Service 1 for us$1.00\n5.00 | Service 2 for us$5.00\n10.00 | Service 3 for us$10.00");


// tables

define('DEX_RESERVATIONS_TABLE_NAME_NO_PREFIX', "dex_reservations");
define('DEX_RESERVATIONS_TABLE_NAME', @$wpdb->prefix . DEX_RESERVATIONS_TABLE_NAME_NO_PREFIX);

define('DEX_RESERVATIONS_CALENDARS_TABLE_NAME_NO_PREFIX', "reservation_calendars_data");
define('DEX_RESERVATIONS_CALENDARS_TABLE_NAME', @$wpdb->prefix ."reservation_calendars_data");

define('DEX_RESERVATIONS_CONFIG_TABLE_NAME_NO_PREFIX', "reservation_calendars");
define('DEX_RESERVATIONS_CONFIG_TABLE_NAME', @$wpdb->prefix ."reservation_calendars");

define('DEX_RESERVATIONS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX', "dex_reservations_discount_codes");
define('DEX_RESERVATIONS_DISCOUNT_CODES_TABLE_NAME', @$wpdb->prefix ."dex_reservations_discount_codes");

// calendar constants

define("TDE_RESERVATIONDEFAULT_CALENDAR_ID","1");
define("TDE_RESERVATIONDEFAULT_CALENDAR_LANGUAGE","EN");
define("DEX_RESERVATIONS_DEFAULT_CALENDAR_MODE","true");

define("TDE_RESERVATIONCAL_PREFIX", "RCalendar");
define("TDE_RESERVATIONCONFIG",DEX_RESERVATIONS_CONFIG_TABLE_NAME);
define("TDE_RESERVATIONCONFIG_ID","id");
define("TDE_RESERVATIONCONFIG_TITLE","title");
define("TDE_RESERVATIONCONFIG_USER","uname");
define("TDE_RESERVATIONCONFIG_PASS","passwd");
define("TDE_RESERVATIONCONFIG_LANG","lang");
define("TDE_RESERVATIONCONFIG_CPAGES","cpages");
define("TDE_RESERVATIONCONFIG_MSG","msg");
define("TDE_RESERVATIONCALDELETED_FIELD","caldeleted");

define("TDE_RESERVATIONCALENDAR_DATA_TABLE",DEX_RESERVATIONS_CALENDARS_TABLE_NAME);
define("TDE_RESERVATIONDATA_ID","id");
define("TDE_RESERVATIONDATA_IDCALENDAR","reservation_calendar_id");
define("TDE_RESERVATIONDATA_DATETIME_S","datatime_s");
define("TDE_RESERVATIONDATA_DATETIME_E","datatime_e");
define("TDE_RESERVATIONDATA_TITLE","title");
define("TDE_RESERVATIONDATA_DESCRIPTION","description");
// end calendar constants

define('TDE_RESERVATIONDEFAULT_dexcv_enable_captcha', 'false');
define('TDE_RESERVATIONDEFAULT_dexcv_width', '180');
define('TDE_RESERVATIONDEFAULT_dexcv_height', '60');
define('TDE_RESERVATIONDEFAULT_dexcv_chars', '5');
define('TDE_RESERVATIONDEFAULT_dexcv_font', 'font-1.ttf');
define('TDE_RESERVATIONDEFAULT_dexcv_min_font_size', '25');
define('TDE_RESERVATIONDEFAULT_dexcv_max_font_size', '35');
define('TDE_RESERVATIONDEFAULT_dexcv_noise', '200');
define('TDE_RESERVATIONDEFAULT_dexcv_noise_length', '4');
define('TDE_RESERVATIONDEFAULT_dexcv_background', 'ffffff');
define('TDE_RESERVATIONDEFAULT_dexcv_border', '000000');
define('TDE_RESERVATIONDEFAULT_dexcv_text_enter_valid_captcha', 'Please enter a valid captcha code.');


function dex_reservations_plugin_init() {
  load_plugin_textdomain( 'default', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'dex_reservations_plugin_init');

register_activation_hook(__FILE__,'dex_reservations_install');

function dex_reservations_install($networkwide)  {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
	                $old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				_dex_reservations_install();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	_dex_reservations_install();
}

function _dex_reservations_install() {
    global $wpdb;    
    
    $sql = "CREATE TABLE ".$wpdb->prefix.DEX_RESERVATIONS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX." (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         cal_id mediumint(9) NOT NULL DEFAULT 1,
         code VARCHAR(250) DEFAULT '' NOT NULL,
         discount VARCHAR(250) DEFAULT '' NOT NULL,
         expires datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,       
         availability int(10) unsigned NOT NULL DEFAULT 0,
         used int(10) unsigned NOT NULL DEFAULT 0,
         UNIQUE KEY id (id)
         );";             
    $wpdb->query($sql); 

    $sql = "CREATE TABLE ".$wpdb->prefix.DEX_RESERVATIONS_TABLE_NAME_NO_PREFIX." (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         calendar INT NOT NULL,
         time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         booked_time_s VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_e VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_unformatted_s VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_unformatted_e VARCHAR(250) DEFAULT '' NOT NULL,
         name VARCHAR(250) DEFAULT '' NOT NULL,
         email VARCHAR(250) DEFAULT '' NOT NULL,
         phone VARCHAR(250) DEFAULT '' NOT NULL,
         question text,
         buffered_date text,
         UNIQUE KEY id (id)
         );";
    $wpdb->query($sql);
    

    $sql = "CREATE TABLE `".$wpdb->prefix.DEX_RESERVATIONS_CONFIG_TABLE_NAME."` (".
                   "`".TDE_RESERVATIONCONFIG_ID."` int(10) unsigned NOT NULL auto_increment,".
                   "`".TDE_RESERVATIONCONFIG_TITLE."` varchar(255) NOT NULL default '',".
                   "`".TDE_RESERVATIONCONFIG_USER."` varchar(100) default NULL,".
                   "`".TDE_RESERVATIONCONFIG_PASS."` varchar(100) default NULL,".
                   "`".TDE_RESERVATIONCONFIG_LANG."` varchar(5) default NULL,".
                   "`".TDE_RESERVATIONCONFIG_CPAGES."` tinyint(3) unsigned default NULL,".
                   "`".TDE_RESERVATIONCONFIG_MSG."` varchar(255) NOT NULL default '',".
                   "`".TDE_RESERVATIONCALDELETED_FIELD."` tinyint(3) unsigned default NULL,".
                   "`conwer` INT NOT NULL,".
                   "`calendar_language` varchar(10) DEFAULT '' NOT NULL,".
                   "`calendar_mode` varchar(10) DEFAULT '' NOT NULL,".
                   "`calendar_dateformat` varchar(10) DEFAULT '',".
                   "`calendar_pages` varchar(10) DEFAULT '' NOT NULL,".
                   "`calendar_weekday` varchar(10) DEFAULT '' NOT NULL,".
                   "`calendar_mindate` varchar(255) DEFAULT '' NOT NULL,".
                   "`calendar_maxdate` varchar(255) DEFAULT '' NOT NULL,".
                   // paypal
                   "`enable_paypal` varchar(10) DEFAULT '' NOT NULL,".
                   "`paypal_email` varchar(255) DEFAULT '' NOT NULL ,".
                   "`request_cost` varchar(255) DEFAULT '' NOT NULL ,".
                   "`paypal_product_name` varchar(255) DEFAULT '' NOT NULL,".
                   "`currency` varchar(10) DEFAULT '' NOT NULL,".
                   "`url_ok` text,".
                   "`url_cancel` text,".
                   "`paypal_language` varchar(10) DEFAULT '' NOT NULL,".
                   // copy to user
                   "`notification_from_email` text,".
                   "`notification_destination_email` text,".
                   "`email_subject_confirmation_to_user` text,".
                   "`email_confirmation_to_user` text,".
                   "`email_subject_notification_to_admin` text,".
                   "`email_notification_to_admin` text,".
                   // captcha
                   "`dexcv_enable_captcha` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_width` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_height` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_chars` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_min_font_size` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_max_font_size` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_noise` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_noise_length` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_background` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_border` varchar(10) DEFAULT '' NOT NULL,".
                   "`dexcv_font` varchar(100) DEFAULT '' NOT NULL,".
                   // services field
                   "`cp_cal_checkboxes` text,".
                   "PRIMARY KEY (`".TDE_RESERVATIONCONFIG_ID."`)); ";
    $wpdb->query($sql);
    
    $sql = 'INSERT INTO `'.$wpdb->prefix.DEX_RESERVATIONS_CONFIG_TABLE_NAME.'` (`'.TDE_RESERVATIONCONFIG_ID.'`,`'.TDE_RESERVATIONCONFIG_TITLE.'`,`'.TDE_RESERVATIONCONFIG_USER.'`,`'.TDE_RESERVATIONCONFIG_PASS.'`,`'.TDE_RESERVATIONCONFIG_LANG.'`,`'.TDE_RESERVATIONCONFIG_CPAGES.'`,`'.TDE_RESERVATIONCONFIG_MSG.'`,`'.TDE_RESERVATIONCALDELETED_FIELD.'`,calendar_mode) VALUES("1","cal1","Calendar Item 1","","ENG","1","Please, select your reservation.","0","true");';
    $wpdb->query($sql);

    $sql = "CREATE TABLE `".$wpdb->prefix.DEX_RESERVATIONS_CALENDARS_TABLE_NAME."` (".
                   "`".TDE_RESERVATIONDATA_ID."` int(10) unsigned NOT NULL auto_increment,".
                   "`".TDE_RESERVATIONDATA_IDCALENDAR."` int(10) unsigned default NULL,".
                   "`".TDE_RESERVATIONDATA_DATETIME_S."`datetime NOT NULL default '0000-00-00 00:00:00',".
                   "`".TDE_RESERVATIONDATA_DATETIME_E."`datetime NOT NULL default '0000-00-00 00:00:00',".
                   "`".TDE_RESERVATIONDATA_TITLE."` varchar(250) default NULL,".
                   "`".TDE_RESERVATIONDATA_DESCRIPTION."` text,".
                   "PRIMARY KEY (`".TDE_RESERVATIONDATA_ID."`)) ;";
    $wpdb->query($sql);
    
    

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}


/* Filter for placing the maps into the contents */

add_filter('the_content','dex_reservations_filter_content');

function dex_reservations_filter_content($content) {

    global $wpdb;

    if (strpos($content, "[CP_RESERVATION_CALENDAR") !== false)
    {

        $shorttag =  "[CP_RESERVATION_CALENDAR]";
        $shorttag_sel =  "[CP_RESERVATION_CALENDAR]";
        if (strpos($content, $shorttag) !== false)
            define ('DEX_CALENDAR_USER',0);
        else
        {
            $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." ORDER BY ID DESC" );
            foreach ($users as $user)
            {
                $shorttag =  "[CP_RESERVATION_CALENDAR user=\"".$user->user_login."\"]";
                if (strpos($content, $shorttag) !== false)
                {
                    $shorttag_sel =  "[CP_RESERVATION_CALENDAR user=\"".$user->user_login."\"]";
                    define ('DEX_CALENDAR_USER',$user->ID);
                }
                else
                {
                    $shorttag =  "[CP_RESERVATION_CALENDAR user=".$user->user_login."]";
                    if (strpos($content, $shorttag) !== false)
                    {
                        $shorttag_sel =  "[CP_RESERVATION_CALENDAR user=".$user->user_login."]";
                        define ('DEX_CALENDAR_USER',$user->ID);
                    }
                }
            }

            // if no calendar tag found, try to find it by calendar id
            if (!defined('DEX_CALENDAR_USER'))
            {
                $calendars = $wpdb->get_results( "SELECT * FROM ".DEX_RESERVATIONS_CONFIG_TABLE_NAME );
                foreach ($calendars as $calendar)
                {
                    $shorttag =  "[CP_RESERVATION_CALENDAR calendar=\"".$calendar->id."\"]";
                    if (strpos($content, $shorttag) !== false)
                    {
                        $shorttag_sel =  "[CP_RESERVATION_CALENDAR calendar=\"".$calendar->id."\"]";
                        define ('DEX_CALENDAR_FIXED_ID',$calendar->id);
                    }
                    else
                    {
                        $shorttag =  "[CP_RESERVATION_CALENDAR calendar=".$calendar->id."]";
                        if (strpos($content, $shorttag) !== false)
                        {
                            $shorttag_sel =  "[CP_RESERVATION_CALENDAR calendar=".$calendar->id."]";
                            define ('DEX_CALENDAR_FIXED_ID',$calendar->id);
                        }
                    }
                }
            }


        }

        ob_start();
        define('DEX_AUTH_INCLUDE', true);
        @include dirname( __FILE__ ) . '/dex_scheduler.inc.php';
        $buffered_contents = ob_get_contents();
        ob_end_clean();

        $content = str_replace($shorttag_sel, $buffered_contents, $content);
    }
    return $content;
}

function dex_reservations_show_booking_form($id = "")
{
    if ($id != '')
        define ('DEX_CALENDAR_FIXED_ID',$id);
    define('DEX_AUTH_INCLUDE', true);
    @include dirname( __FILE__ ) . '/dex_scheduler.inc.php';    
}


/* Code for the admin area */

if ( is_admin() ) {
    add_action('media_buttons', 'set_dex_reservations_insert_button', 100);
    add_action('admin_enqueue_scripts', 'set_dex_reservations_insert_adminScripts', 1);
    add_action('admin_menu', 'dex_reservations_admin_menu');

    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_".$plugin, 'dex_reservations_customAdjustmentsLink');
    add_filter("plugin_action_links_".$plugin, 'dex_reservations_settingsLink');
    add_filter("plugin_action_links_".$plugin, 'dex_reservations_helpLink');


    function dex_reservations_admin_menu() {
        add_options_page('CP Reservation Calendar Options', 'CP Reservation Calendar', 'manage_options', 'dex_reservations', 'dex_reservations_html_post_page' );
        add_menu_page( 'CP Reservation Calendar Options', 'CP Reservation Calendar', 'edit_pages', 'dex_reservations', 'dex_reservations_html_post_page' );
    }
}
else
{
    add_action('wp_enqueue_scripts', 'set_dex_reservations_insert_publicScripts');
}

function dex_reservations_settingsLink($links) {
    $settings_link = '<a href="options-general.php?page=dex_reservations">'.__('Settings').'</a>';
	array_unshift($links, $settings_link);
	return $links;
}


function dex_reservations_helpLink($links) {
    $help_link = '<a href="http://wordpress.dwbooster.com/calendars/cp-reservation-calendar">'.__('Help').'</a>';
	array_unshift($links, $help_link);
	return $links;
}

function dex_reservations_customAdjustmentsLink($links) {
    $customAdjustments_link = '<a href="http://wordpress.dwbooster.com/contact-us">'.__('Request custom changes').'</a>';
	array_unshift($links, $customAdjustments_link);
	return $links;
}

function dex_reservations_html_post_page() {
    if (isset($_GET["cal"]) && $_GET["cal"] != '')
    {
        if (isset($_GET["list"]) && $_GET["list"] == '1')
            @include_once dirname( __FILE__ ) . '/dex_reservations_admin_int_bookings_list.inc.php';
        else
            @include_once dirname( __FILE__ ) . '/dex_reservations_admin_int.inc.php';
    }
    else
        @include_once dirname( __FILE__ ) . '/dex_reservations_admin_int_calendar_list.inc.php';

}

function set_dex_reservations_insert_button() {
    print '<a href="javascript:dex_reservations_insertCalendar();" title="'.__('Insert Reservation Calendar').'"><img hspace="5" src="'.plugins_url('/images/dex_apps.gif', __FILE__).'" alt="'.__('Insert  Reservation Calendar').'" /></a>';
}

function set_dex_reservations_insert_adminScripts($hook) {
    if (isset($_GET["cal"]) && $_GET["cal"] != '')
    {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-datepicker' );        
        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    }
    if( 'post.php' != $hook  && 'post-new.php' != $hook )
        return;
    wp_enqueue_script( 'cp_dex_reservations_script', plugins_url('/dex_reservations_script.js', __FILE__) );
}

function set_dex_reservations_insert_publicScripts($hook) {
    wp_enqueue_script( 'jquery' );
}


/* hook for checking posted data for the admin area */


add_action( 'init', 'dex_reservations_check_posted_data', 11 );

function dex_reservations_check_posted_data()
{
    global $wpdb;

    if (isset($_GET["dex_reservations"]) &&  $_GET["dex_reservations"] == 'calfeed')
        dex_reservations_export_iCal();
        

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['dex_reservations_post_options'] ) && is_admin() )
    {
        dex_reservations_save_options();
        return;
    }

    // if this isn't the expected post and isn't the captcha verification then nothing to do
	if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['dex_reservations_post'] ) )
		if ( 'GET' != $_SERVER['REQUEST_METHOD'] || !isset( $_GET['hdcaptcha'] ) )
		    return;

    if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',$_POST["dex_item"]);

    session_start();

	// if this isn't the real post (it was the captcha verification) then echo ok and exit
    if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['dex_reservations_post'] ) )
	{
	    echo 'ok';
        exit;
	}

    $_SESSION['rand_code'] = '';

    $selectedCalendar = $_POST["dex_item"];

    $_POST["dateAndTime_s"] =  $_POST["selYear_start".$selectedCalendar]."-".$_POST["selMonth_start".$selectedCalendar]."-".$_POST["selDay_start".$selectedCalendar];
    $_POST["dateAndTime_e"] =  $_POST["selYear_end".$selectedCalendar]."-".$_POST["selMonth_end".$selectedCalendar]."-".$_POST["selDay_end".$selectedCalendar];

    if (dex_reservations_get_option('calendar_dateformat', DEX_RESERVATIONS_DEFAULT_CALENDAR_DATEFORMAT))
    {
        $_POST["Date_s"] = date("d/m/Y H:i",strtotime($_POST["dateAndTime_s"]));
        $_POST["Date_e"] = date("d/m/Y H:i",strtotime($_POST["dateAndTime_e"]));
    }    
    else
    {
        $_POST["Date_s"] = date("m/d/Y H:i",strtotime($_POST["dateAndTime_s"]));
        $_POST["Date_e"] = date("m/d/Y H:i",strtotime($_POST["dateAndTime_e"]));
    }

    $services_formatted = explode("|",@$_POST["services"]);

    $price = (@$_POST["services"]?trim($services_formatted[0]):dex_reservations_get_option('request_cost', DEX_RESERVATIONS_DEFAULT_COST));
 
    $discount_note = "";
    $coupon = false;  

    $buffer = $_POST["Date_s"] ." - ". $_POST["Date_e"] ."\n".
    "Name: ".$_POST["name"]."\n".
    "Email: ".$_POST["email"]."\n".
    "Phone: ".$_POST["phone"]."\n".
    "Question: ".$_POST["question"]."\n".
            (@$_POST["services"]?"\nService: ".trim($services_formatted[1])."\n":"").
            ($coupon?"\nCoupon code: ".$coupon->code.$discount_note."\n":"").
    "*-*\n";
    
    $days = round(
                   (strtotime($_POST["dateAndTime_e"]) - strtotime($_POST["dateAndTime_s"])) / (24 * 60 * 60)
                 );
    if (dex_reservations_get_option('calendar_mode',DEX_RESERVATIONS_DEFAULT_CALENDAR_MODE) == 'false')             
        $days++; 
        
    $price = floatval ($price)*$days;

    $rows_affected = $wpdb->insert( DEX_RESERVATIONS_TABLE_NAME, array( 'calendar' => $selectedCalendar,
                                                                        'time' => current_time('mysql'),
                                                                        'booked_time_s' => $_POST["Date_s"],
                                                                        'booked_time_e' => $_POST["Date_e"],
                                                                        'booked_time_unformatted_s' => $_POST["dateAndTime_s"],
                                                                        'booked_time_unformatted_e' => $_POST["dateAndTime_e"],
                                                                        'name' => $_POST["name"],
                                                                        'email' => $_POST["email"],
                                                                        'phone' => $_POST["phone"],
                                                                        'question' => $_POST["question"]
                                                                           .(@$_POST["services"]?"\nService: ".trim($services_formatted[1]):"")
                                                                           .($coupon?"\nCoupon code: ".$coupon->code.$discount_note:"")
                                                                           ,
                                                                        'buffered_date' => $buffer
                                                                         ) );
    if (!$rows_affected)
    {
        echo 'Error saving data! Please try again.';
        echo '<br /><br />Error debug information: '.mysql_error();
        exit;
    }


    $myrows = $wpdb->get_results( "SELECT MAX(id) as max_id FROM ".DEX_RESERVATIONS_TABLE_NAME );

 	// save data here
    $item_number = $myrows[0]->max_id;

?>
<html>
<head><title>Redirecting to Paypal...</title></head>
<body>
<form action="https://www.paypal.com/cgi-bin/webscr" name="ppform3" method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo dex_reservations_get_option('paypal_email', DEX_RESERVATIONS_DEFAULT_PAYPAL_EMAIL); ?>" />
<input type="hidden" name="item_name" value="<?php echo dex_reservations_get_option('paypal_product_name', DEX_RESERVATIONS_DEFAULT_PRODUCT_NAME).(@$_POST["services"]?": ".trim($services_formatted[1]):"").$discount_note; ?>" />
<input type="hidden" name="item_number" value="<?php echo $item_number; ?>" />
<input type="hidden" name="amount" value="<?php echo $price; ?>" />
<input type="hidden" name="page_style" value="Primary" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="return" value="<?php echo dex_reservations_get_option('url_ok', DEX_RESERVATIONS_DEFAULT_OK_URL); ?>">
<input type="hidden" name="cancel_return" value="<?php echo dex_reservations_get_option('url_cancel', DEX_RESERVATIONS_DEFAULT_CANCEL_URL); ?>" />
<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="currency_code" value="<?php echo strtoupper(dex_reservations_get_option('currency', DEX_RESERVATIONS_DEFAULT_CURRENCY)); ?>" />
<input type="hidden" name="lc" value="<?php echo dex_reservations_get_option('paypal_language', DEX_RESERVATIONS_DEFAULT_PAYPAL_LANGUAGE); ?>" />
<input type="hidden" name="bn" value="NetFactorSL_SI_Custom" />
<input type="hidden" name="notify_url" value="<?php echo cp_reservation_get_FULL_site_url(); ?>/?ipncheck=1&itemnumber=<?php echo $item_number; ?>" />
<input type="hidden" name="ipn_test" value="1" />
<input class="pbutton" type="hidden" value="Buy Now" /></div>
</form>
<script type="text/javascript">
document.ppform3.submit();
</script>
</body>
</html>
<?php
     exit();
   
}

add_action( 'init', 'dex_reservations_check_IPN_verification', 11 );

function dex_reservations_check_IPN_verification() {

    global $wpdb;

	if ( ! isset( $_GET['ipncheck'] ) || $_GET['ipncheck'] != '1' ||  ! isset( $_GET["itemnumber"] ) )
		return;

    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $payment_type = $_POST['payment_type'];


	if ($payment_status != 'Completed' && $payment_type != 'echeck')
	    return;

	if ($payment_type == 'echeck' && $payment_status == 'Completed')
	    return;

    dex_process_ready_to_go_reservation($_GET["itemnumber"], $payer_email);

    echo 'OK';

    exit();

}

function dex_process_ready_to_go_reservation($itemnumber, $payer_email = "")
{
   global $wpdb;

   $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_RESERVATIONS_TABLE_NAME." WHERE id=".$itemnumber );

   $mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.DEX_RESERVATIONS_CONFIG_TABLE_NAME .' WHERE `'.TDE_RESERVATIONCONFIG_ID.'`='.$myrows[0]->calendar);

   if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',$myrows[0]->calendar);

   $SYSTEM_EMAIL = dex_reservations_get_option('notification_from_email', DEX_RESERVATIONS_DEFAULT_PAYPAL_EMAIL);
   $SYSTEM_RCPT_EMAIL = dex_reservations_get_option('notification_destination_email', DEX_RESERVATIONS_DEFAULT_PAYPAL_EMAIL);


   $email_subject1 = dex_reservations_get_option('email_subject_confirmation_to_user', DEX_RESERVATIONS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL);
   $email_content1 = dex_reservations_get_option('email_confirmation_to_user', DEX_RESERVATIONS_DEFAULT_CONFIRMATION_EMAIL);
   $email_subject2 = dex_reservations_get_option('email_subject_notification_to_admin', DEX_RESERVATIONS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL);
   $email_content2 = dex_reservations_get_option('email_notification_to_admin', DEX_RESERVATIONS_DEFAULT_NOTIFICATION_EMAIL);

   $information = $mycalendarrows[0]->uname."\n".
                  $myrows[0]->booked_time_s."\n".
                  $myrows[0]->booked_time_e."\n".
                  $myrows[0]->name."\n".
                  $myrows[0]->email."\n".
                  $myrows[0]->phone."\n".
                  $myrows[0]->question."\n";

   $email_content1 = str_replace("%INFORMATION%", $information, $email_content1);
   $email_content2 = str_replace("%INFORMATION%", $information, $email_content2);

   // SEND EMAIL TO USER
   wp_mail($myrows[0]->email, $email_subject1, $email_content1,
            "From: \"$SYSTEM_EMAIL\" <".$SYSTEM_EMAIL.">\r\n".
            "Content-Type: text/plain; charset=utf-8\n".
            "X-Mailer: PHP/" . phpversion());

   if ($payer_email && strtolower($payer_email) != strtolower($myrows[0]->email))
       wp_mail($payer_email , $email_subject1, $email_content1,
                "From: \"$SYSTEM_EMAIL\" <".$SYSTEM_EMAIL.">\r\n".
                "Content-Type: text/plain; charset=utf-8\n".
                "X-Mailer: PHP/" . phpversion());

   // SEND EMAIL TO ADMIN
   wp_mail($SYSTEM_RCPT_EMAIL, $email_subject2, $email_content2,
            "From: \"$SYSTEM_EMAIL\" <".$SYSTEM_EMAIL.">\r\n".
            "Content-Type: text/plain; charset=utf-8\n".
            "X-Mailer: PHP/" . phpversion());


    $rows_affected = $wpdb->insert( TDE_RESERVATIONCALENDAR_DATA_TABLE, array( 'reservation_calendar_id' => $myrows[0]->calendar,
                                                                        'datatime_s' => date("Y-m-d H:i:s", strtotime($myrows[0]->booked_time_unformatted_s)),
                                                                        'datatime_e' => date("Y-m-d H:i:s", strtotime($myrows[0]->booked_time_unformatted_e)),
                                                                        'title' => $myrows[0]->name,
                                                                        'description' => str_replace("\n","<br />", $information)
                                                                         ) );


}

function dex_reservations_save_options()
{
    global $wpdb;
    if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',$_POST["dex_item"]);

    $data = array(
         'calendar_language' => $_POST["calendar_language"],
         'calendar_dateformat' => $_POST["calendar_dateformat"],
         'calendar_mode' => $_POST["calendar_mode"],        
         'calendar_pages' => 1,         
         'calendar_weekday' => $_POST["calendar_weekday"],
         'calendar_mindate' => $_POST["calendar_mindate"],
         'calendar_maxdate' => $_POST["calendar_maxdate"],

         'enable_paypal' => '1',
         'paypal_email' => $_POST["paypal_email"],
         'request_cost' => $_POST["request_cost"],
         'paypal_product_name' => $_POST["paypal_product_name"],
         'currency' => $_POST["currency"],
         'url_ok' => $_POST["url_ok"],
         'url_cancel' => $_POST["url_cancel"],
         'paypal_language' => $_POST["paypal_language"],

         'notification_from_email' => $_POST["notification_from_email"],
         'notification_destination_email' => $_POST["notification_destination_email"],
         'email_subject_confirmation_to_user' => $_POST["email_subject_confirmation_to_user"],
         'email_confirmation_to_user' => $_POST["email_confirmation_to_user"],
         'email_subject_notification_to_admin' => $_POST["email_subject_notification_to_admin"],
         'email_notification_to_admin' => $_POST["email_notification_to_admin"],

         'dexcv_enable_captcha' => 'false',
         'dexcv_width' => $_POST["dexcv_width"],
         'dexcv_height' => $_POST["dexcv_height"],
         'dexcv_chars' => $_POST["dexcv_chars"],
         'dexcv_min_font_size' => $_POST["dexcv_min_font_size"],
         'dexcv_max_font_size' => $_POST["dexcv_max_font_size"],
         'dexcv_noise' => $_POST["dexcv_noise"],
         'dexcv_noise_length' => $_POST["dexcv_noise_length"],
         'dexcv_background' => $_POST["dexcv_background"],
         'dexcv_border' => $_POST["dexcv_border"],
         'dexcv_font' => $_POST["dexcv_font"],
         'cp_cal_checkboxes' => ''
	);
    $wpdb->update ( DEX_RESERVATIONS_CONFIG_TABLE_NAME, $data, array( 'id' => CP_CALENDAR_ID ));
}


add_action( 'init', 'dex_reservations_calendar_load2', 11 );
add_action( 'init', 'dex_reservations_calendar_update2', 11 );

function dex_reservations_calendar_load2() {
    global $wpdb;
	if ( ! isset( $_GET['dex_reservations_calendar_load2'] ) || $_GET['dex_reservations_calendar_load2'] != '1' )
		return;
    @ob_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    $calid = str_replace  (TDE_RESERVATIONCAL_PREFIX, "",$_GET["id"]);
    $query = "SELECT * FROM ".TDE_RESERVATIONCALENDAR_DATA_TABLE." where ".TDE_RESERVATIONDATA_IDCALENDAR."='".$calid."'";
    $row_array = $wpdb->get_results($query,ARRAY_A);
    foreach ($row_array as $row)
    {        
        $d1 =  date("m/d/Y", strtotime($row[TDE_RESERVATIONDATA_DATETIME_S])); 
        $d2 =  date("m/d/Y", strtotime($row[TDE_RESERVATIONDATA_DATETIME_E]));

        echo $d1."-".$d2."\n";
        echo $row[TDE_RESERVATIONDATA_TITLE]."\n";
        echo $row[TDE_RESERVATIONDATA_DESCRIPTION]."\n*-*\n";
    }

    exit();
}


function dex_reservations_calendar_update2() {
    global $wpdb, $user_ID;
 
    if ( ! current_user_can('edit_pages') )
        return;
 
	if ( ! isset( $_GET['dex_reservations_calendar_update2'] ) || $_GET['dex_reservations_calendar_update2'] != '1' )
		return;
 
    @ob_clean();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    if ( $user_ID )
    {       
        if (isset($_POST["xmldates"]))
        {         
            $calid = str_replace (TDE_RESERVATIONCAL_PREFIX, "",$_GET["id"]);        
            $items = explode("*-*\n", $_POST["xmldates"]);
            $wpdb->query("DELETE FROM ".TDE_RESERVATIONCALENDAR_DATA_TABLE."");
            foreach ($items as $item)
                if (trim($item) != '')
                {                            
                    $data = explode("\n", $item);
                    $d1 =  explode("-", $data[0]);                
	                $datetime_s = date("Y-m-d H:i:s", strtotime($d1[0]));
	                $datetime_e = date("Y-m-d H:i:s", strtotime($d1[1]));
	                $title = $data[1];
                    $description = "";
                    for ($j=2;$j<count($data);$j++)
                    {
                        $description .= $data[$j];
                        if ($j!=count($data)-1)
                            $description .= "\n";
                    }
                    $wpdb->query("insert into ".TDE_RESERVATIONCALENDAR_DATA_TABLE."(".TDE_RESERVATIONDATA_IDCALENDAR.",".TDE_RESERVATIONDATA_DATETIME_S.",".TDE_RESERVATIONDATA_DATETIME_E.",".TDE_RESERVATIONDATA_TITLE.",".TDE_RESERVATIONDATA_DESCRIPTION.") values(".$calid.",'".$datetime_s."','".$datetime_e."','".esc_sql($title)."','".esc_sql($description)."') ");
                }    
        }
    }

    exit();
}


function cp_reservation_get_site_url($admin = false)
{
    $blog = get_current_blog_id();
    if( $admin ) 
        $url = get_admin_url( $blog );	
    else 
        $url = get_home_url( $blog );	

    $url = parse_url($url);
    $url = rtrim(@$url["path"],"/");
    return $url;
}

function cp_reservation_get_FULL_site_url($admin = false)
{
    $blog = get_current_blog_id();
    if( $admin ) 
        $url = get_admin_url( $blog );	
    else 
        $url = get_home_url( $blog );	

    $url = parse_url($url);
    $url = rtrim($url["path"],"/");
    $pos = strpos($url, "://");    
    if ($pos === false)
        $url = 'http://'.$_SERVER["HTTP_HOST"].$url;
    return $url;
}


// dex_dex_reservations_get_option:
$dex_option_buffered_item = false;
$dex_option_buffered_id = -1;

function dex_reservations_get_option ($field, $default_value)
{
    global $wpdb, $dex_option_buffered_item, $dex_option_buffered_id;
    if ($dex_option_buffered_id == CP_CALENDAR_ID)
        $value = $dex_option_buffered_item->$field;
    else
    {
       $myrows = $wpdb->get_results( "SELECT * FROM ".DEX_RESERVATIONS_CONFIG_TABLE_NAME." WHERE id=".CP_CALENDAR_ID );
       $value = $myrows[0]->$field;
       $dex_option_buffered_item = $myrows[0];
       $dex_option_buffered_id  = CP_CALENDAR_ID;
    }
    if ($value == '' && $dex_option_buffered_item->calendar_language == '')
        $value = $default_value;
    return $value;
}

function cp_reservation_is_administrator()
{
    return current_user_can('manage_options');
}

?>