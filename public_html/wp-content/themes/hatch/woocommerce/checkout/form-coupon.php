<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! WC()->cart->coupons_enabled() ) {
	return;
}

/* MOD BY HGR */
$info_message = '<i class="fa fa-icon fa-tag" style="font-size:22px;margin-right:20px;"></i>';
$info_message .= apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', "hatch" ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', "hatch" ) . '</a>' );
wc_print_notice( $info_message, 'notice' );
?>

<form class="checkout_coupon" method="post" style="display:none">

	<p class="form-row form-row-first">
		<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_html_e( 'Coupon code', "hatch" ); ?>" id="coupon_code" value="" />
	</p>

	<p class="form-row form-row-last">
		<input type="submit" class="checkout_apply_coupon" name="apply_coupon" value="<?php esc_html_e( 'Apply Coupon', "hatch" ); ?>" />
	</p>

	<div class="clear"></div>
</form>