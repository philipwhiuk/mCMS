<?php

abstract class Admin_Dashboard extends Admin {
	protected $parent;
	protected $mode;
	private $selected;

	public static function Load_Menu($panel, $parent) {
		$parent->resource()->get_module()->file('dashboard/menu');
		return new Admin_Dashboard_Menu($panel,$parent);
	}
	
	public static function Load_Main($panel, $parent) {
		$arg = $parent->resource()->get_argument();
		try {
			switch($arg) {
				case 'resources':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/resources');
					return new Admin_Dashboard_Resources($panel,$parent);
					break;
				case 'sites':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/sites');
					return new Admin_Dashboard_Sites($panel,$parent);
					break;					
				case 'modules':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/modules');
					return new Admin_Dashboard_Modules($panel,$parent);
					break;
				case 'updates':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/updates');
					return new Admin_Dashboard_Updates($panel,$parent);
					break;
				case 'settings':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/settings');
					return new Admin_Dashboard_Settings($panel,$parent);
					break;
				case 'statistics':
					$parent->resource()->consume_argument();
					$parent->resource()->get_module()->file('dashboard/statistics');
					return new Admin_Dashboard_Statistics($panel,$parent);
					break;
				case 'overview':
					$parent->resource()->consume_argument();				
				default:
					$parent->resource()->get_module()->file('dashboard/overview');
					return new Admin_Dashboard_Overview($panel,$parent);
					break;
			}
		} catch(Exception $e){
			$parent->resource()->get_module()->file('dashboard/overview');
			return new Admin_Dashboard_Overview($panel,$parent);
		}
	}
	
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->url = $this->url();		
	}
	public function execute($parent) {
		$this->parent = $parent;
	}
	
	public function execute_resources() {
		parent::execute($parent);
		$this->mode = 'resources'; 
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$arg = (int) $arg;
			$this->resources = Resource::Get_Selection(20, ($arg - 1) * 20);
			$this->parent->resource()->consume_argument();
			$this->page = $arg;
		} else {
			$this->page = 1;
			$this->resources = Resource::Get_Selection(20);
		}

		$count = Resource::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('dashboard','resources','edit'));
		$this->title = $language->get($this->module, array('dashboard','resources','title'));
		$this->resourcePath = $language->get($this->module, array('dashboard','resources','resourcePath'));

		
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('resources/' . $pg);
		}
		$this->selected = 'Resources';
	}
	public function execute_modules() {
		$this->mode = 'modules';  
		$arg = $this->parent->resource()->get_argument();
		if(is_numeric($arg) && ((int) $arg) > 0){
			$arg = (int) $arg;
			$this->modules = Module::Get_Selection(20, ($arg - 1) * 20);
			$this->parent->resource()->consume_argument();
			$this->page = $arg;
		} else {
			$this->page = 1;
			$this->modules = Module::Get_Selection(20);
		}

		$count = Module::Count_All();
		$this->page_count = ((int) ($count / 20)) + ((($count % 20) == 0) ? 0 : 1);
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('dashboard','modules','edit'));
		$this->title = $language->get($this->module, array('dashboard','modules','title'));
		$this->moduleName = $language->get($this->module, array('dashboard','modules','moduleName'));
		$this->packageName = $language->get($this->module, array('dashboard','modules','packageName'));	
		$this->version = $language->get($this->module, array('dashboard','modules','version'));

		
		for($pg = 1; $pg <= $this->page_count; $pg ++){
			$this->pages[$pg] = $this->url('modules/' . $pg);
		}
		$this->selected = 'Modules';
	}
	public function execute_updates() {
		$this->mode = 'updates';  
		$this->selected = 'Updates';
	}
	public function execute_settings() {
		$this->mode = 'settings';  
		$this->selected = 'Settings';
	}
	public function execute_sites() {
		$this->mode = 'sites';  
		$language = Language::Retrieve();
		$this->edit = $language->get($this->module, array('dashboard','sites','edit'));
		$this->title = $language->get($this->module, array('dashboard','sites','title'));
		$this->siteName = $language->get($this->module, array('dashboard','sites','siteName'));
		$this->selected = 'Sites';
	}
	public function execute_statistics() {
		$this->mode = 'statistics';  
		$this->selected = 'Statistics';
	}	


	public function display_modules() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','modules'));
		$template->edit = $this->edit;
		$template->moduleName = $this->moduleName;
		$template->packageName = $this->packageName;	
		$template->version = $this->version;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->modules as $module){
			$mT = array();
			$mT['name'] = $module->name();
			$mT['version'] = $module->version();
			if($module->package() != null) {
				$mT['package'] = $module->package()->name() ;
			} else {
				$mT['package'] = '';
			}
			$mT['edit'] = $this->url('edit/' . $module->id());		
			$template->modules[] = $mT;
		}
		return $template;
	}
	public function display_resources() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','resources'));
		$template->edit = $this->edit;
		$template->resourcePath = $this->resourcePath;
		$template->title = $this->title;
		$template->pages = $this->pages;
		$template->page_count = $this->page_count;
		$template->page = $this->page;
		foreach($this->resources as $resource){
			$rT = array();
			$rT['path'] = $resource->get_path();
			$rT['edit'] = $this->url('edit/' . $resource->get_id());		
			$template->resources[] = $rT;
		}
		return $template;
	}
	public function display_sites() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','sites'));
		$template->title = $this->title;
		return $template;
	}
	public function display_updates() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','updates'));
		return $template;
	}
	public function display_settings() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','updates'));
		return $template;
	}
	public function display_statistics() {
		$template = MCMS::Get_Instance()->output()->start(array('admin','dashboard','updates'));
		return $template;
	}
}
