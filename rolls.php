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
                          "used": "5",
                          "active": "",
                          "lastsync": "1694156834"
                      },
                      {
                          "zone": "netcue",
                          "number": "2",
                          "minutes": "240",
                          "descr": "Comment 2",
                          "count": "200",
                          "used": "5",
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
        <h4>Rolls</h4>
      </div>
    </div>
  </div>

  <div class="container mb-5">
    <div class="container table-responsive my-3">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Roll Number</th>
            <th>Roll Minutes</th>
            <th>Roll Description</th>
            <th>Roll Count</th>
            <th>Roll Used</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($_GET['zone'])) {
            $zone = $_GET['zone'];

            $ch = curl_init();
            $url = "https://182.191.81.171:8443/api/roll.php?zone=netcue";
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
              // echo $e; 
          ?>
              <h3 style="text-align: center;"><?php echo $e; ?><div class='emoji'>😞</div>
                <?php   } else {
                $decoded = json_decode($resp);
                // print_r($decoded);
              }
              $zone_data = false;
              // Find the data for the selected zone
              if (isset($_GET['zone'])) {
                $zone = $_GET['zone']; 
                // Check if the 'data' key exists in the decoded JSON
                if (isset($decoded->data)) {
                  $jsonDataArray = $decoded->data;

                  foreach ($jsonDataArray as $entry) {
                    if (isset($entry->zone) && $entry->zone === $zone) {
                      // Check if the required properties exist in the object
                      if (isset($entry->number, $entry->minutes, $entry->descr, $entry->count, $entry->used)) {
                        echo '<tr class="clickable-row" onclick="window.location=\'vouchers.php?number=' . $entry->number . '\'">';
                        echo '<td>' . $entry->number . '</td>';
                        echo '<td>' . $entry->minutes . '</td>';
                        echo '<td>' . $entry->descr . '</td>';
                        echo '<td>' . $entry->count . '</td>';
                        echo '<td>' . $entry->used . '</td>';
                        echo '<td><button class="btn btn-primary">edit</button> <button class="btn btn-danger">delete</button></td>';
                        echo '</tr>';
                      }
                    } else {
                      $zone_data = true;
                    }
                  }
                  if ($zone_data == true) {
                ?>
                    <h3 style="text-align: center;"><?php echo "No data available for this zone."; ?><div class='emoji'>😞</div>
                    </h3>
                  <?php
                  }
                } else { ?>
                  <h3 style="text-align: center;"><?php echo "No data available."; ?><div class='emoji'>😞</div>
                  </h3>
            <?php }
              }
            }
            ?>
        </tbody>
      </table>

    </div>
    <div class="container p-0" style="display: flex; justify-content: end;">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add <i class="fa fa-plus"></i></button>
    </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a roll</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form_add_roll">
          <div class="modal-body">
            <!-- Add your modal content here -->
            <input type="hidden" name="txt_zone" id="txt_zone" value="<?php echo $zone; ?>">
            <div class="m-2">
              <label for="">Number</label>
              <input class="form-control" name="txt_number" type="text">
            </div>
            <div class="m-2">
              <label for="">Validity</label>
              <input class="form-control" name="txt_validity" type="text">
            </div>
            <div class="m-2">
              <label for="">Count</label>
              <input class="form-control" name="txt_count" type="text">
            </div>
            <div class="m-2">
              <label for="">Description</label>
              <textarea class="form-control" name="txt_description" id="" cols="30" rows="5"></textarea>
              <!-- <input  class="form-control" type="text"> -->
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="btn_add_roll" data-bs-dismiss="modal">Add</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <!-- Add any additional buttons here -->
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
 $(document).ready(function () {
    $('#form_add_roll').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Serialize the form data
        var formData = $(this).serialize();


console.log('yea');
        $.ajax({
            url: 'add_roll.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log(response);
            },
            error: function () {
                alert('An error occurred while inserting data.');
            }
        });
    });
});

</script>


</body>

</html>