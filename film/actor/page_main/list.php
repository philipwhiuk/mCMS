<?php

class Actor_Page_Main_List extends Actor_Page_Main {
	
	private $actors = array();
	
	public function __construct($parent){
		$system = MCMS::Get_Instance();
		$module = Module::Get('actor');
		parent::__construct($parent);
		Permission::Check(array('actor'), array('view','edit','add','delete','list'),'list');
		$actors = Actor::Get_All();
		foreach($actors as $actor) {
			try {
				$ac_names[] = $actor->get_description()->get_title();
				$ac_url[] =  $system->url(
							Resource::Get_By_Argument(
								$module, 
								$actor->id()
							)->url());
				$this->actors[] = array(
					'name' => $actor->get_description()->get_title(),
					'url' => $system->url(Resource::Get_By_Argument($module, $actor->id())->url())
				);
			}
			catch(Content_Not_Found_Exception $ce) {
			}
		}
		array_multisort($ac_names,SORT_ASC,SORT_STRING,$ac_url,$this->actors);
	}
	
	public function display(){
		try {
			$template = MCMS::Get_Instance()->output()->start(array('actor','page','list'));
			$language = Language::Retrieve();
			$system = MCMS::Get_Instance();
			$module = Module::Get('actor');
		$template->title = $language->get($module, array('list','title'));
		$template->actor = $this->actors;
		return $template;
		}
		catch(Exception $e) {
			var_dump($e);
		}
	}
}