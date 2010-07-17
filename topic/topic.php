<?php
class Topic {
	private $id;
	private $type;
	private $content;
	private $locked;
	private $hidden;
	private $module;
	private $views;
	private $forum;
	private $firstauthor;
	private $firstdate;
	private $lastauthor;
	private $lastdate;
	private $posts;

	public get_id() {
		return $this->id;
	}
	public get_type() {
		return $this->type;
	}
	public get_content() {
		if(!$this->content instanceof Content) {
			$this->content = Content::Get_By_ID($this->content);
		}
		return $this->content;
	}
	public get_locked() {
		return $this->locked;
	}
	public get_hidden() {
		return $this->hidden;
	}
	public get_views() {
		return $this->get_views();
	}
	public get_firstauthor() {
		if(!$this->firstauthor instanceof User) {
			$this->firstauthor = User::Get_By_ID($this->firstauthor);
		}
		return $this->firstauthor;
	}
	public get_firstdate() {
		return $this->firstdate;
	}
	public get_lastauthor() {
		if(!$this->lastauthor instanceof User) {
			$this->lastauthor = User::Get_By_ID($this->lastauthor);
		}
		return $this->firstauthor;
	}
	public get_lastdate() {
		return $this->lastdate;
	}
	public static Get_By_ID($id) {
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_One($operator, $operand){
		$query = System::Get_Instance()->database()->Select()->table('topic')->where($operator, $operand)->limit(1);
		$result = $query->execute();
		if($result->num_rows == 0){
			throw new Topic_Not_Found_Exception($operator, $operand);
		}
		return $result->fetch_object('Topic');
	}
	public static Get_All() {
		$query = System::Get_Instance()->database()->Select()->table('topic')->order(array('lastdate' => true));
		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Topic')){
			$return[] = $row;
		}
		return $return;
	}
}