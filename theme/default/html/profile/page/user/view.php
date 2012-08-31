<?php
class Template_Theme_Default_HTML_Profile_Page_User_View extends Template {
	public $fields = array();
	function display() {
		?><div class="page-view user-view profile-view page-profile-view profile-user-view page-profile-user-view">
		<h1>User Profile - <?php echo $this->title; ?></h1>
		<div class="profile_fields">
		<?php foreach($this->fields as $field) {
			?><div class="field">
			<div class="field_label"><?php echo $field['title']; ?>:</div><?php
			?><div class="field_data"><?php $field['template']->display(); ?></div>
			</div>
			<?php
		}
		?>
		</div>
		</div>
		<?php
	}
}