<?php
function MailManagement($bookingId,$action)
{
	global $wpdb;
	$url = TBP_BK_PLUGIN_URL.'/views'; 
	$bookingDetail = $wpdb->get_row
	(
		$wpdb->prepare
		(
			"SELECT CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable().".CustomerLastName) as CustomerName,".customersTable().".CustomerEmail,".customersTable().".CustomerMobile,
			". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceId,".servicesTable().".ServiceFullDay,".servicesTable().".ServiceColorCode,".servicesTable().".ServiceStartTime, ".servicesTable().".ServiceEndTime,
			".bookingTable().".BookingDate ,". bookingTable().".TimeSlot,". bookingTable().".BookingId, ". bookingTable().".PaymentStatus, ". bookingTable().".TransactionId, 
			". bookingTable().".PaymentDate,". bookingTable().".BookingStatus FROM ".bookingTable()." 
			LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().".CustomerId= ".customersTable().".CustomerId ". " 
			LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".BookingId =  %d",
			$bookingId
		)
	);
	$multipleBookings = $wpdb->get_results
	(
		$wpdb->prepare
		(
			"SELECT ".multiple_bookingTable().".bookingDate FROM ".multiple_bookingTable()." JOIN ".bookingTable()." ON ".multiple_bookingTable().".bookingId = 
			".bookingTable().".BookingId WHERE ".multiple_bookingTable().".bookingId = %d ORDER By ".multiple_bookingTable().".bookingDate ",
			$bookingId
		)
	);
	$dateFormat = $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
			"default_Date_Format"
		)
	);
	$payenable= $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() .' where PaymentGatewayKey = %s',
			"paypal-enabled"
		)
	);
	if($bookingDetail->ServiceFullDay  == 1)
	{
		$dateFormat = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
				"default_Date_Format"
			)
		);
		$date = "";
		for($flag=0; $flag < count($multipleBookings); $flag++)
		{
			if($dateFormat == 0)
			{
				$dateFormat =  date("M d, Y", strtotime($multipleBookings[$flag]->bookingDate));
			}
			else if($dateFormat == 1)
			{
				$dateFormat =  date("Y/m/d", strtotime($multipleBookings[$flag]->bookingDate));
			}
			else if($dateFormat == 2)
			{
				$dateFormat = date("m/d/Y", strtotime($multipleBookings[$flag]->bookingDate));
			}
			else if($dateFormat == 3)
			{
				$dateFormat =  date("d/m/Y", strtotime($multipleBookings[$flag]->bookingDate));
			}
			if($flag < count($multipleBookings) - 1)
			{
				$date .= $dateFormat. ", ";
			}
			else 
			{
				$date .= $dateFormat;
			}
		}
		$time = "";
		$at = "";
	}
	else 
	{
		$timeFormats = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
				'default_Time_Format'
			)
		);
		$getHours = floor(($bookingDetail->TimeSlot)/60);
		$getMins = ($bookingDetail->TimeSlot) % 60;
		$hourFormat = $getHours . ":" . $getMins;
		if($timeFormats == 0)
		{
			$time  = DATE("g:i a", STRTOTIME($hourFormat));
		}
		else 
		{
			$time  = DATE("H:i", STRTOTIME($hourFormat));
		}
		if($dateFormat == 0)
		{
			$date =  date("M d, Y", strtotime($bookingDetail->BookingDate));
		}
		else if($dateFormat == 1)
		{
			$date =   date("Y/m/d", strtotime($bookingDetail->BookingDate));
		}
		else if($dateFormat == 2)
		{
			$date =  date("m/d/Y", strtotime($bookingDetail->BookingDate));
		}
		else if($dateFormat == 3)
		{
			$date =  date("d/m/Y", strtotime($bookingDetail->BookingDate));
		}
		$at = "at";
	}
	$title=get_bloginfo('name');
	$admin_email = get_option('admin_email');
	$to = $bookingDetail->CustomerEmail;
	$paymentStatus = $bookingDetail->PaymentStatus;
	$paymenTtransId = $bookingDetail->TransactionId;
	$paymentDate = $bookingDetail->PaymentDate;
	$currentDateComputer = date("Y-m-d");
	if($dateFormat == 0)
	{
		$currentDate =  date("M d, Y", strtotime($currentDateComputer));
	}
	else if($dateFormat == 1)
	{
		$currentDate =   date("Y/m/d", strtotime($currentDateComputer));
	}
	else if($dateFormat == 2)
	{
		$currentDate =  date("m/d/Y", strtotime($currentDateComputer));
	}
	else if($dateFormat == 3)
	{
		$currentDate =  date("d/m/Y", strtotime($currentDateComputer));
	}
	$space = "";
	if($action == "approved")
	{
		$emailContent = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailContent FROM  ' . email_templatesTable() . ' WHERE EmailType = %s',
				"booking-confirmation"
			)
		);
		$emailSubject = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailSubject FROM  ' . email_templatesTable() . ' WHERE EmailType = %s',
				"booking-confirmation"
			)
		);
		if($payenable == 1)
		{
			
			$message_1 = str_replace("[client_name]", $bookingDetail->CustomerName, stripcslashes($emailContent));
			$message_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $message_1);
			$message_3 = str_replace("[booked_time]", $time, $message_2);
			$message_4 = str_replace("[companyName]", $title, $message_3);
			$message_5 = str_replace("[booked_date]", $date, $message_4);
			$message_6 = str_replace("[Transaction Id:]","Transaction Id:", $message_5);
			$message_7 = str_replace("[Payment Date:]","Payment Date:", $message_6);
			$message_8 = str_replace("[Payment Status:]","Payment Status:", $message_7);
			$message_9 = str_replace("[payment_status]", $paymentStatus, $message_8);
			$message_10 = str_replace("[transaction_id]", $paymenTtransId, $message_9);
			$message_11 = str_replace("[payment_date]", $paymentDate, $message_10);
			$message = str_replace("[at]", $at, $message_11);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			$headers .= "Bcc: ".$bookingDetail->EmployeeEmail . "\n";
			wp_mail($to,$emailSubject,$message,$headers);
		}
		else
		{
			$message_1 = str_replace("[client_name]", $bookingDetail->CustomerName, stripcslashes($emailContent));
			$message_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $message_1);
			$message_3 = str_replace("[booked_time]", $time, $message_2);
			$message_4 = str_replace("[companyName]", $title, $message_3);
			$message_5 = str_replace("[booked_date]", $date, $message_4);
			$message_6 = str_replace("[date]", $currentDate, $message_5);
			$message_7 = str_replace("[Transaction Id:]",$space, $message_6);
			$message_8 = str_replace("[Payment Date:]",$space, $message_7);
			$message_9 = str_replace("[Payment Status:]",$space, $message_8);
			$message_10 = str_replace("[transaction_id]",$space, $message_9);
			$message_11 = str_replace("[payment_status]",$space, $message_10);
			$message_12 = str_replace("[payment_date]",$space, $message_11);
			$message = str_replace("[at]", $at, $message_12);
			$headers =  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			
			wp_mail($to,$emailSubject,$message,$headers);
		}
	}
/***********************************************************************************************************************************************************/
	else if($action == "disapproved")
	{
		$emailContent = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailContent FROM  ' . email_templatesTable() . ' WHERE EmailType = %s ',
				"booking-disapproved"
			)
		);
		$emailSubject = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailSubject FROM  ' . email_templatesTable() . ' WHERE EmailType = %s' ,
				"booking-disapproved"
			)
		);
		if($payenable == 1)
		{
			$msg_1 = str_replace("[first name]", $bookingDetail->CustomerName, stripcslashes($emailContent));
			$msg_2 = str_replace("[service]", $bookingDetail->ServiceName, $msg_1);
			$msg_3 = str_replace("[date]", $date, $msg_2);
			$msg_4= str_replace("[time]", $time, $msg_3);
			$msg_5 = str_replace("[companyName]", $title, $msg_4);
			$msg_6 = str_replace("[Transaction Id:]","Transaction Id:", $msg_5);
			$msg_7 = str_replace("[Payment Date:]","Payment Date:", $msg_6);
			$msg_8 = str_replace("[Payment Status:]","Payment Status:", $msg_7);
			$msg_9 = str_replace("[payment_status]", $paymentStatus, $msg_8);
			$msg_10 = str_replace("[transaction_id]", $paymenTtransId, $msg_9);
			$msg_11 = str_replace("[payment_date]", $paymentDate, $msg_10);
			$message = str_replace("[at]", $at, $msg_11);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			wp_mail($to,$emailSubject, $message, $headers);
		}
		else
		{
			$msg_1 = str_replace("[first name]", $bookingDetail->CustomerName, stripcslashes($emailContent));
			$msg_2 = str_replace("[service]", $bookingDetail->ServiceName, $msg_1);
			$msg_3 = str_replace("[date]", $date, $msg_2);
			$msg_4= str_replace("[time]", $time, $msg_3);
			$msg_5 = str_replace("[companyName]", $title, $msg_4);
			$msg_6 = str_replace("[Transaction Id:]",$space, $msg_5);
			$msg_7 = str_replace("[Payment Date:]",$space, $msg_6);
			$msg_8 = str_replace("[Payment Status:]",$space, $msg_7);
			$msg_9 = str_replace("[transaction_id]",$space, $msg_8);
			$msg_10 = str_replace("[payment_status]",$space, $msg_9);
			$msg_11 = str_replace("[payment_date]",$space, $msg_10);
			$message = str_replace("[at]", $at, $msg_11);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			wp_mail($to,$emailSubject, $message, $headers);
		}
	}
/***********************************************************************************************************************************************************/
	else if($action == "approval_pending")
	{
		$emailContent = $wpdb->get_var
		(
			$wpdb->prepare
			(
			'SELECT EmailContent FROM  ' . email_templatesTable() . ' WHERE EmailType = %s',
			"booking-pending-confirmation"
			)
		);
		$emailSubject = $wpdb->get_var
		(
			$wpdb->prepare
			(
			'SELECT EmailSubject FROM  ' . email_templatesTable() . ' WHERE EmailType = %s ' , 
			"booking-pending-confirmation"
			)
		);
		if($payenable == 1)
		{
			$message_1 = str_replace("[client_name]",  $bookingDetail->CustomerName, stripcslashes($emailContent));
			$message_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $message_1);
			$message_3 = str_replace("[booked_time]", $time, $message_2);
			$message_4 = str_replace("[companyName]", $title, $message_3);
			$message_5 = str_replace("[booked_date]", $date, $message_4);
			$message_6 = str_replace("[Transaction Id:]","Transaction Id:", $message_5);
			$message_7 = str_replace("[Payment Date:]","Payment Date:", $message_6);
			$message_8 = str_replace("[Payment Status:]","Payment Status:", $message_7);
			$message_9 = str_replace("[payment_status]", $paymentStatus, $message_8);
			$message_10 = str_replace("[transaction_id]", $paymenTtransId, $message_9);
			$message_11 = str_replace("[payment_date]", $paymentDate, $message_10);
			$message_final = str_replace("[At :]", $at, $message_11);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			wp_mail($to,$emailSubject,$message_final,$headers);
		}
		else
		{
			$message_1 = str_replace("[client_name]",  $bookingDetail->CustomerName, stripcslashes($emailContent));
			$message_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $message_1);
			$message_3 = str_replace("[booked_time]", $time, $message_2);
			$message_4 = str_replace("[companyName]", $title, $message_3);
			$message_5 = str_replace("[booked_date]", $date, $message_4);
			$message_6 = str_replace("[Transaction Id:]",$space, $message_5);
			$message_7 = str_replace("[Payment Date:]",$space, $message_6);
			$message_8 = str_replace("[Payment Status:]",$space, $message_7);
			$message_9 = str_replace("[transaction_id]",$space, $message_8);
			$message_10 = str_replace("[payment_status]",$space, $message_9);
			$message_11 = str_replace("[payment_date]",$space, $message_10);
			$message_final = str_replace("[At :]", $at, $message_11);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			
			wp_mail($to,$emailSubject,$message_final,$headers);
		}
	}
/***********************************************************************************************************************************************************/
	else if($action == "admin")
	{
		$emailContent = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailContent FROM  ' . email_templatesTable() . ' WHERE EmailType = %s ' ,
				"admin-control"
			)
		);
		$emailSubject = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailSubject FROM  ' . email_templatesTable() . ' WHERE EmailType = %s',
				"admin-control"
			)
		);
		if($payenable == 1 )
		{
			$msg_1 = str_replace("[client_name]", $bookingDetail->CustomerName, stripcslashes($emailContent));
			$msg_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $msg_1);
			$msg_3 = str_replace("[booked_time]", $time, $msg_2);
			$msg_4= str_replace("[booked_date]", $date, $msg_3);
			$msg_5 = str_replace("[payment_status]", $paymentStatus, $msg_4);
			$msg_6 = str_replace("[transaction_id]", $paymenTtransId, $msg_5);
			$msg_7 = str_replace("[payment_date]", $paymentDate, $msg_6);
			$msg_8 = str_replace("[Transaction Id:]","Transaction Id:", $msg_7);
			$msg_9 = str_replace("[Payment Date:]","Payment Date:", $msg_8);
			$msg_10 = str_replace("[Payment Status:]","Payment Status:", $msg_9);
			$approve = "<a href=\"$url/adminEmailLink.php?action=ApprovedLink&id=".$bookingId."\">Confirm Booking</a>";
			$msg_11 = str_replace("[approve]", $approve, $msg_10);
			$disapprove = "<a href=\"$url/adminEmailLink.php?action=DisapproveLink&id=".$bookingId."\">Decline Booking</a>";
			$msg_12 = str_replace("[deny]", $disapprove, $msg_11);
			$msg_13 = str_replace("[email_address]", $bookingDetail->CustomerEmail, $msg_12);
			$msg_14 = str_replace("[mobile_number]", $bookingDetail->CustomerMobile, $msg_13);
			$msg_15 = str_replace("[companyName]", $title, $msg_14);
			$msg_16 = str_replace("[at]", $at, $msg_15);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			wp_mail($admin_email,$emailSubject,$msg_16,$headers);
		}
		else
		{
			$msg_1 = str_replace("[client_name]", $bookingDetail->CustomerName, stripcslashes($emailContent));
			$msg_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $msg_1);
			$msg_3 = str_replace("[booked_time]", $time, $msg_2);
			$msg_4= str_replace("[booked_date]", $date, $msg_3);
			echo $approve = "<a href=\"$url/adminEmailLink.php?action=ApprovedLink&id=".$bookingId."\">Confirm Booking</a>";
			$msg_5 = str_replace("[approve]", $approve, $msg_4);
			$disapprove = "<a href=\"$url/adminEmailLink.php?action=DisapproveLink&id=".$bookingId."\">Decline Booking</a>";
			$msg_6 = str_replace("[deny]", $disapprove, $msg_5);
			$msg_7 = str_replace("[email_address]", $bookingDetail->CustomerEmail, $msg_6);
			$msg_8 = str_replace("[mobile_number]", $bookingDetail->CustomerMobile, $msg_7);
			$msg_9 = str_replace("[Transaction Id:]",$space, $msg_8);
			$msg_10 = str_replace("[Payment Date:]",$space, $msg_9);
			$msg_11 = str_replace("[Payment Status:]",$space, $msg_10);
			$msg_12 = str_replace("[transaction_id]",$space, $msg_11);
			$msg_13 = str_replace("[payment_status]",$space, $msg_12);
			$msg_14 = str_replace("[payment_date]",$space, $msg_13);
			$msg_15 = str_replace("[companyName]", $title, $msg_14);
			$msg_16 = str_replace("[at]", $at, $msg_15);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			wp_mail($admin_email,$emailSubject,$msg_16,$headers);
		}
	}
/***********************************************************************************************************************************************************/
	else if($action == "notification")
	{
		$emailContent = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailContent FROM  ' . email_templatesTable() . ' WHERE EmailType = %s ' ,
				"paypal-payment-notification"
			)
		);
		$emailSubject = $wpdb->get_var
		 (
		   	$wpdb->prepare
		   	(
		    	'SELECT EmailSubject FROM  ' . email_templatesTable() . ' WHERE EmailType = %s',
		    	"paypal-payment-notification"
		   	)
		  );
		$msg_1 = str_replace("[client_name]", $bookingDetail->CustomerName, stripcslashes($emailContent));
		$msg_2 = str_replace("[service_name]", $bookingDetail->ServiceName, $msg_1);
		$msg_3 = str_replace("[booked_time]", $time, $msg_2);
		$msg_4= str_replace("[booked_date]", $date, $msg_3);
		$msg_5 = str_replace("[email_address]", $bookingDetail->CustomerEmail, $msg_4);
		$msg_6 = str_replace("[mobile_number]", $bookingDetail->CustomerMobile, $msg_5);
		$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
		"Content-Type: text/html; charset=\"" .
		get_option('blog_charset') . "\n";
		wp_mail($admin_email,$emailSubject,$msg_6,$headers);
	}
}
?>