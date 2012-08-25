<?php

class Template_Theme_Flix_HTML_Film_Feature_Page_Edit extends Template {
	public function display(){
?>		
<div class="page-edit content page-content content-edit page-content-edit">
	<h1><?php echo $this->title; ?></h1>
<div class="film_feature-edit">
	<h1>Film Feature: Edit</h1>
	<div class="overview">
		<div class="overview_item">
			<div class="overview_heading title_heading">Title</div>
			<div class="overview_data title_data"></div>
		</div>
		<div class="overview_item">
			<div class="overview_heading description_heading">Description</div>
			<div class="overview_data description_data"></div>
		</div>
		<div class="overview_item">
			<div class="overview_heading category_heading">Category</div>
			<div class="overview_data category_data"></div>
			<div class="overview_ext category_ext"></div>
		</div>
	</div>
	<h2>Films</h2>
	<div class="films">
	</div>
	<h2>Showings</h2>
	<div class="showings">
	</div>
	<h2>Film Festivals</h2>
	<div class="festivals">
	</div>
	<h2>Events</h2>
	<div class="events">
	</div>
</div>
	<div class="film_feature-form">
		<?php echo $this->form->display(); ?> 
	</div> 
</div>
<?php	
	}	
}