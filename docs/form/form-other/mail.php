<?php
if(!empty($_POST))
{
 
$title = ''.$_POST[title]."";
$name = 'Имя: '.$_POST[name]."";
$phone = 'Телефон: '.$_POST[phone]."";
$email = 'E-mail: '.$_POST[email]."";

 
$ip = getRealIpAddr();
$message = "$title<br/>$name<br/>$phone<br/>$email<br/><br/>Со страницы: ".$_SERVER['HTTP_REFERER']."<br/>IP: $ip<br/>Браузер: ".$_SERVER['HTTP_USER_AGENT']."<br/>";
$error = array();
 
// Если не введено имя
if(empty($name))
{
$error[] = 'Укажите Ваше имя.';
}
 
// Если не введено имя
if(empty($phone))
{
$error[] = 'Укажите Ваше номер.';
}

if(empty($email))
{
$error[] = 'Укажите Ваше E-mail.';
}
 
 
if(empty($error))
{ // отправляем email средствами php
$mail =
mail("vadim@pechati.ru", "$title", $message,
 "From: Print-Stamp\r\n"
."Reply-To: Print-Stamp\r\n"
."Content-Type: text/html; charset=\"utf-8\"\r\n"
."X-Mailer: PHP/" . phpversion());
 
if($mail)
{
echo 'Передано сообщение!';
}
 
}
else
{
echo '<div class="notification_error">'.implode('<br />', $error).'</div>';
}
}
 
function getRealIpAddr() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip=$_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
			$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
 
 ?>