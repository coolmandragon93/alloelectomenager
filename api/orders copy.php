<?php //if(!isset($_SERVER['PHP_AUTH_USER'])) die('401');

if(isset($_GET["id"]))
{
    $order = new WC_Order($_GET['id']);

    $toencode = $order;
}
elseif (isset($_GET["q"])) 
{
    // Common args for query
    $args = array(
        'post_type'         => 'shop_order',
        'post_status'       => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date', 
        'order' => 'DESC'
    );

    if($_GET["q"] == "today")
    {
        // Today
        $today = getdate(strtotime("+2 hours"));

        $args["year"] = $today["year"];
        $args["monthnum"] = $today["mon"];
        $args["day"] = $today["mday"];
    }
    elseif ($_GET["q"] == "yesterday") 
    {
        // Yesterday
        $today = getdate(strtotime("-1 day +2 hours"));

        $args["year"] = $today["year"];
        $args["monthnum"] = $today["mon"];
        $args["day"] = $today["mday"];
    }
    elseif ($_GET["q"] == "monthsales") 
    {
        // Current Month
        $today = getdate(strtotime("+2 hours"));

        $args["year"] = $today["year"];
        $args["monthnum"] = $today["mon"];
        $args["tax_query"] = array(
            array(
                'taxonomy' => 'shop_order_status',
                'terms' => apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ),
                'field' => 'slug',
                'operator' => 'IN'
            )
        );
    }

    // WP Query & loop
    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) {
            $loop->the_post();
            $order_id = $loop->post->ID;

            $order = new WC_Order($order_id);
            $orders[] = $order;

        }
    }

    $toencode = $orders;
}

wp_reset_query(); 
http_response_code(200);
header('Content-type: application/json');
echo json_encode($toencode);