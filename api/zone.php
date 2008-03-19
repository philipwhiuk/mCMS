<?php

/**
 * Zone API File
 *
 * Subversion ID: $Id: page.php 16 2007-12-26 19:47:06Z agentscorpion $
**/

class Zone extends API  {

  function __construct($data){
    $this->zones = array();
    $this->blocks = array();
    $this->width = 100;
    $this->ran = false;
    foreach($data as $f => $v){ $this->$f = $v; } 
  }
  
  function run(){
  
  }
  
  function output(){
    $template = new Template;
    //$template = Fusion::$_->output->template('zone/view');
    return $template;
  }

/*
  function __construct($data){
    $this->zones = array();
    $this->width = 100;
    $this->ran = false;
    foreach($data as $f => $v){ $this->$f = $v; }
  }
  
  function run_view(Page $page, $remainder){
    // Run Sub Zones
    foreach($this->zones as $r => &$row){
      foreach($row as $c => &$col){
        foreach($col as $z => &$zone){
          if($zone->run($page, $remainder) == false){
            unset($this->zones[$r][$c][$z]);
          }
        }
      }
    }
    // Run Blocks
    $this->blocks = Block::Load($this->id, $page, $remainder);
    foreach($this->blocks as $b => &$row){
      foreach($row as $c => &$block){
        $block->run();
      }
    }
    $this->mode = 'view';
  }
  
  function run_edit_new_block(Page $page, $remainder){
		$this->form = new Form('zone_edit_new_block' . $this->id, Fusion::URL($page->URL('edit/' . $this->id . '/new_block')));
		$this->form->field('name',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => '',
			'title' => Fusion::$_->locale->get('Zone/edit/new_block/name')
		));
		$this->form->field('type',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => '',
			'title' => Fusion::$_->locale->get('Zone/edit/new_block/type')
		));
		$this->form->field('sort',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => '', // get last + 1
			'title' => Fusion::$_->locale->get('Zone/edit/new_block/sort')
		));
		$this->form->field('submit',array(
			'type' => 'submit',
			'title' => Fusion::$_->locale->get('Zone/edit/new_block/submit')
		));
		
		if($data = $this->form->run()){
      unset($data['submit']);
      $data['zone'] = $this->id;
      Block::Create($data);
			Fusion::Redirect($page->URL('edit'));
      exit;
		}
    $this->mode = 'new_block';
    return true;
  }
  
  function run_edit_new_zone(Page $page, $remainder){
		$this->form = new Form('zone_edit_new_zone' . $this->id, Fusion::URL($page->URL('edit/' . $this->id . '/new_zone')));
		$this->form->field('name',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => '',
			'title' => Fusion::$_->locale->get('Zone/edit/new_zone/name')
		));
		$this->form->field('width',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => '100',
			'title' => Fusion::$_->locale->get('Zone/edit/new_zone/width')
		));
		$this->form->field('row',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => '', // Get max row + 1
			'title' => Fusion::$_->locale->get('Zone/edit/new_zone/row')
		));
		$this->form->field('sort',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => '', // depends on row
			'title' => Fusion::$_->locale->get('Zone/edit/new_zone/sort')
		));
		$this->form->field('submit',array(
			'type' => 'submit',
			'title' => Fusion::$_->locale->get('Zone/edit/new_zone/submit')
		));
		
		if($data = $this->form->run()){
      unset($data['submit']);
      $data['parent'] = $this->id;
      $data['template'] = $this->template;
      Zone::Create($data);
			Fusion::Redirect($page->URL('edit'));
      exit;
		}
    $this->mode = 'new_zone';
    return true;
  }
  
  function run_edit_move_zone_left(Page $page, $remainder){
    $this->move_left();
		Fusion::Redirect($page->URL('edit'));
  }
  
  function move_left(){
    $this->update(array('sort' => $this->left->sort));
    $this->left->update(array('sort' => $this->sort));
    return;
  }
  
  function run_edit_move_zone_up(Page $page, $remainder){
    $this->move_up();
		Fusion::Redirect($page->URL('edit'));
  }
  
  function move_up(){
    $sql = "UPDATE page_template_zone SET row = %u WHERE row = %u AND template = %u ";
    Fusion::$_->storage->query($sql, $this->row, $this->up, $this->template);
    $this->update(array('row' => $this->up));
    return;
  }
  
  function run_edit_edit_zone(Page $page, $remainder){
		$this->form = new Form('zone_edit_edit_zone' . $this->id, Fusion::URL($page->URL('edit/' . $this->id . '/edit_zone')));
		$this->form->field('name',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => $this->name,
			'title' => Fusion::$_->locale->get('Zone/edit/edit_zone/name')
		));
		$this->form->field('width',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => $this->width,
			'title' => Fusion::$_->locale->get('Zone/edit/edit_zone/width')
		));
		$this->form->field('row',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => $this->row, // Get max row + 1
			'title' => Fusion::$_->locale->get('Zone/edit/edit_zone/row')
		));
		$this->form->field('sort',array(
			'type' => 'textbox',
			'validation' => 'required',
			'value' => $this->sort, // depends on row
			'title' => Fusion::$_->locale->get('Zone/edit/edit_zone/sort')
		));
		$this->form->field('submit',array(
			'type' => 'submit',
			'title' => Fusion::$_->locale->get('Zone/edit/edit_zone/submit')
		));
		
		if($data = $this->form->run()){
      unset($data['submit']);
      $data['parent'] = $this->parent;
      $data['template'] = $this->template;
      $this->Update($data);
			Fusion::Redirect($page->URL('edit'));
      exit;
		}
    $this->mode = 'edit_zone';
    return true;  
  }
  
  function run_edit(Page $page, $remainder){
    // Zone Header Links
    if($this->id > 0){
      $this->tools = array(
        'new_zone' => array('name' => Fusion::$_->locale->get('Zone/edit/new_zone'), 'url' => Fusion::URL($page->URL('edit/' . $this->id . '/new_zone'))),
        'new_block' => array('name' => Fusion::$_->locale->get('Zone/edit/new_block'), 'url' => Fusion::URL($page->URL('edit/' . $this->id . '/new_block'))),
        'edit_zone' => array('name' => Fusion::$_->locale->get('Zone/edit/edit_zone'), 'url' => Fusion::URL($page->URL('edit/' . $this->id . '/edit_zone'))),
        'delete_zone' => array('name' => Fusion::$_->locale->get('Zone/edit/delete_zone'), 'url' => Fusion::URL($page->URL('edit/' . $this->id . '/delete_zone')))
      );
      
      if(isset($this->left)) // Can Move left
        $this->tools['move_zone_left'] = array('name' => Fusion::$_->locale->get('Zone/edit/move_zone_left'), 'url' => Fusion::URL($page->URL('edit/' . $this->id . '/move_zone_left')));
        
      if(isset($this->up)) // Can Move left
        $this->tools['move_zone_up'] = array('name' => Fusion::$_->locale->get('Zone/edit/move_zone_up'), 'url' => Fusion::URL($page->URL('edit/' . $this->id . '/move_zone_up')));
      
    } else {  
      $this->tools = array(
        'new_zone' => array('name' => Fusion::$_->locale->get('Zone/edit/new_zone'), 'url' => Fusion::URL($page->URL('edit/' . $this->id . '/new_zone'))),
        'new_block' => array('name' => Fusion::$_->locale->get('Zone/edit/new_block'), 'url' => Fusion::URL($page->URL('edit/' . $this->id . '/new_block')))
        );
    }
  
    $r = explode('/', $remainder, 3);
    if($r[0] == $this->id && isset($r[1]) && isset($this->tools[$r[1]])){
      $f = 'run_edit_' . $r[1];
      $rem = '';
      if(isset($r[2])){ $rem = $r[2]; }
      if($this->$f($page, $r[2])){
        return;
      }
    }
    // Run Sub Zones
    $u = NULL;
    ksort($this->zones);
    foreach($this->zones as $r => &$row){ 
      $l = NULL;
      ksort($row);
      foreach($row as $c => &$col){
        ksort($col);
        foreach($col as $z => &$zone){
          $this->zones[$r][$c][$z]->left = $l;
          $this->zones[$r][$c][$z]->up = $u;
          if($this->zones[$r][$c][$z]->run($page, $remainder, $render_full) == false){
            unset($this->zones[$r][$c][$z]);
          } else {
            $l = $zone;
          }
        }
      }
      $u  = $r;
    }

    
    // Run Blocks
    $this->blocks = Block::Load($this->id, $page, $remainder);
    foreach($this->blocks as $b => &$row){
      foreach($row as $c => &$block){
        $block->run();
      }
    }
    $this->mode = 'edit';
  }
  
  function run(Page $page, $remainder){
    if($this->ran){
      return false;
    }
    $this->ran = true;
    $f = 'run_' . $page->mode;
    $this->$f($page, $remainder);
    return true;
  }

  function output(){
    $f = 'output_' . $this->mode;
    return $this->$f();
  }
  
  function output_view(){
    $template = Fusion::$_->output->template('zone/view');
    
    // Output sub zones
    
    $template->zones = array();
    foreach($this->zones as $r => &$row){
      foreach($row as $c => &$col){
        foreach($col as $z => &$zone){
          $template->zones[$r][$c][$z] = $zone->output($page);
        }
      }
      ksort($template->zones[$r]);
    }
    ksort($template->zones);
    
    // Output Sub blocks
    
    $template->blocks = array();
    foreach($this->blocks as $r => &$row){
      foreach($row as $b => &$block){
        $template->blocks[$r][$b] = $block->output();
      }
      ksort($template->blocks[$r]);
    }
    
    // Size zone
    
    $template->width = $this->width;
    $template->row = $this->row;
    
    return $template;
  }
  
  function output_new_zone(){
    $template = Fusion::$_->output->template('zone/new_zone');
    $template->tools = $this->tools;
    $template->name = $this->name;
    $template->form = $this->form->output();
    // Size zone
    $template->width = $this->width;
    $template->row = $this->row;
    return $template;    
  }
  
  function output_edit_zone(){
    $template = Fusion::$_->output->template('zone/edit_zone');
    $template->tools = $this->tools;
    $template->name = $this->name;
    $template->form = $this->form->output();
    // Size zone
    $template->width = $this->width;
    $template->row = $this->row;
    return $template;    
  }
  
  function output_new_block(){
    $template = Fusion::$_->output->template('zone/new_zone');
    $template->tools = $this->tools;
    $template->name = $this->name;
    $template->form = $this->form->output();
    // Size zone
    $template->width = $this->width;
    $template->row = $this->row;
    return $template;    
  }
  
  function output_edit(){
    $template = Fusion::$_->output->template('zone/edit');
    
    // Output sub zones
    
    $template->zones = array();
    foreach($this->zones as $r => &$row){
      foreach($row as $c => &$col){
        foreach($col as $z => &$zone){
          $template->zones[$r][$c][$z] = $zone->output($page);
        }
      }
      ksort($template->zones[$r]);
    }
    ksort($template->zones);
    
    // Header
    
    $template->tools = $this->tools;
    $template->name = $this->name;
    
    // Blocks Form
    
    $template->blocks = array();
    foreach($this->blocks as $r => &$row){
      foreach($row as $b => &$block){
        $template->blocks[$r][$b] = $block->output();
        $template->blocks[$r][$b]->name = $block->name;
      }
      ksort($template->blocks[$r]);
    }
    
    // Size zone
    
    $template->width = $this->width;
    $template->row = $this->row;
    
    return $template;
  }

  static function Create($data){
    $sqls = array();
    foreach($data as $k => $v){
      $sqls[] = " $k = %s ";
    }
    $sql = "INSERT INTO page_template_zone SET " . join($sqls, ' , ');
    return ($result = Fusion::$_->storage->query($sql, $data));
  }
  
  function Update($data){
    $sqls = array();
    foreach($data as $k => $v){
      $sqls[] = " $k = %s ";
    }
    $sql = "UPDATE page_template_zone SET " . join($sqls, ' , ') . " WHERE id = %u ";
    $data['id'] = $this->id;
    return ($result = Fusion::$_->storage->query($sql, $data));

  }

  static function Load($template){
    $master = - $template;
    $zones = array(
      $master => new Zone(
        array(
          'id' => $master,
          'template' => $template,
          'name' => Fusion::$_->locale->get('Zone/page'),
          'width' => 100,
          'row' => 0,
          'sort' => 0
        )
      )
    );
    $sql = "SELECT * FROM page_template_zone WHERE template = %u";
    $result = Fusion::$_->storage->query($sql, $template);
    if($result){
      while($row = $result->fetch_assoc()){
        $zones[$row['id']] = new Zone($row);
      }
    }
    
    foreach($zones as $z => &$zone){
      if($z != $master){
        if(isset($zones[$zone->parent])){
          $zones[$zone->parent]->zones[$zone->row][$zone->sort][$zone->id] = $zone;
          $zone->pzobj = $zones[$zone->parent];
        } elseif($zone->parent == 0) {
          $zones[$master]->zones[$zone->row][$zone->sort][$zone->id] = $zone;
          $zone->pzobj = $zones[$master];
        } else {
          // Error
          $zones[$master]->zones[99][][$zone->id] = $zone;
        }
      }
    }
    
    return $zones[$master];  
  }

*/

}
