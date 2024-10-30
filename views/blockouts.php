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
						<?php _e( "BLOCKOUTS", booking_xpress ); ?>
					</a>
				</li>
			</ul>
		</div>
		<div class="section">
			<div class="box">
				
				<div class="title">
					<?php _e("Block Outs", booking_xpress); ?>
					<span class="hide"></span>
				</div>
				<div class="content">
					<table class="table table-striped" id="data-table-blockOuts">
	 					<thead>
							<tr>
								<th  style="width:25%">
									<?php _e( "Service", booking_xpress ); ?>
								</th>
								<th>
									<?php _e( "Block Outs", booking_xpress ); ?>
								</th>
								<th style="width:8%"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$dateFormat = $wpdb->get_var
								(
									$wpdb->prepare
									(
										'SELECT GeneralSettingsValue FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s ',
										"default_Date_Format"
									)
								);
								$timeFormats = $wpdb -> get_var
								(
									$wpdb->prepare
									(	
										'SELECT  GeneralSettingsValue   FROM ' . generalSettingsTable() . ' where GeneralSettingsKey = %s',
										"default_Time_Format"
									)
								);
								$blockouts = $wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT * From ".block_outs() . " join " . servicesTable() . " on " .block_outs() .".ServiceId = " . servicesTable() . ".ServiceId",""
									)
								);
								for($flagBlock =0; $flagBlock < count($blockouts); $flagBlock++)
								{
									?>
									<tr>
										<td>
											<?php echo $blockouts[$flagBlock]->ServiceName; ?>
										</td>
										<td>
											<?php
											if($dateFormat == 0)
											{
												$StartDate = date("M d, Y", strtotime($blockouts[$flagBlock]->StartDate));
												$EndDate = date("M d, Y", strtotime($blockouts[$flagBlock]->EndDate));
											}
											else if($dateFormat == 1)
											{
												$StartDate = date("Y/m/d", strtotime($blockouts[$flagBlock]->StartDate));
												$EndDate = date("Y/m/d", strtotime($blockouts[$flagBlock]->EndDate));
											}	
											else if($dateFormat == 2)
											{
												$StartDate = date("m/d/Y", strtotime($blockouts[$flagBlock]->StartDate));
												$EndDate = date("m/d/Y", strtotime($blockouts[$flagBlock]->EndDate));
											}	
											else if($dateFormat == 3)
											{
												$StartDate = date("d/m/Y", strtotime($blockouts[$flagBlock]->StartDate));
												$EndDate = date("d/m/Y", strtotime($blockouts[$flagBlock]->EndDate));
											}
												if($blockouts[$flagBlock]->Repeats == 0)
												{
													if($blockouts[$flagBlock]->FullDayBlockOuts == 1)
													{
														if($blockouts[$flagBlock]->RepeatEvery == 1)
														{
															if($blockouts[$flagBlock]->EndDate == 0)
															{
																_e( "Daily with full day Block Outs from ", booking_xpress ) ._e($StartDate,booking_xpress)."</br></br>";
															}
															else 
															{
																_e( "Daily with full day Block Outs from ", booking_xpress ) ._e($StartDate,'booking_xpress').
																_e( " upto ", booking_xpress )._e($EndDate,'booking_xpress')."</br></br>";
															}
														}
														else
														{
															if($blockouts[$flagBlock]->EndDate == 0)
															{
																_e( "Every ", booking_xpress ). _e($blockouts[$flagBlock]->RepeatEvery,'booking_xpress') . 
																_e( " days with full day Block Outs from ", booking_xpress ) ._e($StartDate,'booking_xpress')."</br></br>";
															}
															else 
															{
																_e( "Every ", booking_xpress ). _e($blockouts[$flagBlock]->RepeatEvery,'booking_xpress') . 
																_e( " days with full day Block Outs from ", booking_xpress ) ._e($StartDate,'booking_xpress').
																_e( " upto ", booking_xpress )._e($EndDate,'booking_xpress')."</br></br>";
															}	
														}
													}
													else 
													{
														$getHours_block = floor(($blockouts[$flagBlock] -> StartTime)/60);
														$getMins_block = ($blockouts[$flagBlock] -> StartTime) % 60;
														$hourFormat_blockouts = $getHours_block . ":" . $getMins_block;
														if($timeFormats == 0)
														{
															$time_in_12_hour_format_blockouts  = DATE("h:i A", STRTOTIME($hourFormat_blockouts)); 
														}
														else 
														{
															$time_in_12_hour_format_blockouts  = DATE("H:i", STRTOTIME($hourFormat_blockouts));
														}
														$getHours_blockout = floor(($blockouts[$flagBlock] -> EndTime)/60);
														$getMins_blockout = ($blockouts[$flagBlock] -> EndTime) % 60;
														$hourFormat_blockout = $getHours_blockout . ":" . $getMins_blockout;
														if($timeFormats == 0)
														{
															$time_in_12_hour_format_blockout  = DATE("h:i A", STRTOTIME($hourFormat_blockout)); 
														}
														else 
														{
															$time_in_12_hour_format_blockout = DATE("H:i", STRTOTIME($hourFormat_blockout));
														}
														if($blockouts[$flagBlock]->RepeatEvery == 1)
														{
															if($blockouts[$flagBlock]->EndDate == 0)
															{
																_e( "Daily from ", booking_xpress ) . _e($StartDate,'booking_xpress').
																_e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,'booking_xpress').
																_e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,'booking_xpress')."</br></br>";
															}
															else 
															{
																_e( "Daily from ", booking_xpress ) . _e($StartDate,'booking_xpress').
																_e( " upto ", booking_xpress )._e($EndDate,'booking_xpress').
																_e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,'booking_xpress').
																_e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,'booking_xpress')."</br></br>";
															}
														}
														else
														{
															if($blockouts[$flagBlock]->EndDate == 0)
															{
																_e( "Every ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatEvery,'booking_xpress')._e( " days from ", booking_xpress ).
																_e($StartDate,'booking_xpress')._e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,'booking_xpress').
																_e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,'booking_xpress')."</br></br>";
															}
															else {
																_e( "Every ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatEvery,'booking_xpress')._e( " days from ", booking_xpress ).
																_e($StartDate,'booking_xpress')._e( " upto ", booking_xpress )._e($EndDate,'booking_xpress').
																_e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,'booking_xpress').
																_e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,'booking_xpress')."</br></br>";
															}
														}
														
													}
												}
												if($blockouts[$flagBlock]->Repeats == 1)
												{
													if($blockouts[$flagBlock]->FullDayBlockOuts == 1)
													{
														if($blockouts[$flagBlock]->RepeatEvery == 1)
														{
															if($blockouts[$flagBlock]->EndDate == 0)
															{
																_e( "Weekly with full day Block Outs on ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatDays,'booking_xpress').
																_e( " from ", booking_xpress ) ._e($StartDate,'booking_xpress')."</br></br>";
															}
															else 
															{
																_e( "Weekly with full day Block Outs on ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatDays,'booking_xpress').
																_e( " from ", booking_xpress ) ._e($StartDate,'booking_xpress').
																_e( " upto ", booking_xpress )._e($EndDate,'booking_xpress')."</br></br>";
															}
														}
														else
														{
															if($blockouts[$flagBlock]->EndDate == 0)
															{
																_e( "Every ", booking_xpress ). _e($blockouts[$flagBlock]->RepeatEvery,'booking_xpress') .
																_e( " weeks on ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatDays,'booking_xpress').
																_e( " with full day Block Outs from ", booking_xpress ) ._e($StartDate,'booking_xpress').
																"</br></br>";	
															}
															else
															{
																_e( "Every ", booking_xpress ). _e($blockouts[$flagBlock]->RepeatEvery,'booking_xpress') .
																_e( " weeks on ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatDays,'booking_xpress').
																_e( " with full day Block Outs from ", booking_xpress ) ._e($StartDate,'booking_xpress').
																_e( " upto ", booking_xpress )._e($EndDate,'booking_xpress')."</br></br>";
															}
														}
													}
													else 
													{
														$getHours_block = floor(($blockouts[$flagBlock] -> StartTime)/60);
														$getMins_block = ($blockouts[$flagBlock] -> StartTime) % 60;
														$hourFormat_blockouts = $getHours_block . ":" . $getMins_block;
														if($timeFormats == 0)
														{
															$time_in_12_hour_format_blockouts  = DATE("h:i A", STRTOTIME($hourFormat_blockouts));
														}
														else 
														{
															$time_in_12_hour_format_blockouts  = DATE("H:i", STRTOTIME($hourFormat_blockouts));
														}
														$getHours_blockout = floor(($blockouts[$flagBlock] -> EndTime)/60);
														$getMins_blockout = ($blockouts[$flagBlock] -> EndTime) % 60;
														$hourFormat_blockout = $getHours_blockout . ":" . $getMins_blockout;
														if($timeFormats == 0)
														{
															$time_in_12_hour_format_blockout  = DATE("h:i A", STRTOTIME($hourFormat_blockout));
														}
														else 
														{
															$time_in_12_hour_format_blockout = DATE("H:i", STRTOTIME($hourFormat_blockout));
														}
														if($blockouts[$flagBlock]->RepeatEvery == 1)
														{
															if($blockouts[$flagBlock]->RepeatDays == NULL)
															{
																if($blockouts[$flagBlock]->EndDate == 0)
																{
																	_e( "Weekly from ", booking_xpress )._e($StartDate,booking_xpress).
																	_e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,booking_xpress).
																	_e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout, booking_xpress)."</br></br>";
																}
																else 
																{
																	_e( "Weekly from ", booking_xpress )._e($StartDate,booking_xpress).
																	_e( " upto ", booking_xpress )._e($EndDate,booking_xpress).
																	_e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,booking_xpress).
																	_e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,booking_xpress)."</br></br>";
																}
															}
															else
															{
																if($blockouts[$flagBlock]->EndDate == 0)
																{
																	_e( "Weekly on ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatDays,booking_xpress)._e( " from ", booking_xpress ).
																	_e($StartDate,booking_xpress)._e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,booking_xpress).
																	_e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,booking_xpress)."</br></br>";
																}
																else
																{
																	_e( "Weekly on ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatDays,booking_xpress)._e( " from ", booking_xpress ).
																	_e($StartDate,'booking_xpress') . _e( " upto ", booking_xpress )._e($EndDate,booking_xpress).
																	_e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,booking_xpress)._e( " till ", booking_xpress ).
																	_e($time_in_12_hour_format_blockout,booking_xpress)."</br></br>";
																}
															}
															
														}
														else
														{
															if($blockouts[$flagBlock]->RepeatDays == NULL)
															{
																if($blockouts[$flagBlock]->EndDate == 0)
																{
																	_e( "Every ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatEvery,booking_xpress)._e( " weeks from ", booking_xpress )._e($StartDate,booking_xpress).
																	_e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,booking_xpress).
																	_e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,booking_xpress)."</br></br>";
																}
																else 
																{
																	_e( "Every ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatEvery,booking_xpress)._e( " weeks from ", booking_xpress )._e($StartDate,booking_xpress).
																	_e( " upto ", booking_xpress )._e($EndDate,booking_xpress)._e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,booking_xpress).
																	_e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,booking_xpress)."</br></br>";
																}
															}
															else
															{
																if($blockouts[$flagBlock]->EndDate == 0)
																{
																	_e( "Every ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatEvery,booking_xpress)._e( " weeks on ", booking_xpress )._e($blockouts[$flagBlock]->RepeatDays,booking_xpress).
																	_e( " from ", booking_xpress ) ._e($StartDate,booking_xpress).
																	_e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,booking_xpress)._e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,booking_xpress)."</br></br>";
																}
																else
																{
																	_e( "Every ", booking_xpress ) ._e($blockouts[$flagBlock]->RepeatEvery,booking_xpress)._e( " weeks on ", booking_xpress )._e($blockouts[$flagBlock]->RepeatDays,booking_xpress).
																	_e( " from ", booking_xpress ) ._e($StartDate,booking_xpress)._e( " upto ", booking_xpress )._e($EndDate,booking_xpress).
																	_e( " starting from ", booking_xpress )._e($time_in_12_hour_format_blockouts,booking_xpress)._e( " till ", booking_xpress )._e($time_in_12_hour_format_blockout,booking_xpress)."</br></br>";
																}
															}
														}
													}
												}
												?>
											</td>
											<td>
												<a class="icon-trash hovertip"  data-toggle="modal" data-original-title="<?php _e("Delete Block Out", booking_xpress ); ?>" data-placement="top" onclick="deleteblockOut(<?php echo $blockouts[$flagBlock]->RepeatId;?>)"></a>
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
<script type="text/javascript">
	jQuery("#blockouts").attr("class","current"); 
	oTable = jQuery('#data-table-blockOuts').dataTable
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
	function deleteblockOut(RepeatId)
	{
		bootbox.confirm('<?php _e("Are you sure you want to delete this Block Out?", booking_xpress ); ?>', function(confirmed) 
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.post(ajaxurl, "RepeatId="+RepeatId+"&param=deleteBlockOut&action=blockoutLibrary", function(data) 
				{
					var checkPage = "<?php echo $_REQUEST['page']; ?>";
					window.location.href = "admin.php?page="+checkPage;
				});
			}
		});
	}
</script>