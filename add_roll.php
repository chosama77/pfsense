<?php

require_once('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $zone = $_POST["txt_zone"];
    $number = $_POST["txt_number"];
    $validity = $_POST["txt_validity"];
    $count = $_POST["txt_count"];
    $description = $_POST["txt_description"];

    $insert = "INSERT INTO tb_rolls (number, minutes, description, count) VALUES ('$number', '$validity', '$description', '$count')";
    $status = mysqli_query($conn, $insert);

    if ($status) {
        $ch = curl_init();
        $url = "https://182.191.81.171:8443/api/zone.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set the AUTH header
        $headers = array(
            'AUTH: 2yrzOZq0OSByIjXnPzo0CCmwZRFbPUAN',
            'Content-Type: application/json', // Example content type header
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Disable SSL certificate verification (use with caution)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $resp = curl_exec($ch);
        if ($e = curl_error($ch)) {
            echo $e;
        } else {
            $decoded = json_decode($resp);
            // print_r($decoded);
            $zoneid = null;
            foreach ($decoded->data as $zoneData) {
                if ($zoneData->zone === $zone) {
                    $zoneid = $zoneData->zoneid;
                    break; 
                }
            }

            if ($zoneid !== null) {
                echo "Zone ID for '$zone': " . $zoneid;
            } else {
                echo "Zone '$zone' not found in the data.";
            }
        }
    }

    curl_close($ch);
    echo 'success';
} else {
    echo 'error'  . mysqli_error($conn);
}
