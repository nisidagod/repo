<?php

require_once __DIR__ . '/vendor/autoload.php';
$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');
//$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv(''));
$bot = new \LINE\LINEBot($accessToken, ['channelSecret' => getenv('329695d93f519ef5bdc856f2276c7b4d')]);

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}

foreach ($events as $event) {
  $bot->replyText($event->getReplyToken(), "https://" . $_SERVER["HTTP_HOST"] .  "/line_login.php");
}

?>
