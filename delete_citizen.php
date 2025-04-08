<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM citizens WHERE id=$id");

    echo "<script>
            alert('Citizen deleted successfully!');
            window.location.href='manage_citizen.php';
          </script>";
}

$conn->close();
?>
