<?php

class Actor_Page_Main_View extends Actor_Page_Main {
	
	protected $actor;
	public $film_roles = array();	

	public function __construct($parent, $actor){
		parent::__construct($parent);
		$system = System::Get_Instance();
		$this->actor = $actor;
		$this->check('view');
		Module::Get('film');
		$film_roles = Film_Role_Film_Actor::Get_By_Actor($this->actor->get_id());
		$role = array();
		$film = array();
			$i = 0;		
		foreach($film_roles as $film_role) {
			try {
				$role[$i] = $film_role->get_film_role()->get_content()->get_title();
				$film[$i] = $film_role->get_film()->get_description()->get_title();
				$this->film_roles[$i]['role'] = $film_role->get_film_role()->get_content()->get_title();
				$this->film_roles[$i]['title'] = $film_role->get_film()->get_description()->get_title();
				try {
					$this->film_roles[$i]['titleIMG'] = $film_role->get_film()->get_smallImage()->width(200)->file()->url();
				}
				catch(Image_Not_Found_Exception $ie) {
				}
				$filmmod = Module::Get('film');
				$frid = $film_role->get_film_role()->get_id();
				$this->film_roles[$i]['roleURL'] = $system->url(Resource::Get_By_Argument($filmmod,'role/'.$frid)->url());

				$this->film_roles[$i]['titleURL'] = $system->url(Resource::Get_By_Argument(Module::Get('film'),$film_role->get_film()->get_id())->url());
				$i++;
			}
			catch(Exception $e) {
				var_dump($e);
			}
		}
		array_multisort($role,SORT_STRING,SORT_ASC,$film,SORT_STRING,SORT_ASC,$this->film_roles);
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('actor','page','view'));
		$template->title = $this->actor->get_description()->get_title();
		$template->body = $this->actor->get_description()->get_body();
		$template->film_roles = $this->film_roles;
		$template->modes = $this->modes;
		return $template;
	}
}

