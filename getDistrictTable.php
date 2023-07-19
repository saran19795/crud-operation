<!DOCTYPE html>
<html>
<head>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <table class="table table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Product Name</th>
          <th>Product Price</th>
          <th>District</th>
          <th>State</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- PHP code to generate table rows -->
        <?php
          // Assuming you have a database connection established
          $mysqli = require __DIR__ . "/database.php";

          // Retrieve the selected district from the AJAX request
          $selectedDistrict = $_GET['district'];

          // Prepare and execute the query to retrieve the district table data
          $sql = "SELECT * FROM products WHERE district = ?";
          $stmt = $mysqli->prepare($sql);
          $stmt->bind_param("s", $selectedDistrict);
          $stmt->execute();
          $result = $stmt->get_result();

          // Fetch the rows and generate the table rows
          while ($row = $result->fetch_assoc()) {
            echo '<tr id="row-' . $row['id'] . '">';
            echo '<td><input type="text" class="form-control" value="' . $row['id'] . '"></td>';
            echo '<td><input type="text" class="form-control" value="' . $row['productname'] . '"></td>';
            echo '<td><input type="text" class="form-control" value="' . $row['productprice'] . '"></td>';
            echo '<td><input type="text" class="form-control" value="' . $row['district'] . '"></td>';
            echo '<td><input type="text" class="form-control" value="' . $row['state'] . '"></td>';
            echo '<td>';
            echo '<button class="btn btn-primary" onclick="updateRow(' . $row['id'] . ')">Update</button>';
            echo '<button class="btn btn-danger" onclick="deleteRow(' . $row['id'] . ')">Delete</button>';
            echo '</td>';
            echo '</tr>';
          }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Include Bootstrap JS (optional, for certain Bootstrap features) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Your other JavaScript code here -->
  <script>
    // Your updateRow and deleteRow functions here
  </script>
</body>
</html>
