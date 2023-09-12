<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
  .clickable-row:hover {
    cursor: pointer !important;
  }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid px-5">
    <a class="navbar-brand" href="#">Pfsense</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
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

<div class="container my-3">
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

    $rowNumber = 1;

    foreach ($jsonDataArray as $json) {
      $data = json_decode($json, true);

      if ($data !== null) {
        foreach ($data['data'] as $entry) {
          echo "<tr class='clickable-row' onclick=\"window.location='roles.php?zone={$entry['zone']}'\">";
          echo "<th scope='row'>$rowNumber</th>";
          echo "<td>{$entry['zone']}</td>";
          echo "<td>{$entry['interface']}</td>";
          echo "<td>{$entry['roll'][0]['count']}</td>";
          echo "<td>{$entry['descr']}</td>";
          echo "<td><a class='btn btn-primary' href='osam.php'><i class='fa-solid fa-pencil'></i></a></td>";
          echo "</tr>";
      
          $rowNumber++;
        }
      } else {
        echo "<tr><td colspan='6'>Error decoding JSON data.</td></tr>";
      }
      
    }
    ?>
  </tbody>
</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kmU1w7U5zg2tc3t6o5z5nxFt3B0F5R5r5C3f0N7Ktx7TwZl1iL2m5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5O5F5OFq0C97f5F5O5F5O5F5F5O5F5O5F5O5F5O5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5F5O5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5O5F5F5

</body>
</html>
