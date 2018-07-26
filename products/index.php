<?php
/*
@Author: Adedayo Matthews
@Created: 26/07/2018
@Last Modified: 26/07/2018
*/
require '../inc/setup.php';
require '../json_response.php';
$products = $woocommerce->get('products');
$response = new Response();
$total_products = count($products);
$product_count = ($total_products > 1 ? "There are $total_products products in your store currently" : "There is $total_products product in your store currently");
								
$products_array = array();

foreach($products as $product){
	$description = ($product->short_description == "" ? "No short description" : $product->short_description);
	$image_src = $product->images[0]->src;
	$image = ($image_src == "" ? "https://academy.tinklingd.com/wp-content/uploads/2017/08/Academy-logo.jpg" : $image_src);
	
	$products_array[] = array("title"=>$product->name,"subtitle"=>"Price: N ".$product->price,"image"=>$image,
								"buttons" =>array(
								    array("type"=>"web_url","url"=>$product->permalink,"title"=>"View product"),
												array("type"=>"web_url","url"=>"https://academy.tinklingd.com","title"=>"Visit Store")
												)									);				
}
$response->text($product_count);
$response->gallery($products_array);
$response->send(); 
?>




