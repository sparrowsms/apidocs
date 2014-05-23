<?php

    $client_id  = 'demo';
    $username   = 'demo';
    $password   = 'demo';
 
    $to     = '9841000000';
    $text   = 'I am trying the Sparrow SMS API using a Demo account';

	// STEP 1
    // build the url
    $api_url =  "http://api.sparrowsms.com/call_in.php?" . 
                http_build_query(array(
                    "client_id" => $client_id,
                    "username" => $username,
                    "password" => $password,
                    "to" => $to,
                    "text" => $text
                ));

	// STEP 2
    // put the request to server
    $response = file_get_contents($api_url);

	// check the response and verify
    print_r($response);
 
?>
