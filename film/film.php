<?php

class Film {
	
	private $id;
	private $description;
	private $release_year;
	private $certificate;
	private $synopsis;
	private $runtime;
	private $imdbID;
	private $largeImage;
	private $smallImage;
	
	private function __construct($data = array()){
		foreach($data as $k => $v){ $this->$k = $v; }
	}
	public function get_id(){
		return $this->id;
	}
	public function get_description(){
		if(!($this->description instanceof Content)){
			$this->description = Content::Get_By_ID($this->description);
		}
		return $this->description;
	}
	public function get_trailers() {
		if(!isset($this->trailers)) {
			$this->trailers = Film_Trailer::Get_By_Film($this);		
		}
		return $this->trailers;
	}
	public function get_genres() {
		if(!isset($this->genres)) {
			$this->genres = Film_Genre_Film::Get_By_Film($this);		
		}
		return $this->genres;
	}
	public function get_role_actors() {
		if(!isset($this->role_actors)) {
			$this->role_actors = Film_Role_Film_Actor::Get_By_Film($this);		
		}
		return $this->role_actors;
	}
	public function get_taglines() {
		if(!isset($this->taglines)) {
			$this->taglines = Film_Tagline::Get_By_Film($this);		
		}
		return $this->taglines;
	}
	public function get_release_year(){
		return $this->release_year;
	}
	public function get_certificate(){
		if(!($this->certificate instanceof Film_Certificate)){
			$this->certificate = Film_Certificate::Get_By_ID($this->certificate);
		}
		return $this->certificate;
	}
	public function get_synopsis(){
		if(!($this->synopsis instanceof Content)){
			$this->synopsis = Content::Get_By_ID($this->synopsis);
		}
		return $this->synopsis;
	}
	public function get_runtime() {
		return $this->runtime;
	}
	public function get_imdb() {
		return $this->imdb;
	}
	public function get_largeImage() {
		if(!$this->largeImage instanceof Image){
			$this->largeImage = Image::Get_By_ID($this->largeImage);
		}
		return $this->largeImage;
	}
	public function get_smallImage() {
		if(!$this->smallImage instanceof Image){
			$this->smallImage = Image::Get_By_ID($this->smallImage);
		}
		return $this->smallImage;
	}
	public function get_director() {
		if(!$this->director instanceof Actor && $this->director != 0){
			$this->director = Actor::Get_By_ID($this->director);
		}
		else {
			throw new Actor_Not_Found_Exception();
		}
		return $this->director;
	}		
	public function module(){
		if(!($this->module instanceof Module)){
			$this->module = Module::Get_ID($this->module);
		}
		return $this->module;
	}
	
	public function trailers($offset, $limit){
		if(!isset($this->trailers)){
			if(!isset($this->class)){
				$this->class = $this->module()->load_section('Film_Trailer');
			}
			$this->trailers = call_user_func(array($this->class, 'Get_By_Film'), $this, $offset, $limit);
		}
		return $this->trailers;
	}	
	
	public function get_random_trailer() {
		$key = array_rand($this->get_trailers());
		if(is_int($key)) {
			$row = $this->trailers[$key];
			if(!$row instanceof Film_Trailer) {
				throw new Film_Trailer_Not_Found_Exception();
			}
		}
		else {
			throw new Film_Trailer_Not_Found_Exception();
		}
		return $row;
	}
	public function get_random_tagline() {
		if(count($this->get_taglines()) > 0) {
			$key = array_rand($this->get_taglines());	
			$row = $this->taglines[$key];
			if(!$row instanceof Film_Tagline) {
				throw new Film_Tagline_Not_Found_Exception();
			}
			return $row;
		}
		else {
			throw new Film_Tagline_Not_Found_Exception();
		}
	}
	
	public function get_language() {
		if(!$this->language instanceof Film_Language) {
			$this->language = Film_Language::Get_By_ID($this->language);
		}
		return $this->language;
	}
	
	public function Add($data){
		$database = System::Get_Instance()->database();
		$query = $database->insert()->table('film')
			->set(array(
					'release_year' => array('u', $data['release_year']),					// Number
					'runtime' => array('u', $data['runtime']),
					'imdbID' => array('u', $data['imdbID'])					
			));
		
		$query->execute();
		
		return new Content(array(
			'release_year' => $data['release_year'],
			'runtime' => $data['runtime'],
			'imdbID' => $data['imdbID'],			
			'id' => $database->insert_id		// TODO: Fix!
		));
	}
	
	public function update($data){
		try {
		$query = System::Get_Instance()->database()->Update()->table('film')
			->set(array(
					'release_year' => array('s', $data['release_year']),
					'runtime' => array('u', $data['runtime']),
					'imdb' => array('u', $data['imdb']),
					'largeImage' => array('u', $data['largeImage']),
					'smallImage' => array('u', $data['smallImage']),
					'certificate' => array('u', $data['certificate']),
			))
			->where('=', array(array('col','id'), array('u', $this->id)))->limit(1);
		$query->execute();
		$this->description->update(array('title' => $data['title'],'body' => $data['description']));
		$this->synopsis->update(array('title' => $this->synopsis->get_title(),'body' => $data['synopsis']));			
		$this->release_year = $data['release_year'];
		$this->runtime = $data['runtime'];
		$this->imdbID = $data['imdbID'];
		$this->largeImage = $data['largeImage'];
		$this->smallImage = $data['smallImage'];
		$this->certificate = $data['certificate'];
		}
		catch(Exception $e) {
			print_r($e);
			die();	
		}
	}
	
	public static function Get_All(){
		$query = System::Get_Instance()->database()->Select()->table('film');
		
		$result = $query->execute();
		
		$return = array();
		
		while($row = $result->fetch_object('Film')){
			$return[] = $row;
		}
		
		return $return;
	}
	public static function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}
	public static function Get_By_Feature($feature){
		if($feature instanceof Feature){
			$feature = $feature->id();
		}
		$query = System::Get_Instance()->database()
			->Select()
			->table('film_feature_film')
			->where('=', array(array('col','feature'), array('u', $feature)))
			->limit($limit)
			->offset($offset);
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_assoc()) {
			$query2 = System::Get_Instance()	->database()
			->Select()
			->table('film')
			->where('=', array(array('col','id'), array('u', $row['film'])))
			->limit($limit)
			->offset($offset);
			$result2 = $query2->execute();
			$return[]  = $result2->fetch_object('Film');
		}
		return $return;
	}	
	public static function Get_One($operator, $operand){
		
		$query = System::Get_Instance()->database()->Select()->table('film')->where($operator, $operand)->limit(1);
		
		$result = $query->execute();
		
		if($result->num_rows == 0){
			throw new Film_Not_Found_Exception($operator, $operand);
		}
		
		return $result->fetch_object('Film');
		
	}
	public static function Get_By_Language($language){
		$operator = '=';
		$operand = array(array('col','language'), array('u', $language));
		$query = System::Get_Instance()->database()->Select()->table('film')->where($operator, $operand);
		$result = $query->execute();
		$return = array();
		while($row = $result->fetch_object('Film')){
			$return[] = $row;
		}
		return $return;
	}
}