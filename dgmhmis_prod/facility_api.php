<?php

// API URL
$url = "https://uphealthfacility.in/api/webapi/GetUPKSKFacility?FacilityType=DH";

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // To store the result as a string
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Optional: Skip SSL certificate verification (useful in dev environments)

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    // Handle the response (print or process the data)
    echo "<pre>";
    print_r($response);
    echo "</pre>";
}

// Close the cURL session
curl_close($ch);

?>
