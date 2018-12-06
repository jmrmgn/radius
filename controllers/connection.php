<?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $db_name = "radiusdb";

   $conn = new mysqli($servername, $username, $password, $db_name);

   if ( $conn->connect_error ) {
      die("Connection failed: " . $conn->connect_error());
   }
   

   // Attr array
   $attributes = [
      "1" => "Clear-text-Password",
      "2" => "Max-Daily-Season",
      "3" => "Login-Time",
      "4" => "Simultaneous-Use",
      "5" => "Expiration",
      "6" => "Auth-Type",
      "7" => "Idle-Timeout",
      "8" => "Session-Timeout"
   ];

   