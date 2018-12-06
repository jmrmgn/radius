<?php
   include('connection.php');

   $qry = " SELECT * FROM radcheck";
   $result = $conn->query($qry);

   $conn->close();