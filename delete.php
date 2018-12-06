<?php
   include('./controllers/connection.php');

   $id = $_GET['id'];
   $type = $_GET['type'];

   if ( isset($_GET['id']) && isset($_GET['type']) ) {
      $tbl = ($type == 1) ? "radcheck" : "radreply";

      $qry = "DELETE FROM $tbl WHERE id = '$id'";

      if ( $conn->query($qry) === TRUE ) {
         echo "
            <script>
               alert('Deleted succcessfully.');
               setTimeout(function() {
                  window.location = './index.php';
               });
            </script>
         ";
      }
      else {
         echo "Error occured in: " . $conn->error;
      }
   }
