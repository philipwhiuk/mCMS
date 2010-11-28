<?php

class Raven_Login extends Login {

	private $form;

	public function load($resource, $parent){ 

		parent::load($resource, $parent);
		$parent = $this->parent();

		$module = $resource->get_module();

		$this->url = System::Get_Instance()->url(Resource::Get_By_Argument($module,$this->get_id() .'/raven')->url());
	
		print_r($resource->get_argument());

		if($resource->get_argument() == 'raven'){
			// Do Login

			$resource->consume_argument();

			$rh = System::Get_Instance()->site()->get('raven_host');

			$webauth = new Raven_Webauth(array(
						'url' => System::Get_Instance()->url($resource->url()),
						'hostname' => $rh,
						'key_dir' => dirname(__FILE__),
						'do_session' => false,
						));

			if (!$webauth->validate_response()){
				$webauth->invoke_wls(NULL,'yes',NULL,'');
				exit;
			}

			if (!$webauth->success()){
				// Raven login was unsuccesful
			}
	
			// We have a valid user.

			try {

				$user = User::Get_One('=', array(array('col','raven_username'),array('s',$webauth->principal())));

				return $user;

			} catch (User_Not_Found_Exception $e) {

				// No Matching Raven User.			
			}


		}
		
		throw new Login_Incomplete_Exception();

	}

	public function display(){
		$template = System::Get_Instance()->output()->start(array('raven','login'));

		$template->url = $this->url;

		return $template;
	}

}
