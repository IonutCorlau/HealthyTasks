<?php

$ToEmail = 'ionut.corlau@gmail.com';

$Mail->IsSMTP(); // Use SMTP
$Mail->Host        = "smtp.gmail.com"; // Sets SMTP server
$Mail->SMTPDebug   = 2; // 2 to enable SMTP debug information
$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
$Mail->SMTPSecure  = "tls"; //Secure conection
$Mail->Port        = 587; // set the SMTP port
$Mail->Username    = 'healthy.tasks@gmail.com'; // SMTP account username
$Mail->Password    = 'lola2006'; // SMTP account password
$Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
$Mail->CharSet     = 'UTF-8';
$Mail->Encoding    = '8bit';
$Mail->ContentType = 'text/html; charset=utf-8\r\n';
$Mail->From        = 'healthy.tasks@gmail.com';
$Mail->FromName    = 'Healthy Tasks';
$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
$Mail->SMTPDebug   = FALSE;

?>

