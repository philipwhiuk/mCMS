var tb;            // Global Thickbox Controller.

function image_init(imgPath, closePath){

$(document).ready(function($){

    var imgLoader = new Image();
    imgLoader.src = imgPath;

    var image_show = function(img){
        $('#TB_load').show();
        var image = $(img);
        $.ajax({
            dataType: 'html',
            url: image.attr('href'),
            error: function (req, text, error){ alert(text); },
            success: function(data){
                if(tb == img){
                    imgpl = $("div.gallery-image-item img", data);
                    var imgPreloader = new Image();
                    imgPreloader.onload = function(){
                        var de = document.documentElement;
                        var w = window.innerWidth || self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
                        var h = window.innerHeight || self.innerHeight || (de&&de.clientHeight) || document.body.clientHeight;

                        // From Thickbox
                        var x = w - 150;
                        var y = h - 150;
                        var imageWidth = imgPreloader.width;
                        var imageHeight = imgPreloader.height;
                        
                        if (imageWidth > x) {
                            imageHeight = imageHeight * (x / imageWidth); 
                            imageWidth = x; 
                            if (imageHeight > y) { 
                                imageWidth = imageWidth * (y / imageHeight); 
                                imageHeight = y; 
                            }
                        } else if (imageHeight > y) { 
                            imageWidth = imageWidth * (y / imageHeight); 
                            imageHeight = y; 
                            if (imageWidth > x) { 
                                imageHeight = imageHeight * (x / imageWidth); 
                                imageWidth = x;
                            }
                        }

                        inner = $('#TB_inner');
                        win = $('#TB_window_image');
                        inner.empty();
                        $("div.gallery-item-internal", data).appendTo(inner);
                        img = $("#TB_window_image div.gallery-image-item img");
                        links  = $("#TB_window_image div.gallery-item-links");

                        $("#TB_window_image .gallery-item-links-link a").click(function(evt){
                            if(tb == null){ return false; }
                            tb = this;
                            evt.preventDefault();

                            $("#TB_load").show();
                            $("#TB_window_image").hide();

                            image_show(this);
                            return false;

                        });
                        
                        var winwidth = imageWidth + 50;

                        var winleft = (w - winwidth) / 2;
                        img.css({height: imageHeight, width: imageWidth});
                        links.css({width: imageWidth});
                        win.css({display:"block", left: winleft, width: winwidth });
                        $('#TB_load').hide();

                    }
                    // Loaded image
                    imgPreloader.src = imgpl.attr("src");
                }
            }
        });

        return false;
    }

    $(".gallery .gallery-items-images-selector a.gallery-items-images-image").click(function(evt){
        if(tb != null){ $('.thickbox').remove(); tb = null; }

        tb = this;

        $("body").append("<div id='TB_overlay' class='thickbox'></div><div class='thickbox' id='TB_window_image'><div id='TB_close' class='thickbox'><img src='" + closePath + "' /></div><div id='TB_inner'></div></div>");
    
        $('#TB_close').click(function(){ $(".thickbox").remove(); tb = null; evt.preventDefault(); return false; });

        var userAgent = navigator.userAgent.toLowerCase();
        if (userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1) {
            $("#TB_overlay").addClass("TB_overlayMacFFBGHack");
        } else {
            $("#TB_overlay").addClass("TB_overlayBG");
        }

        evt.preventDefault();

        $("#TB_overlay").click(function(){ $(".thickbox").remove(); tb = null; });

        document.onkeydown = function(e){     
            if (e == null) { // ie
                keycode = event.keyCode;
                tb = null;
            } else { // mozilla
                keycode = e.which;
                tb = null;
            }
            if(keycode == 27){ // close
                $(".thickbox").remove();
                tb = null;
            } 
        };

        $("body").append("<div class='thickbox' id='TB_load'><img src='"+imgPath + "' /></div>");

        image_show(this);

        return false;
    });

});


}