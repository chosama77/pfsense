<?php

header('Content-Type: application/json');
require_once('db_connection.php');

if (isset($_REQUEST['auth_token'])) {

    $_REQUEST['auth_token'] = mysqli_real_escape_string($conn, $_REQUEST['auth_token']);
    $token = "49866f9a672b9c9db2d982dd6fffdd16";

    if ($token == $_REQUEST['auth_token']) {

        // $resp = curl_exec($ch);
        $jsonDataArray = 
            '{
          "data": [
              {
                  "zone": "netcue",
                  "descr": "its netcue",
                  "localauth_priv": "",
                  "zoneid": "2",
                  "interface": "wan",
                  "roll": [
                      {
                          "zone": "netcue",
                          "number": "1",
                          "minutes": "180",
                          "descr": "Comment",
                          "count": "100",
                          "used": "AAAAAAAAAAAAAAAAAA==",
                          "active": "",
                          "lastsync": "1694156834"
                      },
                      {
                          "zone": "netcue",
                          "number": "2",
                          "minutes": "240",
                          "descr": "Comment 2",
                          "count": "200",
                          "used": "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=",
                          "active": "",
                          "lastsync": "1694156844"
                      },
                      {
                          "zone": "netcue",
                          "number": "0",
                          "minutes": "1",
                          "comment": "New Voucher Created",
                          "descr": "Description",
                          "count": "10",
                          "used": "AAA=",
                          "active": ""
                      }
                  ]
              },
              {
                  "zone": "Gold",
                  "descr": "Gold Zone",
                  "localauth_priv": "",
                  "zoneid": "4",
                  "interface": "lan",
                  "roll": [
                      {
                          "zone": "gold",
                          "number": "0",
                          "minutes": "181",
                          "descr": "",
                          "count": "182",
                          "used": "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=",
                          "active": "",
                          "lastsync": "1694426414"
                      }
                  ]
              }
          ]
        }'
          ;
$response_data = json_decode($jsonDataArray);

          $response = [
            "code"    => 200,
            "status"    => "Success",
            "data"   => $response_data
        ];
        header("HTTP/1.1 200 OK");
        
            
            // Encode the final array as JSON and send it as the response
            // $jsonResponse = json_encode($responseData, JSON_PRETTY_PRINT);
            echo json_encode($response);
            // echo json_encode($jsonDataArray);
        
    } else {
        $response = [
            "code"    => 402,
            "status"    => "Unauthorized",
            "message"   => "Auth token does not match"
        ];
        header("HTTP/1.1 200 OK");
        echo json_encode($response);
    }
} else {
    $response = [
        "code"    => 401,
        "status"    => "Bad Request",
        "message"   => "Not all the parameters are passed in the request"
    ];
    header("HTTP/1.1 200 OK");
    echo json_encode($response);
}
