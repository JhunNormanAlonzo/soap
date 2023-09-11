<?php
		include "DiavoxSoap.php";
		$ds = new DiavoxSoap();
        $ds->setUrl("http://192.168.0.170/mpwebservices/services/MP");
        $ds->setUserId('jella');
        $ds->setUserPassword('Diavox!23');
        $ds->setExtension("1501");
        $ds->setSubsystem("lim1");
        $ds->nameSwap("test", "lastname");