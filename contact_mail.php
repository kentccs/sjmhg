<?php
require('phpmailer/class.phpmailer.php');

$error = "";

if (empty($_POST["userName"])) {
    $error .= "*Name is required";
  } else {
    $name = test_input($_POST["userName"]);
  }

  if (empty($_POST["userEmail"])) {
    $error .= "*Email is required";
  } else {
    $email = test_input($_POST["userEmail"]);
  }

  if (empty($_POST["subject"])) {
    $error .= "*Subject is required";
  } else {
    $subject = test_input($_POST["subject"]);
  }

  if (empty($_POST["content"])) {
    $error = "*Message is required";
  } else {
    $content = test_input($_POST["content"]);
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
 }

if($error ==""){

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = TRUE;
	$mail->SMTPSecure = "ssl";
	$mail->Port     = 465;  
	$mail->Username = "test@glosoftgroup.com";
	$mail->Password = "@testAccount123";
	$mail->Host     = "197.kweservers.com";
	$mail->Mailer   = "smtp";
	$mail->SetFrom($email, $name);
	$mail->AddReplyTo($email, $name);
	$mail->AddAddress("info@glosoftgroup.com");	
	$mail->AddAddress("kentccs07@gmail.com");	
	$mail->AddAddress("mercy8muhia@gmail.com");	
	$mail->Subject = $subject." - [St.Joseph Mukasa Website Contact Form]";
	$mail->WordWrap   = 80;
	$msgcontent = "This mail belongs to sjmshg website contact form <br/> Sent by " .$email. " <br/>Message : <br/> ".$content;
	$mail->MsgHTML($msgcontent);


	$mail->IsHTML(true);

	if(!$mail->Send()) {

		echo "<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-remove'></span> Error occured failed to send mail. Please try again later.</div>";
	} else {
		echo "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok'></span> Successfully sent. Thank you for your Mail.</div>";
	}	

}else{

	echo "<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-remove'></span> The Form has Errors. <br/> ".$error."</div>";
}






?>