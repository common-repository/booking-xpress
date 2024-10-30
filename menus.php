<div id="top">
	<h1 id="logo"></h1>
	<div id="menu">
		<ul class="sf-js-enabled">
			<li id="Dashboard">
				<a href="admin.php?page=booking_xpress">
					<?php _e( "Dashboard", booking_xpress ); ?>
				</a>
			</li> 
			<li id="Bookings">
				<a href="admin.php?page=bookings" >
					<?php _e( "Bookings", booking_xpress ); ?>
				</a>
			</li> 
			<li id="Services" class="">
				<a href="admin.php?page=display_services">
					<?php _e( "Services", booking_xpress ); ?>
				</a>
			</li>
			<li id="Coupons">
				<a href="admin.php?page=display_Coupons">
					<?php _e( "Coupons", booking_xpress ); ?>
				</a>
			</li>
			<li id="blockouts">
				<a href="admin.php?page=display_blockouts">
					<?php _e( "Block Outs", booking_xpress ); ?>
				</a>
			</li>
			<li id="Customers">
				<a href="admin.php?page=bookings_customers">
					<?php _e( "Clients", booking_xpress ); ?>
				</a>
			</li>
			<li id="BookingForm">
				<a href="admin.php?page=form_setup">
					<?php _e( "Form Setup", booking_xpress ); ?>
				</a>
			</li>
			<li id="EmailTemplate">
				<a href="admin.php?page=email_templates">
					<?php _e( "Email Templates", booking_xpress ); ?>
				</a>
			</li>
			<li id="ReportBug">
				<a href="admin.php?page=report_bugs">
					<?php _e( "Report a Bug", booking_xpress ); ?>
				</a>
			</li>
		</ul>
	</div>
</div>
<div id="left">
	<div class="box statics">
		<div class="content">
			<ul>
				<li>
					<h2><?php _e( "Overview Stats", booking_xpress ); ?></h2>
				</li>
				<li>
					<?php _e( "Total Bookings", booking_xpress ); ?>
					<div class="info red">
						<span id="uxDashboardBookingsCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total Services", booking_xpress ); ?>
					<div class="info blue">
						<span id="uxDashboardServiceCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total Clients", booking_xpress ); ?>
					<div class="info black">
						<span id="uxDashboardCustomersCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total Coupons", booking_xpress ); ?>
					<div class="info green">
						<span id="uxDashboardCouponsCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total BlockOuts", booking_xpress ); ?>
					<div class="info red">
						<span id="uxDashboardBlockOutsCount"></span>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="box statics">
		<div class="content">
			<ul>
				<li>
					<h2><?php _e( "Default Settings", booking_xpress ); ?></h2>
				</li>
				<div id="defaultSettingsArea" >	
				</div>
			</ul>
		</div>
	</div>	
	<div class="box statics">
		<div class="content">
			<ul>
				<li>
					<h2><?php _e( "Bookings Today", booking_xpress ); ?></h2>
				</li>
				<div id="recentBookingsContent" >
				</div>
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery.post(ajaxurl,"&param=getServiceCount&action=menuLibrary", function(data)
	{
		jQuery("#uxServiceCount").html(data);
		jQuery("#uxDashboardServiceCount").html(data);
	});
	jQuery.post(ajaxurl, "&param=getCustomerCount&action=menuLibrary", function(data)
	{
		jQuery("#uxCustomersCount").html(data);
		jQuery("#uxDashboardCustomersCount").html(data);
	});
	jQuery.post(ajaxurl, "&param=getBookingCount&action=menuLibrary", function(data)
	{
		jQuery("#uxBookingsCount").html(data);
		jQuery("#uxDashboardBookingsCount").html(data);
	});
	jQuery.post(ajaxurl, "&param=getCouponCount&action=menuLibrary", function(data)
	{
		jQuery("#uxCouponsCount").html(data);
		jQuery("#uxDashboardCouponsCount").html(data);
	});
	jQuery.post(ajaxurl, "&param=recentBookings&action=menuLibrary", function(data)
	{
		jQuery("#recentBookingsContent").html(data);
	});
	jQuery.post(ajaxurl, "&param=defaultSettingsArea&action=menuLibrary", function(data)
	{
		jQuery("#defaultSettingsArea").html(data);
	});
	jQuery.post(ajaxurl, "&param=getBlockOutsCount&action=menuLibrary", function(data)
	{
		jQuery("#uxBlockOutsCount").html(data);
		jQuery("#uxDashboardBlockOutsCount").html(data);
	});
</script>
