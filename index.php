<?php
   include('./controllers/connection.php');
   include('./controllers/retrieve.php');
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
      <div class="insert-container">
         <form action="controllers/insert.php" method="POST" autocomplete="off">
            <table>
               <tr>
                  <td>Username</td>
                  <td><input type="text" name="username" placeholder="Enter username" required></td>
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
                     <input type="text" name="operator" id="operator" value=":=" readonly>
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
                     <input type="submit" value="Insert">
                  </td>
               </tr>
            </table>
         </form>
      </div>

      <div class="retrieve-container">
         <div class="search-container">
            <input type="text" placeholder="Search here...">
         </div>
         <table>
            <thead>
               <th>ID</th>
               <th>Username</th>
               <th>Attribute</th>
               <th>Operator</th>
               <th>Value</th>
               <th>Action</th>
            </thead>
            <tbody>
               <?php if($result->num_rows > 0): ?>
                  <?php while( $row = $result->fetch_assoc() ): ?>
                     <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['attribute']; ?></td>
                        <td><?= $row['op']; ?></td>
                        <td><?= $row['value']; ?></td>
                        <td>
                           <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>
                           <a href="delete.php?id=<?= $row['id']; ?>">Delete</a>
                        </td>
                     </tr>
                  <?php endwhile; ?>
               <?php else: ?>
                  <tr>
                     <td colspan="6" style="text-align: center;">No user found...</td>
                  </tr>
               <?php endif; ?>
            </tbody>
         </table>
      </div>
   </div>
   <script src="./assets/scripts.js"></script>
</body>
</html>