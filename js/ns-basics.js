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

});