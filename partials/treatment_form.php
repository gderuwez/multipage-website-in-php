<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;
date_default_timezone_set('Europe/Brussels');
require './vendor/autoload.php';

$doc = DOMDocument::loadHTMLFile('views/base_form.html');
$form = $doc->getElementById('form');

function errorMsg($id, $message, $test){
  global $doc, $form;
  $newnode = $test;
  $element = $doc->getElementById($id);
  $$newnode = $doc->createElement('p', $message);
  $form->insertBefore(${$newnode}, $element);
}

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->AuthType = 'XOAUTH2';
$email = 'testingbecode@gmail.com';
$clientId = getenv('CLIENT_ID');
$clientSecret = getenv('CLIENT_SECRET');
$refreshToken = getenv('CLIENT_TOKEN');
$provider = new Google(
    [
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]
);
$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $email,
        ]
    )
);

if (isset($_POST['submit'])) {
  $handle = new upload($_FILES['image_field']);
  //create empty log array
  $log = [];
  //get today's date
  $today = getDate();
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
      $mail->addAddress('testingbecode@gmail.com', $_POST['contact_choice']);
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
