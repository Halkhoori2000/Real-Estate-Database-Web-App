<?php
require('db.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>PHP MySQL Delete Data</title>
</head>

<body>
  <p>
    <?php

      try {
        echo "Deleting house: " . $_POST["HouseId"] . "...";
        $sql = 'DELETE FROM House WHERE HouseId = "' . $_POST["HouseId"] . '"';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec($sql);
        echo "House deleted successfully";
      ?>
  <p>You will be redirected in 3 seconds</p>
  <script>
    var timer = setTimeout(function () {
      window.location = 'start.php?page=<?php echo $_POST['page']; ?>'
    }, 3000);
  </script>
  <?php
      } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
      $pdo = null;
      ?>
  </p>
</body>
</div>

</html>