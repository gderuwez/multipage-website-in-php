<?php
  //Import PHPMailer classes into the global namespace
  use PHPMailer\PHPMailer\PHPMailer;
  require 'vendor/autoload.php';

  $doc = DOMDocument::loadHTMLFile('source/base_form.html');
  $form = $doc->getElementById('form');
  $mail = new PHPMailer;


  //check if file with password and username to log to gmail exists
  //if it exists, uses it
  if(file_exists('pass.php')) {
    include 'pass.php';
  }
  //if it doesn't exist, create input for password and username
  else {
    $placement = $doc->getElementById('firstformelement');
    $breaks = $doc->createElement('br');
    //create the email input
    $usernameForm = $doc->createElement('label', 'enter your gmail address');
    $usernameForm->setAttribute('for', 'useremail');
    $usernameFormInput = $doc->createElement('input');
    $UFIA = ['type' => 'email', 'id' => 'useremail', 'name' => 'useremail'];
    foreach ($UFIA as $key => $value) {
      $usernameFormInput->setAttribute($key, $value);
    }
    //create the password input
    $passwordForm = $doc->createElement('label', 'enter password for gmail connexion');
    $passwordForm->setAttribute('for', 'gmailpassword');
    $passwordFormInput = $doc->createElement('input');
    $PFIA = ['type' => 'password', 'id' => 'gmailpassword', 'name' => 'gmailpassword'];
    foreach ($PFIA as $key => $value) {
      $passwordFormInput->setAttribute($key, $value);
    }
    //display the email and password input
    $form->insertBefore($usernameForm, $placement);
    $form->insertBefore($usernameFormInput, $placement);
    $form->insertBefore($passwordForm, $placement);
    $form->insertBefore($passwordFormInput, $placement);
    $form->insertBefore($breaks, $placement);
  }

  function errorMsg($id, $message){
    global $doc, $form;
    $element = $doc->getElementById($id);
    $newnode = $doc->createElement('p', $message);
    $form->insertBefore($newnode, $element);
  }

  if (isset($_POST['submit'])) {
    $handle = new upload($_FILES['image_field']);
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $log = [];
    $today = getDate();
    //check if valid email and non empty message
    if( isset($_POST['email']) && $_POST['message'] !== '' ){
      //log time
      $log['date'] = $today['weekday'].' '.$today['mday'].'/'.$today['mon'].'/'.$today['year'].' '.$today['hours'].':'.$today['minutes'].':'.$today['seconds'];
      //sanitize and validate email and sanitize message
      $sanemail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $sanmessage = filter_var($_POST['message'], FILTER_SANITIZE_EMAIL);
      $valemail = filter_var($sanemail, FILTER_VALIDATE_EMAIL);
      //check validity of entered email adress
      if($valemail == false){
        $id = 'errorEmail';
        $message = 'Veuillez entrez une adresse email valide';
        errorMsg($id, $message);
      }
      //if valid email
      else {
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
        if ($handle->uploaded) {
          if ($handle->file_src_name_ext === 'png' || $handle->file_src_name_ext === 'jpg' || $handle->file_src_name_ext === 'jpeg' || $handle->file_src_name_ext === 'gif') {
            $handle->process('./uploads');
            if ($handle->processed) {
              $id = 'errorUpload';
              $message = 'Image uploaded';
              errorMsg($id, $message);
              $imagePath = $handle->file_dst_pathname;
              $mail->addAttachment($imagePath);
              $handle->clean();
            }
            else {
              $id = 'errorUpload';
              $message = 'error : ' . $handle->error;
              errorMsg($id, $message);
            }
          }
          else {
            $id = 'errorUpload';
            $message = 'type de fichier invalide';
            errorMsg($id, $message);
          }
        }
        // if (!$mail->send()) {
        //     echo "Mailer Error: " . $mail->ErrorInfo;
        // } else {
        //     echo "Message sent!";
        // }
        echo '<pre>';
        // var_dump($log);
        $toput = json_encode($log, true) . ',';
        file_put_contents('./logs/logs.txt', $toput, FILE_APPEND);
        unset($_POST);
        unset($mail);
        unset($log);
        unset($toput);
        echo '</pre>';
      }
    }
    else {
      if( isset($_POST['email']) == false ){
        $id = 'errorEmail';
        $message = 'Veuillez entrez une adresse email';
        errorMsg($id, $message);
      }
      if ($_POST['message'] == '') {
        $id = 'errorMessage';
        $message = 'Veuillez entrez un message';
        errorMsg($id, $message);
        echo 'test';
      }
    }
  }
 ?>
