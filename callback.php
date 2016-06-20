<?
/* 輸入申請的Line Developers 資料  */
$channel_id = "";
$channel_secret = "";
$mid = "";

/* 將收到的資料整理至變數 */
$receive = json_decode(file_get_contents("php://input"));
$text = $receive->result{0}->content->text;
$from = $receive->result[0]->content->from;
$content_type = $receive->result[0]->content->contentType;

$str = explode("|", $text);
if(trim($str[0]) == 'author'){ //記憶所需要的資訊 
    $logfile = fopen("mids/".$str[1]."_".$from.".txt" ,"a");
    fwrite($logfile, file_get_contents("php://input")."\r\n");
    fclose($logfile);
}else{
}


/* 準備Post回Line伺服器的資料 */
$header = array("Content-Type: application/json; charser=UTF-8", "X-Line-ChannelID:" . $channel_id, "X-Line-ChannelSecret:" . $channel_secret, "X-Line-Trusted-User-With-ACL:" . $mid);
sendMessage($header, $from, $message);


/* 發送訊息 */
function sendMessage($header, $to, $message) {

        $url = "https://trialbot-api.line.me/v1/events";
        $data = array("to" => array($to), "toChannel" => 1383378250, "eventType" => "138311608800106203", "content" => array("contentType" => 1, "toType" => 1, "text" => $message));
        $context = stream_context_create(array(
        "http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
        ));
       $a = file_get_contents($url, false, $context);
	   print_r($a);
}

?>

