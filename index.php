<?php

$link = "http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?wsdl";
$param = array('sName' => 'Tuvalu');
try {
    $soapclient = new SoapClient($link);
    $lists = $soapclient->ListOfCountryNamesByName($param);




    foreach ($lists->ListOfCountryNamesByNameResult->tCountryCodeAndName as $item) {
        echo "<pre>" . $item->sISOCode . " : " . $item->sName . "</pre>";
    }


    echo "<pre>" . json_encode($http_response_header) . "</pre>";
} catch (Exception $e) {
    echo $e->getMessage();
}

?>