<?php
class Error_Page_Main_View extends Error_Page_Main {
	private $exceptions = array();
	private $exceptionsdata;

	public function extractExceptions($parent) {
		$data = $parent->data();
		if(is_object($data) && $data instanceof Exception) {
			$this->exceptions[] = $data;
			$this->extractExceptions($data);
		}
		else if(is_array($data)) {
//			var_dump($data);
//			exit();
			foreach($data as $member) {
				if(is_object($member) && $member instanceof Exception) {
					$this->exceptions[] = $member;
					$this->extractExceptions($member);
				}
				else if(is_array($member)) {
					foreach($member as $submember) {
						if(is_object($submember) && $submember instanceof Exception) {
							$this->exceptions[] = $submember;
							$this->extractExceptions($submember);
						}
					}
				}
			}
		}
	}
	
	public function __construct($parent) {
		$this->title = '';
		$this->modes = array();
		$this->body = '';
		$exceptions = MCMS::Get_Instance()->exceptions;
		$ex = array();
//		var_dump($exceptions);
		foreach($exceptions as $exception) {
			if($exception instanceof Exception) {
				$this->exceptions[] = $exception;
				$this->extractExceptions($exception);
			}
		}
		$ex = array_reverse($this->exceptions);
		foreach($ex as $e2) {
			$eT = array();
			if($e2 instanceof MCMS_Exception) {
				$eT['validSystemException'] = true;
			}
			else {
				$eT['validSystemException'] = false;
			}
			$eT['class'] = get_class($e2);
//			var_dump($e2);
			$eT['message'] = $e2->getMessage();
			$eT['trace'] = $e2->getTrace();
			$eT['name'] = str_replace('_',' ',substr($eT['class'],0,strpos($eT['class'],'_Exception')));
			$this->exceptionsdata[] = $eT;
		}
	}
	public function display() {
		$template = MCMS::Get_Instance()->output()->start(array('error','page','main','view'));
		$template->modes = $this->modes;
		$template->title = $this->title;
		$template->body = $this->body;
		$template->exceptions = $this->exceptionsdata;
		return $template;		
	}
}
