<?php

class Page_Block {

	private $id;
	private $source;
	private $layout;
	private $order;
	private $destination;
	private $resource;
	
	private $main;
	
	public function get_layout(){
		return $this->layout;
	}
	
	public function get_order(){
		return $this->order;
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('page','block'));
		$template->main = $this->main->display();
		return $template;
	}
	
	public function resource(){	
		if(!isset($this->resource)){
			$this->resource = Resource::Get_By_ID($this->source);
		}
		return $this->resource;
	}
	
	public function __construct($data = array(), $additional = ''){
		foreach($data as $k => $v){ $this->$k = $v; }
		$class = $this->resource()->get_module()->load_section('Page_Block_Main');
		$this->main = call_user_func(array($class, 'Load'), $this);
	}
	
	private static function Get_Raw($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('page_blocks')->where($operator, $operand);
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_assoc()){
			$return[] = $row;
		}
		
		return $return;
		
	}
	
	
	public static function Load($id, $args = array()){
		$blocks = self::Get_Raw(
			'OR', array (
				array('=', array(array('col','destination'), array('u', $id))),
				array('=', array(array('col','destination'), array('u', 0)))
			)
		);
		
		$return = array();
		
		foreach($blocks as $block){
			try {
				$return[] = new Page_Block($block, isset($args[$block['id']]) ? $args[$block['id']] : '');
			} catch(Exception $e){
				// Ignore exception 
			}
		}
		
		return $return;
	}
	
}