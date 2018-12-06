<?php

   include('./connection.php');

   $txtSearch = mysqli_real_escape_string($conn, $_POST['txtSearch']);

   $qry = "SELECT * FROM `radcheck`
            WHERE username LIKE '%$txtSearch%'
            UNION
            SELECT * FROM `radreply`
            WHERE username LIKE '%$txtSearch%'";

   $result = $conn->query($qry);

   $resultSet = [];

   while ( $row = $result->fetch_assoc() ) {
      $resultSet[] = $row;
   }
   
   echo json_encode($resultSet);