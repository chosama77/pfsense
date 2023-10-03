<?php


$jsonData = '[
    {
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
                        "used": "20",
                        "active": "",
                        "lastsync": "1694156834"
                    },
                    {
                        "zone": "netcue",
                        "number": "2",
                        "minutes": "240",
                        "descr": "Comment 2",
                        "count": "200",
                        "used": "50",
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
                        "used": "3",
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
                        "used": "10",
                        "active": "",
                        "lastsync": "1694426414"
                    }
                ]
            }
        ]
    }
]';

// Decode the JSON data
$jsonDataArray = json_decode($jsonData, true);

// Check if the decoding was successful

if ($jsonDataArray !== null) {
  // Initialize counters
  $zoneCount = 0;
  $totalRollCount = 0;
  $totalVouchersUsed = 0;
  $rollCount = 0;
    
  // Iterate through zones
  foreach ($jsonDataArray[0]['data'] as $zone) {
      // Count zones
      $zoneCount++;
      
      // Count rolls within each zone
      $rollCount += count($zone['roll']);
  }
  
  // Iterate through zones
  foreach ($jsonDataArray[0]['data'] as $zone) {
      // Count zones
      
      // Initialize roll count for the current zone
      $zoneRollCount = 0;
      
      // Iterate through rolls within each zone
      foreach ($zone['roll'] as $roll) {
          // Add the count to the zoneRollCount
          $zoneRollCount++;
          
          // Add the count to the totalRollCount
          $totalRollCount += (int)$roll['count'];
          $totalVouchersUsed += (int)$roll['used'];
      }
    
  }
} else {
  echo "Failed to decode JSON data.";
}
if ($jsonDataArray !== null) {
    // Initialize counters
    $zoneCount = 0;
    $rollCount = 0;
    
    // Iterate through zones
    foreach ($jsonDataArray[0]['data'] as $zone) {
        // Count zones
        $zoneCount++;
        
        // Count rolls within each zone
        $rollCount += count($zone['roll']);
    }
    
} else {
    echo "Failed to decode JSON data.";
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
    .card_hover:hover {
  /* Add a slight shadow */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);

  /* Increase the opacity of the card body */
  opacity: 1;

  /* Add a color transition to the card body */
  transition: background-color 0.5s ease-in-out;
}

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
        <h4>Dashboard</h4>
      </div>
    </div>
  </div>

  <!-- Page Content -->
<div id="content">
    <div class="container">

        <!-- Analytics Charts -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card card_hover">
                    <div class="card-header">
                        Zones
                    </div>
                    <div class="card-body">
                        <canvas id="lineChart"></canvas>
                        <h3>Total Zones: <?php echo $zoneCount; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card_hover">
                    <div class="card-header">
                        Rolls
                    </div>
                    <div class="card-body">
                        <canvas id="barChart"></canvas>
                        <h3>Total Rolls: <?php echo $rollCount; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Data Table -->
        <div class="card card_hover mt-4">
            <div class="card-header">
                Vouchers
            </div>
            <div class="card-body">
                <div class="container" style="display: flex; justify-content: space-around;">
                    <h3>Total vouchers: <span><?php echo $totalRollCount ?></span></h3>
                    <h3>Total vouchers Used: <span><?php echo $totalVouchersUsed ?></span></h3>
                </div>
            </div>
        </div>

    </div>
</div>



  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kmU1w7U5zg2tc3t6o5z5nxFt3B0F5R5r5C3f0N7Ktx7TwZl1iL2m5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5OFq0C97f5F5O5F5O5F5F5O5F5O5F5O5F5O5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5"></script>

</body>

</html>