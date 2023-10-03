<?php

header('Content-Type: application/json');
require_once('dbconnection.php');

if (isset($_REQUEST['auth_token'], $_REQUEST['city'], $_REQUEST['limit'])) {

    $_REQUEST['auth_token'] = mysqli_real_escape_string($conn, $_REQUEST['auth_token']);
    $token = "49866f9a672b9c9db2d982dd6fffdd16";

    if ($token == $_REQUEST['auth_token']) {
        $_REQUEST['city'] = mysqli_real_escape_string($conn, $_REQUEST['city']);
        $_REQUEST['limit'] = mysqli_real_escape_string($conn, $_REQUEST['limit']);

        $city = $_REQUEST['city'];
        $limit = $_REQUEST['limit'];

        if (empty($city)) {
            $response = [
                "code"    => 400,
                "status"    => "Empty Parameter",
                "message"   => "Parameter value must not be empty"
            ];
            header("HTTP/1.1 400 OK");
            echo json_encode($response);
        } else {
            if (!filter_var($limit, FILTER_VALIDATE_INT)) {
                $response = [
                    "code" => 422,
                    "status" => "Invalid parameter value",
                    "message" => "Limit must be valid."
                ];
                header("HTTP/1.1 422 OK");
                echo json_encode($response);
            } else {
                if (!empty($limit)) {
                    $selectQuery = "SELECT * FROM tb_restaurants WHERE city = '$city' ORDER BY id ASC LIMIT {$limit}";

                    $result = mysqli_query($conn, $selectQuery);
                    $totalRecords = mysqli_num_rows($result);
                    if ($totalRecords > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {
                            $image_name = $row['place_id'];
                            $image_url = 'https://sv.revapvt.com/storage/uploads/restaurants/main/' . $image_name . '.png';
                            $data[] = array(

                                "id" => $row['id'],
                                "image_url" => $image_url,
                                "name" => $row['name'],
                                "types" => $row['types'],
                                "contact" => $row['contact'],
                                "city" => $row['city'],
                                "website" => $row['website'],
                                "menu" => $row['menu'],
                                "cuisines" => $row['cuisines'],
                                "rating" => $row['rating'],
                                "user_ratings_total" => $row['user_ratings_total'],
                                "price_level" => $row['price_level'],
                                "lat" => $row['lat'],
                                "lng" => $row['lng'],
                                "address" => $row['address']

                            );
                        }
                        $response = [
                            "code" => 200,
                            "status" => "OK",
                            "result" => $data
                        ];
                        header("HTTP/1.1 200 OK");
                        echo json_encode($response);
                    } else {
                        $response = [
                            "code"    => 204,
                            "status" => "Record not found",
                            "message" => 'No restaurant found in this city.'
                        ];
                        header("HTTP/1.1 403 Forbidden");
                        echo json_encode($response);
                    }
                } else {

                    $selectQuery = "SELECT * FROM tb_restaurants WHERE city = '$city' ORDER BY id ASC";

                    $result = mysqli_query($conn, $selectQuery);
                    $totalRecords = mysqli_num_rows($result);
                    if ($totalRecords > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                            $image_name = $row['place_id'];
                            $image_url = 'https://sv.revapvt.com/storage/uploads/restaurants/main/' . $image_name . '.png';
                            $data[] = array(

                                "id" => $row['id'],
                                "image_url" => $image_url,
                                "name" => $row['name'],
                                "types" => $row['types'],
                                "contact" => $row['contact'],
                                "city" => $row['city'],
                                "website" => $row['website'],
                                "menu" => $row['menu'],
                                "cuisines" => $row['cuisines'],
                                "rating" => $row['rating'],
                                "user_ratings_total" => $row['user_ratings_total'],
                                "price_level" => $row['price_level'],
                                "lat" => $row['lat'],
                                "lng" => $row['lng'],
                                "address" => $row['address']

                            );
                        }
                        $response = [
                            "code" => 200,
                            "status" => "OK",
                            "result" => $data
                        ];
                        header("HTTP/1.1 200 OK");
                        echo json_encode($response);
                    } else {
                        $response = [
                            "code"    => 204,
                            "status" => "Record not found",
                            "message" => 'No restaurant found in this city.'
                        ];
                        header("HTTP/1.1 403 Forbidden");
                        echo json_encode($response);
                    }
                }
            }
        }
    } else {
        $response = [
            "code"    => 402,
            "status"    => "Unauthorized",
            "message"   => "Auth token does not match"
        ];
        header("HTTP/1.1 402 OK");
        echo json_encode($response);
    }
} else {
    $response = [
        "code"    => 401,
        "status"    => "Bad Request",
        "message"   => "Not all the parameters are passed in the request"
    ];
    header("HTTP/1.1 401 OK");
    echo json_encode($response);
}
