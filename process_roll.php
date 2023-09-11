<?php
require_once('db_connection.php'); // Make sure this file includes your database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $jsonDataArray = [
        '{
            "package_id": "2",
            "price": "14",
            "zone": "netcue",
            "number": "15",
            "minutes": "120",
            "descr": "osa",
            "count": "120",
            "used": "AAAAAAA",
            "active": "",
            "lastsync": "1694156758"
        }',
        '{
            "package_id": "2",
            "price": "13",
            "zone": "netcue",
            "number": "16",
            "minutes": "120",
            "descr": "osa",
            "count": "120",
            "used": "AAAAAAA",
            "active": "",
            "lastsync": "1694156758"
        }'
    ];

    $insertedCount = 0; // Initialize the count of inserted records
    $updatedCount = 0; // Initialize the count of updated records

    foreach ($jsonDataArray as $jsonData) {
        $data = json_decode($jsonData, true);
        $package_id = $data['package_id'];
        $name = $data['number'];
        $price = $data['price'];
        $minutes = $data['minutes'];
        $description = $data['descr'];
        $count = $data['count'];
        $voucher_used = $data['used'];
        $active = $data['active'];
        $last_sync = $data['lastsync'];

        if (!filter_var($package_id, FILTER_VALIDATE_INT)) {
            echo "Id must be valid. ";
        } elseif (empty($name) || empty($price) || empty($minutes) || empty($description) || empty($voucher_used)) {
            echo "All fields are required.";
        } else {
            // Check if the record already exists
            $checkSql = "SELECT COUNT(*) FROM tb_roll WHERE external_roll_id = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("s", $data['number']);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count == 0) {
                // Record doesn't exist, so insert it
                $sql = "INSERT INTO tb_roll (external_roll_id, NAME, description, validity, price, voucher_used) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $data['number'], $data['number'], $data['descr'], $data['minutes'], $data['price'], $data['used']);
                if ($stmt->execute()) {
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
