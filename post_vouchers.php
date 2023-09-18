<?php

header('Content-Type: application/json');
require_once('db_connection.php');

if (isset($_REQUEST['auth_token'], $_REQUEST['cpzone'], $_REQUEST['number'], $_REQUEST['count'], $_REQUEST['minutes'], $_REQUEST['comment'], $_REQUEST['description'])) {

    $_REQUEST['auth_token'] = mysqli_real_escape_string($conn, $_REQUEST['auth_token']);
    $token = "fb60b8640b96fe2ae46181f53492a09c283";

    if ($token == $_REQUEST['auth_token']) {
        $_REQUEST['cpzone'] = mysqli_real_escape_string($conn, $_REQUEST['cpzone']);
        $_REQUEST['number'] = mysqli_real_escape_string($conn, $_REQUEST['number']);
        $_REQUEST['count'] = mysqli_real_escape_string($conn, $_REQUEST['count']);
        $_REQUEST['minutes'] = mysqli_real_escape_string($conn, $_REQUEST['minutes']);
        $_REQUEST['comment'] = mysqli_real_escape_string($conn, $_REQUEST['comment']);
        $_REQUEST['description'] = mysqli_real_escape_string($conn, $_REQUEST['description']);

        $cpzone = $_REQUEST['cpzone'];
        $number = $_REQUEST['number'];
        $count = $_REQUEST['count'];
        $minutes = $_REQUEST['minutes'];
        $comment = $_REQUEST['comment'];
        $description = $_REQUEST['description'];

        if (empty($cpzone) || empty($number) || empty($count) || empty($minutes) || empty($comment) || empty($description)) {
            $response = [
                "code" => 400,
                "status" => "Empty Parameter",
                "message" => "Parameter value must not be empty"
            ];
            header("HTTP/1.1 400 OK");
            echo json_encode($response);
        } else {
            if (!filter_var($count, FILTER_VALIDATE_INT) || !filter_var($minutes, FILTER_VALIDATE_INT)) {
                $response = [
                    "code" => 422,
                    "status" => "Invalid parameter value",
                    "message" => "Count and minutes must be valid."
                ];
                header("HTTP/1.1 422 OK");
                echo json_encode($response);
            } else {
                $selectQuery = "SELECT * FROM tb_roll WHERE external_roll_id = '$number' ";

                $result = mysqli_query($conn, $selectQuery);
                $totalRecords = mysqli_num_rows($result);
                if ($totalRecords > 0) {

                    $response = [
                        "code" => 200,
                        "status" => "Conflict",
                        "message" => 'Roll already present'
                    ];
                    header("HTTP/1.1 200 Forbidden");
                    echo json_encode($response);
                } else {
                    $insertQuery = "INSERT INTO tb_roll (external_roll_id, NAME, description, validity) VALUES ('$number', '$cpzone', '$description', '$minutes')";
                    $status = mysqli_query($conn, $insertQuery);


                    if ($status) {
                        $response = [
                            "code" => 204,
                            "status" => "Success",
                            "message" => 'Record successfully inserted.'
                        ];
                        header("HTTP/1.1 200 Forbidden");
                        echo json_encode($response);
                    } else {
                        $response = [
                            "code" => 204,
                            "status" => "Record not found",
                            "message" => 'No review found by given id.'
                        ];
                        header("HTTP/1.1 200 Forbidden");
                        echo json_encode($response);
                    }
                }
            }
        }
    } else {
        $response = [
            "code" => 402,
            "status" => "Unauthorized",
            "message" => "Auth token does not match"
        ];
        header("HTTP/1.1 402 OK");
        echo json_encode($response);
    }
} else {
    $response = [
        "code" => 401,
        "status" => "Bad Request",
        "message" => "Not all the parameters are passed in the request"
    ];
    header("HTTP/1.1 401 OK");
    echo json_encode($response);
}
