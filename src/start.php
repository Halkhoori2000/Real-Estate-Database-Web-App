<?php
require('db.php');

// Compute pagination offsets and limits
$rowsPerPage = 50;
$page = isset($_GET['page']) ? $_GET['page'] : 0;

// Query the rows here 
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
  o.OwnerPhone
FROM House h
LEFT JOIN Address a ON h.HouseId = a.HouseId
LEFT JOIN HouseForSale hf ON hf.HouseId = h.HouseId
LEFT JOIN Owner o ON o.HouseId = h.HouseId
ORDER BY h.HouseId
LIMIT ' . ($rowsPerPage + 1) . '
OFFSET ' . ($rowsPerPage * $page) . '
';

$q = $pdo->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);

// Count the fetch rows. 
// If we get more than the number of rows,
// then we have a next page. 
$fetchRows = 0;

?>
<!DOCTYPE html>
<html>

<head>
  <title>PHP MySQL Query Data</title>
  <style>
    table {
      border-collapse: collapse;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    .inline {
      display: inline-block;
    }

    .right {
      float: right;
    }

    .left {
      float: left;
    }
  </style>
</head>

<body>
  <div id="container">
    <h2>List of houses</h2>
    <table cellpadding=5 cellspacing=0>
      <thead>
        <tr>
          <th>#</th>
          <th>Built</th>
          <th>Listed</th>
          <th>Address</th>
          <th>Street</th>
          <th>ZipCode</th>
          <th>City</th>
          <th>Country</th>
          <th>Rooms</th>
          <th>Bedrooms</th>
          <th>Bathrooms</th>
          <th>Garage</th>
          <th>Description</th>
          <th>LotSize</th>
          <th>Area</th>
          <th>Price</th>
          <th>Posted</th>
          <th>Owner</th>
          <th>Phone</th>
          <th>Delete?</th>
          <th>Update?</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $q->fetch()): ?>
        <?php
          $fetchRows++;
          if ($fetchRows > $rowsPerPage)
            continue;
        ?>
        <tr>
          <td>
            <?php echo htmlspecialchars($row['HouseId']) ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseBuilt']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseListed']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseAddress']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['AddressStreet']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['AddressZipCode']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['AddressCity']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['AddressCountry']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseRooms']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseBedrooms']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseBathrooms']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseGarage']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseDescription']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseLotSize']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HouseArea']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['HousePrice']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['DatePosted']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['OwnerName']); ?>
          </td>
          <td>
            <?php echo htmlspecialchars($row['OwnerPhone']); ?>
          </td>
          <td>
            <form action="./delete.php" method="post" onsubmit="return confirm('Do you want to continue?');">
              <input type="submit" value="DELETE" />
              <input type="hidden" name="page" value="<?php echo $page;?>"/>
              <input type="hidden" name="HouseId" value="<?php echo $row['HouseId']; ?>"/>
            </form>
          </td>
          <td>
            <form action="./update.php" method="get">
              <input type="submit" value="UPDATE" />
              <input type="hidden" name="page" value="<?php echo $page;?>"/>
              <input type="hidden" name="HouseId" value="<?php echo $row['HouseId']; ?>"/>
            </form>
          </td>
        </tr>
        <?php
          $newLastHouseId = $row['HouseId'];
        endwhile;
        ?>
        <tr>
          <td colspan="21">
            <?php if ($page > 0): ?>
            <form action="" method="get" class="inline left">
              <input type="submit" value="PREVIOUS" />
              <input type="hidden" name="page" value="<?php echo ($page - 1); ?>" />
            </form>
            <?php endif; ?>
            <?php if ($fetchRows > $rowsPerPage): ?>
            <form action="" method="get" class="inline right">
              <input type="submit" value="NEXT" />
              <input type="hidden" name="page" value="<?php echo ($page + 1); ?>" />
            </form>
            <?php endif; ?>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    <h2>List a new house:</h2>
    <form action="./insert.php" method="post">
      <table>
        <tr>
          <td>Built:</td>
          <td><input required type="date" id="HouseBuilt" name="HouseBuilt"></td>
        </tr>
        <tr>
          <td>Address:</td>
          <td><input required type="text" id="HouseAddress" name="HouseAddress"></td>
        </tr>
        <tr>
          <td>Street:</td>
          <td><input required type="text" id="AddressStreet" name="AddressStreet"></td>
        </tr>
        <tr>
          <td>ZipCode:</td>
          <td><input required type="number" id="AddressZipCode" name="AddressZipCode"></td>
        </tr>
        <tr>
          <td>City:</td>
          <td><input required type="text" id="AddressCity" name="AddressCity"></td>
        </tr>
        <tr>
          <td>Country:</td>
          <td><input required type="text" id="AddressCountry" name="AddressCountry"></td>
        </tr>
        <tr>
          <td>Rooms:</td>
          <td><input required min="0" type="number" id="HouseRooms" name="HouseRooms"></td>
        </tr>
        <tr>
          <td>Bedrooms:</td>
          <td><input required min="0" type="number" id="HouseBedrooms" name="HouseBedrooms"></td>
        </tr>
        <tr>
          <td>Bathrooms:</td>
          <td><input required min="0" type="number" id="HouseBathrooms" name="HouseBathrooms"></td>
        </tr>
        <tr>
          <td>Garage:</td>
          <td><input required min="0" type="number" id="HouseGarage" name="HouseGarage"></td>
        </tr>
        <tr>
          <td>Description:</td>
          <td><textarea required id="HouseDescription" name="HouseDescription"></textarea></td>
        </tr>
        <tr>
          <td>LotSize:</td>
          <td><input required min="0" type="number" id="HouseLotSize" name="HouseLotSize"></td>
        </tr>
        <tr>
          <td>Area:</td>
          <td><input required min="0" type="number" id="HouseArea" name="HouseArea"></td>
        </tr>
        <tr>
          <td>Owner Name:</td>
          <td><input required type="text" id="OwnerName" name="OwnerName"></td>
        </tr>
        <tr>
          <td>Owner Phone:</td>
          <td><input required type="text" id="OwnerPhone" name="OwnerPhone"></td>
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
              <option value="<?php echo $row['PersonId']; ?>">
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
        f.FeatureDescription
      FROM Feature f 
      LEFT JOIN FeatureCategory fc ON f.FeatureCategoryId = fc.FeatureCategoryId
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
          <td><input type="checkbox" id="features[]" name="Features[]" value="<?php echo $row['FeatureId']; ?>" /></td>
        </tr>
        <?php endwhile; ?>
      </table>
      <input type="hidden" name="page" value="<?php echo $page;?>"/>
      <input type="submit" value="INSERT">
    </form>
    <br>
    <br><br><br>
</body>
</div>

</html>