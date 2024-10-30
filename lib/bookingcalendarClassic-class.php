<?php
	if($_REQUEST['param'] == "frontendService")
	{
		$serviceId  = intval($_REQUEST['serviceId']);
		$service = $wpdb->get_row
		(
			$wpdb->prepare
			(
				'SELECT Type, ServiceCost, ServiceFullDay, ServiceMaxBookings FROM '.servicesTable().'  WHERE ServiceId = %d ',
				$serviceId
			)
		);
		if($service->Type == 0)
		{
			$type = "Single Booking";
		}
		else
		{
			$type = "Group Booking";
			$type = $type . "(" . $service->ServiceMaxBookings . ")";
		}
		
		$currencyIcon = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT CurrencySymbol FROM '.currenciesTable().'  WHERE CurrencyUsed = 1'
				
			)
		);		
		
		echo $type .",".$service->ServiceCost.",".$service->ServiceFullDay . "," . $currencyIcon;
		die();
	}
	else if($_REQUEST['param'] == "frontendCalender")
	{
		$serviceId  = intval($_REQUEST['serviceId']);
		$currentdate = date("Y-m-d");
		$service = $wpdb->get_row
		(
			$wpdb->prepare
			(
				'SELECT ServiceFullDay,ServiceMaxBookings,Type,MaxDays FROM '.servicesTable().'  WHERE ServiceId = %d ',
				$serviceId
			)
		);
		$AllBlockOuts = $wpdb->get_results
		(
			$wpdb->prepare
			(
				'SELECT * FROM '.block_outs().'  WHERE ServiceId = %d and FullDayBlockOuts =%d ',
				$serviceId,
				"1"
			)
		);
		$bookingCount = $wpdb->get_results
		(
			$wpdb->prepare
			(
				'SELECT CountTotal FROM '.bookingsCountTable() .' where ServiceId = %d and BookingDate > "%s"',
				$serviceId,
				$currentdate
			)
		);
		$allBookings =  $wpdb->get_results
		(
			$wpdb->prepare
			(
				'SELECT Distinct ('.bookingTable().'.BookingDate),'.bookingTable().'.serviceId,COUNT(*) as Total from '.bookingTable().'
				where '.bookingTable().'.BookingDate > "%s"  
				and  '.bookingTable().'.serviceId = %d GROUP BY  '.bookingTable().'.BookingDate',
				$currentdate,
				$serviceId
			)
		);
		$totalCountBookings = $wpdb->get_results
		(
			$wpdb->prepare
			(
				'Select * from ' . bookingsCountTable() . ' where ServiceId = %d',
				$serviceId
			)
		);
		//Array Initilization
		$BookingCountTotal = array();
		$bookingDatesArray = array();
		$blockDatesArray = array();
		$weekDays = array();
		$WeekName = array();
		$dynamic = "";
		for($flagCount = 0 ;$flagCount < count($bookingCount); $flagCount++)
		{
			array_push($BookingCountTotal,$bookingCount[$flagCount]->CountTotal); 
		}
		for($flag = 0; $flag < count($totalCountBookings); $flag++)
		{
			if($totalCountBookings[$flag]->CountTotal > $service->ServiceMaxBookings)
			{
				array_push($bookingDatesArray, $totalCountBookings[$flag]->BookingDate);
			}
		}
		for($flagBlock = 0 ;$flagBlock < count($AllBlockOuts); $flagBlock++)
		{
			$dailyCase = $AllBlockOuts[$flagBlock]->Repeats;
			// code for endate check
			if($AllBlockOuts[$flagBlock]->EndDate == 0)
			{
				$blockOutEndDate = date('Y-m-d',strtotime(date("Y-12-25", mktime()) . " + 1 year"));
			}
			else
			{
				$blockOutEndDate = $AllBlockOuts[$flagBlock]->EndDate;
			}
			$start_date = $AllBlockOuts[$flagBlock]->StartDate;
			// code for weekdays/daily case
			if($dailyCase == 0)
			{
				for($loopDate = $start_date; $loopDate < $blockOutEndDate ; $loopDate = date("Y-m-d", strtotime("+ ".$AllBlockOuts[$flagBlock]->RepeatEvery." day", strtotime($loopDate))))
				{
					array_push($blockDatesArray,$loopDate);
				}
			}
			else
			{
				$StartweekNumber = date("W", strtotime($start_date));
				$EndweekNumber = date("W", strtotime($blockOutEndDate));
				for( $Startweek = $StartweekNumber; $Startweek <= $EndweekNumber; $Startweek += $AllBlockOuts[$flagBlock]->RepeatEvery)
				{
					array_push($weekDays,$Startweek);
				}
				array_push($WeekName,$AllBlockOuts[$flagBlock]->RepeatDays);
			}
		}
		$dynamic ='
		<script>jQuery("#calBindingMultiple").multiDatesPicker
		({
			altField: "#altField",
			beforeShowDay: disableSpecificWeekDays';
			if($service->ServiceFullDay == 1)
			{
				$MaxPicks = $service->MaxDays;
				if($service->MaxDays == "Unlimited" || $service->MaxDays == null)
				{
					$dynamic .= ",
					numberOfMonths :3,
					fullDay:true
				});";
				}
				else
				{
					$dynamic .= ",
					numberOfMonths:3,
					maxPicks: '$MaxPicks',
					changeMonth: false,
					fullDay:true
				});";
				}
			}
			else
			{
				$dynamic .= ",fullDay:false,addDisabledDates: []});";
			}
			$dynamic .='function disableSpecificWeekDays(date) 
			{
				var day = date.getDay();
				var yyyy = date.getFullYear().toString();
				var mm = (date.getMonth()+1).toString(); // getMonth() is zero-based
				var dd  = date.getDate().toString();
				var finalDate = yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
				var temp = new Date(date.getFullYear(),0,1);					
				var Sun = 0, Mon= 1, Tue = 2, Wed = 3, Thu = 4, Fri = 5, Sat = 6;
				var weekNow =  Math.ceil((((date - temp) / 86400000) + temp.getDay()+1)/7);
				var daysToDisable = [';
				for($loop = 0; $loop < count($blockDatesArray);$loop++)
				{
					if($loop < (count($blockDatesArray)- 1))
					{
						$dynamic.= strtotime($blockDatesArray[$loop]).",";
					}
					else
					{
						$dynamic.= strtotime($blockDatesArray[$loop]);
					}
				}
				if($service->ServiceFullDay == 1)
				{
					if($service->Type == 1)
					{
						if(count($blockDatesArray) > 0 && count($bookingDatesArray) > 0)
						{
							$dynamic .= ",";
						}
						for($loop = 0; $loop < count($bookingDatesArray); $loop++)
						{
							if($loop < (count($bookingDatesArray)- 1))
							{
								$dynamic.= strtotime($bookingDatesArray[$loop]).",";
							}
							else
							{
								$dynamic.= strtotime($bookingDatesArray[$loop]);
							}
						}
					}
					else
					{
						if(count($blockDatesArray) > 0 && count($totalCountBookings) > 0)
						{
							$dynamic .= ",";
						}
						for($loop = 0; $loop < count($totalCountBookings); $loop++)
						{
							if($loop < (count($totalCountBookings)- 1))
							{
								$dynamic.= strtotime($totalCountBookings[$loop]->BookingDate).",";
							}
							else
							{
								$dynamic.= strtotime($totalCountBookings[$loop]->BookingDate);
							}
						}
					}
				}
				$dynamic .= "];";
				$dynamic .= "var weeksToBlock = [";
				for($loop = 0; $loop < count($weekDays);$loop++)
				{
					if($loop < (count($weekDays)- 1))
					{
						$dynamic.= $weekDays[$loop].",";
					}
					else
					{
						$dynamic.= $weekDays[$loop];
					}
				}
				$dynamic .= "];";
				$dynamic .= "var weekDays = [";
				for($weekN = 0; $weekN < count($WeekName); $weekN++)
				{
					if($weekN <  (count($WeekName)- 1))
					{
						$dynamic.= $WeekName[$weekN].",";
					}
					else
					{
						$dynamic.= $WeekName[$weekN];
					}
				}
				$dynamic .='];';
				$dynamic .= 'if(daysToDisable.length > 0) 
				{
					if(jQuery.inArray(new Date(finalDate).valueOf() / 1000, daysToDisable) != -1)
					{
						return [false];
					}
				}
				if(weeksToBlock.length > 0)
				{
					if(jQuery.inArray(weekNow, weeksToBlock) != -1)
					{
						if(jQuery.inArray(day, weekDays) != -1)
						{
							return [false];
						}
						return [true];
					}
				}
				return [true];
			}';
			$dynamic .='</script>';
			echo $dynamic;
		die();
	}
	else if($_REQUEST['param'] == "frontEndMutipleDates")
	{
		$serviceId  = intval($_REQUEST['serviceId']);
		$uxCouponCode = esc_attr($_REQUEST['uxCouponCode']);
		$uxNotes = esc_attr($_REQUEST['uxNotes']);
		$altField = esc_attr($_REQUEST['altField']);
		$dates = explode(",", $altField);
		$bookingTime  = intval($_REQUEST['bookingTime']);
		$customerLastId = intval($_REQUEST['customerId']);
		$autoApproveStatus = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT GeneralSettingsValue FROM '.generalSettingsTable() .' where GeneralSettingsKey = %s',
				"auto-approve-enable"
			)
		);
		$customerDetails = $wpdb->get_row
		(
			$wpdb->prepare
			(
				"SELECT * FROM ".customersTable()." WHERE CustomerId = %d",
				$customerLastId
			)
		);
		$countryName = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT CountryName FROM ".countriesTable()." WHERE CountryId = %d",
				$customerDetails->CustomerCountry
			)
		);
		$bookingCount = $wpdb->get_row
		(
			$wpdb->prepare
			(
				'SELECT count(bookingCountId) as CountTotal FROM '.bookingsCountTable() .' where ServiceId = %d and BookingDate = "%s"',
				$serviceId,
				$dates[0]
			)
		);
		$mailChimpEnable = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT AutoResponderValue FROM ".auto_Responders_settingsTable()." WHERE AutoResponderKey = %s",
				'mail-chimp-enabled'
			)
		);
		if($bookingCount->CountTotal == null)
		{
			$countTotals = 1;
		}
		else 
		{
			$countTotals = $bookingCount->CountTotal + 1;
		}
		if($bookingCount->CountTotal == 0)
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".bookingsCountTable()."(ServiceId,BookingDate,CountTotal) 
					VALUES(%d, '%s', %d)",
					$serviceId,
					$dates[0],
					$countTotals
				)
			);
		}
		else 
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"Update ".bookingsCountTable()." SET ServiceId = %d, BookingDate = '%s',CountTotal = %d ", 
					$serviceId,
					$dates[0],
					$countTotals
				)
			);	
		}
		if($autoApproveStatus == "1")
		{
			$bookingStatus = "Approved";
		}
		else
		{
			$bookingStatus = "Pending Approval";
		}
		$serviceType = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT ServiceFullDay FROM '. servicesTable() .' where ServiceId = %d',
				$serviceId
			)
		);
		
		if($serviceType == 1)
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".bookingTable()."(CustomerId,ServiceId,BookingDate,BookingStatus,couponCode,Comments,DateofBooking)
					VALUES(%d, %d, '%s', %s, %s, %s, CURDATE())",
					$customerLastId,
					$serviceId,
					$dates[0],
					$bookingStatus,
					$uxCouponCode,
					$uxNotes
				)
			);
			echo $BookingId = $wpdb->insert_id;
			for($flag = 0; $flag < count($dates); $flag++)
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"INSERT INTO ".multiple_bookingTable()."(bookingId,bookingDate) VALUES(%s, '%s')",
						$BookingId,
						$dates[$flag]
					)
				);
				
			}
			include_once TBP_BK_PLUGIN_DIR.'/views/mailmanagement.php';
			$payenable= $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() .' where PaymentGatewayKey = %s',
					"paypal-enabled"
				)
			);
			if($payenable == 1)
			{
				MailManagement($BookingId,"notification");
			}
			else 
			{
				if($autoApproveStatus == 1)
				{
					MailManagement($BookingId,"approved");
				}
				else 
				{
					MailManagement($BookingId,"approval_pending");
					MailManagement($BookingId,"admin");
				}
			}
			include_once TBP_BK_PLUGIN_DIR.'/mcapis/store-address.php';
			if($mailChimpEnable == 1)
			{
				storeAddress($customerDetails->CustomerFirstName,$customerDetails->CustomerLastName,$customerDetails->CustomerEmail,$customerDetails->CustomerAddress1,$customerDetails->CustomerCity,$countryName,$customerDetails->CustomerZipCode);
			}
		}
		else
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".bookingTable()."(CustomerId,ServiceId,BookingDate ,BookingStatus,TimeSlot,couponCode,Comments,DateofBooking)
					 VALUES(%d, %d, '%s', %s, %d, %s, %s, CURDATE())",
					$customerLastId,
					$serviceId,
					$dates[0],
					$bookingStatus,
					$bookingTime,
					$uxCouponCode,
					$uxNotes
				)
			);
			echo $BookingId = $wpdb->insert_id;
			include_once TBP_BK_PLUGIN_DIR.'/views/mailmanagement.php';
			$payenable= $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT PaymentGatewayValue FROM ' . payment_Gateway_settingsTable() .' where PaymentGatewayKey = %s',
					"paypal-enabled"
				)
			);
			if($payenable == 1)
			{
				MailManagement($BookingId,"notification");
			}
			else 
			{
				if($autoApproveStatus == 1)
				{
					MailManagement($BookingId,"approved");
				}
				else 
				{
					MailManagement($BookingId,"approval_pending");
					MailManagement($BookingId,"admin");
				}
			}
			include_once TBP_BK_PLUGIN_DIR.'/mcapis/store-address.php';
			if($mailChimpEnable == 1)
			{
				storeAddress($customerDetails->CustomerFirstName,$customerDetails->CustomerLastName,$customerDetails->CustomerEmail,$customerDetails->CustomerAddress1,$customerDetails->CustomerCity,$countryName,$customerDetails->CustomerZipCode);
			}
		}
		die();
	}
	else if($_REQUEST['param'] == "bookingTiming")
	{
		function find_closest ( $needle, $haystack ) 
			{
				//sort the haystack
				sort($haystack);
				//get the size to be used later
				$haystack_size = count($haystack);
				//pre-check, is the needle less than the lowest array value 
				if ( $needle < $haystack[0] )
				{
					return $haystack[0];
				}
				//loop through the haystack 
				foreach ( $haystack AS $key => $val ) 
				{
					//if we have a match with the current value, return it 
					if ( $needle == $val )
					{
						return $val;
					}
					//if we've hit the end of the array, return the max value 
					if ( $key == $haystack_size - 1 ) 
					{
						return $val; 
					}
					//now do the "between" check 
					if( $needle > $val && $needle < $haystack[$key+1] )
					{
						//find the closest.  If they're equidistant, the higher value gets precedence 
						if ( $needle - $val < $haystack[$key+1] - $needle ) 
			            { 
			                return $val; 
			            } 
			            else  
			            { 
			                return $haystack[$key]; 
			            } 
			        } 
			    } 
			}
			$serviceId  = intval($_REQUEST['serviceId']);
			$BookingDate = $_REQUEST['bookingDates'];
			if($BookingDate == "")
			{
				$BookingDate = date('Y-m-d');
			}	
			$ServiceTableData = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT ServiceFullDay,ServiceStartTime,ServiceEndTime,ServiceTotalTime,ServiceMaxBookings,Type FROM ".servicesTable()." where ServiceId = %d",
					$serviceId
				)
			);
			$CurrentBookingDay =  date('D',strtotime($BookingDate));
			$CurrentBookingWeek =  date('W',strtotime($BookingDate));
			
			$checkMultipleBookingsCount = $wpdb->get_results
			(
				$wpdb->prepare
				(
						"SELECT TimeSlot, COUNT(*) as Total FROM " .bookingTable(). " join " . servicesTable() ." on " .bookingTable().".ServiceId = ".servicesTable().".ServiceId 
						where ". bookingTable() . ".BookingDate = '%s' and ". bookingTable() . ".ServiceId = %d  GROUP BY TimeSlot",
						$BookingDate,
						$serviceId
				)
			);
			$checkBookings = $wpdb->get_results
			(
				$wpdb->prepare
				(
						"SELECT TimeSlot FROM " .bookingTable(). " join " . servicesTable() ." on " .bookingTable().".ServiceId = ".servicesTable().".ServiceId 
						where ". bookingTable() . ".BookingDate = '%s' and ". bookingTable() . ".ServiceId = %d",
						$BookingDate,
						$serviceId
				)
			);
			$AllBlockOuts = $wpdb->get_results
	       	(
				$wpdb->prepare
				(
					 'SELECT * FROM '.block_outs().'  WHERE ServiceId = %d and FullDayBlockOuts =%d ',
					 $serviceId,
					 "0"
				)
			);
			$MultiplebookingTimesArray = array();
			$bookingTimesArray = array();
			$blockOutTimeArray = array();
			$blockDatesArray = array();
			
			$new_array1 = array();
			
			for($flag = 0; $flag < count($checkMultipleBookingsCount); $flag++)
			{
				
				if($checkMultipleBookingsCount[$flag]->Total >= $ServiceTableData->ServiceMaxBookings)
				{
					array_push($MultiplebookingTimesArray,$checkMultipleBookingsCount[$flag]->TimeSlot);
				}
			}
			for($flag = 0; $flag < count($checkBookings); $flag++)
			{
				array_push($bookingTimesArray,$checkBookings[$flag]->TimeSlot);
			}
			for($timeOff = $ServiceTableData->ServiceStartTime; $timeOff <= $ServiceTableData->ServiceEndTime; $timeOff += $ServiceTableData->ServiceTotalTime)
			{
				array_push($new_array1,$timeOff);
			}
			
			for($flagBlock = 0 ;$flagBlock < count($AllBlockOuts); $flagBlock++)
			{
				$dailyCase = $AllBlockOuts[$flagBlock]->Repeats;
				 
				// code for endate check
				if($AllBlockOuts[$flagBlock]->EndDate == 0)
				{
					$blockOutEndDate = date('Y-m-d',strtotime(date("Y-12-25", mktime()) . " + 1 year"));
				}
				else
				{
					$blockOutEndDate = $AllBlockOuts[$flagBlock]->EndDate;
				}
				$start_date = $AllBlockOuts[$flagBlock]->StartDate;
				// code for weekdays/daily case
				if($dailyCase == 0)
				{
					for($loopDate = $start_date; $loopDate <= $blockOutEndDate ; $loopDate = date("Y-m-d", strtotime("+ ".$AllBlockOuts[$flagBlock]->RepeatEvery." day", strtotime($loopDate))))
					{
						if($loopDate == $BookingDate)
						{									
							for($flagLoop = $AllBlockOuts[$flagBlock]->StartTime; $flagLoop < $AllBlockOuts[$flagBlock]->EndTime; $flagLoop += $ServiceTableData->ServiceTotalTime)
							{
								$value = find_closest($flagLoop,$new_array1);
							
								if(!in_array($value,$blockOutTimeArray))
								{
									
									array_push($blockOutTimeArray,$value);
								} 
							}
							break;
						}
					}
				}
				else 
				{
					$WeekDays = explode(',', $AllBlockOuts[$flagBlock]->RepeatDays);							 
					$StartweekNumber = date("W", strtotime($start_date)); 
					$EndweekNumber = date("W", strtotime($blockOutEndDate));
					for( $Startweek = $StartweekNumber; $Startweek <= $EndweekNumber; $Startweek += $AllBlockOuts[$flagBlock]->RepeatEvery)
					{
						if($Startweek == $CurrentBookingWeek)
						{
							for($flag = 0; $flag<count($WeekDays);$flag++)
							{
								if($WeekDays[$flag] == $CurrentBookingDay)
								{
									for($flagLoop = $AllBlockOuts[$flagBlock]->StartTime; $flagLoop < $AllBlockOuts[$flagBlock]->EndTime; $flagLoop += $ServiceTableData->ServiceTotalTime)
									{
										$value = find_closest($flagLoop,$new_array1);
									
										if(!in_array($value,$blockOutTimeArray))
										{
											
											array_push($blockOutTimeArray,$value);
										} 
									}
									break;
								}
							}
							
						}
					   
					 }						
				} 
			}					
			$timeFormats = $wpdb->get_var
			 (
			 	$wpdb->prepare
			 	(
			 		"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
			 		'default_Time_Format'
			 	)
			);
			if($ServiceTableData->ServiceFullDay == 0)
			{
				for($timeOff = $ServiceTableData->ServiceStartTime; $timeOff < $ServiceTableData->ServiceEndTime; $timeOff += $ServiceTableData->ServiceTotalTime)
				{
					
					$getHours = floor($timeOff / 60) ;
					$getMins = $timeOff % 60 ;
					$hourFormat = $getHours . ":" . $getMins;
					if($timeFormats == 0)
					{
						$time_in_12_hour_format  = DATE("h:iA", STRTOTIME($hourFormat));
					}
					else 
					{
						$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
					}
					if($ServiceTableData->Type == 1)
					{
						if((!in_array($timeOff,$MultiplebookingTimesArray)) && (!in_array($timeOff,$blockOutTimeArray)))
						{
							
							?>
							
							<a value="<?php echo $timeOff; ?>" href="#" class="timeCol hovertip" data-placement="top"><?php echo $time_in_12_hour_format; ?></a>
							<?php
					
						}
						else
						{
								?>
							<span value="<?php echo $timeOff; ?>" class="timeCol-blocked hovertip" data-placement="top"><?php echo $time_in_12_hour_format; ?></span>
							<?php
						}
					}
					else
					{
						
						if((!in_array($timeOff,$bookingTimesArray)) && (!in_array($timeOff,$blockOutTimeArray)))
						{
							
							?>
							
							<a value="<?php echo $timeOff; ?>" href="#" class="timeCol hovertip" data-placement="top"><?php echo $time_in_12_hour_format; ?></a>
							<?php
					
						}
						else
						{
								?>
							<span value="<?php echo $timeOff; ?>" class="timeCol-blocked hovertip" data-placement="top"><?php echo $time_in_12_hour_format; ?></span>
							<?php
						}
					}
				}
				?>
					<input type="hidden" value="" id="hdTimeControl"/>
					<input type="hidden" value="" id="hdTimeControlValue"/>
				<?php
			}
			else
			{
				echo "fullday";
			}	
			
			?>
		
			<?php
			die();		
	}
	else if($_REQUEST['param'] == 'getExistingCustomerData')
	{
		$uxEmailAddress = esc_attr($_REQUEST['uxEmailAddress']);
		$customerId = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT CustomerId FROM ' . customersTable(). ' where CustomerEmail  = %s',
				$uxEmailAddress
			)
		);
		if($customerId == 0)
		{
			echo $returnEmployeeEmailCountCheck = "newCustomer";
		}
		else
		{
			global $customer;
			$customerCount = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT count(". bookingTable() .".BookingId) FROM ". customersTable() ." join " . bookingTable() . " on " . customersTable() . ".CustomerId = " . bookingTable() . ".CustomerId where ". customersTable() .".CustomerId = %d",
					$customerId
				)
			);
			if($customerCount > 0)
			{
				$customer = $wpdb->get_row
				(
					$wpdb->prepare
					(
						"SELECT * FROM ". customersTable() ." join " . bookingTable() . " on " . customersTable() . ".CustomerId = " . bookingTable() . ".CustomerId where ". customersTable() .".CustomerId = %d",
						$customerId
					)
				);
			}
			else {
				
				$customer = $wpdb->get_row
				(
					$wpdb->prepare
					(
						"SELECT * FROM ". customersTable() ." where CustomerId = %d",
						$customerId
					)
				);
				
			}
			$requiredFields1 = $wpdb->get_results
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".bookingFormTable()." where status = %d",
					"1"					
					)
				);
				$faceboookEnable = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT SocialMediaValue FROM '.social_Media_settingsTable().' where SocialMediaKey = %s',
						"facebook-connect-enable"
					)
				);
				?>
				<script type="text/javascript">
					<?php
					for($flagField = 0; $flagField < count($requiredFields1); $flagField++)
					{
						switch("uxTxtControl".$requiredFields1[$flagField]->BookingFormId)
						{
							case "uxTxtControl2":
					?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerFirstName; ?>");
							<?php
								break;
								case "uxTxtControl3":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerLastName; ?>");
							<?php
								break;
								case "uxTxtControl4":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerMobile; ?>");
							<?php
								break;
								case "uxTxtControl5":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerTelephone; ?>");
							<?php
								break;
								case "uxTxtControl6":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerSkypeId; ?>");
							<?php
								break;
							
								case "uxTxtControl7":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerAddress1; ?>");
							<?php
								break;
								case "uxTxtControl8":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerAddress2; ?>");
							<?php
								break;
								case "uxTxtControl9":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerCity; ?>");
							<?php
								break;
								
								case "uxTxtControl10":
							?>
							jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->CustomerZipCode; ?>");
							<?php
								break;
																
								case "uxTxtAreaControl13":
								?>
								jQuery('#uxTxtAreaControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val("<?php echo $customer->Comments; ?>");
								<?php
									break;
						}
					}
								?>
					jQuery('#uxDdlControl12').val("<?php echo $customer->CustomerCountry; ?>");
				</script>
				<?php
			}
		die();
	}
	else if($_REQUEST['param'] == "checkForCouponExist")
	{
		$uxCouponCode = esc_attr($_REQUEST['uxCouponCode']);
		$serviceId = intval($_REQUEST['serviceId']);
		$currentDate = date('Y-m-d');		
		$serviceAmount = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT ServiceCost FROM ' . servicesTable() . ' WHERE ServiceId = %d',
				 $serviceId
			)
		);
		$requiredFields = $wpdb->get_row
		(
			$wpdb->prepare
			(
				"SELECT * FROM ".bookingFormTable()." where BookingFormId = %d ",
				"11"
			)
		);
		if($requiredFields->required == 1) 
		{
			if($serviceAmount != 0)
			{
				$countMatchCouponName = $wpdb->get_row
				(
					$wpdb->prepare
					(
						'SELECT count(couponId) as countTotal FROM ' . coupons() . ' WHERE couponName = %s',
						 $uxCouponCode
					)
				);
				if($countMatchCouponName->countTotal == 1)
				{
				
					$countMatchCouponId = $wpdb->get_row
					(
						$wpdb->prepare
						(
							'SELECT couponId FROM ' . coupons() . ' WHERE couponName = %s',
							 $uxCouponCode
						)
					);
					$allDateCoupon = $wpdb->get_row
					(
						$wpdb->prepare
						(
							'SELECT * FROM ' . coupons() . ' WHERE couponId = %d',
							 $countMatchCouponId->couponId
						)
					);
					if($allDateCoupon->couponApplicable == 1)
					{
						global $cost;
						
						$couponValidDates = $wpdb->get_row
						(
							$wpdb->prepare
							(
								'SELECT couponValidFrom, couponValidUpto FROM ' . coupons() . ' WHERE couponId = %d',
								 $countMatchCouponId->couponId
							)
						);
														
							if($currentDate >=  $couponValidDates->couponValidFrom && $currentDate <=  $couponValidDates->couponValidUpto)
							{
								if($allDateCoupon->amountType == 0)
								{
									echo $cost = $serviceAmount - $allDateCoupon->Amount . "-" . "CouponValid";
								}
								else 
								{
									$discountPercent = $serviceAmount * $allDateCoupon->Amount / 100;
									echo $cost = $serviceAmount - $discountPercent . "-" . "CouponValid";
								}
								
							}
							else {
								echo "0" . "-" . "CouponNotValid";
							}
							
							
					}
					else
					{
						$checkServiceCoupon = $wpdb->get_var
						(
							$wpdb->prepare
							(
								'SELECT count(' . coupons_products() . '.couponId)  FROM ' . coupons_products() . ' join ' . coupons() .' on ' . coupons_products() . '.couponId = ' . coupons() .'.couponId where ' . coupons() .'.couponName = %s AND ' . coupons_products() . '.serviceId = %d',
								 $uxCouponCode,
								 $serviceId
							)
						);
						if($checkServiceCoupon > 0)
						{
							global $cost;
							$couponValidDates = $wpdb->get_row
							(
								$wpdb->prepare
								(
									'SELECT couponValidFrom, couponValidUpto FROM ' . coupons() . ' WHERE couponId = %d',
									 $countMatchCouponId->couponId
								)
							);
														
							if($currentDate >=  $couponValidDates->couponValidFrom && $currentDate <=  $couponValidDates->couponValidUpto)
							{
							
								if($allDateCoupon->amountType == 0)
								{
									echo $cost = $serviceAmount - $allDateCoupon->Amount . "-" . "CouponValid";
								}
								else 
								{
									$discountPercent = $serviceAmount * $allDateCoupon->Amount / 100;
									echo $cost = $serviceAmount - $discountPercent . "-" . "CouponValid";
								}
							}
							else 
							{
								echo "0" . "-" . "CouponNotValid";
							}
							
							
						}
						else 
						{
							echo "0" . "-" . "CouponNotValid";
						}
					}

				}
				else 
				{
					
					echo "0" . "-" . "CouponNotValid";
					
				}
			}
		}
		else 
		{
					
			if($uxCouponCode != "")
			{
				if($serviceAmount != 0)
				{
				$countMatchCouponName = $wpdb->get_row
				(
					$wpdb->prepare
					(
						'SELECT count(couponId) as countTotal FROM ' . coupons() . ' WHERE couponName = %s',
						 $uxCouponCode
					)
				);
				if($countMatchCouponName->countTotal == 1)
				{
				
					$countMatchCouponId = $wpdb->get_row
					(
						$wpdb->prepare
						(
							'SELECT couponId FROM ' . coupons() . ' WHERE couponName = %s',
							 $uxCouponCode
						)
					);
					$allDateCoupon = $wpdb->get_row
					(
						$wpdb->prepare
						(
							'SELECT * FROM ' . coupons() . ' WHERE couponId = %d',
							 $countMatchCouponId->couponId
						)
					);
					
					if($allDateCoupon->couponApplicable == 1)
					{
						global $cost;
						
						$couponValidDates = $wpdb->get_row
						(
							$wpdb->prepare
							(
								'SELECT couponValidFrom, couponValidUpto FROM ' . coupons() . ' WHERE couponId = %d',
								 $countMatchCouponId->couponId
							)
						);
														
							if($currentDate >=  $couponValidDates->couponValidFrom && $currentDate <=  $couponValidDates->couponValidUpto)
							{
								if($allDateCoupon->amountType == 0)
								{
									echo $cost = $serviceAmount - $allDateCoupon->Amount . "-" . "CouponValid";
								}
								else 
								{
									$discountPercent = $serviceAmount * $allDateCoupon->Amount / 100;
									echo $cost = $serviceAmount - $discountPercent . "-" . "CouponValid";
								}
								
							}
							else {
								echo "0" . "-" . "CouponNotValid";
							}
							
							
					}
					else
					{
						$checkServiceCoupon = $wpdb->get_var
						(
							$wpdb->prepare
							(
								'SELECT count(' . coupons_products() . '.couponId)  FROM ' . coupons_products() . ' join ' . coupons() .' on ' . coupons_products() . '.couponId = ' . coupons() .'.couponId where ' . coupons() .'.couponName = %s AND ' . coupons_products() . '.serviceId = %d',
								 $uxCouponCode,
								 $serviceId
							)
						);
						if($checkServiceCoupon > 0)
						{
							global $cost;
							$couponValidDates = $wpdb->get_row
							(
								$wpdb->prepare
								(
									'SELECT couponValidFrom, couponValidUpto FROM ' . coupons() . ' WHERE couponId = %d',
									 $countMatchCouponId->couponId
								)
							);
														
							if($currentDate >=  $couponValidDates->couponValidFrom && $currentDate <=  $couponValidDates->couponValidUpto)
							{
							
								if($allDateCoupon->amountType == 0)
								{
									echo $cost = $serviceAmount - $allDateCoupon->Amount . "-" . "CouponValid";
								}
								else 
								{
									$discountPercent = $serviceAmount * $allDateCoupon->Amount / 100;
									echo $cost = $serviceAmount - $discountPercent . "-" . "CouponValid";
								}
							}
							else 
							{
								echo "0" . "-" . "CouponNotValid";
							}
							
							
						}
						else 
						{
							echo "0" . "-" . "CouponNotValid";
						}
					}
					

				}
				else 
				{
					
					echo "0" . "-" . "CouponNotValid";
					
				}
			}
		}
		else
		{
			echo $serviceAmount . "-" . "leaveBlank";
		}
					
	}
	die();
	}
	
	else if($_REQUEST['param'] == 'checkForUpdateCustomer')
	{
				$uxEmailAddress = esc_attr($_REQUEST['uxEmailAddress']);
				$customerId = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT CustomerId FROM ' . customersTable(). ' where CustomerEmail = %s',
						 $uxEmailAddress
					)
				);
				if($customerId != 0)
				{
					echo $customerId;
				}
				else 
				{
					echo $returnEmployeeEmailCountCheck = "newCustomerEmail";
				}
				die();
			}
			
			
	else if($_REQUEST['param'] == 'upDateCustomer')
			{
				
				$customerId = esc_attr($_REQUEST['customerId']);
				$uxCustomerEmail =  esc_attr($_REQUEST['uxCustomerEmail']);
				$uxCustomerFname = esc_attr($_REQUEST['uxTxtControl2']);
								
				$customerInformation = $wpdb->get_row
				(
					$wpdb->prepare
					(
						'SELECT * FROM ' . customersTable(). ' where CustomerId = %d',
						 $customerId
					)
				);
				
				if(isset($_REQUEST['uxTxtControl3']))
				{
					$uxCustomerlname =  esc_attr($_REQUEST['uxTxtControl3']);	
				}
				else {
					$uxCustomerlname = $customerInformation->CustomerLastName;
				}
				if(isset($_REQUEST['uxTxtControl4']))
				{
					$uxCustomerMobile =  esc_attr($_REQUEST['uxTxtControl4']);	
				}
				else {
					$uxCustomerMobile = $customerInformation->CustomerMobile;
				}
				if(isset($_REQUEST['uxTxtControl5']))
				{
					$uxCustomerPhone =  esc_attr($_REQUEST['uxTxtControl5']);	
				}
				else {
					$uxCustomerPhone = $customerInformation->CustomerTelephone;
				}
				if(isset($_REQUEST['uxTxtControl6']))
				{
					$uxCustomerSkypeId =  esc_attr($_REQUEST['uxTxtControl6']);	
				}
				else {
					$uxCustomerSkypeId = $customerInformation->CustomerSkypeId;
				}												
				if(isset($_REQUEST['uxTxtControl7']))
				{
					$uxCustomerAddress1 =  esc_attr($_REQUEST['uxTxtControl7']);	
				}
				else {
					$uxCustomerAddress1 = $customerInformation->CustomerAddress1;
				}
				
				if(isset($_REQUEST['uxTxtControl8']))
				{
					$uxCustomerAddress2 =  esc_attr($_REQUEST['uxTxtControl8']);	
				}
				else {
					$uxCustomerAddress2 = $customerInformation->CustomerAddress2;
				}
				
				if(isset($_REQUEST['uxTxtControl9']))
				{
					$uxCustomerCity =  esc_attr($_REQUEST['uxTxtControl9']);	
				}
				else {
					$uxCustomerCity = $customerInformation->CustomerCity;
				}
				
				if(isset($_REQUEST['uxTxtControl10']))
				{
					$uxCustomerPostCode =  esc_attr($_REQUEST['uxTxtControl10']);	
				}
				else {
					$uxCustomerPostCode = $customerInformation->CustomerZipCode;
				}
				if(intval($_REQUEST['uxDdlControl12']) != 0)
				{
					$uxCustomerCountry =  intval($_REQUEST['uxDdlControl12']);	
				}
				else {
					$uxCustomerCountry = $customerInformation->CustomerCountry;
				}
				
				$wpdb->query
				(
					$wpdb->prepare
					(
							"Update " . customersTable() . " set CustomerFirstName = %s, CustomerLastName = %s, CustomerEmail = %s, CustomerTelephone = %s, CustomerMobile = %s, CustomerAddress1 = %s,
							CustomerAddress2 = %s, CustomerSkypeId = %s, CustomerCity = %s, CustomerZipCode = %s, CustomerCountry = %d where CustomerId = %d",						
							$uxCustomerFname,
							$uxCustomerlname,
							$uxCustomerEmail,
							$uxCustomerPhone,
							$uxCustomerMobile,
							$uxCustomerAddress1,
							$uxCustomerAddress2,
							$uxCustomerSkypeId,
							$uxCustomerCity,
							$uxCustomerPostCode,
							$uxCustomerCountry,
							$customerId							
					)
				);
				die();
			}
			else if($_REQUEST['param'] == "addNewCustomer")
			{
				
				$uxCustomerEmail = esc_attr($_REQUEST['uxTxtControl1']);
				$uxCustomerFname = esc_attr($_REQUEST['uxTxtControl2']);
				$uxCustomerlname = esc_attr(!isset($_REQUEST['uxTxtControl3'])) ? "" :  esc_attr($_REQUEST['uxTxtControl3']);
				$uxCustomerMobile = esc_attr(!isset($_REQUEST['uxTxtControl4'])) ? "" :  esc_attr($_REQUEST['uxTxtControl4']);
				$uxCustomerPhone = esc_attr(!isset($_REQUEST['uxTxtControl5']))  ? "" :  esc_attr($_REQUEST['uxTxtControl5']);
				$uxCustomerSkypeId = esc_attr(!isset($_REQUEST['uxTxtControl6'])) ? "" :  esc_attr($_REQUEST['uxTxtControl6']);
				$uxCustomerAddress1 = esc_attr(!isset($_REQUEST['uxTxtControl7'])) ? "" :  esc_attr($_REQUEST['uxTxtControl7']);
				$uxCustomerAddress2 = esc_attr(!isset($_REQUEST['uxTxtControl8'])) ? "" :  esc_attr($_REQUEST['uxTxtControl8']);
				$uxCustomerCity = esc_attr(!isset($_REQUEST['uxTxtControl9'])) ? "" :  esc_attr($_REQUEST['uxTxtControl9']);
				$uxCustomerPostCode = esc_attr(!isset($_REQUEST['uxTxtControl10'])) ? "" :  esc_attr($_REQUEST['uxTxtControl10']);
				$uxCustomerCouponCode = esc_attr(!isset($_REQUEST['uxTxtControl11'])) ? "" :  esc_attr($_REQUEST['uxTxtControl11']);
				$uxCustomerCountry = intval(!isset($_REQUEST['uxDdlControl12'])) ? "" :  intval($_REQUEST['uxDdlControl12']);
				$wpdb->query
				(
					$wpdb->prepare
					(
							"INSERT INTO ". customersTable() ."(CustomerFirstName, CustomerLastName, CustomerEmail, CustomerTelephone, CustomerMobile, CustomerAddress1,
							CustomerAddress2, CustomerSkypeId, CustomerCity, CustomerZipCode, CustomerCountry, DateTime) 
							VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d, CURDATE())",
							$uxCustomerFname,
							$uxCustomerlname,
							$uxCustomerEmail,
							$uxCustomerPhone,
							$uxCustomerMobile,
							$uxCustomerAddress1,
							$uxCustomerAddress2,
							$uxCustomerSkypeId,
							$uxCustomerCity,
							$uxCustomerPostCode,
							$uxCustomerCountry
							
					)
				);
				echo $customerId = $wpdb->insert_id;
				die();
			
			}
	
	
	else if($_REQUEST["param"] == "addCustomer")
	{
		$uxCustomerEmail = esc_attr($_REQUEST['uxTxtControl1']);		
		$uxCustomerFname = esc_attr($_REQUEST['uxTxtControl2']);
		$uxCustomerlname = esc_attr(!isset($_REQUEST['uxTxtControl3'])) ? "" :  esc_attr($_REQUEST['uxTxtControl3']);
		$uxCustomerMobile = esc_attr(!isset($_REQUEST['uxTxtControl4'])) ? "" :  esc_attr($_REQUEST['uxTxtControl4']);
		$uxCustomerPhone = esc_attr(!isset($_REQUEST['uxTxtControl5']))  ? "" :  esc_attr($_REQUEST['uxTxtControl5']);
		$uxCustomerSkypeId = esc_attr(!isset($_REQUEST['uxTxtControl6'])) ? "" :  esc_attr($_REQUEST['uxTxtControl6']);
		$uxCustomerAddress1 = esc_attr(!isset($_REQUEST['uxTxtControl7'])) ? "" :  esc_attr($_REQUEST['uxTxtControl7']);
		$uxCustomerAddress2 = esc_attr(!isset($_REQUEST['uxTxtControl8'])) ? "" :  esc_attr($_REQUEST['uxTxtControl8']);
		$uxCustomerCity = esc_attr(!isset($_REQUEST['uxTxtControl9'])) ? "" :  esc_attr($_REQUEST['uxTxtControl9']);
		$uxCustomerPostCode = esc_attr(!isset($_REQUEST['uxTxtControl10'])) ? "" :  esc_attr($_REQUEST['uxTxtControl10']);
		$uxCustomerCouponCode = esc_attr(!isset($_REQUEST['uxTxtControl11'])) ? "" :  esc_attr($_REQUEST['uxTxtControl11']);
		$uxCustomerCountry = intval(!isset($_REQUEST['uxDdlControl12'])) ? "" :  intval($_REQUEST['uxDdlControl12']);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ". customersTable() ."(CustomerFirstName, CustomerLastName, CustomerEmail, CustomerTelephone, CustomerMobile, CustomerAddress1,
				CustomerAddress2, CustomerSkypeId, CustomerCity, CustomerZipCode, CustomerCountry,DateTime) 
				VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d,CURDATE())",
				$uxCustomerFname,
				$uxCustomerlname,
				$uxCustomerEmail,
				$uxCustomerPhone,
				$uxCustomerMobile,
				$uxCustomerAddress1,
				$uxCustomerAddress2,
				$uxCustomerSkypeId,
				$uxCustomerCity,
				$uxCustomerPostCode,
				$uxCustomerCountry
			)
		);
		echo $customerId = $wpdb->insert_id;
		die();
	}
	else if($_REQUEST['param'] == "getTypeOfService")
	{
		$serviceId = intval($_REQUEST['serviceId']);
		$serviceType = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT ServiceFullDay FROM ' . servicesTable() . '  WHERE ServiceId = %d',
				$serviceId
			)
		);
		echo $serviceType;
		die();
	}
	
	else if($_REQUEST['param'] == "getExistingCustomerId")
	{
		$customerEmail = esc_attr($_REQUEST['uxEmailAddress']);
		$customerId = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT CustomerId FROM ' . customersTable() . ' WHERE CustomerEmail = %s',
				$customerEmail
			)
		);
		echo $customerId;
		die();
	}
?>