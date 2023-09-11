<?php

use GuzzleHttp\Client;

class DiavoxSoap
{
    protected $user_id;
    protected $user_password;
    protected $response;
    protected $mp_status;
    protected $mp_type;
    protected $client;
    protected $subsystem;
    protected $request;
    protected $namespace;
    protected $url;
    protected $extension;
    protected $headers = [];
    public function __construct()
    {
        require 'vendor/autoload.php';
        $this->client = new Client();
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        $xmlData = $this->response;
        $simpleXml = simplexml_load_string($xmlData);
        $namespaces = $simpleXml->getNamespaces(true);
        $soapenv = $simpleXml->children($namespaces[$this->namespace]);
        return json_encode($soapenv->Body->children(), JSON_PRETTY_PRINT);
    }

    public function setMP($mp)
    {
        if ($mp == "1") {
            $this->mp_status = true;
        } else if ($mp == "0") {
            $this->mp_status = false;
        }
    }
    public function getMP()
    {
        return $this->mp_status;
    }

    public function setType($type)
    {
        $this->mp_type = $type;
    }

    public function getType()
    {
        return $this->mp_type;
    }

    public function setHeader($key = "SOAPAction", $value = "urn:#manageData")
    {
        $this->headers[$key] = $value;
    }

    public function getHeader()
    {
        return $this->headers;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }


    public function getRequest()
    {
        return $this->request;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserPassword($user_password)
    {
        $this->user_password = $user_password;
    }

    public function getUserPassword()
    {
        return $this->user_password;
    }

    public function setSubsystem($subsystem)
    {
        $this->subsystem = $subsystem;
    }

    public function getSubsystem()
    {
        return $this->user_password;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function checkIn()
    {
    }

    public function checkOut()
    {
    }

    public function roomSwap()
    {
    }

    public function nameSwap($firstname, $lastname)
    {


        $this->request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
        <soapenv:Header/>
        <soapenv:Body>
           <eemm:EMInteractions xmlns:eemm="http://schemas.ericsson.se/enterprise/mecs/eemm">
              <eemm:EMInteraction>
                 <eemm:GenericRequest>
                    <eemm:TargetSystem>MP</eemm:TargetSystem>
                    <eemm:TaskObject>java:global/mp/mp.jar/SubSystemBean!se.ericsson.ebc.emtsn.ejb.GenericManagerLocal</eemm:TaskObject>
                    <eemm:Action>CHANGE</eemm:Action>
                 </eemm:GenericRequest>
                 <eemm:Tokens>
                    <eemm:UserID>' . $this->getUserId() . '</eemm:UserID>
                    <eemm:Password>' . $this->getUserPassword() . '</eemm:Password>
                    <eemm:ApplicationID>diavox</eemm:ApplicationID>
                    <eemm:OnBehalfOf>diavox</eemm:OnBehalfOf>
                    <eemm:TransactionID>1</eemm:TransactionID>
                 </eemm:Tokens>
                 <eemm:EMType>
                    <eemm:MP>
                       <eemm:SubSystem_VOs>
                           <eemm:SubSystem_VO>
                            <eemm:SubSystem>
                             <eemm:SubSystemName>' . $this->getSubsystem() . '</eemm:SubSystemName>
                            </eemm:SubSystem>
                             <eemm:ServiceSystem>
                                <eemm:Action>CHANGE</eemm:Action>
                                <eemm:TSA>
                                    <eemm:GenericResponse>
                                        <eemm:Info>
                                        </eemm:Info>
                                    </eemm:GenericResponse>
                                    <eemm:' . $this->getType() . 'Extension_VOs>
                                        <eemm:' . $this->getType() . 'Extension_VO>
                                            <eemm:DIR>' . $this->getExtension() . '</eemm:DIR>
                                            <eemm:NIINP>
                                                <eemm:Name1>' . $firstname . '</eemm:Name1>
                                                <eemm:Name2>' . $lastname . '</eemm:Name2>
                                            </eemm:NIINP>
                                        </eemm:' . $this->getType() . 'Extension_VO>
                                        <eemm:GEDIP>
                                        </eemm:GEDIP>
                                    </eemm:' . $this->getType() . 'Extension_VOs>
                                </eemm:TSA>
                            </eemm:ServiceSystem>
                        </eemm:SubSystem_VO>
                    </eemm:SubSystem_VOs>
                    </eemm:MP>
                 </eemm:EMType>
              <eemm:GenericResponse/></eemm:EMInteraction>
           </eemm:EMInteractions>
        </soapenv:Body>
     </soapenv:Envelope>';

        $this->requestFire();
        // return htmlspecialchars($this->response->getBody());

    }

    public function requestFire()
    {

        $headers = [
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction'     => 'urn:#manageData'
        ];

        $this->client->post($this->url, [
            'headers' => $headers,
            'body' => $this->getRequest()

        ]);
    }

    public function setNamespace($namespace = "SOAP-ENV")
    {
        $this->namespace = $namespace;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }
}
