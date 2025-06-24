<?php
include 'db.php';
 $sql = "SELECT latitude, longitude FROM locations ORDER BY id ASC LIMIT 1";
  $result = $conn->query($sql); $data = array();
   if ($result->num_rows > 0) {
     $data = $result->fetch_assoc();
    }
echo json_encode($data);
?>