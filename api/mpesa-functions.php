<?php

    function getMpesaAccessToken(){
        //YOU MPESA API KEYS
        $consumerKey = "4qvGImGdAPLS72g0kgdW1Nh4Cfuq6Fh0"; //Fill with your app Consumer Key
        $consumerSecret = "JVSAF7WKxC8iJX2x"; //Fill with your app Consumer Secret

        //ACCESS TOKEN URL
        $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $headers = ['Content-Type:application/json; charset=utf8'];

        $curl = curl_init($access_token_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);

        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);

        //echo $access_token = $result->access_token;
        curl_close($curl);
        return $result->access_token;
    }

    function securityCredential(){
        $pass = "Safaricom999!*!";
        $publicKey = "-----BEGIN CERTIFICATE-----
        MIIGgDCCBWigAwIBAgIKMvrulAAAAARG5DANBgkqhkiG9w0BAQsFADBbMRMwEQYK
        CZImiZPyLGQBGRYDbmV0MRkwFwYKCZImiZPyLGQBGRYJc2FmYXJpY29tMSkwJwYD
        VQQDEyBTYWZhcmljb20gSW50ZXJuYWwgSXNzdWluZyBDQSAwMjAeFw0xNDExMTIw
        NzEyNDVaFw0xNjExMTEwNzEyNDVaMHsxCzAJBgNVBAYTAktFMRAwDgYDVQQIEwdO
        YWlyb2JpMRAwDgYDVQQHEwdOYWlyb2JpMRAwDgYDVQQKEwdOYWlyb2JpMRMwEQYD
        VQQLEwpUZWNobm9sb2d5MSEwHwYDVQQDExhhcGljcnlwdC5zYWZhcmljb20uY28u
        a2UwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCotwV1VxXsd0Q6i2w0
        ugw+EPvgJfV6PNyB826Ik3L2lPJLFuzNEEJbGaiTdSe6Xitf/PJUP/q8Nv2dupHL
        BkiBHjpQ6f61He8Zdc9fqKDGBLoNhNpBXxbznzI4Yu6hjBGLnF5Al9zMAxTij6wL
        GUFswKpizifNbzV+LyIXY4RR2t8lxtqaFKeSx2B8P+eiZbL0wRIDPVC5+s4GdpFf
        Y3QIqyLxI2bOyCGl8/XlUuIhVXxhc8Uq132xjfsWljbw4oaMobnB2KN79vMUvyoR
        w8OGpga5VoaSFfVuQjSIf5RwW1hitm/8XJvmNEdeY0uKriYwbR8wfwQ3E0AIW1Fl
        MMghAgMBAAGjggMkMIIDIDAdBgNVHQ4EFgQUwUfE+NgGndWDN3DyVp+CAiF1Zkgw
        HwYDVR0jBBgwFoAU6zLUT35gmjqYIGO6DV6+6HlO1SQwggE7BgNVHR8EggEyMIIB
        LjCCASqgggEmoIIBIoaB1mxkYXA6Ly8vQ049U2FmYXJpY29tJTIwSW50ZXJuYWwl
        MjBJc3N1aW5nJTIwQ0ElMjAwMixDTj1TVkRUM0lTU0NBMDEsQ049Q0RQLENOPVB1
        YmxpYyUyMEtleSUyMFNlcnZpY2VzLENOPVNlcnZpY2VzLENOPUNvbmZpZ3VyYXRp
        b24sREM9c2FmYXJpY29tLERDPW5ldD9jZXJ0aWZpY2F0ZVJldm9jYXRpb25MaXN0
        P2Jhc2U/b2JqZWN0Q2xhc3M9Y1JMRGlzdHJpYnV0aW9uUG9pbnSGR2h0dHA6Ly9j
        cmwuc2FmYXJpY29tLmNvLmtlL1NhZmFyaWNvbSUyMEludGVybmFsJTIwSXNzdWlu
        ZyUyMENBJTIwMDIuY3JsMIIBCQYIKwYBBQUHAQEEgfwwgfkwgckGCCsGAQUFBzAC
        hoG8bGRhcDovLy9DTj1TYWZhcmljb20lMjBJbnRlcm5hbCUyMElzc3VpbmclMjBD
        QSUyMDAyLENOPUFJQSxDTj1QdWJsaWMlMjBLZXklMjBTZXJ2aWNlcyxDTj1TZXJ2
        aWNlcyxDTj1Db25maWd1cmF0aW9uLERDPXNhZmFyaWNvbSxEQz1uZXQ/Y0FDZXJ0
        aWZpY2F0ZT9iYXNlP29iamVjdENsYXNzPWNlcnRpZmljYXRpb25BdXRob3JpdHkw
        KwYIKwYBBQUHMAGGH2h0dHA6Ly9jcmwuc2FmYXJpY29tLmNvLmtlL29jc3AwCwYD
        VR0PBAQDAgWgMD0GCSsGAQQBgjcVBwQwMC4GJisGAQQBgjcVCIfPjFaEwsQDhemF
        NoTe0Q2GoIgIZ4bBx2yDublrAgFkAgEMMB0GA1UdJQQWMBQGCCsGAQUFBwMCBggr
        BgEFBQcDATAnBgkrBgEEAYI3FQoEGjAYMAoGCCsGAQUFBwMCMAoGCCsGAQUFBwMB
        MA0GCSqGSIb3DQEBCwUAA4IBAQBMFKlncYDI06ziR0Z0/reptIJRCMo+rqo/cUuP
        KMmJCY3sXxFHs5ilNXo8YavgRLpxJxdZMkiUIVuVaBanXkz9/nMriiJJwwcMPjUV
        9nQqwNUEqrSx29L1ARFdUy7LhN4NV7mEMde3MQybCQgBjjOPcVSVZXnaZIggDYIU
        w4THLy9rDmUIasC8GDdRcVM8xDOVQD/Pt5qlx/LSbTNe2fekhTLFIGYXJVz2rcsj
        k1BfG7P3pXnsPAzu199UZnqhEF+y/0/nNpf3ftHZjfX6Ws+dQuLoDN6pIl8qmok9
        9E/EAgL1zOIzFvCRYlnjKdnsuqL1sIYFBlv3oxo6W1O+X9IZ
        -----END CERTIFICATE-----";
        openssl_public_encrypt($pass, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
        $SecurityCredential = base64_encode($encrypted);
    }

    function initiateSTKPush($phoneNumber, $amount, $transactionDesc){
        //INCLUDE THE ACCESS TOKEN FILE
        $access_token = getMpesaAccessToken();

        date_default_timezone_set('Africa/Nairobi');

        $processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $callbackurl = 'https://1c95-105-161-14-223.ngrok-free.app/MPEsa-Daraja-Api/callback.php';

        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $BusinessShortCode = '174379';
        $Timestamp = date('YmdHis');

        // ENCRIPT  DATA TO GET PASSWORD
        $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);

        $PartyA = $phoneNumber; //Phone Number to receive STK Push.
        $AccountReference = 'Elite Money Manager';
        $TransactionDesc = 'Automated deposit daily deposit';
        $Amount = $amount; //The amount to be sent

        $stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

        //INITIATE CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader); //setting custom header
        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => $PartyA,
            'CallBackURL' => $callbackurl,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc
        );

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        //echo $curl_response = curl_exec($curl);
        $curl_response = curl_exec($curl);

        //ECHO  RESPONSE
        $data = json_decode($curl_response);
        //$CheckoutRequestID = $data->CheckoutRequestID;
        //$ResponseCode = $data->ResponseCode;
        return $data;
        if ($ResponseCode == "0") {
            //echo "The CheckoutRequestID for this transaction is : " . $CheckoutRequestID;
        }
    }


    function handleSTKPushResponse($host, $user, $password, $database, $stkPushResponse){
        if(isset($stkPushResponse->errorCode)){
            /**
             * Handle error code
             */
            $merchantRequestId = $stkPushResponse->requestId;
            $errorCode = $stkPushResponse->errorCode;
            $errorMessage = $stkPushResponse->errorMessage;

            if($stkPushResponse->errorCode == "500.001.1001"){
                $data = [
                    "requestId"=>"c62b-4e23-a479-5f74de8082a1893078",
                    "errorCode"=>"500.001.1001",
                    "errorMessage"=>"Unable to lock subscriber, a transaction is already in process for the current subscriber"
                ];

            } else if ( $stkPushResponse->errorCode == "500.003.02" ){
                $data = [
                    "requestId"=>"c62b-4e23-a479-5f74de8082a1893336",
                    "errorCode"=>"500.003.02",
                    "errorMessage"=>"System is busy. Please try again in few minutes."
                ];
            }
            
            $sql = "INSERT INTO mpesa_transactions(`stk_push_merchant_request_id`, `stk_push_error_code`, `stk_push_error_message`) VALUES('$merchantRequestId', '$errorCode', '$errorMessage')";
            $mpesaTransactionId = create($host, $user, $password, $database, $sql);
        } else {
            $merchantRequestId = $stkPushResponse->MerchantRequestID;
            $checkoutRequestId = $stkPushResponse->CheckoutRequestID;
            $responseCode = $stkPushResponse->ResponseCode;
            $responseDescription = $stkPushResponse->ResponseDescription;
            $customerMessage = $stkPushResponse->CustomerMessage;

            $sql = "INSERT INTO mpesa_transactions(`stk_push_merchant_request_id`, `stk_push_checkout_request_id`, `stk_push_response_code`, `stk_push_response_description`, stk_push_customer_message) VALUES('$merchantRequestId', '$checkoutRequestId', '$responseCode', '$responseDescription', '$customerMessage')";
            $mpesaTransactionId = create($host, $user, $password, $database, $sql);
        }

        return $mpesaTransactionId;
    }
    //initiateSTKPush("254717551542", 1, "Regular deposit");
    //echo $access_token;

    

    function makePayment(){
        securityCredential();
        $access_token = getMpesaAccessToken();

        $b2c_url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
        $InitiatorName = '';
        $pass = "";
        $BusinessShortCode = "600983";
        $phone = "";
        $amountsend = '';
        //$SecurityCredential ='iOZoPBIc9xvaZviQ6TpN64Jh800cv7My9azP6CH98Jzo6od8uPN/7JP/3XjREd8QjZG9a7DgAdubNbonsc3IMI3xckZ/b+ARt75VSWY//t2xxyWgLa9KW4OUIC7Ge7so8H3GvhnfGP5nhPcxwSJzXhyX72ayqxHba4Ay0m7DFrbLguDqyIqCyG2rrmP1B9cQbMFMIWed3XTny/4RCnKVMtecieZ6IGXuLLxMSKzDWZ3D3K3rMjlR0kR16LbNjjqs32YUN9G1g75hz1h37apUY0kP4Maicvd0K2qNWDoqKo/YQwLrhGsmVh/gybQeaQuPs9ssZUQ6wNDVD4Eg+a8qAA==';
        $CommandID = 'SalaryPayment'; // SalaryPayment, BusinessPayment, PromotionPayment
        $Amount = $amountsend;
        $PartyA = $BusinessShortCode;
        $PartyB = $phone;
        $Remarks = 'Umeskia Withdrawal';
        $QueueTimeOutURL = 'https://1c95-105-161-14-223.ngrok-free.app/MPEsa-Daraja-Api/b2cCallbackurl.php';
        $ResultURL = 'https://1c95-105-161-14-223.ngrok-free.app/MPEsa-Daraja-Api/dataMaxcallbackurl.php';
        $Occasion = 'Online Payment';
        /* Main B2C Request to the API */
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $b2c_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token]);
        $curl_post_data = array(
            'InitiatorName' => $InitiatorName,
            'SecurityCredential' => $SecurityCredential,
            'CommandID' => $CommandID,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'Remarks' => $Remarks,
            'QueueTimeOutURL' => $QueueTimeOutURL,
            'ResultURL' => $ResultURL,
            'Occasion' => $Occasion
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        echo $curl_response;
    }
    