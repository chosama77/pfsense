


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>PFSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .center-container {
            display: flex;
            justify-content: center;
            /* align-items: center; */
            margin-top: 5%;
            height: 100vh;
        }

        .message {
            text-align: center;
            font-size: 24px;
        }

        .emoji {
            font-size: 36px;
        }

        .dropdown-menu {
            left: -150% !important;
        }

        @media only screen and (max-width: 600px) {
            .dropdown-menu {
                position: inherit;
                left: 0% !important;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid px-5">
            <a class="navbar-brand" href="index.php">Pfsense</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Zones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                </ul>
                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="dropdown">
                        <i class="fa fa-user-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="container-fluid my-3" style="display: flex; justify-content: center;">
        <div class="card" style="background-color: #F8F9FA !important; width: 95%;">
            <div class="card-body" style="padding: 10px !important;">
                <h4>Vouchers</h4>
            </div>
        </div>
    </div>

    <div class="container my-3">
    <?php
    $count = 0;
    if (isset($_GET['number'])) {
        $number = $_GET['number'];

        $ch = curl_init();
        $url = "https://182.191.81.171:8443/api/voucher.php?zone=netcue&number=0";
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
            // Handle curl error
            echo '<h3 style="text-align: center;">' . $e . '<div class="emoji">😞</div></h3>';
        } else {

            $decoded = json_decode($resp, true, 512, JSON_UNESCAPED_UNICODE); // Try decoding with specific options

            if ($decoded !== null && json_last_error() === JSON_ERROR_NONE) {
                // JSON decoding was successful
                // Check if the 'number' key exists in the decoded JSON
                if (isset($decoded['number'])) {
                    if ($decoded['number'] === $number) {
                        // Check if the 'vouchers' key exists
                        if (isset($decoded['vouchers'])) {
                            $vouchers = $decoded['vouchers'];

                            // Display the vouchers in a table
                            echo '<h3>Vouchers for Roll number ' . $number . ':</h3>';
                            echo '<table class="table table-bordered">';
                            echo '<thead><tr><th>Voucher</th></tr></thead>';
                            echo '<tbody> <tr>';

                            foreach ($vouchers as $voucher) {
                                echo '<td>' . $voucher . '</td>';
                                $count++;
                                if($count % 4 === 0){
                                    echo '</tr><tr>';
                                }
                            }

                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            // No 'vouchers' key in the JSON response
                            echo '<h3 style="text-align: center;">No vouchers available for Roll number ' . $number . '<div class="emoji">😞</div></h3>';
                        }
                    } else {
                        // The 'number' in the JSON response does not match the requested number
                        echo '<h3 style="text-align: center;">No vouchers available for Roll number ' . $number . '<div class="emoji">😞</div></h3>';
                    }
                } else {
                    // No 'number' key in the JSON response
                    echo '<h3 style="text-align: center;">No data available.</h3>';
                }
            } else {
                // JSON decoding failed
                echo '<h3 style="text-align: center;">Failed to decode JSON response.</h3>';
            }
        }

        // Close the cURL session
        curl_close($ch);
    }
    ?>
</div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kmU1w7U5zg2tc3t6o5z5nxFt3B0F5R5r5C3f0N7Ktx7TwZl1iL2m5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5OFq0C97f5F5O5F5O5F5F5O5F5O5F5O5F5O5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5"></script>

</body>

</html>