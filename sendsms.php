<?php
require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;


function request()
{
    return  json_decode(file_get_contents('php://input'));
}
$request = request();
$phones = $request->phones;
$messages = $request->messages;
$username = "sandbox";
//$apiKey = getenv("API_KEY");
$apiKey = "4ca73f85280344016ed322335f12b884b0e3cad474646a5a6ab8ab4c07ca5fa8";


// Initialize the SDK
$AT         = new AfricasTalking($username, $apiKey);
$sms        = $AT->sms();
$results = array(
    "success"=> array(),
    "failed" => array()
);
for ($i=0; $i < sizeof($phones) ; $i++) { 
    $recipients = $phones[$i];
    $message    = $messages[$i];    
    // Set your shortCode or senderId
    $from       = "17532";    
    try {
        // Thats it, hit send and we'll take care of the rest
        $result = $sms->send([
            'to'      => $recipients,
            'message' => $message,
            'from'    => $from
        ]);
        if($result['status'] == "success"){
            array_push($results["success"], $recipients);             
        }else{
            array_push($results["failed"], $recipients);             
        }
    } catch (Exception $e) {
        array_push($results["failed"], $recipients);             
        echo "Error: ".$e->getMessage();
    }
}
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($results);