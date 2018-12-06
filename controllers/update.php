<?php
   include('connection.php');

   $id = $_GET['id'];
   $type = $_GET['type'];
   
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
         $value_date = date("F m Y", strtotime($_POST['value_date']));
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

   $tbl = ($type == 1) ? "radcheck" : "radreply" ;
   // DELETE FIRST
   $qry = "DELETE FROM $tbl WHERE id = '$id'";
   
   if ( $conn->query($qry) === TRUE ) {
      // INSERT AGAIN
      $qry = "INSERT INTO $tbl_name(username, attribute, op, value) VALUES('$username', '$attribute', '$op', '$value')";

      if ( $conn->query($qry) === TRUE ) {
         echo "
            <script>
               alert('Updated succcessfully.');
               setTimeout(function() {
                  window.location = '../index.php';
               });
            </script>
         ";
      }
      else {
         echo "Error occured in: " . $conn->error;
      }
   }
   else {
      echo "
            <script>
               alert('Something went wrong.');
               setTimeout(function() {
                  window.location = '../index.php';
               });
            </script>
         ";
   }

   $conn->close();

   // $qry = "UPDATE $tbl_name SET username='$username', attribute='$attribute', op='$op', value='$value' WHERE id = '$id'";
