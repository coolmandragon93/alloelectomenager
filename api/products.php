<?php


if(isset($_GET["id"]))
{
    $id = $_GET["id"];

    $product = new WC_Product($id);

    $toencode['product'] = $product;
    $toencode['post'] = $product->get_post_data();
}
elseif(isset($_GET["ids"]))
{
    $ids = explode(",", $_GET["ids"]);

    foreach ($ids as $id)
    {
        $product = new WC_Product($id);

        $toencode[$id]['product'] = $product;
        $toencode[$id]['post'] = $product->get_post_data();
        $toencode[$id]['image'] = preg_replace("/-150x150/", "", wp_get_attachment_image_src( get_post_thumbnail_id($id))[0]);
    }
}
elseif(isset($_GET['add']))
{
    $post = array(
         'post_author' => 2,
         'post_content' => '',
         'post_status' => "publish",
         'post_title' => "Test product",
         'post_parent' => '',
         'post_type' => "product",
    );

    $post_id = wp_insert_post( $post, $wp_error );

    update_post_meta( $post_id, '_visibility', 'visible' );
    update_post_meta( $post_id, '_stock_status', 'instock');
    update_post_meta( $post_id, 'total_sales', '0');
    update_post_meta( $post_id, '_downloadable', 'no');
    update_post_meta( $post_id, '_virtual', 'yes');
    update_post_meta( $post_id, '_regular_price', "10" );
    update_post_meta( $post_id, '_sale_price', "" );
    update_post_meta( $post_id, '_purchase_note', "" );
    update_post_meta( $post_id, '_featured', "no" );
    update_post_meta( $post_id, '_weight', "" );
    update_post_meta( $post_id, '_length', "" );
    update_post_meta( $post_id, '_width', "" );
    update_post_meta( $post_id, '_height', "" );
    update_post_meta($post_id, '_sku', "");
    update_post_meta( $post_id, '_product_attributes', array());
    update_post_meta( $post_id, '_sale_price_dates_from', "" );
    update_post_meta( $post_id, '_sale_price_dates_to', "" );
    update_post_meta( $post_id, '_price', "1" );
    update_post_meta( $post_id, '_sold_individually', "" );
    update_post_meta( $post_id, '_manage_stock', "no" );
    update_post_meta( $post_id, '_backorders', "no" );
    update_post_meta( $post_id, '_stock', "" );

    die('test');
}
elseif(isset($_GET['excepts']))
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

            if(in_array($product_id, $_GET['excepts']))
                continue;

            $product = new WC_Product($product_id);

            $products[$product_id]['product'] = $product;
            $products[$product_id]['post'] = $product->get_post_data();

        }
    }

    $toencode = $products;

    wp_reset_query(); 
}
elseif(isset($_GET['status']))
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

            $products[] = $product_id;
        }
    }

    $toencode = $products;

    wp_reset_query(); 
}
else
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
}


http_response_code(200);
header('Content-type: application/json');
echo json_encode($toencode);