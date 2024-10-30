<?php
global $wpdb;
if (!current_user_can("edit_posts") && ! current_user_can("edit_pages"))
{
	return;
}
else
{
	if(isset($_REQUEST["param"]))
	{
		if($_REQUEST["param"] == "checkExistingCoupons")
		{
			$uxDefaultCoupon = esc_attr($_REQUEST["uxDefaultCoupon"]);
			$countName = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT count(couponId) FROM " . coupons() . " WHERE couponName = %s",
					$uxDefaultCoupon
				)
			);
			echo $countName;
			die();
		}
		else if($_REQUEST["param"] == "addCoupons")
		{
			$uxDefaultCoupon = esc_attr($_REQUEST["uxDefaultCoupon"]);
			$uxValidFrom = esc_attr($_REQUEST["uxValidFrom"]);
			$uxValidUpto = esc_attr($_REQUEST["uxValidUpto"]);
			$uxAmount = doubleval($_REQUEST["uxAmount"]);
			$uxDdlAmountType = intval($_REQUEST["uxDdlAmountType"]);
			$uxApplicableOnAllProducts = esc_attr($_REQUEST["uxApplicableOnAllProducts"]);
			$uxDdlBookingServices = esc_attr($_REQUEST["selectedvalue"]);
			$couponStatus = 1;
			if($uxApplicableOnAllProducts == "true")
			{
				$uxAppForAllPro = 1;
			}
			else
			{
				$uxAppForAllPro = 0;
			}
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".coupons()."(couponName,couponValidFrom,couponValidUpto,Amount,amountType,couponApplicable,couponStatus)
					VALUES(%s,%s,%s,%f,%d,%d,%s)",
					$uxDefaultCoupon,
					$uxValidFrom,
					$uxValidUpto,
					$uxAmount,
					$uxDdlAmountType,
					$uxAppForAllPro,
					$couponStatus,
					$uxDdlBookingServices
				)
			);
			echo $lastid = $wpdb->insert_id;
			die();
		}
		else if($_REQUEST["param"]== "addCouponsProducts")
		{
			$tmp1 = intval($_REQUEST["tmp1"]);
			$uxcouponid = intval($_REQUEST["uxcouponid"]);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO ".coupons_products()."(couponId,serviceId) VALUES(%d,%d)",
					$uxcouponid,$tmp1
				)
			);
			die();
		}
		else if($_REQUEST["param"] == "deleteCoupon")
		{
			$couponId = intval($_REQUEST["couponId"]);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE FROM ". coupons(). " WHERE couponId = %d",
					$couponId
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE FROM ".coupons_products()." WHERE couponId = %d",
					$couponId
				)
			);
			die();
		}
	}
}
?>