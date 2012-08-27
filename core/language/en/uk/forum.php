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
			'title' => 'Forums',
			'Add' => 'Add forum',
			'Manage' => 'Manage forums',
			'Permissions' => 'Permissions',	
		),
		'list' => array(
			'title' => 'Forums',
			'description' => 'In mCMS a category is just a special type of forum. Each forum can have an unlimited number of sub-forums and you can determine whether each may be posted to or not. Here you can add, edit, delete, lock, unlock individual forums as well as set certain additional controls. If your posts and topics have got out of sync you can also resynchronise a forum.',
			'top' => 'Board index',
			'up' => 'Move up',
			'down' => 'Move down',
			'edit' => 'Edit',
			'resync' => 'Resynchronise',
			'delete' => 'Delete'
		),
		'edit' => array(
			'title' => 'Title:',
			'description' => 'Description:',
			'language_field' => 'Language:',
			'no_lang' => 'No Default Language',
			'parent' => 'Parent Forum:',
			'no_parent' => 'No Parent',
			'depth' => 'Forum Depth:',
			'has_topics' => 'Contains Topics:',
			'submit' => 'Update' 
		)
	)
);
