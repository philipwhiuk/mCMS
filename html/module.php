<?php
class HTML_Module extends Module {
	public function Load() {
		Module::Get('theme');
		Module::Get('page');
	}
}