<?php
if(!current_user_can('edit_posts') && ! current_user_can('edit_pages'))
{
	return;
}
else
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == 'getBookings')
		{
			$serviceId = intval($_REQUEST['serviceId']);
			if(isset($_REQUEST['uxBookingStatus1']) == 'uxBookingStatus1')
			{
				$status1 = esc_attr($_REQUEST['uxBookingStatus1']);
			}
			else
			{
				$status1 = '';
			}
			if(isset($_REQUEST['uxBookingStatus2']) == 'uxBookingStatus2')
			{
				$status2 = esc_attr($_REQUEST['uxBookingStatus2']);
			}
			else
			{
				$status2 = '';
			}
			if(isset($_REQUEST['uxBookingStatus3']) == 'uxBookingStatus3')
			{
				$status3 = esc_attr($_REQUEST['uxBookingStatus3']);
			}
			else
			{
				$status3 = '';
			}
			if(isset($_REQUEST['uxBookingStatus4']) == 'uxBookingStatus4')
			{
				$status4 = esc_attr($_REQUEST['uxBookingStatus4']);
			}
			else
			{
				$status4 = '';
			}
			if(isset($_REQUEST['uxBookingStatus5']) == 'uxBookingStatus5')
			{
				$status5 = esc_attr($_REQUEST['uxBookingStatus5']);
			}
			else
			{
				$status5 = '';
			}
			$query = "";
			if($status1 == 1)
			{
				$query .= "( ". bookingTable().".BookingStatus = 'Pending Approval' ";
			}
			if($status2 == 1)
			{
				if($status1 == 1)
				{
					$query .= " or ";
				}
				else 
				{
					$query .= "( ";
				}
				$query .= bookingTable().".BookingStatus = 'Approved' ";
			}
			if($status3 == 1)
			{
				if($status1 == 1 || $status2 == 1)
				{
					$query .= " or ";
				}
				else 
				{
					$query .= "( ";
				}
				$query .= bookingTable().".BookingStatus = 'Disapproved' ";
			}
			if($status4 == 1)
			{
				if($status1 == 1 || $status2 == 1 || $status3 == 1)
				{
					$query .= " or ";
				}
				else 
				{
					$query .= "( ";
				}
				$query .= bookingTable().".BookingStatus = 'Cancelled' ";
			}
			if($status1 == 1 || $status2 == 1 || $status3 == 1  || $status4 == 1)
			{
				$query .= " )";
			}
			if($query != "")
			{
				$query2 = " and " . $query;
				$query1 = "  where " . $query ;
				$query = "  where " . $query  . " and ";
				
				
			}
			else 
			{
				$query2 = "";
				$query = " where ";
				$query1 = "";
			}
			$ServiceType = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT ServiceFullDay FROM ".servicesTable()." where ServiceId = %d",
					$serviceId
				)
			);
			if($serviceId == 0)
			{
				$allBookings = $wpdb->get_results
				(
					$wpdb->prepare
					(
						"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceColorCode,". servicesTable(). ".ServiceFullDay,
						". servicesTable(). ".ServiceTotalTime, " .bookingTable().".BookingDate,
						CONCAT(".customersTable().".CustomerFirstName ,' ',". customersTable(). ".CustomerLastName) as ClientName,
						" .customersTable().".CustomerMobile,". bookingTable().".BookingId,". bookingTable().".TimeSlot,
						" . bookingTable().".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
						".CustomerId= ".customersTable().".CustomerId ". " JOIN " .servicesTable()." ON ".bookingTable().
						".ServiceId=".servicesTable().".ServiceId  ".$query."  ". bookingTable().".TimeSlot != 0 UNION ALL SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceColorCode,
						". servicesTable(). ".ServiceFullDay,". servicesTable(). ".ServiceTotalTime," .multiple_bookingTable().".bookingDate,
						CONCAT(".customersTable().".CustomerFirstName ,' ',". customersTable(). ".CustomerLastName) as ClientName,
						" .customersTable().".CustomerMobile,". bookingTable().".BookingId,". bookingTable().".TimeSlot,
						" . bookingTable().".BookingStatus from ".bookingTable()." JOIN " .multiple_bookingTable()." on " .bookingTable().".BookingId = " .multiple_bookingTable().".bookingId
						LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().".CustomerId= ".customersTable().".CustomerId ". "
						JOIN " .servicesTable()." ON ".bookingTable().".ServiceId = ".servicesTable().".ServiceId  ".$query1,""
					)
				);
			}
			else
			{
				if($ServiceType == 1)
				{
					$allBookings =  $wpdb->get_results
					(
						$wpdb->prepare
						(
							"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceColorCode," .multiple_bookingTable().".bookingDate,CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable(). ".CustomerLastName) as ClientName,".customersTable().".CustomerMobile,
							". bookingTable().".BookingId,". bookingTable().".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
							".CustomerId= ".customersTable().".CustomerId ". " JOIN " .servicesTable()." ON ".bookingTable().
							".ServiceId=".servicesTable().".ServiceId LEFT OUTER JOIN " .multiple_bookingTable()." ON ".bookingTable().
							".BookingId=".multiple_bookingTable().".bookingId where ".bookingTable().".ServiceId = %d ".$query2,
							$serviceId
						)
					);
				}
				else
				{
					$allBookings = $wpdb->get_results
					(
						$wpdb->prepare
						(
							"SELECT ". servicesTable(). ".ServiceName,". servicesTable(). ".ServiceTotalTime,". servicesTable(). ".ServiceColorCode," .bookingTable().".BookingDate,CONCAT(".customersTable().".CustomerFirstName ,'  ',". customersTable(). ".CustomerLastName) as ClientName,".customersTable().".CustomerMobile,
							". bookingTable().".TimeSlot,". bookingTable().".BookingId,". bookingTable().".BookingStatus from ".bookingTable()." LEFT OUTER JOIN " .customersTable()." ON ".bookingTable().
							".CustomerId= ".customersTable().".CustomerId ". " JOIN " .servicesTable()." ON ".bookingTable().
							".ServiceId=".servicesTable().".ServiceId where ".bookingTable().".ServiceId = %d ".$query2." ORDER BY ".bookingTable().".BookingDate ASC",
							$serviceId
						)
					);
				}
			}
			$dynamicCalendar = "<script>jQuery('#calendar').fullCalendar( 'destroy' );jQuery('#calendar').fullCalendar
			({
				disableDragging: true,
				header: 
				{
					left: 'prev,next',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: false,
				events: [";
				for($start = 0; $start<count($allBookings);$start++)
				{
					if($serviceId == 0)
					{
						$bookingDate = date("Y-m-d", strtotime($allBookings[$start]->BookingDate));
						$bdate = (explode("-",$bookingDate));	
						$getHours = floor(($allBookings[$start]->TimeSlot)/60);
						$getEndHours = floor(($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime))/60;
						if($getHours%60!=0)
						{
							$getMins = ($allBookings[$start]->TimeSlot) % 60;
						}
						else 
						{
							$getMins = 0;
						}
						if($getEndHours%60!=0)
						{
							$getEndMins = ($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime) % 60;
						}
						else
						{
							$getEndMins = 0;
						}
						if($allBookings[$start]->ServiceFullDay == 1)
						{
							if($start == count($allBookings) -1)
							{
								$dynamicCalendar .= "{
								title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
								bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
								status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
								clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
								clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
								start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
								end: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
								url:'#EditBooking',
								allDay: true
								}";
							}
							else
							{
								$dynamicCalendar .= "{
								title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
								bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
								status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
								clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
								clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
								start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
								end: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
								url:'#EditBooking',
								allDay: true
								},";
							}	
						}
						else 
						{
							if($start == count($allBookings) -1)
							{
								$dynamicCalendar .= "{
								title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
								bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
								status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
								clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
								clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
								start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
								end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
								url:'#EditBooking',
								allDay: false
								}";	
							}
							else 
							{
								$dynamicCalendar .= "{
								title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
								bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
								status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
								clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
								clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
								start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
								end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
								url:'#EditBooking',
								allDay: false
								},";
							}	
						}
					}
					else
					{
						if($ServiceType == 1)
						{
							$bookingDate = date("Y-m-d", strtotime($allBookings[$start]->bookingDate));
							$bdate = (explode("-",$bookingDate));
							if($start == count($allBookings) -1)
							{
								$dynamicCalendar .= "{
								title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
								bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
								status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
								clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
								clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
								start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
								end: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
								url:'#EditBooking',
								allDay: true				
								}";
							}
							else 
							{
								$dynamicCalendar .= "{
								title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
								bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
								status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
								clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
								clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
								start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
								end: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
								url:'#EditBooking',
								allDay: true
								},";
							}	
						}
						else
						{
							$bookingDate = date("Y-m-d", strtotime($allBookings[$start]->BookingDate));
							$bdate = (explode("-",$bookingDate));				
							$getHours = floor(($allBookings[$start]->TimeSlot)/60);
							$getEndHours = floor(($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime))/60;
							if($getHours%60!=0)
							{
								$getMins = ($allBookings[$start]->TimeSlot) % 60;
							}
							else 
							{
								$getMins = 0;
							}
							if($getEndHours%60!=0)
							{
								$getEndMins = ($allBookings[$start]->TimeSlot + $allBookings[$start]->ServiceTotalTime) % 60;
							}
							else 
							{
								$getEndMins = 0;
							}
							if($start == count($allBookings) -1)
							{
								$dynamicCalendar .= "{
								title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
								bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
								status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
								clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
								clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
								start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
								end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
								url:'#EditBooking',
								allDay: false
								}";
							}
							else 
							{
								$dynamicCalendar .= "{
								title: ".'"'.$allBookings[$start]->ServiceName.'"'.",
								bookingId:".'"'.$allBookings[$start]->BookingId.'"'.",
								status:".'"'.$allBookings[$start]->BookingStatus.'"'.",
								clientName:".'"'.$allBookings[$start]->ClientName.'"'.",
								clientMobile:".'"'.$allBookings[$start]->CustomerMobile.'"'.",
								start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
								end: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getEndHours, $getEndMins),
								url:'#EditBooking',
								allDay: false
								},";
							}
						}
					}
				}
				$dynamicCalendar .= "]});jQuery('.popover-test').popover({
				placement: 'left'
				});";
				$dynamicCalendar .= "</script><style type=\"text/css\">";
				for($start = 0; $start<count($allBookings);$start++)
				{
					$dynamicCalendar .=".fc-event".$allBookings[$start]->BookingId . "{border: 1px solid ". $allBookings[$start]->ServiceColorCode."; color: white !important; display: block; font-size: 11px;
					background: ". $allBookings[$start]->ServiceColorCode." url(../images/elements/ui/progress_overlay.png);
					background: url(".$url."/images/elements/ui/progress_overlay.png), -moz-linear-gradient(top, ". $allBookings[$start]->ServiceColorCode." 0%, ". $allBookings[$start]->ServiceColorCode." 100%);
					background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-gradient(linear, left top, left bottom, color-stop(0%,". $allBookings[$start]->ServiceColorCode."), color-stop(100%,". $allBookings[$start]->ServiceColorCode."));
					background: url(".$url."/images/elements/ui/progress_overlay.png), -webkit-linear-gradient(top,  ". $allBookings[$start]->ServiceColorCode." 0%,". $allBookings[$start]->ServiceColorCode." 100%);
					background: url(".$url."/images/elements/ui/progress_overlay.png), -o-linear-gradient(top, ". $allBookings[$start]->ServiceColorCode." 0%,". $allBookings[$start]->ServiceColorCode." 100%);
					background: url(".$url."/images/elements/ui/progress_overlay.png), -ms-linear-gradient(top, ". $allBookings[$start]->ServiceColorCode." 0%,". $allBookings[$start]->ServiceColorCode." 100%);
					background: url(".$url."/images/elements/ui/progress_overlay.png), linear-gradient(to bottom, ". $allBookings[$start]->ServiceColorCode." 0%,". $allBookings[$start]->ServiceColorCode." 100%);
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='". $allBookings[$start]->ServiceColorCode."', endColorstr='". $allBookings[$start]->ServiceColorCode."',GradientType=0 );
					-moz-border-radius: 2px;
					-webkit-border-radius: 2px;
					border-radius: 2px;
					box-sizing: border-box;
					-ms-box-sizing: border-box;
					-webkit-box-sizing: border-box;
					-moz-box-sizing: border-box;
					box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
					-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;	
					-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
					}"; 
				}
				echo $dynamicCalendar . "</style>";
				die();
		}
	}
}
?>