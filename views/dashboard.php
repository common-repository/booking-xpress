<?php
global $wpdb;
if (!current_user_can('edit_posts') && ! current_user_can('edit_pages') )
{
 	return;
}
else
{
	?>
	<div id="right">
		<div id="breadcrumbs">
			<ul>
				<li class="first"></li>
				<li>
					<a href="#">
						<?php _e("BOOKINGS XPRESS", booking_xpress); ?>
					</a>
				</li>
				<li class="last">
					<a href="#">
						<?php _e("DASHBOARD", booking_xpress); ?>
					</a>
				</li>
			</ul>
		</div>
		<div class="section">
			<div class="box">
				<div class="title">
					<?php _e("Action Panel", booking_xpress); ?>
					<span class="hide"></span>
				</div>
				<div class="content">
					<ul class="midnav">
					<li>
						<a href="#bookNewService" class="inline">
							<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/date.png'?>" alt="">
							<span>
								<?php _e( "Book a Service", booking_xpress ); ?>
							</span>
						</a>
						<strong id="uxBookingsCount"></strong>
					</li>
						<li>
							<a href="#addNewService" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/order-149.png' ?>" alt="">
								<span>
									<?php _e( "Add Services", booking_xpress ); ?>
								</span>
							</a>
							<strong id="uxServiceCount"></strong>
						</li>
						<li>
							<a href="#BlockOuts" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/busy.png'?>" alt="">
								<span>
									<?php _e( "Block Outs", booking_xpress ); ?>
								</span>
							</a>
							<strong id="uxBlockOutsCount"></strong>
						</li>
						<li>
							<a href="#couponsMenu" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/bank.png' ?>" alt="">
								<span>
									<?php _e( "Coupons", booking_xpress ); ?>
								</span>
							</a>
							<strong id="uxCouponsCount"></strong>
						</li>
						<li>
							<a href="#defaultSettings" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/settings.png'?>" alt="">
								<span>
									<?php _e( "Default Settings", booking_xpress ); ?>
								</span>
							</a>
						</li>
						<li>
							<a href="#ReminderSettings" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/phone.png' ?>" alt="">
								<span>
									<?php _e( "Reminder Settings", booking_xpress ); ?>
								</span>
							</a>
							<strong id="uxDashboardReminderSettings"></strong>
						</li>
	 					<li>
							<a href="#shortcodes" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/lightbulb.png' ?>" alt="">
								<span>
									<?php _e( "ShortCodes", booking_xpress ); ?>
								</span>
							</a>
						</li>
						<li>
							<a href="#paypalSettings" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/paypal.png'?>" alt="">
								<span>
									<?php _e( "Paypal Settings", booking_xpress ); ?>
								</span>
							</a>
							<strong id="uxDashboardPaypalSettings"></strong>
						</li> 
						<li>
							<a href="#mailChimpSettings" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/mailchimp.png'?>" alt="">
								<span>
									<?php _e( "Mailchimp Settings", booking_xpress ); ?>
								</span>
							</a>
							<strong id="uxDashboardMailChimpSettings"></strong>
						</li>
						<li>
							<a href="#facebookConnect" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/facebook.png' ?>" alt="">
								<span>
									<?php _e( "Facebook Connect", booking_xpress ); ?>
								</span>
							</a>
							<strong id="uxDashboardFacebookConnect"></strong>
						</li>			   		
						<li>
							<a href="#autoApproveBookings" class="inline">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/check.png'?>" alt="">
								<span>
									<?php _e( "Auto Approve", booking_xpress ); ?>
								</span>
							</a>
							<strong id="uxDashboardAutoApprove"></strong>
						</li>
						<li>
							<a href="#deleteAllBookings" onclick="DeleteAllBookings();">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/brainstorming.png' ?>" alt="">
								<span>
									<?php _e( "Delete All Bookings", booking_xpress ); ?>
								</span>
							</a>
						</li>
						<li>
							<a href="#restorFactorySettings" onclick="RestoreFactorySettings();">
								<img src="<?php echo TBP_BK_PLUGIN_URL.'/images/icons/color/config.png'?>" alt="">
								<span>
									<?php _e( "Restore Factory Settings", booking_xpress ); ?>
								</span>
							</a>
						</li>
					</ul>
				</div>	
			</div>
			<div class="box">
				<div class="title">
					<?php _e("Upcoming Bookings", booking_xpress); ?>
					<span class="hide"></span>
				</div>
				<div class="content">
					<div class="table-overflow">
						<table class="table table-striped" id="data-table-upcoming-events">
							<thead>
								<tr>
								<?php
									$paypalEnable = $wpdb->get_var
										(
											$wpdb->prepare
											(
												"SELECT PaymentGatewayValue FROM ".payment_Gateway_settingsTable()." where PaymentGatewayKey = %s ",
												"paypal-enabled"
											)
									);
									
									if($paypalEnable == 1)
									{
									?>
										<th style="width:2% !important"></th>
										<?php
										}
										?>
										<th style="width:12% !important"><?php _e( "Client Name", booking_xpress ); ?></th>
										<th style="width:10% !important"><?php _e( "Mobile", booking_xpress ); ?></th>
										<th style="width:12% !important"><?php _e( "Service", booking_xpress ); ?></th>
										<th style="width:18% !important"><?php _e( "Booking Date", booking_xpress ); ?></th>
										<th style="width:12% !important"><?php _e( "Time Slot", booking_xpress ); ?></th>
										<th style="width:7% !important"></th>
									</tr>
							</thead>
							<tbody>
							<?php
								$currentdate = date("Y-m-d"); 
								$newDate = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")+30, date("Y")));
								$uxUpcomingBookings = $wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT CONCAT(".customersTable().".CustomerFirstName,'  ',". customersTable().".CustomerLastName) as ClientName,".servicesTable().".ServiceTotalTime,
										".customersTable().".CustomerMobile,". servicesTable(). ".ServiceName, ".servicesTable().".ServiceFullDay, ".servicesTable().".ServiceColorCode,
										".servicesTable().".ServiceStartTime, ".servicesTable().".ServiceEndTime, ".bookingTable().".BookingDate ,". bookingTable().".TimeSlot,
										". bookingTable().".PaymentStatus,". bookingTable().".BookingId,". bookingTable().".BookingStatus from ".bookingTable()." 
										LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().".CustomerId= ".customersTable().".CustomerId ". "  
										LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().".ServiceId=".servicesTable().".ServiceId 
										ORDER BY ".bookingTable().".BookingDate asc",""
									)
								);
								$timeFormats = $wpdb->get_var
								(
									$wpdb->prepare
									(
										"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s ",
										"default_Time_Format"
									)
								);
								for($flag = 0; $flag < count($uxUpcomingBookings); $flag++)
								{
									$multipleBookings = $wpdb->get_results
									(
										$wpdb->prepare
										(
											"Select ".multiple_bookingTable().".bookingDate from ".multiple_bookingTable()." JOIN 
											". bookingTable() ." on ".multiple_bookingTable().".bookingId = ". bookingTable() .".BookingId WHERE 
											". multiple_bookingTable().".bookingId = %d ORDER BY ".multiple_bookingTable().".bookingDate asc",
											$uxUpcomingBookings[$flag]->BookingId  
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
									if($dateFormat == 0)
									{
										$dateFormat1 =  date("M d, Y", strtotime($uxUpcomingBookings[$flag]->BookingDate));
									}
									else if($dateFormat == 1)
									{
										$dateFormat1 =  date("Y/m/d", strtotime($uxUpcomingBookings[$flag]->BookingDate));
									}	
									else if($dateFormat == 2)
									{
									
										$dateFormat1 = date("m/d/Y", strtotime($uxUpcomingBookings[$flag]->BookingDate));
								
									}	
									else if($dateFormat == 3)
									{
									
										$dateFormat1 =  date("d/m/Y", strtotime($uxUpcomingBookings[$flag]->BookingDate));
									
									}	
									$allocatedMultipleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto; \">";
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
										$allocatedMultipleDates .= "<span style=\"background-color:".$uxUpcomingBookings[$flag]->ServiceColorCode.";color:#fff;border:solid 1px ".$uxUpcomingBookings[$flag]->ServiceColorCode . "\" class=\"tag\"><span>" . $dateFormat1 .''. "</span></span>";
									}
									$allocatedMultipleDates.= "</div>";
									if($uxUpcomingBookings[$flag]->BookingStatus == "Approved")
									{
									?>
										<tr class="success hovertip"  data-original-title="<?php _e("Booking Status : Approved", booking_xpress ); ?>" data-placement="left">
									<?php
									}
									else if($uxUpcomingBookings[$flag]->BookingStatus == "Disapproved")
									{
									?>
										<tr class="error hovertip"  data-original-title="<?php _e("Booking Status : Disapproved", booking_xpress ); ?>" data-placement="left">
									<?php	
									}
									else if($uxUpcomingBookings[$flag]->BookingStatus == "Pending Approval")
									{
									?>
										<tr class="warning hovertip"  data-original-title="<?php _e("Booking Status : Pending Approval", booking_xpress ); ?>" data-placement="left">
									<?php	
									}
									else if($uxUpcomingBookings[$flag]->BookingStatus == "Cancelled")
									{
									?>
										<tr class="info hovertip"  data-original-title="<?php _e("Booking Status : Cancelled", booking_xpress ); ?>" data-placement="left">
									<?php	
									}
									else
									{
									?>
										<tr>
									<?php	
									}	
									if($paypalEnable == 1)
									{
										if($uxUpcomingBookings[$flag]->PaymentStatus == "Completed")
										{																																								
										?>
											<td>
												<div style="width:15px;height:15px;background-color:green" title="Payment Recieved"></div>
											</td>
										<?php
										}
										else if($uxUpcomingBookings[$flag]->PaymentStatus == "Cancelled")
										{
										?>
											<td>
												<div style="width:10px;height:15px;background-color:red" title="Payment Cancelled"></div>
											</td>
										<?php
										}
										else 
										{
											?>
											<td>
												<div style="width:15px;height:15px;background-color:orange" title="Awaiting Payment"></div>
											</td>
										<?php
										}
									}
									?>
									<td><?php echo $uxUpcomingBookings[$flag]->ClientName?></td>
									<td><?php echo $uxUpcomingBookings[$flag]->CustomerMobile?></td>
									<td><?php echo $uxUpcomingBookings[$flag]->ServiceName;?></td>
									<?php
										if($uxUpcomingBookings[$flag]->ServiceFullDay == 1)
									{
										?>
											<td><?php echo $allocatedMultipleDates;?></td>
										<?php
									}
									else
									{
										$allocatedSingleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto; \">";
										
										if($dateFormat == 0)
										{
											 $SingleDate = date("M d, Y", strtotime($uxUpcomingBookings[$flag]->BookingDate));
											
										}
										else if($dateFormat == 1)
										{
											 $SingleDate = date("Y/m/d", strtotime($uxUpcomingBookings[$flag]->BookingDate));
										}	
										else if($dateFormat == 2)
										{
											$SingleDate = date("m/d/Y", strtotime($uxUpcomingBookings[$flag]->BookingDate));
										}	
										else if($dateFormat == 3)
										{
											$SingleDate =  date("d/m/Y", strtotime($uxUpcomingBookings[$flag]->BookingDate));
										}
										$allocatedSingleDates .= "<span style=\"background-color:".$uxUpcomingBookings[$flag]->ServiceColorCode.";color:#fff;border:solid 1px ".$uxUpcomingBookings[$flag]->ServiceColorCode . "\" class=\"tag\"><span>" . $SingleDate .''. "</span></span></div>";
										?><td><?php echo $allocatedSingleDates; ?></td><?php
									}
									$getHours_bookings = floor(($uxUpcomingBookings[$flag] -> TimeSlot)/60);
									$getMins_bookings = ($uxUpcomingBookings[$flag] -> TimeSlot) % 60;
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
									$totalBookedTime = $uxUpcomingBookings[$flag]->TimeSlot + $uxUpcomingBookings[$flag]->ServiceTotalTime;
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
									if($uxUpcomingBookings[$flag]->ServiceFullDay == 0)
									{
									?>
										<td><?php echo $time_in_12_hour_format_bookings ." - ". $time_in_12_hour_format_bookings_End ?></td>
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
											<a class="icon-edit hovertip inline" data-original-title="<?php _e("Edit Booking?", booking_xpress ); ?>" data-placement="top" href="#EditBooking" onclick="editBooking(<?php echo $uxUpcomingBookings[$flag]->BookingId; ?>);"></a>
											<?php
											if($uxUpcomingBookings[$flag]->BookingStatus != "Cancelled")
											{
											 	?>
												<a  class="icon-envelope hovertip" data-original-title="<?php _e("Send Email Again?", booking_xpress ); ?>" data-placement="top" href="#" onclick="resendEmail('<?php echo $uxUpcomingBookings[$flag]->BookingId;?>','<?php echo $uxUpcomingBookings[$flag]->BookingStatus;?>')"></a>
												<?php
											}
											?>
											<a class="icon-trash hovertip" data-original-title="<?php _e("Delete Booking?", booking_xpress ); ?>" data-placement="top" href="#" onclick="deleteBooking(<?php echo $uxUpcomingBookings[$flag]->BookingId; ?>)"></a>
										</td>
									</tr>
							<?php
							}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div class="split">
			<?php _e( "&copy; 2013 Bookings-Xpress", booking_xpress ); ?>
		</div>
		<div class="split right">
			Powered by
			<a href="#" >
			<?php _e( "Bookings Xpress!", booking_xpress ); ?>
			</a>
		</div>
	</div>
	</div>
	</div>
	<div style="display: none">
		<div id="facebookConnect">
			<form id="uxFrmFacebookSettings" class="form-horizontal" method="post" action="">		
				<div class="body">
					<div class="message green" id="successFacebookSettingsMessage" style="display:none;margin-left:10px;">
						<span>
							<strong>
								<?php _e( "Success! Facebook Settings has been saved.", booking_xpress ); ?>
							</strong>
						</span>
					</div>
					<div class="block well" style="margin:10px;">
						<div class="box">
							<div class="content">
								<?php
								$facebookStatus = $wpdb->get_var
								(
									$wpdb->prepare
									(
										'SELECT SocialMediaValue FROM ' . social_Media_settingsTable() . ' where SocialMediaKey = %s',
										"facebook-connect-enable"
									)
								);
								?>
								<div class="row">
									<label style="top:10px;">
										<?php _e( "Facebook Connect :", booking_xpress );?>
									</label>
									<div class="right">
									<?php
										if($facebookStatus == 1)
										{
									?>
											<input type="radio" id="uxFacebookConnectEnable" name="uxFacebookConnect" class="style" value="1" onclick="enableFBText();" checked="checked">&nbsp;&nbsp;<?php _e( "Enabled", booking_xpress );?>
											<input type="radio" id="uxFacebookConnectDisable" name="uxFacebookConnect" onclick="disableFBText();" class="style" value="0" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", booking_xpress );?>
									<?php
										}
										else 
										{
									?>
											<input type="radio" id="uxFacebookConnectEnable" name="uxFacebookConnect" class="style" onclick="enableFBText();" value="1" >&nbsp;&nbsp;<?php _e( "Enabled", booking_xpress );?>
											<input type="radio" id="uxFacebookConnectDisable" name="uxFacebookConnect" class="style" onclick="disableFBText();" value="0" checked="checked" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", booking_xpress );?>
									<?php
										}
									?>
									</div>
								</div>
								<div class="row" id="facebookAPI">
									<label>
										<?php _e( "App Id :", booking_xpress ); ?>
									</label>
									<?php
										$facebookApiKey = $wpdb->get_var
										(
											$wpdb->prepare
											(
												'SELECT SocialMediaValue FROM ' . social_Media_settingsTable() . ' where SocialMediaKey = %s',
												"facebook-api-id"
											)
										);
									?>
									<div class="right">
										<input type="text" class="required span12" name="uxFacebookAppId" id="uxFacebookAppId" value="<?php echo $facebookApiKey;  ?>"/>
									</div>
								</div>
								<div class="row" id="facebookSecret">
									<label>
										<?php _e( "Secret Key :", booking_xpress ); ?>
									</label>
									<?php
										$facebookSecretKey = $wpdb->get_var
										(
											$wpdb->prepare
											(
												'SELECT SocialMediaValue FROM ' . social_Media_settingsTable() . ' where SocialMediaKey = %s',
												"facebook-secret-key"
											)
										);
									?>
									<div class="right">
										<input type="text" class="required span12" name="uxFacebookSecretKey" id="uxFacebookSecretKey" value="<?php echo $facebookSecretKey;  ?>"/>
									</div>
								</div>
								<div class="row" style="border-bottom: !important">
									<label></label>
									<div class="right">
										<button type="submit" class="green" >
											<span>
											<?php _e( "Submit & Save Changes", booking_xpress ); ?>
											</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>		
			</form>
		</div>
	</div>
	<div style="display: none">
		<div id="mailChimpSettings">
			<form id="uxFrmMailChimpSettings" class="form-horizontal" method="post" action="">		
				<div class="message green" id="successMailChimpSettingsMessage" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Success! Mail Chimp Settings has been saved.", booking_xpress ); ?>
						</strong>
					</span>
				</div>	
				<div class="body">
					<div class="block well" style="margin:10px;">
						<div class="box">
							<div class="content">
								 <?php
									$autoResponderStatus = $wpdb->get_var
									(
										$wpdb->prepare
										(
											'SELECT AutoResponderValue FROM ' . auto_Responders_settingsTable() . ' where AutoResponderKey  = %s',
											"mail-chimp-enabled"
										)
									);
								?>
								<div class="row">
									<label style="top:10px;"><?php _e( "Mail Chimp :", booking_xpress ); ?></label>
									<div class="right">
										<?php
											if($autoResponderStatus == 1)
											{
										?>
												<input type="radio" id="enableuxMailChimp" name="uxMailChimp" class="style" value="1" onclick="enableMailChimpText();" checked="checked">&nbsp;&nbsp;<?php _e( "Enabled", booking_xpress );?>
												<input type="radio" id="disableuxMailChimp" name="uxMailChimp" onclick="disableMailChimpText();" class="style" value="0" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", booking_xpress );?>
										<?php
											}
											else 
											{
										?>
												<input type="radio" id="enableuxMailChimp" name="uxMailChimp" class="style" onclick="enableMailChimpText();" value="1" >&nbsp;&nbsp;<?php _e( "Enabled", booking_xpress );?>
												<input type="radio" id="disableuxMailChimp" name="uxMailChimp" class="style" onclick="disableMailChimpText();" value="0" checked="checked" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", booking_xpress );?>
										<?php
											}
										?>
									</div>
								</div>
								<div class="row" id="mailApiKey">
									<label>
										<?php _e( "Api Key :", booking_xpress ); ?>
									</label>
									<?php
										$MailChimpApiKey = $wpdb->get_var
										(
											$wpdb->prepare
											(
												'SELECT AutoResponderValue FROM ' . auto_Responders_settingsTable() . ' where AutoResponderKey  = %s',
												"mail-chimp-api-key"
											)
										);
									?>
									<div class="right">
										<input type="text" class="required span12" name="uxMailChimpApiKey" id="uxMailChimpApiKey" value="<?php echo $MailChimpApiKey;  ?>"/>
									</div>
								</div>
								<div class="row" id="mailUniqueId">
									<label>	<?php _e( "List Unique Id :", booking_xpress ); ?></label>
									<?php
										$MailChimpUniqueId = $wpdb -> get_var
										(
											$wpdb->prepare
											(
												'SELECT AutoResponderValue FROM ' . auto_Responders_settingsTable() . ' where AutoResponderKey  = %s',
												"mail-chimp-unique-id"
											)
										);
									?>
									<div class="right">
										<input type="text" class="required span12" name="uxMailChimpUniqueId" id="uxMailChimpUniqueId" value="<?php echo $MailChimpUniqueId;  ?>"/>
									</div>
								</div>
								<div class="row"  id="mailOptIn">
									<label>
										<?php _e( "Double Opt-In :", booking_xpress ); ?>
									</label>
									<div class="right">
									<?php
										$DoubleOptIn = $wpdb -> get_var
										(
											$wpdb->prepare
											(
												'SELECT AutoResponderValue FROM ' . auto_Responders_settingsTable() . ' where AutoResponderKey  = %s',
												"mail-double-optin-id"
											)
										);
										if($DoubleOptIn == "true")
										{
									?>
											<input type="checkbox" class="style" name="uxDoubleOptIn" value="true" checked="checked" id="uxDoubleOptIn"/>
									<?php
										}
										else 
										{
									?>
											<input type="checkbox" class="style" name="uxDoubleOptIn" value="false" id="uxDoubleOptIn"/>
									<?php
										}
									?>
									</div>
								</div>
								<div class="row" id="mailEmail" style="border-bottom:none">
									<label><?php _e( "Welcome Email :", booking_xpress ); ?></label>
									<div class="right">
										<?php
											$WelcomeEmail = $wpdb -> get_var
											(
												$wpdb->prepare
													(
														'SELECT AutoResponderValue FROM ' . auto_Responders_settingsTable() . '  where AutoResponderKey  = %s',
														"mail-welcome-email"
													)
											);
											if($WelcomeEmail == "true")
											{
										?>
												<input type="checkbox" class="style" name="uxWelcomeEmail" value="true" id="uxWelcomeEmail" checked="checked"/>
										<?php
											}
											else 
											{
										?>
												<input type="checkbox" class="style" name="uxWelcomeEmail"  value="false" id="uxWelcomeEmail" />
										<?php
											}
									?>
									</div>
								</div>
								<div class="row" style="border-bottom: !important">
									<label></label>
									<div class="right">
										<button type="submit" class="green" >
											<span>
												<?php _e( "Submit & Save Changes", booking_xpress ); ?>	   			
											</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>		
			</form>
		</div>
	</div>
	<div style="display:none">
		<div id="addNewService" >
			<form id="uxFrmAddServices" class="form-horizontal" method="post" action="">	
				<div class="message green" id="successMessageService" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Success! Service has been saved.", booking_xpress ); ?>
						</strong>
					</span>
				</div>
				<div class="message red" id="errorMessageServices" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Error! Max Bookings should be greater than 1", booking_xpress ); ?>
						</strong>
					</span>
				</div>
				<div class="message red" id="timeErrorMessage" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Error! Please Enter the Valid Time.", booking_xpress ); ?>
						</strong>
					</span>
				</div>
				<div class="message red" id="serviceTimeErrorMessage" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Error! Please enter valid Service Time.", booking_xpress ); ?>
						</strong>
					</span>
				</div>
				<div class="body">
					<div class="block well" style="margin:10px;">
						<div class="box">
							<div class="content">
								<div class="row">
									<label>
										<?php _e( "Service Color :", booking_xpress ); ?>
									</label>
									<div class="right">
											<input type="text" id="uxServiceColor" name="uxServiceColor" value="#00ff00">
									</div>
								</div>
								<div class="row">
									<label>
										<?php _e( "Service Name :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="text" class="required span12" name="uxServiceName" id="uxServiceName"/> 
									</div>
								</div>
								<div class="row">
									<?php
									$costIcon = $wpdb->get_var
									(
										$wpdb->prepare
										(
											"SELECT CurrencySymbol FROM ".currenciesTable()." where CurrencyUsed = %d",
											1
										)
									);
									?>
									<label>
										<?php _e( "Service Cost ", booking_xpress ); ?><?php echo "(".$costIcon.") :";?>
									</label>
									<div class="right">
										<input type="text" class="required span12" name="uxServiceCost" id="uxServiceCost"/> 
									</div>
								</div>
								<div class="row">
									<label style="top:10px">
										<?php _e( "Service Type :", booking_xpress );?>
									</label>
									<div class="right">
										<input type="radio" id="uxServiceTypeEnable" name="uxServiceType" class="style" value="0" onclick="singleBooking();" checked="checked">&nbsp;&nbsp;<?php _e( "Single Booking", booking_xpress );?>
										<input type="radio" id="uxServiceTypeDisable" name="uxServiceType" onclick="groupBooking();" class="style" value="1" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Group Bookings", booking_xpress );?> 	
									</div>
								</div>
								<div class="row" id="maxBooking" Style="display: none;">
									<label>
										<?php _e( "Max Bookings :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="text" class="required span12" name="uxMaxBookings" id="uxMaxBookings" value="1"/> 
									</div>
								</div>																						
								<div class="row">
									<label  style="top:10px">
										<?php _e( "Full Day Service :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="checkbox" value="1"  id="uxFullDayService" name="uxFullDayService" onclick="divControlsShowHide();" > 
									</div>
								</div>
								<div class="row" id="divMaxDays" style="display : none;">
									<label>
										<?php _e( "Allow Max. Days :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxMaxDays" class="required" id="uxMaxDays" style="width:100px;" > 
											<option value="Unlimited"><?php _e( "Unlimited", booking_xpress ); ?></option>
											<?php
											for($days = 1; $days < 31; $days++)
											{
												?>
												<option value="<?php echo $days; ?>"><?php echo $days; ?></option>
												<?php
											}
											?>
											</select>
									</div>
								</div>
								<div class="row" id="divCostType" style="display : none;">
									<label>
										<?php _e( "Cost Type :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="radio" id="uxServiceCostType" name="uxCostType" class="style" value="0" checked="checked">&nbsp;&nbsp;<?php _e( "Per Day", booking_xpress );?>
										<input type="radio" id="uxServiceCostType" name="uxCostType" class="style" value="1" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Fixed", booking_xpress );?> 
									</div>
								</div>
								<div class="row" id="divServiceTime">
									<label>
										<?php _e( "Service Time :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxServiceHours" class="required" id="uxServiceHours" style="width:100px;" >
											<?php
												for ($hr = 0; $hr <= 23; $hr++) 
												{
													if($hr > 1)
													{
														$hrsDisplay = "Hrs";
													}
													else
													{
														$hrsDisplay = "Hour";
															
													}
													if ($hr < 10) 
													{
														?>
														<option value="<?php echo "0" . $hr; ?>"><?php echo "0" . $hr ." ". $hrsDisplay;?></option>
														<?php
													}
													else
													{
														?>
														<option value="<?php echo $hr; ?>"><?php echo $hr ." ". $hrsDisplay;?></option>
														<?php
													}
												}
											?>
										</select>
										<select name="uxServiceMins" class="required" id="uxServiceMins" style="width:100px;" >
											<?php
												for ($min = 0; $min < 60; $min += 5) 
												{
													if($min > 1)
													{
														$minDisplay = "Mins";
													}
													else
													{
														$minDisplay = "Minute";
															
													}
													if ($min < 10) 
													{
														?>
														<option value="<?php echo $min; ?>"><?php echo "0" . $min ." ". $minDisplay;?></option>
														<?php
													}
													else
													{
														?>
														<option value="<?php echo $min; ?>"><?php echo  $min ." ". $minDisplay;?></option>
														<?php
													}
												}
											?>
										</select> 
									</div>
								</div>
								<div class="row" id="divStartTime">
									<label>
										<?php _e( "Start Time :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxStartTimeHours" class="required" id="uxStartTimeHours" style="width:60px;" >
											<?php
												for ($hr = 0; $hr <= 12; $hr++) 
												{
													if ($hr < 10) 
													{
														echo "<option value=" . $hr . " >0" . $hr . "</option>";
													}
													else 
													{
														echo "<option value=" . $hr . ">" . $hr . "</option>";
													}
												}
											?>
										</select>
										<select name="uxStartTimeMins" class="required" id="uxStartTimeMins" style="width:60px;" >
										<?php
											for ($min = 0; $min < 60; $min += 5) 
												{
													if ($min < 10) 
													{
														echo "<option value=" . $min . ">0" . $min . "</option>";
													}
													else
													{
														echo "<option value=" . $min . ">" . $min . "</option>";
													}
												}
											?>
										</select>
										<select name="uxStartTimeAMPM" class="required" id="uxStartTimeAMPM" style="width:60px;" >
											<option value="AM">AM</option>
											<option value="PM">PM</option>
										</select>
									</div>
								</div>
								<div class="row" id="divEndTime">
									<label>
										<?php _e( "End Time :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxEndTimeHours" class="required" id="uxEndTimeHours" style="width:60px;" >
											<?php
												for ($hr = 0; $hr <= 12; $hr++) 
												{
													if ($hr < 10) 
													{
														echo "<option value=" . $hr . " >0" . $hr . "</option>";
													}
													else 
													{
														echo "<option value=" . $hr . ">" . $hr . "</option>";
													}
												}
											?>
										</select>
										<select name="uxEndTimeMins" class="required" id="uxEndTimeMins" style="width:60px;" >
											<?php
												for ($min = 0; $min < 60; $min += 5) 
												{
													if ($min < 10) 
													{
														echo "<option value=" . $min . ">0" . $min . "</option>";
													}
													else
													{
														echo "<option value=" . $min . ">" . $min . "</option>";
													}
												}
											?>
										</select>
										<select name="uxEndTimeAMPM" class="required" id="uxEndTimeAMPM" style="width:60px;" >
											<option value="AM">AM</option>
											<option value="PM">PM</option>
										</select>								
									</div>
								</div>
								<script>
									jQuery("#uxStartTimeHours").val("9");
									jQuery("#uxStartTimeMins").val("0");
									jQuery("#uxStartTimeAMPM").val("AM");
									jQuery("#uxEndTimeHours").val("5");
									jQuery("#uxEndTimeMins").val("0");
									jQuery("#uxEndTimeAMPM").val("PM");
									jQuery("#uxMaxDays").val("1");
								</script>		
							</div>
						</div>
						<div class="row" style="border-bottom: !important">
							<label></label>
							<div class="right">
								<button type="submit" class="green" >
									<span>
										<?php _e( "Submit & Save Changes", booking_xpress ); ?>	   			
									</span>
								</button>
							</div>
						</div>	
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="display:none">
		<div id="defaultSettings">
			<form id="uxFrmGeneralSettings" class="form-horizontal" method="post" action="">
				<div class="message green" id="successDefaultSettingsMessage" style="display:none;margin-left:10px;">
					<span>
						<strong><?php _e( "Success! Default Settings has been saved.", booking_xpress ); ?></strong>
					</span>
				</div>				
				<div class="body">
					<div class="block well" style="margin:10px;">
						<div class="box">
							<div class="content">
								<div class="row">
									<label>
										<?php _e( "Currency :", booking_xpress ); ?>
									</label>
									<div class="right">
										<?php
											$currency = $wpdb->get_col
											(
												$wpdb->prepare
												(
													"SELECT CurrencyName From ".currenciesTable()." order by CurrencyName ASC",''
												)
											);	
											$currency_code = $wpdb->get_col
											(
												$wpdb->prepare
												(
													"SELECT CurrencySymbol From ".currenciesTable()." order by CurrencyName ASC",''
												)
											);	
											$currency_sel = $wpdb -> get_var
											(
												$wpdb->prepare
												(
													"SELECT CurrencyName FROM ".currenciesTable(). " where CurrencyUsed = %d",
													1
												)
											);
										?>
										<select name="uxDdlDefaultCurrency" id="uxDdlDefaultCurrency" style="width:200px;">
											<?php
												for ($flagCurrency = 0; $flagCurrency < count($currency); $flagCurrency++)
												{
													if ($currency[$flagCurrency] == $currency_sel)
													{
														$currencyCode = $currency_code[$flagCurrency];
														?>
														<option value="<?php echo $currency[$flagCurrency];?>" selected='selected'><?php echo "(" . $currencyCode . ")  ";echo $currency[$flagCurrency];?></option>
														<?php 
													}
													else
													{
													?>
														<option value="<?php echo $currency[$flagCurrency];?>"><?php echo "(" . $currency_code[$flagCurrency] . ")  ";echo $currency[$flagCurrency]; ?></option>
													<?php 
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<label>
										<?php _e( "Country :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxDdlDefaultCountry" class="style required" id="uxDdlDefaultCountry" style="width:200px;">  
											<?php
												$country = $wpdb->get_col
												(
													$wpdb->prepare
													(
														"SELECT CountryName From ".countriesTable()."  order by CountryName ASC"
													)
												);	
												$sel_country = $wpdb -> get_var
												(
													$wpdb->prepare
													(	
														'SELECT CountryName  FROM ' . countriesTable() . ' where CountryUsed = %d',
														1
													)
												);
												for ($flagCountry = 0; $flagCountry < count($country); $flagCountry++)
												{
													if ($sel_country == $country[$flagCountry])
													{
													?>
														<option value="<?php echo $country[$flagCountry];?>" selected='selected'><?php echo $country[$flagCountry];?></option>
													<?php 
													}
													else
													{
													?>
														 <option value="<?php echo $country[$flagCountry];?>"><?php echo $country[$flagCountry];?></option>
													<?php 
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<?php
										$dateFormat = $wpdb->get_var
										(
											$wpdb->prepare
											(	
												'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
												"default_Date_Format"
											)
										);
									?>
									<label>
										<?php _e( "Date Format :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxDefaultDateFormat" class="style required" id="uxDefaultDateFormat" style="width:200px;">
											<?php
												$date = date('j'); 
												$monthName = date('F');
												$monthNumeric = date('m');
												$year = date('Y');
												if($dateFormat == 0)
												{
											?>	
													<option value="0" selected="selected">
														<?php echo  $monthName ." ".$date.",  ".$year; ?>
													</option>
													<option value="1">
														<?php echo  $year ."/".$monthNumeric."/".$date; ?>
													</option>
													<option value="2">
														<?php echo  $monthNumeric ."/".$date."/".$year; ?>
						 							</option>
													<option value="3">
														<?php echo $date ."/".$monthNumeric."/".$year;  ?>
													</option>
												<?php
												}
												else if($dateFormat == 1)
												{
												?>
													<option value="0">
														<?php echo  $monthName ." ".$date.",  ".$year; ?>
													</option>
														<option value="1" selected="selected">
															<?php echo  $year ."/".$monthNumeric."/".$date; ?>
														</option>
														<option value="2">
															<?php echo  $monthNumeric ."/".$date."/".$year; ?>
														</option>
														<option value="3">
															<?php echo $date ."/".$monthNumeric."/".$year;  ?>
														</option>
												<?php
												}
												else if($dateFormat == 2)
												{
												?>
													<option value="0">
														<?php echo  $monthName ." ".$date.",  ".$year; ?>
													</option>
														<option value="1" >
															<?php echo  $year ."/".$monthNumeric."/".$date; ?>
														</option>
														<option value="2" selected="selected">
															<?php echo  $monthNumeric ."/".$date."/".$year; ?>
														</option>
														<option value="3">
															<?php echo $date ."/".$monthNumeric."/".$year;  ?>
														</option>
												<?php
												}
												else 
												{
												?>
													<option value="0">
														<?php echo  $monthName ." ".$date.",  ".$year; ?>
													</option>
													<option value="1" >
														<?php echo  $year ."/".$monthNumeric."/".$date; ?>
													</option>
													<option value="2">
														<?php echo  $monthNumeric ."/".$date."/".$year; ?>
													</option>
													<option value="3" selected="selected">
														<?php echo $date ."/".$monthNumeric."/".$year;  ?>
													</option>
												<?php
												}
												?>
										</select> 	
									</div>
								</div>
								<div class="row">
									<?php
										$timeFormat = $wpdb -> get_var
										(
											$wpdb->prepare
											(	
												'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
												"default_Time_Format"
											)
										);
										$minuteFormat = $wpdb -> get_var
										(
											$wpdb->prepare
											(	
												'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
												"default_Slot_Minute_Format"
											)
										);
									?>
									<label>
										<?php _e( "Time Format :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxDefaultTimeFormat" class="style required" id="uxDefaultTimeFormat" style="width:200px;">
											<?php
												if($timeFormat == 0)
												{
												?>	
												<option value="0" selected="selected">12 Hours</option>
												<option value="1">24 Hours</option>
												<?php
												}
												else 
												{
												?>
													<option value="0">12 Hours</option>
													<option value="1" selected="selected">24 Hours</option>
												<?php
												}
											?>
									</select> 		
									</div>
								</div>
								<div class="row">
									<?php
										$default_Time_Zone = $wpdb->get_var
										(
											$wpdb->prepare
											(	
												'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
												"default_Time_Zone"
											)
										);
									?>
									<label>
										<?php _e( "Time Zone :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxDefaultTimeZone" class="style required" id="uxDefaultTimeZone" style="width:350px;">
											<option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
											<option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
											<option value="-10.0">(GMT -10:00) Hawaii</option>
											<option value="-9.0">(GMT -9:00) Alaska</option>
											<option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
											<option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
											<option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
											<option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
											<option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
											<option value="-3.5">(GMT -3:30) Newfoundland</option>
											<option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
											<option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
											<option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
											<option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
											<option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
											<option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
											<option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
											<option value="3.5">(GMT +3:30) Tehran</option>
											<option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
											<option value="4.5">(GMT +4:30) Kabul</option>
											<option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
											<option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
											<option value="5.75">(GMT +5:45) Kathmandu</option>
											<option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
											<option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
											<option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
											<option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
											<option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
											<option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
											<option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
											<option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
										</select>
									<script>
										jQuery('#uxDefaultTimeZone').val("<?php echo html_entity_decode($default_Time_Zone); ?>");
									</script> 	
								</div>
								</div>
								<div class="row">
									<label>
										<?php _e( "Service Display :", booking_xpress ); ?>
									</label>
									<div class="right">
										<?php
											$servDisplay = $wpdb -> get_var
											(
												$wpdb->prepare
												(	
													'SELECT GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
													"default_Service_Display"
												)
											);
										?>
										<select name="uxServiceDisplayFormat" class="style required" id="uxServiceDisplayFormat" style="width:200px;">
											<?php
												if($servDisplay == 0)
												{
													?>
													<option selected="selected" value="0"><?php _e( "Radio Button", booking_xpress ); ?></option>
													<option value="1"><?php _e( "Drop Down List", booking_xpress ); ?></option>
													<?php
												}
												else 
												{
													?>
													<option  value="0"><?php _e( "Radio Button", booking_xpress ); ?></option>
													<option selected="selected" value="1"><?php _e( "Drop Down List", booking_xpress ); ?></option>
													<?php
												}
											?>
									</select> 	
									</div>
								</div>
								<div class="row" style="border-bottom: !important">
									<label></label>
									<div class="right">
										<button type="submit" class="green" >
											<span>
												<?php _e( "Submit & Save Changes", booking_xpress ); ?>
											</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="display: none">
		<div id="paypalSettings">
			<form id="uxFrmPayPalGatewaySettings" class="form-horizontal" method="post" action="">		
				<div class="message green" id="successPaypalSettingsMessage" style="display:none;margin-left:10px;">
					<span>
						<strong><?php _e( "Success! Paypal Gateway Settings has been saved.", booking_xpress ); ?></strong>
					</span>
				</div>				
				<div class="body">
					<div class="block well" style="margin:10px;">					
						<div class="box">
							<div class="content">
								<div class="row">
		 							<?php
										$paypalStatus = $wpdb -> get_var
										(
											$wpdb->prepare
											(
												'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() . ' where PaymentGatewayKey  = %s',
												"paypal-enabled"
											)
										);
									?>
									<label style="top:10px;" ><?php _e( "PayPal :", booking_xpress ); ?></label>
									<div class="right">
										<?php
										if($paypalStatus == 1)
										{
										?>
												<input type="radio" id="uxPayPalEnable" name="uxPayPal" class="style" onclick="enablePaypalText();" value="1" checked="checked">&nbsp;&nbsp;<?php _e( "Enabled", booking_xpress );?>
												<input type="radio" id="uxPayPalDisable" name="uxPayPal" onclick="disablePaypalText();" class="style" value="0" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", booking_xpress );?>
										<?php
										}
										else 
										{
										?>
												<input type="radio" id="uxPayPalEnable" name="uxPayPal" class="style" onclick="enablePaypalText();" value="1">&nbsp;&nbsp;<?php _e( "Enabled", booking_xpress );?>
												<input type="radio" id="uxPayPalDisable" name="uxPayPal" onclick="disablePaypalText();" class="style" value="0" checked="checked" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", booking_xpress );?>
										<?php
										}
										?>
									</div>
								</div>
								<div class="row" id="paypalUrl" style="display:none">
									 <?php
										$paypalURLTest = $wpdb -> get_var
										(
											$wpdb->prepare
											(
												'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() . ' where PaymentGatewayKey  = %s',
												"paypal-Test-Url"
											)
										);
										?>
									<label style="top:10px;"><?php _e( "PayPal Url :", booking_xpress ); ?></label>
									<div class="right">
										<?php
										if($paypalURLTest == "https://paypal.com/cgi-bin/webscr")
										{
										?>
											<input type="radio" id="uxPaypalUrlLive" name="uxPayPalurl" class="style"  value="https://paypal.com/cgi-bin/webscr" checked="checked">&nbsp;&nbsp;<?php _e( "Live", booking_xpress );?>
											<input type="radio" id="uxPaypalUrlSandbox" name="uxPayPalurl" class="style" value="https://sandbox.paypal.com/cgi-bin/webscr" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Sandbox", booking_xpress );?>
										<?php
										}
										else 
										{
										?>
											<input type="radio" id="uxPaypalUrlLive" name="uxPayPalurl" class="style"  value="https://paypal.com/cgi-bin/webscr">&nbsp;&nbsp;<?php _e( "Live", booking_xpress );?>
											<input type="radio" id="uxPaypalUrlSandbox" name="uxPayPalurl"  class="style" value="https://sandbox.paypal.com/cgi-bin/webscr" checked="checked" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Sandbox", booking_xpress );?>
										<?php
										}
										?>									
									</div>
								</div>
								<div class="row" id="paypalMerchantEmail" style="display: none;">
									<?php
									$paypalMarchantEmail = $wpdb -> get_var
									(
										$wpdb->prepare
										(
												'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() . '  where PaymentGatewayKey  = %s',
												"paypal-merchant-email-address"
										)
									);
									?>
								 <label><?php _e( "Paypal Email :", booking_xpress ); ?></label>			                	 
									 <div class="right">
										<input type="text" class="required span12" name="uxMerchantEmailAddress" id="uxMerchantEmailAddress" value="<?php echo $paypalMarchantEmail; ?>"/>
									</div>
								</div>
								<div class="row" id="paypalThankYou" style="display: none;">
									<?php
									$paypalThankYouUrl = $wpdb -> get_var
									(
										$wpdb->prepare
										(
												'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() . ' where PaymentGatewayKey  = %s',
												"paypal-thankyou-page-url"
										)
									);
									?>
								 <label><?php _e( "Success Page Url :", booking_xpress ); ?></label>
									<div class="right">
										<input type="text" class="required span12" name="uxThankyouPageUrl" id="uxThankyouPageUrl" value="<?php echo $paypalThankYouUrl; ?>"/>
									</div>
								</div>
								<div class="row" id="paypalCancellation" style="display: none;">
									<?php
									$paypalCancelUrl = $wpdb -> get_var
									(
										$wpdb->prepare
										(
												'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() . ' where PaymentGatewayKey  = %s',
												"paypal-payment-cancellation-Url"
										)
									);
									?>
									<label>
									 	<?php _e( "Cancel Page Url :", booking_xpress ); ?>
								 	</label>
										<div class="right">
											<input type="text" class="required span12" name="uxCancellationUrl" id="uxCancellationUrl" value="<?php echo $paypalCancelUrl;  ?>"/>
										</div>
									</div>
								<div class="row" id="paypalIPN" style="display: none;">
									<?php
										$paypalIpnUrl = $url."/paypal.php?action=ipn";
									?>
									<label><?php _e( "IPN Url :", booking_xpress ); ?></label>
										<div class="right">
											<input type="text" class="required span12" name="uxIPNUrl" id="uxIPNUrl" value="<?php echo $paypalIpnUrl;  ?>" disabled="disabled"/>
										</div>
								</div>
								<div class="row" style="border-bottom: !important">
									<label></label>
									<div class="right">
										<button type="submit" class="green">
											<span>
												<?php _e( "Submit & Save Changes", booking_xpress ); ?>
											</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="display: none">
		<div id="autoApproveBookings">
			<form id="uxFrmAutoApprove" class="form-horizontal" method="post" action="">		
				<div class="message green" id="successAutoApproveMessage" style="display:none;margin-left:10px;">
					<span>
						<strong><?php _e( "Success! Auto Approve has been saved.", booking_xpress ); ?></strong>
					</span>
				</div>				
				<div class="body">
					<div class="block well" style="margin:10px;">					
						<div class="box">
							<div class="content">
								<div class="row">
									<label style="top:10px;">
										<?php _e( "Auto Approve :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="radio" id="uxAutoApproveEnable" name="uxAutoApprove"  value="1" checked="checked">&nbsp;&nbsp;<?php _e( "Enabled", booking_xpress );?>
										<input type="radio" id="uxAutoApproveDisable" name="uxAutoApprove"  value="0" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", booking_xpress );?>
									</div>
								</div>
								<div class="row" style="border-bottom: !important">
									<label></label>
									<div class="right">
										<button type="submit" class="green" >
											<span>
												<?php _e( "Submit & Save Changes", booking_xpress ); ?>
											</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="display:none">
		<div id="ReminderSettings" >
			<form id="uxFrmReminderSettings" class="form-horizontal" method="post" action="">
				<div class="message green" id="successReminderSettingsMessage" style="display:none;margin-left:10px;">
					<span>
						<strong><?php _e( "Success! Reminder Settings has been saved.", booking_xpress ); ?></strong>
					</span>
				</div>				
				<div class="body">
					<div class="block well" style="margin:10px;">					
						<div class="box">
							<div class="content">
								<div class="row">
									<label style="top:10px;bottom: 10px;">
										<?php _e( "Reminder Settings", booking_xpress ); ?><span class="req">*</span>
									</label>
									<div class="right">
										<?php
											$ReminderStatus = $wpdb->get_var
											(
												$wpdb->prepare
												(
													'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
													"reminder-settings"
												)
											);
											$ReminderStatusInterval = $wpdb->get_var
											(
												$wpdb->prepare
												(
													'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
													"reminder-settings-interval"
												)
											);
											if($ReminderStatus == 1)
											{
										?>
												<input type="radio" id="uxReminderSettingsEnable" name="uxReminderSettings" onclick="enableReminder();"  value="1" checked="checked" >&nbsp;&nbsp;<?php _e( "Enabled", booking_xpress );?>
												<input type="radio" id="uxReminderSettingsDisable" name="uxReminderSettings" onclick="disableReminder();" value="0" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", booking_xpress );?>
										<?php
											}
											else 
											{
										?>
												<input type="radio" id="uxReminderSettingsEnable" name="uxReminderSettings" onclick="enableReminder();"  value="1" >&nbsp;&nbsp;<?php _e( "Enabled", booking_xpress );?>
												<input type="radio" id="uxReminderSettingsDisable" name="uxReminderSettings" onclick="disableReminder();" checked="checked" value="0" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", booking_xpress );?>
										<?php
											}
								?>
									</div>
								</div>
								<div class="row" id="ReminderIntervalDiv" style="display: none">
									<label><?php _e( "Reminder Interval :", booking_xpress ); ?></label>
									<div class="right">
										<select name="uxReminderInterval" class="required" id="uxReminderInterval" style="width:100px;" >
											<option value="1 hour">1 Hour</option>
											<option value="2 hour">2 Hours</option>
											<option value="4 hour">4 Hours</option>
											<option value="5 hour">5 Hours</option>
											<option value="10 hour">10 Hours</option>
											<option value="12 hour">12 Hours</option>
											<option value="1 Day">1 Day</option>
											<option value="1 week">1 week</option>
										</select>
										<script>
											jQuery("#uxReminderInterval").val("<?php echo $ReminderStatusInterval;?>");
										</script>
									</div>
								</div>
								<div class="row" style="border-bottom: !important">
									<div class="right">
										<button type="submit" class="green">
											<span>
												<?php _e( "Submit & Save Changes", booking_xpress ); ?>	   			
											</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="display: none">
		<div id="BlockOuts">
			<form id="uxFrmBlockOuts" class="form-horizontal" method="post" action="">		
				<div class="message green" id="successExceptionsMessage" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Success! Block Out has been saved.", booking_xpress ); ?>
						</strong>
					</span>
				</div>
				<div class="message red" id="errorExceptionsMessage" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Error! Please Choose Service First.", booking_xpress ); ?>
						</strong>
					</span>
				</div>
				<div class="message red" id="ExceptionsErrorMessage" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Error! Please Enter the Valid Time.", booking_xpress ); ?>
						</strong>
					</span>
				</div>
				<div class="message red" id="ExceptionsWeekErrorMessage" style="display:none;margin-left:10px;">
					<span>
						<strong><?php _e( "Error! Please Select Atleast One Day.", booking_xpress ); ?></strong>
					</span>
				</div>	
				<div class="message red" id="FulldayErrorMessage" style="display:none;margin-left:10px;">
					<span>
						<strong><?php _e( "Error! Selected Service is full day service.", booking_xpress ); ?></strong>
					</span>
				</div>
				<div class="body">
					<div class="block well" style="margin:10px;">
						<div class="box">
							<div class="content">
								<div class="row" style="border-top:none !important;">
									<label>
										<?php _e( "Services :", booking_xpress);?>
									</label>
									<div class="right">
									<?php
										$service = $wpdb->get_results
										(
											$wpdb->prepare
											(
												"SELECT * FROM ".servicesTable()." order by ServiceName ASC",''
											)
										);
									?>
									<select name="uxExceptionsServices" class=" required" id="uxExceptionsServices" onchange="ExceptionsChangeService();" style="width: 95%;">
										<option value="0"><?php _e( "Please Choose Service", booking_xpress ); ?></option>
										<?php
										for( $flagServicesDropdown = 0; $flagServicesDropdown < count($service); $flagServicesDropdown++)
										{
										?>
											<option value ="<?php echo $service[$flagServicesDropdown]->ServiceId;?>"><?php echo $service[$flagServicesDropdown]->ServiceName;?></option>
										<?php 
										} 
										?>
									</select>
									</div>
								</div>
								<div class="row">
									<label>
										<?php _e( "Repeats :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxExceptionsIntervals" class="required" id="uxExceptionsIntervals" onchange="ExceptionsOnChange();"  style="width:100px;" >
											<option value="0"><?php _e( "Daily", booking_xpress ); ?></option>
											<option value="1"><?php _e( "Weekly", booking_xpress ); ?></option>
										</select>
									</div>
								</div>
								<div class="row" id="divExceptionsDays">
									<label>
										<?php _e( "Repeat Every :", booking_xpress ); ?>
									</label>
									<div class="right">
									<select name="uxExceptionsRepeatDay" class="required" id="uxExceptionsRepeatDay" style="width:50px;" >
									<?php
										for ($day = 1; $day <= 31; $day++) 
										{
											echo "<option value=" . $day . " >" . $day . "  </option>";
										}
									?>
									</select>
									<?php _e( "days", booking_xpress );?>
									</div>
								</div>
								<div class="row" id="divExceptionsDayStartsOn">
									<label>
										<?php _e( "Starts On :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="text" name="uxExceptionsStartsOn" id="uxExceptionsStartsOn" />
									</div>
								</div>
								<div class="row" id="divFullDayExceptionsDay">
									<label>
										<?php _e( "Full Day:", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="checkbox" value="1" id="uxFullDayExceptionsDay" name="uxFullDayExceptionsDay" onclick="divExceptionsShowHide();" />
									</div>
								</div>
								<div class="row" id="divExceptionsStartTime">
									<label>
										<?php _e( "Start Time:", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxExceptionsStartTimeHours" class="required" id="uxExceptionsStartTimeHours" style="width:60px;" >
											<?php
											for ($hr = 0; $hr <= 12; $hr++) 
											{
												if ($hr < 10) 
												{
													echo "<option value=0" . $hr . " >0" . $hr . "  </option>";
												}
												else 
												{
													echo "<option value=" . $hr . ">" . $hr . " </option>";
												}
											}
											?>
										</select>
										<select name="uxExceptionsStartTimeMins" class="required" id="uxExceptionsStartTimeMins" style="width:60px;" >
										<?php
										for ($min = 0; $min < 60; $min += 5) 
										{
											if ($min < 10) 
											{
												echo "<option value=0" . $min . ">0" . $min . " </option>";
											}
											else
											{
												echo "<option value=" . $min . ">" . $min . "  </option>";
											}
										}
										?>
										</select>
										<select name="uxExceptionsStartTimeAMPM" class="required" id="uxExceptionsStartTimeAMPM" style="width:60px;" >
											<option value="AM">AM</option>
											<option value="PM">PM</option>
										</select>
									</div>
								</div>
								<div class="row" id="divExceptionsEndTime">
									<label>
										<?php _e( "End Time :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxExceptionsEndTimeHours" class="required" id="uxExceptionsEndTimeHours" style="width:60px;" >
										<?php
										for ($hr = 0; $hr <= 12; $hr++) 
										{
											if ($hr < 10) 
											{
												echo "<option value=0" . $hr . " >0" . $hr . " </option>";
											}
											else 
											{
												echo "<option value=" . $hr . ">" . $hr . " </option>";
											}
										}
										?>
										</select>
										<select name="uxExceptionsEndTimeMins" class="required" id="uxExceptionsEndTimeMins" style="width:60px;" >
										<?php
										for ($min = 0; $min < 60; $min += 5) 
										{
											if ($min < 10) 
											{
												echo "<option value=0" . $min . ">0" . $min . " </option>";
											}
											else
											{
												echo "<option value=" . $min . ">" . $min . " </option>";
											}
										}
										?>
										</select>
										<select name="uxExceptionsEndTimeAMPM" class="required" id="uxExceptionsEndTimeAMPM" style="width:60px;">
											<option value="AM">AM</option>
											<option value="PM">PM</option>
										</select>
									</div>
								</div>
								<div class="row" id="divExceptionsDayEndsOn">
									<label>
										<?php _e( "Ends :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="radio" id="uxExceptionsDayNever" name="uxExceptionsDay" class="style" value="0" checked="checked" onclick="disableExceptionsText();">&nbsp;&nbsp;<?php _e( "Never", booking_xpress );?>
										<input type="radio" id="uxExceptionsDayOn" name="uxExceptionsDay" value="1" class="style" style="margin-left:10px;" onclick="enableExceptionsText();" >&nbsp;&nbsp;<?php _e( "On", booking_xpress );?>
									</div>
									<div class="right" id="ExceptionsEndDate" style="display: none;">
										<input type="text" name="uxExceptionsDayEndsOn" id="uxExceptionsDayEndsOn" style="margin-top:10px;"/>
									</div>
								</div>
								<div class="row" id="divExceptionsRepeatDays">
									<label>
										<?php _e( "Repeat On :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="checkbox" value="Sun" id="uxExceptionsSun" name="uxExceptionsWeekDay1">&nbsp;&nbsp;<?php _e( "Sun", booking_xpress );?>
										<input type="checkbox" value="Mon" id="uxExceptionsMon" name="uxExceptionsWeekDay2" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Mon", booking_xpress );?>
										<input type="checkbox" value="Tue" id="uxExceptionsTue" name="uxExceptionsWeekDay3" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Tue", booking_xpress );?>
										<input type="checkbox" value="Wed" id="uxExceptionsWed" name="uxExceptionsWeekDay4" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Wed", booking_xpress );?>
										<input type="checkbox" value="Thu" id="uxExceptionsThur" name="uxExceptionsWeekDay5" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Thu", booking_xpress );?>
										<input type="checkbox" value="Fri" id="uxExceptionsFri" name="uxExceptionsWeekDay6" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Fri", booking_xpress );?>
										<input type="checkbox" value="Sat" id="uxExceptionsSat" name="uxExceptionsWeekDay7" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Sat", booking_xpress );?>
									</div>
								</div>
								<div class="row" id="divExceptionsWeek">
									<label>
										<?php _e( "Repeat Every :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxExceptionsRepeatWeeks" class="required" id="uxExceptionsRepeatWeeks" style="width:50px;">
										<?php
											for ($weeks = 1; $weeks <= 52; $weeks++) 
											{
												echo "<option value=" . $weeks . " >" . $weeks . "  </option>";
											}
										?>
										</select>
										<?php _e( "weeks", booking_xpress );?>	
									</div>
								</div>
								<div class="row" id="divExceptionsWeekStartsOn">
									<label>
										<?php _e( "Starts On :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="text" name="uxExceptionsWeekStartsOn" id="uxExceptionsWeekStartsOn" />
									</div>
								</div>
								<div class="row" id="divFullDayWeekExceptions">
									<label>
										<?php _e( "Full Day:", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="checkbox" value="1"  id="uxFullDayExceptionsWeek" name="uxFullDayExceptionsWeek" onclick="divExceptionsWeekShowHide();" />
									</div>
								</div>
								<div class="row" id="divExceptionsWeekStartTime">
									<label>
										<?php _e( "Start Time:", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxExceptionsWeekStartTimeHours" class="required" id="uxExceptionsWeekStartTimeHours" style="width:60px;" >
											<?php
											for ($hr = 0; $hr <= 12; $hr++) 
											{
												if ($hr < 10) 
												{
													echo "<option value=0" . $hr . " >0" . $hr . " </option>";
												}
												else 
												{
													echo "<option value=" . $hr . ">" . $hr . " </option>";
												}
											}
											?>
										</select>
										<select name="uxExceptionsWeekStartTimeMins" class="required" id="uxExceptionsWeekStartTimeMins" style="width:60px;" >
										<?php
											for ($min = 0; $min < 60; $min += 5) 
											{
												if ($min < 10) 
												{
													echo "<option value=0" . $min . ">0" . $min . " </option>";
												}
												else
												{
													echo "<option value=" . $min . ">" . $min . " </option>";
												}
											}
										?>
										</select>
										<select name="uxExceptionsWeekStartTimeAMPM" class="required" id="uxExceptionsWeekStartTimeAMPM" style="width:60px;" >
											<option value="AM">AM</option>
											<option value="PM">PM</option>
										</select>
									</div>
								</div>
								<div class="row" id="divExceptionsWeekEndTime">
									<label>
										<?php _e( "End Time :", booking_xpress ); ?>
									</label>
									<div class="right">
										<select name="uxExceptionsWeekEndTimeHours" class="required" id="uxExceptionsWeekEndTimeHours" style="width:60px;" >
										<?php
											for ($hr = 0; $hr <= 12; $hr++) 
											{
												if ($hr < 10) 
												{
													echo "<option value=0" . $hr . " >0" . $hr . " </option>";
												}
												else 
												{
													echo "<option value=" . $hr . ">" . $hr . " </option>";
												}
											}
										?>
										</select>
										<select name="uxExceptionsWeekEndTimeMins" class="required" id="uxExceptionsWeekEndTimeMins" style="width:60px;" >
										<?php
											for ($min = 0; $min < 60; $min += 5) 
											{
												if ($min < 10) 
												{
													echo "<option value=0" . $min . ">0" . $min . " </option>";
												}
												else
												{
													echo "<option value=" . $min . ">" . $min . " </option>";
												}
											}
										?>
										</select>
										<select name="uxExceptionsWeekEndTimeAMPM" class="required" id="uxExceptionsWeekEndTimeAMPM" style="width:60px;" >
											<option value="AM">AM</option>
											<option value="PM">PM</option>
										</select>
									</div>
								</div>
								<div class="row" id="divExceptionsWeekEndsOn">
									<label>
										<?php _e( "Ends:", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="radio" id="uxExceptionsWeekNever" name="uxExceptionsWeek" class="style" value="0" checked="checked" onclick="disableExceptionsTextWeek();">&nbsp;&nbsp;<?php _e( "Never", booking_xpress );?>
										<input type="radio" id="uxExceptionsWeekOn" name="uxExceptionsWeek" value="1" class="style" style="margin-left:10px;" onclick="enableExceptionsTextWeek();">&nbsp;&nbsp;<?php _e( "On", booking_xpress );?>
									</div>
									<div class="right" id="ExceptionsEndDateWeek" style="display: none;">
										<input type="text" name="uxExceptionsWeekEndsOn" id="uxExceptionsWeekEndsOn" style="margin-top:10px;"/>		
									</div>
								</div>
							<script>
								jQuery("#uxExceptionsStartTimeHours").val("09");
								jQuery("#uxExceptionsStartTimeMins").val("00");
								jQuery("#uxExceptionsStartTimeAMPM").val("AM");
								jQuery("#uxExceptionsEndTimeHours").val("05");
								jQuery("#uxExceptionsEndTimeMins").val("00");
								jQuery("#uxExceptionsEndTimeAMPM").val("PM");
								jQuery("#uxExceptionsWeekStartTimeHours").val("09");
								jQuery("#uxExceptionsWeekStartTimeMins").val("00");
								jQuery("#uxExceptionsWeekStartTimeAMPM").val("AM");
								jQuery("#uxExceptionsWeekEndTimeHours").val("05");
								jQuery("#uxExceptionsWeekEndTimeMins").val("00");
								jQuery("#uxExceptionsWeekEndTimeAMPM").val("PM");
							</script>
							<div class="row"  style="border-bottom:!important">
								<label></label>
								<div class="right">
									<button type="submit" class="green">
										<span>
											<?php _e( "Submit & Save Changes", booking_xpress ); ?>	   			
										</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>	
	<div style="display:none">
		<div id="couponsMenu">
			<form id="uxFrmCoupons" class="form-horizontal" method="post" action="">
				<div class="message green" id="successCouponsSettingMessage" style="display:none;margin-left:10px;">
					<span>
						<strong><?php _e( "Success! Coupons has been saved.", booking_xpress); ?></strong>
					</span>
				</div>
				<div class="body">
					<div class="block well" style="margin:10px;">     
						<div class="box">
							<div class="content">
								<div class="row">
									<label>
										<?php _e( "Discount Coupon :", booking_xpress ); ?>
									</label>
									<div class="right">
										<input type="text" class="required span12" name="uxDefaultCoupon" id="uxDefaultCoupon"/>
									</div>
								</div>
								<div class="row">
									<label>
										<?php _e( "Valid From :", booking_xpress );?>
									</label>
									<div class="right">
										<input type="text" class="required span12" name="uxValidFrom" id="uxValidFrom" value=""/>
									</div>
								</div>
								<div class="row">
									<label>
										<?php _e( "Valid Upto :", booking_xpress );?>
									</label>
									<div class="right">
										<input type="text" class="required span12" name="uxValidUpto" id="uxValidUpto" value=""/>
									</div>
								</div>
								<div class="row">
									<label>
										<?php _e( "Amount :", booking_xpress );?>
									</label>
									<div class="right">
										<input type="text" class="required span12" name="uxAmount" id="uxAmount" value=""/>
									</div>
								</div>
								<div class="row">
									<label>
										<?php _e( "Type :", booking_xpress );?>
									</label>
									<div class="right">
										<select id="uxDdlAmountType" name="uxDdlAmountType">
											<option value="0"><?php _e( "Fixed Amount", booking_xpress );?></option>
											<option value="1"><?php _e( "Fixed Percentage", booking_xpress );?></option>
										</select>
									</div>
								</div>
								<div class="row">
									<label style="top:10px;">
										<?php _e( "Apply to All Products :", booking_xpress );?>
									</label>
									<div class="right">
										<input type="checkbox" value="1"  id="uxApplicableOnAllProducts" name="uxApplicableOnAllProducts" onclick="divCouponsHide();" >
									</div>
								</div>
								<div class="row" id="divServices">
									<?php
										$service = $wpdb->get_results
										(
											$wpdb->prepare
											(
												"SELECT * FROM ".servicesTable()." order by ServiceName ASC",''
											)
										);
									?>
									<label>
										<?php _e( "Services :", booking_xpress);?>
									</label>
									<div class="right">
										<select name="uxDdlBookingServices" class="style required span12" id="uxDdlBookingServices" multiple="multiple" style="width:500px;">
										<?php
											for( $flagServicesDropdown = 0; $flagServicesDropdown < count($service); $flagServicesDropdown++)
											{
										?>
											<option value ="<?php echo $service[$flagServicesDropdown]->ServiceId;?>"><?php echo $service[$flagServicesDropdown]->ServiceName;?></option>
										<?php 
											} 
										?>
										</select>
									</div>
								</div>
								<div class="row" style="border-bottom:!important">
									<label></label>
									<div class="right">
										<button type="submit" class="green">
											<span>
												<?php _e( "Submit & Save Changes", booking_xpress ); ?>
											</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="display: none">
		<div id="bookNewService">
			<div class="body">
				<?php include_once 'booking-calendar-back-end.php' ?>
			</div> 
		</div>
	</div>	
	<div style="display:none">	
		<div id="shortcodes" >
			<form id="uxFrmSortcodes" class="form-horizontal" method="post" action="#">
				<div class="body">
					<div class="block well" style="margin:10px;">
						<div class="box">
							<div class="content">
								<div class="row">
									<label><?php _e( "Bookings Full Calendar Embed :", booking_xpress ); ?></label>
									<div class="right">
										<textarea   id="singleServiceCode" rows="2"  style="width:100%">[bookingXpressFullCalendarEmbed][/bookingXpressFullCalendarEmbed]</textarea>
									</div>
								</div>
								<div class="row">
									<label><?php _e( "Booking Front End Embed Form :", booking_xpress ); ?>
									</label>
									<div class="right">
										<textarea id="allServicesCode" rows="2"  style="width:100%">[bookingXpressBookingFrontEndEmbed][/bookingXpressBookingFrontEndEmbed]</textarea>
									</div>
								</div>
								<div class="row">
									<label><?php _e( "Booking Front End Popup Form :", booking_xpress ); ?>
									</label>
									<div class="right">
										<textarea id="allServicesCode" rows="2"  style="width:100%">[bookingXpressBookingFrontEndPopUp][/bookingXpressBookingFrontEndPopUp]</textarea>
									</div>
								</div>
								<div class="row">
									<label><?php _e( "Booking Front End Classic Popup Form :", booking_xpress ); ?>
									</label>
									<div class="right">
										<textarea id="allServicesCode" rows="2"  style="width:100%">[bookingXpressBookingFrontEndClassicPopUp][/bookingXpressBookingFrontEndClassicPopUp]</textarea>
									</div>
								</div>
								
								<div class="row">
									<label><?php _e( "Booking Front End Classic Embed Form :", booking_xpress ); ?>
									</label>
									<div class="right">
										<textarea id="allServicesCode" rows="2"  style="width:100%">[bookingXpressBookingFrontEndClassicEmbedForm][/bookingXpressBookingFrontEndClassicEmbedForm]</textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div style="display: none">
		<div id="EditBooking">
			<div class="message green" id="successMessage" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Success! The Customer has been Updated.", booking_xpress ); ?>	
					</strong>
				</span>
			</div>
			<div class="message green" id="successMessageUpdateBooking" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Success! The Booking has been Updated.", booking_xpress ); ?>	
					</strong>
				</span>
			</div>
			<form id="uxFrmEditBooking" class="form-horizontal" method="post" action="#">
				<div class="block well">
					 <div class="body" id="bookingDetails"></div>
				</div>
				<input type="hidden" id="bookingId" value="" />
				<div class="row" style="border-bottom:!important">
					<label></label>
					<div class="right">
						<button type="submit" class="green">
							<span>
								<?php _e( "Submit & Save Changes", booking_xpress ); ?>
							</span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
	jQuery(".inline").colorbox({inline:true, width:"700px"});
		jQuery("#Dashboard").attr("class","current"); 
		jQuery.post(ajaxurl, "param=getFacebookStatus&action=dashboardLibrary", function(data)
		{
			jQuery("#uxDashboardFacebookConnect").html(data);
			jQuery.colorbox.resize();
		});
		
		jQuery.post(ajaxurl, "param=getMailChimpStatus&action=dashboardLibrary", function(data)
		{
			jQuery("#uxDashboardMailChimpSettings").html(data);
			jQuery.colorbox.resize();
		});
		jQuery(document).ready(function() 
		{
			
			ExceptionsOnChange();
			enableFBText();
			disableFBText();
			enableMailChimpText();
			disableMailChimpText();
			
			jQuery('.hovertip').tooltip();
			jQuery('#uxServiceColor').ColorPicker
			({		
				onSubmit: function(hsb, hex, rgb, el) 
				{
					jQuery(el).val( '#' + hex);
					jQuery(el).ColorPickerHide();
				},
				onBeforeShow: function() 
				{
					jQuery(this).ColorPickerSetColor(this.value);
				}
			}).bind('onblur', function()
			{
				jQuery(this).ColorPickerSetColor(this.value);
			});
			var RSEnable = jQuery('input:radio[name=uxReminderSettings]:checked').val();
			if(RSEnable == 1)
			{
				
				jQuery('#ReminderIntervalDiv').attr('style','');
			}
			else
			{
				jQuery('#ReminderIntervalDiv').css('display','none');
				jQuery.colorbox.resize(); 
				
			}
	
			var PaypalEnable = jQuery('input:radio[name=uxPayPal]:checked').val();
			if(PaypalEnable == 1)
			{
				jQuery('#paypalUrl').attr('style','');
				jQuery('#paypalMerchantEmail').attr('style','');
				jQuery('#paypalThankYou').attr('style','');
				jQuery('#paypalIPN').attr('style','');	   		
				jQuery('#paypalCancellation').attr('style','');
				jQuery.colorbox.resize();
			}
			else
			{
				jQuery('#paypalUrl').css('display','none');
				jQuery('#paypalMerchantEmail').css('display','none');
				jQuery('#paypalThankYou').css('display','none');
				jQuery('#paypalIPN').css('display','none');
				jQuery('#paypalCancellation').css('display','none');
				jQuery.colorbox.resize();
			} 
			var uxReminderSettings =  jQuery('input:radio[name=uxReminderSettings]:checked').val();
			jQuery.post(ajaxurl,"uxReminderSettings="+uxReminderSettings+"&param=ReminderSettingsShow&action=dashboardLibrary", function(data)
			{
				if(data == "On")
				{
					jQuery('#uxReminderSettingsEnable').attr('checked','checked');
					jQuery('#uxDashboardReminderSettings').html(data);
					jQuery.colorbox.resize(); 
				}
				else
				{
					jQuery('#uxReminderSettingsDisable').attr('checked','checked');
					jQuery('#uxDashboardReminderSettings').html(data);
					jQuery.colorbox.resize(); 
				}
			}); 
			var uxAutoApprove = jQuery('input:radio[name=uxAutoApprove]:checked').val();
			jQuery.post(ajaxurl, "uxAutoApprove="+uxAutoApprove+"&param=AutoApproveShow&action=dashboardLibrary", function(data)
			{
				if(data == "On")
				{
					jQuery('#uxAutoApproveEnable').attr('checked','checked');
					jQuery('#uxDashboardAutoApprove').html(data);
					jQuery.colorbox.resize();
				}
				else
				{
					jQuery('#uxAutoApproveDisable').attr('checked','checked');
					jQuery('#uxDashboardAutoApprove').html(data);
					jQuery.colorbox.resize();
				}
			});
		});
		function enableReminder()
		{
			var RSEnable = jQuery('input:radio[name=uxReminderSettings]:checked').val();
			if(RSEnable == 1)
			{
				jQuery('#ReminderIntervalDiv').attr('style','');
				jQuery.colorbox.resize();
			}
		}
		function disableReminder()
		{
			var RSEnable = jQuery('input:radio[name=uxReminderSettings]:checked').val();
			if(RSEnable == 0)
			{
				jQuery('#ReminderIntervalDiv').css('display','none');
				jQuery.colorbox.resize();
			}
		}
		function enableFBText()
		{
			var FBEnable = jQuery('input:radio[name=uxFacebookConnect]:checked').val();
			if(FBEnable == 1)
			{
				jQuery('#facebookAPI').attr('style','');
				jQuery('#facebookSecret').attr('style','');
				jQuery.colorbox.resize();
			}
		}
		function disableFBText()
		{
			var FBEnable = jQuery('input:radio[name=uxFacebookConnect]:checked').val();
			if(FBEnable == 0)
				{
					jQuery('#facebookAPI').css('display','none');
					jQuery('#facebookSecret').css('display','none');
					jQuery.colorbox.resize();
				}
		}
		function enableMailChimpText()
		{
			var MailChimp = jQuery('input:radio[name=uxMailChimp]:checked').val();
			if(MailChimp == 1)
			{
				jQuery('#mailApiKey').attr('style','');
				jQuery('#mailUniqueId').attr('style','');
				jQuery('#mailOptIn').attr('style','');
				jQuery('#mailEmail').attr('style','');
				jQuery.colorbox.resize();
			}
		}
		function disableMailChimpText()
		{
			var MailChimp = jQuery('input:radio[name=uxMailChimp]:checked').val();
			if(MailChimp == 0)
	 		{
				jQuery('#mailApiKey').css('display','none');
				jQuery('#mailUniqueId').css('display','none');
				jQuery('#mailOptIn').css('display','none');
				jQuery('#mailEmail').css('display','none');
				jQuery.colorbox.resize();
			}
		}	
		function enablePaypalText()
		{
		
			var PaypalEnable = jQuery('input:radio[name=uxPayPal]:checked').val();
			if(PaypalEnable == 1)
			{
				jQuery('#paypalUrl').attr('style','');
			jQuery('#paypalMerchantEmail').attr('style','');
			jQuery('#paypalThankYou').attr('style','');
			jQuery('#paypalIPN').attr('style','');
			jQuery('#paypalCancellation').attr('style','');
			jQuery.colorbox.resize();
			}
		}
		function disablePaypalText()
		{
			var PaypalEnable = jQuery('input:radio[name=uxPayPal]:checked').val();
			if(PaypalEnable == 0)
			{
				jQuery('#paypalUrl').css('display','none');
				jQuery('#paypalMerchantEmail').css('display','none');
				jQuery('#paypalThankYou').css('display','none');
				jQuery('#paypalIPN').css('display','none');
				jQuery('#paypalCancellation').css('display','none');
				jQuery.colorbox.resize();
			}
		}
		jQuery("#uxFrmFacebookSettings").validate
		({
			highlight: function(label) 
			{
				jQuery.colorbox.resize();
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid');
				jQuery.colorbox.resize();
			},
			submitHandler: function(form) 
			{
				jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=UpdateFacebookSocialMedia&action=dashboardLibrary", function(data) 
					{
						jQuery('#successFacebookSettingsMessage').css('display','block');
						jQuery.colorbox.resize();
						setTimeout(function() 
						{
							jQuery('#successFacebookSettingsMessage').css('display','none');
							jQuery.colorbox.resize();
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
						}, 2000);
				});
			}
		});
		jQuery("#uxFrmMailChimpSettings").validate
		({
			rules: 
			{
				uxMailChimpApiKey: "required",
				uxMailChimpUniqueId: "required",
			},
			highlight: function(label) 
			{
				jQuery.colorbox.resize();
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid');
				jQuery.colorbox.resize();
			},
			submitHandler: function(form) 
			{
				jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=UpdateAutoResponder&action=dashboardLibrary", function(data)  
				{
					
					jQuery('#successMailChimpSettingsMessage').css('display','block');
					jQuery.colorbox.resize();
					setTimeout(function()
					{
						jQuery('#successMailChimpSettingsMessage').css('display','none');
						jQuery.colorbox.resize(); 
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}, 2000);
					jQuery.colorbox.resize(); 
				});
			}
		});
		jQuery('#uxServiceMins').val(30);
		jQuery("#uxFrmAddServices").validate
		({
			rules: 
			{
				uxServiceName: "required",
				uxServiceCost: 
				{
					required: true,
					number: true
				},
				uxMaxBookings: 
				{
					required: true,
					digits: true
				
				},
				uxServiceHours:
				{
					required : true,
				},
				uxServiceMins:
				{
					required : true,
				}
			},			
			highlight: function(label) 
			{	
				jQuery.colorbox.resize();
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid');
				jQuery.colorbox.resize();
			},
			submitHandler: function(form)
			{
				var uxServiceType = jQuery('input:radio[name=uxServiceType]:checked').val();
				var uxMaxBookings = jQuery('#uxMaxBookings').val();
				var uxStartTimeHours = jQuery('#uxStartTimeHours').val();
				var uxStartTimeMins = jQuery('#uxStartTimeMins').val();
				var uxStartTimeAMPM = jQuery('#uxStartTimeAMPM').val();
				var uxEndTimeHours = jQuery('#uxEndTimeHours').val();
				var uxEndTimeMins = jQuery('#uxEndTimeMins').val();
				var uxEndTimeAMPM = jQuery('#uxEndTimeAMPM').val();
				var uxFullDayService = jQuery("#uxFullDayService").prop("checked");
				var uxServiceHours = jQuery('#uxServiceHours').val();
				var uxServiceMins = jQuery('#uxServiceMins').val();
				var serviceTime = (parseInt(uxServiceHours) * 60) + parseInt(uxServiceMins);
				
				if(uxStartTimeAMPM == "PM")
				{
					if(uxStartTimeHours <= 11)
					{
						 var uxStartTimeHour = parseInt(uxStartTimeHours) + 12;
					}
					else if(uxStartTimeHours == 12)
					{
						uxStartTimeHour = 12;
					}
				}
				else if(uxStartTimeAMPM == "AM")
				{
					if(uxStartTimeHours == 12)
					{
						uxStartTimeHour = 0;
					}
					else 
					{
						uxStartTimeHour = uxStartTimeHours;
					}
				}
				if(uxEndTimeAMPM == "PM")
				{
					if(uxEndTimeHours <= 11)
					{
						var uxEndTimeHour = parseInt(uxEndTimeHours) + 12;
					}
					else if(uxEndTimeHours == 12)
					{
						var uxEndTimeHour = 12;
					}
				}
				else if(uxEndTimeAMPM == "AM")
				{
					if(uxEndTimeHours == 12)
					{
						var uxEndTimeHour = 0;
					}
					else 
					{
						var uxEndTimeHour = uxEndTimeHours;
					}
				}
				
				if(uxFullDayService == true)
				{	
					if(uxServiceType == 1 && uxMaxBookings > 1)
					{
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=addService&action=dashboardLibrary", function(data) 
						{
							jQuery('#timeErrorMessage').css('display','none');
							jQuery('#errorMessageServices').css('display','none');
							jQuery('#serviceTimeErrorMessage').css('display','none');
							jQuery('#successMessageService').css('display','block');
							jQuery.colorbox.resize();
							setTimeout(function() 
							{
								jQuery('#successMessageService').css('display','none');
								var checkPage = "<?php echo $_REQUEST['page']; ?>";
								window.location.href = "admin.php?page="+checkPage;
							}, 2000);
						});
					}
					else if(uxServiceType == 0)
					{
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=addService&action=dashboardLibrary", function(data) 
						{
							jQuery('#errorMessageServices').css('display','none');
							jQuery('#timeErrorMessage').css('display','none');
							jQuery('#serviceTimeErrorMessage').css('display','none');
							jQuery('#successMessageService').css('display','block');
							jQuery.colorbox.resize();
							setTimeout(function() 
							{
								jQuery('#successMessageService').css('display','none');
								jQuery.colorbox.resize(); 
								var checkPage = "<?php echo $_REQUEST['page']; ?>";
								window.location.href = "admin.php?page="+checkPage;
							}, 2000);
						});
					}
					else
					{
						jQuery('#timeErrorMessage').css('display','none');
						jQuery('#serviceTimeErrorMessage').css('display','none');
						jQuery('#errorMessageServices').css('display','block');
						jQuery.colorbox.resize();
					}
				}
				else if(uxServiceType == 1 && uxMaxBookings > 1)
				{
					if(serviceTime == 0)
					{
						jQuery('#errorMessageServices').css('display','none');
						jQuery('#timeErrorMessage').css('display','none');
						jQuery('#serviceTimeErrorMessage').css('display','block');
						jQuery.colorbox.resize();
					}
					else if((uxStartTimeHour * 60 + parseInt(uxStartTimeMins) >= uxEndTimeHour * 60 + parseInt(uxEndTimeMins)))
					{
						jQuery('#errorMessageServices').css('display','none');
						jQuery('#serviceTimeErrorMessage').css('display','none');
						jQuery('#timeErrorMessage').css('display','block');
						jQuery.colorbox.resize();
					}
					else
					{
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=addService&action=dashboardLibrary", function(data)  
						{  
							jQuery('#timeErrorMessage').css('display','none');
							jQuery('#errorMessageServices').css('display','none');
							jQuery('#serviceTimeErrorMessage').css('display','none');
							jQuery('#successMessageService').css('display','block');
							jQuery.colorbox.resize();
							setTimeout(function() 
							{
								jQuery('#successMessageService').css('display','none');
								jQuery.colorbox.resize(); 
								var checkPage = "<?php echo $_REQUEST['page']; ?>";
								window.location.href = "admin.php?page="+checkPage;
							}, 2000);	
						});
					}
				}
				else if(uxServiceType == 0)
				{
					if(serviceTime == 0)
					{
						jQuery('#errorMessageServices').css('display','none');
						jQuery('#timeErrorMessage').css('display','none');
						jQuery('#serviceTimeErrorMessage').css('display','block');
						jQuery.colorbox.resize();
					}
					else if((uxStartTimeHour * 60 + parseInt(uxStartTimeMins) >= uxEndTimeHour * 60 + parseInt(uxEndTimeMins)))
					{
						jQuery('#errorMessageServices').css('display','none');
						jQuery('#serviceTimeErrorMessage').css('display','none');
						jQuery('#timeErrorMessage').css('display','block');
						jQuery.colorbox.resize();
					}
					else
					{
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=addService&action=dashboardLibrary", function(data)  
						{
							jQuery('#errorMessageServices').css('display','none');
							jQuery('#timeErrorMessage').css('display','none');
							jQuery('#serviceTimeErrorMessage').css('display','none');
							jQuery('#successMessageService').css('display','block');
							jQuery.colorbox.resize();
							setTimeout(function() 
							{
								jQuery('#successMessageService').css('display','none');
								jQuery.colorbox.resize(); 
								var checkPage = "<?php echo $_REQUEST['page']; ?>";
								window.location.href = "admin.php?page="+checkPage;
							}, 2000);
						});
					}
				}
				else
				{
					jQuery('#timeErrorMessage').css('display','none');
					jQuery('#serviceTimeErrorMessage').css('display','none');
					jQuery('#errorMessageServices').css('display','block');
					jQuery.colorbox.resize();
				}
			}
			
		});
		jQuery('#uxMaxBookings').on('keypress', function(evt) 
			{
				var charCode = (evt.which) ? evt.which : event.keyCode;
				return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
			});
		function singleBooking()
		{
		 	jQuery('#maxBooking').css('display','none');
			jQuery.colorbox.resize();
		}
		function groupBooking()
		{
		jQuery('#maxBooking').css('display','block');
		jQuery.colorbox.resize();
		}	
		var PaypalEnable = jQuery('input:radio[name=uxPayPal]:checked').val();
		if(PaypalEnable == 0)
		 {
			jQuery("#uxFrmPayPalGatewaySettings").validate
			({
				rules: 
				{
					uxMerchantEmailAddress: 
					{
						required: true,
						email:true
					},
					uxThankyouPageUrl: "required",
					uxPaymentImageUrl: "required",
					uxPaymentCancellationMessage: "required"
				},
				highlight: function(label) 
				{
					jQuery.colorbox.resize();
				},
				success: function(label)
				{
					label
					.text('Success!').addClass('valid');
					jQuery.colorbox.resize();
				},
				submitHandler: function(form) 
				{
					jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=UpdatePaymentGateway&action=dashboardLibrary", function(data)
					{ 
						jQuery('#successPaypalSettingsMessage').css('display','block');
						jQuery.colorbox.resize();
						setTimeout(function() 
						{
							jQuery('#successPaypalSettingsMessage').css('display','none');
							jQuery.colorbox.resize(); 
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
						}, 2000);
					});
				}
			});
		}
		else
		{
			jQuery("#uxFrmPayPalGatewaySettings").validate
			({
				highlight: function(label) 
				{
					jQuery.colorbox.resize();
				},
				success: function(label) 
				{
					label
					.text('Success!').addClass('valid');
					jQuery.colorbox.resize();
				},
				submitHandler: function(form) 
				{
					jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=UpdatePaymentGateway&action=dashboardLibrary", function(data) 
					{ 
						jQuery('#successPaypalSettingsMessage').css('display','block');
						jQuery.colorbox.resize();
						setTimeout(function() 
						{
							jQuery('#successPaypalSettingsMessage').css('display','none');
							jQuery.colorbox.resize(); 
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
						}, 2000);
					});
				}
			 });
		}
			jQuery.post(ajaxurl, "param=getPaypalStatus&action=dashboardLibrary", function(data) 
			{
				jQuery("#uxDashboardPaypalSettings").html(data);
				jQuery.colorbox.resize();
			});
		jQuery("#uxFrmAutoApprove").validate
		({
			highlight: function(label) 
			{
				jQuery.colorbox.resize();
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid');
				jQuery.colorbox.resize();
			},
			submitHandler: function(form) 
			{
				jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=AutoApprove&action=dashboardLibrary", function(data)
				{
					jQuery('#successAutoApproveMessage').css('display','block');
					jQuery.colorbox.resize();
					setTimeout(function() 
					{
						jQuery('#successAutoApproveMessage').css('display','none');
						jQuery.colorbox.resize(); 
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}, 2000);
				});
			}
		});
		function DeleteAllBookings()
		{
			bootbox.confirm("<?php _e("Are you sure you want to Delete All Bookings?", booking_xpress ); ?>", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.post(ajaxurl, "&param=DeleteAllBookings&action=dashboardLibrary", function(data)
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					});
				}
			});  
		}
		function RestoreFactorySettings()
		{
			bootbox.confirm("<?php _e("Are you sure you want to Restore Factory Settings ?", booking_xpress ); ?>", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.post(ajaxurl, "&param=RestoreFactorySettings&action=dashboardLibrary", function(data)
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					});
					
				}
			});
		}
		function deleteBooking(bookingId)
		{
			bootbox.confirm("<?php _e("Are you sure you want to delete this Booking?", booking_xpress ); ?>", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.post(ajaxurl, "bookingId="+bookingId+"&param=deleteBooking&action=dashboardLibrary", function(data)
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					});
				}
			});
		}
		function resendEmail(bookingId,status)
		{
			jQuery.post(ajaxurl, "bookingId="+bookingId+"&status="+status+"&param=resendBookingEmail&action=dashboardLibrary", function(data) 
			{	
				bootbox.alert('<?php _e("Email has been Sent successfully.", booking_xpress ); ?>');	
			});
		}
		<?php
		$paypalEnable = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT PaymentGatewayValue FROM ".payment_Gateway_settingsTable()." where PaymentGatewayKey = %s",
				'paypal-enabled'
			)
		);
		if($paypalEnable == 1)
		{
		?>
			oTable = jQuery('#data-table-upcoming-events').dataTable
			({
				"bJQueryUI": false,
				"bAutoWidth": true,
				"sPaginationType": "full_numbers",
				"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
				"oLanguage": 
				{
					"sLengthMenu": "_MENU_"
				},
				"aaSorting": [[ 5, "asc" ]],
				"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] },{ "bSortable": false, "aTargets": [ 6 ] }]
			});
		<?php
		}
		else
		{
		?>
			oTable = jQuery('#data-table-upcoming-events').dataTable
			({
					"bJQueryUI": false,
					"bAutoWidth": true,
					"sPaginationType": "full_numbers",
					"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
					"oLanguage": 
					{
						"sLengthMenu": "_MENU_"
					},
					"aaSorting": [[ 4, "asc" ]],
					"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 5 ] }]
			});
		<?php
		}
		?>
		jQuery("#uxFrmReminderSettings").validate
		({
			highlight: function(label) 
			{	
				jQuery.colorbox.resize();
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid');
				jQuery.colorbox.resize();
			},
			submitHandler: function(form) 
			{
				var uxReminderInterval = jQuery('#uxReminderInterval').val();		    	    
				var uxReminderSettings =  jQuery('input:radio[name=uxReminderSettings]:checked').val();
				jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=UpdateReminderSettings&action=dashboardLibrary", function(data)
				{ 
					jQuery('#successReminderSettingsMessage').css('display','block');
					jQuery.colorbox.resize();
					setTimeout(function() 
					{
						jQuery('#successReminderSettingsMessage').css('display','none');
						jQuery.colorbox.resize();
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}, 2000);
				});
			}
		});
		function divControlsShowHide()
		{
			var uxFullDay = jQuery("#uxFullDayService").prop("checked");
		
			if(uxFullDay == true)
			{
				jQuery("#divServiceTime").css('display','none');
				jQuery("#divStartTime").css('display','none');
				jQuery("#divEndTime").css('display','none');
				jQuery("#divMaxDays").css('display','block');
				jQuery("#divCostType").css('display','block');
				jQuery.colorbox.resize();
			}
			else
			{
				jQuery("#divCostType").css('display','none');
				jQuery("#divMaxDays").css('display','none');
				jQuery("#divServiceTime").css('display','block');
				jQuery("#divStartTime").css('display','block');
				jQuery("#divEndTime").css('display','block');
				jQuery.colorbox.resize();
			}
		}
		jQuery("#uxFrmBlockOuts").validate
		({	
			rules: 
			{
				uxExceptionsStartsOn: 
				{
					required: true,
				},
				uxExceptionsDayEndsOn:
				{
					required : true,
				},
				uxExceptionsWeekStartsOn: 
				{
					required: true,
				},
				uxExceptionsWeekEndsOn:
				{
					required : true,
				}
			},	
			highlight: function(label) 
			{
				
				jQuery.colorbox.resize();
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid');
				jQuery.colorbox.resize();
			},
			submitHandler: function(form) 
			{
				var uxExceptionsIntervals = jQuery('#uxExceptionsIntervals').val();
				var uxExceptionsStartTimeHours = jQuery('#uxExceptionsStartTimeHours').val();
				var uxExceptionsStartTimeMins = jQuery('#uxExceptionsStartTimeMins').val();
				var uxExceptionsStartTimeAMPM = jQuery('#uxExceptionsStartTimeAMPM').val();
				var uxExceptionsEndTimeHours = jQuery('#uxExceptionsEndTimeHours').val();
				var uxExceptionsEndTimeMins = jQuery('#uxExceptionsEndTimeMins').val();
				var uxExceptionsEndTimeAMPM = jQuery('#uxExceptionsEndTimeAMPM').val();
				var uxExceptionsWeekStartTimeHours = jQuery('#uxExceptionsWeekStartTimeHours').val();
				var uxExceptionsWeekStartTimeMins = jQuery('#uxExceptionsWeekStartTimeMins').val();
				var uxExceptionsWeekStartTimeAMPM = jQuery('#uxExceptionsWeekStartTimeAMPM').val();
				var uxExceptionsWeekEndTimeHours = jQuery('#uxExceptionsWeekEndTimeHours').val();
				var uxExceptionsWeekEndTimeMins = jQuery('#uxExceptionsWeekEndTimeMins').val();
				var uxExceptionsWeekEndTimeAMPM = jQuery('#uxExceptionsWeekEndTimeAMPM').val();
				var uxFullDayExceptionsDay = jQuery('#uxFullDayExceptionsDay').prop("checked");
				var uxFullDayExceptionsWeek = jQuery('#uxFullDayExceptionsWeek').prop("checked");
				
				if(uxExceptionsStartTimeAMPM == "PM")
				{
					if(uxExceptionsStartTimeHours <= 11)
					{
						uxExceptionsStartTimeHour = parseInt(uxExceptionsStartTimeHours) + 12;
					}
					else if(uxExceptionsStartTimeHours == 12)
					{
						uxExceptionsStartTimeHour = 12;
					}
				}
				else if(uxExceptionsStartTimeAMPM == "AM")
				{
					if(uxExceptionsStartTimeHours == 12)
					{
						uxExceptionsStartTimeHour = 0;
					}
					else 
					{
						uxExceptionsStartTimeHour = uxExceptionsStartTimeHours;
					}
				}
				if(uxExceptionsEndTimeAMPM == "PM")
				{
					if(uxExceptionsEndTimeHours <= 11)
					{
						uxExceptionsEndTimeHour = parseInt(uxExceptionsEndTimeHours) + 12;
					}
					else if(uxExceptionsEndTimeHours == 12)
					{
						uxExceptionsEndTimeHour = 12;
					}
				}
				else if(uxExceptionsEndTimeAMPM == "AM")
				{
					if(uxExceptionsEndTimeHours == 12)
					{
						uxExceptionsEndTimeHour = 0;
					}
					else 
					{
						uxExceptionsEndTimeHour = uxExceptionsEndTimeHours;
					}
				}
				
				var ExceptionDayTotalStartTime = uxExceptionsStartTimeHour * 60 + parseInt(uxExceptionsStartTimeMins);
				var ExceptionDayTotalEndTime = uxExceptionsEndTimeHour * 60 + parseInt(uxExceptionsEndTimeMins);
				if(uxExceptionsWeekStartTimeAMPM == "PM")
				{
					if(uxExceptionsWeekStartTimeHours <= 11)
					{
						uxExceptionsWeekStartTimeHour = parseInt(uxExceptionsWeekStartTimeHours) + 12;
					}
					else if(uxExceptionsWeekStartTimeHours == 12)
					{
						uxExceptionsWeekStartTimeHour = 12;
					}
				}
				else if(uxExceptionsWeekStartTimeAMPM == "AM")
				{
					if(uxExceptionsWeekStartTimeHours == 12)
					{
						uxExceptionsWeekStartTimeHour = 0;
					}
					else 
					{
						uxExceptionsWeekStartTimeHour = uxExceptionsWeekStartTimeHours;
					}
				}
				if(uxExceptionsWeekEndTimeAMPM == "PM")
				{
					if(uxExceptionsWeekEndTimeHours <= 11)
					{
						uxExceptionsWeekEndTimeHour = parseInt(uxExceptionsWeekEndTimeHours) + 12;
					}
					else if(uxExceptionsWeekEndTimeHours == 12)
					{
						uxExceptionsWeekEndTimeHour = 12;
					}
				}
				else if(uxExceptionsWeekEndTimeAMPM == "AM")
				{
					if(uxExceptionsWeekEndTimeHours == 12)
					{
						uxExceptionsWeekEndTimeHour = 0;
					}
					else 
					{
						uxExceptionsWeekEndTimeHour = uxExceptionsWeekEndTimeHours;
					}
				}
				var repeatDays = "";
				var uxExceptionsSun = jQuery('input:checkbox[id=uxExceptionsSun]').prop("checked");
				if(uxExceptionsSun)
				{
				 	repeatDays += "Sun" + ",";	
				}
				var uxExceptionsMon = jQuery('input:checkbox[id=uxExceptionsMon]').prop("checked");
				if(uxExceptionsMon)
				{
				repeatDays += "Mon" + ",";	
				}
				var uxExceptionsTue = jQuery('input:checkbox[id=uxExceptionsTue]').prop("checked");
				if(uxExceptionsTue)
				{
					repeatDays += "Tue" + ",";	
				}
				var uxExceptionsWed = jQuery('input:checkbox[id=uxExceptionsWed]').prop("checked");
				if(uxExceptionsWed)
				{
					repeatDays += "Wed" + ",";	
				}
				var uxExceptionsThur = jQuery('input:checkbox[id=uxExceptionsThur]').prop("checked");
				if(uxExceptionsThur)
				{
					repeatDays += "Thu" + ",";	
				}
				var uxExceptionsFri = jQuery('input:checkbox[id=uxExceptionsFri]').prop("checked");
				if(uxExceptionsFri)
				{
				 	repeatDays += "Fri" + ",";	
				}
				var uxExceptionsSat = jQuery('input:checkbox[id=uxExceptionsSat]').prop("checked");
				if(uxExceptionsSat)
				{
				 	repeatDays += "Sat" + ",";	
				}
				var ExceptionWeekTotalStartTime = uxExceptionsWeekStartTimeHour * 60 + parseInt(uxExceptionsWeekStartTimeMins);
				var ExceptionWeekTotalEndTime = uxExceptionsWeekEndTimeHour * 60 + parseInt(uxExceptionsWeekEndTimeMins);
				var serviceId = jQuery("#uxExceptionsServices").val();
				jQuery.post(ajaxurl, "serviceId="+serviceId+"&param=getServiceFullDay&action=dashboardLibrary", function(data)
				{
					var dat = data.trim();
					if(uxExceptionsIntervals == 0)
					{
						if(uxFullDayExceptionsDay == true)
						{
							if(serviceId == 0)
							{
								jQuery('#ExceptionsErrorMessage').css('display','none');
								jQuery('#FulldayErrorMessage').css('display','none');
								jQuery('#errorExceptionsMessage').css('display','block');
								jQuery.colorbox.resize();
							}
							else
							{
								jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=insertExceptionDays&action=dashboardLibrary", function(data) 
								{
									jQuery('#ExceptionsErrorMessage').css('display','none');
									jQuery('#errorExceptionsMessage').css('display','none');
									jQuery('#FulldayErrorMessage').css('display','none');
									jQuery('#successExceptionsMessage').css('display','block');
									jQuery.colorbox.resize();
									setTimeout(function() 
									{
										jQuery('#successExceptionsMessage').css('display','none');
										jQuery.colorbox.resize();
										var checkPage = "<?php echo $_REQUEST['page']; ?>";
										window.location.href = "admin.php?page="+checkPage;
										jQuery.colorbox.resize();
									}, 2000);
								});
							}
						}
						else
						{
							if(serviceId == 0)
							{
								jQuery('#ExceptionsErrorMessage').css('display','none');
								jQuery('#FulldayErrorMessage').css('display','none');
								jQuery('#errorExceptionsMessage').css('display','block');
								jQuery.colorbox.resize();
							}
							else if(ExceptionDayTotalStartTime >= ExceptionDayTotalEndTime)
							{
								jQuery('#errorExceptionsMessage').css('display','none');
								jQuery('#FulldayErrorMessage').css('display','none');
								jQuery('#ExceptionsErrorMessage').css('display','block');
								jQuery.colorbox.resize();
							}
							else if(dat == 1 && uxFullDayExceptionsDay != 1)
				 			{	
				 				jQuery('#errorExceptionsMessage').css('display','none');
								jQuery('#ExceptionsErrorMessage').css('display','none');
				 				jQuery('#FulldayErrorMessage').css('display','block');
				 				jQuery.colorbox.resize();
				 			}	
							else
							{
								jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=insertExceptionDays&action=dashboardLibrary", function(data) 
								{
									jQuery('#ExceptionsErrorMessage').css('display','none');
									jQuery('#errorExceptionsMessage').css('display','none');
									jQuery('#FulldayErrorMessage').css('display','none');
									jQuery('#successExceptionsMessage').css('display','block');
									jQuery.colorbox.resize();
									setTimeout(function() 
									{
										jQuery('#successExceptionsMessage').css('display','none');
										jQuery.colorbox.resize();
										var checkPage = "<?php echo $_REQUEST['page']; ?>";
										window.location.href = "admin.php?page="+checkPage;
										jQuery.colorbox.resize();
									}, 2000);
								});
							}
						}
					}
					else
					{
						
						if(uxFullDayExceptionsWeek == true)
						{
							if(repeatDays == "")
				 			{
				 				
				 				jQuery('#errorExceptionsMessage').css('display','none');
								jQuery('#ExceptionsErrorMessage').css('display','none');
								jQuery('#FulldayErrorMessage').css('display','none');
				 				jQuery('#ExceptionsWeekErrorMessage').css('display','block');
				 				jQuery.colorbox.resize();
				 			}
				 			else if(serviceId == 0)
							{
								jQuery('#ExceptionsErrorMessage').css('display','none');
								jQuery('#ExceptionsWeekErrorMessage').css('display','none');
								jQuery('#errorExceptionsMessage').css('display','block');
								jQuery.colorbox.resize();
							}
				 			else
				 			{
								jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=insertExceptionDays&action=dashboardLibrary", function(data) 
								{
									jQuery('#ExceptionsErrorMessage').css('display','none');
									jQuery('#errorExceptionsMessage').css('display','none');
									jQuery('#FulldayErrorMessage').css('display','none');
									jQuery('#ExceptionsWeekErrorMessage').css('display','none');
									jQuery('#successExceptionsMessage').css('display','block');
									jQuery.colorbox.resize();
									setTimeout(function() 
									{
										jQuery('#successExceptionsMessage').css('display','none');
										jQuery.colorbox.resize();
										var checkPage = "<?php echo $_REQUEST['page']; ?>";
										window.location.href = "admin.php?page="+checkPage;
										jQuery.colorbox.resize();
									}, 2000);
								});
							}
						}
						else
						{
							if(serviceId == 0)
							{
								jQuery('#ExceptionsErrorMessage').css('display','none');
								jQuery('#ExceptionsWeekErrorMessage').css('display','none');
								jQuery('#errorExceptionsMessage').css('display','block');
								jQuery.colorbox.resize();
							}
							else if(ExceptionWeekTotalStartTime >= ExceptionWeekTotalEndTime)
							{
								jQuery('#errorExceptionsMessage').css('display','none');
								jQuery('#ExceptionsWeekErrorMessage').css('display','none');
								jQuery('#ExceptionsErrorMessage').css('display','block');
								jQuery.colorbox.resize();
							}
							else if(dat == 1 && uxFullDayExceptionsWeek != 1)
				 			{	
				 				jQuery('#errorExceptionsMessage').css('display','none');
								jQuery('#ExceptionsErrorMessage').css('display','none');
								jQuery('#ExceptionsWeekErrorMessage').css('display','none');
				 				jQuery('#FulldayErrorMessage').css('display','block');
				 				jQuery.colorbox.resize();	
				 			}
				 			
				 			else if(repeatDays == "")
				 			{
				 				
				 				jQuery('#errorExceptionsMessage').css('display','none');
								jQuery('#ExceptionsErrorMessage').css('display','none');
								jQuery('#FulldayErrorMessage').css('display','none');
				 				jQuery('#ExceptionsWeekErrorMessage').css('display','block');
				 				jQuery.colorbox.resize();
				 			}
							else
							{
								jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=insertExceptionWeeks&action=dashboardLibrary", function(data) 
								{
									jQuery('#ExceptionsErrorMessage').css('display','none');
									jQuery('#errorExceptionsMessage').css('display','none');
									jQuery('#FulldayErrorMessage').css('display','none');
									jQuery('#ExceptionsWeekErrorMessage').css('display','none');
									jQuery('#successExceptionsMessage').css('display','block');
									jQuery.colorbox.resize();
									setTimeout(function() 
									{
										jQuery('#successExceptionsMessage').css('display','none');
										jQuery.colorbox.resize();
										var checkPage = "<?php echo $_REQUEST['page']; ?>";
										window.location.href = "admin.php?page="+checkPage;
									}, 2000);
								});
							}
						}
					}
				});
			}
		});	
		function divExceptionsWeekShowHide()
		{
			var uxFullDayWeek = jQuery("#uxFullDayExceptionsWeek").prop("checked");
			
			if(uxFullDayWeek == true)
			{
				jQuery("#divExceptionsStartTime").css('display','none');
				jQuery("#divExceptionsEndTime").css('display','none');
				jQuery("#divExceptionsWeekStartTime").css('display','none');
				jQuery("#divExceptionsWeekEndTime").css('display','none');
				jQuery.colorbox.resize();
			}
			else
			{
				jQuery("#divExceptionsWeekStartTime").css('display','block');
				jQuery("#divExceptionsWeekEndTime").css('display','block');
				jQuery.colorbox.resize();
			}
			jQuery.colorbox.resize();
		}
		function divExceptionsShowHide()
		 {
		 	var uxFullDayDay = jQuery("#uxFullDayExceptionsDay").prop("checked");
		 	if(uxFullDayDay == 1)
		 	{
				jQuery("#divExceptionsStartTime").css('display','none');
				jQuery("#divExceptionsEndTime").css('display','none');
				jQuery.colorbox.resize();
			}
			else
			{
				jQuery("#divExceptionsStartTime").css('display','block');
				jQuery("#divExceptionsEndTime").css('display','block');
				jQuery.colorbox.resize();
			}
		}
		function ExceptionsOnChange()
		{
		var repeat = jQuery("#uxExceptionsIntervals").val();
		if(repeat == 0)
		{
			jQuery("#divExceptionsDays").css('display','block');
			jQuery("#divExceptionsWeek").css('display','none');
			jQuery("#divExceptionsRepeatDays").css('display','none');
			jQuery("#divExceptionsDayStartsOn").css('display','block');
			jQuery("#divExceptionsWeekStartsOn").css('display','none');
			jQuery("#divFullDayExceptionsDay").css('display','block');
			jQuery("#divFullDayWeekExceptions").css('display','none');
			jQuery("#divExceptionsStartTime").css('display','block');
			jQuery("#divExceptionsEndTime").css('display','block');
			jQuery("#divExceptionsWeekStartTime").css('display','none');
			jQuery("#divExceptionsWeekEndTime").css('display','none');
			jQuery("#divExceptionsDayEndsOn").css('display','block');
			jQuery("#divExceptionsWeekEndsOn").css('display','none');
			jQuery.colorbox.resize();
		}
		else if(repeat == 1)
		{
			jQuery("#divExceptionsDays").css('display','none');
			jQuery("#divExceptionsWeek").css('display','block');
			jQuery("#divExceptionsRepeatDays").css('display','block');
			jQuery("#divExceptionsDayStartsOn").css('display','none');
			jQuery("#divFullDayExceptionsDay").css('display','none');
			jQuery("#divExceptionsWeekStartsOn").css('display','block');
			jQuery("#divFullDayWeekExceptions").css('display','block');
			jQuery("#divExceptionsStartTime").css('display','none');
			jQuery("#divExceptionsEndTime").css('display','none');
			jQuery("#divExceptionsWeekStartTime").css('display','block');
			jQuery("#divExceptionsWeekEndTime").css('display','block');
			jQuery("#divExceptionsDayEndsOn").css('display','none');
			jQuery("#divExceptionsWeekEndsOn").css('display','block');
			jQuery.colorbox.resize();
		}
		var serviceId = jQuery("#uxExceptionsServices").val();
		jQuery.post(ajaxurl, "serviceId="+serviceId+"&param=getServiceFullDay&action=dashboardLibrary", function(data) 
		{
			if(data == 1)
			{
				var uxExceptionsInterval = jQuery('#uxExceptionsIntervals').val();
				if(uxExceptionsInterval == 0)
				{
					jQuery('#uxFullDayExceptionsDay').prop('checked', true);
					jQuery("#divExceptionsStartTime").css('display','none');
					jQuery("#divExceptionsEndTime").css('display','none');
					jQuery("#divExceptionsWeekStartTime").css('display','none');
					jQuery("#divExceptionsWeekEndTime").css('display','none');
					jQuery.colorbox.resize();
				}
				else
				{
					jQuery('#uxFullDayExceptionsWeek').prop('checked', true);
					jQuery("#divExceptionsStartTime").css('display','none');
					jQuery("#divExceptionsEndTime").css('display','none');
					jQuery("#divExceptionsWeekStartTime").css('display','none');
					jQuery("#divExceptionsWeekEndTime").css('display','none');
					jQuery.colorbox.resize();
				}
			}
			else
			{
				var uxExceptionsInterval = jQuery('#uxExceptionsIntervals').val();
				if(uxExceptionsInterval == 0)
				{
					jQuery('#uxFullDayExceptionsDay').prop('checked', false);
					jQuery("#divExceptionsWeekStartTime").css('display','none');
					jQuery("#divExceptionsWeekEndTime").css('display','none');
					jQuery("#divExceptionsStartTime").css('display','block');
					jQuery("#divExceptionsEndTime").css('display','block');
					jQuery.colorbox.resize();
				}
				else
				{
					jQuery('#uxFullDayExceptionsWeek').prop('checked', false);
					jQuery("#divExceptionsStartTime").css('display','none');
					jQuery("#divExceptionsEndTime").css('display','none');
					jQuery("#divExceptionsWeekStartTime").css('display','block');
					jQuery("#divExceptionsWeekEndTime").css('display','block');
					jQuery.colorbox.resize();
				}
			}
			
		});
		}
		jQuery( "#uxExceptionsStartsOn" ).datepicker
		({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			onClose: function( selectedDate ) 
			{
				jQuery( "#uxExceptionsDayEndsOn" ).datepicker( "option", "minDate", selectedDate );
					var label = jQuery('label[for="uxExceptionsStartsOn"]');
				//var label = jQuery("label").attr("for", "uxExceptionsStartsOn");
				label.text('Success!').addClass('valid');
			}
		});
		jQuery( "#uxExceptionsDayEndsOn" ).datepicker
		({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			onClose: function( selectedDate ) 
			{
				jQuery( "#uxExceptionsStartsOn" ).datepicker( "option", "maxDate", selectedDate );
				var label = jQuery('label[for="uxExceptionsDayEndsOn"]');
				label.text('Success!').addClass('valid');
			}
		});
		jQuery( "#uxExceptionsWeekStartsOn" ).datepicker
		({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			onClose: function( selectedDate ) 
			{
				jQuery( "#uxExceptionsWeekEndsOn" ).datepicker( "option", "minDate", selectedDate );
				var label = jQuery('label[for="uxExceptionsWeekStartsOn"]');
				label.text('Success!').addClass('valid');
			}
		});
		jQuery( "#uxExceptionsWeekEndsOn" ).datepicker
		({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			onClose: function( selectedDate )
			{
				jQuery( "#uxExceptionsWeekStartsOn" ).datepicker( "option", "maxDate", selectedDate );
				var label = jQuery('label[for="uxExceptionsWeekEndsOn"]');
				label.text('Success!').addClass('valid');
			}
		});
		jQuery("#uxFrmCoupons").validate
		({
			rules: 
			{
				uxValidFrom: 
				{
					required: true,
				},
				uxValidUpto:
				{
					required : true,
				}
			},	
			highlight: function(label) 
			{
				jQuery.colorbox.resize();
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid');
				jQuery.colorbox.resize();
			},
			submitHandler: function(form)
			{
				jQuery.colorbox.resize();
				var uxApplicableOnAllProducts = jQuery('#uxApplicableOnAllProducts').prop("checked");
				jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=checkExistingCoupons&action=dashboardLibrary", function(data)
				{
					if(data == 0)
					{
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=addCoupons&action=dashboardLibrary", function(data)
						{
							if(uxApplicableOnAllProducts == false) 
							{
								var len = uxDdlBookingServices.length;
								for(var j = 0; j < len; j++)
								{
									if(uxDdlBookingServices[j].selected)
									{
										var tmp1 = uxDdlBookingServices.options[j].value;
										jQuery.post(ajaxurl, "uxcouponid="+data+"&tmp1="+tmp1+"&param=addCouponsProducts&action=dashboardLibrary", function(data)
										{
											jQuery('#nameExistCouponsMessage').css('display','none');
											jQuery('#successCouponsSettingMessage').css('display','block');
											jQuery.colorbox.resize();
											setTimeout(function() 
											{
												jQuery('#successCouponsSettingMessage').css('display','none');
												jQuery.colorbox.resize();
												var checkPage = "<?php echo $_REQUEST['page']; ?>";
												window.location.href = "admin.php?page="+checkPage;
											}, 2000);
										}); 
									}
								}
							}
							else
							{
								jQuery('#nameExistCouponsMessage').css('display','none');
								jQuery('#successCouponsSettingMessage').css('display','block');
								jQuery.colorbox.resize();
								setTimeout(function() 
								{
									jQuery('#successCouponsSettingMessage').css('display','none');
									jQuery.colorbox.resize();
									var checkPage = "<?php echo $_REQUEST['page']; ?>";
									window.location.href = "admin.php?page="+checkPage;
								}, 2000);
							}	
						});
					}
					else
					{
						jQuery('#nameExistCouponsMessage').css('display','block');
						jQuery.colorbox.resize();
					}
				});
			}
		});
		function divCouponsHide()
		{
			var uxuxApplicableOnAllProducts = jQuery("#uxApplicableOnAllProducts").prop("checked");
			if(uxuxApplicableOnAllProducts == false)
			{
				jQuery("#divServices").css('display','block');
				jQuery.colorbox.resize();
			}
			else
			{
				jQuery("#divServices").css('display','none');
				jQuery.colorbox.resize();
			}
		}
		function enableExceptionsText()
		{
			var ExceptionsEnable = jQuery('input:radio[name=uxExceptionsDay]:checked').val();
			if(ExceptionsEnable == 1)
			{
				jQuery('#ExceptionsEndDate').attr('style','');
			}
			jQuery.colorbox.resize();
		}
		function disableExceptionsText()
		{
			var ExceptionsEnable = jQuery('input:radio[name=uxExceptionsDay]:checked').val();
			if(ExceptionsEnable == 0)
			{
				jQuery('#ExceptionsEndDate').css('display','none');
			}
			jQuery.colorbox.resize();
		}
		function enableExceptionsTextWeek()
		{
			var ExceptionEnable = jQuery('input:radio[name=uxExceptionsWeek]:checked').val();
			
			if(ExceptionEnable == 1)
			{
				jQuery('#ExceptionsEndDateWeek').attr('style','');
			}
			jQuery.colorbox.resize();
		}
		function disableExceptionsTextWeek()
		{
			var ExceptionEnable = jQuery('input:radio[name=uxExceptionsWeek]:checked').val();
			if(ExceptionEnable == 0)
			{
				jQuery('#ExceptionsEndDateWeek').css('display','none');
				jQuery.colorbox.resize();
			}
		}
		jQuery( "#uxValidFrom" ).datepicker
		({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			onClose: function( selectedDate ) 
			{
				jQuery( "#uxValidUpto" ).datepicker( "option", "minDate", selectedDate );
				var label = jQuery('label[for="uxValidFrom"]');
				label.text('Success!').addClass('valid');
			}
		});
		jQuery( "#uxValidUpto" ).datepicker
		({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			onClose: function( selectedDate )
			{
				jQuery( "#uxValidFrom" ).datepicker( "option", "maxDate", selectedDate );
				var label = jQuery('label[for="uxValidUpto"]');
				label.text('Success!').addClass('valid');
			}
		});
		jQuery('#uxAmount').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});	
		jQuery('#uxServiceCost').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});
		
		function ExceptionsChangeService()
		{
			
			var serviceId = jQuery("#uxExceptionsServices").val();
			
			jQuery.post(ajaxurl, "serviceId="+serviceId+"&param=getServiceFullDay&action=dashboardLibrary", function(data) 
			{
				
				if(data == 1)
				{
					var uxExceptionsInterval = jQuery('#uxExceptionsIntervals').val();
					if(uxExceptionsInterval == 0)
					{
						jQuery('#uxFullDayExceptionsDay').prop('checked', true);
						jQuery("#divExceptionsStartTime").css('display','none');
						jQuery("#divExceptionsEndTime").css('display','none');
						jQuery("#divExceptionsWeekStartTime").css('display','none');
						jQuery("#divExceptionsWeekEndTime").css('display','none');
						jQuery.colorbox.resize();
					}
					else
					{
						jQuery('#uxFullDayExceptionsWeek').prop('checked', true);
						jQuery("#divExceptionsStartTime").css('display','none');
						jQuery("#divExceptionsEndTime").css('display','none');
						jQuery("#divExceptionsWeekStartTime").css('display','none');
						jQuery("#divExceptionsWeekEndTime").css('display','none');
						jQuery.colorbox.resize();
					}
				}
				else
				{
					var uxExceptionsInterval = jQuery('#uxExceptionsIntervals').val();
					if(uxExceptionsInterval == 0)
					{
						jQuery('#uxFullDayExceptionsDay').prop('checked', false);
						jQuery("#divExceptionsWeekStartTime").css('display','none');
						jQuery("#divExceptionsWeekEndTime").css('display','none');
						jQuery("#divExceptionsStartTime").css('display','block');
						jQuery("#divExceptionsEndTime").css('display','block');
						jQuery.colorbox.resize();
					}
					else
					{
						jQuery('#uxFullDayExceptionsWeek').prop('checked', false);
						jQuery("#divExceptionsStartTime").css('display','none');
						jQuery("#divExceptionsEndTime").css('display','none');
						jQuery("#divExceptionsWeekStartTime").css('display','block');
						jQuery("#divExceptionsWeekEndTime").css('display','block');
						jQuery.colorbox.resize();
					}
				}
				
			});
		}
		function editBooking(bookingId)
		{
			jQuery.post(ajaxurl, "bookingId="+bookingId+"&param=updatebooking&action=dashboardLibrary", function(data)
			 {
				jQuery('#bookingDetails').html(data);
				jQuery("#bookingId").val(jQuery("#bookingHideId").val());
				jQuery.colorbox.resize(); 
			});
		}
		jQuery("#uxFrmEditBooking").validate
		({
			highlight: function(label) 
			{
				jQuery.colorbox.resize();
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid');
				jQuery.colorbox.resize();
			},
			submitHandler: function(form) 
			{
				var BookingId = jQuery("#bookingId").val();
				
				jQuery.post(ajaxurl, jQuery(form).serialize() + "&BookingId="+BookingId+"&param=updateBookingStatus&action=dashboardLibrary", function(data)
				{
					jQuery('#successMessageUpdateBooking').css('display','block'); 
					jQuery.colorbox.resize(); 
					setTimeout(function() 
					{
						jQuery('#successMessageUpdateBooking').css('display','none'); 
						jQuery.colorbox.resize(); 
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}, 2000);
				});
			}
		});
		jQuery("#uxFrmGeneralSettings").validate
		({
			highlight: function(label) 
			{
				jQuery.colorbox.resize();
			},
			success: function(label) 
			{
				label
				.text('Success!').addClass('valid');
				jQuery.colorbox.resize();
			},
			submitHandler: function(form) 
			{
				jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=updateGeneralSettings&action=dashboardLibrary", function(data)
				{
					jQuery('#successDefaultSettingsMessage').css('display','block');
					jQuery.colorbox.resize();
					setTimeout(function() 
					{
						jQuery('#successDefaultSettingsMessage').css('display','none');
						jQuery.colorbox.resize();
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}, 2000);
				});
			}
		});
</script>
<?php
}
?>