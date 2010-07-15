<?php

class Film_Module extends Module {
	
	public function load(){
		
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('content');
		Module::Get('image');
		Module::Get('film_certificate');
		Module::Get('actor');
		
		$this->files('film','film_trailer','film_tagline','film_role','film_role_film_actor','film_genre','film_genre_film','exception');
	}
	
}