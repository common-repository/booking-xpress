<?php
if (!current_user_can("edit_posts") && ! current_user_can("edit_pages") )
{
	return;
}
else
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == "updatePendingConfirmationEmailTemplate")
		{
			$PendingConfirmationEmailTemplateSubject = esc_attr(stripslashes($_REQUEST['uxPendingConfirmationEmailTemplateSubject']));
			$PendingConfirmationEmailTemplateContent = html_entity_decode($_REQUEST['uxPendingConfirmationEmailTemplate']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$PendingConfirmationEmailTemplateSubject,
					$PendingConfirmationEmailTemplateContent,
					"booking-pending-confirmation"
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "updateConfirmationEmailTemplate")
		{
			$ConfirmationEmailTemplateSubject = esc_attr(stripslashes($_REQUEST['uxConfirmationEmailTemplateSubject']));
			$ConfirmationEmailTemplateContent = html_entity_decode($_REQUEST['uxConfirmationEmailTemplate']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$ConfirmationEmailTemplateSubject,
					$ConfirmationEmailTemplateContent,
					"booking-confirmation"
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "updateDeclinedEmailTemplate")
		{
			$DeclineEmailTemplateSubject = esc_attr(stripslashes($_REQUEST['uxBookingDeclinedEmailTemplateSubject']));
			$DeclineEmailTemplateContent = html_entity_decode($_REQUEST['uxBookingDeclinedEmailTemplate']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$DeclineEmailTemplateSubject,
					$DeclineEmailTemplateContent,
					"booking-disapproved"
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "updateAdminApproveDisapproveEmailTemplate")
		{
			$AdminApproveDisapproveEmailTemplateSubject = esc_attr(stripslashes($_REQUEST['uxAdminApproveDisapproveEmailTemplateSubject']));
			$AdminApproveDisapproveEmailTemplateContent = html_entity_decode($_REQUEST['uxAdminApproveDisapproveEmailTemplate']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$AdminApproveDisapproveEmailTemplateSubject,
					$AdminApproveDisapproveEmailTemplateContent,
					"admin-control"
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "updatePaypalAdminNotificationEmailTemplate")
		{
			$PaypalAdminNotificationEmailTemplateSubject = esc_attr(stripslashes($_REQUEST['uxPaypalAdminNotificationEmailTemplateSubject']));
			$PaypalAdminNotificationEmailTemplateContent = html_entity_decode($_REQUEST['uxPaypalAdminNotificationEmailTemplate']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".email_templatesTable()." SET EmailSubject = %s, EmailContent = %s  WHERE EmailType = %s",
					$PaypalAdminNotificationEmailTemplateSubject,
					$PaypalAdminNotificationEmailTemplateContent,
					"paypal-payment-notification"
				)
			);
			die();
		}
	}
}
?>