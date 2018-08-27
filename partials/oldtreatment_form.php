<?php
  //Import PHPMailer classes into the global namespace
  use PHPMailer\PHPMailer\PHPMailer;
  require 'vendor/autoload.php';

  // load the view into the code
  $doc = DOMDocument::loadHTMLFile('views/base_form.html');
  $form = $doc->getElementById('form');
  //create a new instance of mail
  $mail = new PHPMailer;

  // function to create a <br> element
  function breaktest($name){
    global $doc;
    $breaks = $name;
    $$breaks = $doc->createElement('br');
    return ${$breaks};
  }
  //check if file with password and username to log to gmail exists
  //if it exists, uses it
  if(file_exists('pass.php')) {
    include 'pass.php';
  }
  //if it doesn't exist, create input for password and username
  else {
    //decide where to put the elements
    $placement = $doc->getElementById('firstformelement');
    //create the email label and set it's attributes
    $usernameForm = $doc->createElement('label', 'enter your gmail address');
    $usernameForm->setAttribute('for', 'useremail');
    //create the email input and set it's attributes
    $usernameFormInput = $doc->createElement('input');
    $UFIA = ['type' => 'email', 'id' => 'useremail', 'name' => 'useremail'];
    foreach ($UFIA as $key => $value) {
      $usernameFormInput->setAttribute($key, $value);
    }
    //create the password label and sets its inputs
    $passwordForm = $doc->createElement('label', 'enter password for gmail connexion');
    $passwordForm->setAttribute('for', 'gmailpassword');
    //create the password input and set its attributes
    $passwordFormInput = $doc->createElement('input');
    $PFIA = ['type' => 'password', 'id' => 'gmailpassword', 'name' => 'gmailpassword'];
    foreach ($PFIA as $key => $value) {
      $passwordFormInput->setAttribute($key, $value);
    }
    //display the email and password label and inputs
    $form->insertBefore($usernameForm, $placement);
    $form->insertBefore(breaktest('test3'), $placement);
    $form->insertBefore($usernameFormInput, $placement);
    $form->insertBefore(breaktest('test4'), $placement);
    $form->insertBefore($passwordForm, $placement);
    $form->insertBefore(breaktest('test2'), $placement);
    $form->insertBefore($passwordFormInput, $placement);
    $form->insertBefore(breaktest('test'), $placement);
  }

  //function to display the messages
  function errorMsg($id, $message, $test){
    global $doc, $form;
    $newnode = $test;
    $element = $doc->getElementById($id);
    $$newnode = $doc->createElement('p', $message);
    $form->insertBefore(${$newnode}, $element);
  }

  //check if button submit is pressed
  if (isset($_POST['submit'])) {
    //set the smtp server parameters
    $handle = new upload($_FILES['image_field']);
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    //create empty log array
    $log = [];
    //get today's date
    $today = getDate();
    //if password file doesn't exist
    if(!file_exists('pass.php')) {
      //sanitize password and username
      $sanuser = filter_var($_POST['useremail'], FILTER_SANITIZE_EMAIL);
      $sanpassword = filter_var($_POST['gmailpassword'], FILTER_SANITIZE_STRING);
      $valuser = filter_var($sanuser, FILTER_VALIDATE_EMAIL);
      //if email is valid, use it in mail function
      if( $valuser !== false ){
        $mail->Username = $valuser;
      }
      // else display error message
      else {
        $id = 'useremail';
        $message = 'email non valide';
        errorMsg($id, $message, 'newnode2');
      }
      // if no problem with password, use it
      if($sanpassword !== "") {
        $mail->Password = $sanpassword;
      }
      //display error message for password
      else {
        $id = 'gmailpassword';
        $message = 'password non valide';
        errorMsg($id, $message, 'newnode3');
      }
    }
    //check if valid email and non empty message
    if( isset($_POST['email']) && $_POST['message'] !== '' ){
      //log time
      $log['date'] = $today['weekday'].' '.$today['mday'].'/'.$today['mon'].'/'.$today['year'].' '.$today['hours'].':'.$today['minutes'].':'.$today['seconds'];
      //sanitize and validate email and sanitize message
      $sanemail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $sanmessage = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
      $valemail = filter_var($sanemail, FILTER_VALIDATE_EMAIL);
      //check validity of entered email adress
      if($valemail == false){
        $id = 'errorEmail';
        $message = 'Veuillez entrez une adresse email valide';
        errorMsg($id, $message, 'newnode4');
      }
      //if valid email
      else {
        //declare variable to use in email sender info
        $nameToUse = '';
        // check if title is selected
        if (isset($_POST['title'])) {
          $nameToUse .= $_POST['title'] . ' ';
        }
        // check if first name was entered and sanitize it and log it
        if ($_POST['first_name'] !== 'Prénom') {
          $nameToUse .= filter_var($_POST['first_name'], FILTER_SANITIZE_STRING) . " ";
          $log['first_name'] = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
        }
        //check if first name was entered and sanitize it and log it
        if ($_POST['name'] !== 'Nom') {
          $nameToUse .= filter_var($_POST['name'], FILTER_SANITIZE_STRING) . " ";
          $log['last_name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        }
        //set the expeditor adress and name and log the email
        $mail->setFrom($valemail, $nameToUse);
        $log['email'] = $valemail;
        //set the subject
        $mail->Subject = $_POST['subject'];
        //set the recipient adress and the specific service
        $mail->addAddress('berior14@gmail.com', $_POST['contact_choice']);
        //set the message
        $mail->Body = $sanmessage;
        //check if reply type is chosen
        if(isset($_POST['reply_type'])) {
          $log['format'] = $_POST['reply_type'];
        }
        //check if image is attached
        if ($handle->uploaded) {
          //check extension of attached file if valid process it
          if ($handle->file_src_name_ext === 'png' || $handle->file_src_name_ext === 'jpg' || $handle->file_src_name_ext === 'jpeg' || $handle->file_src_name_ext === 'gif') {
            $handle->process('./uploads');
            //check if processing works and send confirmation message
            if ($handle->processed) {
              $id = 'errorUpload';
              $message = 'Image attached';
              errorMsg($id, $message, 'newnode5');
              $imagePath = $handle->file_dst_pathname;
              $mail->addAttachment($imagePath);
              $handle->clean();
            }
            // if processing failed send error message
            else {
              $id = 'errorUpload';
              $message = 'error : ' . $handle->error;
              errorMsg($id, $message, 'newnode6');
            }
          }
          // if invalid type, send error message
          else {
            $id = 'errorUpload';
            $message = 'type de fichier invalide';
            errorMsg($id, $message, 'newnode7');
          }
        }
        //attempt to send message
        //if fail display error message
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else { // if sent send confirmation message
            echo "Message sent!";
        }
        echo '<pre>';
        // encode log as json and put it in file
        $toput = json_encode($log, true) . ',';
        file_put_contents('./logs/logs.txt', $toput, FILE_APPEND);
        //unset sensitive variables for safety
        unset($_POST, $mail, $log, $toput);
        echo '</pre>';
      }
    }
    else {
      //if email exist, san and validate
      if( isset($_POST['email']) ){
        $sanemail2 = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $valemail2 = filter_var($sanemail2, FILTER_VALIDATE_EMAIL);
        // if invalid send error
        if ($valemail2 == false) {
          $id = 'errorEmail';
          $message = 'Veuillez entrez une adresse email valide';
          errorMsg($id, $message, 'newnode8');
        }
      }
      // if email empty send error
      if (!isset($_POST['email'])) {
        $id = 'errorEmail';
        $message = 'Veuillez entrez une adresse email';
        errorMsg($id, $message, 'newnode10');
      }
      //if message empty send error
      if ($_POST['message'] == '') {
        $id = 'errorMessage';
        $message = 'Veuillez entrez un message';
        errorMsg($id, $message, 'newnode9');
      }
    }
  }
 ?>
