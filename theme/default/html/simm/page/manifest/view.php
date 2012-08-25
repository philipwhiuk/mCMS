<?php
class Template_Theme_Default_HTML_Simm_Page_Manifest_View extends Template {
	public $title;
	public function display() {
		?>
		<h1><?php echo $this->title; ?></h1>
		<?php foreach ($this->roster as $department) { ?>
			<div class="simm-manifest-department-title simm-manifest-department<?php echo $department['id']; ?>-title"><?php echo $department['title']; ?></div>
			<table>
			<?php foreach ($department['positions'] as $position) { 
				foreach($position['characters'] as $character) { ?>
					<tr>
					<td><?php echo $position['title']; ?></td>
					<td></td>
					<td><?php echo $character['rank'];?> <a href="<?php echo $character['bio_url']; ?>"><?php echo $character['lastname'].', '.$character['firstname'].' '.$character['middlename']; ?></a></td>
					</tr><?php
				}
				
				for($i = 0; $i < $position['count_open']; $i++) { ?>
					<tr>
					<td><?php echo $position['title']; ?></td>
					<td></td>
					<td>Position Open</td>				
					</tr><?php
				}
			}
			?></table><?php
		}
	}

}