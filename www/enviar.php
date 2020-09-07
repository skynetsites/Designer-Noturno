<?php

// Do not edit this if you are not familiar with php
error_reporting (E_ALL ^ E_NOTICE);
$post = (!empty($_POST)) ? true : false;
if($post) {
	function ValidateEmail($email){

		$regex = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
		$eregi = preg_replace($regex,'', trim($email));
		
		return empty($eregi) ? true : false;
	}

	$name = stripslashes($_POST['ContactName']);
	$to = trim($_POST['to']);
	$email = strtolower(trim($_POST['ContactEmail']));
	$subject = stripslashes($_POST['subject']);
	$message = stripslashes($_POST['ContactComment']);
	$error = '';
	$Reply=$to;
	$from=$to;
	
	// Check Name Field
	if(!$name) {
		$error .= 'Por favor, insira seu nome.<br />';
	}
	
	// Checks Email Field
	if(!$email) { 
		$error .= 'Por favor insira um endereço de e-mail.<br />';
	}
	if($email && !ValidateEmail($email)) {
		$error .= 'Por favor insira um endereço de e-mail válido.<br />';
	}

	// Checks Subject Field
	if(!$subject) {
		$error .= 'Por favor, insira seu assunto.<br />';
	}
	
	// Checks Message (length)
	if(!$message || strlen($message) < 3) {
		$error .= "Por favor insira a sua mensagem. Deve ter pelo menos 5 caracteres.<br />";
	}
	
	// Let's send the email.
	if(!$error) {
		$messages="From: $email <br>";
		$messages.="Nome: $name <br>";
		$messages.="E-mail: $email <br>";	
		$messages.="Menssagem: $message <br><br>";
		$emailto=$to;
		
		$mail = mail($emailto,$subject,$messages,"from: $from <$Reply>\nReply-To: $Reply \nContent-type: text/html");	
	
		if($mail) {
			echo 'success';
		}
	} else {
		echo '<div class="error">'.$error.'</div>';
	}

}
?>