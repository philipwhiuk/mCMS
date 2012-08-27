<?php
class Film_Admin_Edit extends Film_Admin {
	public function __construct($a,$b){
		parent::__construct($a,$b);
		$this->mode = 'edit';
		$arg = $this->parent->resource()->get_argument();
		$this->film = Film::Get_By_ID($arg);
		$this->parent->resource()->consume_argument();

		try {
		
		$this->buildForm();
		} catch (Exception $e) {
			var_dump($e);
			throw $e;
		}
		try {
			$data = $this->form->execute();
			$this->film->update($data);
			MCMS::Get_Instance()->redirect($this->url('list'));
		} catch(Form_Incomplete_Exception $e){
		}
	}
	public function buildForm() {
		$language = Language::Retrieve();
		$this->form = new Form(array('film',$this->film->get_id(), 'admin'), $this->url('edit/' . $this->film->get_id()));

		$title = Form_Field::Create('title', array('textbox'));
		$title->set_label($language->get($this->module, array('admin','edit','title')));
		$description = Form_Field::Create('description', array('richtext','textarea'));
		$description->set_label($language->get($this->module, array('admin','edit','description')));
		
		try {
			$title->set_value($this->film->get_description()->get_title());
			$description->set_value($this->film->get_description()->get_body());
		} catch (Content_Not_Found_Exception $e) {
		
		}
		
		$release_year = Form_Field::Create('release_year', array('textbox'));
		$release_year->set_label($language->get($this->module, array('admin','edit','release_year')));
		$release_year->set_value($this->film->get_release_year());
		
		$certificate = Form_Field::Create('certificate', array('select'));
		$certificate->set_label($language->get($this->module, array('admin','edit','certificate')));
		$certs = Film_Certificate::Get_All();
		try {
			$current_cert = $this->film->get_certificate()->get_id();
		}
		catch (Film_Certificate_Not_Found_Exception $e) {
			$current_cert = 0;
		}
		foreach ($certs as $cert) {
			if($cert->get_id() == $current_cert) {
				$certificate->set_option($cert->get_id(),$cert->get_image()->description()->get_title(),true);
			}
			else {
				$certificate->set_option($cert->get_id(),$cert->get_image()->description()->get_title(),false);
			}
		}
		
		$synopsis = Form_Field::Create('synopsis', array('richtext','textarea'));
		$synopsis->set_label($language->get($this->module, array('admin','edit','synopsis')));
		try { $synopsis->set_value($this->film->get_synopsis()->get_body()); } catch (Exception $e) {}
		
		$runtime = Form_Field::Create('runtime', array('textbox'));
		$runtime->set_label($language->get($this->module, array('admin','edit','runtime')));
		$runtime->set_value($this->film->get_runtime());
		
		$imdb = Form_Field::Create('imdb', array('textbox'));
		$imdb->set_label($language->get($this->module, array('admin','edit','imdb')));
		$imdb->set_value($this->film->get_imdb());
		
		$f_language = Form_Field::Create('language', array('select'));
		$f_language->set_label($language->get($this->module, array('admin','edit','language')));
		$f_langs = Film_Language::Get_All();
		try {
			$current_lang = $this->film->get_language()->get_id();
		}
		catch (Film_Language_Not_Found_Exception $e) {
			$current_lang = 0;
		}
		foreach ($f_langs as $f_lang) {
			if($f_lang->get_id() == $current_lang) {
				$f_language->set_option($f_lang->get_id(),$f_lang->get_content()->get_title(),true);
			}
			else {
				$f_language->set_option($f_lang->get_id(),$f_lang->get_content()->get_title(),false);
			}
		}
		
		$english_title = Form_Field::Create('english_title', array('textbox'));
		$english_title->set_label($language->get($this->module, array('admin','edit','english_title')));
		$english_title->set_value($this->film->get_english_title());
		
		$submit = Form_Field::Create('submit', array('submit'));
		$submit->set_label($language->get($this->module, array('admin','edit','submit')));
		
		$this->form->fields($title,$description,$release_year,$certificate,$synopsis,$runtime,$imdb,$f_language,$english_title,$submit);

	}
	public function display(){
		$template = MCMS::Get_Instance()->output()->start(array('film','admin','edit'));
		try {
			$template->title = $this->film->get_description()->get_title();
		} catch (Content_Not_Found_Exception $e) {
			$template->title = '';
		}
		$template->form = $this->form->display();
		return $template;
	}
}