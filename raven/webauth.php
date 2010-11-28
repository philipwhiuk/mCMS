<?php

class Raven_Webauth extends Ucam_Webauth {

	private $url = null;

	function __construct($args){
		if(isset($args['url'])){
			$this->url = $args['url'];
		}
		return parent::__construct($args);
	}

	function url(){
		if(isset($this->url)){
			$url = $this->url;
		} else {
			$url = parent::url();
		}
	
		return $url;
	}

}
