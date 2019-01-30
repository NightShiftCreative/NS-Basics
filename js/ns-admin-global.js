jQuery(document).ready(function($) {

    /*************************************************************************/
    /** GLOBAL **/
    /** Shared admin scripts used across all Nightshift Themes and Plugins
    /*************************************************************************/

    /** COLOR PICKER **/
    $(function() {
        $('.color-field').wpColorPicker();
    });

    /** SINGLE MEDIA UPLOAD **/
    var mediaUploader;

    $('.admin-module').on('click', '.ns_upload_image_button', function(e) {
        e.preventDefault();
        formfield = jQuery(this).prev('input');

        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
          mediaUploader.open();
          return;
        }
        // Extend the wp.media object
        mediaUploader = wp.media.frames.file_frame = wp.media({
          title: 'Choose Image',
          button: {
          text: 'Choose Image'
        }, multiple: false });

        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function() {
          attachment = mediaUploader.state().get('selection').first().toJSON();
          $(formfield).val(attachment.url);
        });
        // Open the uploader dialog
        mediaUploader.open();
    });

    /** SINGLE MEDIA REMOVE **/
    $('.admin-module').on('click', '.remove', function() {
        $(this).parent().find('input[type="text"]').removeAttr('value');
        $(this).parent().find('.option-preview').hide();
    });

    /** ACCORDIONS **/
    $(function() {
        $('.ns-accordion').on('click', '.ns-accordion-header', function(e) {
            e.preventDefault();
            var parent = $(this).closest('.ns-accordion');
            parent.find('.ns-accordion-content').slideToggle();
            parent.toggleClass('active');
            parent.find('.ns-accordion-header > .fa').toggleClass('fa-chevron-right fa-chevron-down');
        });
    });

    /** TABS **/
    $(function() {
        $('.ns-tabs').each(function() {
            if (!$(this).find('.ns-tabs-nav li').hasClass('active')) {
                $(this).find('.ns-tabs-nav li:first-child').addClass('active');
            }
            if (!$(this).find('.ns-tabs-content .tab-content').hasClass('active')) {
                $(this).find('.ns-tabs-content .tab-content:first').addClass('active');
            }
        }); 
        
        $('.ns-tabs').on('click', '.ns-tabs-nav li a', function(e) {
            e.preventDefault();
            var tabID = $(this).attr('href');
            var parentTabs = $(this).closest('.ns-tabs');
            parentTabs.find('.tab-content').removeClass('active');
            parentTabs.find(tabID).addClass('active');
            parentTabs.find('.ns-tabs-nav li').removeClass('active');
            $(this).closest('li').addClass('active');
        });
        $(".tab-loader").hide();
    });

    /** SELECTABLE ITEMS **/
    $('.selectable-item').click(function() {
        $( ".selectable-item" ).each(function( index ) {
          $(this).removeClass('active');
        });
        $(this).addClass('active');

        var input  = $(this).find('input').val();
        input = 'selectable-item-options-' + input;
        
        $(".selectable-item-settings").each(function( index ) {
            if($(this).attr('id') == input) {
                $(".selectable-item-settings").hide();
                $(this).show();
            } else if($(this).attr('id') != input) {
                $(this).hide();
            }
        });
    });

    /********************************************/
    /* TOGGLE SWITCH */
    /********************************************/
    $('.toggle-switch-label').on('click', function() {
        var settingsClass = $(this).data('settings');
        if($(this).parent().find('.toggle-switch-checkbox').is(':checked')) {
            $(this).parent().attr('title', 'Disabled');
            $(this).find('span').text('Off');
            $(this).find('span').removeClass('on');
            if(settingsClass) { $('.'+settingsClass).slideUp(); }
        } else {
            $(this).parent().attr('title', 'Active');
            $(this).find('span').text('On');
            $(this).find('span').addClass('on');
            if(settingsClass) { $('.'+settingsClass).slideDown(); }
        }
    }); 

});