<?php
if (!current_user_can('edit_posts') && ! current_user_can('edit_pages') )
{
	return;
}
else 
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == "getFacebookStatus")
		{
			$FBStatus = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT SocialMediaValue FROM ' . social_Media_settingsTable() . ' where SocialMediaKey = %s',
					"facebook-connect-enable"
				)
			);
			if($FBStatus == 0)
			{
				echo "OFF";
			}
			else 
			{
				echo "ON";
			}
			die();
		}
		else if($_REQUEST['param'] == "getMailChimpStatus")
		{
			$MCStatus = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT AutoResponderValue FROM ' . auto_Responders_settingsTable() . ' where AutoResponderKey = %s',
					"mail-chimp-enabled"
				)
			);
			if($MCStatus == 0)
			{
				echo "OFF";
			}
			else 
			{
				echo "ON";
			}
			die();
		}
		else if($_REQUEST['param'] == "ReminderSettingsShow")
		{
			$uxReminderSettings = esc_attr($_REQUEST['uxReminderSettings']);
			$ReminderSettings = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where   GeneralSettingsKey = %s',
					"reminder-settings"
				)
			);
			$ReminderSettingsInterval = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where   GeneralSettingsKey = %s',
					"reminder-settings-interval"
				)
			);
			if($ReminderSettings == 0)
			{
				echo "OFF";
			}
			else 
			{
				echo "ON";
			}
			die();
		}
		else if($_REQUEST['param'] == "AutoApproveShow")
		{
			$uxAutoApprove = esc_attr($_REQUEST['uxAutoApprove']);
			$AutoApprove = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where   GeneralSettingsKey = %s',
					"auto-approve-enable"
				)
			);
			if($AutoApprove == 0)
			{
				echo "OFF";
			}
			else 
			{
				echo "ON";
			}
			die();
		}
		if($_REQUEST['param'] == "UpdateFacebookSocialMedia")
		{
			$uxFacebookAppId = esc_attr($_REQUEST['uxFacebookAppId']);
			$uxFacebookSecretKey = esc_attr($_REQUEST['uxFacebookSecretKey']);
			$uxFacebookConnectRadio = esc_attr($_REQUEST['uxFacebookConnect']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".social_Media_settingsTable()." SET SocialMediaValue = %s WHERE SocialMediaKey = %s",
					$uxFacebookAppId,
					"facebook-api-id"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".social_Media_settingsTable()." SET SocialMediaValue = %s WHERE SocialMediaKey = %s",
					$uxFacebookSecretKey,
					"facebook-secret-key"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".social_Media_settingsTable()." SET SocialMediaValue = %s WHERE SocialMediaKey = %s",
					$uxFacebookConnectRadio,
					"facebook-connect-enable"
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "UpdateAutoResponder")
		{
			$uxuxMailChimpRadio = esc_attr($_REQUEST['uxMailChimp']);
			$uxMailChimpApiKey = esc_attr($_REQUEST['uxMailChimpApiKey']);
			$uxMailChimpUniqueId = esc_attr($_REQUEST['uxMailChimpUniqueId']);
			if(isset($_REQUEST['uxDoubleOptIn']))
			{
				$uxDoubleOptIn = 'true';
			}
			else
			{
				$uxDoubleOptIn = 'false';
			}
			if(isset($_REQUEST['uxWelcomeEmail']))
			{
				$uxWelcomeEmail = 'true';
			}
			else
			{
				$uxWelcomeEmail = 'false';
			}
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".auto_Responders_settingsTable()." SET AutoResponderValue = %s WHERE AutoResponderKey = %s",
					$uxuxMailChimpRadio,
					"mail-chimp-enabled"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".auto_Responders_settingsTable()." SET AutoResponderValue = %s WHERE AutoResponderKey = %s",
					$uxMailChimpApiKey,
					"mail-chimp-api-key"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".auto_Responders_settingsTable()." SET AutoResponderValue = %s WHERE AutoResponderKey = %s",
					$uxMailChimpUniqueId,
					"mail-chimp-unique-id"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".auto_Responders_settingsTable()." SET AutoResponderValue = %s WHERE AutoResponderKey = %s",
					$uxDoubleOptIn,
					"mail-double-optin-id"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".auto_Responders_settingsTable()." SET AutoResponderValue = %s WHERE AutoResponderKey = %s",
					$uxWelcomeEmail,
					"mail-welcome-email"
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "addService")
		{
			$uxServiceNameEncode = html_entity_decode($_REQUEST['uxServiceName']);
			$uxServiceCost = doubleval($_REQUEST['uxServiceCost']);
			$uxServiceHours = intval($_REQUEST['uxServiceHours']);
			$uxServiceMins = intval($_REQUEST['uxServiceMins']);
			$uxServicesTotalTime = $uxServiceHours  * 60 + $uxServiceMins;
			$uxMaxBookings = intval($_REQUEST['uxMaxBookings']);
			$uxServiceType = intval($_REQUEST['uxServiceType']);
			$uxServiceColor = esc_attr($_REQUEST['uxServiceColor']);
			$uxStartTimeHours = intval($_REQUEST['uxStartTimeHours']);
			$uxStartTimeMins = intval($_REQUEST['uxStartTimeMins']);
			$uxStartTimeAMPM = esc_attr($_REQUEST['uxStartTimeAMPM']);
			$uxEndTimeHours = intval($_REQUEST['uxEndTimeHours']);
			$uxEndTimeMins= intval($_REQUEST['uxEndTimeMins']);
			$uxEndTimeAMPM = esc_attr($_REQUEST['uxEndTimeAMPM']);
			$uxFullDayService = intval($_REQUEST['uxFullDayService']);
			$uxMaxDays = esc_attr($_REQUEST['uxMaxDays']);
			$uxCostType = intval($_REQUEST['uxCostType']);
			if(isset($_REQUEST['uxFullDayService']))
			{
				$uxFullDay = esc_attr($_REQUEST['uxFullDayService']);
			}
			else
			{
				$uxFullDay = "false";
			}
			if($uxStartTimeAMPM == "PM")
			{
				if($uxStartTimeHours <= 11)
				{
					$uxStartTimeHour = $uxStartTimeHours + 12;
				}
				else if($uxStartTimeHours == 12)
				{
					$uxStartTimeHour = 12;
				}
			}
			else if($uxStartTimeAMPM == "AM")
			{
				if($uxStartTimeHours == 12)
				{
					$uxStartTimeHour = 0;
				}
				else 
				{
					$uxStartTimeHour = $uxStartTimeHours;
				}
			}
			else 
			{
				$uxStartTimeHour = $uxStartTimeHours;
			}
			
			if($uxEndTimeAMPM == "PM")
			{
				if($uxEndTimeHours <= 11)
				{
					$uxEndTimeHour = $uxEndTimeHours + 12;
				}
				else if($uxEndTimeHours == 12)
				{
					$uxEndTimeHour = 12;
				}
			}
			else if($uxEndTimeAMPM == "AM")
			{
				if($uxEndTimeHours == 12)
				{
					$uxEndTimeHour = 0;
				}
				else 
				{
					$uxEndTimeHour = $uxEndTimeHours;
				}
			}
			else 
			{
				$uxEndTimeHour = $uxEndTimeHours;
			}
			if($uxFullDay == "false")
			{
				$ServiceTotalStartTime = ($uxStartTimeHour * 60) + $uxStartTimeMins;
				$ServiceTotalEndTime = ($uxEndTimeHour * 60) + $uxEndTimeMins;
			}
			else 
			{
				$ServiceTotalStartTime = 0;
				$ServiceTotalEndTime = 0;
				$uxServicesTotalTime = 0;
			}
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".servicesTable()."(ServiceName,ServiceCost,ServiceTotalTime,ServiceMaxBookings,Type,ServiceFullDay,ServiceStartTime,ServiceEndTime,ServiceColorCode,MaxDays,CostType ) 
					VALUES( %s, %f, %d, %d, %d, %d, %d, %d, %s, %s, %d)",
					$uxServiceNameEncode,
					$uxServiceCost,
					$uxServicesTotalTime,
					$uxMaxBookings,
					$uxServiceType,
					$uxFullDay,
					$ServiceTotalStartTime,
					$ServiceTotalEndTime,
					$uxServiceColor,
					$uxMaxDays,
					$uxCostType
				)
			);
			$lastid = $wpdb->insert_id;
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".servicesTable()." SET ServiceDisplayOrder = %d WHERE ServiceId = %d",
					$lastid,
					$lastid
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "UpdatePaymentGateway")
		{
			$PaypalEnableCheck = intval($_REQUEST['uxPayPal']);
			$PaypalUrlCheck = esc_attr($_REQUEST['uxPayPalurl']);
			$uxMerchantEmailAddress = esc_attr($_REQUEST['uxMerchantEmailAddress']);
			$uxThankyouPageUrl = esc_attr($_REQUEST['uxThankyouPageUrl']);
			$uxIPNUrl = esc_attr($_REQUEST['uxIPNUrl']);
			$uxPaymentImageUrl = esc_attr($_REQUEST['uxPaymentImageUrl']);
			$uxPaymentCancellationUrl = esc_attr($_REQUEST['uxCancellationUrl']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".payment_Gateway_settingsTable()." SET PaymentGatewayValue = %s WHERE PaymentGatewayKey = %s",
					$PaypalEnableCheck,
					"paypal-enabled"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".payment_Gateway_settingsTable()." SET PaymentGatewayValue = %s WHERE PaymentGatewayKey = %s",
					$uxMerchantEmailAddress,
					"paypal-merchant-email-address"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".payment_Gateway_settingsTable()." SET PaymentGatewayValue = %s WHERE PaymentGatewayKey = %s",
					$uxThankyouPageUrl,
					"paypal-thankyou-page-url"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".payment_Gateway_settingsTable()." SET PaymentGatewayValue = %s WHERE PaymentGatewayKey = %s",
					$uxIPNUrl,
					"paypal-ipn-url"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".payment_Gateway_settingsTable()." SET PaymentGatewayValue = %s WHERE PaymentGatewayKey = %s",
					$uxPaymentImageUrl,
					"paypal-payment-image-url"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".payment_Gateway_settingsTable()." SET PaymentGatewayValue = %s WHERE PaymentGatewayKey = %s",
					$uxPaymentCancellationUrl,
					"paypal-payment-cancellation-Url"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".payment_Gateway_settingsTable()." SET PaymentGatewayValue = %s WHERE PaymentGatewayKey = %s",
					$PaypalUrlCheck,
					"paypal-Test-Url"
				)
			);
			die(); 
		}
		else if($_REQUEST['param'] == "AutoApprove")
		{
			$uxAutoApprove = intval($_REQUEST['uxAutoApprove']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s WHERE GeneralSettingsKey = %s",
					$uxAutoApprove,
					"auto-approve-enable"
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "deleteBooking")
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE FROM ".bookingTable()." WHERE BookingId = %d",
					$bookingId
				)
			);
			die();
		}
		else if($_REQUEST['param'] == 'resendBookingEmail')
		{
			include_once TBP_BK_PLUGIN_DIR.'/views/mailmanagement.php';
			$bookingId = intval($_REQUEST['bookingId']);
			$uxBookingStaus = esc_attr($_REQUEST['status']);
			if($uxBookingStaus == "Pending Approval")
			{
				MailManagement($bookingId,"approval_pending");	
				MailManagement($bookingId,"admin");
			}
			else if($uxBookingStaus == "Approved")
			{
				MailManagement($bookingId,"approved");
			}
			else if($uxBookingStaus == "Disapproved")
			{
				MailManagement($bookingId,"disapproved");
			}
			die();
		}
		else if($_REQUEST['param'] == "UpdateReminderSettings")
		{
			$uxReminderSettings = esc_attr($_REQUEST['uxReminderSettings']);
			$uxReminderInterval = esc_attr($_REQUEST['uxReminderInterval']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s WHERE GeneralSettingsKey = %s",
					$uxReminderSettings,
					"reminder-settings"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s WHERE GeneralSettingsKey = %s",
					$uxReminderInterval,
					"reminder-settings-interval"
				)
			);
			die();
		}
		else if($_REQUEST['param'] == 'getServiceFullDay')
		{
			$serviceId = intval($_REQUEST['serviceId']);
			$checkServiceFullDay = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT ServiceFullDay FROM ".servicesTable()." where 	ServiceId = %d",
					$serviceId
				)
			);
			echo $checkServiceFullDay;
			die();	
		}
		else if($_REQUEST['param'] == 'insertExceptionDays')
		{
			$serviceId = intval($_REQUEST['uxExceptionsServices']);
			$ExceptionsIntervals  = intval($_REQUEST['uxExceptionsIntervals']);
			$ExceptionsRepeatDay  = intval($_REQUEST['uxExceptionsRepeatDay']);
			$ExceptionsDayStartsOn  = esc_attr($_REQUEST['uxExceptionsStartsOn']);
			if(!isset($_REQUEST['uxFullDayExceptionsDay']))
			{
				$FullDayExceptionsDay = 0;
			}
			else
			{
				$FullDayExceptionsDay = intval($_REQUEST['uxFullDayExceptionsDay']);	
			}	
			$ExceptionsStartTimeHours = intval($_REQUEST['uxExceptionsStartTimeHours']);
			$ExceptionsStartTimeMins = intval($_REQUEST['uxExceptionsStartTimeMins']);
			$ExceptionsStartTimeAMPM = esc_attr($_REQUEST['uxExceptionsStartTimeAMPM']);
			$ExceptionsEndTimeHours = intval($_REQUEST['uxExceptionsEndTimeHours']);
			$ExceptionsEndTimeMins = intval($_REQUEST['uxExceptionsEndTimeMins']);
			$ExceptionsEndTimeAMPM = esc_attr($_REQUEST['uxExceptionsEndTimeAMPM']);
			$ExceptionsDayEndsOn = esc_attr($_REQUEST['uxExceptionsDayEndsOn']);
			if($FullDayExceptionsDay == 0)
			{
				if($ExceptionsStartTimeAMPM == "PM")
				{
					if($ExceptionsStartTimeHours <= 11)
					{
						$DayStartTimeHour = $ExceptionsStartTimeHours + 12;
					}
					else if($ExceptionsStartTimeHours == 12)
					{
						$DayStartTimeHour = 12;
					}
				}
				else if($ExceptionsStartTimeAMPM == "AM")
				{
					if($ExceptionsStartTimeHours == 12)
					{
						$DayStartTimeHour = 0;
					}
					else 
					{
						$DayStartTimeHour = $ExceptionsStartTimeHours;
					}
				}
				else 
				{
					$DayStartTimeHour = $ExceptionsStartTimeHours;
				}
				$ExceptionsTotalStartTime = ($DayStartTimeHour * 60) + $ExceptionsStartTimeMins;
				if($ExceptionsEndTimeAMPM == "PM")
				{
					if($ExceptionsEndTimeHours <= 11)
					{
						$DayEndTimeHour = $ExceptionsEndTimeHours + 12;
					}
					else if($ExceptionsEndTimeHours == 12)
					{
						$DayEndTimeHour = 12;
					}
				}
				else if($ExceptionsEndTimeAMPM == "AM")
				{
					if($ExceptionsEndTimeHours == 12)
					{
						$DayEndTimeHour = 0;
					}
					else 
					{
						$DayEndTimeHour = $ExceptionsEndTimeHours;
					}
				}
				else 
				{
					$DayEndTimeHour = $ExceptionsEndTimeHours;
				}
				$ExceptionsTotalEndTime = ($DayEndTimeHour * 60) + $ExceptionsEndTimeMins;
			}
			else
			{
				$ExceptionsTotalStartTime = 0;
				$ExceptionsTotalEndTime = 0;
			}
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".block_outs()."(ServiceId,Repeats,RepeatEvery,StartDate,FullDayBlockOuts,StartTime,EndTime,EndDate ) 
					VALUES( %d, %d, %d, '%s', %d, %d, %d, '%s')",
					$serviceId,
					$ExceptionsIntervals,
					$ExceptionsRepeatDay,
					$ExceptionsDayStartsOn,
					$FullDayExceptionsDay,
					$ExceptionsTotalStartTime,
					$ExceptionsTotalEndTime,
					$ExceptionsDayEndsOn
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "insertExceptionWeeks")
		{
			$serviceId = intval($_REQUEST['uxExceptionsServices']);	
			$ExceptionsIntervals  = intval($_REQUEST['uxExceptionsIntervals']);
			$ExceptionsRepeatWeeks  = intval($_REQUEST['uxExceptionsRepeatWeeks']);
			$ExceptionsWeekStartsOn  = esc_attr($_REQUEST['uxExceptionsWeekStartsOn']);
			if(!isset($_REQUEST['uxFullDayExceptionsWeek']))
			{
				$FullDayExceptionsWeek = 0;
			}
			else
			{
				$FullDayExceptionsWeek = intval($_REQUEST['uxFullDayExceptionsWeek']);	
			}
			$ExceptionsWeekStartTimeHours = intval($_REQUEST['uxExceptionsWeekStartTimeHours']);
			$ExceptionsWeekStartTimeMins = intval($_REQUEST['uxExceptionsWeekStartTimeMins']);
			$ExceptionsWeekStartTimeAMPM = esc_attr($_REQUEST['uxExceptionsWeekStartTimeAMPM']);
			$ExceptionsWeekEndTimeHours = intval($_REQUEST['uxExceptionsWeekEndTimeHours']);
			$ExceptionsWeekEndTimeMins = intval($_REQUEST['uxExceptionsWeekEndTimeMins']);
			$ExceptionsWeekEndTimeAMPM = esc_attr($_REQUEST['uxExceptionsWeekEndTimeAMPM']);
			$ExceptionsWeekEndsOn = esc_attr($_REQUEST['uxExceptionsWeekEndsOn']);
			$RepeatDays = array();
			if(isset($_REQUEST['uxExceptionsWeekDay1']))
			{
				array_push($RepeatDays, esc_attr($_REQUEST['uxExceptionsWeekDay1']));
			}
			if(isset($_REQUEST['uxExceptionsWeekDay2']))
			{
				array_push($RepeatDays, esc_attr($_REQUEST['uxExceptionsWeekDay2']));
			}
			if(isset($_REQUEST['uxExceptionsWeekDay3']))
			{
				array_push($RepeatDays, esc_attr($_REQUEST['uxExceptionsWeekDay3']));
			}
			if(isset($_REQUEST['uxExceptionsWeekDay4']))
			{
				array_push($RepeatDays, esc_attr($_REQUEST['uxExceptionsWeekDay4']));
			}
			if(isset($_REQUEST['uxExceptionsWeekDay5']))
			{
				array_push($RepeatDays, esc_attr($_REQUEST['uxExceptionsWeekDay5']));
			}
			if(isset($_REQUEST['uxExceptionsWeekDay6']))
			{
				array_push($RepeatDays, esc_attr($_REQUEST['uxExceptionsWeekDay6']));
			}
			if(isset($_REQUEST['uxExceptionsWeekDay7']))
			{
				array_push($RepeatDays, esc_attr($_REQUEST['uxExceptionsWeekDay7']));
			}
			$RepeatedDays = "";
			for($Repeats = 0; $Repeats < count($RepeatDays); $Repeats++)
			{
				if($Repeats < count($RepeatDays) - 1)
				{
					$RepeatedDays .= $RepeatDays[$Repeats]. ","; 
				}
				else 
				{
					$RepeatedDays .= $RepeatDays[$Repeats];
				}
			}
			if($FullDayExceptionsWeek == 0)
			{
				if($ExceptionsWeekStartTimeAMPM == "PM")
				{
					if($ExceptionsWeekStartTimeHours <= 11)
					{
						$WeekStartTimeHour = $ExceptionsWeekStartTimeHours + 12;
					}
					else if($ExceptionsWeekStartTimeHours == 12)
					{
						$WeekStartTimeHour = 12;
					}
				}
				else if($ExceptionsWeekStartTimeAMPM == "AM")
				{
					if($ExceptionsWeekStartTimeHours == 12)
					{
						$WeekStartTimeHour = 0;
					}
					else 
					{
						$WeekStartTimeHour = $ExceptionsWeekStartTimeHours;
					}
				}
				else 
				{
					$WeekStartTimeHour = $ExceptionsWeekStartTimeHours;
				}
				$ExceptionsWeekTotalStartTime = ($WeekStartTimeHour * 60) + $ExceptionsWeekStartTimeMins;
				
				
				if($ExceptionsWeekEndTimeAMPM == "PM")
				{
					if($ExceptionsWeekEndTimeHours <= 11)
					{
						$WeekEndTimeHour = $ExceptionsWeekEndTimeHours + 12;
					}
					else if($ExceptionsWeekEndTimeHours == 12)
					{
						$WeekEndTimeHour = 12;
					}
				}
				else if($ExceptionsWeekEndTimeHours == "AM")
				{
					if($ExceptionsWeekEndTimeHours == 12)
					{
						$WeekEndTimeHour = 0;
					}
					else 
					{
						$WeekEndTimeHour = $ExceptionsWeekEndTimeHours;
					}
				}
				else 
				{
					$WeekEndTimeHour = $ExceptionsWeekEndTimeHours;
				}
				$ExceptionsWeekTotalEndTime = ($WeekEndTimeHour * 60) + $ExceptionsWeekEndTimeMins;
			}
			else 
			{
				$ExceptionsWeekTotalStartTime = 0;
				$ExceptionsWeekTotalEndTime = 0;
			}
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".block_outs()."(ServiceId,Repeats,RepeatEvery,StartDate,FullDayBlockOuts,StartTime,EndTime,EndDate,RepeatDays ) 
					VALUES( %d, %d, %d, '%s', %d, %d, %d, '%s', %s)",
					$serviceId,
					$ExceptionsIntervals,
					$ExceptionsRepeatWeeks,
					$ExceptionsWeekStartsOn,
					$FullDayExceptionsWeek,
					$ExceptionsWeekTotalStartTime,
					$ExceptionsWeekTotalEndTime,
					$ExceptionsWeekEndsOn,
					$RepeatedDays
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "checkExistingCoupons")
		{
			$uxDefaultCoupon = esc_attr($_REQUEST['uxDefaultCoupon']);
			echo $countName = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(couponId) FROM ' . coupons() . ' WHERE couponName = %s',
					$uxDefaultCoupon
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "addCoupons")
		{
			
			$uxDefaultCoupon = esc_attr($_REQUEST['uxDefaultCoupon']);
			$uxValidFrom = esc_attr($_REQUEST['uxValidFrom']);
			$uxValidUpto = esc_attr($_REQUEST['uxValidUpto']);
			$uxAmount = doubleval($_REQUEST['uxAmount']);
			$uxDdlAmountType = intval($_REQUEST['uxDdlAmountType']);
			if(!isset($_REQUEST['uxApplicableOnAllProducts']))
			{
					$uxApplicableOnAllProducts = 0;
			}
			else 
			{
					$uxApplicableOnAllProducts = esc_attr($_REQUEST['uxApplicableOnAllProducts']);
			}
			$uxDdlBookingServices = esc_attr($_REQUEST['uxDdlBookingServices']);
			$couponStatus = 1;
			if($uxApplicableOnAllProducts == 1)
			{
				$uxAppForAllPro = 1;
			}
			else
			{
				$uxAppForAllPro = 0;
			}
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".coupons()."(couponName,couponValidFrom,couponValidUpto,Amount,amountType,couponApplicable,couponStatus) 
					VALUES(%s,%s,%s,%f,%d,%d,%s)",
					$uxDefaultCoupon,
					$uxValidFrom,
					$uxValidUpto,
					$uxAmount,
					$uxDdlAmountType,
					$uxAppForAllPro,
					$couponStatus,
					$uxDdlBookingServices
				)
			);
			echo $lastid = $wpdb->insert_id;
			die();
		}
		else if($_REQUEST['param']== "addCouponsProducts")
		{
			$tmp1 = intval($_REQUEST['tmp1']);
			$uxcouponid = intval($_REQUEST['uxcouponid']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".coupons_products()."(couponId,serviceId) VALUES(%d,%d)",
					$uxcouponid,$tmp1
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "updatebooking")
		{
			$bookingId = intval($_REQUEST['bookingId']);
			$bookingDetail = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT ".customersTable().".CustomerFirstName,".customersTable().".CustomerLastName,".customersTable().".CustomerEmail,".customersTable().".CustomerMobile,".servicesTable(). ".ServiceId,"
					.servicesTable(). ".ServiceName,".servicesTable(). ".ServiceTotalTime,".servicesTable(). ".ServiceColorCode,".bookingTable().".BookingDate,".bookingTable().".TimeSlot,".bookingTable().".PaymentStatus,".bookingTable().".BookingStatus,".bookingTable().".TransactionId,"
					.bookingTable().".PaymentDate, ".bookingTable().".BookingId from ".bookingTable()." LEFT OUTER JOIN " 
					.customersTable()." ON ".bookingTable().".CustomerId= ".customersTable().".CustomerId "." LEFT OUTER JOIN " .servicesTable()." ON ".bookingTable().".ServiceId=" 
					.servicesTable().".ServiceId where ".bookingTable().".BookingId =  %d",
					$bookingId." ORDER BY ".bookingTable().".BookingDate asc"
				)
			);
			$paypalEnable = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT PaymentGatewayValue FROM ".payment_gateway_settingsTable()." where PaymentGatewayKey = %s",'paypal-enabled'
				)
			);
			$ServiceFullDay = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT ServiceFullDay FROM ".servicesTable()." where ServiceId = %d",
					$bookingDetail->ServiceId
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
			if($ServiceFullDay == 1)
			{
				$bookingDates = $wpdb->get_results
				(
					$wpdb->prepare
					(
						"SELECT * FROM ".multiple_bookingTable()." where bookingId = %d",
						$bookingDetail->BookingId
					)
				);
			}

?>
<div class="well-smoke block"  style="margin-top:10px">
	<div class="row">
		<label style="top:10px;"> <?php _e("Client Name :", booking_xpress);?></label>
		<div class="right">
			<span> <?php echo $bookingDetail -> CustomerFirstName . " " . $bookingDetail -> CustomerLastName;?>
				&nbsp;</span>
		</div>
	</div>
	<div class="row">
		<label style="top:10px;"> <?php _e("Email :", booking_xpress);?></label>
		<div class="right">
			<span> <?php echo $bookingDetail -> CustomerEmail;?>
				&nbsp;</span>
		</div>
	</div>
	<div class="row">
		<label style="top:10px;"> <?php _e("Mobile :", booking_xpress);?></label>
		<div class="right">
			<span> <?php echo $bookingDetail -> CustomerMobile;?>
				&nbsp;</span>
		</div>
	</div>
	<div class="row">
		<label style="top:10px;"> <?php _e("Service Booked :", booking_xpress);?></label>
		<div class="right">
			<span> <?php echo $bookingDetail -> ServiceName;?>&nbsp; </span>
		</div>
	</div>
	<div class="row">
		<label> <?php _e("Booking Date :", booking_xpress);?></label>
		<div class="right">
			<?php
			$dateFormat = $wpdb -> get_var($wpdb -> prepare('SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s ', "default_Date_Format"));
			if ($ServiceFullDay == 1) {
				if ($dateFormat == 0) {
					$dateFormat1 = date("M d, Y", strtotime($bookingDetail -> BookingDate));
				} else if ($dateFormat == 1) {
					$dateFormat1 = date("Y/m/d", strtotime($bookingDetail -> BookingDate));
				} else if ($dateFormat == 2) {
					$dateFormat1 = date("m/d/Y", strtotime($bookingDetail -> BookingDate));
				} else if ($dateFormat == 3) {
					$dateFormat1 = date("d/m/Y", strtotime($bookingDetail -> BookingDate));
				}
				$allocatedMultipleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto; \">";
				for ($MBflag = 0; $MBflag < count($bookingDates); $MBflag++) {
					if ($dateFormat == 0) {
						$dateFormat = date("M d, Y", strtotime($bookingDates[$MBflag] -> bookingDate));
					} else if ($dateFormat == 1) {
						$dateFormat = date("Y/m/d", strtotime($bookingDates[$MBflag] -> bookingDate));
					} else if ($dateFormat == 2) {
						$dateFormat = date("m/d/Y", strtotime($bookingDates[$MBflag] -> bookingDate));
					} else if ($dateFormat == 3) {
						$dateFormat = date("d/m/Y", strtotime($bookingDates[$MBflag] -> bookingDate));
					}
					$allocatedMultipleDates .= "<span style=\"margin-left:5px;background-color:" . $bookingDetail -> ServiceColorCode . ";color:#fff;border:solid 1px " . $bookingDetail -> ServiceColorCode . "\" class=\"tag\"><span>" . $dateFormat . '' . "</span></span>";
				}
				$allocatedMultipleDates .= "</div>";
				echo $allocatedMultipleDates;
			} else {
				$allocatedSingleDates = "<div id=\"tags1_tagsinput\" class=\"tagsinput\" style=\"width: 100%; min-height: auto; height: auto; \">";
				if ($dateFormat == 0) {
					$SingleDate = date("M d, Y", strtotime($bookingDetail -> BookingDate));
				} else if ($dateFormat == 1) {
					$SingleDate = date("Y/m/d", strtotime($bookingDetail -> BookingDate));
				} else if ($dateFormat == 2) {
					$SingleDate = date("m/d/Y", strtotime($bookingDetail -> BookingDate));

				} else if ($dateFormat == 3) {
					$SingleDate = date("d/m/Y", strtotime($bookingDetail -> BookingDate));

				}
				$allocatedSingleDates .= "<span style=\"margin-left:5px;background-color:" . $bookingDetail -> ServiceColorCode . ";color:#fff;border:solid 1px " . $bookingDetail -> ServiceColorCode . "\" class=\"tag\"><span>" . $SingleDate . '' . "</span></span></div>";
				echo $allocatedSingleDates;
			}
			?>
		</div>
	</div>
	<?php
if($ServiceFullDay == 0)
{
	?>
	<div class="row">
		<label style="top:10px;"> <?php _e("Time Slot :", booking_xpress);?></label>
		<div class="right">
			<span> <?php
			if ($ServiceFullDay == 0) {
				$getHours_bookings = floor(($bookingDetail -> TimeSlot) / 60);
				$getMins_bookings = ($bookingDetail -> TimeSlot) % 60;
				$hourFormat_bookings = $getHours_bookings . ":" . "00";
				if ($timeFormats == 0) {
					$time_in_12_hour_format_bookings = DATE("g:i a", STRTOTIME($hourFormat_bookings));
				} else {
					$time_in_12_hour_format_bookings = DATE("H:i", STRTOTIME($hourFormat_bookings));
				}
				if ($getMins_bookings != 0) {
					$hourFormat_bookings = $getHours_bookings . ":" . $getMins_bookings;
					if ($timeFormats == 0) {
						$time_in_12_hour_format_bookings = DATE("g:i a", STRTOTIME($hourFormat_bookings));
					} else {
						$time_in_12_hour_format_bookings = DATE("H:i", STRTOTIME($hourFormat_bookings));
					}
				}
				$totalBookedTime = $bookingDetail -> TimeSlot + $bookingDetail -> ServiceTotalTime;
				$getHours_bookings = floor(($totalBookedTime) / 60);
				$getMins_bookings = ($totalBookedTime) % 60;
				$hourFormat_bookings = $getHours_bookings . ":" . "00";
				if ($timeFormats == 0) {
					$time_in_12_hour_format_bookings_End = DATE("g:i a", STRTOTIME($hourFormat_bookings));
				} else {
					$time_in_12_hour_format_bookings_End = DATE("H:i", STRTOTIME($hourFormat_bookings));
				}
				if ($getMins_bookings != 0) {
					$hourFormat_bookings = $getHours_bookings . ":" . $getMins_bookings;
					if ($timeFormats == 0) {
						$time_in_12_hour_format_bookings_End = DATE("g:i a", STRTOTIME($hourFormat_bookings));
					} else {
						$time_in_12_hour_format_bookings_End = DATE("H:i", STRTOTIME($hourFormat_bookings));
					}
				}
				echo $time_in_12_hour_format_bookings . " - " . $time_in_12_hour_format_bookings_End;
			}
				?></span>&nbsp;
		</div>
	</div>
	<?php
	}
	if($paypalEnable == 1)
	{
	?>
	<div class="row">
		<label style="top:10px;"> <?php _e("Payment Status:", booking_xpress);?></label>
		<div class="right">
			<span> <?php echo $bookingDetail -> PaymentStatus;?></span>&nbsp;
		</div>
	</div>
	<div class="row">
		<label style="top:10px;"> <?php _e("Transaction ID :", booking_xpress);?></label>
		<div class="right">
			<span> <?php echo $bookingDetail -> TransactionId;?></span>&nbsp;
		</div>
	</div>
	<div class="row">
		<label style="top:10px;"> <?php _e("Payment Date :", booking_xpress);?></label>
		<div class="right">
			<span> <?php echo $bookingDetail -> PaymentDate;?></span>&nbsp;
		</div>
	</div>
	<?php
	}
	?>
	<input type="hidden" id="bookingHideId" value="<?php echo $bookingId;?>" />
	<div class="row">
		<label> <?php _e("Booking Status :", booking_xpress);?></label>
		<div class="right">
			<select name="uxBookingStatus" class="style required" id="uxBookingStatus" style="width:200px;">
				<?php
if($bookingDetail->BookingStatus =="Pending Approval")
{
				?>
				<option value="<?php echo $bookingDetail -> BookingStatus;?>" selected="selected" ><?php _e($bookingDetail -> BookingStatus, booking_xpress);?></option>
				<option value="Approved"><?php _e("Approved", booking_xpress);?></option>
				<option value="Disapproved"><?php _e("Disapproved", booking_xpress);?></option>
				<option value="Cancelled"><?php _e("Cancelled", booking_xpress);?></option>
				<?php
				}
				else if($bookingDetail->BookingStatus =="Approved")
				{
				?>
				<option value="Pending Approval" ><?php _e("Pending Approval", booking_xpress);?></option>
				<option value="<?php echo $bookingDetail -> BookingStatus;?>" selected="selected" ><?php _e($bookingDetail -> BookingStatus, booking_xpress);?></option>
				<option value="Disapproved" ><?php _e("Disapproved", booking_xpress);?></option>
				<option value="Cancelled" ><?php _e("Cancelled", booking_xpress);?></option>
				<?php
				}
				else if($bookingDetail->BookingStatus =="Disapproved")
				{
				?>
				<option value="Pending Approval"><?php _e("Pending Approval", booking_xpress);?></option>
				<option value="Approved" ><?php _e("Approved", booking_xpress);?></option>
				<option value="<?php echo $bookingDetail -> BookingStatus;?>" selected="selected" ><?php _e($bookingDetail -> BookingStatus, booking_xpress);?></option>
				<option value="Cancelled" ><?php _e("Cancelled", booking_xpress);?></option>
				<?php
				}
				else if($bookingDetail->BookingStatus =="Cancelled")
				{
				?>
				<option value="Pending Approval"><?php _e("Pending Approval", booking_xpress);?></option>
				<option value="Approved" ><?php _e("Approved", booking_xpress);?></option>
				<option value="Disapproved" ><?php _e("Disapproved", booking_xpress);?></option>
				<option value="<?php echo $bookingDetail -> BookingStatus;?>" selected="selected" ><?php _e($bookingDetail -> BookingStatus, booking_xpress);?></option>
				<?php
				}
				?>
			</select>
		</div>
	</div>
</div>
<?php
die();
}
else if($_REQUEST['param'] == "updateBookingStatus")
{
$bookingId = intval($_REQUEST['BookingId']);
$uxBookingStatus = esc_attr($_REQUEST['uxBookingStatus']);
$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".bookingTable()." SET BookingStatus = %s WHERE BookingId = %d",
$uxBookingStatus,
$bookingId
)
);
include_once TBP_BK_PLUGIN_DIR.'/views/mailmanagement.php';
if($uxBookingStatus == "Pending Approval")
{
MailManagement($bookingId,"approval_pending");
MailManagement($bookingId,"admin");
}
else if($uxBookingStatus == "Approved")
{

MailManagement($bookingId,"approved");
}
else if($uxBookingStatus == "Disapproved")
{
MailManagement($bookingId,"disapproved");
}
die();
}
else if($_REQUEST['param'] == "DeleteAllBookings")
{
$wpdb->query
(
$wpdb->prepare
(
"TRUNCATE Table ".bookingTable(),""
)
);
$wpdb->query
(
$wpdb->prepare
(
"TRUNCATE Table ".multiple_bookingTable(),""
)
);
$wpdb->query
(
$wpdb->prepare
(
"TRUNCATE Table ".bookingsCountTable(),""
)
);
die();
}
else if($_REQUEST['param'] == "RestoreFactorySettings")
{
include_once 'booking-xpress.php';
plugin_delete_script();
plugin_install_script();
die();
}
else if($_REQUEST['param'] == "getPaypalStatus")
{
$PPStatus = $wpdb->get_var
(
$wpdb->prepare
(
'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() . ' where   PaymentGatewayKey = %s',
"paypal-enabled"
)
);
if($PPStatus == 0)
{
echo "OFF";
}
else
{
echo "ON";
}
die();
}
else if($_REQUEST['param'] == "updateGeneralSettings")
{
$uxDefaultcurrency = esc_attr($_REQUEST['uxDdlDefaultCurrency']);
$uxDefaultcountry = esc_attr($_REQUEST['uxDdlDefaultCountry']);
$uxDefaultTimeFormat = esc_attr($_REQUEST['uxDefaultTimeFormat']);
$uxDefaultDateFormat = esc_attr($_REQUEST['uxDefaultDateFormat']);
$uxServiceDisplayFormat = esc_attr($_REQUEST['uxServiceDisplayFormat']);
$default_Time_Zone =  esc_attr($_REQUEST['uxDefaultTimeZone']);
$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".currenciesTable()." SET CurrencyUsed = %d  WHERE CurrencyName = %s",
1,
$uxDefaultcurrency
)
);
$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".currenciesTable()." SET CurrencyUsed = %d  WHERE CurrencyName != %s",
0,
$uxDefaultcurrency
)
);
$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".countriesTable()." SET CountryUsed = %d where CountryName = %s",
1,
$uxDefaultcountry
)
);
$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".countriesTable()." SET CountryUsed = %d where CountryName != %s",
0,
$uxDefaultcountry
)
);
$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %d  WHERE GeneralSettingsKey = %s",
$uxDefaultTimeFormat,
"default_Time_Format"
)
);

$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %d  WHERE GeneralSettingsKey = %s",
$uxDefaultDateFormat,
"default_Date_Format"
)
);
$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s  WHERE GeneralSettingsKey = %s",
$default_Time_Zone,
"default_Time_Zone"
)
);
$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s  WHERE GeneralSettingsKey = %s",
$StaffManagement,
"default_Staff_Management_Settings"
)
);
$wpdb->query
(
$wpdb->prepare
(
"UPDATE ".generalSettingsTable()." SET GeneralSettingsValue = %s  WHERE GeneralSettingsKey = %s",
$uxServiceDisplayFormat,
"default_Service_Display"
)
);

die();
}
}
}
?>