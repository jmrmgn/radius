<?php
   include('connection.php');

   $qry = " SELECT * FROM radcheck
            UNION
            SELECT * FROM radreply";
   $result = $conn->query($qry);
