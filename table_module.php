<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Home Page</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/index.css">

  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="states">Location</label>
          <?php require 'states.php'; ?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="districts">Region</label>
          <select id="districts" class="form-control">
            <option value="">Select District</option>
            <!-- The districts will be dynamically populated here -->
          </select>
        </div>
      </div>
    </div>
  </div>
  <div id="userDetails">
        <!-- The user data will be displayed here -->
    </div>
    

    <script>
    // JavaScript code for dynamic dropdowns and data fetching
    // Add your JavaScript code here
    const statesDropdown = document.getElementById('states');
    const districtsDropdown = document.getElementById('districts');
    const userDetailsDiv = document.getElementById('userDetails');

    statesDropdown.addEventListener('change', function() {
        const selectedState = this.value;

        // Make an AJAX request to fetch the districts for the selected state
        const url = `getDistricts.php?state=${encodeURIComponent(selectedState)}`;

        // Clear previous options in the districts dropdown
        districtsDropdown.innerHTML = '<option value="">Select District</option>';

        // Fetch districts data
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Populate the districts dropdown with fetched data
                data.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    districtsDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    });

    districtsDropdown.addEventListener('change', function() {
        const selectedDistrict = this.value;

        // Make an AJAX request to fetch the district table data
        const tableUrl = `getDistrictTable.php?district=${encodeURIComponent(selectedDistrict)}`;

        // Fetch district table data
        fetch(tableUrl)
            .then(response => response.text())
            .then(data => {
                // Display the district table data in the userDetailsDiv
                userDetailsDiv.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    });
</script>
<!-- Add this within the <head> section -->
<script>
  function updateRow(rowId) {
  // Retrieve the values from the input fields for the specified row
  var id = document.getElementById('row-' + rowId).querySelectorAll('input')[0].value;
  var productName = document.getElementById('row-' + rowId).querySelectorAll('input')[1].value;
  var productPrice = document.getElementById('row-' + rowId).querySelectorAll('input')[2].value;
  var district = document.getElementById('row-' + rowId).querySelectorAll('input')[3].value;
  var state = document.getElementById('row-' + rowId).querySelectorAll('input')[4].value;

  // Perform an AJAX request to update the row on the server-side
  // Include the rowId and updated values in the request payload
  fetch('updateRow.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      id: id,
      productName: productName,
      productPrice: productPrice,
      district: district,
      state: state
    }),
  })
  .then(response => response.text())
  .then(data => {
    // Handle the response from the server
    alert(data); // Display the response in a popup

    // Optionally, you can perform additional actions after a successful update
    console.log('Row updated successfully.');
  })
  .catch(error => {
    // Handle the error, if any
    console.error(error);
  });
}


  function deleteRow(rowId) {
    // Perform an AJAX request to delete the row on the server-side
    // Include the rowId in the request payload

    // Example using fetch API:
    fetch('deleteRow.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        id: rowId
      }),
    })
    .then(response => response.text())
    .then(data => {
      
      // Handle the response from the server, if needed
      console.log(data);

      // Remove the deleted row from the HTML table
      var rowElement = document.getElementById('row-' + rowId);
      rowElement.parentNode.removeChild(rowElement);
    })
    .catch(error => {
      // Handle the error, if any
      console.error(error);
    });
  }
</script>




</body>

</html>
