jQuery(document).ready(function($) {

    /******************************************************/
    /** GLOBAL **/
    /** Shared scripts between NightLight and NS Basics  **/
    /******************************************************/

    /** COLOR PICKER **/
    $(function() {
        $('.color-field').wpColorPicker();
    });

    /** SINGLE MEDIA UPLOAD  **/
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
        $( "#accordion" ).removeClass('hide');
        $( ".accordion" ).accordion({
            collapsible: true,
            active: false,
            autoHeight: true,
            heightStyle: "content"
        });
        $('.accordion-tab').click(function() {
            var icon = $(this).find('.icon');
            if (icon.hasClass('fa-chevron-right')) {
                $(this).find('.icon').removeClass('fa-chevron-right');
                $(this).find('.icon').addClass('fa-chevron-down');
            } else {
                $(this).find('.icon').removeClass('fa-chevron-down');
                $(this).find('.icon').addClass('fa-chevron-right');
            }
        });
    });

    /** TABS **/
    $(function() {
        $('#tabs').tabs();
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
    /****************************************************/
    /** END GLOBAL **/
    /****************************************************/


    /********************************************/
    /* SAVE SETTINGS */
    /********************************************/
    $(document).ready(function() {
        $('.ns-settings-ajax').submit(function() { 
            $(this).ajaxSubmit({
                onLoading: $('.loader').show(),
                success: function(){
                    $('.loader').hide();
                    $('.settings-saved').fadeIn();
                    setTimeout(function() {
                        $('.settings-saved').fadeOut('fast');
                    }, 2000);
                }, 
                timeout: 20000
            }); 
            return false; 
        });
    });

    /********************************************/
    /* SHORTCODE SELECTOR */
    /********************************************/
    function nsBasicsInsertShortcode(shortcode) {
        var shortcodeOutput = '';
        var visualEditor = (typeof tinyMCE != "undefined") && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden();

        //set row shortcode
        if(shortcode == 'basic-row') { shortcodeOutput = "[ns_row][/ns_row]"; }

        //set column shortcode
        if(shortcode == 'basic-col') {
            var colWidth = $('.shortcode-selector-options .basic-col-width').val();
            shortcodeOutput = "[ns_col span='"+colWidth+"'][/ns_col]";
        }

        //set module shortcode
        if(shortcode == 'basic-module') {
            if ($('.shortcode-selector-options .basic-module-container').is(':checked')) { var moduleContainer = 'true'; } else { var moduleContainer = 'false'; }
            var moduleClass = $('.shortcode-selector-options .basic-module-class').val();
            var modulePaddingTop = $('.shortcode-selector-options .basic-module-padding-top').val();
            var modulePaddingBottom = $('.shortcode-selector-options .basic-module-padding-bottom').val();
            var moduleMarginTop = $('.shortcode-selector-options .basic-module-margin-top').val();
            var moduleMarginBottom = $('.shortcode-selector-options .basic-module-margin-bottom').val();
            var moduleBgColor = $('.shortcode-selector-options .basic-module-bg-color').val();
            var moduleBgImg = $('.shortcode-selector-options .basic-module-bg-img').val();
            shortcodeOutput = "[ns_module class='"+moduleClass+"' container='"+moduleContainer+"' padding_top='"+modulePaddingTop+"' padding_bottom='"+modulePaddingBottom+"' margin_bottom='"+moduleMarginBottom+"' margin_top='"+moduleMarginTop+"' bg_color='"+moduleBgColor+"' bg_img='"+moduleBgImg+"'][/ns_module]";
        }

        //set module header shortcode
        if(shortcode == 'basic-module-header') {
            var moduleHeaderTitle = $('.shortcode-selector-options .basic-module-header-title').val();
            var moduleHeaderText = $('.shortcode-selector-options .basic-module-header-text').val();
            var moduleHeaderPosition = $('.shortcode-selector-options .basic-module-header-position').val();
            shortcodeOutput = "[ns_module_header title='"+moduleHeaderTitle+"' text='"+moduleHeaderText+"' position='"+moduleHeaderPosition+"'][/ns_module_header]";
        }

        //set button shortcode
        if(shortcode == 'basic-button') {
            var buttonText = $('.shortcode-selector-options .basic-button-text').val();
            var buttonUrl = $('.shortcode-selector-options .basic-button-url').val();
            var buttonType = $('.shortcode-selector-options .basic-button-type').val();
            var buttonPosition = $('.shortcode-selector-options .basic-button-position').val();
            shortcodeOutput = "[ns_button url='"+buttonUrl+"' type='"+buttonType+"' position='"+buttonPosition+"']" +  buttonText + "[/ns_button]";
        }

        //set video shortcode
        if(shortcode == 'basic-video') {
            var videoTitle = $('.shortcode-selector-options .basic-video-title').val();
            var videoUrl = $('.shortcode-selector-options .basic-video-url').val();
            var videoCover = $('.shortcode-selector-options .basic-video-cover').val();
            shortcodeOutput = "[ns_video title='"+videoTitle+"' url='"+videoUrl+"' cover_img='"+videoCover+"'][/ns_video]";
        }

        //set alert box shortcode
        if(shortcode == 'basic-alert') {
            var alertTitle = $('.shortcode-selector-options .basic-alert-title').val();
            var alertType = $('.shortcode-selector-options .basic-alert-type').val();
            shortcodeOutput = "[ns_alert_box type='"+alertType+"']"+alertTitle+"[/ns_alert_box]";
        }

        //set service shortcode
        if(shortcode == 'basic-service') {
            var serviceIcon = $('.shortcode-selector-options .basic-service-icon-fa').val();
            var serviceIconLine = $('.shortcode-selector-options .basic-service-icon-line').val();
            var serviceIconDripicon = $('.shortcode-selector-options .basic-service-icon-dripicon').val();
            var serviceTitle = $('.shortcode-selector-options .basic-service-title').val();
            var serviceText = $('.shortcode-selector-options .basic-service-text').val();
            shortcodeOutput = "[ns_service icon='"+serviceIcon+"' icon_line='"+serviceIconLine+"' dripicon='"+serviceIconDripicon+"' title='"+serviceTitle+"' text='"+serviceText+"'][/ns_service]";
        }

        //set team member shortcode
        if(shortcode == 'basic-team-member') {
            var teamImg = $('.shortcode-selector-options .basic-team-member-img').val();
            var teamName = $('.shortcode-selector-options .basic-team-member-name').val();
            var teamTitle = $('.shortcode-selector-options .basic-team-member-title').val();
            var teamBio = $('.shortcode-selector-options .basic-team-member-bio').val();
            var teamFacebook = $('.shortcode-selector-options .basic-team-member-fb').val();
            var teamTwitter = $('.shortcode-selector-options .basic-team-member-twitter').val();
            var teamGoogle = $('.shortcode-selector-options .basic-team-member-google').val();
            var teamInstagram = $('.shortcode-selector-options .basic-team-member-instagram').val();
            var teamLinkedin = $('.shortcode-selector-options .basic-team-member-linkedin').val();
            var teamYoutube = $('.shortcode-selector-options .basic-team-member-youtube').val();
            var teamVimeo = $('.shortcode-selector-options .basic-team-member-vimeo').val();
            var teamFlickr = $('.shortcode-selector-options .basic-team-member-flickr').val();
            var teamDribbble = $('.shortcode-selector-options .basic-team-member-dribbble').val();
            shortcodeOutput = "[ns_team_member img='"+teamImg+"' name='"+teamName+"' title='"+teamTitle+"' bio='"+teamBio+"' facebook='"+teamFacebook+"' twitter='"+teamTwitter+"' google='"+teamGoogle+"' instagram='"+teamInstagram+"' linkedin='"+teamLinkedin+"' youtube='"+teamYoutube+"' vimeo='"+teamVimeo+"' flickr='"+teamFlickr+"' dribbble='"+teamDribbble+"'][/ns_team_member]";
        }

        //set tab shortcode
        if(shortcode == 'basic-tabs') {
            var count = 1;
            shortcodeOutput += '[ns_tabs]';
            $('.shortcode-selector-options .tab-item').each(function(i, obj) {
                var tabTitle = $(this).find('.tab-title').val();
                var tabIcon = $(this).find('.tab-icon').val();
                var tabIconLine = $(this).find('.tab-icon-line').val();
                var tabIconDripicon = $(this).find('.tab-icon-dripicon').val();
                var tabText = $(this).find('.tab-text').val();
                shortcodeOutput += '[ns_tab id="'+count+'" title="'+tabTitle+'" icon="'+tabIcon+'" icon_line="'+tabIconLine+'" dripicon="'+tabIconDripicon+'"]'+tabText+'[/ns_tab]';
                count++;
            });
            shortcodeOutput += "[/ns_tabs]";
        }

        //set accordion shortcode
        if(shortcode == 'basic-accordion') {
            shortcodeOutput += '[ns_accordions]';
            $('.shortcode-selector-options .accordion-item').each(function(i, obj) {
                var accordionTitle = $(this).find('.accordion-title').val();
                var accordionText = $(this).find('.accordion-text').val();
                shortcodeOutput += '[ns_accordion title="'+accordionTitle+'"]'+accordionText+'[/ns_accordion]';
            });
            shortcodeOutput += "[/ns_accordions]";
        }

        //set testimonial shortcode
        if(shortcode == 'basic-testimonials') {
            shortcodeOutput += '[ns_testimonials]';
            $('.shortcode-selector-options .testimonial-item').each(function(i, obj) {
                var testimonialImg = $(this).find('.testimonial-img').val();
                var testimonialName = $(this).find('.testimonial-name').val();
                var testimonialTitle = $(this).find('.testimonial-title').val();
                var testimonialText = $(this).find('.testimonial-text').val();
                shortcodeOutput += '[ns_testimonial img="'+testimonialImg+'" name="'+testimonialName+'" title="'+testimonialTitle+'"]'+testimonialText+'[/ns_testimonial]';
            });
            shortcodeOutput += "[/ns_testimonials]";
        }

        //set login form shortcode
        if(shortcode == 'basic-login-form') {
            var loginRedirectUrl = $('.shortcode-selector-options .basic-login-form-redirect').val();
            shortcodeOutput += '[ns_login_form redirect="'+loginRedirectUrl+'"]';
        }

        //set register form shortcode
        if(shortcode == 'basic-register-form') {
            shortcodeOutput += '[ns_register_form]';
        }

        //set dashboard shortcode
        if(shortcode == 'basic-user-dashboard') {
            shortcodeOutput += '[ns_dashboard]';
        }

        //set favorites shortcode
        if(shortcode == 'basic-user-favorites') {
            shortcodeOutput += '[ns_favorites]';
        }

        //set edit profile shortcode
        if(shortcode == 'basic-user-edit-profile') {
            shortcodeOutput += '[ns_edit_profile]';
        }

        //insert shortcode and close lightbox
        if(visualEditor) {
            tinyMCE.activeEditor.selection.setContent(shortcodeOutput);
        } else {
            QTags.insertContent(shortcodeOutput);
        }

        var current = $.featherlight.current();
        current.close();
    }

    $('.add-shortcode').on('click', function() {
        $('.shortcode-selector-list').show();
        $('.shortcode-selector-options').hide(); 
        $('.shortcode-selector-options .admin-module').removeClass('active');
    });

    $('.shortcode-selector-list').on('click', '.button', function() { 
        var shortcode = $(this).attr('href');
        $('.shortcode-selector-options .admin-module').removeClass('active');

        if($(this).hasClass('has-options')) {
            $('.shortcode-selector-options .admin-module'+shortcode).addClass('active');  
            $('.shortcode-selector-list').hide();
            $('.shortcode-selector-options').show(); 
        } else {
            shortcode = shortcode.substring(1, shortcode.length);
            nsBasicsInsertShortcode(shortcode);
        }
    });

    $('.shortcode-selector-options').on('click', '.insert-shortcode', function() { 
        var shortcode = $('.shortcode-selector-options .admin-module.active').attr('id');
        nsBasicsInsertShortcode(shortcode);
    });

    $('.shortcode-selector-options').on('click', '.cancel-shortcode', function() {
        $('.shortcode-selector-list').show();
        $('.shortcode-selector-options').hide(); 
        $('.shortcode-selector-options .admin-module').removeClass('active');
    });

    //create tabs
    $('.shortcode-selector-options').on('click', '.create-tab', function() {
        var tabCount = $(this).closest('.form-block').find('.tab-item').length;
        tabCount = tabCount + 1;
        var tabItem = '<div class="tab-item"><label><strong>Tab '+tabCount+'</strong></label><input type="text" placeholder="Title" class="tab-title" /><input type="text" placeholder="Icon" class="tab-icon" /><input type="text" placeholder="Line Icon" class="tab-icon-line" /><input type="text" placeholder="Dripicon" class="tab-icon-dripicon" /><textarea placeholder="Tab Text" class="tab-text"></textarea></div>';
        $(this).closest('.form-block').prepend(tabItem);
    });

    //create accordions
    $('.shortcode-selector-options').on('click', '.create-accordion', function() {
        var accordionCount = $(this).closest('.form-block').find('.accordion-item').length;
        accordionCount = accordionCount + 1;
        var accordionItem = '<div class="accordion-item"><label><strong>Accordion '+accordionCount+'</strong></label><input type="text" placeholder="Title" class="accordion-title" /><textarea placeholder="Accordion Text" class="accordion-text"></textarea></div>';
        $(this).closest('.form-block').prepend(accordionItem);
    });

    //create testimonials
    $('.shortcode-selector-options').on('click', '.create-testimonial', function() {
        var testimonialCount = $(this).closest('.form-block').find('.testimonial-item').length;
        testimonialCount = testimonialCount + 1;
        var testimonialItem = '<div class="testimonial-item"><label><strong>Testimonial '+testimonialCount+'</strong></label><input type="text" placeholder="Image" class="testimonial-img" /><input type="text" placeholder="Name" class="testimonial-name" /><input type="text" placeholder="Title/Position" class="testimonial-title" /><textarea placeholder="Testimonial Text" class="testimonial-text"></textarea></div>';
        $(this).closest('.form-block').prepend(testimonialItem);
    });

    /********************************************/
    /* DISMISS ADMIN ALERT */
    /********************************************/
    $('.admin-alert-box').on('click', '.admin-alert-close', function(e) {
        e.preventDefault();
        $(this).closest('.admin-alert-box').slideUp('fast');
    });

    /********************************************/
    /* GALLERY MULTIPLE UPLOAD */
    /********************************************/
     var gallery_media_upload;

    $('.add-gallery-media').click(function(e) {

        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if( gallery_media_upload ) {
            gallery_media_upload.open();
            return;
        }

        // Extend the wp.media object
        gallery_media_upload = wp.media.frames.file_frame = wp.media({
            title: 'Choose Images',
            button: { text: 'Choose Images' },
            multiple: true
        });

        // When multiple images are selected, get the multiple attachment objects and convert them into a usable array of attachments
        gallery_media_upload.on( 'select', function(){

            var attachments = gallery_media_upload.state().get('selection').map(function(attachment) {
                attachment.toJSON();
                return attachment;
            });

            //loop through the array and do things with each attachment
           var i;
           for (i = 0; i < attachments.length; ++i) {
                $('.gallery-container').prepend(
                    '<div class="gallery-img-preview"><img src="' + attachments[i].attributes.sizes.thumbnail.url + '" ><input type="hidden" name="ns_additional_img[]" value="'+ attachments[i].attributes.url +'" /><span class="action delete-additional-img" title="'+ ns_basics_local_script.delete_text +'"><i class="fa fa-trash"></i></span><a href="'+ns_basics_local_script.admin_url+'upload.php?item='+attachments[i].attributes.id+'" class="action edit-additional-img" target="_blank" title="'+ns_basics_local_script.edit_text+'"><i class="fa fa-pencil-alt"></i></a></div>'
                );
            }

            $('.gallery-container').find('.no-gallery-img').hide();

        });

        gallery_media_upload.open();
    });

    /********************************************/
    /* GALLERY SORT */
    /********************************************/
    $('.gallery-container').sortable({
        curosr: 'move'
    });

    /********************************************/
    /* GALLERY DELETE */
    /********************************************/
    $('.gallery-container').on("click", ".gallery-img-preview .delete-additional-img", function() {
        $(this).parent().remove();
    });

    /********************************************/
    /* DATEPICKER */
    /********************************************/
    var dateToday = new Date(); 
    $(".datepicker").datepicker({
        minDate: dateToday,
    });

    /********************************************/
    /* SORTABLE ITEMS */
    /********************************************/    
    $(document).ready(function () {
        $('.sortable-list').sortable({
            axis: 'y',
            curosr: 'move',
            distance: 10,
            update: function(event, ui) {
                $(this).closest('.widget-inside').find('.widget-control-save').removeAttr('disabled');
                $(this).closest('.widget-inside').find('.widget-control-save').val(ns_basics_local_script.save_text);
            }
        });
    });

    $(document).on('widget-updated', function(e, widget){
        $('.sortable-list').sortable({
            axis: 'y',
            curosr: 'move',
            distance: 10,
            update: function(event, ui) {
                $(this).closest('.widget-inside').find('.widget-control-save').removeAttr('disabled');
                $(this).closest('.widget-inside').find('.widget-control-save').val(ns_basics_local_script.save_text);
            }
        });
    });

    /********************************************/
    /* SORTABLE ITEM SETTINGS */
    /********************************************/
    $(document).on('click','.advanced-options-toggle', function (event) { 
        event.preventDefault();
        var settingsID = $(this).attr('href');
        var link = $(this);
        $(settingsID).slideToggle('fast', function() {
            if ($(this).is(':visible')) {
                $(this).closest('.sortable-item').addClass('expanded');
                link.html('<i class="fa fa-gear"></i> Hide Settings');                
            } else {
                $(this).closest('.sortable-item').removeClass('expanded');
                link.html('<i class="fa fa-gear"></i> Additional Settings');                
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
            $(this).find('span').text(ns_basics_local_script.off);
            $(this).find('span').removeClass('on');
            if(settingsClass) { $('.'+settingsClass).slideUp(); }
        } else {
            $(this).parent().attr('title', 'Active');
            $(this).find('span').text(ns_basics_local_script.on);
            $(this).find('span').addClass('on');
            if(settingsClass) { $('.'+settingsClass).slideDown(); }
        }
    }); 

    /********************************************/
    /* SOCIAL LINKS WIDGET */
    /********************************************/
    $('#widgets-right').on('change', '.social-links-source', function() {
        var custom_fields = $(this).closest('.widget-inside').find('.custom-social-fields');
        var theme_note = $(this).closest('.widget-inside').find('.theme-note');
        if(this.value == 'custom') {
            custom_fields.removeClass('hide-soft');
            custom_fields.addClass('show');
            theme_note.removeClass('show');
            theme_note.addClass('hide');
        } else {
            custom_fields.removeClass('show');
            custom_fields.addClass('hide-soft');
            theme_note.removeClass('hide');
            theme_note.addClass('show');
        }
    });

    /********************************************/
    /* TESTIMONIALS WIDGET */
    /********************************************/
    $('#widgets-right, .elementor-panel').on("click", ".testimonials-widget-container .testimonial-header", function() {
        $(this).parent().find('.testimonial-content').slideToggle('fast');
    });

    $('#widgets-right, .elementor-panel').on("click", ".button-add-testimonial", function() {
        var testimonialFieldName = $(this).closest('.testimonials-widget-container').find('.testimonial-field-name').html();
        var count = $(this).closest('.testimonials-widget-container').find('.testimonial-item').length;
        var testimonial = '\
            <div class="testimonial-item"> \
                <div class="testimonial-header"> \
                    <i class="icon fa fa-cog"></i> <strong>'+ns_basics_local_script.new_testimonial+'</strong> \
                    <span class="right testimonial-delete"><i class="icon fa fa-close"></i> '+ns_basics_local_script.remove_text+'</span> \
                </div> \
                <div class="testimonial-content"> \
                    <table> \
                        <tr> \
                            <td valign="top"><label>'+ns_basics_local_script.name_text+':</label></td> \
                            <td valign="top"><input class="widefat" type="text" name="'+testimonialFieldName+'['+count+'][name]" value="" /></td> \
                        </tr> \
                        <tr> \
                            <td valign="top"><label>'+ns_basics_local_script.position+':</label></td> \
                            <td valign="top"><input class="widefat" type="text" name="'+testimonialFieldName+'['+count+'][position]" value="" /></td> \
                        </tr> \
                        <tr> \
                            <td valign="top"><label>'+ns_basics_local_script.image_url+':</td> \
                            <td valign="top"><input class="widefat" type="text" name="'+testimonialFieldName+'['+count+'][image]" value="" /></td> \
                        </tr> \
                        <tr> \
                            <td valign="top"><label>'+ns_basics_local_script.testimonial+':</label></td> \
                            <td valign="top"><textarea class="widefat" name="'+testimonialFieldName+'['+count+'][text]"></textarea></td> \
                        </tr> \
                    </table> \
                </div> \
            </div> \
        ';
        $(this).closest('.testimonials-widget-container').prepend(testimonial);
    });

    $('#widgets-right, .elementor-panel').on("click", ".testimonials-widget-container .testimonial-header .testimonial-delete", function() {
        $(this).closest('.widget-inside').find('.widget-control-save').prop("disabled", false);
        $(this).closest('.testimonial-item').remove();
    });

});