<?php  
   include('connection.php');

   if(isset($_POST["export"])) {

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

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('ID', 'HotSpot', 'Username', 'IP Address', 'Start time', 'Stop time', 'Total Time (seconds)', 'Upload', 'Download', 'Termination', 'NAS IP Address')); 
      $query = "SELECT radacctid, nasporttype, username, framedipaddress, acctstarttime, acctstoptime, TIMESTAMPDIFF(SECOND, acctstarttime, acctstoptime), acctinputoctets, acctoutputoctets, acctterminatecause, nasipaddress from radacct $join ORDER BY radacctid ASC";  
      $result = mysqli_query($conn, $query);  
      while($row = mysqli_fetch_assoc($result)) {  
         fputcsv($output, $row);  
      }  

      fclose($output);  
   } 