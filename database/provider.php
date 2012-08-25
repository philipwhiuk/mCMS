<?php
interface Database_Provider {
	public function query($sql /*, $arg1, $arg2 ... */);
	public function query_array($sql, $args);
	public function get();
	public function update();
	public function add();
}
