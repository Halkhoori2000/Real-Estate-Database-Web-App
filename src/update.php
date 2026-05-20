<?php
require('db.php');

try {
  // Update here 
  if (isset($_POST['HouseId'])) {
    try {
      // Begin a transaction for rollback 
      $pdo->beginTransaction();

      // Update the house 
      $sql = 'UPDATE House SET ';
      $sql = $sql . 'HouseBuilt = "' . $_POST['HouseBuilt'] . '", ';
      $sql = $sql . 'HouseAddress = "' . $_POST['HouseAddress'] . '", ';
      $sql = $sql . 'HouseRooms = ' . $_POST['HouseRooms'] . ', ';
      $sql = $sql . 'HouseBedrooms = ' . $_POST['HouseBedrooms'] . ', ';
      $sql = $sql . 'HouseBathrooms = ' . $_POST['HouseBathrooms'] . ', ';
      $sql = $sql . 'HouseGarage = ' . $_POST['HouseGarage'] . ', ';
      $sql = $sql . 'HouseDescription = "' . $_POST['HouseDescription'] . '", ';
      $sql = $sql . 'HouseLotSize = ' . $_POST['HouseLotSize'] . ', ';
      $sql = $sql . 'HouseArea = ' . $_POST['HouseArea'] . ' ';
      $sql = $sql . 'WHERE HouseId = ' . $_POST['HouseId'];

      $pdo->exec($sql);

      // Update the address
      $sql = 'UPDATE Address SET ';
      $sql = $sql . 'AddressStreet = "' . $_POST['AddressStreet'] . '", ';
      $sql = $sql . 'AddressZipCode = ' . $_POST['AddressZipCode'] . ', ';
      $sql = $sql . 'AddressCity = "' . $_POST['AddressCity'] . '", ';
      $sql = $sql . 'AddressCountry = "' . $_POST['AddressCountry'] . '", ';
      $sql = $sql . 'WHERE HouseId = ' . $_POST['HouseId'];

      $pdo->exec($sql);

      // Delete the existing features
      $sql = 'DELETE FROM HouseFeature WHERE HouseId = "' . $_POST['HouseId'] . '"';

      $pdo->exec($sql);

      // Update the features
      if (isset($_POST['Features'])) {
        $sql = 'INSERT INTO HouseFeature(HouseId, FeatureId) VALUES ';
        foreach ($_POST['Features'] as $featureId) {
          $sql = $sql . '(' . $_POST['HouseId'] . ',' . $featureId . '),';
        }
        $sql = substr($sql, 0, strlen($sql) - 1);

        $pdo->exec($sql);
      }

      // Update the owner 
      $sql = 'UPDATE Owner SET ';
      $sql = $sql . 'OwnerName = "' . $_POST['OwnerName'] . '", ';
      $sql = $sql . 'AddressZipCode = ' . $_POST['AddressZipCode'] . ', ';
      $sql = $sql . 'OwnerPhone = "' . $_POST['OwnerPhone'] . '" ';
      $sql = $sql . 'WHERE OwnerId = ' . $_POST['OwnerId'];

      $pdo->exec($sql);

      // Commit the changes
      $pdo->commit();

      echo 'House updated!';
    } catch (Exception $e) {
      echo "Failed to update house info: " . $e->getMessage() . ". Rolling back changes.";
      $pdo->rollBack();
    }
  }

  $page = isset($_GET['page']) ? $_GET['page'] : 0;

  $sql = 'SELECT 
  h.HouseId, 
  h.HouseBuilt,
  h.HouseListed,
  h.HouseAddress,
  a.AddressStreet,
  a.AddressZipCode,
  a.AddressCity, 
  a.AddressCountry,
  h.HouseRooms,
  h.HouseBedrooms,
  h.HouseBathrooms,
  h.HouseGarage,
  h.HouseDescription,
  h.HouseLotSize,
  h.HouseArea,
  hf.HousePrice,
  hf.DatePosted,
  o.OwnerName,
  o.OwnerPhone,
  o.PersonId,
  o.OwnerId
FROM House h
LEFT JOIN Address a ON h.HouseId = a.HouseId
LEFT JOIN HouseForSale hf ON hf.HouseId = h.HouseId
LEFT JOIN Owner o ON o.HouseId = h.HouseId
WHERE h.HouseId = "' . $_GET['HouseId'] . '"
;';
  $q = $pdo->query($sql);
  $q->setFetchMode(PDO::FETCH_ASSOC);
  $house = $q->fetch();
} catch (PDOException $e) {
  die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>PHP MySQL Update Data</title>
</head>

<body>
  <div id="container">
    <a href="./start.php?page=<?php echo $page; ?>">&lt; Back</a>
    <h2>Update an existing house:</h2>
    <form action="./update.php?HouseId=<?php echo $_GET['HouseId']; ?>&page=<?php echo $page; ?>" method="post">
      <input type="hidden" name="HouseId" value="<?php echo $house['HouseId']; ?>" />
      <input type="hidden" name="OwnerId" value="<?php echo $house['OwnerId']; ?>" />
      <table>
        <tr>
          <td>Built:</td>
          <td><input required type="date" id="HouseBuilt" name="HouseBuilt" value="<?php echo $house['HouseBuilt']; ?>">
          </td>
        </tr>
        <tr>
          <td>Address:</td>
          <td><input required type="text" id="HouseAddress" name="HouseAddress"
              value="<?php echo $house['HouseAddress']; ?>"></td>
        </tr>
        <tr>
          <td>Street:</td>
          <td><input required type="text" id="AddressStreet" name="AddressStreet"
              value="<?php echo $house['AddressStreet']; ?>"></td>
        </tr>
        <tr>
          <td>ZipCode:</td>
          <td><input required type="number" id="AddressZipCode" name="AddressZipCode"
              value="<?php echo $house['AddressZipCode']; ?>"></td>
        </tr>
        <tr>
          <td>City:</td>
          <td><input required type="text" id="AddressCity" name="AddressCity"
              value="<?php echo $house['AddressCity']; ?>"></td>
        </tr>
        <tr>
          <td>Country:</td>
          <td><input required type="text" id="AddressCountry" name="AddressCountry"
              value="<?php echo $house['AddressCountry']; ?>"></td>
        </tr>
        <tr>
          <td>Rooms:</td>
          <td><input required min="0" type="number" id="HouseRooms" name="HouseRooms"
              value="<?php echo $house['HouseRooms']; ?>"></td>
        </tr>
        <tr>
          <td>Bedrooms:</td>
          <td><input required min="0" type="number" id="HouseBedrooms" name="HouseBedrooms"
              value="<?php echo $house['HouseBedrooms']; ?>"></td>
        </tr>
        <tr>
          <td>Bathrooms:</td>
          <td><input required min="0" type="number" id="HouseBathrooms" name="HouseBathrooms"
              value="<?php echo $house['HouseBathrooms']; ?>"></td>
        </tr>
        <tr>
          <td>Garage:</td>
          <td><input required min="0" type="number" id="HouseGarage" name="HouseGarage"
              value="<?php echo $house['HouseGarage']; ?>"></td>
        </tr>
        <tr>
          <td>Description:</td>
          <td><textarea required id="HouseDescription"
              name="HouseDescription"><?php echo $house['HouseDescription']; ?></textarea></td>
        </tr>
        <tr>
          <td>LotSize:</td>
          <td><input required min="0" type="number" id="HouseLotSize" name="HouseLotSize"
              value="<?php echo $house['HouseLotSize']; ?>"></td>
        </tr>
        <tr>
          <td>Area:</td>
          <td><input required min="0" type="number" id="HouseArea" name="HouseArea"
              value="<?php echo $house['HouseArea']; ?>"></td>
        </tr>
        <tr>
          <td>Owner Name:</td>
          <td><input required type="text" id="OwnerName" name="OwnerName" value="<?php echo $house['OwnerName']; ?>">
          </td>
        </tr>
        <tr>
          <td>Owner Phone:</td>
          <td><input required type="text" id="OwnerPhone" name="OwnerPhone" value="<?php echo $house['OwnerPhone']; ?>">
          </td>
        </tr>
        <tr>
          <td>Owner:</td>
          <td>
            <select required id="PersonId" name="PersonId">
              <option></option>
              <?php
              $sql = "SELECT * FROM Person;";
              $q = $pdo->query($sql);
              $q->setFetchMode(PDO::FETCH_ASSOC);

              while ($row = $q->fetch()):
              ?>
              <option value="<?php echo $row['PersonId']; ?>" <?php if ($row['PersonId']==$house['PersonId']): ?>
                selected
                <?php endif; ?>>
                <?php echo $row['Username']; ?>
              </option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
      </table>
      <table>
        <tr>
          <th>Feature Category</th>
          <th>Description</th>
          <th>Add?</th>
        </tr>
        <?php
        $sql = 'SELECT 
      f.FeatureId, 
      fc.FeatureCategory,
      f.FeatureDescription,
      hf.HouseFeatureId HouseFeatureId
    FROM Feature f 
    LEFT JOIN FeatureCategory fc ON f.FeatureCategoryId = fc.FeatureCategoryId
    LEFT JOIN HouseFeature hf ON (f.FeatureId = hf.FeatureId AND hf.HouseId = ' . $house['HouseId'] . ')
    ORDER BY f.FeatureCategoryId ASC 
    ;';
        $q = $pdo->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $q->fetch()):
        ?>
        <tr>
          <td>
            <?php echo $row['FeatureCategory']; ?>
          </td>
          <td>
            <?php echo $row['FeatureDescription']; ?>
          </td>
          <td>
            <input type="checkbox" name="Features[]" value="<?php echo $row['FeatureId']; ?>" <?php if
          ($row['HouseFeatureId'] !=NULL): ?>
            checked
            <?php endif; ?>
            />
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
      <input type="submit" value="UPDATE">
    </form>
    <br>
    <br><br><br>
</body>
</div>

</html>