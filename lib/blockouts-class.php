<?php
if (!current_user_can('edit_posts') && ! current_user_can('edit_pages') )
{
	return;
}
else 
{
	if($_REQUEST['param'] == 'insertBlockOutsDay')
	{
		$serviceId = intval($_REQUEST['uxDdlBlockOutServices']);
		$BlockOutsIntervals  = intval($_REQUEST['uxBlockOutsIntervals']);
		$BlockOutsRepeatDay  = intval($_REQUEST['uxBlockOutsRepeatDay']);
		$BlockOutsDayStartsOn  = esc_attr($_REQUEST['uxBlockOutsDayStartsOn']);
		$FullDayBlockOutsDay = intval($_REQUEST['uxFullDayBlockOutsDay']);
		$BlockOutsStartTimeHours = intval($_REQUEST['uxBlockOutsStartTimeHours']);
		$BlockOutsStartTimeMins = intval($_REQUEST['uxBlockOutsStartTimeMins']);
		$BlockOutsStartTimeAMPM = esc_attr($_REQUEST['uxBlockOutsStartTimeAMPM']);
		$BlockOutsEndTimeHours = intval($_REQUEST['uxBlockOutsEndTimeHours']);
		$BlockOutsEndTimeMins = intval($_REQUEST['uxBlockOutsEndTimeMins']);
		$BlockOutsEndTimeAMPM = esc_attr($_REQUEST['uxBlockOutsEndTimeAMPM']);
		$BlockOutsDayNever = intval($_REQUEST['uxBlockOutsDayNever']);
		$BlockOutsDayEndsOn = esc_attr($_REQUEST['uxBlockOutsDayEndsOn']);
		if($FullDayBlockOutsDay == 0)
		{
			if($BlockOutsStartTimeAMPM == "PM")
			{
				if($BlockOutsStartTimeHours <= 11)
				{
					$DayStartTimeHour = $BlockOutsStartTimeHours + 12;
				}
				else if($BlockOutsStartTimeHours == 12)
				{
					$DayStartTimeHour = 12;
				}
			}
			else if($BlockOutsStartTimeAMPM == "AM")
			{
				if($BlockOutsStartTimeHours == 12)
				{
					$DayStartTimeHour = 0;
				}
				else 
				{
					$DayStartTimeHour = $BlockOutsStartTimeHours;
				}
			}
			else 
			{
				$DayStartTimeHour = $BlockOutsStartTimeHours;
			}
			$BlockOutsTotalStartTime = ($DayStartTimeHour * 60) + $BlockOutsStartTimeMins;
			if($BlockOutsEndTimeAMPM == "PM")
			{
				if($BlockOutsEndTimeHours <= 11)
				{
					$DayEndTimeHour = $BlockOutsEndTimeHours + 12;
				}
				else if($BlockOutsEndTimeHours == 12)
				{
					$DayEndTimeHour = 12;
				}
			}
			else if($BlockOutsEndTimeAMPM == "AM")
			{
				if($BlockOutsEndTimeHours == 12)
				{
					$DayEndTimeHour = 0;
				}
				else 
				{
					$DayEndTimeHour = $BlockOutsEndTimeHours;
				}
			}
			else 
			{
				$DayEndTimeHour = $BlockOutsEndTimeHours;
			}
			$BlockOutsTotalEndTime = ($DayEndTimeHour * 60) + $BlockOutsEndTimeMins;
		}
		else
		{
			$BlockOutsTotalStartTime = 0;
			$BlockOutsTotalEndTime = 0;
		}
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".block_outs()."(ServiceId,Repeats,RepeatEvery,StartDate,FullDayBlockOuts,StartTime,EndTime,EndDate )
				VALUES( %d, %d, %d, %s, %d, %d, %d, %s)",
				$serviceId,
				$BlockOutsIntervals,
				$BlockOutsRepeatDay,
				$BlockOutsDayStartsOn,
				$FullDayBlockOutsDay,
				$BlockOutsTotalStartTime,
				$BlockOutsTotalEndTime,
				$BlockOutsDayEndsOn
			)
		);
		die();
	}
	else if($_REQUEST['param'] == 'insertBlockOutsWeek')
	{
		$serviceId = intval($_REQUEST['uxDdlBlockOutServices']);	
		$BlockOutsIntervals  = intval($_REQUEST['uxBlockOutsIntervals']);
		$BlockOutsRepeatWeeks  = intval($_REQUEST['uxBlockOutsRepeatWeeks']);
		$BlockOutsWeekStartsOn  = esc_attr($_REQUEST['uxBlockOutsWeekStartsOn']);
		$FullDayBlockOutWeek = intval($_REQUEST['uxFullDayBlockOutWeek']);
		$BlockOutsWeekStartTimeHours = intval($_REQUEST['uxBlockOutsWeekStartTimeHours']);
		$BlockOutsWeekStartTimeMins = intval($_REQUEST['uxBlockOutsWeekStartTimeMins']);
		$BlockOutsWeekStartTimeAMPM = esc_attr($_REQUEST['uxBlockOutsWeekStartTimeAMPM']);
		$BlockOutsWeekEndTimeHours = intval($_REQUEST['uxBlockOutsWeekEndTimeHours']);
		$BlockOutsWeekEndTimeMins = intval($_REQUEST['uxBlockOutsWeekEndTimeMins']);
		$BlockOutsWeekEndTimeAMPM = esc_attr($_REQUEST['uxBlockOutsWeekEndTimeAMPM']);
		$BlockOutsWeekNever = intval($_REQUEST['uxBlockOutsWeekNever']);
		$BlockOutsWeekEndsOn = esc_attr($_REQUEST['uxBlockOutsWeekEndsOn']);
		$RepeatDays = esc_attr($_REQUEST['repeatDays']);
		$RepeatDay = explode(',', $RepeatDays);
		$RepeatedDays = "";
		for($Repeats = 0; $Repeats < count($RepeatDay); $Repeats++)
		{
			if($Repeats < count($RepeatDay) - 2)
			{
				$RepeatedDays .= $RepeatDay[$Repeats]. ","; 
			}
			else 
			{
				$RepeatedDays .= $RepeatDay[$Repeats];
			}
		}
		if($FullDayBlockOutWeek == 0)
		{
			if($BlockOutsWeekStartTimeAMPM == "PM")
			{
				if($BlockOutsWeekStartTimeHours <= 11)
				{
					$WeekStartTimeHour = $BlockOutsWeekStartTimeHours + 12;
				}
				else if($BlockOutsWeekStartTimeHours == 12)
				{
					$WeekStartTimeHour = 12;
				}
			}
			else if($BlockOutsWeekStartTimeAMPM == "AM")
			{
				if($BlockOutsWeekStartTimeHours == 12)
				{
					$WeekStartTimeHour = 0;
				}
				else 
				{
					$WeekStartTimeHour = $BlockOutsWeekStartTimeHours;
				}
			}
			else 
			{
				$WeekStartTimeHour = $BlockOutsWeekStartTimeHours;
			}
			$BlockOutsWeekTotalStartTime = ($WeekStartTimeHour * 60) + $BlockOutsWeekStartTimeMins;
			if($BlockOutsWeekEndTimeAMPM == "PM")
			{
				if($BlockOutsWeekEndTimeHours <= 11)
				{
					$WeekEndTimeHour = $BlockOutsWeekEndTimeHours + 12;
				}
				else if($BlockOutsWeekEndTimeHours == 12)
				{
					$WeekEndTimeHour = 12;
				}
			}
			else if($BlockOutsWeekEndTimeHours == "AM")
			{
				if($BlockOutsWeekEndTimeHours == 12)
				{
					$WeekEndTimeHour = 0;
				}
				else 
				{
					$WeekEndTimeHour = $BlockOutsWeekEndTimeHours;
				}
			}
			else 
			{
				$WeekEndTimeHour = $BlockOutsWeekEndTimeHours;
			}
			$BlockOutsWeekTotalEndTime = ($WeekEndTimeHour * 60) + $BlockOutsWeekEndTimeMins;
		}
		else 
		{
			$BlockOutsWeekTotalStartTime = 0;
			$BlockOutsWeekTotalEndTime = 0;
		}
		$wpdb->query
		(
			$wpdb->prepare
			(
				"INSERT INTO ".block_outs()."(ServiceId,Repeats,RepeatEvery,StartDate,FullDayBlockOuts,StartTime,EndTime,EndDate,RepeatDays ) 
				VALUES( %d, %d, %d, %s, %d, %d, %d, %s, %s)",
				$serviceId,
				$BlockOutsIntervals,
				$BlockOutsRepeatWeeks,
				$BlockOutsWeekStartsOn,
				$FullDayBlockOutWeek,
				$BlockOutsWeekTotalStartTime,
				$BlockOutsWeekTotalEndTime,
				$BlockOutsWeekEndsOn,
				$RepeatedDays
			)
		);
		die();
	}
	else if($_REQUEST['param'] == 'deleteBlockOut')
	{
		$repeatId = intval($_REQUEST['RepeatId']);
		$wpdb->query
		(
			$wpdb->prepare
			(
				"DELETE FROM ".block_outs()." WHERE RepeatId = %d",
				$repeatId
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
}
?>