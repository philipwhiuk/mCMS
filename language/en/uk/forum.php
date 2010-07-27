<?php

return array(
	'forum' => array(
		'view_forum' => 'View Forum',
		'view' => array(),
		'edit' => array(),
		'delete' => array(),
		),
	'topic' => array(
		'view_topic' => 'View Topic',
		'view' => array(),
		'add' => array(
			'title_main' => 'Add Forum Topic',
			'title' => 'Topic Title',
			'description' => 'Description',
			'post_title' => 'Post Title',
			'post_body' => 'Post',
			'submit' => 'Submit'			
			),
		'edit' => array(),
		'delete' => array(),
		),
	'post' => array(
		'view_topic' => 'View Topic',
		'view' => array(),
		'edit' => array(),
		'delete' => array(),
		),
	'edit' => array(
		'title' => 'Title:',
		'body' => 'Body:',
		'submit' => 'Update' 
	),
	'list' => array(
		'title' => 'Content List'
	),
	'add' => array(
		'title_main' => 'Add New Content',
		'title' => 'Title:',
		'body' => 'Body:',
		'submit' => 'Add' 
	),
	'modes' => array(
		'add' => 'Add',
		'view' => 'View',
		'list' => 'List',
		'edit' => 'Edit',
		'delete' => 'Delete'
	),
	'admin' => array(
		'menu' => array(
			'name' => 'Forum'
		),
		'list' => array(
			'edit' => 'Edit',
			'title' => 'Forum List'
		),
		'edit' => array(
			'title' => 'Title:',
			'description' => 'Description:',
			'language_field' => 'Language:',
			'parent' => 'Parent Forum:',
			'depth' => 'Forum Depth:',
			'has_topics' => 'Contains Topics:',
			'submit' => 'Update' 
		)
	)
);
