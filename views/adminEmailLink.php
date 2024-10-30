<?php
	include_once(dirname(dirname(dirname(dirname(dirname( __FILE__ ))))) . '/wp-config.php' );
	include_once 'mailmanagement.php';
	$bookingId = $_GET['id'];
	global $wpdb;
	$bookingDetail = $wpdb->get_row
	(
	 	$wpdb->prepare
	 	(
			"SELECT CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable().
			".CustomerLastName) as ClientName,".customersTable().".CustomerEmail,".customersTable().".CustomerMobile,". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceId,".bookingTable().".BookingDate,". bookingTable().".TimeSlot,
			". bookingTable().".BookingId, ". bookingTable().".PaymentStatus, ". bookingTable().".TransactionId, ". bookingTable().".PaymentDate,". bookingTable().
			".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
			".CustomerId= ".customersTable().".CustomerId ". "  LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().
			".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".BookingId =  ".$bookingId
		)
	);
	$dateFormat = $wpdb -> get_var
	(
		$wpdb->prepare
		(
			'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
			"default_Date_Format"
		)
	);											
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
	$getHours = floor(($bookingDetail->TimeSlot)/60);
	$getMins = ($bookingDetail->TimeSlot) % 60;
	$hourFormat = $getHours . ":" . "00";
	$timeFormats = $wpdb->get_var("SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = 'default_Time_Format'");
	if($timeFormats == 0)
	{
		$time  = DATE("g:i a", STRTOTIME($hourFormat));
	}
	else 
	{
		$time  = DATE("H:i", STRTOTIME($hourFormat));
	}
if($_REQUEST['action'] == "ApprovedLink")
{
	
	echo "<p style=\"color: green; font-style: italic; clear: both;\">Booking has been Confirmed successfully.
	<br /><br />
	Booking Details:
	<br />
	<br />
	Client Name: ".$bookingDetail->ClientName."
	<br />
	Client Email: ".$bookingDetail->CustomerEmail."
	<br />
	Client Mobile Number: ".$bookingDetail->CustomerMobile."
	<br />
	Booking Date: ".$date."
	<br />
	Booking Time: ".$time."
	<br />
	Booking Service Name: ".$bookingDetail->ServiceName."
	<br />
	Booking Service Provider: ".$bookingDetail->EmployeeName."
	</p>";
	 $wpdb->query
	 (
		$wpdb->prepare
		(
			"UPDATE ".bookingTable()." SET BookingStatus = %s WHERE BookingId = %d",
			"Approved",
			$bookingId
		)
	 );
	MailManagement($bookingId,"approved");
}

else if($_REQUEST['action'] == "DisapproveLink")
{
	echo "<p style=\"color: red; font-style: italic; clear: both;\">Booking has been Dissapproved successfully.
	<br /><br />
	Booking Details:
	<br />
	<br />
	Client Name: ".$bookingDetail->ClientName."
	<br />
	Client Email: ".$bookingDetail->CustomerEmail."
	<br />
	Client Mobile Number: ".$bookingDetail->CustomerMobile."
	<br />
	Booking Date: ".$date."
	<br />
	Booking Time: ".$time."
	<br />
	Booking Service Name: ".$bookingDetail->ServiceName."
	<br />
	Booking Service Provider: ".$bookingDetail->EmployeeName."
	</p>";
	$wpdb->query
	 (
	      $wpdb->prepare
	      (
	           "UPDATE ".bookingTable()." SET BookingStatus = %s WHERE BookingId = %d",
	           "Disapproved",
	           $bookingId
	      )
	 );
	MailManagement($bookingId,"disapproved");
}
?>