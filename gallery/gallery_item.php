<?php

abstract class Gallery_Item {

	abstract public function next();
	abstract public function previous();

	abstract public static function Get_By_Gallery($gallery, $offset, $limit);
	abstract public static function Get_By_Gallery_ID($gallery, $object);
	abstract public static function Count_By_Gallery($gallery);
}

