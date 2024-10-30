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
					<?php _e( "FORM SETUP", booking_xpress ); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<div class="message green" id="SuccessReportBug" style="display:none;">
			<span>
				<strong>
					<?php _e("Success! The Email has been sent.", booking_xpress); ?>
				</strong>
			</span>
		</div>
		<div class="message green" id="bookingFieldsSuccessMessage" style="display:none;">
			<span>
				<strong>
					<?php _e( "Success! The Booking Fields has been updated.", booking_xpress ); ?>
				</strong>
			</span>
		</div>
		<div class="box">
			<div class="title">
				<?php _e("Form Setup", booking_xpress); ?>
				<span class="hide"></span>
			</div>
			<div class="content dataTables_wrapper">
				<form id="uxFrmbookingFormFields" class="form-horizontal" method="post" action="#">
					<table cellspacing="0" cellpadding="0" border="0" class="all" id="table-booking-form"> 
						<thead>
							<tr>
								<th rowspan="1" colspan="1" style="width: 270px;">
									<?php _e("Field Name", booking_xpress); ?>
								</th>
								<th rowspan="1" colspan="1" style="width: 176px;">
									<?php _e("Visibility", booking_xpress); ?>
								</th>
								<th rowspan="1" colspan="1" style="width: 290px;">
									<?php _e("Validation", booking_xpress); ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$bookingFeild = $wpdb->get_results
								(
									$wpdb->prepare
									(
										'SELECT * FROM '.bookingFormTable(),''
									)
								);
								for ($flag = 0; $flag < count($bookingFeild); $flag++)
								{
									$bookingFeildName = $bookingFeild[$flag]->BookingFormField;
									$bookingStatus = $bookingFeild[$flag]->status;
									$BookingRequired = $bookingFeild[$flag]->required;
									$checked = "";
									$check = "";
									if ($bookingStatus == 1)
									{
										$checked = "checked=\"checked\"";
									}
									else 
									{
										$check = "checked=\"checked\"";
									}
									$check1 = "";
									$check0 = "";
									if ($BookingRequired == 1)
									{
										$check1 = "checked=\"checked\"";
									} 
									else 
									{
										$check0 = "checked=\"checked\"";
									}
							?>
									<tr>
										<td>
											<?php _e($bookingFeildName, booking_xpress); ?>
												<input type="hidden" id="bookingFeildNameHidden<?php echo $flag;?>" value="<?php echo $bookingFeildName;?>"/>
										</td>
										<?php
											if($bookingFeildName != "First Name :" && $bookingFeildName != "Email :")
											{
										?>
												<td>
													<label class="radio">
														<input type="radio" id="bookingStatus_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="1" <?php echo $checked;?> />  <?php _e( "Visible", booking_xpress ); ?>
													</label>&nbsp;&nbsp;
													<label class="radio">
														<input type="radio" id="bookingStatus1_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="0" <?php echo $check;?> />  <?php _e( "Invisible", booking_xpress ); ?>
													</label>	
												</td>
												<td>
													<label class="radio">
														<input type="radio" id="bookingRequiredOpen<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="1"   <?php echo $check1;?> /><?php _e( "Required", booking_xpress ); ?>
													</label>&nbsp;&nbsp;	
													<label class="radio">
														<input type="radio" id="bookingRequiredClose<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="0" <?php echo $check0;?> /><?php _e( "Not Required", booking_xpress ); ?>
													</label>
												</td>
										<?php
											}
											else 
											{
										?>
												<td>
													<label class="radio">
														<input type="radio" disabled="disabled" id="bookingStatus_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="1" <?php echo $checked;?> /><?php _e( "Visible", booking_xpress ); ?>
													</label>&nbsp;&nbsp;
													<label class="radio">
														<input type="radio" disabled="disabled"id="bookingStatus1_<?php echo $flag;?>" name="bookingStatusSaved<?php echo $flag;?>" class="style" onchange="setaction(this)" value="0" <?php echo $check;?> /><?php _e( "Invisible", booking_xpress ); ?>
													</label>
												</td>
												<td>
													<label class="radio">
														<input type="radio" disabled="disabled" id="bookingRequiredOpen<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="1"   <?php echo $check1;?> /><?php _e( "Required", booking_xpress ); ?>
													</label>&nbsp;&nbsp;
													<label class="radio">
														<input type="radio" disabled="disabled" id="bookingRequiredClose<?php echo $flag;?>" name="bookingRequiredSaved<?php echo $flag;?>" class="style" value="0" <?php echo $check0;?> /><?php _e( "Not Required", booking_xpress ); ?>
													</label>
												</td>
											<?php
											}
											?>
									</tr>
									<?php
								}
									?>
						</tbody>
					</table>
					<button type="submit" class="green" style="margin-top:10px;">
						<span>
							<?php _e( "Submit & Save Changes", booking_xpress ); ?>	
						</span>
					</button>
				</form>			
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
<script type="text/javascript">
	jQuery("#BookingForm").attr("class","current");
	jQuery("#uxFrmbookingFormFields").validate
	({
		rules:
		{
			
		},
		submitHandler: function(form)
		{ 
			jQuery.post(ajaxurl, jQuery(form).serialize() + "&param=savedBookingForm&action=bookingFormLibrary", function(data) 
			{
				jQuery('#bookingFieldsSuccessMessage').css('display','block');
				setTimeout(function() 
				{
					jQuery('#bookingFieldsSuccessMessage').css('display','none');
					var checkPage = "<?php echo $_REQUEST['page']; ?>";
					window.location.href = "admin.php?page="+checkPage;
				}, 2000);
			});
		}
	});
	function setaction(e)
	{
		var t = e.id;	
		var radioid = t.split("_");
		value = e.value;	
		if(value == 0) 
		{
			jQuery('#bookingRequiredClose' + radioid[1]).attr("checked", "checked");
			jQuery('#bookingRequiredOpen' + radioid[1]).removeAttr("checked");
		} 
		else if(value == 1)
		{		
			jQuery('#bookingRequiredClose' + radioid[1]).removeAttr("checked");
			jQuery('#bookingRequiredOpen' + radioid[1]).attr("checked", "checked");
		}
	}
</script>