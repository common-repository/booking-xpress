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
					<?php _e( "CLIENTS", booking_xpress); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<div class="box">
			<div class="title">
				<?php _e("Clients", booking_xpress); ?>
				<span class="hide">
				</span>
			</div>
			<div class="content">
				<table class="table table-striped" id="data-table-clients">
					<thead>
						<tr>
							<th style="width:15%"><?php _e( "First Name", booking_xpress ); ?></th>
							<th style="width:15%"><?php _e( "Last Name", booking_xpress ); ?></th>
							<th style="width:15%"><?php _e( "Email Address", booking_xpress ); ?></th>
							<th style="width:15%"><?php _e( "Mobile", booking_xpress ); ?></th>
							<th style="width:10%"><?php _e( "City", booking_xpress ); ?></th>
							<th style="width:15%"><?php _e( "Country", booking_xpress ); ?></th>
							<th style="width:18%"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$paypalEnable = $wpdb->get_var('SELECT PaymentGatewayValue FROM '.payment_Gateway_settingsTable().' WHERE PaymentGatewayKey = "paypal-enabled"');
						$customers = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"SELECT * FROM ".customersTable()." LEFT OUTER JOIN ".countriesTable()." on ".customersTable().".CustomerCountry = ".countriesTable().".CountryId","" 
							)
						);
						for($flag=0; $flag < count($customers); $flag++)
						{
						?>
							<tr>
								<td><?php echo $customers[$flag] -> CustomerFirstName;?></td>
								<td><?php echo $customers[$flag] -> CustomerLastName;?></td>
								<td><?php echo $customers[$flag] -> CustomerEmail;?></td>
								<td><?php echo $customers[$flag] -> CustomerMobile;?></td>
								<td><?php echo $customers[$flag] -> CustomerCity;?></td>
								<td><?php echo $customers[$flag] -> CountryName;?></td>
								<td>
									<a class="icon-edit hovertip inline"  data-original-title="<?php _e("Edit Client?", booking_xpress ); ?>" data-placement="top" href="#EditCustomerDiv" onclick="editCustomers(<?php echo $customers[$flag]->CustomerId;?>);"></a>&nbsp;&nbsp;
									<?php
									if($paypalEnable == 1)
									{
									?>
										<a class="icon-shopping-cart hovertip inline" data-original-title="<?php _e("Payment Details", booking_xpress ); ?>" data-placement="top" href="#paypalDetails" onclick="customerPaypalBookingdetails(<?php echo $customers[$flag]->CustomerId;?>)"></a>&nbsp;&nbsp;
									<?php
									}
									?>
									<a class="icon-calendar hovertip inline" data-original-title="<?php _e("Booking Details", booking_xpress ); ?>" data-placement="top"  href="#manageBookings" onclick="customerBookingdetails(<?php echo $customers[$flag]->CustomerId;?>)" ></a>&nbsp;&nbsp;
									<a class="icon-trash hovertip"  data-toggle="modal" data-original-title="<?php _e("Delete Client", booking_xpress ); ?>" data-placement="top"   onclick="deleteCustomer(<?php echo $customers[$flag]->CustomerId;?>)"></a>	
								</td>
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
<div style="display: none">
	<div id="EditCustomerDiv">
		<div class="message green" id="UpdatesuccessMessage" style="display:none;margin-left:10px;">
			<span>
				<strong>
					<?php _e( "Success! The Customer has been Updated.", booking_xpress ); ?>	
				</strong>
			</span>
		</div>
		<form id="uxFrmEditCustomers" class="form-horizontal" method="post" action="#">
			<div class="block well" style="margin:10px">
				<div class="body">
					<div class="box">
						<div class="content"  id="EditClientsData">
						</div>
						</div>
					<input type="hidden" id="customerHiddenId" value="10" />
				</div>
			</div>
			<div style="border-bottom:!important">
				<button type="submit" class="green" style="margin-top:10px;">
					<span>
						<?php _e( "Submit & Save Changes", booking_xpress ); ?>
					</span>
				</button>
			</div>
		</form>
	</div>	
</div>
<div style="display: none">
	<div id="manageBookings">
		<form id="uxFrmManageBookings" class="form-horizontal" method="post" action="#">
			<div class="block well" style="margin:10px">
				<div class="body">
					<div class="table-overflow" id="table-customer-bookings">
					</div>
				</div>
			</div>	
		</form>
	</div>
</div>
<div style="display: none">
	<div id="paypalDetails">	
		<form id="uxFrmPaypalDetails" class="form-horizontal" method="post" action="#">
			<div class="block well" style="margin:10px">
				<div class="body">
					<div class="table-overflow" id="paypal-table">
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div id="customerEmail" class="modal1 hide fade" role="dialog" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3>
			<?php _e( "Email Customer ", booking_xpress ); ?> - 
			<strong id="CustomerSendEmail"></strong>
		</h3>
	</div>
	<div class="message green" id="customerEmailSuccessMessage" style="display:none;margin-left:10px;">
		<span>
			<strong>
				<?php _e( "Success! Email has been sent.", booking_xpress ); ?>
			</strong>
		</span>
	</div>
	<form id="uxFrmCustomerDirectEmail" class="form-horizontal" method="post" action="#">
		<div class="block well" style="margin:10px">
			<div class="body">
				<div class="row">
					<label class="control-label">
						<?php _e( "Email Subject :", booking_xpress ); ?>
					</label>
					<div class="right">
						<input type="text" class="required" name="uxFrmCustomerEmailSubject" id="uxFrmCustomerEmailSubject"/>
					</div>
				</div>
				<div class="row">
					<label class="control-label">
						<?php _e( "Email Content :", booking_xpress ); ?>
					</label>
					<div class="right">
						<?php
							wp_editor("", $id = 'uxFrmCustomerEmailTemplate', $prev_id = 'title', $media_buttons = true, $tab_index = 2);
						?>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" id="CustomerId" value="" />
		<div style="padding:0px 20px 10px 0px;float:right">
			<button type="submit" class="red" style="margin-top:10px;">
				<span>
					<?php _e( "Send Email", booking_xpress ); ?>
				</span>
			</button>
		</div>
	</form>
	<style type="text/css">
		#uxFrmCustomerEmailTemplate_ifr{height:250px !important;}
	</style>
</div>
<script type="text/javascript">
	jQuery(".inline").colorbox({inline:true, width:"700px"});
	jQuery("#Customers").attr("class","current");
	jQuery('#btnEditClient').click(function ()
	{
		var btn = jQuery(this)
		btn.button('loading')
		setTimeout(function ()
		{
			btn.button('reset')
		}, 1000);
	});
	var uri = "<?php echo $url; ?>";
	oTable = jQuery('#data-table-clients').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
		"oLanguage": 
		{
			"sLengthMenu": "_MENU_"
		}
	});
	function editCustomers(CustomerId)
	{
		jQuery.post(ajaxurl, "CustomerId="+CustomerId+"&param=editcustomers&action=clientLibrary", function(data)
		{
			jQuery("#EditClientsData").html(data);
			jQuery('#customerHiddenId').val(jQuery('#hiddenCustomerId').val());
			jQuery.colorbox.resize();
		}); 
	}
	jQuery("#uxFrmEditCustomers").validate
	({
		rules:
		{
			uxEditFirstName: "required",
			uxEditLastName: "required",
			uxEditEmailAddress: 
			{
				required:true,
				email:true
			},
			uxEditTelephoneNumber:
			{
				required:false
			},
			uxEditMobileNumber:
			{
				required:false
			},
			uxEditSkypeId:
			{
			required:false
			},
			uxEditAddress1:
			{
				required:false
			},
			uxEditAddress2:
			{
				required:false
			},
			uxEditCity:
			{
				required:false
			},
			uxEditPostalCode:
			{
				required:false
			},			
			uxEditCountry:
			{
				required:false
			},
			uxEditComments:
			{
				required:false
			},
		},
		highlight: function(label) 
		{
			if(jQuery(label).closest('.control-group').hasClass('success'))
			{
				jQuery.colorbox.resize();
			jQuery(label).closest('.control-group').removeClass('success');
			}
			jQuery(label).closest('.control-group').addClass('errors');
			jQuery.colorbox.resize();
		},
		success: function(label)
		{
			label
			.text('Success!').addClass('valid')
			.closest('.control-group').addClass('success');
			jQuery.colorbox.resize();
		},
		submitHandler: function(form) 
		{
			var customerHiddenId = jQuery('#customerHiddenId').val();
			jQuery.post(ajaxurl, jQuery(form).serialize() + "&customerHiddenId="+customerHiddenId+"&param=updatecustomers&action=clientLibrary", function(data)
			{
				jQuery('#UpdatesuccessMessage').css('display','block');
				jQuery.colorbox.resize();
				setTimeout(function() 
				{
					jQuery('#UpdatesuccessMessage').css('display','none');
					jQuery.colorbox.resize();
					var checkPage = "<?php echo $_REQUEST['page']; ?>";
					window.location.href = "admin.php?page="+checkPage;
				}, 2000);
			});
		}
	});
	function deleteCustomer(CustomerId) 
	{
	bootbox.confirm('<?php _e( "Are you sure you want to delete this Client?", booking_xpress ); ?>', function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.post(ajaxurl, "uxcustomerId="+CustomerId+"&param=DeleteCustomer&action=clientLibrary", function(data)
				{
					var checkExist = jQuery.trim(data);
					if(checkExist == "bookingExist")
					{
						bootbox.alert('<?php _e("You cannot delete this Customer until all Bookings have been deleted.", booking_xpress ); ?>');
					}
					else
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}
				});
			}
		});
	}
	jQuery(".inline").colorbox({inline:true, width:"700px"});
	function customerBookingdetails(CustomerId)
	{
		jQuery.post(ajaxurl, "CustomerId="+CustomerId+"&param=customerBooking&action=clientLibrary", function(data)
		{
			jQuery('#table-customer-bookings').html(data);
			jQuery('#CustomerBookingsSchedule').html(jQuery('#customerNameForBooking').val());
			oTable = jQuery('#data-table-customer-bookings').dataTable
			({
				"bJQueryUI": false,
				"bAutoWidth": true,
				"bDestroy": true,
				"sPaginationType": "full_numbers",
				"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
				"oLanguage": 
				{
					"sLengthMenu": "_MENU_"
				}
			});
			jQuery.colorbox.resize();
		});
	}
	function customerPaypalBookingdetails(id)
	{
		jQuery.post(ajaxurl, "customerId="+id+"&param=customerPaypalBooking&action=clientLibrary", function(data)
		{	
			jQuery('#paypal-table').html(data);
			jQuery('#CustomerPaymentSchedule').html(jQuery('#customerNamePayment').val());
			oTable = jQuery('#data-table-paypal-bookings').dataTable
			({
				"bJQueryUI": false,
				"bAutoWidth": true,
				"sPaginationType": "full_numbers",
				"oLanguage":
				{
					"sLengthMenu": "_MENU_"
				}
			});
			jQuery.colorbox.resize();
		});
	}
	jQuery(".inline").colorbox({inline:true, width:"700px"});
	function deleteCustomerBooking(bookingId)
	{
		bootbox.confirm('<?php _e( "Are you sure you want to delete this Booking?", booking_xpress ); ?>', function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.post(ajaxurl, "bookingId="+bookingId+"&param=deleteCustomerBookings&action=clientLibrary", function(data)
				{
					var checkPage = "<?php echo $_REQUEST['page']; ?>";
					window.location.href = "admin.php?page="+checkPage;
					jQuery.colorbox.resize();
				});
			}
		});
	}
	function customerBookingComments(bookingId)
	{
		jQuery.post(ajaxurl, "bookingId="+bookingId+"&param=customerBookingCommentsId&action=clientLibrary", function(data)
		{
			jQuery('#hiddenBookingId').val(bookingId);
			jQuery('#uxCustomerComments').val(data);
		});
	}
</script>