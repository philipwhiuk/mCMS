<?php

class File {

	private $id;
	private $name;
	private $path;
	private $mime;
	private $size;
	private $time;

	private function __construct($array = array()){foreach($array as $k => $v){ $this->$k = $v; }}

	private static function GenString($length){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters) -1 )];
		}
		return $string;
	}

	public static function Create($data){
		$system = System::Get_Instance();
		$site = $system->site();

		do {
			$path = 'file/upload/';
			$path_parts = (int) $site->get('file_path');
			$name_length = (int) $site->get('file_length');
	
			for($i = 1; $i <= $path_parts; $i ++){
				$path .= File::GenString($i) . '/';
			}

			$local = $system->local_path($path);		
			mkdir($local, 0777, true); // Permissions are controlled by umask.

			$name = File::GenString($name_length);
			$path .= $name;

			$data['path'] = $path;
	
			try {
				self::Get_One('=', array(array('col','path'), array('s', $path)));
				$found = false;
			} catch (Exception $e){
				$found = true;
			}
		} while(!$found);
		
		if(!isset($data['name'])){
			if(isset($data['extension'])){
				$data['name'] = $name . $data['extension'];
			} else {
				$data['name'] = $name;
			}
		}

		$data['time'] = isset($data['time']) ? $data['time'] : time();
		$data['size'] = isset($data['size']) ? $data['size'] : 0;
		$data['mime'] = isset($data['mime']) ? $data['mime'] : 'application/octet-stream';

		touch($system->local_path($path), $data['time']);
	
		$db = $system->database();

		$query = $db->Insert()->table('file')
			->set(array(
						'name' => array('s', $data['name']),
						'path' => array('s', $data['path']),
						'mime' => array('s', $data['mime']),
						'size' => array('u', $data['size']),
						'time' => array('u', $data['time'])
				   ));

		$result = $query->execute();
		
		$ndata = array(
				'id' => $db->insert_id(), 
				'name' => $data['name'],
				'path' => $data['path'], 
				'mime' => $data['mime'], 
				'size' => $data['size'],
				'time' => $data['time']
		);
	
		return new File($ndata);
	}

	public function update($data){
		$data['name'] = isset($data['name']) ? $data['name'] : $this->name;
		$data['path'] = isset($data['path']) ? $data['path'] : $this->path;
 		$data['mime'] = isset($data['mime']) ? $data['mime'] : $this->mime;
		$data['size'] = isset($data['size']) ? $data['size'] : $this->size;
		$data['time'] = isset($data['type']) ? $data['time'] : $this->time;

		$query = System::Get_Instance()->database()->Update()->table('file')
			->set(array(
					'name' => array('s', $data['name']),
					'path' => array('s', $data['path']),
					'mime' => array('s', $data['mime']),
					'size' => array('u', $data['size']),
					'time' => array('u', $data['time'])
			))
			->where('=', array(array('col','id'), array('u', $this->id)))->limit(1);
			
		$query->execute();
		
		$this->name = $data['name'];
		$this->path = $data['path'];
		$this->mime = $data['mime'];
		$this->size = $data['size'];
		$this->time = $data['time'];
	}

	public function id(){
		return $this->id;
	}

	public function name(){
		return $this->name;
	}

	public function location(){
		return System::Get_Instance()->local_path($this->path);
	}

	public function url(){
		$module = Module::Get('file');
		$resource = Resource::Get_By_Argument($module, $this->id);
		return System::Get_Instance()->url($resource->url(), array('output' => 'raw'));
	}

	public function size(){
		return $this->size;
	}

	public function mime(){
		return $this->mime;
	}

	static public function Get_By_ID($id){
		return self::Get_One('=', array(array('col','id'), array('u', $id)));
	}

        public static function Count_All(){
                $query = System::Get_Instance()->database()->Count()->table('file');
                return $query->execute();
        }

        public static function Get_All($limit = null, $skip = null){
                $query = System::Get_Instance()->database()->Select()->table('file')->order(array('name' => true));

		if(isset($limit)){
                        $query->limit($limit);
                        if(isset($skip)){
                                $query->offset($skip);
                        }
                }

		$result = $query->execute();

		$return = array();

		while($row = $result->fetch_object('File')){
			$return[] = $row;
		}

		return $return;
	}

	public static function Get_One($operator, $operand){

		$query = System::Get_Instance()->database()->Select()->table('file')->where($operator, $operand)->limit(1);

		$result = $query->execute();

		if($result->num_rows == 0){
			throw new File_Not_Found_Exception($operator, $operand);
		}

		$site = $result->fetch_object('File');

		return $site;

	}

}
