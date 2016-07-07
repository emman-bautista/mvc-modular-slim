<?php 
namespace App\Utilities;

/**
* Helper Class
*/
class Helper
{
	
	static function todayMysqlDate() {
		return date("Y-m-d H:i:s");
	}

	static function todayMysqlTime() {
		return date("H:i:s");
	}

	// Send Email
	static function sendEmail($recipient, $from, $subject, $message, $smtp = true) {
		$emailConfig = require SOURCES_PATH . '/email.php';

 		//die($message);
	 	$mail = new \PHPMailer();
		$mail->isSMTP();
		$mail->SMTPDebug 	= 2;
		$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);

		$mail->SMTPAuth   	= true; // enable SMTP authentication
		$mail->SMTPSecure 	= $emailConfig['smtp']["secure"]; // sets the prefix to the servier
		$mail->Host       	= $emailConfig['smtp']["host"]; // sets GMAIL as the SMTP server
		$mail->Port       	= $emailConfig['smtp']["port"]; // set the SMTP port for the GMAIL server
		$mail->Username   	= $emailConfig['smtp']["username"];
		$mail->Password  	= $emailConfig['smtp']["password"];

		$mail->From = $from;
		$mail->FromName = "No-reply: Event Registration";
		$mail->addReplyTo($from, "Event Registration");

		// Recipient email
		$html = $message;
		
		// Replace contents
		$mail->addAddress($recipient);

		$mail->isHTML(true);
		
		$mail->Subject = $subject;
		$mail->Body = $message;
		// End of recipient email
		
		if($mail->send()){
			return true;
			exit;
		}

		return false;
 	}

	
}