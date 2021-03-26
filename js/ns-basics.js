jQuery(document).ready(function($) {

	/***************************************************************************/
    //TABS
    /***************************************************************************/
    $( function() {
        $( ".tabs" ).tabs({
            create: function(event, ui) { 
                $(this).fadeIn(); 
            }
        });
    });

    /***************************************************************************/
    //ACCORDIONS
    /***************************************************************************/
    $(function() {
        $( ".accordion" ).accordion({
            heightStyle: "content",
            closedSign: '<i class="fa fa-minus"></i>',
            openedSign: '<i class="fa fa-plus"></i>',
            collapsible: true,
            active: false,
        });
    });

    /***************************************************************************/
    // Auto-Update Image Alt Text
    /***************************************************************************/
    $('img[data-auto-alt]').each(function() {

        var currentImg = $(this);
        var image_url = currentImg.attr('src');

        $.ajax({
            type : "post",
            url : ns_basics_local_script.ajaxurl,
            data : {action: "ns_basics_auto_img_alts", image_url:image_url},
            success: function(response) {
                if(response != '') { currentImg.attr('alt', response); }
            }
        });
    });


});