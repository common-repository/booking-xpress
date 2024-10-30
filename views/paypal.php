<?php
	include_once(dirname(dirname(dirname(dirname(dirname( __FILE__ ))))) . '/wp-config.php' );
/*  PHP Paypal IPN Integration Class Demonstration File
 *  4.16.2005 - Micah Carrick, email@micahcarrick.com
 *
 *  This file demonstrates the usage of paypal.class.php, a class designed  
 *  to aid in the interfacing between your website, paypal, and the instant
 *  payment notification (IPN) interface.  This single file serves as 4 
 *  virtual pages depending on the "action" varialble passed in the URL. It's
 *  the processing page which processes form data being submitted to paypal, it
 *  is the page paypal returns a user to upon success, it's the page paypal
 *  returns a user to upon canceling an order, and finally, it's the page that
 *  handles the IPN request from Paypal.
 *
 *  I tried to comment this file, aswell as the acutall class file, as well as
 *  I possibly could.  Please email me with questions, comments, and suggestions.
 *  See the header of paypal.class.php for additional resources and information.
*/

// Setup class
require_once('paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = 'https://sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
          
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

// if there is not action variable, set the default action of 'process'
if(isset($_REQUEST['action']))
{
	
	switch ($_REQUEST['action']) 
	{
		case 'process':		// Process and order
			
			$return_url = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable(). ' WHERE PaymentGatewayKey = %s',
						 'paypal-thankyou-page-url'
					)
				);
			
			//$cancel_url = plugins_url('/paypal.php', __FILE__);
			$marchantidd = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable(). ' WHERE PaymentGatewayKey = %s',
						 'paypal-merchant-email-address'
					)
				);
				$cancelPage = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable(). ' WHERE PaymentGatewayKey = %s',
						 'paypal-payment-cancellation-Url'
					)
				);
			$servicesDetail = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT ServiceName FROM ' . servicesTable(). ' WHERE ServiceId = %d',
						 intval($_REQUEST['serviceid'])
					)
				);
			
			$servicesDetail;
			$currcode = esc_attr(!isset($_REQUEST['currency_code'])) ? "" :  esc_attr($_REQUEST['currency_code']);
			$first_name = esc_attr(!isset($_REQUEST['first_name'])) ? "" :  esc_attr($_REQUEST['first_name']);
			$last_name = esc_attr(!isset($_REQUEST['last_name'])) ? "" :  esc_attr($_REQUEST['last_name']);
			$phno = esc_attr(!isset($_REQUEST['H_PhoneNumber'])) ? "" :  esc_attr($_REQUEST['H_PhoneNumber']);
			$email = esc_attr(!isset($_REQUEST['email'])) ? "" :  esc_attr($_REQUEST['email']);
			$address1 = esc_attr(!isset($_REQUEST['address1'])) ? "" :  esc_attr($_REQUEST['address1']);
			$address2 = esc_attr(!isset($_REQUEST['address2'])) ? "" :  esc_attr($_REQUEST['address2']);
			$city = esc_attr(!isset($_REQUEST['city'])) ? "" :  esc_attr($_REQUEST['city']);
			$zip = esc_attr(!isset($_REQUEST['zip'])) ? "" :  esc_attr($_REQUEST['zip']);
			$payer_email = esc_attr(!isset($_REQUEST['payer_email'])) ? "" :  esc_attr($_REQUEST['payer_email']);
			$item_number = esc_attr($_REQUEST['item_number']);
			$TotalCost = intval($_REQUEST['TotalCost']);					
			$cancel_url .= $cancelPage;
			
	      // There should be no output at this point.  To process the POST data,
	      // the submit_paypal_post() function will output all the HTML tags which
	      // contains a FORM which is submited instantaneously using the BODY onload
	      // attribute.  In other words, don't echo or printf anything when you're
	      // going to be calling the submit_paypal_post() function.
	 
	      // This is where you would have your form validation  and all that jazz.
	      // You would take your POST vars and load them into the class like below,
	      // only using the POST values instead of constant string expressions.
	 
	      // For example, after ensureing all the POST variables from your custom
	      // order form are valid, you might have:
	      //
	      // $p->add_field('first_name', $_POST['first_name']);
	      // $p->add_field('last_name', $_POST['last_name']);     
	      $p->add_field('business', $marchantidd);
	      $p->add_field('return', $return_url);
	      $p->add_field('cancel_return', $cancel_url);
	      $p->add_field('notify_url', $this_script.'?action=ipn');
	      $p->add_field('item_name', $servicesDetail);
	      $p->add_field('cmd', '_xclick');
		  $p->add_field('no_note', '1');
		  $p->add_field('currency_code', $currcode);
		  $p->add_field('first_name', $first_name);
		  $p->add_field('last_name', $last_name);
		  $p->add_field('H_PhoneNumber', $phno);
		  $p->add_field('email', $email);
		  $p->add_field('address1', $address1);
		  $p->add_field('address2', $address2);
		  $p->add_field('city', $city);
		  $p->add_field('zip', $zip);
		  $p->add_field('amount', $TotalCost);
		  $p->add_field('payer_email', $payer_email);
		  $p->add_field('item_number', $item_number);
		  $p->submit_paypal_post(); // submit the fields to paypal
	      //$p->dump_fields();      // for debugging, output a table of all the fields
	      break;
		  
	    case 'ipn':   // Paypal is calling page for IPN validation...
	   			$transactionId = $_POST['txn_id'];
				$bookingId = $_POST['item_number'];
				$paymentStatus = $_POST['payment_status'];
				$dt = $_POST['payment_date'];
				$t = explode(":", $dt);
				$r = explode(" ", $t[2]);
				$s = explode(" ", $r[2]);
				$u = explode(",", $s[0]);
				$time = $t[0].":".$t[1].":".$r[0];
				$nmonth = date('m',strtotime($r[1]));
				$datet = $r[3]."-".$nmonth."-".$u[0]." " .$time;
				$timestamp = strtotime($datet);
				$finaldate =  date("Y-m-d H:i:s", $timestamp);
				
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE ".bookingTable()." SET TransactionId = ". '"' . $transactionId . '"' . ", PaymentStatus = ". '"' . $paymentStatus . '"' . ", PaymentDate = ". '"' . $finaldate . '"' . "  WHERE BookingId  = " . '"' . $bookingId . '"'
					)
				);
				$p->validate_ipn();
				if($paymentStatus == "Completed")
				{
					require_once('mailmanagement.php');
					MailManagement($bookingId,"approval_pending");
					MailManagement($bookingId,"admin");
				}
		break;
	}
}
else if(isset($_REQUEST['cancellationPage']))
{
			$bookingId =  $_REQUEST['cancellationPage'];
			$bookingMailData = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM " . bookingTable() . " WHERE BookingId =". '"' . $bookingId . '"'
				)
			);
			$servicemaildata = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * From  " . servicesTable() . "  WHERE ServiceId =". '"' .  $bookingMailData->ServiceId . '"'
				)
			);
			$serviceName =  $_REQUEST['serviceName'];
			$paystatus = "Cancelled";			
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".bookingTable()." SET PaymentStatus = ". '"' . $paystatus . '"' . ", BookingStatus = ". '"' . $paystatus . '"' . "  WHERE BookingId = " . '"' . $bookingId . '"'
				)
			);
}     
?>