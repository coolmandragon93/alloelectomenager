<?php

$countries = new WC_Countries();

$args = array(
    'post_type'         => 'shop_order',
    'post_status'       => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date', 
    'order' => 'ASC',
    'year' => 2013,
    'monthnum' => 12,
    'tax_query' => array(
        array(
            'taxonomy' => 'shop_order_status',
            'terms' => apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing' ) ),
            'field' => 'slug',
            'operator' => 'IN'
        )
    )
);

$loop = new WP_Query( $args );

$orders = [];
$totalCA = 0;
$totalCB = 0;
$totalCheque = 0;
$totalWire = 0;
$totalPaypal = 0;
$totalOthers = 0;

if ( $loop->have_posts() ) {
    while ( $loop->have_posts() ) {
        $loop->the_post();
        $order_id = $loop->post->ID;
        $order = new WC_Order($order_id);
        $orders[] = $order;

        $totalCA += $order->order_total;

        switch ($order->payment_method) {
            case 'atos':
                $totalCB += $order->order_total;
                break;
            case 'paypal':
                $totalPaypal += $order->order_total;
                break;
            case 'bacs':
                $totalWire += $order->order_total;
                break;
            case 'cheque':
                $totalCheque += $order->order_total;
                break;
            
            default:
                $totalOthers += $order->order_total;
                break;
        }
    }
}

// CA
// CB
// Virement
// Cheque
// Paypal

wp_reset_query();

echo "Chiffre d'affaires: $totalCA € <br>";
echo "CB: $totalCB € <br>";
echo "Cheques: $totalCheque € <br>";
echo "Virements: $totalWire € <br>";
echo "Paypal: $totalPaypal € <br>";
echo "Autres: $totalOthers € <br>";

exit; 