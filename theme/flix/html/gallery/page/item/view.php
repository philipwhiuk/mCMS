<?php

class Template_Theme_Flix_HTML_Gallery_Page_Item_View extends Template {

    public function display(){
?>
    <div class="page-view gallery page-gallery gallery-item page-gallery-item gallery-item-view page-gallery-item-view">
        <div class="gallery-info">
            <?php if($this->gallery['title'] != ''){ ?><h1><?php echo $this->gallery['title']; ?></h1><?php } ?>
            <?php echo $this->gallery['body']; ?>
        </div>
        <div class="gallery-item-internal">
        <div class="gallery-item">
            <?php $this->item->display(); ?>
        </div>
        <div class="gallery-item-links">
            <?php if($this->gallery['previous']){ ?>
            <div class="gallery-item-links-previous gallery-item-links-link">
                <a href="<?php echo $this->gallery['previous']; ?>">
                Previous
                </a>
            </div>
            <? } ?>
            <?php if($this->gallery['next']){ ?>
            <div class="gallery-item-links-next gallery-item-links-link">
                <a href="<?php echo $this->gallery['next']; ?>">
                                  Next
                </a>
                         </div>
             <? } ?>
        </div>
        </div>
    </div>
<?php
    }

}
