<?php

/**
 * DaphasBulkSmS Class 
 * 
 * @author Giceha(gicehajunior76@gmail.com)
 * @version v1.0
 * */
class DaphasBulkSmS {

    private $sender_id; 
    private $api_key; 
    private $sender_email; 
    private $contacts;
    private $message;

    private $ujumbe_messaging_endpoint;

    /**
     * DaphasBulkSmS class constructor
     */
    public function __construct($sender_id, $api_key, $sender_email)
    {
        $this->sender_id = $sender_id;
        $this->api_key = $api_key;
        $this->sender_email = $sender_email;
        $this->ujumbe_messaging_endpoint = "https://ujumbesms.co.ke/api/messaging";
    }


    /**
     * Takes care of sending an sms via ujumbe sms api
     * 
     * @author - Giceha(gicehajunior76@gmail.com)
     * @param  :  
     *         -  message - Actual text message that gets sent to recipient.
     * 
     *         -  contacts - Selected array of numbers to send the message to.
     * @return array
     */
    public function send($message, $contacts = []) {
        $this->message = $message;
        $this->contacts = implode(",", $contacts); 
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->ujumbe_messaging_endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
                "data": [
                    {
                        "message_bag": {
                            "numbers": "' . $this->contacts . '",
                            "message": "' . $this->message . '",
                            "sender": "' . $this->sender_id . '"
                        }
                    }
                ]
            }',
    
            CURLOPT_HTTPHEADER => array (
                'Content-Type: application/json',
                'Access-Control-Allow-Origin: *',
                'Accept-Language: *',
                'X-Authorization: ' . $this->api_key,
                'email: ' . $this->sender_email,
                'Cache-Control: no-cache'
            ),
        ));
    
        $response = curl_exec($curl);
    
        if (curl_errno($curl)) {
            $response = curl_error($curl);
        }
    
        curl_close($curl);

        $response_obj = array();

        foreach (json_decode($response) as $key => $obj_val) { 
            $response_obj[$key] = $obj_val;
        }
    
        return $response_obj;
    }

}

