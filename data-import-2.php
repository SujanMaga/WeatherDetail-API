<?php

// Select weather data for given parameters
$sql = "SELECT *
FROM weather WHERE city = '{$_GET['city']}'
AND weather_when >= DATE_SUB(NOW(), INTERVAL 10 SECOND)
ORDER BY weather_when DESC limit 1";
$result = $mysqli -> query($sql);

// If 0 record found
if ($result->num_rows == 0) {
    $url = "https://api.openweathermap.org/data/2.5/weather?q=" . $_GET['city'] . "insert weather-api id here";

// Get data from openweathermap and store in JSON object 
$data = file_get_contents($url);
$json = json_decode($data, true);

// Fetch required fields
$weather_description = $json['weather'][0]['description'];
$weather_temperature = $json['main']['temp'];
$weather_wind = $json['wind']['speed'];
$weather_when = date("Y-m-d H:i:s"); // now
$city = $json['name'];
$humidity = $json["main"]["humidity"];
$maxTemp = $json['main']['temp_max'];
$minTemp = $json['main']['temp_min'];
$icon = $json['weather'][0]['icon'];
$weather= $json['weather']['0']['main'];
$pressure= $json['main']['pressure'];


 

// Build INSERT SQL statement

$sql = "INSERT INTO weather (weather_description, weather_temperature, weather_wind, weather_when, city, min, max, humidity, icon, weather_value, pressure)
VALUES('{$weather_description}', {$weather_temperature}, {$weather_wind}, '{$weather_when}', '{$city}','{$minTemp}','{$maxTemp}','{$humidity}','{$icon}','{$weather}','{$pressure}')";

// Run SQL statement and report errors
if (!$mysqli -> query($sql)) {
echo("<h4>SQL error description: " . $mysqli -> error . "</h4>");

}
}

?>