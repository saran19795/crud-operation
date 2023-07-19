<?php
// getDistricts.php

// Simulating the districts data
require 'districts.php';


// Check if the state parameter is present
if (isset($_GET['state'])) {
    $selectedState = $_GET['state'];

    // Check if the selected state exists in the data
    if (array_key_exists($selectedState, $districtsData)) {
        // Retrieve the districts for the selected state
        $districts = $districtsData[$selectedState];

        // Return the districts as a JSON response
        header('Content-Type: application/json');
        echo json_encode($districts);
        exit();
    }
}

// If the state parameter is missing or the selected state doesn't exist, return an empty response
echo json_encode([]);
