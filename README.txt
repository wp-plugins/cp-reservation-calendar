=== CP Reservation Calendar ===
Contributors: codepeople
Donate link: http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form
Tags: reservation calendar,booking calendar,bookings,reservations,paypal,calendar,reservation,booking,hotel,room
Requires at least: 3.0.5
Tested up to: 3.7
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

CP Reservation Calendar is a booking calendar that allows selecting dates - ex: check-in and check-out dates - for a reservation. 

== Description ==

CP Reservation Calendar is a booking calendar that allows selecting dates - ex: check-in and check-out dates - for a reservation. 

= Main Features: =

1. The reservation calendar supports **partial days** and **complete days** reservations
2. Booking form integrated with payment options
3. Email notifications 
4. Easy setup
5. Multiple configuration options
6. One-click publishing process 

This **booking calendar** can be used for hotel bookings, tour bookings, car rentals, office rentals, jewels rentals, cellphone rentals, etc. It's **integrated with PayPal** for receiving the reservation payments and has many other features (details below).

The reservation calendar can be configured in two modes: "complete day" or "partial day" bookings. *Complete day* means that the first and the last days booked are charged as full days while *Partial Day* means that they are charged as half-days only. Partial Day system is widely used by hotels and car rental systems: the customer is charged half a daily rate for both the arrival/pick-up day and the departure/drop-off day, thereby matching the number of nights actually spent in the hotel or the 24 hour days using the service.

= More Features: =

* The website visitors can **select a start date and end date for the reservation** and pay for it through **PayPal / credit cards**.
* The amount to pay is **calculated** based in the number of days of the reservation.
* Once a reservation has been booked it appears as blocked in order to **prevent duplicated bookings**.
* You receive an **email** after each confirmed (paid) booking.
* The user receives a **thank you/confirmation email** after completing the payment.
* Allows **customizing the contents** of the notification/confirmation emails.
* Allows defining the product name at PayPal, the currency, the PayPal language and amount to pay for a booking (you can set zero to let the user pay/donate the desired amount).
* You can define the **start day** of the week.
* You can define the **minimum available date** and the **maximum available date** for the booking calendar.
* You can **block specific dates**.
* You can **assign a user** to the calendar. The owner (with Editor Access Level) can edit only their own calendar.
* You can **publish the calendars of a specific user** with the shorttag *[CP_RESERVATION_CALENDAR user="admin"]*
* You can **publish a specific calendar** with the shorttag *[CP_RESERVATION_CALENDAR calendar="1"]*
* Can be configured in two modes: **"complete day"** or **"partial day"** bookings.
* Easy Ajax administration for the calendar.

== Installation ==

To install **CP Reservation Calendar**, follow these steps:

1.	Download and unzip the CP Reservation Calendar plugin
2.	Upload the entire cp-reservation-calendar/ directory to the /wp-content/plugins/ directory
3.	Activate the  CP Reservation Calendar plugin through the Plugins menu in WordPress
4.	Configure the booking calendar settings at the administration menu >> Settings >> CP Reservation Calendar.
5.	To insert the reservation calendar form into some content or post use the icon that will appear when editing contents

To update the plugin you can either overwrite the files or upload it via Plugins - Add New - Upload.

== Frequently Asked Questions ==

= Q: What means each field in the booking calendar settings area? =

A: The product's page contains detailed information about each field and customization:

http://wordpress.dwbooster.com/calendars/cp-reservation-calendar

= Q: How can I change the calendar's size and colors? =

A: Go to the file "cp-reservation-calendar/TDE_RCalendar/all-css.css" and edit the following styles:

Line #13 - style for the external border; background and border:

    .yui-calcontainer { 
      float:left;    padding:5px; background-color:#F7F9FB; border:1px solid #7B9EBD;
    }


Line #42 - style for width, height, border and background for all cells:

    .yui-calendar td.calcell {
      width:2em; height:2em; border:1px solid #E0E0E0; background-color:#FFF;
    }


Line #46 - style for the current month's cells:

    .yui-calendar td.calcell a {
      color:#003DB8; text-decoration:none; 
    }


Line #53 - style for the cells with days that do not belong to the current month:

    .yui-calendar td.calcell.oom {   
      cursor:default; color:#999; background-color:#EEE; border:1px solid #E0E0E0; 
    }


Line #81 - style cells with associated information (events, links):

    .yui-calendar td.calcell.reserved {
      background-color:#FFff00;
    } 


Line #109 - style for day's names:

    .yui-calendar .calweekdaycell {
      color:#666; font-weight:normal;
    }
    
= Q: I'm getting this message: "Destination folder already exists". Solution? =

A: The currently installed version of the plugin (if any) must be deleted before installing a new version.

This is a safe step, the plugin's data and settings won't be lost during the process.

Another alternative is to overwrite the plugin files through a FTP connection. This is also a safe step.
    
== Screenshots ==

1. Inserting the reservation calendar into a page.
2. Booking form/reservation form.
3. Booking calendar configuration and administration.

== Changelog ==

= 1.0 =
* First stable version released.

= 1.0.1 =
* Little bugs fixed
* More configuration settings added
* Compatible with WP 3.6
* fixing tags

== Upgrade Notice ==

= 1.0.1 =
New configuration settings and improvements.