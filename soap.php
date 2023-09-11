<?php


include "DiavoxSoapClass.php";

$diavoxSoap = new DiavoxSoapClass();


if (isset($_POST['save'])) {
    $extension = $_REQUEST['extension'];
    $firstname = $_REQUEST['firstname'];
    $lastname = $_REQUEST['lastname'];
    $url = "http://192.168.0.170:80/mpwebservices/services/MP";
    $type = $_REQUEST['type'];
    $diavoxSoap->setCredential('jella', 'Diavox!23', 'lim1');
    $diavoxSoap->setRequestBody($type, $extension, $firstname, $lastname);
    $response = $diavoxSoap->soapRequest($url);
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <label for="">Extension</label>
        <input type="text" name="extension">
        <br>
        <label for="">Firstname</label>
        <input type="text" name="firstname">
        <br>
        <label for="">Lastname</label>
        <input type="text" name="lastname">
        <br>
        <label for="">Type</label>
        <input type="text" name="type">
        <br>
        <button name="save">Save</button>
    </form>
</body>

</html>