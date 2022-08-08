<?php
include("./phpMailer/class.phpmailer.php");
include("./phpMailer/class.smtp.php");

$email_user = "tecwebproyectcendi@gmail.com"; //OJO. Debes actualizar esta línea con tu información
$email_password = "esdrasEsGay69"; //OJO. Debes actualizar esta línea con tu información
$the_subject = "Prueba de PHPMailer por PEM (May 2022)";
$address_to = "luise.ascencio13@gmail.com"; //OJO. Debes actualizar esta línea con tu información
$from_name = "Tec Web - 2CM4";
$phpmailer = new PHPMailer();

// ---------- datos de la cuenta de Gmail -------------------------------
$phpmailer->Username = $email_user;
$phpmailer->Password = $email_password; 
//-----------------------------------------------------------------------
// $phpmailer->SMTPDebug = 1;
$phpmailer->SMTPSecure = 'tls';
$phpmailer->Host = "smtp.gmail.com"; // GMail
$phpmailer->Port = 587;
$phpmailer->IsSMTP(); // use SMTP
$phpmailer->SMTPAuth = true;

$phpmailer->setFrom($phpmailer->Username,$from_name);
$phpmailer->AddAddress($address_to); // recipients email

$phpmailer->Subject = $the_subject;	
$phpmailer->Body .="<h1 style='color:#3498db;'>Hola chicas y chicos del grupo 2CM4!</h1>";
$phpmailer->Body .= "<p>Esta es una prueba del envío de correo :)</p>";
$phpmailer->Body .= "<p>Fecha: ".date("d-m-Y")."</p>";
$phpmailer->IsHTML(true);

if(!$phpmailer->Send()){
	echo "No se pudo";
} else{
	echo "Se mandó";
}
?>