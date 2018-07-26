<?php
/*
@Author: Adedayo Matthews
@Created: 26/07/2018
@Last Modified: 26/07/2018
*/
require '../inc/setup.php';
require '../json_response.php';
$orders = $woocommerce->get('orders');
$response = new Response();
$total_orders= count($orders);
$order_count = "You currently have ".($total_orders > 1 ? " $total_orders orders" : "order");
$orders_array = array();
$response->text($order_count);
	$products_ordered = "";
foreach($orders as $order){
	foreach($order->line_items as $item){
		$products_ordered .= $item->quantity. " of product #".$item->product_id."(".$item->quantity." X ".$item->price." = ".$item->total."),";
	}
	$msg = "Order #".$order->id." of ".$products_ordered." \n\n";
	$msg .= "Billing Detail: \n";
	$msg .= "Name: ".$order->billing->first_name." ".$order->billing->last_name." \n";
    $msg .= "Address: ".$order->billing->address_1." ".$order->billing->city.", ".$order->billing->country." \n";
    $msg .= "Email: ".$order->billing->email." \n";
    $msg .= "Phone: ".$order->billing->phone." \n\n";
	
	$msg .= "Shipping Detail: \n";
	$msg .= "Name: ".$order->shipping->first_name." ".$order->shipping->last_name." \n";
    $msg .= "Address: ".$order->shipping->address_1." ".$order->shipping->city.", ".$order->shipping->country." \n";
	
	$msg .= "Payment method: ". $order->payment_method_title;
	$buttons = array(array("title"=>"View Product","type"=>"show_block","block"=>["Ordered Product"]));
	
	$response->text_button($msg,$buttons);
}
$response->send(); 
?>