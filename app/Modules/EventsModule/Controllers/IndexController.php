<?php 
namespace App\Modules\EventsModule\Controllers;

use App\Utilities\RandomStringGenerator as GenStr;
use Respect\Validation\Validator as v;
use \App\Modules\EventsModule\Models\Event;
use \App\Modules\EventsModule\Models\Organizer;
use \App\Modules\EventsModule\Models\Session;
/**
* 
*/
class IndexController extends \App\Controllers\BaseController
{	
	protected $templateNamespace = 'Events';

	// Parameters $request, $response and $args show always be declared.
	function home($request, $response, $args) {
		$params = $request->getQueryParams();
		
		$page = isset($params['page']) ? $params['page'] : 0;
		
		$events = Event::limit(10)->offset($page)->get();

		return $this->render($response, 'index.phtml', ['title'=>'Events', 'events'=> $events]);
	}

	function about($request, $response, $args) {
		return $this->render($response, 'about.phtml', ['title'=>'About']);	
	}
	
	function invite($request, $response, $args) {

		if($request->isPost()) {
			$params = $request->getParsedBody();
			$invite_code = $params['invite_code'];
			$email = $params['email'];
			$isMatched = $this->isMatched($invite_code);
			
			if(!v::email()->validate($email)) {
				$this->container->flash->addMessage('Error', "Email is required and should be a valid email.");
				$_SESSION['invite_email'] = $email;
	        	return $response->withHeader('Location', $this->container->router->pathFor('event_invite'));
			}
		}
		
		$email = (isset($_SESSION['invite_email'])) ? $_SESSION['invite_email'] : '';
		unset($_SESSION['invite_email']);
		
		return $this->render($response, 'invite.phtml', ['title'=>'Invite', 'email' => $email]);	
	}

	private function isMatched($code){
		return 0;
	}

	private function getUserInviteCode() {
		$currentUser = $this->container->get('authenticator')->getIdentity();
	}

	private function createEvent($data = []) {
		if(empty($data)) {
			return false;
		}

		$me = $this->container->get('authenticator')->getIdentity();

		$event = new \App\Modules\EventsModule\Models\Event;
		$event->title = $data['title'];
		$event->description =  $data['description'];
		$event->date_start = $data['start_date']; //\App\Utilities\Helper::todayMysqlDateTime();
		$event->date_end = $data['end_date']; //\App\Utilities\Helper::todayMysqlDateTime();
		$event->venue = $data['venue'];
		$event->owner = $me['id'];

		if($event->save()) {
			return $event;
		}

		return false;
	}

	private function createSession($event_id, $sessionData= []) {
		$session = new \App\Modules\EventsModule\Models\EventSession;
		$session->title = "Session Title";
		$session->description = "Session Description";
		$session->date = \App\Utilities\Helper::todayMysqlDate();
		$session->start = \App\Utilities\Helper::todayMysqlTime();
		$session->venue = "Room 404: Not found!";
		
		if($session->save()) {
			return $session;
		}

		return false;
	}

	private function createOrganizer($event_id, $sessionData= []) {
		$session = new \App\Modules\EventsModule\Models\Organizers;
		$session->title = "Session Title";
		$session->description = "Session Description";
		$session->date = \App\Utilities\Helper::todayMysqlDate();
		$session->start = \App\Utilities\Helper::todayMysqlTime();
		$session->venue = "Room 404: Not found!";
		
		if($session->save()) {
			return $session;
		}

		return false;
	}
}