<?php

class Template_RSS_News_Feed extends Template {

	public function display(){

?> 
<channel> 
<?php if($this->category !== false){ ?>
	<title><?php echo $this->category['title']; ?></title>
	<link><?php echo $this->category['link']; ?></link>
	<description><?php echo $this->category['body']; ?></description>
<?php } 

foreach($this->articles as $article){ 
?>
	<item>
		<title><?php echo $article['title']; ?></title>
		<link><?php echo $article['slink']; ?></link>
		<description><?php echo $article['body']; ?></description>
	</item>
<?php	
}
?>
</channel>
<?php

	}

}
