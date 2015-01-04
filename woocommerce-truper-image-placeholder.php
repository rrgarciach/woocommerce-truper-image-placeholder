<?php
/*
Plugin Name: DISTRIBUIDORA GC - TRUPER Image Placeholder
Plugin URI: http://developercats.com
Description: Plugin for WooCommerce to replace the default image placeholder for the TRUPER image.
Author: Ruy R. Garcia
Version: 1.0
Author URI: http://developercats.com
*/

add_action( 'init', 'custom_fix_thumbnail' );
 
function custom_fix_thumbnail() {
	add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
   
	function custom_woocommerce_placeholder_img_src( $src ) {
		global $product;
		$upload_dir = wp_upload_dir();
		$uploads = untrailingslashit( $upload_dir['baseurl'] );
		$src = 'http://www.truperenlinea.com/reng/info/fichas/img/ch/' . $product->get_sku() . '.jpg';

		if ( ! imageExists($src) ) {
			$src = WC()->plugin_url() . '/assets/images/placeholder.png';
		} else {
			// # @TODO Fix image size when none square source is provided. 
			// add_filter( 'woocommerce_get_image_size_shop_single', 'wptt_single_image_size' );
		}
		return $src;
	}

	// function wptt_single_image_size( $size ){
	//     $size['width'] = '150';
	//     $size['height'] = '150';
	//     return $size;		 
	// }

	function imageExists( $src ) {
		$file_headers = @get_headers($src);
		if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
			return false;
		}
		return true;
	}

}