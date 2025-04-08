<?php
include 'db.php'; // Make sure this connects to your DB

$filename = 'pre_approved_citizens.csv'; // CSV must be in the same folder

if (!file_exists($filename)) {
    die("CSV file not found.");
}

$file = fopen($filename, 'r');

// Skip header row
fgetcsv($file);

while (($row = fgetcsv($file)) !== FALSE) {
    $name = $row[0];
    $mobile_no = $row[1];
    $aadhar_no = $row[2];
    $dob = $row[3];
    $gender = $row[4];

    // Check if citizen already exists
    $check = $conn->prepare("SELECT * FROM pre_approved_citizens WHERE aadhar_no = ? OR mobile_no = ?");
    $check->bind_param("ss", $aadhar_no, $mobile_no);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO pre_approved_citizens (name, mobile_no, aadhar_no, dob, gender) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $mobile_no, $aadhar_no, $dob, $gender);
        $stmt->execute();
    }
}
fclose($file);

echo "Data import completed successfully.";
?>
