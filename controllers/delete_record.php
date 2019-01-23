<?php  
   include('connection.php');

   if(isset($_POST["delete"])) {

      if (isset($_GET['q'])) {
         $q = $_GET['q'];
   
         if (empty($q)) {
            $join = '';
         }
         else {
            $join = "WHERE username='$q'";
         }
      }
      else {
         $join = '';
      }

      $query = "DELETE FROM radacct $join";  
      if ($conn->query($query) === TRUE) {
         echo "
            <script>
               alert('Record successfully deleted');
               window.location.href = '../reports.php';
            </script>
         ";
      }
      else {
         echo "
            <script>
               alert('Error occured while deleting the record: $conn->error');
            </script>
         ";
      }
      
   }