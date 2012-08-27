<?php
class Admin_Dashboard_Modules extends Admin_Dashboard {
	public function __construct($a,$b){
		parent::__construct($a,$b);
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
	}
	public function display() {
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
}