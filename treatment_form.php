<?php
  //Import PHPMailer classes into the global namespace
  use PHPMailer\PHPMailer\PHPMailer;
  require './vendor/autoload.php';

  $doc = DOMDocument::loadHTMLFile('base_form.html');
  $form = $doc->getElementById('form');

  function errorMsg($id, $message){
    global $doc, $form;
    $element = $doc->getElementById($id);
    $newnode = $doc->createElement('p', $message);
    $form->insertBefore($newnode, $element);
  }

  if (isset($_POST['submit'])) {
    $log = [];
    $today = getDate();
    $handle = new upload($_FILES['image_field']);
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    include 'pass.php';
    //check if valid email and non empty message
    if( isset($_POST['email']) && $_POST['message'] !== '' ){
      $log['date'] = $today['weekday'].' '.$today['mday'].'/'.$today['mon'].'/'.$today['year'].' '.$today['hours'].':'.$today['minutes'].':'.$today['seconds'];
      $sanemail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $sanmessage = filter_var($_POST['message'], FILTER_SANITIZE_EMAIL);
      $valemail = filter_var($sanemail, FILTER_VALIDATE_EMAIL);
      if(isset($valemail) == false){
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
        // check if first name was entered and sanitize it
        if ($_POST['first_name'] !== 'Prénom') {
          $nameToUse .= filter_var($_POST['first_name'], FILTER_SANITIZE_STRING) . " ";
          $log['first_name'] = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
        }
        //check if first name was entered and sanitize it
        if ($_POST['name'] !== 'Nom') {
          $nameToUse .= filter_var($_POST['name'], FILTER_SANITIZE_STRING) . " ";
          $log['last_name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        }
        $mail->setFrom($valemail, $nameToUse);
        $log['email'] = $valemail;
        $mail->Subject = $_POST['subject'];
        $mail->addAddress('berior14@gmail.com', $_POST['contact_choice']);
        $mail->Body = $sanmessage;
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
        var_dump($log);
        // file_put_contents()
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
