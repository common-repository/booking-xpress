<?php
if (!current_user_can("edit_posts") && ! current_user_can("edit_pages"))
{
	return;
}
else 
{
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == 'reportABug')
		{
			$uxReportEmailAddress = esc_attr($_REQUEST['uxReportEmailAddress']);
			$uxReportSubject = esc_attr($_REQUEST['uxReportSubject']);
			$uxReportBug = html_entity_decode(esc_attr($_REQUEST['uxReportBug']));
			$to = "support@bookings-engine.com";
			$title=get_bloginfo('name');
			$headers= "From: " .$title. " <". $uxReportEmailAddress . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			$content = "
			<p>Email Address: ".$uxReportEmailAddress."
			</p><p>
			Bug: ".$uxReportBug."</p>";
			wp_mail($to,$uxReportSubject,$content,$headers);
			die();
		}
	}
}
?>