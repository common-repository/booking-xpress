<div id="right">
	<div id="breadcrumbs">
		<ul>
			<li class="first"></li>
			<li>
				<a href="#">
					<?php _e( "BOOKINGS XPRESS", booking_xpress ); ?>
				</a>
			</li>				
			<li class="last">
				<a href="#">
					<?php _e( "SERVICES", booking_xpress ); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<div class="box">
			<div class="title">
				<?php _e("SERVICES", booking_xpress); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<table class="table table-striped" id="data-table">
 					<thead>
						<tr>
<!-- 							<th style="display:none;"><?php _e( "Service Display Order", booking_xpress ); ?></th> -->
							<th style="width:5%"></th>
							<th style="width:17%"><?php _e( "Service", booking_xpress ); ?></th>
							<th style="width:8%"><?php _e( "Cost", booking_xpress ); ?></th>
							<th style="width:17%"><?php _e( "Type", booking_xpress ); ?></th>
							<th style="width:8%"><?php _e( "FullDay", booking_xpress ); ?></th>
							<th style="width:12%"><?php _e( "Time", booking_xpress ); ?></th>
							<th style="width:12%"><?php _e( "Business Hours", booking_xpress ); ?></th>
							<th style="width:8%"></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$service = $wpdb->get_results
							(
								$wpdb->prepare
								(
									'SELECT '.servicesTable().'.ServiceId, '.servicesTable().'.ServiceName, ' . servicesTable() . '.ServiceDisplayOrder,'.servicesTable().'.ServiceCost,
									'.servicesTable().'.ServiceFullDay,'.servicesTable().'.ServiceMaxBookings, '.servicesTable().'.Type,'.servicesTable().'.ServiceStartTime,'.servicesTable().'.ServiceEndTime,
									'.servicesTable().'.ServiceTotalTime,'.servicesTable().'.ServiceColorCode FROM '.servicesTable().'  ORDER BY ' . servicesTable() . '.ServiceDisplayOrder ASC',''
								)
							);
							$costIcon = $wpdb->get_var
							(
								$wpdb->prepare	
								(
									"SELECT CurrencySymbol FROM ".currenciesTable()." where CurrencyUsed = %d",
									"1"
								)
							);
							for($flag=0; $flag < count($service); $flag++)
							{
								$serviceColor = $service[$flag]->ServiceColorCode;
								$hrs = floor(($service[$flag] -> ServiceTotalTime) / 60);
								$mins = ($service[$flag] -> ServiceTotalTime) % 60;
							?>
								<tr id="recordsArray_<?php echo $service[$flag] -> ServiceId ; ?>">
								<?php
									$serviceColorCode = "<div style=\"width:40px;height:15px;cursor:default;background-color:$serviceColor;color:$serviceColor\">";
								?>
								<!--<td style="display: none;"><?php echo $service[$flag] -> ServiceDisplayOrder;?></td> -->
									<td><?php echo $serviceColorCode;?></td>
									<td><?php echo $service[$flag] -> ServiceName;?></td>
									<td><?php echo ($costIcon).$service[$flag] -> ServiceCost;?></td>
									<td><?php 
										if($service[$flag]->Type == 0)
										{
											_e( "Single Booking", booking_xpress );
										}
										else 
										{
											_e( "Group Bookings", booking_xpress );?> <?php echo "(". $service[$flag] -> ServiceMaxBookings .")";
										}
									?>
									</td>
									<?php
									if($service[$flag] -> ServiceFullDay == 1)
									{
										$fullday = "Yes";
									}
									else
									{
										$fullday = "No";
									}
									?>
									<td><?php _e( $fullday, booking_xpress );?></td>
									<?php
									if($service[$flag] -> ServiceFullDay == 1)
									{
									?>
									<td>-</td>
									<?php
									}
									else
									{
									?>
									<td><?php
										if($hrs == 0)
										{
											echo $mins ." Mins";
										}
										else if($mins == 0)
										{
											echo $hrs ." Hrs";
										}
										else
										{
											echo $hrs ." Hrs ";
											echo $mins ." Mins";
										}
									?>
									</td>
									<?php
									}		
									if($service[$flag] -> ServiceFullDay == 1)
									{
									?>
									<td>-</td>
									<?php
									}
									else
									{
									?>
										<td>
									<?php
										$timeFormats = $wpdb->get_var
										(
											$wpdb->prepare
											(
												"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." WHERE GeneralSettingsKey = %s",
												'default_Time_Format'
											)
										);
										$getHours = floor($service[$flag] -> ServiceStartTime / 60) ;
										$getMins = $service[$flag] -> ServiceStartTime % 60 ;
										$hourFormat = $getHours . ":" . $getMins;
										if($timeFormats == 0)
										{
											$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($hourFormat));
										}
										else
										{
											$time_in_12_hour_format  = DATE("H:i", STRTOTIME($hourFormat));
										}
										$getHours = floor($service[$flag] -> ServiceEndTime / 60) ;
										$getMins = $service[$flag] -> ServiceEndTime % 60 ;
										$hourFormat = $getHours . ":" . $getMins;
										if($timeFormats == 0)
										{
											$time_in_12_hour_format_End  = DATE("g:i a", STRTOTIME($hourFormat));
										}
										else
										{
											$time_in_12_hour_format_End  = DATE("H:i", STRTOTIME($hourFormat));
										}
											echo $time_in_12_hour_format."-".$time_in_12_hour_format_End;
									?>
									</td>
								<?php
									}
								?>
									<td>&nbsp;&nbsp;<a class="icon-edit hovertip inline"  data-original-title="<?php _e("Edit Service?", booking_xpress ); ?>" data-placement="top" href="#editServicePopUp" onclick="editServices(<?php echo $service[$flag]->ServiceId;?>);"></a>&nbsp;&nbsp;<a class="icon-remove hovertip" data-original-title="<?php _e("Delete Service?", booking_xpress ); ?>" data-placement="top"  href="#" onclick="deleteServices(<?php echo $service[$flag]->ServiceId;?>)"></a></td>
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
<div id="footer">
	<div class="split">
		<?php _e( "&copy; 2013 Bookings-Xpress", booking_xpress ); ?>
	</div>
	<div class="split right">
		<?php _e( "Powered by ", booking_xpress ); ?>
			<a href="#" >
				<?php _e( "Bookings Xpress!", booking_xpress ); ?>
			</a>
	</div>
</div>
</div>
</div>
<div style="display:none">
	<div id="editServicePopUp">
		<form id="uxFrmEditServices" class="form-horizontal" method="post" action="">	
			<div class="message green" id="successMessageEditService" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Success! Service has been updated.", booking_xpress ); ?>
					</strong>
				</span>
			</div>
			<div class="message red" id="errorMessageEditServices" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Error! Max Bookings should be greater than 1", booking_xpress ); ?>
					</strong>
				</span>
			</div>
			<div class="message red" id="timeErrorEditMessage" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Error! Please Enter the Valid Time.", booking_xpress ); ?>
					</strong>
				</span>
			</div>
			<div class="message red" id="serviceTimeErrorEditMessage" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Error! Please Enter the valid Service Time.", booking_xpress ); ?>
					</strong>
				</span>
			</div>
			<div id="bindEditControls"></div>
			<div class="row" style="border-bottom:none;padding: 0px 10px 10px !important;">
				<label></label>
				<div class="right">
					<button type="submit" class="green" >
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
	jQuery("#Services").attr("class","current");
	jQuery(".inline").colorbox({inline:true, width:"700px"});
	var uri = "<?php echo $url; ?>";
	<?php
	$ResourcesEnable = $wpdb->get_var
	(
		$wpdb->prepare
		(
			"SELECT GeneralSettingsValue FROM ".generalSettingsTable()." where GeneralSettingsKey  = %s ",
			"resources-visible-enable"
		)
	);
	?>	
	oTable = jQuery('#data-table').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
		"oLanguage":
		{
			"sLengthMenu": "_MENU_"
		},
		"aaSorting": [[ 0, "asc" ]]
		
	});
	function deleteServices(ServiceId)
	{
		bootbox.confirm('<?php _e("Are you sure you want to delete this Service?", booking_xpress ); ?>', function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.post(ajaxurl, "ServiceId="+ServiceId+"&param=deleteService&action=servicesLibrary", function(data)
				{
					var checkAllocated = jQuery.trim(data);
					if(checkAllocated == "allocated")
					{
						bootbox.alert('<?php _e("This Service cannot be deleted until Booking is their.", booking_xpress ); ?>');
					}
					else
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
						jQuery.colorbox.resize();
					}	
				});
			}
		});
	}
	jQuery("#uxFrmEditServices").validate
	({
		rules:
		{
			uxEditServiceName: "required",
			uxEditServiceCost: 
			{
				required: true,
				number: true
			},
			uxEditMaxBookings: 
			{
				required: true,
				digits: true
			},
		},			
		highlight: function(label)
		{
			jQuery(label).closest('.control-group').addClass('errors');
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
			
			var ServiceId = jQuery('#hiddenServiceId').val();
			var uxEditMaxBookings = jQuery('#uxEditMaxBookings').val();
			var uxEditServiceType = jQuery('input:radio[name=uxEditServiceType]:checked').val();
			var uxEditStartTimeHours = jQuery('#uxEditStartTimeHours').val();
			var uxEditStartTimeMins = jQuery('#uxEditStartTimeMins').val();
			var uxEditStartTimeAMPM = jQuery('#uxEditStartTimeAMPM').val();
			var uxEditEndTimeHours = jQuery('#uxEditEndTimeHours').val();
			var uxEditEndTimeMins = jQuery('#uxEditEndTimeMins').val();
			var uxEditEndTimeAMPM = jQuery('#uxEditEndTimeAMPM').val();
			var uxEditFullDay = jQuery("#uxEditFullDayService").prop("checked") == true ? 1 : 0;
			var uxEditServiceHours = jQuery('#uxEditServiceHours').val();
			var uxEditServiceMins = jQuery('#uxEditServiceMins').val();
			var uxEditMaxDays = jQuery('#uxEditMaxDays').val();
			var uxEditCostType = jQuery('input:radio[name=uxEditCostType]:checked').val();
			var uxEditServiceHours = jQuery('#uxEditServiceHours').val();
			var uxEditServiceMins = jQuery('#uxEditServiceMins').val();
			if(uxEditStartTimeAMPM == "PM")
			{
				if(uxEditStartTimeHours <= 11)
				{
					 var uxEditStartTimeHour = parseInt(uxEditStartTimeHours) + 12;
				}
				else if(uxEditStartTimeHours == 12)
				{
					uxEditStartTimeHour = 12;
				}
			}
			else if(uxEditStartTimeAMPM == "AM")
			{
				if(uxEditStartTimeHours == 12)
				{
					uxEditStartTimeHour = 0;
				}
				else 
				{
					uxEditStartTimeHour = uxEditStartTimeHours;
				}
			}
			if(uxEditEndTimeAMPM == "PM")
			{
				if(uxEditEndTimeHours <= 11)
				{
					var uxEditEndTimeHour = parseInt(uxEditEndTimeHours) + 12;
				}
				else if(uxEditEndTimeHours == 12)
				{
					var uxEditEndTimeHour = 12;
				}
			}
			else if(uxEditEndTimeAMPM == "AM")
			{
				if(uxEditEndTimeHours == 12)
				{
					var uxEditEndTimeHour = 0;
				}
				else 
				{
					var uxEditEndTimeHour = uxEditEndTimeHours;
				}
			}
			var uxEditTotalStartTime = parseInt(uxEditStartTimeHour * 60) + parseInt(uxEditStartTimeMins);
			var uxEditTotalEndTime = parseInt(uxEditEndTimeHour * 60) + parseInt(uxEditEndTimeMins);
			var editServiceTime = (parseInt(uxEditServiceHours) * 60) + parseInt(uxEditServiceMins);
			if(uxEditFullDay == true)
			{
				if(uxEditServiceType == 1 && uxEditMaxBookings > 1)
				{
					jQuery.post(ajaxurl, jQuery(form).serialize() + "&ServiceId="+ServiceId+"&param=updateServiceTable&action=servicesLibrary", function(data)
					{
						jQuery('#timeErrorEditMessage').css('display','none');
						jQuery('#errorMessageEditServices').css('display','none');
						jQuery('#serviceTimeErrorEditMessage').css('display','none');
						jQuery('#successMessageEditService').css('display','block');
						jQuery.colorbox.resize();
						setTimeout(function() 
						{
							jQuery('#successMessageEditService').css('display','none');
							jQuery.colorbox.resize();
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
							}, 2000);
					});
				}
				else if(uxEditServiceType == 0)
				{
					jQuery.post(ajaxurl, jQuery(form).serialize() + "&ServiceId="+ServiceId+"&param=updateServiceTable&action=servicesLibrary", function(data)
					{
						jQuery('#timeErrorEditMessage').css('display','none');
						jQuery('#errorMessageEditServices').css('display','none');
						jQuery('#serviceTimeErrorEditMessage').css('display','none');
						jQuery('#successMessageEditService').css('display','block');
						jQuery.colorbox.resize();
						setTimeout(function() 
						{
							jQuery('#successMessageEditService').css('display','none');
							jQuery.colorbox.resize();
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
						}, 2000);
					});
				}
				else
				{
					jQuery('#timeErrorEditMessage').css('display','none');
					jQuery('#serviceTimeErrorEditMessage').css('display','none');
					jQuery('#errorMessageEditServices').css('display','block');
					jQuery.colorbox.resize();
				}
			}
			else if(uxEditServiceType == 1 && uxEditMaxBookings > 1)
			{
				if(editServiceTime == 0)
				{
					jQuery('#errorMessageEditServices').css('display','none');
					jQuery('#timeErrorEditMessage').css('display','none');
					jQuery('#serviceTimeErrorEditMessage').css('display','block');
					jQuery.colorbox.resize();
				}
				else if((uxEditTotalStartTime >= uxEditTotalEndTime) && (uxEditStartTimeAMPM == uxEditEndTimeAMPM) && (uxEditFullDay == 0))
				{
					jQuery('#errorMessageEditServices').css('display','none');
					jQuery('#serviceTimeErrorEditMessage').css('display','none');
					jQuery('#timeErrorEditMessage').css('display','block');
					jQuery.colorbox.resize();
				}
				else if((uxEditStartTimeAMPM == "PM") && (uxEditEndTimeAMPM == "AM") && (uxEditFullDay == 0))
				{
					jQuery('#errorMessageEditServices').css('display','none');
					jQuery('#serviceTimeErrorEditMessage').css('display','none');
					jQuery('#timeErrorEditMessage').css('display','block');
					jQuery.colorbox.resize();
				}
				else
				{
					jQuery.post(ajaxurl, jQuery(form).serialize() + "&ServiceId="+ServiceId+"&param=updateServiceTable&action=servicesLibrary", function(data)
					{
						jQuery('#timeErrorEditMessage').css('display','none');
						jQuery('#errorMessageEditServices').css('display','none');
						jQuery('#serviceTimeErrorEditMessage').css('display','none');
						jQuery('#successMessageEditService').css('display','block');
						jQuery.colorbox.resize();
						setTimeout(function() 
						{
							jQuery('#successMessageEditService').css('display','none');
							jQuery.colorbox.resize();
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page="+checkPage;
							}, 2000);
						});
					}
				}
				else if(uxEditServiceType == 0)
				{
					var editServiceTime = (parseInt(uxEditServiceHours) * 60) + parseInt(uxEditServiceMins);
					var uxEditTotalStartTime = parseInt(uxEditStartTimeHour * 60) + parseInt(uxEditStartTimeMins);
					var uxEditTotalEndTime = parseInt(uxEditEndTimeHour * 60) + parseInt(uxEditEndTimeMins);
					if(editServiceTime == 0)
					{
						jQuery('#errorMessageEditServices').css('display','none');
						jQuery('#timeErrorEditMessage').css('display','none');
						jQuery('#serviceTimeErrorEditMessage').css('display','block');
						jQuery.colorbox.resize();
					}
					else if((uxEditTotalStartTime >= uxEditTotalEndTime) && (uxEditStartTimeAMPM == uxEditEndTimeAMPM) && (uxEditFullDay == 0))
					{
						jQuery('#errorMessageEditServices').css('display','none');
						jQuery('#serviceTimeErrorEditMessage').css('display','none');
						jQuery('#timeErrorEditMessage').css('display','block');
						jQuery.colorbox.resize();
					}
					else if((uxEditStartTimeAMPM == "PM") && (uxEditEndTimeAMPM == "AM") && (uxEditFullDay == 0))
					{
						jQuery('#errorMessageEditServices').css('display','none');
						jQuery('#serviceTimeErrorEditMessage').css('display','none');
						jQuery('#timeErrorEditMessage').css('display','block');
						jQuery.colorbox.resize();
					}
					else
					{
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&ServiceId="+ServiceId+"&param=updateServiceTable&action=servicesLibrary", function(data)
						{
							jQuery('#timeErrorEditMessage').css('display','none');
							jQuery('#errorMessageEditServices').css('display','none');
							jQuery('#serviceTimeErrorEditMessage').css('display','none');
							jQuery('#successMessageEditService').css('display','block');
							jQuery.colorbox.resize();
							setTimeout(function() 
							{
								jQuery('#successMessageEditService').css('display','none');
								jQuery.colorbox.resize();
								var checkPage = "<?php echo $_REQUEST['page']; ?>";
								window.location.href = "admin.php?page="+checkPage;
							}, 2000);
						});
					}
				}
				else
				{
					jQuery('#timeErrorEditMessage').css('display','none');
					jQuery('#serviceTimeErrorEditMessage').css('display','none');
					jQuery('#errorMessageEditServices').css('display','block');
					jQuery.colorbox.resize();
				}
		}
	});
	function editServices(ServiceId)
	{
		jQuery.post(ajaxurl, "ServiceId="+ServiceId+"&param=editService&action=servicesLibrary", function(data)
		{
			jQuery("#bindEditControls").html(data);
			jQuery('#uxEditServiceColorCode').ColorPicker
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
			jQuery.colorbox.resize();
			jQuery("#EditcolorPickerService").css('display','none');
		});
	}
	jQuery(document).ready(function()
	{
		jQuery("#data-table tbody").sortable
		({
			opacity: 0.6,
			cursor: 'move',
			update: function()
			{
				var order = jQuery(this).sortable("serialize")+'&param=updateRecordsListings&action=servicesLibrary';
				jQuery.ajax
				({
					type: "POST",
					data: order,
					url:  ajaxurl,
					success: function(data)
					{
					}
				});
			}
		});
	});
	function singleBookingType()
	{
		jQuery('#editMaxBooking').css('display','none');
		jQuery.colorbox.resize();
	}
	function groupBookingType()
	{
		jQuery('#editMaxBooking').css('display','block');
		jQuery.colorbox.resize();
	}
	
	function divEditControlsShowHide()
	{
		var uxFullDay = jQuery("#uxEditFullDayService").prop("checked");
		if(uxFullDay == 1)
		{
			jQuery("#divEditServiceTime").css('display','none');
			jQuery("#divEditStartTime").css('display','none');
			jQuery("#divEditEndTime").css('display','none');
			jQuery("#divEditMaxDays").css('display','block');
			jQuery("#divEditCostType").css('display','block');
			jQuery.colorbox.resize();
		}
		else
		{
			jQuery("#divEditCostType").css('display','none');
			jQuery("#divEditMaxDays").css('display','none');
			jQuery("#divEditServiceTime").css('display','block');
			jQuery("#divEditStartTime").css('display','block');
			jQuery("#divEditEndTime").css('display','block');
			jQuery.colorbox.resize();
		}
	}	
</script>