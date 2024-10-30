<?php
global $wpdb;
$url = plugins_url('', __FILE__);
$requiredFields = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM ".bookingFormTable()." where status = 1 ",''
	)
); 
$requiredFields1 = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM ".bookingFormTable()." where status = 1 ",''
	)
);
?>
<form id="uxFrondendBookingForm" class="form-horizontal" method="post" action="" style="font-family: sans-serif;font-size: 12px;line-height: 1.4em;">
	<div class="content">
		<div class="form-wizard">
			<ul>
				<li style="float:left;width:25%;text-align:center">
					<a id="tab1" class="step active">
						<span class="number">1</span>
						<div><?php _e( "Choose Service", booking_xpress ); ?></div>
					</a>
				</li>
				<li style="float:left;width:25%;text-align:center">
					<a id="tab2" class="step">
						<span class="number">2</span>
						<div><?php _e( "Choose Availability", booking_xpress ); ?></div>
					</a>
				</li>
				<li style="float:left;width:25%;text-align:center">
					<a id="tab3" class="step">
						<span class="number">3</span>
						<div><?php _e( "Fill in your Information", booking_xpress ); ?></div>
					</a>
				</li>
				<li style="float:left;width:25%;text-align:center">
					<a id="tab4" class="step">
						<span class="number">4</span>
						<div><?php _e( "Confirm Booking", booking_xpress ); ?></div>
					</a>
				</li>
			</ul>
		</div> 
		
		<div class="progressbar-normal green  ui-progressbar ui-widget ui-widget-content ui-corner-all" value="75%" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="75" style="width:70%;float:left;">
			<div class="ui-progressbar-value ui-widget-header ui-corner-left" id="progressBar" style="width: 25%;"></div>
		</div>
		<div id="serviceGrid"  style="display:block;float:left;width:70%;">
			<table class="table table-striped" id="data-table">
				<thead>
					<tr>
						<th style="width:17%"><?php _e( "Service", booking_xpress ); ?></th>
						<th style="width:8%"><?php _e( "Cost", booking_xpress ); ?></th>
						<th style="width:15%"><?php _e( "Type", booking_xpress ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$service = $wpdb->get_results
				(
					$wpdb->prepare
					(
						'SELECT * FROM '.servicesTable(),''
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
				$defaultServiceDisplay =  $wpdb->get_var
				(
					$wpdb->prepare	
					(
						"SELECT GeneralSettingsValue  FROM ".generalSettingsTable()." where GeneralSettingsKey = %s",
						"default_Service_Display"
					)
				);
				if($defaultServiceDisplay == 0)
				{
					for($flag=0; $flag < count($service); $flag++)
					{
						
				?>
						<tr id="recordsArray_<?php echo $service[$flag] -> ServiceId ; ?>">
							<td>
								<input id="radioService<?php echo $flag;?>"   name="radioservice" type="radio" title="<?php echo $service[$flag] -> ServiceName;?>" value="<?php echo $service[$flag] -> ServiceId;?>"/>&nbsp;&nbsp;<?php echo $service[$flag] -> ServiceName;?>
							</td>
							<td>
								<?php echo ($costIcon).$service[$flag] -> ServiceCost;?>
							</td>
							<td>
								<?php 
								if($service[$flag]->Type == 0)
								{
									echo _e( "Single Booking", booking_xpress );
								}
								else 
								{
									_e( "Group Bookings", booking_xpress );?> <?php echo "(". $service[$flag] -> ServiceMaxBookings .")";
								}
								?>
								<input type="hidden" value="<?php echo $service[$flag]->ServiceFullDay; ?>" id="hdServiceType_<?php echo $service[$flag] -> ServiceId ; ?>" />
							</td>
							
						</tr>
					<?php
					}
				}
				else
				{
					?>
						<tr>
							<td>
								<select id="allService" name="allService" onchange="servicesOnchange()" style="width:95%">
									<option value="0"><?php _e( "Please choose Service", booking_xpress ); ?></option>
										<?php
										for($flag=0; $flag < count($service); $flag++)
										{
										?>
											<option value="<?php echo $service[$flag] -> ServiceId ; ?>"><?php echo $service[$flag] -> ServiceName ; ?></option>
											
										<?php
										
										}
									?>
								</select>
								
							</td>
							<td>
								<label id="SC" name="SC">
									
								</label>
							</td>
							<td>								
								
							<label id="ST" name="ST">
								
							</label>
							</label>
							</td>
							
						</tr>
						<?php
				}
				?>
				</tbody>
			</table>
			<input type="hidden" name="hdServiceTypeDDL" id="hdServiceTypeDDL" value="" />
		</div>
		<div id="calendarGrid" style="display:none;float:left;width:70%;">
			<div id="calBindingMultiple" style="width: 35%;float:left;"></div>	
			<div id="timingSlot" style="float:left;width: 54%;padding:5px;margin-left:10px;border:solid 1px #ECECEC;">
				<div id="timingsGrid"></div>
			</div>
			<input type="text" id="altField" value="" style="display:none"/>
		</div>
		<div id="customerGrid" style="display:none;float:left;width:71%;">
			<div class="block well" style="margin:10px;">
				<div class="box">
					<div class="content">
						
						<div id="scriptExistingCustomer"></div>
						<?php
      	 						$faceboookEnable = $wpdb->get_var
								(
									$wpdb->prepare
									(
										'SELECT SocialMediaValue FROM '.social_Media_settingsTable().' where SocialMediaKey = %s',
										"facebook-connect-enable"
									)
								);
								
								$facebookApi = $wpdb->get_var
								(
									$wpdb->prepare
									(
										'SELECT SocialMediaValue FROM '.social_Media_settingsTable().' where SocialMediaKey = %s',
										"facebook-api-id"
									)
								);
								
								$facebookSecret = $wpdb->get_var
								(
									$wpdb->prepare
									(
										'SELECT SocialMediaValue FROM '.social_Media_settingsTable().' where SocialMediaKey = %s',
										"facebook-secret-key"
									)
								);
		         	 			
								if($faceboookEnable == 1)
								{								
									?>
										<a href='#'><img onclick='checkLogin();' src="<?php echo TBP_BK_PLUGIN_URL ?>/images/facebook-login-button.png"/></a>
									
									<?php
								}	
						
						$bookingFeild = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"SELECT * FROM ".bookingFormTable()." where status = 1",""
							)
						);
						for($flagField = 0; $flagField < count($bookingFeild); $flagField++)
						{
							if($bookingFeild[$flagField]->type == "textbox")
							{
							?>
								<div class="row" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
								<label><?php _e($bookingFeild[$flagField]->BookingFormField, booking_xpress ); ?>
									<?php
									if($bookingFeild[$flagField]->required == 1)
									{
									?>
										<span class="req">*</span>
									<?php
									}
									?>
										</label>
										<div class="right">
											<input type="text" name="uxTxtControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxTxtControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" value=""/>
										</div>
								</div>
								
								<?php
							}
							else if($bookingFeild[$flagField]->type == "textarea")
							{
								?>
								<div class="row" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
									<label><?php _e($bookingFeild[$flagField]->BookingFormField, booking_xpress ); ?>
										<?php
										if($bookingFeild[$flagField]->required == 1)
										{
										?>
											<span class="req">*</span>
										<?php
										}
										?>
									</label>
									<div class="right">
										<textarea rows="4" cols="120" id="uxTxtAreaControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>"></textarea>
									</div>
								</div>
								<?php
							}
							else if($bookingFeild[$flagField]->type == "dropdown")
							{
							?>
								<div class="row" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
									<label ><?php _e($bookingFeild[$flagField]->BookingFormField, booking_xpress );?>
										<?php
											if($bookingFeild[$flagField]->required == 1)
											{
										?>
												<span class="req">*</span>
										<?php
											}
										?>
									</label>
									<div class="right">
										<select name="uxDdlControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxDdlControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" class="style">					                 					
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
													'SELECT CountryName FROM '. countriesTable() .' where CountryUsed = %d',
													"1"
												)
											);
											for ($flagCountry = 0; $flagCountry < count($country); $flagCountry++)
											{
												if ($sel_country == $country[$flagCountry]->CountryName)
												{
												?>
													<option value="<?php echo $country[$flagCountry]->CountryId;?>" selected='selected'><?php echo $country[$flagCountry]->CountryName;?></option>
												<?php
												}
												else
												{
												?>
													<option value="<?php echo $country[$flagCountry]->CountryId;?>"><?php echo $country[$flagCountry]->CountryName;?></option>
												<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<?php
							}
							if($bookingFeild[$flagField]->validation == "email")
							{
								?>
								<script>jQuery("#uxTxtControl1").attr("onBlur","checkExistingCustomerBooking();");</script> 
								<?php
							}	
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div id="confirmGrid" style="display:none;width:70%;float:left;">
			<div class="span8 well" style="border:none;background:none">
				<div class="row-fluid form-horizontal">
					<div class="row">
						<label style="top:10px;"> <?php _e( "Booking Details :", booking_xpress ) ?></label>
						<div class="right">
							<span id="uxLblControlApp" value=""></span>
						</div>
					</div>
					<?php
					$bookingFeild = $wpdb->get_results
					(
						$wpdb->prepare
						(
							"SELECT * FROM ".bookingFormTable()." where status = 1",""
						)
					);
					for($flagField = 0; $flagField < count($bookingFeild); $flagField++)
					{
						?>
						<div class="row" name="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" id="uxControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>">
							<label style="top:10px;"><?php _e($bookingFeild[$flagField]->BookingFormField, booking_xpress ); ?>
							</label>
							<div class="right">
								<span id="uxLblControl<?php echo $bookingFeild[$flagField]->BookingFormId;?>" value=""></span>
							</div>
							<input type="hidden" id="hiddeninputname" name="hiddeninputname" value="" />
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<div style="float: left;margin-bottom: 10px;margin-left: 1%;margin-right: 30%;padding-top:1%; ">
			<button type="submit" id="buttonBackStep" class="green" style="display:none;padding:0px	">
				<span>
					<?php _e( "Previous Step", booking_xpress ); ?>
				</span>
			</button>
		</div>
		<div style="float:right;margin-right: 31%;"> 
			<button type="submit" id="buttonNextStep" class="green" style="margin-top:10px;padding:0px">
				<span>
					<?php _e( "Next Step", booking_xpress ); ?>
				</span>
			</button>
		</div>
	</div>
	<input type="hidden" name="uxHdnTotalCost" id="uxHdnTotalCost"/>
</form>

<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	<?php
	$defaultServicedisplay = $wpdb->get_var
	(
		$wpdb->prepare
		(
			"select GeneralSettingsValue from ". generalSettingsTable()." where GeneralSettingsKey = %s",
			'default_Service_Display'
		)
	);
	?>
	var defaultServiceDisplaySetting = "<?php echo $defaultServicedisplay; ?>";
	jQuery('.timeCol').live('click',function()
	{
		jQuery(".timeCol").each(function()
		{
			jQuery(this).attr('style','');
		});
		jQuery(this).attr('style','background-color:#86c301 !important;color:#fff !important');
		jQuery('#hdTimeControl').val(jQuery(this).html());
		jQuery('#hdTimeControlValue').val(jQuery(this).attr('value'));
	});
	jQuery('#buttonNextStep').click(function()
	{
		var block = 'block';
		var step1Action = jQuery('#serviceGrid').css('display');
		var step2Action = jQuery('#calendarGrid').css('display');
		var step3Action = jQuery('#customerGrid').css('display');
		var step4Action = jQuery('#confirmGrid').css('display');
		
		switch(block)
		{
			case step1Action:
				
				var serviceId;
				if(defaultServiceDisplaySetting == 0)
				{
					 serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
				}
				else
				{
					 serviceId = jQuery("#allService").val();
					 
				}
				
				if(serviceId != undefined && serviceId != 0 )
				{
					jQuery('#serviceGrid').css('display','none');
					jQuery('#progressBar').css('width','50%');
					jQuery('#tab2').addClass('active');
					//var hdServiceType = jQuery('#hdServiceType_' + serviceId).val();
					//var hdServiceType = jQuery('#hdServiceTypeDDL').val();
					
					jQuery('#buttonBackStep').css('display','block');
					Showcalender();
					var hdServiceType;					
					jQuery.post(ajaxurl,  "serviceId="+serviceId+"&param=getTypeOfService&action=bookingsLibrary", function(data)
					{						
						hdServiceType = jQuery.trim(data);	
						if(hdServiceType == 0)
						{
							showTimingGrid();
							jQuery.colorbox.resize();
						}
						else
						{
							jQuery('#timingSlot').css('visibility','hidden');
							jQuery.colorbox.resize();
						}								
					
					});
				
				}
				else
				{
					bootbox.alert("<?php _e( "Please choose atleast one Service", booking_xpress ); ?>");
				}					
				break;
			case step2Action:
				
				var serviceId;
				if(defaultServiceDisplaySetting == 0)
				{
					 serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
				}
				else
				{
					   serviceId = jQuery("#allService").val();
				}
				//var hdServiceType = jQuery('#hdServiceType_' + serviceId).val();
				//var hdServiceType = jQuery('#hdServiceTypeDDL').val();
				
				jQuery.post(ajaxurl,  "serviceId="+serviceId+"&param=getTypeOfService&action=bookingsLibrary", function(data)
					{
						hdServiceType = jQuery.trim(data);	
						if(hdServiceType == 1)
						{
							var BookingDate = jQuery("#altField").val();
							if(BookingDate != "")
							{
								ShowClients();
								jQuery('#tab3').addClass("active");
								jQuery('#progressBar').css('width','75%');
								jQuery.colorbox.resize();
							}
							else
							{
								bootbox.alert("<?php _e( "Please choose Booking date", booking_xpress ); ?>");
							}
						}
						else
						{
							var BookingDate = jQuery("#altField").val();
							var hdTimeControlValue = jQuery("#hdTimeControlValue").val();
							if(BookingDate != "" && hdTimeControlValue != "")
							{
								ShowClients();
								jQuery('#tab3').addClass("active");
								jQuery('#progressBar').css('width','75%');
								jQuery.colorbox.resize();
							}
							else
							{
								bootbox.alert("<?php _e( "Please choose Booking date and time", booking_xpress ); ?>");
							}
						}									
				
					});
				
				
				break;
				
			case step3Action:
				_validator  = jQuery("#uxFrondendBookingForm").valid();   
				if(_validator)
				{	
					CheckCoupons();
					
				}
				break;
				case step4Action:
					insertCustomer();
					jQuery.colorbox.resize();
				break;
		}
		return false;
	});
	jQuery('#buttonBackStep').click(function()
	{
		var block = 'block';
		var step1Action = jQuery('#serviceGrid').css('display');
		var step2Action = jQuery('#calendarGrid').css('display');
		var step3Action = jQuery('#customerGrid').css('display');
		var step4Action = jQuery('#confirmGrid').css('display');
		switch(block)
		{
			case step2Action:
				jQuery('#serviceGrid').css('display','block');
				jQuery('#calendarGrid').css('display','none');
				jQuery('#buttonBackStep').css('display','none');
				jQuery('#progressBar').css('width','25%');	
				jQuery('#tab1').addClass('active');
				jQuery('#tab2').removeClass('active');
				jQuery("#calBindingMultiple").datepicker("destroy");
				jQuery.colorbox.resize();
				break;
			case step3Action:
			
				jQuery('#calendarGrid').css('display','block');
				jQuery('#customerGrid').css('display','none');
				jQuery('#progressBar').css('width','50%');	
				jQuery('#tab2').addClass('active');
				jQuery('#tab3').removeClass('active');
				jQuery.colorbox.resize();
				break;
			case step4Action:
				jQuery('#customerGrid').css('display','block');
				jQuery('#confirmGrid').css('display','none');
				jQuery('#progressBar').css('width','75%');	
				jQuery('#tab3').addClass('active');
				jQuery('#tab4').removeClass('active');
				jQuery.colorbox.resize();
				break;
		}
		return false;
	});
	jQuery("#uxFrondendBookingForm").validate
	({
		rules: 
		{
			<?php
				
				$dynamic = "";
				for($flagField = 0; $flagField < count($requiredFields); $flagField++)
				{
					if($requiredFields[$flagField]->type == "textbox")
					{
						if($requiredFields[$flagField]->required == 1)
						{
							$dynamic .= 'uxTxtControl' . $requiredFields[$flagField]->BookingFormId . ':{ required :true';
							if($requiredFields[$flagField]->validation == "email")
							{
								$dynamic .= ", email : true }";
							}
							else
							{
								$dynamic .= "}";
							}
						}
						else 
						{
							$dynamic .= 'uxTxtControl' . $requiredFields[$flagField]->BookingFormId . ':{ required :false}';
						}
						if(count($requiredFields) > 1 && $flagField < count($requiredFields) - 1)
						{
							$dynamic .= ",";	
						}
					}
					else 
					{
						$dynamic .= "";	
					}
					
						
				}
				
				echo $dynamic;
			?>	
		},
		highlight: function(label) 
		{
			jQuery.colorbox.resize();
		},
		success: function(label)
		{
				label.text('Success!').addClass('valid');
				<?php
				for($flagField = 0; $flagField < count($requiredFields1); $flagField++)
				{
					if($requiredFields[$flagField]->type == "textbox")
					{
					?>
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val() + '&nbsp;');
					<?php
					}
					else if($requiredFields1[$flagField]->type == "textarea")
					{
					?>
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxTxtAreaControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val() + '&nbsp;');
						
					<?php
					}
					else if($requiredFields1[$flagField]->type == "dropdown")
					{
					?>		
						var countryId = jQuery('#uxDdlControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val();	
						jQuery.post(ajaxurl,  "countryId="+countryId+"&param=getCountryName&action=bookingsLibrary", function(data)
						{
							var countryName = jQuery.trim(data);							
							jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(countryName + '&nbsp;');
						}); 
						
					<?php
					}
					else if($requiredFields1[$flagField]->type == "file")
					{
					?>		
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#hiddeninputname').val() + '&nbsp;');
						
					<?php
					}
				}
				?>
				
				var formattedDate = jQuery('#altField').val();
				var time = jQuery('#hdTimeControl').val();				
				var serviceId;
				var serviceName;
				var hdServiceType;
				if(defaultServiceDisplaySetting == 0)
				{
					serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
					serviceName = jQuery('input:radio[name=radioservice]:checked').attr('title');					 
									
					
				}
				else
				{
					serviceId = jQuery("#allService").val();
					serviceName =  jQuery("#allService option[value="+serviceId+"]").text()
					
					
				}
				
				jQuery.post(ajaxurl,  "serviceId="+serviceId+"&param=getTypeOfService&action=bookingsLibrary", function(data)
					{
						hdServiceType = jQuery.trim(data);	
						if(hdServiceType == 1)
						{
							jQuery('#uxLblControlApp').html("For <b>" + serviceName + "</b> on <b>" + formattedDate + "</b>");
						}
						else
						{
							jQuery('#uxLblControlApp').html("For <b>" + serviceName + "</b> on <b>" + formattedDate + "</b> at <b>" + time + "</b>");
						}									
				
					});
			
			
				jQuery.colorbox.resize();

		},
		submitHandler: function(form)
		{
		
		}
	});	
	function servicesOnchange() 
	{	
		var serviceId;	
		if(defaultServiceDisplaySetting == 0)
		{
			serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
			serviceId = jQuery("#allService").val();
		}
		if(serviceId == 0)
		{
			jQuery("#ST").html("");
			jQuery("#SC").html("");	
		}
		else
		{
			jQuery.post(ajaxurl,  "serviceId="+serviceId+"&param=frontendService&action=bookingsLibrary", function(data)
			{
				
				var dat = data.split(',');
				jQuery("#ST").html(dat[0]);
				jQuery("#SC").html(dat[3] + " " + dat[1]);			
				jQuery("#hdServiceTypeDDL").val(dat[2]);
				
			});
		}
	}
	function Showcalender()
	{
		var serviceId
		if(defaultServiceDisplaySetting == 0)
		{
			 serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
			 serviceId = jQuery("#allService").val();
		}
		jQuery.post(ajaxurl,  "serviceId="+serviceId+"&param=frontendCalender&action=bookingsLibrary", function(data)
		{
			var dat = data.trim();
			jQuery("#calBindingMultiple").html(dat);
			jQuery.colorbox.resize();
		}); 
		jQuery("#serviceGrid").css('display','none');
		jQuery("#calendarGrid").css('display','block');
		jQuery.colorbox.resize();
	}
	function ShowClients()
	{
			jQuery("#serviceGrid").css('display','none');
			jQuery("#calendarGrid").css('display','none');
			jQuery("#customerGrid").css('display','block');
	}
	function CheckCoupons()
	{
		if(defaultServiceDisplaySetting == 0)
		{
		   	var serviceId = jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
			var serviceId = jQuery("#allService").val();
		}
		var uxCouponCode = jQuery('#uxTxtControl11').val() == undefined ? "" : jQuery('#uxTxtControl11').val();
		jQuery.post(ajaxurl,  "uxCouponCode="+uxCouponCode+"&serviceId="+serviceId+"&param=checkForCouponExist&action=bookingsLibrary", function(data)
		{				
				var returnData = jQuery.trim(data);
				var coupon = returnData.split("-");				
				var price = coupon[0];				
				var couponType = coupon[1];				
				if(couponType != "CouponNotValid" && couponType != "leaveBlank")
				{
					var totalCost = jQuery.trim(price);				
					jQuery("#uxHdnTotalCost").val(totalCost);
					jQuery('#confirmGrid').css('display','block');
					jQuery('#customerGrid').css('display','none');
					jQuery('#progressBar').css('width','100%');	
					jQuery('#tab4').addClass("active");
					jQuery.colorbox.resize();
				}
				else if(couponType == "leaveBlank")
				{
					var totalCost = jQuery.trim(price);					
					jQuery("#uxHdnTotalCost").val(totalCost);
					jQuery('#confirmGrid').css('display','block');
					jQuery('#customerGrid').css('display','none');
					jQuery('#progressBar').css('width','100%');	
					jQuery('#tab4').addClass("active");
					jQuery.colorbox.resize();
				}
				else
				{
					bootbox.alert("<?php _e( "Coupon is not valid", booking_xpress ); ?>");
				}
		});
	}
	function insertCustomer()
	{
		var uxEmailAddress = jQuery('#uxTxtControl1').val();
		
		jQuery.post(ajaxurl,  "uxEmailAddress="+uxEmailAddress+"&param=checkForUpdateCustomer&action=bookingsLibrary", function(data)
		{
			
			if(jQuery.trim(data) == "newCustomerEmail")
				{
					
					jQuery.post(ajaxurl,  jQuery("#uxFrondendBookingForm").serialize() + "&param=addNewCustomer&action=bookingsLibrary", function(data)
						{
						
							var customerId = jQuery.trim(data);
							submitandsave(customerId);
						});
				}
				else
				{
					var customerId = jQuery.trim(data);
					
					jQuery.post(ajaxurl,  jQuery("#uxFrondendBookingForm").serialize() + "&customerId=" + customerId + "&uxCustomerEmail=" + uxEmailAddress +"&param=upDateCustomer&action=bookingsLibrary", function(data)
					{		
							submitandsave(customerId);
					});
				}
			
		}); 
	}
	function submitandsave(customerId)
	{
		
		<?php 
		$payapalEnable= $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT PaymentGatewayValue  FROM ' . payment_Gateway_settingsTable() .' where PaymentGatewayKey = %s',
				"paypal-enabled"
			)
		);
		?>
		var paypalCheck = "<?php echo $payapalEnable; ?>";	
		if(defaultServiceDisplaySetting == 0)
		{
			var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
			var serviceId = jQuery("#allService").val();
		}
		var altField = jQuery("#altField").val();
		var uxNotes = jQuery('#uxTxtAreaControl13').val() == undefined ? "" : jQuery('#uxTxtAreaControl13').val();
		var uxCouponCode = jQuery('#uxTxtControl11').val() == undefined ? "" : jQuery('#uxTxtControl11').val();
		var bookingTime =  jQuery('#hdTimeControlValue').val();
		
		
		jQuery.post(ajaxurl, "altField="+altField+"&serviceId="+serviceId+"&customerId="+customerId+"&uxCouponCode="+uxCouponCode+"&uxNotes="+uxNotes+"&bookingTime="+bookingTime+"&param=frontEndMutipleDates&action=bookingsLibrary", function(data) 
			{
				
				var bookingId = jQuery.trim(data);
				
					
					if(paypalCheck == 1)
					{
						paypalConnect(bookingId);
					}
					else
					{
						window.location.reload(true);
						
					}	
			});
	}
	
	function paypalConnect(bookingId)
	{
		
		<?php
		$currencyIcon = $wpdb->get_var
		(
			$wpdb->prepare
			(	
				'SELECT CurrencyCode FROM ' . currenciesTable() . ' where CurrencyUsed = %d',
				"1"
			)
		);
		$paypalURL = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT PaymentGatewayValue  FROM ' . payment_Gateway_settingsTable() . ' where PaymentGatewayKey = %s',
				"paypal-Test-Url"
			)
		);
		?>
		var paypalURL = "<?php echo $paypalURL;?>";
		var CurrencyIcon = "<?php echo $currencyIcon; ?>";
		var uri = "<?php echo $url; ?>";
		if(defaultServiceDisplaySetting == 0)
		{
			var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
			var serviceId = jQuery("#allService").val();
		}
		var uxEmailAddress = jQuery('#uxTxtControl1').val();
		var uxFirstName = jQuery('#uxTxtControl2').val();
		var uxLastName = jQuery('#uxTxtControl3').val() == undefined ? "" : jQuery('#uxTxtControl3').val();
		var uxMobileNumber = jQuery('#uxTxtControl4').val() == undefined ? "" : jQuery('#uxTxtControl4').val();
		var uxTelephoneNumber = jQuery('#uxTxtControl5').val() == undefined ? "" : jQuery('#uxTxtControl5').val();
		var uxSkypeId = jQuery('#uxTxtControl6').val() == undefined ? "" : jQuery('#uxTxtControl6').val();
		var uxAddress1 = jQuery('#uxTxtControl7').val() == undefined ? "" : jQuery('#uxTxtControl7').val();
		var uxAddress2 = jQuery('#uxTxtControl8').val() == undefined ? "" : jQuery('#uxTxtControl8').val();
		var uxCity = jQuery('#uxTxtControl9').val() == undefined ? "" : jQuery('#uxTxtControl9').val();
		var uxPostCode = jQuery('#uxTxtControl10').val() == undefined ? "" : jQuery('#uxTxtControl10').val();
		var uxCouponCode = jQuery('#uxTxtControl11').val() == undefined ? "" : jQuery('#uxTxtControl11').val();		
		var TotalCost = jQuery("#uxHdnTotalCost").val();
					
		file=uri+"/paypal.php";		
		jQuery.post(file, "serviceid="+serviceId+"&cmd=_xclick&no_note=1&currency_code="+CurrencyIcon+"&first_name="+uxFirstName+"&last_name="+uxLastName+
			"&H_PhoneNumber="+uxMobileNumber+"&email="+uxEmailAddress+"&address1="+uxAddress1+"&address2="+uxAddress2+"&city="+uxCity+"&zip="+uxPostCode+
			"&payer_email="+uxEmailAddress+"&item_number="+bookingId+"&TotalCost="+TotalCost+"&action=process", function(data) 
			{
				var querystring = jQuery.trim(data);					
				if(querystring !="")
				{	
					window.location = paypalURL+querystring;
				}
			});
	}
	function showTimingGrid()
	{
		if(defaultServiceDisplaySetting == 0)
		{
			var serviceId =  jQuery('input:radio[name=radioservice]:checked').val();
		}
		else
		{
			  var serviceId = jQuery("#allService").val();
		}
		var bookingDates = jQuery("#altField").val();
		
		jQuery.post(ajaxurl,  "serviceId="+serviceId+"&bookingDates="+bookingDates+"&param=bookingTiming&action=bookingsLibrary", function(data)
		{
		
				var dat = data.trim();
				if(dat != "fullday")
				{
					jQuery('#timingSlot').css('display','block');
					jQuery('#timingSlot').css('visibility','visible');
					jQuery('#timingsGrid').html(dat);
					jQuery.colorbox.resize();
				}
			
		});
	}
	function checkExistingCustomerBooking()
	{
		
		var uxEmailAddress = jQuery('#uxTxtControl1').val();
		
		jQuery.post(ajaxurl,  "uxEmailAddress="+uxEmailAddress+"&param=getExistingCustomerData&action=bookingsLibrary", function(data)
		{
			
			if(jQuery.trim(data) != "newCustomer")
			{
				
				var dataa = data.trim();
				jQuery("#scriptExistingCustomer").html(dataa);
			}
			else
			{
				jQuery('#uxTxtControl1').val(uxEmailAddress);
			}	
		});
	}
	oTable = jQuery('#data-table').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"bFilter": false,
		"sPaginationType": "full_numbers",
		"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
		"oLanguage": 
		{
			"sLengthMenu": "_MENU_"
		}
	});
	
</script>
<?php

	$faceboookEnable = $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT SocialMediaValue FROM '.social_Media_settingsTable().' where SocialMediaKey = %s',
			"facebook-connect-enable"
		)
	);
	$facebookApi = $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT SocialMediaValue FROM '.social_Media_settingsTable().' where SocialMediaKey = %s',
			"facebook-api-id"
		)
	);
	$facebookSecret = $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT SocialMediaValue FROM '.social_Media_settingsTable().' where SocialMediaKey = %s',
			"facebook-secret-key"
		)
	);
	
	if($faceboookEnable == 1)
	{		
		?>
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script type="text/javascript">
		window.fbAsyncInit = function() {
		   FB.init({
		     appId      : '<?php echo $facebookApi ?>',  
		     channelURL : '',
		     status     : true, 
		     cookie     : true,       
		     xfbml      : true  
		   });
		};
	
		function checkLogin() {
            
            FB.getLoginStatus(function (response) {
                if (response.status == 'connected') {
                    FB.api('/me', function(me) {
					
						var fnam=me.first_name;
						var lnam=me.last_name;
						var eml=me.email;
						jQuery('#uxTxtControl2').val(fnam);
						jQuery('#uxTxtControl3').val(lnam);
						jQuery('#uxTxtControl1').val(eml);						
						checkExistingCustomerBooking();
												
						});
                    

                } else {

                   FB.login(function(response) {
                   	
                   	if (response.authResponse) {
					     checkLogin();
					   } 
                   	
                   },{scope: 'email,user_likes'});
                    
                }

            });

        }
        
</script>
<?php
}
?>