<?php 

function wd_remove_accents($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);
    
    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    
    return $str;
}

function normalizeDesc($key)
{
	$dom = new DOMDocument();
	$dom->loadHTML('<?xml encoding="UTF-8">' . get_post_field('post_content', $key));

	$tables = $dom->getElementsByTagName('table');

	$mydesc = $tables->item(0)->nodeValue;

	return str_replace(array('.', "\n", "\t", "\r"), ' ', $mydesc);
}

function getImage($id)
{
	return wp_get_attachment_image_src( get_post_thumbnail_id($key), 'shop_thumbnail' )[0];
}

function getCategories($id)
{
	$cagegories = [];
	foreach(get_the_terms($product_id, "product_cat") as $c)
	{
		if(in_array($c->name, ["Portail", "Récepteurs", "Motorisations", "Kit Récepteurs", "Piles Telecommandes"]))
			$categories['category'] = $c->name;
		else
			$categories['brand'] = $c->name;
	}

	return $categories;
}

if(isset($_GET["spec"]) and $_GET["spec"] == "google")
{
	$products = "";

    $args = array(
        'post_type'         => 'product',
        'post_status'       => 'publish',
        'posts_per_page' => -1
    );

    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) 
    {
        while ( $loop->have_posts() ) 
        {
            $loop->the_post();
            $product_id = $loop->post->ID;
            $product = new WC_Product($product_id);

            if($product->regular_price == "" and $product->is_visible())
                continue;


			$title        = $product->get_title();
			$link         = get_permalink($product_id);
			$category     = wd_remove_accents(htmlspecialchars(getCategories($product_id)["category"]));
			$description  = normalizeDesc($product_id);
			$image        = getImage($product_id);
			$price        = $product->sale_price ?: $product->get_price();
			$id           = "allotel".$product_id;
			$brand        = wd_remove_accents(htmlspecialchars(getCategories($product_id)["brand"]));
			$mpn          = substr($brand, 0, 2).$product_id;
			$product_type = "Maison et jardin &gt; Appareils électroménagers &gt; Télécommandes pour portes de garage";


			$patterns = [
				"/{{TITLE}}/i",
				"/{{LINK}}/i",
				"/{{DESCRIPTION}}/i",
				"/{{CATEGORY}}/i",
				"/{{IMAGE_LINK}}/i",
				"/{{PRICE}}/i",
				"/{{ID}}/i",
				"/{{BRAND}}/i",
				"/{{MPN}}/i",
				"/{{PRODUCT_TYPE}}/i",
			];

			$replace = [
				$product->get_title(),
				get_permalink($product_id),
				normalizeDesc($product_id),
				$category,
				getImage($product_id),
				$product->sale_price ?: $product->get_price(),
				$id,
				$brand,
				$mpn,
				"Maison et jardin &gt; Appareils électroménagers &gt; Télécommandes pour portes de garage"
			];

			$products .= preg_replace(
				$patterns, 
				$replace, 
				file_get_contents('templates/google/product.php')
			);
        }
    }

    wp_reset_query(); 

    header ("Content-Type:text/xml; charset=utf-8");
    echo preg_replace('/{{products}}/i', $products, file_get_contents('templates/google/main.php'));
}