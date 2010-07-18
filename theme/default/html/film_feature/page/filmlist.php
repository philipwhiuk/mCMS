<?php

class Template_Theme_Flix_HTML_Film_Feature_Page_FilmList extends Template {
	public $showings = array();
	public $films = array();
	public function display(){
?>		
<div class="film_feature page-film_feature film_feature-view page-film_feature-view page-view">
	<h1 align="center"><?php echo $this->title; ?></h1>
    <h3 align="center">Film List</h3>
	<table id='films' align="center">
		<tr> 
			<th class='date'>Name</th>
		</tr>
        	<?php foreach($this->films as $film) {
		$film->display();
	}
	?>
		<?php 
				foreach($this->showings as $showing) { ?>
		<tr> 
			<td class='date'><?php echo date("jS M Y",$showing); ?></td> 
			<td><?php echo date("g:iA",$showing); ?></td> 
		</tr> 
		<?php
		}
		?>
		</tr> 
	</table>

</div>
<?php	
	}	
}