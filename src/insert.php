<?php
require('db.php');

?>
<!DOCTYPE html>
<html>

<head>
  <title>PHP MySQL Insert Data</title>
</head>

<body>
  <p>
    <?php
    echo "Listing new house: " . $_POST["HouseAddress"] . " " . $_POST["AddressZipCode"] . "...";

    try {
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->beginTransaction();

      // Insert house 
      $sql = 'INSERT INTO House (HouseBuilt, HouseListed, HouseAddress, HouseRooms, HouseBedrooms, HouseBathrooms, HouseGarage, HouseDescription, HouseLotSize, HouseArea) ';
      $sql = $sql . 'VALUES ("' . $_POST["HouseBuilt"] . '", NOW(), "' . $_POST["HouseAddress"] . '",' . $_POST["HouseRooms"] . ',' . $_POST["HouseBedrooms"] . ',' . $_POST["HouseBathrooms"] . ',' . $_POST["HouseGarage"] . ',"' . $_POST["HouseDescription"] . '",' . $_POST["HouseLotSize"] . ',' . $_POST["HouseArea"] . ')';

      $pdo->exec($sql);

      $houseId = $pdo->lastInsertId();

      // Insert address 
      $sql = 'INSERT INTO Address (AddressStreet, AddressZipCode, AddressCity, AddressCountry, HouseId)';
      $sql = $sql . 'VALUES ("' . $_POST["AddressStreet"] . '","' . $_POST["AddressZipCode"] . '","' . $_POST["AddressCity"] . '","' . $_POST["AddressCountry"] . '",' . $houseId . ')';

      $pdo->exec($sql);

      // Insert features
      if (isset($_POST['Features'])) {
        $sql = 'INSERT INTO HouseFeature (FeatureId, HouseId) VALUES ';
        foreach ($_POST['Features'] as $feature) {
          $sql = $sql . '(' . $feature . ',' . $houseId . '),';
        }
        $sql = substr($sql, 0, strlen($sql) - 1);

        $pdo->exec($sql);
      }

      // Insert owner 
      $sql = 'INSERT INTO Owner (OwnerName, OwnerPhone, PersonId, HouseId) VALUES ';
      $sql = $sql . '("' . $_POST['OwnerName'] . '","' . $_POST['OwnerPhone'] . '",' . $_POST['PersonId'] . ',' . $houseId . ')';

      $pdo->exec($sql);

      $pdo->commit();

      echo "New record created successfully";
    ?>
  <p>You will be redirected in 3 seconds</p>
  <script>
    var timer = setTimeout(function () {
      window.location = 'start.php?page=<?php echo $_POST['page']; ?>'
    }, 3000);
  </script>
  <?php
    } catch (PDOException $e) {
      $pdo->rollBack();
      echo $sql . "<br>" . $e->getMessage();
    ?>
  <p>Rolling back changes. You will be redirected in 3 seconds</p>
  <!--script>
    var timer = setTimeout(function () {
      window.location = 'start.php'
    }, 3000);
  </script-->
  <?php
    }
    $pdo = null;
    ?>
  </p>
</body>
</div>

</html>