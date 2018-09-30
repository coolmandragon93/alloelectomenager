<?php
/*
Plugin Name: WooCommerce Atos Gateway
Plugin URI: http://www.cmsbox.fr
Description: Extends WooCommerce. Provides an Atos Redirect gateway for WooCommerce.
Version: 1.0
Author: David Fiaty
Author URI: http://www.cmsbox.fr
*/

/*  Copyright 2011  Cms Box  (email : sav@cmsbox.fr) 

*/
add_action('plugins_loaded', 'init_atos_gateway', 0);
 
function init_atos_gateway() {
 
    if ( ! class_exists( 'woocommerce_payment_gateway' ) ) return;
	
	class woocommerce_atos extends woocommerce_payment_gateway {
			
		public function __construct() { 
			global $woocommerce;
			
			$this->id			= 'atos';
			$this->method_title = __('Atos', 'woothemes');
			$this->icon 		= apply_filters('woocommerce_paypal_icon', $woocommerce->plugin_url() . '/assets/images/icons/paiement-securise.gif');
			// $this->icon 		= apply_filters('woocommerce_atos_icon', get_option('siteurl') . '/wp-content/plugins/woocommerce-gateway-atos/images/cvm.png');
			$this->has_fields 	= false;
			
			// Load the form fields.
			$this->init_form_fields();
			
			// Load the settings.
			$this->init_settings();
			
			// Define user set variables
			$this->title 				   = $this->settings['title'];
			$this->description 			   = $this->settings['description'];
			$this->merchant_id   		   = $this->settings['merchant_id'];
			$this->currency_code		   = $this->settings['currency_code'];		
			$this->pathfile     		   = $this->settings['pathfile'];
			$this->request_file		       = $this->settings['request_file'];
			$this->response_file		   = $this->settings['response_file'];
			$this->payment_means           = $this->settings['payment_means'];
			
			//other
			$this->paybtn		= $this->settings['paybtn'];
			$this->paymsg		= $this->settings['paymsg'];
			//$this->payreturn	= $this->settings['payreturn'];

			// Actions
			add_action('init', array(&$this, 'check_atos_response'));
			add_action('valid-atos-request', array(&$this, 'successful_request'));
			add_action('woocommerce_receipt_atos', array(&$this, 'receipt_page'));
			add_action('woocommerce_update_options_payment_gateways', array(&$this, 'process_admin_options'));
			add_action('woocommerce_thankyou_atos', array(&$this, 'thankyou_page'));
		} 
		
		/**
		 * Initialise Gateway Settings Form Fields
		 */
		function init_form_fields() {
			
			$abs_path = str_replace('/wp-admin', '', getcwd());
		
			$this->form_fields = array(
				'enabled' => array(
								'title' => __( 'Activer/Désactiver:', 'woothemes' ), 
								'type' => 'checkbox', 
								'label' => __( 'Activer le module de paiement Atos.', 'woothemes' ), 
								'default' => 'yes'
							), 
				'title' => array(
								'title' => __( 'Nom:', 'woothemes' ), 
								'type' => 'text', 
								'description' => __( 'Intitulé affiché à l\'utilisateur lors de la commande.', 'woothemes' ), 
								'default' => __( 'Paiement sécurisé par carte bancaire', 'woothemes' )
							),
				'description' => array(
								'title' => __( 'Description:', 'woothemes' ), 
								'type' => 'textarea', 
								'description' => __( 'Description affichée à l\'utilisateur lors de la commande.', 'woothemes' ), 
								'default' => __('Payez en toute sécurité grâce à notre système de paiement Atos.', 'woothemes')
							),
				'merchant_id' => array(
								'title' => __( 'Identifiant commerçant:', 'woothemes' ), 
								'type' => 'text', 
								'description' => __( 'Identifiant commerçant fourni par votre banque. Ex: 014295303911112', 'woothemes' ), 
								'default' => __('014295303911112', 'woothemes')
							),
				'pathfile' => array(
								'title' => __( 'Chemin du fichier pathfile:', 'woothemes' ), 
								'type' => 'text', 
								'description' => __( 'Chemin absolu vers le fichier de configuration "pathfile" du kit de paiement, sans le / final', 'woothemes' ), 
								'default' => __($abs_path . '/atos/param/pathfile', 'woothemes')
							),
				'request_file' => array(
								'title' => __( 'Chemin du fichier request:', 'woothemes' ), 
								'type' => 'text', 
								'description' => __( 'Chemin absolu vers le fichier exécutable "request" du kit de paiement, sans le / final', 'woothemes' ), 
								'default' => __($abs_path . '/atos/bin/request', 'woothemes')
							),
				'response_file' => array(
								'title' => __( 'Chemin du fichier response:', 'woothemes' ), 
								'type' => 'text', 
								'description' => __( 'Chemin absolu vers le fichier exécutable "response" du kit de paiement, sans le / final', 'woothemes' ), 
								'default' => __($abs_path . '/atos/bin/response', 'woothemes')
							),
				'payment_means' => array(
								'title' => __( 'Cartes acceptées:', 'woothemes' ), 
								'type' => 'text', 
								'description' => __( 'Moyens de paiement acceptés. Ex pour CB, Visa et Mastercard: CB,2,VISA,2,MASTERCARD,2', 'woothemes' ), 
								'default' => __('CB,2,VISA,2,MASTERCARD,2', 'woothemes')
							),

				'currency_code' => array(
								'title' => __( 'Devise:', 'woothemes' ), 
								'type' => 'select', 
								'description' => __( 'Veuillez sélectionner une devise pour les paiemenents.', 'woothemes' ), 
								'default' => '978',
								'options' => array(
									'840' => 'USD',
									'978' => 'EUR',
									'124' => 'CAD',
									'392' => 'JPY',
									'826' => 'GBP',
									'036' => 'AUD' 
								 ) 					
							),
							
				'paybtn' => array(
								'title' => __( 'Texte bouton de paiement:', 'woothemes' ), 
								'type' => 'text', 
								'description' => __( 'Texte affiché sur le bouton qui redirige vers le terminal de paiement.', 'woothemes' ), 
								'default' => __('Régler la commande.', 'woothemes')
							),
				'paymsg' => array(
								'title' => __( 'Message page de paiement:', 'woothemes' ), 
								'type' => 'textarea', 
								'description' => __( 'Message affiché sur la page de commande validée, avant passage sur le terminal de paiement.', 'woothemes' ), 
								'default' => __('Merci pour votre commande. Veuillez cliquer sur le bouton ci-dessous pour effectuer le règlement.', 'woothemes')
							)
				/*'payreturn' => array(
								'title' => __( 'Texte bouton retour:', 'woothemes' ), 
								'type' => 'text', 
								'description' => __( 'Texte affiché sur le bouton de retour ver la boutique.', 'woothemes' ), 
								'default' => __('Retour', 'woothemes')
							)*/
							
							
				);
		
		} // End init_form_fields()
		
		/**
		 * Admin Panel Options 
		 * - Options for bits like 'title' and availability on a country-by-country basis
		 *
		 * @since 1.0.0
		 */
		public function admin_options() {

			?>
			<h3>ATOS</h3>
			<p><?php _e('Acceptez les paiements par carte bleue grâce à Atos.', 'woothemes'); ?></p>
			<p><?php _e('Plugin créé par David Fiaty', 'woothemes'); ?> - <a href="http://www.cmsbox.fr">http://www.cmsbox.fr</a></p>
			<table class="form-table">
			<?php
				// Generate the HTML For the settings form.
				$this->generate_settings_html();
			?>
			</table><!--/.form-table-->
			<?php
		} // End admin_options()
		
		/**
		 * There are no payment fields for atos, but we want to show the description if set.
		 **/
		function payment_fields() {
			if ($this->description) echo wpautop(wptexturize($this->description));
		}
		
		/**
		 * Generate the atos button link
		 **/
		public function generate_atos_form( $order_id ) {
			global $woocommerce;
			
			$order = &new woocommerce_order( $order_id );
			$atos_adr = $this->liveurl;
			$shipping_name = explode(' ', $order->shipping_method);	
			
			/******** ATOS PARAMS *************/
			//general
			$parm="merchant_id=" . $this->merchant_id;
			$parm="$parm merchant_country=fr";
			$parm="$parm amount=" . $order->order_total*100;
			$parm="$parm currency_code=" . $this->currency_code;
			//pathfile
			$parm="$parm pathfile=" . $this->pathfile;
			//		$parm="$parm transaction_id=123456";
			$parm="$parm normal_return_url=" . $this->get_return_url( $order );
			$parm="$parm cancel_return_url=" . $order->get_cancel_order_url();
			$parm="$parm automatic_response_url=" . $this->get_return_url( $order );
			//		$parm="$parm language=fr";
			//		$parm="$parm payment_means=CB,2,VISA,2,MASTERCARD,2";
			//		$parm="$parm header_flag=no";
			//		$parm="$parm capture_day=";
			//		$parm="$parm capture_mode=";
			//		$parm="$parm bgcolor=";
			//		$parm="$parm block_align=";
			//		$parm="$parm block_order=";
			//		$parm="$parm textcolor=";
			//		$parm="$parm receipt_complement=";
			//		$parm="$parm caddie=mon_caddie";
			//		$parm="$parm customer_id=";
			//		$parm="$parm customer_email=";
			//		$parm="$parm customer_ip_address="
			if($order->order_total < 150) {
				$parm="$parm data=NO_RESPONSE_PAGE;3D_BYPASS;";

			} else {
				$parm="$parm data=NO_RESPONSE_PAGE";
			}
			//		$parm="$parm return_context=";
			//		$parm="$parm target=";
			$parm="$parm order_id=" . $order_id;
			// $parm="$parm no_responce_page=true";
			// 		$parm="$parm normal_return_logo=";
			// 		$parm="$parm cancel_return_logo=";
			// 		$parm="$parm submit_logo=";
			$parm="$parm logo_id=allo.png";
			// $parm="$parm logo_id=http://www.allotelecommande.com/wp-content/uploads/2012/05/allotelecommande2.com_.png";
			// 		$parm="$parm logo_id2=";
			// 		$parm="$parm advert=";
			// 		$parm="$parm background_id=";
			// 		$parm="$parm templatefile=";
			$path_bin = $this->request_file;
		
			//	Call request binary
			$parm = escapeshellcmd($parm);	
			$result=exec("$path_bin $parm");
			
			error_log(print_r($parm, true), 3, "/var/tmp/tmp-orders.log");
	
			$tableau = explode ("!", "$result");
		
			//Get parameters result
			$code = $tableau[1];
			$error = $tableau[2];
			$message = $tableau[3];
			//Analyze returned code
			if (( $code == "" ) && ( $error == "" ) )
			{
				print ("<BR><CENTER>erreur appel request</CENTER><BR>");
				print ("executable request non trouve $path_bin");
			}
			//	Error
			else if ($code != 0){
				print ("<center><b><h2>Erreur appel API de paiement.</h2></center></b>");
				print ("<br><br><br>");
				print (" message erreur : $error <br>");
			}
		
			//OK, display html form
			else {
				print ("<br><br>");
				# OK, display debug if activated
				print (" $error <br>");
				print ("  $message <br>");
			}
			
		}
		
		/**
		 * Process the payment and return the result
		 **/
		function process_payment( $order_id ) {
			
			$order = &new woocommerce_order( $order_id );
			
			return array(
				'result' 	=> 'success',
				'redirect'	=> add_query_arg('order', $order->id, add_query_arg('key', $order->order_key, get_permalink(get_option('woocommerce_pay_page_id'))))
			);
			
		}
		
		/**
		 * receipt_page
		 **/
		function receipt_page( $order ) {
			
			echo '<p>'.__($this->paymsg, 'woothemes').'</p>';
			
			echo $this->generate_atos_form( $order );
			
		}
		
		/**
		* Check for valid atos server callback
		**/
		function check_atos_response() {
			
			global $woocommerce;
			
			if (isset($_POST['DATA']))
			{
				//custom parameter for transaction processing
				$atos_response = array();
				//atos code
				$message="message=" . $_POST['DATA'];
				$pathfile="pathfile=" . $this->pathfile;
				$path_bin = $this->response_file;
				//exec
				$message = escapeshellcmd($message);
				$result=exec("$path_bin $pathfile $message");
				$tableau = explode ("!", $result);
				//get response data
				$code = $tableau[1];
				$error = $tableau[2];
				$merchant_id = $tableau[3];
				$merchant_country = $tableau[4];
				$amount = $tableau[5];
				$transaction_id = $tableau[6];
				$payment_means = $tableau[7];
				$transmission_date= $tableau[8];
				$payment_time = $tableau[9];
				$payment_date = $tableau[10];
				$response_code = $tableau[11];
				$payment_certificate = $tableau[12];
				$authorisation_id = $tableau[13];
				$currency_code = $tableau[14];
				$card_number = $tableau[15];
				$cvv_flag = $tableau[16];
				$cvv_response_code = $tableau[17];
				$bank_response_code = $tableau[18];
				$complementary_code = $tableau[19];
				$complementary_info = $tableau[20];
				$return_context = $tableau[21];
				$caddie = $tableau[22];
				$receipt_complement = $tableau[23];
				$merchant_language = $tableau[24];
				$language = $tableau[25];
				$customer_id = $tableau[26];
				$order_id = $tableau[27];
				$customer_email = $tableau[28];
				$customer_ip_address = $tableau[29];
				$capture_day = $tableau[30];
				$capture_mode = $tableau[31];
				$data = $tableau[32];
				$order_validity = $tableau[33];  
				$transaction_condition = $tableau[34];
				$statement_reference = $tableau[35];
				$card_validity = $tableau[36];
				$score_value = $tableau[37];
				$score_color = $tableau[38];
				$score_info = $tableau[39];
				$score_threshold = $tableau[40];
				$score_profile = $tableau[41];
				//analyze response code
				if (( $code == "" ) && ( $error == "" ) )
				{
					print ("<BR><CENTER>erreur appel response</CENTER><BR>");
					print ("executable response non trouve $path_bin");
				}
				else if ( $code != 0 ) {
					print ("<center><b><h2>Erreur appel API de paiement.</h2></center></b>");
					print ("<br><br><br>");
					print (" message erreur : $error <br>");
				}else {
				//else if ($code == 0 and $response_code == "00") { //case transaction ok
					if ($response_code == "00") {	
						$atos_response['code_reponse'] = 'ok';
						$atos_response['order_id'] = $order_id;
						$atos_response['real_response_code'] = $response_code;
						$atos_response['real_code'] = $code;
						do_action("valid-atos-request", $atos_response);
					}else{
						print ("<BR><CENTER>Une erreur s'est produite durant la phase de paiement.</CENTER><BR>");
					
					}
				}
			}
		}		
			
		/**
		 * Server callback was valid, process callback (update order as passed/failed etc).
		 **/
		function successful_request($atos_response) {
			global $woocommerce;

			if (isset($atos_response)) {
			
				try {
					switch ($atos_response['code_reponse']) {
						// transaction authorised
						case 'ok':
							$transauthorised = true;
							break;
						default:
							$transauthorised = false;
							break;
					}
				
					if ($transauthorised == true) {
						

						// put code here to update/store the order with the a successful transaction result
						$order_id 	  	= $atos_response['order_id'];
						$order = &new WC_Order( $order_id );
								
						if ($order->status !== 'completed') {
							if ($order->status == 'processing') {
								// This is the second call - do nothing
							} else {
								
								
								$order->payment_complete();
								//Add admin order note
								$order->add_order_note('Paiement Atos: REUSSI<br><br>Référence Transaction: ' . $order_id);								
								$order->add_order_note('info<br><br>Response Code: ' . $atos_response['real_response_code'] . '<br> Bank Code:' . $atos_response['real_code']);								
								//Add customer order note
								$order->add_order_note('Paiement réussi','customer');
								// Empty the Cart
								$woocommerce->cart->empty_cart();
								//update order status
								$order->update_status('processing');

								
							}
						}
					} else {
						// put code here to update/store the order with the a failed transaction result
						$order_id 	  	= $atos_response['order_id'];
						$order 			= new woocommerce_order( (int) $order_id );					
						$order->update_status('failed');
						//Add admin order note
						$order->add_order_note('Paiement Atos: ECHEC<br><br>Référence Transaction: ' . $order_id);
						//Add customer order note
						$order->add_order_note('Paiement échoué','customer');
					}
				} catch (Exception $e) {
					//$nOutputProcessedOK = 30;
					//$szOutputMessage = "Error updating website system, please ask the developer to check code";
				}
				//echo string back for gateway to read - this confirms the script ran correctly.
				//echo("StatusCode=".$nOutputProcessedOK."&Message=".$szOutputMessage);
			}
		}	
		
		function thankyou_page () {
			global $woocommerce;
			
			//grab the order ID from the querystring
			$order_id 	  	= $_GET['order'];
			//lookup the order details
			$order 			= new woocommerce_order( (int) $order_id );
			
			//check the status of the order
			if ($order->status == 'completed') {                                                     
                //display additional success message
				echo "<p>Félicitations! Votre paiement a été validé avec succès. <a href=\"". esc_url( add_query_arg('order', $order_id, get_permalink(get_option('woocommerce_view_order_page_id'))) ) ."\">Cliquez ici pour voir votre commande</a></p>";
			} else {
				//display additional failed message
				echo "<br>&nbsp;<p>La transaction n'a pas été validée. Pour plus d'information, <a href=\"". esc_url( add_query_arg('order', $order_id, get_permalink(get_option('woocommerce_view_order_page_id'))) ) ."\">cliquez ici pour voir votre commande</a>.</p>";
			}
		}		
	}
}

/**
 * Add the gateway to WooCommerce
 **/
function add_atos_gateway( $methods ) {
	$methods[] = 'woocommerce_atos'; return $methods;
}

add_filter('woocommerce_payment_gateways', 'add_atos_gateway' );
