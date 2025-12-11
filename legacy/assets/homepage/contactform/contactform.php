<?php

$EmailFrom = "info@haomaidesign.com";
$EmailTo = "info@haomaidesign.com";
$Subject = "Web Contact";
$Name = Trim(stripslashes($_POST['name'])); 
$Sub = Trim(stripslashes($_POST['subject'])); 
$Email = Trim(stripslashes($_POST['email'])); 
$Message = Trim(stripslashes($_POST['message'])); 

// prepare email body text
$Body = "";
$Body .= "Name: ";
$Body .= $Name;
$Body .= "\n";
$Body .= "Subject: ";
$Body .= $Sub;
$Body .= "\n";
$Body .= "Email: ";
$Body .= $Email;
$Body .= "\n";
$Body .= "Message: ";
$Body .= $Message;
$Body .= "\n";

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");

// redirect to success page 
if ($success){
  echo "OK";
}
else{
  echo "No se pudo enviar el mensaje, contactenos al info@haomaidesign.com";
}
?>
