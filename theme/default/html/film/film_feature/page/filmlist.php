<?php
class Template_Theme_Flix_HTML_Film_Film_Feature_Page_FilmList extends Template {
	public function __construct($parent) {
		parent::__construct($parent);
	}
	public function display() {
		?>
        <tr><td><a href="<?php echo $this->url; ?>"><?php echo $this->title; ?></a></td></tr>
        <?php
	}
}
	