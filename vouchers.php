<?php

require_once('db_connection.php');


$jsonDataArray = [
    '{
        "code": 200,
        "status": "OK",
        "data": [
            {
                "number": "2",
                "minutes": "240",
                "comment": "",
                "count": "200",
                "active": "",
                "used": "5",
                "vouchers": [
                    "3vJU4JX4UQ4",
                    "RwaM6QDwMjw",
                    "rH7M858Qzs",
                    "hQaYGq4xW58",
                    "j2YyWbqvAiw",
                    "Ge3rLwJt4rV",
                    "vJTWrYdyxHE",
                    "q5upzAkFHLa",
                    "R7VXxsjQbj43",
                    "yV6i4rMDS823",
                    "aUfZv8BLtNT",
                    "JctiqifTG3z"
                ]
            },
            {
                "number": "0",
                "minutes": "240",
                "comment": "",
                "count": "200",
                "active": "",
                "used": "3",
                "vouchers": [
                    "Voucher1",
                    "Voucher2",
                    "Voucher3",
                    "Voucher4",
                    "Voucher5"
                ]
            }
        ]
    }'
];

foreach ($jsonDataArray as $json) {
    $data = json_decode($json, true);

    if ($data !== null) {
        foreach ($data['data'] as $entry) {
            $number = $entry['number'];
            $vouchers = $entry['vouchers'];

            foreach ($vouchers as $voucher) {
                // Insert voucher into the database
                $sql = "INSERT INTO tb_vouchers (roll_number, voucher_code) VALUES ('$number', '$voucher')";
                if ($conn->query($sql) === TRUE) {
                    // echo "Voucher inserted successfully: $voucher (Number $number)<br>";
                } else {
                    // echo "Error inserting voucher: " . $conn->error . "<br>";
                }
            }
        }
    } else {
        echo "Error decoding JSON data: " . json_last_error_msg() . "<br>";
    }
}
?>


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

    <div class="container table-responsive my-3">
        <?php
        if (isset($_GET['number'])) {
            $number = $_GET['number'];

            $vouchers = null;

            // Find the data for the selected number
            foreach ($jsonDataArray as $json) {
                $data = json_decode($json, true);

                if ($data === null) {
                    echo "<tr><td colspan='4'>Error decoding JSON data: " . json_last_error_msg() . "</td></tr>";
                } else {
                    foreach ($data['data'] as $entry) {
                        if ($entry['number'] === $number) {
                            $vouchers = $entry['vouchers'];
                            break; // Found the vouchers, no need to continue searching
                        }
                    }
                }
            }

            // Display vouchers or message
            echo "<div class='container'>";
            if ($vouchers !== null) {
                echo "<h4>Vouchers for Number $number:</h4>";

                // Start the table
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Column 1</th><th>Column 2</th><th>Column 3</th><th>Column 4</th></tr></thead>";
                echo "<tbody>";

                $totalVouchers = count($vouchers);
                $columns = 4;
                $vouchersPerColumn = ceil($totalVouchers / $columns);

                for ($i = 0; $i < $vouchersPerColumn; $i++) {
                    echo "<tr>";

                    for ($j = 0; $j < $columns; $j++) {
                        $index = $i + $j * $vouchersPerColumn;

                        if ($index < $totalVouchers) {
                            $voucher = $vouchers[$index];
                            $isUsed = ($index < $entry['used']); // Check if the voucher is used

                            // Add a cross (X) for used vouchers
                            $mark = $isUsed ? '<i class="fa-solid fa-x" style="color: #DF4453"></i>' : '<i class="fa-solid fa-check" style="color: #4EA37C;"></i>';

                            echo "<td>{$voucher} {$mark}</td>";
                        } else {
                            echo "<td></td>"; // Empty cell if there are no more vouchers
                        }
                    }

                    echo "</tr>";
                }

                // Close the table
                echo "</tbody></table>";
            } else {
                echo "<div class='center-container'>
            <div class='message'>
                <h3>No vouchers for this roll.</h3>
                <div class='emoji'>😞</div>
            </div>
        </div>";
            }
            echo "</div>";
        } else {
            echo "<div class='container'><tr><td colspan='4'>Please select a number to display vouchers.</td></tr></div>";
        }
        ?>

    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kmU1w7U5zg2tc3t6o5z5nxFt3B0F5R5r5C3f0N7Ktx7TwZl1iL2m5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5OFq0C97f5F5O5F5O5F5F5O5F5O5F5O5F5O5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5"></script>

</body>

</html>