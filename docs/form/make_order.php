<?php
include('mailer.php');

//Грузим файл:
$uploadfile = 'uploads/'.basename($_FILES['userfile']['name']);

$result = array('result' => false, 
		'err' => 'Неизвестная ошибка');

if ($_FILES['userfile']['error']==1) {
	$result = array('result' => false, 
		'err' => 'Файл превысил допустимый размер');
}
else if ($_FILES['userfile']['error']==2) {
	$result = array('result' => false, 
		'err' => 'Файл превысил допустимый размер: '.$_POST['MAX_FILE_SIZE'].' байт');
}
else if ($_FILES['userfile']['error']==3) {
	$result = array('result' => false, 
		'err' => 'Файл загружен не полностью');
}
// else if ($_FILES['userfile']['error']==4) {
// 	$result = array('result' => false, 
// 		'err' => 'Файл не был загружен');
// }
else if ($_FILES['userfile']['error']==6) {
	$result = array('result' => false, 
		'err' => 'Не определена временная папка для файлов');
}
else if ($_FILES['userfile']['error']==7) {
	$result = array('result' => false, 
		'err' => 'Ошибка записи файла на диск');
}

if ($_FILES['userfile']['tmp_name'] != "") {
	if ($_FILES['userfile']['error']>0) {
		echo json_encode($result);
		die();
	}
	if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		$result = json_encode(array('result'=>false, 
			'err' => 'Не удалось записать файл в папку загрузки'));
		echo $result;
		die();
	}
}


//Отсылаем почту:

$title = ''.$_POST[title]."";
$name = 'Имя: '.$_POST[name]."";
$phone = 'Телефон: '.$_POST[phone]."";
$email = 'E-mail: '.$_POST[email]."";
$type = 'Тип печати: '.$_POST[type]."";
$osnastka = 'Тип оснастки: '.$_POST[osnastka]."";
$total = 'Заказ на сумму: '.$_POST[total_sum]."";
$messages = "Комментарий: ".$_POST[messages]."";

$ip = getRealIpAddr();
$message = "$title<br/>$name<br/>$phone<br/>$email<br/>$address<br/>$area<br/>$messages<br/>$type<br/>$osnastka<br/>$total<br/><br/>Со страницы: ".
$_SERVER['HTTP_REFERER']."<br/>IP: $ip<br/>Браузер: ".$_SERVER['HTTP_USER_AGENT']."<br/>";

$mail = new multipartmail("vadim@pechati.ru", "Новая заявка на \"Изготовление печати\"");
if ($uploadfile != "uploads/") {$cid = $mail->addattachment($uploadfile, "octet-stream");}
$mail->addmessage($message);
$mail->sendmail();

$result = json_encode(array('result'=>true, 'err'=>'Отправка прошла успешно: '.$message));
echo $result;
die();

 
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