<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>PFSense</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .clickable-row:hover {
      cursor: pointer !important;
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
        <h4>Services</h4>
      </div>
    </div>
  </div>

  <div class="container table-responsive my-3">
    <table class="table table-striped">
      <thead class="thead-Secondary" style="background-color: #E2E3E5 !important;">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Zone</th>
          <th scope="col">Interfaces</th>
          <th scope="col">Number of Users</th>
          <th scope="col">Descriptions</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php

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


          curl_close($ch);


          if ($e = curl_error($ch)) {
            echo $e;
          } else {
            $decoded = json_decode($resp, true); // Decode JSON as an associative array

            if (is_array($decoded) && isset($decoded['data'])) {
              $jsonDataArray = $decoded['data'];

              $rowNumber = 1;

              foreach ($jsonDataArray as $entry) {
                echo "<tr class='clickable-row' onclick=\"window.location='rolls.php?zone={$entry['zone']}'\">";
                echo "<th scope='row'>$rowNumber</th>";
                echo "<td>" . (isset($entry['zone']) ? $entry['zone'] : '-') . "</td>";
                echo "<td>" . (isset($entry['interface']) ? $entry['interface'] : '-') . "</td>";
                echo "<td>" . (isset($entry['roll'][0]['count']) ? $entry['roll'][0]['count'] : '-') . "</td>";
                echo "<td>" . (isset($entry['descr']) ? $entry['descr'] : '-') . "</td>";
                echo "<td><a class='btn btn-primary' href='osam.php'><i class='fa-solid fa-pencil'></i></a></td>";
                echo "</tr>";

                $rowNumber++;
              }
            } else {
              echo "<tr><td colspan='6'>Error decoding JSON data.</td></tr>";
            }
          }

          curl_close($ch);
          // ... Rest of your code ...

        ?>
      </tbody>
    </table>
  </div>


<?php  } ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kmU1w7U5zg2tc3t6o5z5nxFt3B0F5R5r5C3f0N7Ktx7TwZl1iL2m5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5OFq0C97f5F5O5F5O5F5F5O5F5O5F5O5F5O5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5"></script>

</body>

</html>