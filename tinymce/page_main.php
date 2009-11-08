<?php

abstract class TinyMCE_Page_Main extends Page_Main {
	
	public static function Load($parent){
		switch($parent->resource()->get_argument()){
			case "files":
				// Filemanager
				if(isset($_REQUEST['tinymce']) && isset($_REQUEST['tinymce']['type']) && isset($_REQUEST['tinymce']['url'])){
					$type = $_REQUEST['tinymce']['type'];
					$url = $_REQUEST['tinymce']['url'];
					$parent->resource()->get_module()->file('page_main/files');
					$parent->resource()->consume_argument();
					return new TinyMCE_Page_Main_Files($parent, $type, $url);
				}
				break;
		}
	}
	
	
}