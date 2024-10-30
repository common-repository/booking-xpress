
<div id="right">
	
	<div class="section">
		<div class="box">
			<!-- <div class="title">
				<?php _e("Monthly Calendar", booking_xpress); ?>
				<span class="hide"></span>
			</div> -->
			<div class="content">
				<div id="calendar"></div>
				<div id="dynamicCalendar"></div>
			</div>
		</div>
	</div>
</div>
<!-- <div id="footer">
	<div class="split">
		<?php _e( "&copy; 2013 Bookings-Xpress", booking_xpress ); ?>
	</div>
	<div class="split right">
		<?php _e( "Powered by ", booking_xpress ); ?>
		<a href="#" >
		<?php _e( "Bookings Xpress!", booking_xpress ); ?>
		</a>
	</div>
</div> -->
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	jQuery("#Bookings").attr("class","current");
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	jQuery(document).ready(function()
	{
		showServicesBooking();
	});
	function showServicesBooking()
	{
		
		jQuery.post(ajaxurl,  "&param=getCalander&action=fullcalendarLibrary", function(data)
		{
			jQuery('#dynamicCalendar').html(data);
			jQuery.colorbox.resize();
		});
	}
</script>
