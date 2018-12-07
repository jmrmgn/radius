<?php
   include('connection.php');
   
   $selectedAttr = $_POST['selectAttr'];

   $username = $_POST['username'];
   $attribute = $attributes[$selectedAttr];
   $op = $_POST['operator'];

   $tbl_name = "radcheck";

   switch ($selectedAttr) {
      case '1': // as is value
         $value = $_POST['value'];
         break;
      
      case '2': // convert input into seconds
         $value = ( $_POST['value'] * 60 ) * 60;
         break;

      case '3':
         $from = str_replace(":", "", $_POST['value_from']);
         $to = str_replace(":", "", $_POST['value_to']);
         $value = "Al" . $from . "-" . $to;
         break;

      case '4':
         $value = $_POST['value'];
         break;

      case '5':
         $value_date = date("F d Y", strtotime($_POST['value_date']));
         $value = $value_date . " " . $_POST['value_time'];
         break;

      case '6':
         $value = $_POST['value'];
         break;
         
      case '7':
         $value = ( $_POST['value'] * 60 ) * 60;
         $tbl_name = "radreply";
         break;

      case '8':
         $value = ( $_POST['value'] * 60 ) * 60;
         $tbl_name = "radreply";
         break;
   }

   $qry = "INSERT INTO $tbl_name(username, attribute, op, value) VALUES('$username', '$attribute', '$op', '$value')";

   if ( $conn->query($qry) === TRUE ) {
      echo "
         <script>
            alert('Successfully added.');
            setTimeout(function() {
               window.location = '../index.php?prevUser=" . $username . "';
            });
         </script>
      ";
   }
   else {
      echo "Error occured in: " . $conn->error;
   }

   $conn->close();
