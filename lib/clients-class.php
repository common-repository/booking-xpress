<?php
if (!current_user_can('edit_posts') && ! current_user_can('edit_pages') )
{
	return;
}
else 
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']) && isset($_REQUEST['action']))
	{
		if($_REQUEST['param'] == "editcustomers")
		{
			$customerId = intval($_REQUEST['CustomerId']);
			$customer = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".customersTable()." where CustomerId = %d",
					$customerId
				)
			);
			?>
			<div style="float:left;width:50%">
				<div class="row">
					<label><?php _e( "First Name :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditFirstName" id="uxEditFirstName" value="<?php echo $customer->CustomerFirstName;?>"/>
					</div>
				</div>
				<div class="row">
					<label ><?php _e( "Last Name :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditLastName" id="uxEditLastName" value="<?php echo $customer->CustomerLastName;?>"/>
					</div>
				</div>
				<div class="row">
					<label><?php _e( "Email :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditEmailAddress" id="uxEditEmailAddress" value= "<?php echo $customer->CustomerEmail;?>"/>
					</div>
				</div>
				<div class="row">
					<label ><?php _e( "Telephone :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required span12" name="uxEditTelephoneNumber" id="uxEditTelephoneNumber" value="<?php echo $customer->CustomerTelephone;?>"/>
					</div>
				</div>
				<div class="row">
					<label><?php _e( "Mobile :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required span12" name="uxEditMobileNumber" id="uxEditMobileNumber" value="<?php echo $customer->CustomerMobile;?>"/>
					</div>
				</div>
				<div class="row">
					<label><?php _e( "Skype Id :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required span12" name="uxEditSkypeId" id="uxEditSkypeId" value="<?php echo $customer->CustomerSkypeId;?>"/>
					</div>
				</div>
				<div class="row">
					<label><?php _e( "Address 1 :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required span12" name="uxEditAddress1" id="uxEditAddress1" value="<?php echo $customer->CustomerAddress1;?>"/>
					</div>
				</div>
			</div>
			<div style="float:left; width:50%">
				<div class="row">
					<label><?php _e( "Address 2 :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditAddress2" id="uxEditAddress2" value="<?php echo $customer->CustomerAddress2;?>"/>
					</div>
				</div>
				<div class="row">
					<label><?php _e( "City :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditCity" id="uxEditCity" value="<?php echo $customer->CustomerCity;?>"/>
					</div>
				</div>
				<div class="row">
					<label><?php _e( "Post Code :", booking_xpress ); ?></label>
					<div class="right">
						<input type="text" class="required" name="uxEditPostalCode" id="uxEditPostalCode" value= "<?php echo $customer->CustomerZipCode;?>"/>
					</div>
				</div>
				<div class="row">
					<label><?php _e( "Country :", booking_xpress ); ?></label>
						<div class="right">
							<select name="uxEditCountry" class="style required" id="uxEditCountry" style="margin-bottom:2px;width: 100%">
								<?php
								$country = $wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT CountryName,CountryId From ".countriesTable()." order by CountryName ASC"
									)
								);	
								$sel_country = $wpdb->get_var
								(
									$wpdb->prepare
									(
										"SELECT CountryName From ".countriesTable()." where CountryId = ".$customer->CustomerCountry
									)
								);
								for ($flagCountry = 0; $flagCountry < count($country); $flagCountry++)
								{
								?>
								<option value="<?php echo $country[$flagCountry]->CountryId;?>"><?php echo $country[$flagCountry]->CountryName;?></option>
								<?php 
								}
								?>
							</select>
							<script>
								jQuery('#uxEditCountry').val("<?php echo $customer->CustomerCountry;?>");
							</script>
						</div>
				</div>
				<div class="row">
					<label><?php _e( "Comments :", booking_xpress ); ?></label>
					<div class="right">
						<textarea class="required span12" name="uxEditComments" id="uxEditComments"  style="height:119px"><?php echo $customer->CustomerComments;?></textarea>
					</div>
				</div>
			</div>
			<input type="hidden" id="hiddenCustomerId" name="hiddenCustomerId" value="<?php echo $customer->CustomerId;?>" />
			<input type="hidden" id="hiddenCustomerName" name="hiddenCustomerName" value="<?php echo $customer->CustomerFirstName ." " . $customer->CustomerLastName ;?>" />
			<?php
			die();
		}
		else if($_REQUEST['param'] == 'updateCustomersComments')
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$uxCustomerComments = html_entity_decode($_REQUEST['uxCustomerComments']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".bookingTable()." SET Comments  = %s WHERE BookingId = %d",
					$uxCustomerComments,
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "DeleteCustomer")
		{
			$customerId = intval($_REQUEST['uxcustomerId']);
			$countBooking = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(BookingId) FROM ' . bookingTable() . ' where CustomerId =%d', 
					$customerId
				)
			);
			if($countBooking != 0)
			{
				echo "bookingExist";
			}
			else
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM ".customersTable()." WHERE CustomerId = %d",
						$customerId
					)
				);
			}
			die();
		}
		else if($_REQUEST['param']== 'customerBooking')
		{
			?>
			<table class="table table-striped" id="data-table-customer-bookings">
				<thead>
					<tr>
						<th><?php _e( "Service", booking_xpress ); ?></th>
						<th><?php _e( "Date", booking_xpress ); ?></th>
						<th><?php _e( "Time Slot", booking_xpress ); ?></th>
						<th><?php _e( "Status", booking_xpress ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$customerId  = intval($_REQUEST['CustomerId']);
					$customerNameReturn = $wpdb->get_row
					(
						$wpdb->prepare
						(
							"SELECT CustomerFirstName,CustomerLastName  FROM " .customersTable(). " where CustomerId = %d ",
							$customerId
						)
					);
					$customerBookingDetail = $wpdb->get_results
					(
						$wpdb->prepare
						(
							"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceColorCode, ". servicesTable(). ".ServiceFullDay,  ". servicesTable(). ".ServiceStartTime, ". servicesTable(). ".ServiceTotalTime,  ". servicesTable(). ".ServiceEndTime, 
							".bookingTable().".BookingDate,". bookingTable().".TimeSlot,". bookingTable().".Comments,". bookingTable().".CustomerId,". bookingTable().".DateofBooking,
							". bookingTable().".BookingStatus,". bookingTable().".BookingId from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
							".CustomerId= ".customersTable().".CustomerId ". " LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().
							".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".CustomerId =  %d
							ORDER BY ".bookingTable().".BookingDate asc",
							$customerId
						)
					);
					$dateFormat = $wpdb->get_var
					(
						$wpdb->prepare
						(
							'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s ',
							"default_Date_Format"
						)
					);
					$timeFormats = $wpdb->get_var
					(
						$wpdb->prepare
						(
							"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
							'default_Time_Format'
						)
					);
					for($flag = 0; $flag < count($customerBookingDetail); $flag++)
					{
						$multipleBookings = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"Select ".multiple_bookingTable().".bookingDate from ".multiple_bookingTable()." join 
								". bookingTable() ." on ".multiple_bookingTable().".bookingId = ". bookingTable() .".BookingId where ". bookingTable() .".CustomerId = %d
								and ".multiple_bookingTable().".bookingId = %d ORDER BY ".multiple_bookingTable().".bookingDate asc",
								$customerBookingDetail[$flag]->CustomerId,
								$customerBookingDetail[$flag]->BookingId
							)
						);
						$allocatedMultipleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto;\">";
						for($MBflag=0; $MBflag < count($multipleBookings); $MBflag++)
						{
							if($dateFormat == 0)
							{
								$dateFormat1 =  date("M d, Y", strtotime($multipleBookings[$MBflag]->bookingDate));
							}
							else if($dateFormat == 1)
							{
								$dateFormat1 =  date("Y/m/d", strtotime($multipleBookings[$MBflag]->bookingDate));
							}	
							else if($dateFormat == 2)
							{
								$dateFormat1 = date("m/d/Y", strtotime($multipleBookings[$MBflag]->bookingDate));
							}
							else if($dateFormat == 3)
							{
								$dateFormat1 =  date("d/m/Y", strtotime($multipleBookings[$MBflag]->bookingDate));
							}	
							$allocatedMultipleDates .= "<span style=\"margin-left:5px;background-color:".$customerBookingDetail[$flag]->ServiceColorCode.";color:#fff;border:solid 1px ".$customerBookingDetail[$flag]->ServiceColorCode . "\" class=\"tag\"><span>" . $dateFormat1 . "</span></span>";
						}
						$allocatedMultipleDates.= "</div>";
						?>
						<tr>
							<td><?php echo $customerBookingDetail[$flag]->ServiceName; ?></td>
							<?php
							if($customerBookingDetail[$flag]->ServiceFullDay  == 1)
							{
							?>
								<td><?php echo $allocatedMultipleDates;?></td>
							<?php
							}
							else
							{
								if($dateFormat == 0)
								{
								?>
								<td><?php echo date("M d, Y", strtotime($customerBookingDetail[$flag]->BookingDate));?></td>
								<?php
								}
								else if($dateFormat == 1)
								{
								?>
									<td><?php echo date("Y/m/d", strtotime($customerBookingDetail[$flag]->BookingDate));?></td>
								<?php
								}
								else if($dateFormat == 2)
								{
								?>
								<td><?php echo date("m/d/Y", strtotime($customerBookingDetail[$flag]->BookingDate));?></td>
								<?php
								}	
								else if($dateFormat == 3)
								{
								?>
								<td><?php echo date("d/m/Y", strtotime($customerBookingDetail[$flag]->BookingDate));?></td>
								<?php
								}
							}
							?>
							<?php
							$getHours_bookings = floor(($customerBookingDetail[$flag] -> TimeSlot)/60);
							$getMins_bookings = ($customerBookingDetail[$flag] -> TimeSlot) % 60;
							$hourFormat_bookings = $getHours_bookings . ":" . "00";
								if($timeFormats == 0)
								{
									$time_in_12_hour_format_bookings  = DATE("g:i a", STRTOTIME($hourFormat_bookings));
								}
								else 
								{
									$time_in_12_hour_format_bookings  = DATE("H:i", STRTOTIME($hourFormat_bookings));
								}
								if($getMins_bookings!=0)
								{
									$hourFormat_bookings = $getHours_bookings . ":" . $getMins_bookings;
									if($timeFormats == 0)
									{
										$time_in_12_hour_format_bookings  = DATE("g:i a", STRTOTIME($hourFormat_bookings));
									}
									else 
									{
										$time_in_12_hour_format_bookings  = DATE("H:i", STRTOTIME($hourFormat_bookings));
									}
								}
								$totalBookedTime = $customerBookingDetail[$flag] -> TimeSlot + $customerBookingDetail[$flag] -> ServiceTotalTime;
								$getHours_bookings = floor(($totalBookedTime)/60);
								$getMins_bookings = ($totalBookedTime) % 60;
								$hourFormat_bookings = $getHours_bookings . ":" . "00";
								if($timeFormats == 0)
								{
									$time_in_12_hour_format_bookings_End  = DATE("g:i a", STRTOTIME($hourFormat_bookings));
								}
								else 
								{
									$time_in_12_hour_format_bookings_End  = DATE("H:i", STRTOTIME($hourFormat_bookings));
								}
								if($getMins_bookings!=0)
								{
									$hourFormat_bookings = $getHours_bookings . ":" . $getMins_bookings;
									if($timeFormats == 0)
									{
										$time_in_12_hour_format_bookings_End  = DATE("g:i a", STRTOTIME($hourFormat_bookings));
									}
									else 
									{
										$time_in_12_hour_format_bookings_End  = DATE("H:i", STRTOTIME($hourFormat_bookings));
									}
								}
								if($customerBookingDetail[$flag]->ServiceFullDay == 0)
								{
								?>
								<td><?php echo $time_in_12_hour_format_bookings."-".$time_in_12_hour_format_bookings_End ?></td>
								<?php
								}
								else
								{
								?>
								<td>-</td>
								<?php
								}
								?>
								<td>
									<?php _e( $customerBookingDetail[$flag]->BookingStatus, booking_xpress );?>
								</td>
								<td>
									<a class="icon-trash" onclick="deleteCustomerBooking(<?php echo $customerBookingDetail[$flag]->BookingId; ?>)"></a>
								</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<input id="customerNameForBooking" type="hidden" value="<?php echo $customerNameReturn->CustomerFirstName . " ". $customerNameReturn->CustomerLastName ; ?>" />
			<?php
			die();
		}
		else if($_REQUEST['param'] == 'customerPaypalBooking')
		{
			?>
			<table class="table table-striped" id="data-table-paypal-bookings">
				<thead>
					<tr>
						<th style="width:12%"><?php _e( "Service", booking_xpress ); ?></th>
						<th style="width:10%"><?php _e( "Cost", booking_xpress ); ?></th>
						<th style="width:12%"><?php _e( "Date", booking_xpress ); ?></th>
						<th style="width:12%"><?php _e( "Time Slot", booking_xpress ); ?></th>
						<th style="width:10%"><?php _e( "Payment Status", booking_xpress ); ?></th>
						<th style="width:12%"><?php _e( "Trns. ID", booking_xpress ); ?></th>
						<th style="width:12%"><?php _e( "Trns. Date", booking_xpress ); ?></th>
						<th style="width:5%"></th>
					</tr>
				</thead>
				<tbody id="bindCustomerPaypalBookings">
				<?php
					$customerId  = intval($_REQUEST['customerId']);
					$customerNameReturn = $wpdb->get_row
					(
						$wpdb->prepare
						(
							"SELECT CustomerFirstName,CustomerLastName  FROM ".customersTable()." where CustomerId = %d",
							$customerId
						)
					);
					$currencyIcon = $wpdb->get_var
					(
						$wpdb->prepare
						(
							"SELECT CurrencySymbol FROM ".currenciesTable()." where CurrencyUsed = %d",
							"1"
						)
					);
					$dateFormat = $wpdb->get_var
					(
						$wpdb->prepare
						(
							'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s ',
							"default_Date_Format"
						)
					);
					$customerPaypalBookingDetail = $wpdb->get_results
					(
						$wpdb->prepare
						(
							"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceCost,". servicesTable(). ".ServiceColorCode, ". servicesTable(). ".ServiceFullDay,  ". servicesTable(). ".ServiceStartTime,  ". servicesTable(). ".ServiceTotalTime,  ". servicesTable(). ".ServiceEndTime,
							".bookingTable().".BookingDate,". bookingTable().".TimeSlot,". bookingTable().".Comments,". bookingTable().".CustomerId,". bookingTable().".DateofBooking,". bookingTable().".TransactionId,". bookingTable().".PaymentStatus,
							". bookingTable().".BookingStatus,". bookingTable().".BookingId,". bookingTable().".PaymentDate from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
							".CustomerId= ".customersTable().".CustomerId ". " LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().
							".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".CustomerId =  %d
							ORDER BY ".bookingTable().".BookingDate asc",
							$customerId
						)
					);
					$timeFormats = $wpdb->get_var
					(
						$wpdb->prepare
						(
							"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
							'default_Time_Format'
						)
					);
					for($flag = 0; $flag < count($customerPaypalBookingDetail); $flag++)
					{
						$multipleBookings = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"Select ".multiple_bookingTable().".bookingDate from ".multiple_bookingTable()." join
								". bookingTable() ." on ".multiple_bookingTable().".bookingId = ". bookingTable() .".BookingId where ". bookingTable() .".CustomerId = %d 
								and ".multiple_bookingTable().".bookingId = %d ORDER BY ".multiple_bookingTable().".bookingDate asc",
								$customerPaypalBookingDetail[$flag]->CustomerId,
								$customerPaypalBookingDetail[$flag]->BookingId
							)
						);
						$allocatedMultipleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto;\">";
						for($MBflag=0; $MBflag < count($multipleBookings); $MBflag++)
						{
							$dateFormat = $wpdb->get_var
							(
								$wpdb->prepare
								(
									'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s ',
									"default_Date_Format"
								)
							);
							if($dateFormat == 0)
							{
								$dateFormat1 =  date("M d, Y", strtotime($multipleBookings[$MBflag]->bookingDate));
							}
							else if($dateFormat == 1)
							{
								$dateFormat1 =  date("Y/m/d", strtotime($multipleBookings[$MBflag]->bookingDate));
							}
							else if($dateFormat == 2)
							{
								$dateFormat1 = date("m/d/Y", strtotime($multipleBookings[$MBflag]->bookingDate));
							}
							else if($dateFormat == 3)
							{
								$dateFormat1 =  date("d/m/Y", strtotime($multipleBookings[$MBflag]->bookingDate));
							}	
							$allocatedMultipleDates .= "<span style=\"margin-left:5px;background-color:".$customerPaypalBookingDetail[$flag]->ServiceColorCode.";color:#fff;border:solid 1px ".$customerPaypalBookingDetail[$flag]->ServiceColorCode . "\" class=\"tag\"><span>" . $dateFormat1 . "</span></span>";
						}
						$allocatedMultipleDates.= "</div>";
						?>
						<tr>
						<td><?php echo $customerPaypalBookingDetail[$flag]->ServiceName; ?></td>
						<td><?php echo $currencyIcon. " ".$customerPaypalBookingDetail[$flag]->ServiceCost; ?></td>
						<?php
						if($customerPaypalBookingDetail[$flag]->ServiceFullDay  == 1)
						{
						?>
							<td><?php echo $allocatedMultipleDates;?></td>
						<?php
						}
						else
						{
							if($dateFormat == 0)
							{
								?>
								<td><?php echo date("M d, Y", strtotime($customerPaypalBookingDetail[$flag]->BookingDate));?></td>
								<?php
							}
							else if($dateFormat == 1)
							{
							?>
								<td><?php echo date("Y/m/d", strtotime($customerPaypalBookingDetail[$flag]->BookingDate));?></td>
							<?php
							}	
							else if($dateFormat == 2)
							{
							?>
								<td><?php echo date("m/d/Y", strtotime($customerPaypalBookingDetail[$flag]->BookingDate));?></td>
							<?php
							}	
							else if($dateFormat == 3)
							{
							?>
								<td><?php echo date("d/m/Y", strtotime($customerPaypalBookingDetail[$flag]->BookingDate));?></td>
							<?php
							}
						}
						?>
						<?php
							$getHours_bookings = floor(($customerPaypalBookingDetail[$flag] -> TimeSlot)/60);
							$getMins_bookings = ($customerPaypalBookingDetail[$flag] -> TimeSlot) % 60;
							$hourFormat_bookings = $getHours_bookings . ":" . $getMins_bookings;
							if($timeFormats == 0)
							{
								$time_in_12_hour_format_bookings  = DATE("h:i A", STRTOTIME($hourFormat_bookings));
							}
							else 
							{
								$time_in_12_hour_format_bookings  = DATE("H:i", STRTOTIME($hourFormat_bookings));
							}
							$totalBookedTime = $customerPaypalBookingDetail[$flag] -> TimeSlot + $customerPaypalBookingDetail[$flag] -> ServiceTotalTime;
							$getHours_bookings = floor(($totalBookedTime)/60);
							$getMins_bookings = ($totalBookedTime) % 60;
							$hourFormat_bookings = $getHours_bookings . ":" . $getMins_bookings;
							if($timeFormats == 0)
							{
								$time_in_12_hour_format_bookings_End  = DATE("h:i A", STRTOTIME($hourFormat_bookings));
							}
							else 
							{
								$time_in_12_hour_format_bookings_End  = DATE("H:i", STRTOTIME($hourFormat_bookings));
							}
							if($customerPaypalBookingDetail[$flag]->ServiceFullDay == 0)
							{
							?>
								<td><?php echo $time_in_12_hour_format_bookings."-".$time_in_12_hour_format_bookings_End ?></td>
							<?php
							}
							else
							{
							?>
								<td>-</td>
							<?php
							}
							?>
							
							<td><?php echo $customerPaypalBookingDetail[$flag]->PaymentStatus; ?></td>
							<td><?php echo $customerPaypalBookingDetail[$flag]->TransactionId; ?></td>
							<?php
							if($customerPaypalBookingDetail[$flag]->PaymentDate == null && $customerPaypalBookingDetail[$flag]->PaymentDate == 0)
							{
								?>
								<td><?php echo "";?></td>
								<?php
							}
							else
							{
								$payDate = explode(" ",$customerPaypalBookingDetail[$flag]->PaymentDate);
								if($dateFormat == 0)
								{
									?>
									<td><?php echo date("M d, Y", strtotime($payDate[0]));?></td>
									<?php
								}
								else if($dateFormat == 1)
								{
								?>
									<td><?php echo date("Y/m/d", strtotime($payDate[0]));?></td>
								<?php
								}	
								else if($dateFormat == 2)
								{
								?>
									<td><?php echo date("m/d/Y", strtotime($payDate[0]));?></td>
								<?php
								}	
								else if($dateFormat == 3)
								{
								?>
									<td><?php echo date("d/m/Y", strtotime($payDate[0]));?></td>
								<?php
								}
							}
							?>
							<td>
								<a class="icon-trash" onclick="deleteCustomerBooking(<?php echo $customerPaypalBookingDetail[$flag]->BookingId; ?>)"></a>
							</td>
						</tr>
					<?php
					}
					?>
						
				</tbody>
			</table>
			<input id="customerNamePayment" type="hidden" value="<?php echo $customerNameReturn->CustomerFirstName . " ". $customerNameReturn->CustomerLastName ; ?>" />
				<?php
				die();
		}
		else if($_REQUEST['param'] == 'deleteCustomerBookings')
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE from ".bookingTable()." where 	BookingId = %d",
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['param'] == 'updateCustomersComments')
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$uxCustomerComments = html_entity_decode($_REQUEST['uxCustomerComments']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".bookingTable()." SET Comments = %s WHERE BookingId = %d",
					$uxCustomerComments,
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['param'] == 'emailCustomerContent')
		{
			$customerId = intval($_REQUEST['customerId']);
			$customerNameReturn = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT CustomerFirstName,CustomerLastName,CustomerEmail FROM ".customersTable()." where CustomerId = %d",
					$customerId
				)
			);
			?>
			<input id="hiddencustomerName" name="hiddencustomerName" type="hidden" value="<?php echo $customerNameReturn->CustomerFirstName . "". $customerNameReturn->CustomerLastName ; ?>" />
			<input id="hiddencustomerEmail" name="hiddencustomerEmail" type="hidden" value="<?php echo $customerNameReturn->CustomerEmail  ; ?>" />
			<?php
			die();
		}
		else if($_REQUEST['param'] == "updatecustomers")
		{
			$CustomerId = intval($_REQUEST['customerHiddenId']);
			$uxEditFirstName=esc_attr($_REQUEST['uxEditFirstName']);
			$uxEditLastName=esc_attr($_REQUEST['uxEditLastName']);
			$uxEditEmailAddress=esc_attr($_REQUEST['uxEditEmailAddress']);
			$uxEditTelephoneNumber=esc_attr($_REQUEST['uxEditTelephoneNumber']);
			$uxEditMobileNumber=esc_attr($_REQUEST['uxEditMobileNumber']);
			$uxEditAddress1=esc_attr($_REQUEST['uxEditAddress1']);
			$uxEditAddress2=esc_attr($_REQUEST['uxEditAddress2']);
			$uxEditSkypeId=esc_attr($_REQUEST['uxEditSkypeId']);
			$uxEditCity=esc_attr($_REQUEST['uxEditCity']);
			$uxEditPostalCode=esc_attr($_REQUEST['uxEditPostalCode']);
			$uxEditCountry=intval($_REQUEST['uxEditCountry']);
			$uxEditComments=esc_attr($_REQUEST['uxEditComments']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE " .customersTable(). " SET CustomerFirstName= %s, CustomerLastName = %s, CustomerEmail = %s,
					CustomerTelephone=%s, CustomerMobile = %s, CustomerAddress1=%s, CustomerAddress2 = %s, CustomerSkypeId=%s,
					CustomerCity=%s, CustomerZipCode=%s,CustomerCountry=%d, CustomerComments=%s WHERE CustomerId = %d",
					$uxEditFirstName,
					$uxEditLastName,
					$uxEditEmailAddress,
					$uxEditTelephoneNumber,
					$uxEditMobileNumber,
					$uxEditAddress1,
					$uxEditAddress2,
					$uxEditSkypeId,
					$uxEditCity,
					$uxEditPostalCode,
					$uxEditCountry,
					$uxEditComments,
					$CustomerId
				)
			);
			die();
		}
	}
}
?>