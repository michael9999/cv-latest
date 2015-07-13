<?php // example listener.php
include("../../../../wp-config.php");
include 'ipn_handler.class.php';
global $wpdb;

class My_Ipn_Handler extends IPN_Handler
{
    public function process(array $post_data)
    {
        // Let the IPN_Handler do it's processing,
        // which includes validating and fixing the encoding
        $data = parent::process($post_data);
	
        // Check if validation failed
       if($data === FALSE)
        {
            header('HTTP/1.0 400 Bad Request', true, 400);
            exit;
        }

        // Seems it all was good, so in lack of better things to do,
        // let's JSON encode it and dump it to a file
        
        file_put_contents('ipn.txt', json_encode($data).PHP_EOL, FILE_APPEND);
        global $wpdb;
          $table = $wpdb->prefix . "ktr_translating_info";
                    $sql = $wpdb->prepare(
                            "UPDATE $table SET
                                    status  = 5
                            WHERE ktr_order_id = '%s'"
                            , $data['item_number']);
                    $updated= $wpdb->query($sql);
		
		
		//Send admin_payment_received email
		$to = get_option( 'ktr-setting-admin_email' );
		$subject = 'Payment Received';
		$message = bp_ktr_get_email('admin_payment_received', 'salutation');
		$message .= '<p>Payment received.</p><p>Order ID:<b>'.$data['item_number'].'</b>';
		$message .= bp_ktr_get_email('admin_payment_received', 'footer');
		$headers = 'From: '. get_bloginfo( $show, 'display' ).' <noreply@mydomain.com>' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		wp_mail($to, $subject, $message , $headers);
		
		//Send client_payment_received email
		$to = $data['payer_email'];
		$subject = 'Payment Received';
		$message = bp_ktr_get_email('client_payment_received', 'salutation');
		$message='<p>Thanks for the payment.</p><p>Order ID:<b>'.$data['item_number'].'</b>';
		$message .= bp_ktr_get_email('client_payment_received', 'footer');
		$headers = 'From: '. get_bloginfo( $show, 'display' ).' <noreply@mydomain.com>' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		wp_mail($to, $subject, $message , $headers);
		
		
    }
}

$handler = new My_Ipn_Handler();
$handler->process($_REQUEST);
//$handler->test();


?>
