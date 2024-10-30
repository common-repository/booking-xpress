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
					<?php _e( "EMAIL TEMPLATES", booking_xpress ); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<div class="message green" id="PendingConfirmationSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", booking_xpress ); ?>
				</strong>
			</span>
		</div>
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"booking-pending-confirmation"
				)
			);
		?>
		<div class="box">
			<div class="title">
				<?php _e( "Approval Pending Email Template [Sent to Client]",booking_xpress ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmPendingConfirmationEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", booking_xpress ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxPendingConfirmationEmailTemplateSubject" value="<?php echo $result-> EmailSubject ;?>" id="uxPendingConfirmationEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", booking_xpress ); ?>
						</label>
						<div class="right">
							<?php
								$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxPendingConfirmationEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1);
							?>	
						</div>
					</div>	
					<div class="row" style="border-bottom:none">
						<div class="right">
							<button type="submit" class="green">
								<span>
									<?php _e("Submit & Save Changes", booking_xpress); ?>
								</span>
							</button>
						</div>
					</div>	
				</form>
			</div>
		</div>
		<div class="message green" id="ConfirmationSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", booking_xpress ); ?>
				</strong>
			</span>
		</div>
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"booking-confirmation"
				)
			);
		?>
		<div class="box">
			<div class="title">
				<?php _e( "Approved Email Template [Sent to Client]",booking_xpress ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmConfirmationEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", booking_xpress ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxConfirmationEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxConfirmationEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", booking_xpress ); ?>
						</label>
						<div class="right">
							<?php
								$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxConfirmationEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
							?>
						</div>
					</div>				
					<div class="row" style="border-bottom:none">
						<div class="right">
							<button type="submit" class="green">
								<span>
									<?php _e("Submit & Save Changes", booking_xpress); ?>
								</span>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="message green" id="BookingDeclinedSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", booking_xpress ); ?>
				</strong>
			</span>
		</div>
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"booking-disapproved"
				)
			);
		?>
		<div class="box">
			<div class="title">
				<?php _e( "Disapproved Email Template [Sent to Client]",booking_xpress ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmBookingDeclinedEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", booking_xpress ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxBookingDeclinedEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxBookingDeclinedEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", booking_xpress ); ?>
						</label>
						<div class="right">
							<?php
								$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxBookingDeclinedEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1);
							?>
						</div>
					</div>
					<div class="row" style="border-bottom:none">
						<div class="right">
							<button type="submit" class="green">
								<span>
									<?php _e("Submit & Save Changes", booking_xpress); ?>
								</span>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="message green" id="AdminApproveDisapproveSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", booking_xpress ); ?>
				</strong>
			</span>
		</div>
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"admin-control"
				)
			);
		?>
		<div class="box">
			<div class="title">
				<?php _e( "Approve/Disapprove Email Template [Sent to Admin]",booking_xpress ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmAdminApproveDisapproveEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", booking_xpress ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxAdminApproveDisapproveEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxAdminApproveDisapproveEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", booking_xpress ); ?>
						</label>
						<div class="right">
							<?php
								$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxAdminApproveDisapproveEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1); 
							?>
						</div>
					</div>
					<div class="row" style="border-bottom:none">
						<div class="right">
							<button type="submit" class="green">
								<span>
									<?php _e("Submit & Save Changes", booking_xpress); ?>
								</span>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="message green" id="PaypalAdminNotificationSuccess" style="display:none">
			<span>
				<strong>
					<?php _e( "Success! The Email has been saved.", booking_xpress ); ?>
				</strong>
			</span>
		</div>
		<?php
			$result = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".email_templatesTable()." where EmailType = %s",
					"paypal-payment-notification"
				)
			);
		?>		
		<div class="box">
			<div class="title">
				<?php _e( "Paypal Admin Notification Email Template [Sent to Admin]",booking_xpress ); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<form id="uxFrmPaypalAdminNotificationEmailTemplate" class="form-horizontal" method="post" action="#">
					<div class="row">
						<label>
							<?php _e( "Email Subject :", booking_xpress ); ?>
						</label>
						<div class="right">
							<input type="text" class="required span12"name="uxPaypalAdminNotificationEmailTemplateSubject" value="<?php echo $result->  EmailSubject ;?>" id="uxPaypalAdminNotificationEmailTemplateSubject"/>
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e( "Email Content :", booking_xpress ); ?>
						</label>
						<div class="right">
							<?php
								$content = stripslashes($result->EmailContent);
								wp_editor($content, $id = 'uxPaypalAdminNotificationEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 1);
							?>
						</div>
					</div>
					<div class="row" style="border-bottom:none">
						<div class="right">
							<button type="submit" class="green">
								<span>
									<?php _e("Submit & Save Changes", booking_xpress); ?>
								</span>
							</button>
						</div>
					</div>
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
<script>
	jQuery("#EmailTemplate").attr("class","current");
	jQuery("#uxFrmPendingConfirmationEmailTemplate").validate
	({
		submitHandler: function(form) 
		{ 
			var uxPendingConfirmationEmailTemplateSubject =  encodeURIComponent(jQuery("#uxPendingConfirmationEmailTemplateSubject").val());
			if (jQuery("#wp-uxPendingConfirmationEmailTemplate-wrap").hasClass("tmce-active"))
			{
				var uxPendingConfirmationEmailTemplate  = encodeURIComponent(tinyMCE.get('uxPendingConfirmationEmailTemplate').getContent());
			}
			else
			{
				var uxPendingConfirmationEmailTemplate  = encodeURIComponent(jQuery('#uxPendingConfirmationEmailTemplate').val());
			}	
			jQuery.post(ajaxurl, "uxPendingConfirmationEmailTemplate="+uxPendingConfirmationEmailTemplate+"&uxPendingConfirmationEmailTemplateSubject="+uxPendingConfirmationEmailTemplateSubject+"&param=updatePendingConfirmationEmailTemplate&action=emailLibrary", function(data) 
			{	
				jQuery('#PendingConfirmationSuccess').css('display','block');
				setTimeout(function() 
				{
					jQuery('#PendingConfirmationSuccess').css('display','none');
				},2000);
			});
		}
	});
	jQuery("#uxFrmConfirmationEmailTemplate").validate
	({
		submitHandler: function(form) 
		{ 
			var uxConfirmationEmailTemplateSubject = encodeURIComponent(jQuery("#uxConfirmationEmailTemplateSubject").val());
			if (jQuery("#wp-uxConfirmationEmailTemplate-wrap").hasClass("tmce-active"))
			{
				var uxConfirmationEmailTemplate = encodeURIComponent(tinyMCE.get('uxConfirmationEmailTemplate').getContent());
			}
			else
			{
				var uxConfirmationEmailTemplate = encodeURIComponent(jQuery('#uxConfirmationEmailTemplate').val());
			}	
			jQuery.post(ajaxurl, "uxConfirmationEmailTemplate="+uxConfirmationEmailTemplate+"&uxConfirmationEmailTemplateSubject="+uxConfirmationEmailTemplateSubject+"&param=updateConfirmationEmailTemplate&action=emailLibrary", function(data)
			{ 
				jQuery('#ConfirmationSuccess').css('display','block');
				setTimeout(function()
				{
					jQuery('#ConfirmationSuccess').css('display','none');
				}, 2000);
			});
		}
	});
	jQuery("#uxFrmBookingDeclinedEmailTemplate").validate
	({
		submitHandler: function(form) 
		{
			var uxBookingDeclinedEmailTemplateSubject = encodeURIComponent(jQuery("#uxBookingDeclinedEmailTemplateSubject").val());
			if (jQuery("#wp-uxBookingDeclinedEmailTemplate-wrap").hasClass("tmce-active"))
			{
				var uxBookingDeclinedEmailTemplate = encodeURIComponent(tinyMCE.get('uxBookingDeclinedEmailTemplate').getContent());
			}
			else
			{
				var uxBookingDeclinedEmailTemplate  = encodeURIComponent(jQuery('#uxBookingDeclinedEmailTemplate').val());
			}	
			jQuery.post(ajaxurl, "uxBookingDeclinedEmailTemplate="+uxBookingDeclinedEmailTemplate+"&uxBookingDeclinedEmailTemplateSubject="+uxBookingDeclinedEmailTemplateSubject+"&param=updateDeclinedEmailTemplate&action=emailLibrary", function(data)
			{	
				jQuery('#BookingDeclinedSuccess').css('display','block');
				setTimeout(function() 
				{
					jQuery('#BookingDeclinedSuccess').css('display','none');
				}, 2000);
			});
		}
	});
	jQuery("#uxFrmAdminApproveDisapproveEmailTemplate").validate
	({
		submitHandler: function(form)
		{	
			var uxAdminApproveDisapproveEmailTemplateSubject =  encodeURIComponent(jQuery("#uxAdminApproveDisapproveEmailTemplateSubject").val());
			if (jQuery("#wp-uxAdminApproveDisapproveEmailTemplate-wrap").hasClass("tmce-active"))
			{
				var uxAdminApproveDisapproveEmailTemplate  = encodeURIComponent(tinyMCE.get('uxAdminApproveDisapproveEmailTemplate').getContent());
			}
			else
			{
				var uxAdminApproveDisapproveEmailTemplate  = encodeURIComponent(jQuery('#uxAdminApproveDisapproveEmailTemplate').val());
			}	
			jQuery.post(ajaxurl, "uxAdminApproveDisapproveEmailTemplate="+uxAdminApproveDisapproveEmailTemplate+"&uxAdminApproveDisapproveEmailTemplateSubject="+uxAdminApproveDisapproveEmailTemplateSubject+"&param=updateAdminApproveDisapproveEmailTemplate&action=emailLibrary", function(data)
			{ 
				jQuery('#AdminApproveDisapproveSuccess').css('display','block');
				setTimeout(function() 
				{
					jQuery('#AdminApproveDisapproveSuccess').css('display','none');
				}, 2000);
			});
		}
	});	
	jQuery("#uxFrmPaypalAdminNotificationEmailTemplate").validate
	({
		submitHandler: function(form) 
		{
			var uxPaypalAdminNotificationEmailTemplateSubject = encodeURIComponent(jQuery("#uxPaypalAdminNotificationEmailTemplateSubject").val());
			if (jQuery("#wp-uxPaypalAdminNotificationEmailTemplate-wrap").hasClass("tmce-active"))
			{
				var uxPaypalAdminNotificationEmailTemplate  = encodeURIComponent(tinyMCE.get('uxPaypalAdminNotificationEmailTemplate').getContent());
			}
			else
			{
				var uxPaypalAdminNotificationEmailTemplate  = encodeURIComponent(jQuery('#uxPaypalAdminNotificationEmailTemplate').val());
			}
			jQuery.post(ajaxurl, "uxPaypalAdminNotificationEmailTemplate="+uxPaypalAdminNotificationEmailTemplate+"&uxPaypalAdminNotificationEmailTemplateSubject="+uxPaypalAdminNotificationEmailTemplateSubject+"&param=updatePaypalAdminNotificationEmailTemplate&action=emailLibrary", function(data)
			{
				jQuery('#PaypalAdminNotificationSuccess').css('display','block');
				setTimeout(function() 
				{
					jQuery('#PaypalAdminNotificationSuccess').css('display','none');
				}, 2000);
			});
		}
	});
</script>