<?php 

namespace App\Core;

/**
* Base Controller that accepts Slim App Container
*/
class BaseController
{
	protected $container = null;
	protected $templateNamespace = null;
	
	function __construct($container)
	{
		$this->container = $container;
	}

	function render($response, $template, $args) {
		$menu = $this->container->menu->getMenu();
		$args['menu'] = $menu;
		if($this->templateNamespace != null ){
			return $this->container->view->render($response, "@$this->templateNamespace/$template", $args);
		}else {

			return $response->withStatus(500)
					->withHeader('Content-Type', 'text/html')
					->write('Template name not define in class ' . static::class);
		}
	}

	protected function sendEmailSMTP($recipient, $from, $subject, $message, $smtp=true) {
		
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

		$mail->SMTPAuth   	= true;                  // enable SMTP authentication
		$mail->SMTPSecure 	= "tls";                 // sets the prefix to the servier
		$mail->Host       	= "vmwaresaptraining.com";      // sets GMAIL as the SMTP server
		$mail->Port       	= 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   	= 'mailtransport@vmwaresaptraining.com';
		$mail->Password  	= 'uFCCXI6HDc';

		$mail->From = $from;
		$mail->FromName = "VMware SAP Training";
		$mail->addReplyTo($from, "VMware SAP Training");

		//Recipient email
		$html = $message;
		
		//Replace contents
		
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