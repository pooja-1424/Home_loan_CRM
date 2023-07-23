<?php
namespace App\helpers;

use Illuminate\Support\Facades\Log;

class sendMessageHelper
{
    public static function sendMsgCurl($data)
    {
        $whatsapp_msg = array();
        $whatsapp_msg['to'] = $data['msg_contact'];//recipient number
        $whatsapp_msg['messaging_product'] = "whatsapp"; // product type
        $whatsapp_msg['type'] = "text"; //message type
        $whatsapp_msg['recipient_type'] = "individual"; // recipient type
        
        $whatsapp_txt = array();
        $whatsapp_txt['preview_url'] = "false";
        $whatsapp_txt['body'] = $data['msg_val'];
        
        $whatsapp_msg['text'] = $whatsapp_txt; //whatsapp text message content
        
        Log::channel('whatsapp')->info("----------------- WHATSAPP DATA ------------------");
        Log::channel('whatsapp')->info(json_encode($whatsapp_msg));
        
        /* api credentials */
        $whatsapp_msg_url = config('whatsapp.whatsapp_url.messages');
        $whatsapp_msg_token = config('whatsapp.bearer_token');
        $whatsapp_url = $whatsapp_msg_url.'111769511815439/messages';
        
        /* Curl request */
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $whatsapp_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($whatsapp_msg),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$whatsapp_msg_token,
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        Log::channel('whatsapp')->info(json_encode($response));

        curl_close($curl);
        return $response;
    }
}

?>