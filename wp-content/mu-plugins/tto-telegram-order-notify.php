<?php
/**
 * Plugin Name: TTO Telegram Order Notifications
 * Description: Sends new WooCommerce order details to admin Telegram via bot.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'TTO_TG_BOT_TOKEN', '8719393506:AAFTZPGvYwacydiNnKL1Fk6kp29jLYyflBA' );
define( 'TTO_TG_CHAT_ID',   '-1003962382996' );

add_action( 'woocommerce_checkout_order_processed', 'tto_tg_notify_new_order', 20, 1 );
add_action( 'woocommerce_store_api_checkout_order_processed', 'tto_tg_notify_new_order', 20, 1 );

function tto_tg_notify_new_order( $order_id ) {
	if ( is_object( $order_id ) ) { $order = $order_id; $order_id = $order->get_id(); }
	if ( ! $order_id ) return;

	$order = isset( $order ) ? $order : wc_get_order( $order_id );
	if ( ! $order ) return;

	if ( $order->get_meta( '_tto_tg_sent' ) ) return;

	$currency = $order->get_currency();
	$total    = $order->get_total();
	$status   = wc_get_order_status_name( $order->get_status() );
	$payment  = $order->get_payment_method_title();
	$name     = trim( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() );
	$phone    = $order->get_billing_phone();
	$email    = $order->get_billing_email();
	$address  = $order->get_formatted_billing_address();

	$esc = function( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ); };

	$lines = [];
	foreach ( $order->get_items() as $item ) {
		$qty   = $item->get_quantity();
		$pname = $item->get_name();
		$line  = $item->get_total();
		$lines[] = sprintf( '• %s x%d — %s %s', $esc( $pname ), $qty, $esc( $currency ), number_format( (float) $line, 2 ) );
	}

	$admin_url = admin_url( 'post.php?post=' . $order_id . '&action=edit' );

	$msg  = "🛒 <b>New Order</b> #" . $esc( $order->get_order_number() ) . "\n";
	$msg .= "Status: " . $esc( $status ) . "\n";
	$msg .= "Total: <b>" . $esc( $currency ) . " " . number_format( (float) $total, 2 ) . "</b>\n";
	$msg .= "Payment: " . $esc( $payment ) . "\n\n";
	$msg .= "👤 " . ( $name ? $esc( $name ) : '—' ) . "\n";
	if ( $phone ) $msg .= "📞 " . $esc( $phone ) . "\n";
	if ( $email ) $msg .= "✉️ " . $esc( $email ) . "\n";
	if ( $address ) $msg .= "🏠 " . $esc( str_replace( '<br/>', ', ', $address ) ) . "\n";
	$msg .= "\n<b>Items:</b>\n" . implode( "\n", $lines );
	$msg .= "\n\n🔗 " . $admin_url;

	$resp = wp_remote_post(
		'https://api.telegram.org/bot' . TTO_TG_BOT_TOKEN . '/sendMessage',
		[
			'timeout' => 15,
			'body'    => [
				'chat_id'    => TTO_TG_CHAT_ID,
				'text'       => $msg,
				'parse_mode' => 'HTML',
				'disable_web_page_preview' => true,
			],
		]
	);

	if ( is_wp_error( $resp ) ) {
		file_put_contents( WP_CONTENT_DIR . '/tto-debug.log', date('c')." ERROR: ".$resp->get_error_message()."\n", FILE_APPEND );
	} else {
		$code = wp_remote_retrieve_response_code( $resp );
		$body = wp_remote_retrieve_body( $resp );
		file_put_contents( WP_CONTENT_DIR . '/tto-debug.log', date('c')." resp code=$code body=$body\n", FILE_APPEND );
		if ( $code === 200 ) {
			$order->update_meta_data( '_tto_tg_sent', 1 );
			$order->save();
		}
	}
}
