<?php
if (!current_user_can("edit_posts") && ! current_user_can("edit_pages"))
{
	return;
}
else 
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == 'savedBookingForm')
		{
			$bookingFeild = $wpdb->get_results
			(
				$wpdb->prepare
				(
					'SELECT * FROM '.bookingFormTable(),''
				)
			);
			for($start = 2; $start <= count($bookingFeild); $start++)
			{
				$bookingRadioVisible = intval($_REQUEST['bookingStatusSaved'.$start]);
				$bookingRadiooRequired = intval($_REQUEST['bookingRequiredSaved'.$start]);
				
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE ".bookingFormTable()." SET status = %d  WHERE BookingFormId = %d",
						$bookingRadioVisible,
						$bookingFeild[$start]->BookingFormId
					)
				);
				if($bookingRadioVisible == 0)
				{
					$wpdb->query
					(
						$wpdb->prepare
						(
							"UPDATE ".bookingFormTable()." SET required = %d  WHERE BookingFormId = %d",
							0,
							$bookingFeild[$start]->BookingFormId
						)
					);					
				}
				else
				{
					if ($bookingRadiooRequired == 1)
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE ".bookingFormTable()." SET required = %d  WHERE BookingFormId = %d",
								1,
								$bookingFeild[$start]->BookingFormId
							)
						);
						
					} 
					else 
					{
						$wpdb->query
						(
							$wpdb->prepare
							(
								"UPDATE ".bookingFormTable()." SET required = %d  WHERE BookingFormId = %d",
								0,
								$bookingFeild[$start]->BookingFormId
							)
						);
					}
				}
			}
		die();
		}
	}
}
?>