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
					<?php _e( "BOOKINGS", booking_xpress ); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<form name="uxbookingsForm" id="uxbookingsForm" class="form-horizontal" method="post" action="">
			<div class="box">
				<div class="title">
					<?php _e("Advanced Booking Filter", booking_xpress); ?>
					<span class="hide"></span>
				</div>
				<div class="content">
					<div class="row">
						<label><?php _e("Services", booking_xpress); ?></label>
						<?php
						$service = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"SELECT * FROM ".servicesTable()." order by ServiceName ASC",''
							)
						);
						?>
						<div class="right">
							<select name="uxDdlBookingServices" class="style required" id="uxDdlBookingServices" onchange="showServicesBooking();" style="width:50%">
								<option value ="0"><?php _e("All Services", booking_xpress); ?></option>
							<?php
								for($flagServicesDropdown = 0; $flagServicesDropdown < count($service); $flagServicesDropdown++)
								{
							?>
								<option value ="<?php echo $service[$flagServicesDropdown]->ServiceId;?>"><?php echo $service[$flagServicesDropdown]->ServiceName;?></option>
							<?php
								}
							?>
							</select>
						</div>
					</div>
					<div class="row">
						<label style="top:10px;"><?php _e("Bookings Status", booking_xpress); ?></label>
						<div class="right">
							<input type="checkbox" class="style" value="1" name="uxBookingStatus1" id="uxBookingStatus1" onclick="showServicesBooking();" checked="checked"/>&nbsp; &nbsp;<?php _e( "Pending Approval", booking_xpress ); ?>
							<input type="checkbox" class="style" value="1" name="uxBookingStatus2" id="uxBookingStatus2" onclick="showServicesBooking();" checked="checked" style="margin-left:10px;"/>&nbsp; &nbsp;<?php _e( "Approved", booking_xpress ); ?>
							<input type="checkbox" class="style" value="1" name="uxBookingStatus3" id="uxBookingStatus3" onclick="showServicesBooking();" checked="checked" style="margin-left:10px;"/>&nbsp; &nbsp;<?php _e( "Disapproved", booking_xpress ); ?>
							<input type="checkbox" class="style" value="1" name="uxBookingStatus4" id="uxBookingStatus4" onclick="showServicesBooking();" checked="checked" style="margin-left:10px;"/>&nbsp; &nbsp;<?php _e( "Cancelled", booking_xpress ); ?>
							<input type="checkbox" class="style" value="1" name="uxBookingStatus5" id="uxBookingStatus5" onclick="showServicesBooking();" checked="checked" style="margin-left:10px;"/>&nbsp; &nbsp;<?php _e( "Block Outs", booking_xpress ); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="box">
			<div class="title">
				<?php _e("Booking Calendar", booking_xpress); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<div id="calendar"></div>
				<div id="dynamicCalendar"></div>
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<div class="split">
		<?php _e( "&copy; 2013 Bookings-Xpress", booking_xpress ); ?>
	</div>
	<div class="split right">
		Powered by
		<a href="#" >
		<?php _e( "Bookings Xpress!", booking_xpress ); ?>
		</a>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
	jQuery("#Bookings").attr("class","current");
		//===== Calendar =====//
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
		var serviceId = jQuery('#uxDdlBookingServices').val();
		jQuery.post(ajaxurl,jQuery('#uxbookingsForm').serialize()+ "&serviceId="+serviceId+"&param=getBookings&action=bookingsCalendarLibrary", function(data)
		{
			jQuery('#dynamicCalendar').html(data);
		});
	}
	// oTable = jQuery('#services-table-grid').dataTable
	// ({
		// "bJQueryUI": false,
		// "bAutoWidth": true,
		// "sPaginationType": "full_numbers",
		// "sDom": 't<"datatable-footer"ip>',
		// "oLanguage": 
		// {
			// "sLengthMenu": "<span>Show entries:</span> _MENU_"
		// },
		// "aaSorting": [[ 3, "asc" ]]
	// });
</script>