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
<form id="uxFrondendBookingForm" class="form-horizontal" method="post" action="">
	<div class="content">
		<div class="form-wizard"></div>
			<div id="serviceGrid"  style="display:block;margin-left:2%">
				<?php
					$service = $wpdb->get_results
					(
						$wpdb->prepare
						(
							'SELECT * FROM '.servicesTable().'  ORDER BY ' . servicesTable() . '.ServiceDisplayOrder ASC',''
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
					for($flag=0; $flag < count($service); $flag++)
					{
					?>
						<label>
							<?php _e( " Choose Service :", booking_xpress ) ?>
						</label>
						<select id="allService" name="allService"'" onchange="servicesOnchange()" style="width:30%">
							<option value="0">
								<?php _e( "Please choose Service", booking_xpress ); ?>
							</option>
							<?php
								for($flag=0; $flag < count($service); $flag++)
								{
							?>
									<option value="<?php echo $service[$flag] -> ServiceId ; ?>"><?php echo $service[$flag] -> ServiceName ; ?></option>
									<?php
								}
									?>
						</select>
						
						<?php
					}
						?>
			</div>
			<div id="calendarGrid" style="display:block;float:left;width:98%;margin-top: 3%;">
				<div id="calBindingMultiple" style="width: 25%;float:left;"></div>	
				<div id="timingSlot" style="float:left;width: 58%;display:none; padding:5px;margin-left:10px;border:solid 1px #ECECEC;">
					<div id="timingsGrid"></div>
				</div>
				<input type="text" id="altField" value="" style="display:none"/>
			</div>
			<div id="customerGrid" style="display: none;width:96%">
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
									<label>
									<?php _e($bookingFeild[$flagField]->BookingFormField, booking_xpress ); ?>
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
									<div class="right" margin-left: -10%>
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
			<div class="row" style="border-bottom:none;padding: 1px 10px 10px !important;">
				<label></label>
				<div class="right">
					<button type="submit" class="green" style="margin-top:10px; margin-left: -2%;padding: 0px;">
						<span>
							<?php _e( "Submit & Save Changes", booking_xpress ); ?>
						</span>
					</button>
				</div>
			</div>
	</div>
</form>
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	function servicesOnchange()
	{
						
		
		
		
		jQuery('#customerGrid').css('display', 'block');
		jQuery("#calBindingMultiple").datepicker("destroy");		
		var serviceId = jQuery("#allService").val();		
		jQuery.post(ajaxurl,  "serviceId="+serviceId+"&param=frontendCalender&action=calendarClassicLibrary", function(data)
		{
						
			jQuery.post(ajaxurl,  "serviceId="+serviceId+"&param=getTypeOfService&action=calendarClassicLibrary", function(data)
			{
				var serviceType = jQuery.trim(data);										
				if(serviceType == 1)
				{					
					jQuery('#timingsGrid').css('display', 'none');
					jQuery('#timingSlot').css('display', 'none');
					jQuery.colorbox.resize();
					if(navigator.userAgent.indexOf("Safari")!=-1 && navigator.userAgent.indexOf('Chrome') == -1){
        				
        				jQuery("#customerGrid").css("margin-top", "0px");
			    		}
			    		else
			    		{
			    			jQuery("#customerGrid").css("margin-top", "32%");
			    			
			    		}
				}
				else
				{
					showTimingGrid();
					jQuery.colorbox.resize();
					jQuery('#timingsGrid').css('display', 'block');
					jQuery('#timingSlot').css('display', 'block');
					jQuery("#customerGrid").css("margin-top", "32%");
				}
			});
			
			var dat = data.trim();
			jQuery('#calBindingMultiple').css('display', 'block');
			jQuery("#calBindingMultiple").html(dat);
			jQuery.colorbox.resize();																							
			
		});
	}
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
	function showTimingGrid()
	{
		var serviceId = jQuery("#allService").val();
		var bookingDates = jQuery("#altField").val();
		jQuery.colorbox.resize();
		jQuery.post(ajaxurl,  "serviceId="+serviceId+"&bookingDates="+bookingDates+"&param=bookingTiming&action=calendarClassicLibrary", function(data)
		{
			var dat = data.trim();
			if(dat != "fullday")
			{
				jQuery.colorbox.resize();
				jQuery('#customerGrid').css('display', 'block');
				jQuery('#timingsGrid').css('display', 'block');
				jQuery('#timingsGrid').html(dat);
				jQuery.colorbox.resize();
			}
		});
	}
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
			if(jQuery(label).closest('.row').hasClass('success'))
			{
				jQuery(label).closest('.row').removeClass('success');
			}
			jQuery(label).closest('.row').addClass('errors');
		},
		success: function(label)
		{
			<?php
				for($flagField = 0; $flagField < count($requiredFields1); $flagField++)
				{
					if($requiredFields[$flagField]->type == "textbox")
					{
					?>
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxTxtControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val());
					<?php
					}
					else if($requiredFields1[$flagField]->type == "textarea")
					{
					?>
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxTxtAreaControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val());
					<?php
					}
					else if($requiredFields1[$flagField]->type == "dropdown")
					{
					?>
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#uxDdlControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').val());
					<?php
					}
					else if($requiredFields1[$flagField]->type == "file")
					{
					?>
						jQuery('#uxLblControl<?php echo $requiredFields1[$flagField]->BookingFormId;?>').html(jQuery('#hiddeninputname').val());
					<?php
					}
				}
				?>
				var serviceName = jQuery('input:radio[name=radioservice]:checked').attr('title');
				var formattedDate = jQuery('#altField').val();
				
			label.text('Success!').addClass('valid')
			
			jQuery.colorbox.resize();
		},
		submitHandler: function(form)
		{
			
		var BookingDate = jQuery("#altField").val();		
		var hdTimeControlValue = jQuery('#hdTimeControlValue').val() == undefined ? "" : jQuery('#hdTimeControlValue').val();
		var serviceId = jQuery("#allService").val();
		if(serviceId == 0)
		{
			bootbox.alert("<?php _e( "Please choose Service", booking_xpress ); ?>");
		}		
		else
		{	
			jQuery.post(ajaxurl,  "serviceId="+serviceId+"&param=getTypeOfService&action=calendarClassicLibrary", function(data)
				{
					var serviceType = jQuery.trim(data);					
					if(serviceType == 1)
					{
						if(BookingDate == "")
						{
							bootbox.alert("<?php _e( "Please choose Booking date", booking_xpress ); ?>");
						}
						else
						{	
							
							var uxCouponCode = jQuery('#uxTxtControl11').val() == undefined ? "" : jQuery('#uxTxtControl11').val();														
							jQuery.post(ajaxurl,  "uxCouponCode="+uxCouponCode+"&serviceId="+serviceId+"&param=checkForCouponExist&action=calendarClassicLibrary", function(data)
							{										
									var returnData = jQuery.trim(data);
									var coupon = returnData.split("-");				
									var price = coupon[0];				
									var couponType = coupon[1];				
									if(couponType != "CouponNotValid" && couponType != "leaveBlank")
									{
										var totalCost = jQuery.trim(price);	
										SaveCustomerData(totalCost);			
										
									}
									else if(couponType == "leaveBlank")
									{
										var totalCost = jQuery.trim(price);					
										SaveCustomerData(totalCost);		
									}
									else
									{
										bootbox.alert("<?php _e( "Coupon is not valid", booking_xpress ); ?>");
									}
							});
												
							
													
																				
						}						
					}
					else
					{
						if(hdTimeControlValue == "")			
						{
														
							bootbox.alert("<?php _e( "Please choose Booking date & time", booking_xpress ); ?>");							
						}
						else
						{								
							var uxCouponCode = jQuery('#uxTxtControl11').val() == undefined ? "" : jQuery('#uxTxtControl11').val();														
							jQuery.post(ajaxurl,  "uxCouponCode="+uxCouponCode+"&serviceId="+serviceId+"&param=checkForCouponExist&action=calendarClassicLibrary", function(data)
							{				
									var returnData = jQuery.trim(data);
									var coupon = returnData.split("-");				
									var price = coupon[0];				
									var couponType = coupon[1];				
									if(couponType != "CouponNotValid" && couponType != "leaveBlank")
									{
										var totalCost = jQuery.trim(price);	
										SaveCustomerData(totalCost);			
										
									}
									else if(couponType == "leaveBlank")
									{
										var totalCost = jQuery.trim(price);					
										SaveCustomerData(totalCost);		
									}
									else
									{
										bootbox.alert("<?php _e( "Coupon is not valid", booking_xpress ); ?>");
									}
							});
											
						}
					}
				});										
			
			
		}
	}
	});
	
	function SaveCustomerData(TotalCost)
	{
		var BookingDate = jQuery("#altField").val();	
		var uxEmailAddress = jQuery('#uxTxtControl1').val();
							jQuery.post(ajaxurl,  "uxEmailAddress="+uxEmailAddress+"&param=getExistingCustomerData&action=calendarClassicLibrary", function(data)
							{
								if(jQuery.trim(data) == "newCustomer")
								{
									
									jQuery.post(ajaxurl, jQuery("#uxFrondendBookingForm").serialize() + "&altField="+altField+"&param=addCustomer&action=calendarClassicLibrary", function(data)
									{
										var customerId = jQuery.trim(data);
										submitandsave(customerId, TotalCost);
										window.location.reload;
										jQuery.colorbox.resize();
									});
									
								}
								else
								{
									jQuery.post(ajaxurl,  "uxEmailAddress="+uxEmailAddress+"&param=getExistingCustomerId&action=calendarClassicLibrary", function(data)
									{
										var customerId = jQuery.trim(data);										
										jQuery.post(ajaxurl,  jQuery("#uxFrondendBookingForm").serialize() + "&customerId=" + customerId + "&uxCustomerEmail=" + uxEmailAddress +"&param=upDateCustomer&action=calendarClassicLibrary", function(data)
										{											
											submitandsave(customerId, TotalCost);
											window.location.reload;
											jQuery.colorbox.resize();
										});
										
									});																		
									
								}
								
							});	
		
	}
	function paypalConnect(bookingId, TotalCost)
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
		var serviceId = jQuery("#allService").val();		
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
	function submitandsave(customerId, TotalCost)
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

		var BookingDate = jQuery("#altField").val();
		var hdTimeControlValue = jQuery("#hdTimeControlValue").val();
		var serviceId = jQuery("#allService").val();
			
		var altField = jQuery("#altField").val();
		//var uxNotes = jQuery('#uxTxtAreaControl13').val() == undefined ? "" : jQuery('#uxTxtAreaControl13').val();
		//var uxCouponCode = jQuery('#uxTxtControl11').val() == undefined ? "" : jQuery('#uxTxtControl11').val();
		var bookingTime =  jQuery('#hdTimeControlValue').val();
		jQuery.post(ajaxurl, "altField="+altField+"&serviceId="+serviceId+"&customerId="+customerId+"&bookingTime="+bookingTime+"&param=frontEndMutipleDates&action=calendarClassicLibrary", function(data)
			{
								
				var bookingId = jQuery.trim(data);
				if(paypalCheck == 1)
				{
					paypalConnect(bookingId, TotalCost);
				}
				else
				{
					setTimeout(function() 
					{
						window.location.reload(true);
					}, 3000);
				}	
			});
	}
	function checkExistingCustomerBooking()
	{
		var uxEmailAddress = jQuery('#uxTxtControl1').val();
		jQuery.post(ajaxurl,  "uxEmailAddress="+uxEmailAddress+"&param=getExistingCustomerData&action=calendarClassicLibrary", function(data)
		{
			
			if(jQuery.trim(data) != "newCustomer")
			{
				var dat = data.trim();
				jQuery("#scriptExistingCustomer").html(dat);
				jQuery.colorbox.resize();
			}
			else
			{
				jQuery('#uxTxtControl1').val(uxEmailAddress);
				jQuery.colorbox.resize();
			}
		});
	}
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
