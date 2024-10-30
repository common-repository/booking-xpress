<?php
if (!current_user_can("edit_posts") && ! current_user_can("edit_pages"))
{
	return;
}
else 
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == "getServiceCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(ServiceId) FROM ' . servicesTable(),''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['param'] == "getCustomerCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(CustomerId) FROM ' . customersTable() ,''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['param'] == "getBookingCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(BookingId) FROM ' . bookingTable(),''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['param'] == "getCouponCount")
		{
			$counting = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(couponId) FROM '. coupons(),''
				)
			);
			echo $counting;
			die();
		}
		else if($_REQUEST['param'] == "recentBookings")
		{
			$currentdate = date("Y-m-d"); 
			$uxRecentBookings = $wpdb->get_results
			(
				$wpdb->prepare
				(
					"SELECT  ".customersTable().".CustomerFirstName as ClientName,
					". bookingTable().".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON 
					".bookingTable().".CustomerId= ".customersTable().".CustomerId ".
					"where ".bookingTable().".BookingDate  = '%s' ORDER BY ".bookingTable().".BookingId DESC LIMIT 5",
					$currentdate
				)
			);
			for($flag = 0; $flag < count($uxRecentBookings); $flag++)
			{
				if($uxRecentBookings[$flag]->BookingStatus == "Approved")
				{
				?>
				<li>
					<?php echo $uxRecentBookings[$flag]->ClientName; ?>
					<div class="info green">
					<span><?php _e($uxRecentBookings[$flag]->BookingStatus, booking_xpress); ?></span>
					</div>
				</li>
				<?php
				}
				else if($uxRecentBookings[$flag]->BookingStatus == "Pending Approval")
				{
				?>
				<li>
					<?php echo $uxRecentBookings[$flag]->ClientName; ?>
					<div class="info blue">
					<span><?php _e($uxRecentBookings[$flag]->BookingStatus, booking_xpress); ?></span>
					</div>
				</li>
				<?php
				}
				else if($uxRecentBookings[$flag]->BookingStatus == "Cancelled")
				{
				?>
				<li>
					<?php echo $uxRecentBookings[$flag]->ClientName; ?>
					<div class="info red">
					<span><?php _e($uxRecentBookings[$flag]->BookingStatus, booking_xpress);?></span>
					</div>
				</li>
				<?php
				}
				else if($uxRecentBookings[$flag]->BookingStatus == "Disapproved")
				{
				?>
				<li>
					<?php echo $uxRecentBookings[$flag]->ClientName; ?>
					<div class="info red">
					<span><?php _e($uxRecentBookings[$flag]->BookingStatus, booking_xpress); ?></span>
					</div>
				</li>
				<?php
				}
			}
			die();
		}
		else if($_REQUEST['param'] == "getBlockOutsCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(RepeatId) FROM ' . block_outs(),''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['param'] == 'defaultSettingsArea')
		{
			$currency_sel = $wpdb -> get_var
			(
				$wpdb->prepare
				(
					"SELECT CurrencySymbol FROM ".currenciesTable(). " where CurrencyUsed = %d",
					1
				)
			);
			?>
			<li>
				<?php _e( "Default Currency", booking_xpress ); ?>
				<div class="info black">
					<span><?php echo $currency_sel?></span>
				</div>
			</li>
			<?php
			$dateFormat = $wpdb->get_var
			(
				$wpdb->prepare
				(	
					'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
					"default_Date_Format"
				)
			);
			?>
			<li>
				<?php _e( "Date Format", booking_xpress ); ?>
				<?php
				$date = date('j'); 
				$monthName = date('F');
				$monthNumeric = date('m');
				$year = date('Y');
				if($dateFormat == 0)
				{
					?>	
					<div class="info blue">
						<span><?php echo  $monthName ." ".$date.",  ".$year; ?></span>
					</div>
					<?php
				}
				else if($dateFormat == 1)
				{
				?>
					<div class="info blue">
						<span><?php echo  $year ."/".$monthNumeric."/".$date; ?></span>
					</div>
				<?php
				}
				else if($dateFormat == 2)
				{
				?>
					<div class="info blue">
						<span><?php echo  $monthNumeric ."/".$date."/".$year; ?></span>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="info blue">
						<span><?php echo $date ."/".$monthNumeric."/".$year;  ?></span>
					</div>
				<?php
				}
			?>	
			</li>
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
			<li>
				<?php _e( "Time Format", booking_xpress ); ?>
				<?php
				if($timeFormat == 0)
				{
				?>	
					<div class="info blue">
						<span>12 Hours</span>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="info blue">
						<span>24 Hours</span>
					</div>
				<?php
				}
				?>
			</li>
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
			<li>
				<?php _e( "Paypal Status", booking_xpress ); ?>
				<?php
				if($paypalStatus == 1)
				{
				?>
					<div class="info green">
						<span><?php echo "On"; ?></span>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="info red">
						<span><?php echo "Off"; ?></span>
					</div>
				<?php
				}
				
				?>
			</li>
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
			<li>
				<?php _e( "Facebook Settings", booking_xpress ); ?>
				<?php
				if($facebookStatus == 1)
				{
				?>
					<div class="info green">
						<span><?php echo "On"; ?></span>
					</div>	
			<?php
				}
				else
				{
			?>
					<div class="info red">
						<span><?php echo "Off"; ?></span>
					</div>
			<?php
				}
			?>
			</li>
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
			<li>
				<?php _e( "Mailchimp Settings", booking_xpress ); ?>
				<?php
				if($autoResponderStatus == 1)
				{
				?>
					<div class="info green">
						<span><?php echo "On"; ?></span>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="info red">
						<span><?php echo "Off"; ?></span>
					</div>
				<?php
				
				}
				?>
			</li>
			<?php
				$ReminderStatus = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
						"reminder-settings"
					)
				);	
			?>
			<li>
				<?php _e( "Reminder Settings", booking_xpress ); ?>
				<?php
				if($ReminderStatus == 1)
				{
				?>
					<div class="info green">
						<span><?php echo "On"; ?></span>
					</div>
					<?php
						$ReminderStatusInterval = $wpdb->get_var
						(
							$wpdb->prepare
							(
								'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
								"reminder-settings-interval"
							)
						);
					?>
					<li>
						<?php _e( "Reminder Interval", booking_xpress ); ?>
						<div class="info black">
						<span><?php echo $ReminderStatusInterval; ?></span>
						</div>
					</li>
				<?php
				}
				else
				{
				?>
					<div class="info red">
						<span><?php echo "Off"; ?></span>
					</div>	
				<?php
				}
				?>
			</li>
			<?php
				$AutoApprove = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where   GeneralSettingsKey = %s',
						"auto-approve-enable"
					)
				);
				?>
			<li>
				<?php _e( "Auto Approve: ", booking_xpress ); ?>
				<?php
				if($AutoApprove == 1)
				{
				?>
					<div class="info green">
						<span><?php echo "On"; ?></span>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="info red">
						<span><?php echo "Off"; ?></span>
					</div>
				<?php
				}
				?>
			</li>
			<?php
			die();
		}
	}
}
?>