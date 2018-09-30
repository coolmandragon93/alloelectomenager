<?php

// $headers = ['test' => 2, "fdfdfd" => 45];

// error_log(print_r($headers, true), 3, "/var/tmp/mes-erreurs.log");

// exit;
// Auth
// require('auth.php');

require 'Carbon.php';

use Carbon\Carbon;

// Load WP
include('../www/wp-load.php');

if($_GET["type"] == "orders")
{
    include('orders.php');
}
elseif($_GET["type"] == "products")
{
    include('products.php');
}
elseif($_GET["type"] == "acc")
{
    include('acc.php');
}
elseif($_GET["type"] == "feed")
{
    include('feed.php');
}
elseif($_GET["type"] == "baz")
{
    $args = array(
        'post_type'         => 'product',
        'post_status'       => 'publish',
        'posts_per_page' => -1
    );

    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) {
            $loop->the_post();
            $product_id = $loop->post->ID;
            $product = new WC_Product($product_id);

            $products[$product_id]['product'] = $product;
            $products[$product_id]['post'] = $product->get_post_data();
            // $products[$product_id]['image'] = $product->get_image('full');
            $products[$product_id]['image'] = preg_replace("/-150x150/", "", wp_get_attachment_image_src( get_post_thumbnail_id($product_id))[0]);

        }
    }

    $toencode = $products;

    wp_reset_query(); 

    http_response_code(200);
    header('Content-type: application/json');
    echo json_encode($toencode);
}
elseif($_GET["type"] == "m")
{
    $date = Carbon::now()->subMonth();

    $countries = new WC_Countries();

    $orders = [];

    $i = $date->format('m');

    $orders[$i]['total'] = 0;

    $args = array(
        'post_type'         => 'shop_order',
        'post_status'       => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date', 
        'order' => 'ASC',
        'year' => $date->format('Y'),
        'monthnum' => $date->format('m'),
        'tax_query' => array(
            array(
                'taxonomy' => 'shop_order_status',
                'terms' => apply_filters('woocommerce_reports_order_statuses', array('completed') ),
                'field' => 'slug',
                'operator' => 'IN'
            )
        )
    );

    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) {
            $loop->the_post();
            $order_id = $loop->post->ID;
            $order = new WC_Order($order_id);

            $order->shipping_country = $countries->countries[$order->shipping_country];
            $order->billing_country = $countries->countries[$order->billing_country]; 

            if(empty($orders[$i][$order->shipping_country]['total']))
            {
                $orders[$i][$order->shipping_country]['total'] = 0;
            }

            $orders[$i][$order->shipping_country]['total'] += $order->get_order_total(); 
            $total += $order->get_order_total();

            $orders[$i]['total'] += $order->get_order_total();
        }
    }

    if(isset($orders[$i][""]['total']))
    {
        $orders[$i]["France"]['total'] += $orders[""]['total'];
        unset($orders[$i][""]);
    }

    ksort($orders[$i]);

    wp_reset_query(); 

    http_response_code(200);
    header('Content-type: application/json');
    echo json_encode($orders);

    // $args = array(
    //     'post_type'         => 'shop_order',
    //     'post_status'       => 'publish',
    //     'posts_per_page' => -1,
    //     'orderby' => 'date', 
    //     'order' => 'ASC',
    //     'year' => 2013,
    //     'monthnum' => 9,
    //     'tax_query' => array(
    //         array(
    //             'taxonomy' => 'shop_order_status',
    //             'terms' => apply_filters('woocommerce_reports_order_statuses', array('completed') ),
    //             'field' => 'slug',
    //             'operator' => 'IN'
    //         )
    //     )
    // );

    // $loop = new WP_Query( $args );

    // $orders = [];
    // $total = 0;

    // if ( $loop->have_posts() ) {
    //     while ( $loop->have_posts() ) {
    //         $loop->the_post();
    //         $order_id = $loop->post->ID;
    //         $order = new WC_Order($order_id);

    //         $order->shipping_country = $countries->countries[$order->shipping_country];
    //         $order->billing_country = $countries->countries[$order->billing_country]; 

    //         if(empty($orders[$order->shipping_country]['total']))
    //         {
    //             $orders[$order->shipping_country]['total'] = 0;
    //         }

    //         $orders[$order->shipping_country]['total'] += $order->get_order_total(); 
    //         $total += $order->get_order_total();
    //     }
    // }

    // wp_reset_query(); 


    // $args = array(
    //     'post_type'         => 'shop_order',
    //     'post_status'       => 'publish',
    //     'posts_per_page' => -1,
    //     'orderby' => 'date', 
    //     'order' => 'ASC',
    //     'year' => 2013,
    //     'monthnum' => 8,
    //     'tax_query' => array(
    //         array(
    //             'taxonomy' => 'shop_order_status',
    //             'terms' => apply_filters('woocommerce_reports_order_statuses', array('completed') ),
    //             'field' => 'slug',
    //             'operator' => 'IN'
    //         )
    //     )
    // );

    // $loop = new WP_Query( $args );

    // if ( $loop->have_posts() ) {
    //     while ( $loop->have_posts() ) {
    //         $loop->the_post();
    //         $order_id = $loop->post->ID;
    //         $order = new WC_Order($order_id);

    //         $order->shipping_country = $countries->countries[$order->shipping_country];
    //         $order->billing_country = $countries->countries[$order->billing_country]; 

    //         if(empty($orders[$order->shipping_country]['total']))
    //         {
    //             $orders[$order->shipping_country]['total'] = 0;
    //         }

    //         $orders[$order->shipping_country]['total'] += $order->get_order_total(); 
    //         $total += $order->get_order_total();
    //     }
    // }

    // wp_reset_query(); 

    // $orders["France"]['total'] += $orders[""]['total'];
    // unset($orders[""]);

    // foreach ($orders as $c => $value) 
    // {
    //     echo html_entity_decode($c).": \n\r \t ".number_format($value['total'], 2)." € \t ".number_format($value['total']*100/$total, 2)."% \n\r";
    // }

    // exit;
}
elseif($_GET["type"] == "sh")
{
    $countries = new WC_Countries();

    $args = array(
        'post_type'         => 'shop_order',
        'post_status'       => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date', 
        'order' => 'ASC',
        'year' => 2013,
        'monthnum' => 11,
        'tax_query' => array(
            array(
                'taxonomy' => 'shop_order_status',
                'terms' => apply_filters( 'woocommerce_reports_order_statuses', array( 'completed' ) ),
                'field' => 'slug',
                'operator' => 'IN'
            )
        )
    );

    $loop = new WP_Query( $args );

    $orders = [];

    header('Content-type: text/csv');
    http_response_code(200);

    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) {
            $loop->the_post();
            $order_id = $loop->post->ID;
            $order = new WC_Order($order_id);
            //echo $order->billing_email.",".$order->billing_first_name." ".$order->billing_last_name.",".$order->id.PHP_EOL;
            echo $order->billing_email.",".$order->billing_first_name." ".$order->billing_last_name.",".$order->id.",[";
            foreach ($order->get_items() as $item) 
            {
                echo $item["name"]."|";
            }
            echo "]".PHP_EOL;
            $orders[] = $order;
        }
    }

    wp_reset_query();

    exit; 
}

global $woocommerce;

// if($_GET["type"] == "products")
// {
//     include('products.php');
// }


/*try {
# MySQL with PDO_MYSQL 

    $DBH = new PDO("mysql:host=127.0.0.1;dbname=allotel", "root", "9sap441h");
}  
catch(PDOException $e) {  
    echo $e->getMessage();  
} 

# using the shortcut ->query() method here since there are no variable
# values in the select statement.
$STH = $DBH->query("SELECT   wpmicka_posts.* FROM wpmicka_posts  WHERE 1=1 AND wpmicka_posts.post_type = 'shop_order' AND (wpmicka_posts.post_status = 'publish')  ORDER BY wpmicka_posts.post_date DESC ");

# setting the fetch mode
$STH->setFetchMode(PDO::FETCH_ASSOC);


while($row = $STH->fetch()) {
    $orders[] = $row;    
}

echo "done. ".count($orders)." orders";
echo "<pre>";
print_r($orders);
*/
