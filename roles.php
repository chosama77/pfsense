<?php
$jsonDataArray = [
  '{
          "code": 200,
          "status": "OK",
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
        }',
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Rolls</title>
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
            <a class="nav-link active" aria-current="page" href="index.php">Zones</a>
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
        <h4>Rolls</h4>
      </div>
    </div>
  </div>

  <div class="container table-responsive my-3">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Roll Number</th>
          <th>Roll Minutes</th>
          <th>Roll Description</th>
          <th>Roll Count</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_GET['zone'])) {
          $zone = $_GET['zone'];

          // Find the data for the selected zone
          foreach ($jsonDataArray as $json) {
            $data = json_decode($json, true);

            if ($data !== null) {
              foreach ($data['data'] as $entry) {
                if (isset($entry['zone']) && $entry['zone'] === $zone) {
                  foreach ($entry['roll'] as $roll) {
                    echo "<tr class='clickable-row' onclick=\"window.location='vouchers.php?number={$roll['number']}'\">";
                    echo "<td>{$roll['number']}</td>";
                    echo "<td>{$roll['minutes']}</td>";
                    echo "<td>{$roll['descr']}</td>";
                    echo "<td>{$roll['count']}</td>";
                    echo "<td><button class='btn btn-primary'>edit</button> <button class='btn btn-danger'>delete</button></td>";
                    echo "</tr>";
                  }
                }
              }
            } else {
              echo "No data available"; // Add a message for cases when $data is null.
            }
          }
        }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kmU1w7U5zg2tc3t6o5z5nxFt3B0F5R5r5C3f0N7Ktx7TwZl1iL2m5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5OFq0C97f5F5O5F5O5F5F5O5F5O5F5O5F5O5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5"></script>

</body>

</html>