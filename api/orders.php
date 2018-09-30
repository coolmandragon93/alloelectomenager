<?php //if(!isset($_SERVER['PHP_AUTH_USER'])) die('401');

// Get countries
$countries = new WC_Countries();

if(isset($_GET["id"]))
{

    if(isset($_POST['tracking']))
    {
        $order = new WC_Order($_GET['id']);
        $order->shipping_country = $countries->countries[$order->shipping_country];
        $order->billing_country = $countries->countries[$order->billing_country];    

        $tracking = $_POST['tracking'];
        $trustpilot = $_POST['trustpilot'];

        // // add meta
        add_post_meta($_GET['id'], "tracking", $tracking);
        add_post_meta($_GET['id'], "trustpilot", $trustpilot);

        
        // // validate order
        $order->update_status('completed');

        // // Send mail
        // ob_start();
        // include('mail_order_complete.php');

        // $message = ob_get_clean();

        // // Email
        // $to  = $order->billing_email;

        // // To send HTML mail, the Content-type header must be set
        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        // // Additional headers
        // $headers .= 'To: '.$order->billing_first_name.' '.$order->billing_last_name.' <'.$order->billing_email.'>' . "\r\n";
        // $headers .= 'From: Allotélécommande <contact@allotelecommande.com>' . "\r\n";

        // // Mail it
        // mail($to, "[AlloTelecommande] Commande terminée", $message, $headers);

        exit;
    }
    else
    {
        $order = new WC_Order($_GET['id']);

        $items = unserialize($order->order_custom_fields['_order_items'][0]);

        $shipping_country_code = $order->shipping_country;
        $billing_country_code = $order->billing_country;
        $order->shipping_country = $countries->countries[$order->shipping_country];
        $order->billing_country = $countries->countries[$order->billing_country];    

        $order = [
            'id' => $_GET['id'],
            'order_status' => $order->status,
            'order_date' => $order->order_date,
            'order_total' => $order->order_total,
            'shipping_method_title' => $order->shipping_method_title,
            'order_shipping' => $order->order_shipping,
            'email' => $order->billing_email,
            'phone' => $order->billing_phone,
            'shipping_company' => $order->shipping_company,
            'shipping_first_name' => $order->shipping_first_name,
            'shipping_last_name' => $order->shipping_last_name,
            'shipping_address_1' => $order->shipping_address_1,
            'shipping_address_2' => $order->shipping_address_2,
            'shipping_postcode' => $order->shipping_postcode,
            'shipping_city' => $order->shipping_city,
            'shipping_country' => $order->shipping_country,
            'shipping_country_code' => $shipping_country_code,
            'billing_company' => $order->billing_company,
            'billing_first_name' => $order->billing_first_name,
            'billing_last_name' => $order->billing_last_name,
            'billing_address_1' => $order->billing_address_1,
            'billing_address_2' => $order->billing_address_2,
            'billing_postcode' => $order->billing_postcode,
            'billing_city' => $order->billing_city,
            'billing_country' => $order->billing_country,
            'billing_country_code' => $billing_country_code
        ];

        foreach ($items as $i) 
        {
            $order['items'][] = [
                'product_id' => $i['id'],
                'name' => $i['name'],
                'price' => $i['id'],
                'quantity' => $i['qty'],
                'total' => $i['line_total']
            ];
        }

        $toencode = $order;
    }
}
elseif (isset($_GET["q"])) 
{
    if($_GET["q"] == "monthsales")
    {
        // Today
        $today = getdate(strtotime("+2 hours"));

        $args = array(
            'post_type'         => 'shop_order',
            'post_status'       => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'date', 
            'order' => 'ASC',
            'year' => $today["year"],
            'monthnum' => $today["mon"],
            'tax_query' => array(
                array(
                    'taxonomy' => 'shop_order_status',
                    'terms' => apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ),
                    'field' => 'slug',
                    'operator' => 'IN'
                )
            )
        );

        $loop = new WP_Query( $args );

        $total = 0;
        $orders = [];

        if ( $loop->have_posts() ) {
            while ( $loop->have_posts() ) {
                $loop->the_post();
                $order_id = $loop->post->ID;
                $order = new WC_Order($order_id);

                if( ! array_key_exists(date("Ymd", strtotime($order->order_date)), $orders))
                {
                    $orders[date("Ymd", strtotime($order->order_date))] = [
                        'date' => date("Ymd", strtotime($order->order_date)),
                        'count' => 0,
                        'amount' => 0
                    ];
                }

                $orders[date("Ymd", strtotime($order->order_date))]['count'] += 1;
                $orders[date("Ymd", strtotime($order->order_date))]['amount'] += $order->get_order_total();
            }
        }

        wp_reset_query(); 

    }
    elseif($_GET["q"] == "toprocess")
    {
        $args = array(
            'post_type'         => 'shop_order',
            'post_status'       => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'date', 
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'shop_order_status',
                    'terms' => apply_filters( 'woocommerce_reports_order_statuses', array( 'processing' ) ),
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

                // Change country
                $order->shipping_country = $countries->countries[$order->shipping_country];
                $order->billing_country = $countries->countries[$order->billing_country];

                $orders[$order_id] = $order;

            }
        }

        wp_reset_query(); 
    }
    elseif($_GET["q"] == "newtoprocess")
    {
        $args = array(
            'post_type'         => 'shop_order',
            'post_status'       => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'date', 
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'shop_order_status',
                    'terms' => apply_filters( 'woocommerce_reports_order_statuses', array( 'processing' ) ),
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

                // Change country
                $shipping_country_code = $order->shipping_country;
                $billing_country_code = $order->billing_country;
                $order->shipping_country = $countries->countries[$order->shipping_country];
                $order->billing_country = $countries->countries[$order->billing_country];

                // $orders[$order_id] = $order;
                $orders[$order_id] = [
                    'id' => $order_id,
                    'order_status' => $order->status,
                    'order_date' => $order->order_date,
                    'order_total' => $order->order_total,
                    'shipping_method_title' => $order->shipping_method_title,
                    'order_shipping' => $order->order_shipping,
                    'email' => $order->billing_email,
                    'phone' => $order->billing_phone,
                    'shipping_company' => $order->shipping_company,
                    'shipping_first_name' => $order->shipping_first_name,
                    'shipping_last_name' => $order->shipping_last_name,
                    'shipping_address_1' => $order->shipping_address_1,
                    'shipping_address_2' => $order->shipping_address_2,
                    'shipping_postcode' => $order->shipping_postcode,
                    'shipping_city' => $order->shipping_city,
                    'shipping_country' => $order->shipping_country,
                    'shipping_country_code' => $shipping_country_code,
                    'billing_company' => $order->billing_company,
                    'billing_first_name' => $order->billing_first_name,
                    'billing_last_name' => $order->billing_last_name,
                    'billing_address_1' => $order->billing_address_1,
                    'billing_address_2' => $order->billing_address_2,
                    'billing_postcode' => $order->billing_postcode,
                    'billing_city' => $order->billing_city,
                    'billing_country' => $order->billing_country,
                    'billing_country_code' => $billing_country_code
                ];

                $items = unserialize($order->order_custom_fields['_order_items'][0]);

                foreach ($items as $i) 
                {
                    $orders[$order_id]['items'][] = [
                        'product_id' => $i['id'],
                        'name' => $i['name'],
                        'price' => $i['id'],
                        'quantity' => $i['qty'],
                        'total' => $i['line_total']
                    ];
                }
            }
        }

        wp_reset_query(); 
    }

    // What to encode
    $toencode = $orders;
}


http_response_code(200);
header('Content-type: application/json');
echo json_encode($toencode);