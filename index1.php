<?php

// Request XML
$requestXml = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <ListOfContinentsByName xmlns="http://www.oorsprong.org/websamples.countryinfo">
    </ListOfContinentsByName>
  </soap:Body>
</soap:Envelope>';

// Set cURL options
$url = 'http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso';
$headers = array(
    'Content-Type: text/xml; charset=utf-8',
    'Content-Length: ' . strlen($requestXml)
);

$curlOptions = array(
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $requestXml,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true
);

// Initialize cURL session
$ch = curl_init();
curl_setopt_array($ch, $curlOptions);

// Execute the cURL session and get the response
$responseXml = curl_exec($ch);


// Close cURL session
curl_close($ch);

// Display the response XML
// echo "Response:\n";
// echo $responseXml;

$soapResponse = simplexml_load_string($responseXml);
if ($soapResponse !== false) {
    $continents = $soapResponse->xpath('//tContinent');
    foreach ($continents as $continent) {
        $code = (string) $continent->sCode;
        $name = (string) $continent->sName;
        echo "Code: $code, Name: $name\n";
    }
} else {
    echo "Failed to parse the SOAP response XML.";
}

https://us02web.zoom.us/j/82323665062?pwd=K1dlZTNEL0o4NnZVcjdKMDhZWW5lQT09
?>