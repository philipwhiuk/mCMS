<?php

class Template_Theme_Flix_HTML_Image_Gallery_Page_Item_View extends Template {

// Replace with image code.
    public function get_file($target){
        ksort($this->files); 
        $current = null; $cfile = null;
        foreach($this->files as $match => $file){
            if($match == $target){
                return $file;
            }
            if(!isset($current) && $match > $target){
                return $file;
            } elseif(!isset($current)){
                $current = $match; $cfile = $file;
            } elseif($match < $target){
                $current = $match; $cfile = $file;
            } else { //if($current < $target, $match > $target){
                return $file;
            }
        }
        return $cfile;
    }

    public function display(){
?>
    <div class="gallery-image-item">
        <?php if($this->title != ''){ ?><h2><?php echo $this->title; ?></h2><?php } ?>
        <img style="width: 100%;" src="<?php $file = $this->get_file(500); echo $file['url']; ?>">
        <p style="margin: 1em; font-size: 120%; text-align: center; font-weight: bold;">
        <a style="color: black;" href="<?php echo $file['url']; ?>" target="_blank">Download Image</a>
        </p>
    </div>
<?php
    }
}
