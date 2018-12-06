<?php
   include('./controllers/connection.php');
   include('./controllers/retrieve.php');

   if ( isset($_GET['id']) && isset($_GET['type']) ) {
      $id = $_GET['id'];
      $type = $_GET['type'];
      $tbl_name = ($type == 1) ? 'radcheck' : 'radreply';


      $qry = "SELECT * FROM $tbl_name WHERE id = '$id'";
      $result = $conn->query($qry);
      $row = $result->fetch_assoc();
      
   }
   else {
      echo "
         <h4>User not found</h4>
      ";
      die();
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Radius - User Account Management</title>
   <link rel="stylesheet" href="./assets/styles.css">
</head>
<body>
   <div class="main-container">
      <div class="update-container">
         <form action="./controllers/update.php?id=<?= $id; ?>&type=<?= $type; ?>" method="POST" autocomplete="off">
            <table>
               <tr>
                  <td>Username</td>
                  <td><input type="text" name="username" placeholder="Enter username" value="<?= $row['username']; ?>" required></td>
               </tr>
               <tr>
                  <td id="small-td">Previous Attribute</td>
                  <td id="small-td"><b><?= $row['attribute']; ?></b></td>
               </tr>
               <tr id="small-tr">
                  <td id="small-td">Previous Value</td>
                  <td id="small-td"><b><?= $row['value']; ?></b></td>
               </tr>
               <tr>
                  <td>Attribute</td>
                  <td>
                     <select name="selectAttr" id="selectAttr" required>
                        <?php foreach($attributes as $attribute => $val): ?>
                           <option value=<?= $attribute; ?>><?= $val; ?></option>
                        <?php endforeach; ?>
                     </select>
                  </td>
               </tr>
               <tr>
                  <td>Operator</td>
                  <td>
                     <input type="text" name="operator" id="operator" value="<?= $row['op']; ?>" readonly>
                  </td>
               </tr>
               <tr>
                  <td>Value</td>
                  <td id="valueContainer">
                     <input type="text" name="value" id="value" placeholder="Enter password" required>
                  </td>
               </tr>
               <tr align="center">
                  <td colspan="2">
                     <input type="submit" name="update" value="Update">
                     <a href="./">Cancel</a>
                  </td>
               </tr>
            </table>
         </form>
      </div>
   </div>
   <script src="./assets/scripts.js"></script>
</body>
</html>