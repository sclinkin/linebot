<?
	$receive = json_decode(file_get_contents("php://input"),true);
	$lineObj = new line_bot();

	$source  = $receive['events'][0]['source'];
	$message = $receive['events'][0]['message'];

	$finnal_target = ($source['type'] == 'user')? $source['userId']:$source['groupId']; //最後發送目的

	$lineObj->sendMessage($finnal_target,"test bot");
?>
<?
	class line_bot{
		var $channel_token;

		function __construct(){
			$this->channel_token="";

		}
		
		/* 發送訊息 */
		function sendMessage($to , $message) {
				$url = "https://api.line.me/v2/bot/message/push";
				$header = array("Content-Type: application/json; charser=UTF-8", "Authorization:Bearer " . $this->channel_token);
				$data = array("to" => $to, "messages"=>(array(array("type"=>"text","text"=>$message))));

				$context = $data;
								
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
			
				
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode( $context ));
				
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_TIMEOUT, 5 );
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
				$result = curl_exec($curl);
				curl_close($curl);
				print_r($result);
		}
	}
?>
