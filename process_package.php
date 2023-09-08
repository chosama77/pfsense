<?php
require_once('db_connection.php'); // Make sure this file includes your database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $jsonData = '{ "zone": "netcue",
        "descr": "Sample Description",
        "localauth_priv": "",
        "zoneid": "3",
        "interface": "lan",
        "maxproc": "",
        "timeout": "",
        "idletimeout": "",
        "trafficquota": "1000",
        "freelogins_count": "",
        "freelogins_resettimeout": "",
        "enable": "",
        "auth_method": "authserver",
        "auth_server": "Local Auth - Local Database",
        "auth_server2": "",
        "radacct_server": "",
        "reauthenticateacct": "",
        "httpsname": "",
        "preauthurl": "",
        "blockedmacsurl": "",
        "certref": "64f5ce10e6617",
        "redirurl": "",
        "radmac_format": "default",
        "radiusnasid": "",
        "termsconditions": "VGVybXMgYW5kIENvbmRpdGlvbnM=",
        "page": "",
        "peruserbw": "",
        "bwdefaultdn": "2000",
        "bwdefaultup": "1000"
    }';

    $data = json_decode($jsonData, true);
    $zone_id = $data['zoneid'];
    $Name = $data['zone'];
    $description = $data['descr'];
    $trffic_quota = $data['trafficquota'];
    $terms = $data['termsconditions'];
    $default_down = $data['bwdefaultdn'];
    $default_up = $data['bwdefaultup'];

    if(!filter_var($zone_id, FILTER_VALIDATE_INT)){
        echo "Id must be valid.";
    }

    elseif(empty($zone_id) || empty($Name) ||  empty($description) || empty($trffic_quota) || empty($terms) || empty($default_down) || empty($default_up)){
        echo "All fields are required.";
    }

    else{

    // Check if the record already exists
    $checkSql = "SELECT COUNT(*) FROM tb_package WHERE external_package_id = ? AND NAME = ? AND description = ? AND trafficquota = ? AND bwdefaultdn = ? AND bwdefaultup = ? AND termsconditions = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("sssssss", $data['zoneid'], $data['zone'], $data['descr'], $data['trafficquota'], $data['bwdefaultdn'], $data['bwdefaultup'], $data['termsconditions']);
    $checkStmt->execute();
    
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();
    
    if ($count == 0) {
        // Record doesn't exist, so insert it
        $sql = "INSERT IGNORE INTO tb_package (external_package_id, NAME, description, bwdefaultdn, bwdefaultup, termsconditions, trafficquota) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $data['zoneid'], $data['zone'], $data['descr'], $data['bwdefaultdn'], $data['bwdefaultup'], $data['termsconditions'], $data['trafficquota']);
    
        if ($stmt->execute()) {
            // Insert successful
            echo "Record inserted successfully.";
        } else {
            // Insert failed
            echo "Error inserting record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Record already exists
        echo "Record already exists.";
    }
}
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
</head>
<body>
    <form method="post" action="">
        <button type="submit" name="submit">Insert Data</button>
    </form>
</body>
</html>
