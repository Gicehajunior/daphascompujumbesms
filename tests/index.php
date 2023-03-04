<?php
include('vendor/autoload.php');
include('../index.php'); 

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

$sender_email = $_ENV['DAPHAS_UJUMBE_SENDER_EMAIL'];
$sender_id = $_ENV['DAPHAS_UJUMBE_SENDER_ID'];
$api_key = $_ENV['DAPHAS_UJUMBE_API_KEY'];

$contacts = ["0722336262", "0719462331", "0748794365"];
$message = "Testing bulk sms on 0719462331 and 0748794365";

$sms = new DaphasBulkSmS($sender_id, $api_key, $sender_email);
$response = $sms->send($message, $contacts);

echo var_dump($response);