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
		
		if($_REQUEST['param'] == 'deleteService')
		{
			$serviceId = intval($_REQUEST['ServiceId']);
			$allocate = $wpdb->get_var 
			(
				$wpdb->prepare
				(
					"SELECT count(BookingId) FROM ". bookingTable() . " WHERE ServiceId = %d",
					$serviceId
				)
			);
			if($allocate > 0)
			{
				echo $allocte = "allocated";
			}
			else 
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM ".servicesTable()." WHERE ServiceId = %d",
						$serviceId
					)
				);
			}
			die();
		}
		
		else if($_REQUEST['param'] == "editService")
		{
			$serviceId = intval($_REQUEST['ServiceId']);
			$uxServiceEdit = $wpdb->get_row
			(
				$wpdb->prepare
				(
					'SELECT ServiceName,ServiceCost,ServiceTotalTime,ServiceMaxBookings,Type,ServiceColorCode,ServiceFullDay,
					ServiceStartTime,ServiceEndTime,MaxDays,CostType FROM ' . servicesTable() . ' where ServiceId = %d',
					$serviceId
				)
			); 
			$CheckBooking = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(ServiceId) FROM ' . bookingTable() . ' where ServiceId = %d',
					$serviceId
				)
			);
			$CurrencyIcon = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT CurrencySymbol FROM ' . currenciesTable() . ' where CurrencyUsed = %d',
					"1"
				)
			);
			?>
			<div class="body">
				<div class="block well" style="margin:10px;">
					<div class="box">
						<div class="content">
							<div class="row">
								<label>
									<?php _e( "Service Color :", booking_xpress ); ?>
								</label>
								<div class="right">
									<input type="text" value="<?php echo $uxServiceEdit->ServiceColorCode; ?>"  id="uxEditServiceColorCode" name="uxEditServiceColorCode" />	
								</div>
							</div>
						<div class="row">
							<label>
								<?php _e( "Service Name :", booking_xpress ); ?>
							</label>
							<div class="right">
								<input type="text" class="required span12" name="uxEditServiceName" id="uxEditServiceName" value="<?php echo $uxServiceEdit->ServiceName; ?>"/>
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e( "Cost", booking_xpress ); ?><?php echo " (".$CurrencyIcon .") :";?>
							</label>
							<div class="right">
								<input type="text" class="required span12" name="uxEditServiceCost" id="uxEditServiceCost" value="<?php echo $uxServiceEdit->ServiceCost; ?>"/>
							</div>
						</div>
						<div class="row">
						<label style="top:10px">
							<?php _e( "Service Type :", booking_xpress );?>
						</label>
						<?php
						if($uxServiceEdit->Type == 0)
						{
						?>
							<div class="right">
								<input type="radio" id="uxEditServiceTypeEnable" name="uxEditServiceType" class="style" value="0" onclick="singleBookingType();" checked="checked">&nbsp;&nbsp;<?php _e( "Single Booking", booking_xpress );?>&nbsp;
								<input type="radio" id="uxEditServiceTypeDisable" name="uxEditServiceType" onclick="groupBookingType();" class="style" value="1">&nbsp;&nbsp;<?php _e( "Group Bookings", booking_xpress );?>
							</div>
						</div>
						<?php
						}
						else
						{
						?>
							<div class="right">
								<input type="radio" id="uxEditServiceTypeEnable" name="uxEditServiceType" class="style" value="0" onclick="singleBookingType();">&nbsp;&nbsp;<?php _e( "Single Booking", booking_xpress );?>&nbsp;
								<input type="radio" id="uxEditServiceTypeDisable" name="uxEditServiceType" onclick="groupBookingType();" class="style" value="1" checked="checked">&nbsp;&nbsp;<?php _e( "Group Bookings", booking_xpress );?>
							</div>
						</div>
						<?php
						}
						?>
						<?php
						if($uxServiceEdit->Type == 0)
						{
						?>
							<div class="row" id="editMaxBooking" style="display: none;">
								<label>
									<?php _e( "Max Bookings<br/>(Each Slot) :", booking_xpress ); ?>
								</label>
								<div class="right">
									<input type="text" class="required span12" name="uxEditMaxBookings" id="uxEditMaxBookings" value="<?php echo $uxServiceEdit->ServiceMaxBookings; ?>"/>
								</div>
							</div>
						<?php
						}
						else
						{
						?>
							<div class="row" id="editMaxBooking" style="display: block;">
								<label>
									<?php _e( "Max Bookings<br/>(Each Slot) :", booking_xpress ); ?>
								</label>
								<div class="right">
									<input type="text" class="required span12" name="uxEditMaxBookings" id="uxEditMaxBookings" value="<?php echo $uxServiceEdit->ServiceMaxBookings; ?>"/>
								</div>
							</div>
						<?php
						}
						?>
						<div class="row">
							<label style="top:10px">
								<?php _e( "Full Day Service :", booking_xpress ); ?>
							</label>
							<div class="right">
							<?php
							if($uxServiceEdit->ServiceFullDay == 1)
							{
							?>
								<input type="checkbox" value="1" checked="checked"  id="uxEditFullDayService" name="uxEditFullDayService" onclick="divEditControlsShowHide();" >
							<?php
							}
							else
							{
							?>
								<input type="checkbox" value="1" id="uxEditFullDayService" name="uxEditFullDayService" onclick="divEditControlsShowHide();" >
							<?php
							}
							?>
							</div>
						</div>
						<?php
						if($uxServiceEdit->ServiceFullDay == 0)
						{
						?>
							<div class="row" id="divEditMaxDays" style="display : none;">
								<label>
									<?php _e( "Allow Max. Days :", booking_xpress ); ?>
								</label>
								<div class="right">
								<?php
									$MaxDays = $uxServiceEdit->MaxDays;
								?>
									<select name="uxEditMaxDays" id="uxEditMaxDays" class="required" style="width:100px;">
										<option value="Unlimited"><?php _e( "Unlimited", booking_xpress ); ?></option>
										<?php
											for($days = 1; $days < 31; $days++)
											{
												if($days == $MaxDays)
												{
													echo "<option selected='selected' value=" . $days . " >" . $days . " </option>";
												}
												else
												{
												?>
													<option value="<?php echo $days; ?>"><?php echo $days; ?></option>
												<?php
												}
											}
											?>
									</select>
								</div>
							</div>
						<?php
						}
						else
						{
						?>
							<div class="row" id="divEditMaxDays" style="display : block;">
								<label>
									<?php _e( "Allow Max. Days :", booking_xpress ); ?>
								</label>
							<div class="right">
							<?php
								$MaxDays = $uxServiceEdit->MaxDays;
								?>
								<select name="uxEditMaxDays" id="uxEditMaxDays" class="required" style="width:100px;">
									<option value="Unlimited"><?php _e( "Unlimited", booking_xpress ); ?></option>
								<?php
								for($days = 1; $days < 31; $days++)
								{
									if($days == $MaxDays)
									{
										echo "<option selected='selected' value=" . $days . " >" . $days . " </option>";
									}
									else
									{
								?>
										<option value="<?php echo $days; ?>"><?php echo $days; ?></option>
								<?php
									}
								}
								?>
								</select>
							</div>
						</div>
						<?php
						}
						if($uxServiceEdit->ServiceFullDay == 0)
						{
						?>
							<div class="row" id="divEditCostType" style="display : none;">
								<label>
									<?php _e( "Cost Type :", booking_xpress ); ?>
								</label>
								<div class="right">
									<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="0" checked="checked">&nbsp;&nbsp;<?php _e( "Per day", booking_xpress );?>
									<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="1">&nbsp;&nbsp;<?php _e( "Fixed", booking_xpress );?>
								</div>
							</div>
						<?php
						}
						else
						{
						?>
							<div class="row" id="divEditCostType" style="display : block;">
								<label style="top:10px">
									
									<?php _e( "Cost Type :", booking_xpress ); ?>
								</label>
							<?php
							$CostType = $uxServiceEdit->CostType;
							if($CostType == 0)
							{
							?>
								<div class="right">
									<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="0" checked="checked">&nbsp;&nbsp;<?php _e( "Per Day", booking_xpress );?>&nbsp;
									<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="1">&nbsp;&nbsp;<?php _e( "Fixed", booking_xpress );?>
								</div>
							<?php
							}
							else
							{
							?>
								<div class="right">
									<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="0">&nbsp;&nbsp;<?php _e( "Per day", booking_xpress );?>&nbsp;
									<input type="radio" id="uxEditCostType" name="uxEditCostType" class="style" value="1" checked="checked">&nbsp;&nbsp;<?php _e( "Fixed", booking_xpress );?>
								</div>	
							<?php	
							}
								?>
							</div>
						<?php
						}
						if($uxServiceEdit->ServiceFullDay == 0)
						{
						?>
							<div class="row" id="divEditServiceTime" style="display:block">
								<label>
									<?php _e( "Service Time :", booking_xpress ); ?>
								</label>
								<?php
								$serviceTotalTime =  $uxServiceEdit->ServiceTotalTime;
								$getHours_bookings = floor(($serviceTotalTime)/60);
								$getTMins_bookings = ($serviceTotalTime) % 60;
								$hourFormat_bookings = $getHours_bookings . ":" . "00";
								$STT  = DATE("H", STRTOTIME($hourFormat_bookings));
								?>
								<div class="right">
									<select name="uxEditServiceHours" class="required" id="uxEditServiceHours" style="width:100px;" >
									<?php
									for ($hr = 0; $hr <= 23; $hr++)
									{
										if($hr == $STT)
										{
											if($hr < 10)
											{
												echo "<option selected='selected' value=0" . $hr . " >0" . $hr . " Hrs</option>";
											}
											else
											{
												echo "<option selected='selected' value=" . $hr . " >" . $hr . " Hrs</option>";
											}
										}
										else
										{
											if($hr < 10)
											{
												echo "<option value=" . $hr . " >0" . $hr . " Hrs</option>";
											}
											else
											{
												echo "<option value=" . $hr . " >" . $hr . " Hrs</option>";
											}
										}
									}
									?>
									</select>
									<select name="uxEditServiceMins" class="required" id="uxEditServiceMins" style="width:100px;" >
									<?php
										for ($min = 0; $min < 60; $min += 5)
										{
											if($min == $getTMins_bookings)
											{
												if($min < 10)
												{
													echo "<option selected='selected' value=" . $min . ">0" . $min . " Mins</option>";	
												}
												else
												{
													echo "<option selected='selected' value=" . $min . ">" . $min . " Mins</option>";
												}
											}
											else
											{
												if($min < 10)
												{
													echo "<option value=" . $min . ">0" . $min . " Mins</option>";	
												}
												else
												{
													echo "<option value=" . $min . ">" . $min . " Mins</option>";	
												}
											}
										}
									?>
									</select>
								</div>
							</div>
							<div class="row" id="divEditStartTime" style="display:block">
								<label>
									<?php _e( "Start Time :", booking_xpress ); ?>
								</label>
								<?php
								$timeFormats = $wpdb->get_var
								(
									$wpdb->prepare
									(
										"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
										'default_Time_Format'
									)
								);
								$serviceStTime =  $uxServiceEdit->ServiceStartTime;
								$getHours_bookings = floor(($serviceStTime)/60);
								$getMins_bookings = ($serviceStTime) % 60;
								$hourFormat_bookings = $getHours_bookings . ":" . "00";
								if($timeFormats == 0)
								{
									$Shr  = DATE("g", STRTOTIME($hourFormat_bookings));
									$Am = DATE("A", STRTOTIME($hourFormat_bookings));
								}
								else 
								{
									$Sthr  = DATE("H", STRTOTIME($hourFormat_bookings));
									$Am = DATE("A", STRTOTIME($hourFormat_bookings));
									if($Sthr > 12)
									{
										$Shr = $Sthr - 12;
									}
									else 
									{
										$Shr = $Sthr;
									}
								}
								?>
								<div class="right">
									<select name="uxEditStartTimeHours" class="required" id="uxEditStartTimeHours" style="width:50px;" >
								<?php
								for ($hr = 0; $hr <= 12; $hr++)
									{
										if($hr == $Shr)
										{
											if($hr < 10)
											{
												echo "<option selected='selected' value=" . $hr . " >0" . $hr . " </option>";
											}
											else
											{
												echo "<option selected='selected' value=" . $hr . " >" . $hr . " </option>";
											}
										}
										else
										{
											if($hr < 10)
											{
												echo "<option value=" . $hr . " >0" . $hr . " </option>";
											}
											else
											{
												echo "<option value=" . $hr . " >" . $hr . " </option>";
											}
										}
									}
								?>
									</select>
									<select name="uxEditStartTimeMins" class="required" id="uxEditStartTimeMins" style="width:50px;" >
									<?php
										for ($min = 0; $min < 60; $min += 5) 
										{
											if($min == $getMins_bookings)
											{
												if($min < 10)
												{
													echo "<option selected='selected' value=0" . $min . ">0" . $min . " </option>";
												}
												else
												{
													echo "<option selected='selected' value=" . $min . ">" . $min . " </option>";
												}
											}
											else
											{
												if($min < 10)
												{
													echo "<option value=" . $min . ">0" . $min . " </option>";
												}
												else
												{
													echo "<option value=" . $min . ">" . $min . " </option>";
												}
											}
										}
									?>
									</select>
									<select name="uxEditStartTimeAMPM" class="required" id="uxEditStartTimeAMPM" style="width:50px;" >
									<?php
									if($Am == "AM")
									{
										echo "<option selected='selected' value='AM'>AM</option>";
										echo "<option value='PM'>PM</option>";
									}
									else
									{
										echo "<option value='AM'>AM</option>";
										echo "<option selected='selected' value='PM'>PM</option>";
									}
									?>
									</select>
								</div>
							</div>
							<div class="row" id="divEditEndTime" style="display:block">
								<label>
									<?php _e( "End Time :", booking_xpress ); ?>
								</label>
								<?php
								$serviceEndTime =  $uxServiceEdit->ServiceEndTime;
								$getHours_bookings = floor(($serviceEndTime)/60);
								$getMins_bookings = ($serviceEndTime) % 60;
								$hourFormat_bookings = $getHours_bookings . ":" . "00";
								if($timeFormats == 0)
								{
									$Ehr  = DATE("g", STRTOTIME($hourFormat_bookings));
									$Am = DATE("A", STRTOTIME($hourFormat_bookings));
								}
								else
								{
									$Ethr  = DATE("H", STRTOTIME($hourFormat_bookings));
									if($Ethr > 12)
									{
										$Ehr = $Ethr - 12;
									}
									else 
									{
										$Ehr = $Ethr;
									}
									$Am = DATE("A", STRTOTIME($hourFormat_bookings));
								}
								?>
								<div class="right">
									<select name="uxEditEndTimeHours" class="required" id="uxEditEndTimeHours" style="width:50px;" >
								<?php
										for ($hr = 0; $hr <= 12; $hr++) 
										{
											if($hr == $Ehr)
											{
												if($hr < 10)
												{
													echo "<option selected='selected' value=0" . $hr . " >0" . $hr . " </option>";
												}
												else
												{
													echo "<option selected='selected' value=" . $hr . ">" . $hr . "</option>";
												}
											}
											else
											{
												if($hr < 10)
												{
													echo "<option value=" . $hr . " >0" . $hr . " </option>";
												}
												else
												{
													echo "<option value=" . $hr . ">" . $hr . "</option>";
												}
											}
										}
									?>
									</select>
									<select name="uxEditEndTimeMins" class="required" id="uxEditEndTimeMins" style="width:50px;" >
									<?php
									for ($min = 0; $min < 60; $min += 5)
									{
										if($min == $getMins_bookings)
										{
											if($min < 10)
											{
												echo "<option selected='selected' value=" . $min . ">0" . $min . " </option>";
											}
											else
											{
												echo "<option selected='selected' value=" . $min . ">" . $min . "</option>";
											}
										}
										else
										{
											if($min < 10)
											{
												echo "<option value=" . $min . ">0" . $min . " </option>";
											}
											else
											{
												echo "<option value=" . $min . ">" . $min . "</option>";
											}
										}
									}
									?>
									</select>
									<select name="uxEditEndTimeAMPM" class="required" id="uxEditEndTimeAMPM" style="width:50px;" >
									<?php
									if($Am == "AM")
									{
										echo "<option selected='selected' value='AM'>AM</option>";
										echo "<option value='PM'>PM</option>";
									}
									else
									{
										echo "<option value='AM'>AM</option>";
										echo "<option selected='selected' value='PM'>PM</option>";
									}
									?>
									</select>
								</div>
							</div>
						<?php
						}
						else
						{
						?>
							<div class="row" id="divEditServiceTime" style="display:none">
								<label>
									<?php _e( "Service Time :", booking_xpress ); ?>
								</label>
								<?php
								$serviceTotalTime =  $uxServiceEdit->ServiceTotalTime;
								$getHours_bookings = floor(($serviceTotalTime)/60);
								$getTMins_bookings = ($serviceTotalTime) % 60;
								$hourFormat_bookings = $getHours_bookings . ":" . "00";
								$STT  = DATE("H", STRTOTIME($hourFormat_bookings));
								?>
								<div class="right">
									<select name="uxEditServiceHours" class="required" id="uxEditServiceHours" style="width:100px;" >
									<?php
									for ($hr = 0; $hr <= 23; $hr++)
									{
										if($hr == $STT)
										{
											if($hr < 10)
											{
												echo "<option selected='selected' value=" . $hr . " >0" . $hr . " Hrs</option>";
											}
											else 
											{
												echo "<option selected='selected' value=" . $hr . " >" . $hr . " Hrs</option>";
											}
										}
										else
										{
											if($hr < 10)
											{
												echo "<option value=" . $hr . " >0" . $hr . " Hrs</option>";
											}
											else
											{
												echo "<option value=" . $hr . " >" . $hr . " Hrs</option>";
											}
										}
									}
									?>
									</select>
									<select name="uxEditServiceMins" class="required" id="uxEditServiceMins" style="width:100px;" >
									<?php
									for ($min = 0; $min < 60; $min += 5)
									{
										if($min == $getTMins_bookings)
										{
											if($min < 10)
											{
												echo "<option selected='selected' value=" . $min . ">0" . $min . " Mins</option>";	
											}
											else 
											{
												echo "<option selected='selected' value=" . $min . ">" . $min . " Mins</option>";	
											}	
										}
										else
										{
											if($min < 10)
											{
												echo "<option value=" . $min . ">0" . $min . " Mins</option>";	
											}
											else
											{
												echo "<option value=" . $min . ">" . $min . " Mins</option>";	
											}
										}
									}
									?>
									</select>
								</div>
							</div>
							<div class="row" id="divEditStartTime" style="display:none">
								<label>
									<?php _e( "Start Time :", booking_xpress ); ?>
								</label>
								<?php
								$timeFormats = $wpdb->get_var
								(
									$wpdb->prepare
									(
										"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
										'default_Time_Format'
									)
								);
								$serviceStTime =  $uxServiceEdit->ServiceStartTime;
								$getHours_bookings = floor(($serviceStTime)/60);
								$getMins_bookings = ($serviceStTime) % 60;
								$hourFormat_bookings = $getHours_bookings . ":" . "00";
								if($timeFormats == 0)
								{
									$Shr  = DATE("g", STRTOTIME($hourFormat_bookings));
									$Am = DATE("A", STRTOTIME($hourFormat_bookings));
								}
								else
								{
									$Shr  = DATE("H", STRTOTIME($hourFormat_bookings));
								}
								?>
								<div class="right">
									<select name="uxEditStartTimeHours" class="required" id="uxEditStartTimeHours" style="width:50px;" >
								<?php
									for ($hr = 0; $hr <= 12; $hr++)
									{
										if($hr == $Shr)
										{
											if($hr < 10)
											{
												echo "<option selected='selected' value=" . $hr . " >0" . $hr . " </option>";
											}
											else
											{
												echo "<option selected='selected' value=" . $hr . " >" . $hr . " </option>";
											}
										}
										else
										{
											if($hr < 10)
											{
												echo "<option value=" . $hr . " >0" . $hr . " </option>";
											}
											else
											{
												echo "<option value=" . $hr . " >" . $hr . " </option>";
											}
										}
									}
								?>
									</select>
									<select name="uxEditStartTimeMins" class="required" id="uxEditStartTimeMins" style="width:50px;" >
								<?php
									for ($min = 0; $min < 60; $min += 5)
									{
										if($min == $getMins_bookings)
										{
											if($min < 10)
											{
												echo "<option selected='selected' value=" . $min . ">0" . $min . " </option>";
											}
											else
											{
												echo "<option selected='selected' value=" . $min . ">" . $min . " </option>";
											}
										}
										else
										{
											if($min < 10)
											{
												echo "<option value=" . $min . ">0" . $min . " </option>";
											}
											else
											{
												echo "<option value=" . $min . ">" . $min . " </option>";
											}
										}
									}
								?>
									</select>
									<select name="uxEditStartTimeAMPM" class="required" id="uxEditStartTimeAMPM" style="width:50px;" >
								<?php
									if($Am == "AM")
									{
										echo "<option selected='selected' value='AM'>AM</option>";
										echo "<option value='PM'>PM</option>";
									}
									else
									{
										echo "<option value='AM'>AM</option>";
										echo "<option selected='selected' value='PM'>PM</option>";
									}	
								?>
									</select>
								</div>
							</div>
							<div class="row" id="divEditEndTime" style="display:none">
								<label>
									<?php _e( "End Time :", booking_xpress ); ?>
								</label>
								<?php
								$serviceEndTime =  $uxServiceEdit->ServiceEndTime;
								$getHours_bookings = floor(($serviceEndTime)/60);
								$getMins_bookings = ($serviceEndTime) % 60;
								$hourFormat_bookings = $getHours_bookings . ":" . "00";
								if($timeFormats == 0)
								{
									$Ehr  = DATE("g", STRTOTIME($hourFormat_bookings));
									$Am = DATE("A", STRTOTIME($hourFormat_bookings));
								}
								else
								{
									$Ehr  = DATE("H", STRTOTIME($hourFormat_bookings));
									$Am = DATE("A", STRTOTIME($hourFormat_bookings));
								}
							?>
								<div class="right">
									<select name="uxEditEndTimeHours" class="required" id="uxEditEndTimeHours" style="width:50px;" >
								<?php
									for ($hr = 0; $hr <= 12; $hr++)
									{
										if($hr == $Ehr)
										{
											if($hr < 10)
											{
												echo "<option selected='selected' value=" . $hr . " >0" . $hr . " </option>";
											}
											else
											{
												echo "<option selected='selected' value=" . $hr . ">" . $hr . "</option>";
											}
										}
										else
										{
											if($hr < 10)
											{
												echo "<option value=" . $hr . " >0" . $hr . " </option>";
											}
											else
											{
												echo "<option value=" . $hr . ">" . $hr . "</option>";
											}
										}
									}
								?>
									</select>
									<select name="uxEditEndTimeMins" class="required" id="uxEditEndTimeMins" style="width:50px;" >
								<?php
									for ($min = 0; $min < 60; $min += 5)
									{
										if($min == $getMins_bookings)
										{
											if($min < 10)
											{
												echo "<option selected='selected' value=" . $min . ">0" . $min . " </option>";
											}
											else
											{
												echo "<option selected='selected' value=" . $min . ">" . $min . "</option>";
											}
										}
										else
										{
											if($min < 10)
											{
												echo "<option value=" . $min . ">0" . $min . " </option>";
											}
											else
											{
												echo "<option value=" . $min . ">" . $min . "</option>";
											}
										}
									}
							?>
								</select>
								<select name="uxEditEndTimeAMPM" class="required" id="uxEditEndTimeAMPM" style="width:50px;" >
							<?php
								if($Am == "AM")
								{
									echo "<option selected='selected' value='AM'>AM</option>";
									echo "<option value='PM'>PM</option>";
								}
								else
								{
									echo "<option value='AM'>AM</option>";
										echo "<option selected='selected' value='PM'>PM</option>";
								}
							?>
								</select>
							</div>
						</div>
					<?php
					}
					?>	
				</div>
			</div>
			<input type="hidden" id="hiddenServiceId" name="hiddenServiceId" value="<?php echo $serviceId; ?>" />
			<script type="text/javascript">
				jQuery('.cw-color-picker').each(function()
				{
					var $this = jQuery(this),
					id = $this.attr('rel');
					$this.farbtastic('#' + id);
				});
				jQuery('#uxEditServiceCost').on('keypress', function(evt) 
				{
					var charCode = (evt.which) ? evt.which : event.keyCode;
					return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
				});
				jQuery('#uxEditMaxBookings').on('keypress', function(evt) 
				{
					var charCode = (evt.which) ? evt.which : event.keyCode;
					return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
				});
			</script>
			<?php
			die();
		}
		else if($_REQUEST['param'] == "updateServiceTable")
		{
			$ServiceId = intval($_REQUEST['ServiceId']);
			$uxEditServiceName = esc_attr($_REQUEST['uxEditServiceName']);
			$uxEditServiceCost = doubleval($_REQUEST['uxEditServiceCost']);
			$uxEditMaxBookings = intval($_REQUEST['uxEditMaxBookings']);
			$uxEditServiceType = intval($_REQUEST['uxEditServiceType']);
			$uxEditServiceColorCode = esc_attr($_REQUEST['uxEditServiceColorCode']);
			$uxEditServiceHours = intval($_REQUEST['uxEditServiceHours']);
			$uxEditServiceMins = intval($_REQUEST['uxEditServiceMins']);
			$servTotalTime = $uxEditServiceHours * 60 + $uxEditServiceMins;
			$uxEditStartTimeHours = intval($_REQUEST['uxEditStartTimeHours']);
			$uxEditStartTimeMins = intval($_REQUEST['uxEditStartTimeMins']);
			$uxEditStartTimeAMPM = esc_attr($_REQUEST['uxEditStartTimeAMPM']);
			$uxEditEndTimeHours = intval($_REQUEST['uxEditEndTimeHours']);
			$uxEditEndTimeMins= intval($_REQUEST['uxEditEndTimeMins']);
			$uxEditEndTimeAMPM = esc_attr($_REQUEST['uxEditEndTimeAMPM']);
			$uxEditMaxDays = esc_attr($_REQUEST['uxEditMaxDays']);
			$uxEditCostType = intval($_REQUEST['uxEditCostType']);
			
			if(isset($_REQUEST['uxEditFullDayService']))
			{
				$uxEditFullDay = $_REQUEST['uxEditFullDayService'];
			}
			else
			{
				$uxEditFullDay = "0";
			}
			if($uxEditStartTimeAMPM == "PM")
			{
				if($uxEditStartTimeHours <= 11)
				{
					$uxEditStartTimeHour = $uxEditStartTimeHours + 12;
				}
				else if($uxEditStartTimeHours == 12)
				{
					$uxEditStartTimeHour = 12;
				}
			}
			else if($uxEditStartTimeAMPM == "AM")
			{
				if($uxEditStartTimeHours == 12)
				{
					$uxEditStartTimeHour = 0;
				}
				else
				{
					$uxEditStartTimeHour = $uxEditStartTimeHours;
				}
			}
			else
			{
				$uxEditStartTimeHour = $uxEditStartTimeHours;
			}
			
			if($uxEditEndTimeAMPM == "PM")
			{
				if($uxEditEndTimeHours <= 11)
				{
					$uxEditEndTimeHour = $uxEditEndTimeHours + 12;
				}
				else if($uxEditEndTimeHours == 12)
				{
					$uxEditEndTimeHour = 12;
				}
			}
			else if($uxEditEndTimeAMPM == "AM")
			{
				if($uxEditEndTimeHours == 12)
				{
					$uxEditEndTimeHour = 0;
				}
				else
				{
					$uxEditEndTimeHour = $uxEditEndTimeHours;
				}
			}
			else
			{
				$uxEditEndTimeHour = $uxEditEndTimeHours;
			}
			if($uxEditFullDay == "0")
			{
				$ServiceTotalStartTime = ($uxEditStartTimeHour * 60) + $uxEditStartTimeMins;
				$ServiceTotalEndTime = ($uxEditEndTimeHour * 60) + $uxEditEndTimeMins;
			}
			else
			{
				$ServiceTotalStartTime = 0;
				$ServiceTotalEndTime = 0;
				$servTotalTime = 0;
			}
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".servicesTable()." SET ServiceName = %s, ServiceCost = %f, ServiceMaxBookings = %d, Type = %d, ServiceColorCode = %s,
					ServiceFullDay = %d, ServiceTotalTime = %d, ServiceStartTime = %d, ServiceEndTime = %d, MaxDays = %s, CostType = %d WHERE ServiceId = %d",
					$uxEditServiceName,
					$uxEditServiceCost,
					$uxEditMaxBookings,
					$uxEditServiceType,
					$uxEditServiceColorCode,
					$uxEditFullDay,
					$servTotalTime,
					$ServiceTotalStartTime,
					$ServiceTotalEndTime,
					$uxEditMaxDays,
					$uxEditCostType,
					$ServiceId
				)
			);
			die();
		}
		else if($_REQUEST['param']== 'updateRecordsListings')
		 {
			$updateRecordsArray = $_POST['recordsArray'];
			 $listingCounter = 1;
			foreach ($updateRecordsArray as $recordIDValue)
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE ".servicesTable()." SET ServiceDisplayOrder  = %d WHERE ServiceId = %d",
						$listingCounter,
						$recordIDValue
					)
				);
				$listingCounter = $listingCounter + 1;	
			}
			die();
		}
	}
}
?>