<?php
   include('./controllers/connection.php');
   include('./controllers/fetch_reports.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Radius - User Account Management</title>
   <style>

      .pagination {
         display: inline-block;
         width: 100%;
         list-style-type: none;
      }

      .pagination a {
         color: black;
         float: left;
         padding: 8px 16px;
         text-decoration: none;
         transition: background-color .3s;
         border: 1px solid #ddd;
      }

      .pagination a.active {
         background-color: #4CAF50;
         color: white;
         border: 1px solid #4CAF50;
      }

      .pagination a:hover:not(.active) {background-color: #ddd;}

      table, th, td {
         font-size: 13px;
         border: 1px solid black;
         border-collapse: collapse;
      }

      table {
         width: 100%;
      }

   </style>
</head>
<body>
   <?php include('layout/navbar.php'); ?>
   <table cellpadding="2" border="1">
      <thead>
         <th>ID</th>
         <th>HotSpot</th>
         <th>Username</th>
         <th>IP Address</th>
         <th>Start time</th>
         <th>Stop time</th>
         <th>Total time</th>
         <th>Upload (Bytes)</th>
         <th>Download (Bytes)</th>
         <th>Termination</th>
         <th>NAS IP Address</th>
      </thead>
      <tbody>
         <?php 
            while($row = mysqli_fetch_array($result)){
               echo "
                  <tr>
                     <td>".$row['radacctid']."</td>
                     <td></td>
                     <td>".$row['username']."</td>
                     <td>".$row['framedipaddress']."</td>
                     <td>".$row['acctstarttime']."</td>
                     <td>".$row['acctstoptime']."</td>
                     <td>".get_total_datetime($row['acctstarttime'], $row['acctstoptime'])."</td>
                     <td>".formatBytes($row['acctinputoctets'])."</td>
                     <td>".formatBytes($row['acctoutputoctets'])."</td>
                     <td>".$row['acctterminatecause'] ."</td>
                     <td>".$row['nasipaddress'] ."</td>
                  </tr>
               ";
            }
         ?>
         <?php if($result->num_rows > 0): ?>
            <?php while( $row = $result->fetch_assoc() ): ?>
               <tr>
                  <td><?= $row['radacctid']; ?></td>
                  <td></td>
                  <td><?= $row['username']; ?></td>
                  <td><?= $row['framedipaddress']; ?></td>
                  <td><?= $row['acctstarttime']; ?></td>
                  <td><?= $row['acctstoptime']; ?></td>
                  <td><?= get_total_datetime($row['acctstarttime'], $row['acctstoptime']); ?></td>
                  <td><?= formatBytes($row['acctinputoctets']); ?></td>
                  <td><?= formatBytes($row['acctoutputoctets']); ?></td>
                  <td><?= $row['acctterminatecause']; ?></td>
                  <td><?= $row['nasipaddress']; ?></td>
               </tr>
            <?php endwhile; ?>
         <?php else: ?>
            <tr>
               <td colspan="11" style="text-align: center;">No reports yet...</td>
            </tr>
         <?php endif; ?>
      </tbody>
   </table>
   
   <div class="container">
      <!-- PAGINATION -->
      <ul class="pagination">
         <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
         
         <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
         <a <?php if($page_no > 1){ echo "href='?page=$previous_page'"; } ?>>Prev</a>
         </li>
            
         <?php 
            if ($total_no_of_pages <= 10){  	 
               for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  if ($counter == $page_no) {
                     echo "<li><a class='active'>$counter</a></li>";	
                  }
                  else {
                     echo "<li><a href='?page=$counter'>$counter</a></li>";
                  }
               }
            }
            else if ($total_no_of_pages > 10) {
               if($page_no <= 4) {	
                  for ($counter = 1; $counter < 8; $counter++) {	 
                     if ($counter == $page_no) {
                        echo "<li><a class='active'>$counter</a></li>";	
                     }
                     else {
                        echo "<li><a href='?page=$counter'>$counter</a></li>";
                     }
                  }
                  echo "<li><a>...</a></li>";
                  echo "<li><a href='?page=$second_last'>$second_last</a></li>";
                  echo "<li><a href='?page=$total_no_of_pages'>$total_no_of_pages</a></li>";
               }
            else if ($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
               echo "<li><a href='?page=1'>1</a></li>";
               echo "<li><a href='?page=2'>2</a></li>";
               echo "<li><a>...</a></li>";
               for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
                  if ($counter == $page_no) {
                     echo "<li><a class='active'>$counter</a></li>";
                  } else {
                     echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                  }                  
               }
               echo "<li><a>...</a></li>";
               echo "<li><a href='?page=$second_last'>$second_last</a></li>";
               echo "<li><a href='?page=$total_no_of_pages'>$total_no_of_pages</a></li>";      
            }
            else {
               echo "<li><a href='?page=1'>1</a></li>";
               echo "<li><a href='?page=2'>2</a></li>";
               echo "<li><a>...</a></li>";

               for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                  if ($counter == $page_no) {
                     echo "<li><a class='active'>$counter</a></li>";	
                  }
                  else {
                     echo "<li><a href='?page=$counter'>$counter</a></li>";
                  }        
               }
            }
         }
      ?>
         
         <li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
            <a <?php if($page_no < $total_no_of_pages) { echo "href='?page=$next_page'"; } ?>>Next</a>
         </li>
         <?php 
            if ($page_no < $total_no_of_pages) {
               echo "<li><a href='?page=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
            }
         ?>
      </ul>
   </div>
   <!-- END OF PAGINATION -->
   <script src="./assets/scripts.js"></script>
</body>
</html>