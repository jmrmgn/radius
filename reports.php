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
   <link rel="stylesheet" href="./assets/styles.css">
   <link rel="stylesheet" href="./assets/reports.css">
   <title>Radius - User Account Management</title>
</head>
<body>
   <?php include('layout/navbar.php'); ?>

   <div class="search-container">
      <form method="GET">
         <input type="text" name="q" value="<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>" placeholder="Search username">
         <button>Search</button>
      </form>
      <br>
      <br>
      <?php if($result->num_rows > 0): ?>
         <form method="POST" action="./controllers/export_to_csv.php<?php if(isset($_GET['q'])) { echo '?q='.$_GET["q"].''; } ?>">
            <button type="submit" name="export">CSV Export</button>
         </form>
      <?php endif; ?>
   </div>
   <?php if($result->num_rows > 0): ?>
      <form method="POST" action="./controllers/delete_record.php<?php if(isset($_GET['q'])) { echo '?q='.$_GET["q"].''; } ?>">
         <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete?')">Delete record</button>
      </form>
   <?php endif; ?>
   <div class="reports-table">
      <table cellpadding="2" border="1">
         <thead>
            <th>ID</th>
            <!-- <th>HotSpot</th> -->
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
                  <?php if(isset($_GET['q'])): ?>
                     <td colspan="10" style="text-align: center;">No reports user '<em><?= $_GET['q']; ?></em>'<td>
                  <?php else: ?>
                     <td colspan="11" style="text-align: center;">No reports yet...</td>
                  <?php endif; ?>
               </tr>
            <?php endif; ?>
         </tbody>
      </table>
   </div>
   
   <div class="container">
      <?= load_pagination(); ?>
   </div>

   <script src="./assets/scripts.js"></script>
</body>
</html>