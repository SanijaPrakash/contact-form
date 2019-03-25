<?php
/**
 * Created by hiran.
 * Date: 12/3/19
 * Time: 4:30 PM
 */
include "database.php";
include "user.php";
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';
require 'class.smtp.php';

if($_POST['formid'] == 'form'){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$namesize = strlen($_POST['name']);
	$number_size = strlen($_POST['phone']);
	$error = array();
	$res = array();
	$res['status']=1;
	$user1 = new user();
	$user1->setdebug(1);
	$email_exist = $user1->check_email_exist($email);

	if((empty($_POST['name']))||$namesize < 3 || $namesize > 20){
	    $error['name'] = 'Name feild not valid';
	}
	if (empty($_POST['email'])||(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))){
	    $error['email'] = 'invalid email format';
	   }
	if((empty($_POST['phone']))||$number_size != 10){
	    $error['phone'] = 'phone Number not valid';
	}
	if($_POST["g-recaptcha-response"] == ''){
		$error['captcha']= "captcha not verified";
	}
	if ($email_exist == 1) {
		$error['email_exist'] = "email already exist";

	}   
	if(!empty($error)){
	    $res['status']=0;
	    $res['error'] = $error;
	    echo json_encode($res);
	}
	else{
		$mail = new PHPMailer;
		$mail->isSMTP();                                      
		$mail->Host = 'smtp.gmail.com'; 					  
		$mail->SMTPAuth = true;                               
		$mail->Username = 'hiranhiraa7@gmail.com';            
		$mail->Password = 'Hiran@123';                       
		$mail->SMTPSecure = 'tls';                            
		$mail->Port = 587;                                   
		$mail->setFrom('hiranhiraa7@gmail.com', 'Mailer');
		$mail->addAddress($email,$name);     
		$mail->addReplyTo('hiranhiraa7@gmail.com', 'Information');
		$mail->isHTML(true);                                  
		$mail->Subject = 'ENQUIRY';
		$mail->Body    = $message;
		if(!$mail->send()) {
		    $error = 'Mailer Error: ' . $mail->ErrorInfo;
		    $res['error'] = $error;
		    $res['status'] = 2;
		} else {
			$res['status'] = 1;
			$res['message'] = 'Message has been sent';
		    echo json_encode($res);
		    $insert=$user1->insert($_POST);
		}
	}
}
?>