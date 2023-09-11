<?php
require_once('db_connection.php'); // Make sure this file includes your database connection code



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $jsonDataArray = [
        '{
        "zone": "netcue",
        "descr": "Sample Description",
        "localauth_priv": "",
        "zoneid": "19",
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
        "bwdefaultup": "2000"
    }',
        '{ "zone": "netcue",
        "descr": "Sample Description",
        "localauth_priv": "",
        "zoneid": "21",
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
        "bwdefaultup": "2000"
    }'

    ];

    $insertedCount = 0; // Initialize the count of inserted records
    $updatedCount = 0; // Initialize the count of updated records

    foreach ($jsonDataArray as $jsonData) {
        $data = json_decode($jsonData, true);
        $zone_id = $data['zoneid'];
        $Name = $data['zone'];
        $description = $data['descr'];
        $traffic_quota = $data['trafficquota'];
        $terms = $data['termsconditions'];
        $default_down = $data['bwdefaultdn'];
        $default_up = $data['bwdefaultup'];

        if (!filter_var($zone_id, FILTER_VALIDATE_INT)) {
            echo "Id must be valid. ";
        } elseif (empty($zone_id) || empty($Name) || empty($description) || empty($traffic_quota) || empty($terms) || empty($default_down) || empty($default_up)) {
            echo "All fields are required.";
        } else {
            // Check if the record already exists
            $checkSql = "SELECT COUNT(*) FROM tb_package WHERE external_package_id = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("s", $data['zoneid']);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count == 0) {
                // Record doesn't exist, so insert it
                $sql = "INSERT INTO tb_package (external_package_id, NAME, description, bwdefaultdn, bwdefaultup, termsconditions, trafficquota) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssss", $data['zoneid'], $data['zone'], $data['descr'], $data['bwdefaultdn'], $data['bwdefaultup'], $data['termsconditions'], $data['trafficquota']);
                if ($stmt->execute()) {
                    // Insert/update successful
              // Insert successful
              $insertedCount++; // Increment the inserted count
            } else {
                // Insert failed
                echo "Error inserting record: " . $stmt->error;
            }
        } else {
            // Record exists, so update it
                $updatedCount++; // Increment the updated count
            } 
        }
    }


if ($insertedCount > 0 && $updatedCount > 0) {
    // Records were both inserted and updated
    echo "Records inserted and updated successfully. Inserted: $insertedCount, Updated: $updatedCount";
} elseif ($insertedCount > 0) {
    // Only records were inserted
    echo "Records inserted successfully. Total records inserted: $insertedCount";
} elseif ($updatedCount > 0) {
    // Only records were updated
    echo "Record already exists.";
} else {
    // No records were inserted or updated
    echo "No records were inserted or updated.";
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