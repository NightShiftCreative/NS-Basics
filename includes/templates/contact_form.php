<?php

$default_email = get_option('admin_email');
    $contact_form_email = esc_attr(get_option('ns_core_email', $default_email));
    $contact_form_success = esc_attr(get_option('ns_core_contact_form_success', esc_html__('Thanks! Your email has been delivered!', 'ns-basics')));
    
    $nameError = '';
    $emailError= '';
    $commentError = '';
    $emailSent = null;

    //If the form is submitted
    if(isset($_POST['submitted'])) {
      
      // require a name from user
      if(trim($_POST['contact-name']) === '') {
        $nameError =  esc_html__('Forgot your name!', 'ns-basics'); 
        $hasError = true;
      } else {
        $contact_name = trim($_POST['contact-name']);
      }
      
      // need valid email
      if(trim($_POST['contact-email']) === '')  {
        $emailError = esc_html__('Forgot to enter in your e-mail address.', 'ns-basics');
        $hasError = true;
      } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['contact-email']))) {
        $emailError = esc_html__('You entered an invalid email address.', 'ns-basics');
        $hasError = true;
      } else {
        $contact_email = trim($_POST['contact-email']);
      }

      // get phone
      if(trim($_POST['contact-phone']) === '') {
        // do nothing
      } else {
        $contact_phone = trim($_POST['contact-phone']);
      }

      // get subject
      if(trim($_POST['contact-subject']) === '') {
        // do nothing
      } else {
        $contact_subject = trim($_POST['contact-subject']);
      }
        
      // we need at least some content
      if(trim($_POST['contact-message']) === '') {
        $commentError = esc_html__('You forgot to enter a message!', 'ns-basics');
        $hasError = true;
      } else {
        if(function_exists('stripslashes')) {
          $contact_message = stripslashes(trim($_POST['contact-message']));
        } else {
          $contact_message = trim($_POST['contact-message']);
        }
      }
        
      // upon no failure errors let's email now!
      if(!isset($hasError)) {

        /*---------------------------------------------------------*/
        /* SET EMAIL ADDRESS HERE                                  */
        /*---------------------------------------------------------*/
        $emailTo = $contact_form_email;
        $subject = 'Submitted message from '.$contact_name;
        $sendCopy = trim($_POST['sendCopy']);
        $body = "Subject:$contact_subject \n\nName: $contact_name \n\nEmail: $contact_email \n\nPhone: $contact_phone \n\nMessage: $contact_message";
        $headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $contact_email;

        mail($emailTo, $subject, $body, $headers);
            
        // set our boolean completion value to TRUE
        $emailSent = true;
      }
    }

    ?>

    <form method="post" class="contact-form">

        <div class="alert-box success <?php if($emailSent) { echo 'show'; } else { echo 'hide'; } ?>"><?php echo $contact_form_success; ?></div>

        <div class="contact-form-fields">
            <div class="form-block">
                <?php if($nameError != '') { echo '<div class="alert-box error">'.$nameError.'</div>'; } ?>
                <label><?php esc_html_e( 'Name', 'ns-basics' ); ?>*</label>
                <input type="text" name="contact-name" placeholder="<?php esc_html_e( 'Your Name', 'ns-basics' ); ?>" class="requiredField" value="<?php if(isset($contact_name)) { echo $contact_name; } ?>" />
            </div>

            <div class="form-block">
                <?php if($emailError != '') { echo '<div class="alert-box error">'.$emailError.'</div>'; } ?>
                <label><?php esc_html_e( 'Email', 'ns-basics' ); ?>*</label>
                <input type="email" name="contact-email" placeholder="<?php esc_html_e( 'Your Email', 'ns-basics' ); ?>" class="requiredField email" value="<?php if(isset($contact_email)) { echo $contact_email; } ?>" />
            </div>

            <div class="form-block">
                <label><?php esc_html_e( 'Phone', 'ns-basics' ); ?></label>
                <input type="text" name="contact-phone" placeholder="<?php esc_html_e( 'Your Phone', 'ns-basics' ); ?>" value="<?php if(isset($_POST['contact-phone'])) { echo $_POST['contact-phone']; } ?>" />
            </div>

            <div class="form-block">
                <label><?php esc_html_e( 'Subject', 'ns-basics' ); ?></label>
                <input type="text" name="contact-subject" placeholder="<?php esc_html_e( 'Subject', 'ns-basics' ); ?>" value="<?php if(isset($_POST['contact-subject'])) { echo $_POST['contact-subject']; } ?>" />
            </div>

            <div class="form-block">
                <?php if($commentError != '') { echo '<div class="alert-box error">'.$commentError.'</div>'; } ?>
                <label><?php esc_html_e( 'Message', 'ns-basics' ); ?>*</label>
                <textarea name="contact-message" placeholder="<?php esc_html_e( 'Your Message', 'ns-basics' ); ?>" class="requiredField"><?php if(isset($contact_message)) { echo $contact_message; } ?></textarea>
            </div>

            <div class="form-block">
                <input type="hidden" name="submitted" id="submitted" value="true" />
                <input type="submit" value="<?php esc_html_e( 'Submit', 'ns-basics' ); ?>" />
                <div class="form-loader"><img src="<?php echo esc_url(home_url('/')); ?>wp-admin/images/spinner.gif" alt="" /> <?php esc_html_e( 'Loading...', 'ns-basics' ); ?></div>
            </div>
        </div>

    </form>