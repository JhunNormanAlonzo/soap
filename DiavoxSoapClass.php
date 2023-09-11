<?php

use GuzzleHttp\Client;

class DiavoxSoapClass
{
    protected $client;

    public $requestResponse;
    public $request;
    public $user_id;
    public $user_password;
    public $subsys;
    public $headers;


    public function __construct()
    {
        require 'vendor/autoload.php';
        $this->client = new Client();
        $this->headers =  [
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction'     => 'urn:#manageData'
        ];
    }

    public function setCredential($user_id, $user_password, $subsys)
    {
        $this->user_id = $user_id;
        $this->user_password = $user_password;
        $this->subsys = $subsys;
    }

    public function setRequestBody($type, $extension, $firstname = "", $lastname = "")
    {
        $this->request = '
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
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
                    <eemm:UserID>' . $this->user_id . '</eemm:UserID>
                    <eemm:Password>' .  $this->user_password . '</eemm:Password>
                    <eemm:ApplicationID>diavox</eemm:ApplicationID>
                    <eemm:OnBehalfOf>diavox</eemm:OnBehalfOf>
                    <eemm:TransactionID>1</eemm:TransactionID>
                 </eemm:Tokens>
                 <eemm:EMType>
                    <eemm:MP>
                       <eemm:SubSystem_VOs>
                           <eemm:SubSystem_VO>
                            <eemm:SubSystem>
                             <eemm:SubSystemName>' . $this->subsys . '</eemm:SubSystemName>
                            </eemm:SubSystem>
                             <eemm:ServiceSystem>
                                <eemm:Action>CHANGE</eemm:Action>
                                <eemm:TSA>
                                    <eemm:GenericResponse>
                                        <eemm:Info>
                                        </eemm:Info>
                                    </eemm:GenericResponse>
                                    <eemm:' . $type . 'Extension_VOs>
                                        <eemm:' . $type . 'Extension_VO>
                                            <eemm:DIR>' . $extension . '</eemm:DIR>
                                            <eemm:NIINP>
                                                <eemm:Name1>' . $firstname . '</eemm:Name1>
                                                <eemm:Name2>' . $lastname . '</eemm:Name2>
                                            </eemm:NIINP>
                                        </eemm:' . $type . 'Extension_VO>
                                        <eemm:GEDIP>
                                        </eemm:GEDIP>
                                    </eemm:' . $type . 'Extension_VOs>
                                </eemm:TSA>
                            </eemm:ServiceSystem>
                        </eemm:SubSystem_VO>
                    </eemm:SubSystem_VOs>
                    </eemm:MP>
                 </eemm:EMType>
              <eemm:GenericResponse/></eemm:EMInteraction>
           </eemm:EMInteractions>
        </soapenv:Body>
     </soapenv:Envelope>
        ';
    }


    public function soapRequest($url)
    {

        $this->requestResponse = $this->client->post($url, [
            'headers' => $this->headers,
            'body' => $this->request,
        ]);
    }

    public function getBody()
    {
        return (string) $this->requestResponse->getBody();
    }




    public function toJson($xmlnamespace)
    {
        $simpleXml = simplexml_load_string($this->getBody());
        $namespaces = $simpleXml->getNamespaces(true);
        if (!empty($namespaces)) {
            $data = $simpleXml->children($namespaces[$xmlnamespace]);
        }
        return json_encode($data->Body->children(), JSON_PRETTY_PRINT);
    }



    public function toXml()
    {
        return htmlspecialchars($this->getBody());
    }
}
