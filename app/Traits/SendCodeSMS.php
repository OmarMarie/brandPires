<?php

namespace App\Traits;

trait SendCodeSMS
{
    public function sms($message,$userMobile)
    {
        /*$sms_link = 'http://josmsservice.com/smsonline/msgservicejo.cfm?numbers=962'.substr($phone,  '&senderid=MASSAR&AccName=MASSAR&AccPass=E3@hB7$PgG4&msg='.$code.$mssg_text;*/

        $url = 'http://josmsservice.com/smsonline/msgservicejo.cfm';

        $fields = array(
            'AccName' => "MASSAR",		// The user name of gateway
            'AccPass' => 'E3@hB7$PgG4', // the password of gateway  1V2d3h4q
            'numbers' => $userMobile, // 962790000000
            'msg' => $message,
            'senderid' => "MASSAR"
        );

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
    }
}