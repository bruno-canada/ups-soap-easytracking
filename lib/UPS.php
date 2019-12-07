<?php

namespace UPS;

use Exception;
use SoapClient;
use SoapHeader;

class UPSClient
{

    private $keyaccess;
    private $userid;
    private $passwd;

    private $client;

    public $operation = "ProcessTrack";
    public $wsdl = "../wsdls/Track.wsdl";

    /**
     * Set credentials and checks system operational mode
     *
     * @param string $keyaccess
     * @param string $userid
     * @param string $passwd
     * @param string $mode
     */
    public function __construct(string $keyaccess, string $userid, string $passwd, string $mode = null)
    {
        $this->keyaccess = $keyaccess;
        $this->userid = $userid;
        $this->passwd = $passwd;

        $this->mode = $mode;
        if (empty($this->mode) || ($this->mode != "Test" && $this->mode != "Production")) {
            throw new Exception("Parameter Mode has to be either *Test* or *Production*");
        }
    }

    /**
     * Fetch activity of a shipment based on tracking number
     *
     * @param string $trackingNumber
     * @return obj Web Service Response
     */
    public function track(string $trackingNumber)
    {
        $this->client = $this->SOAPConnect();

        $request = array();
        $request = [
            "Request" => [
                "RequestOption" => 15,
                "TransactionReference" => ["CustomerContext" => "Description"]
            ],
            "InquiryNumber" => trim($trackingNumber),
            "TrackingOption" => "02"
        ];


        $resp = $this->client->__soapCall($this->operation, array($request));

        return $resp;
    }

    /**
     * Connect to webservice using SOAP and send credentials
     *
     * @return obj SOAP client handler
     */
    private function SOAPConnect()
    {
        //Check if the credentials were defined and are properly loaded
        if (empty($this->keyaccess) || empty($this->userid) || empty($this->passwd)) {
            throw new Exception("UPS credentials are empty.");
        }

        $mode = [
            'soap_version' => 'SOAP_1_1',
            'trace' => 1
        ];

        //Instantiate SoapClient
        $client = new SoapClient($this->wsdl, $mode);

        //Set Soap endpoint
        $client->__setLocation($this->getEndPoint());

        //Header settings
        $headerCredentials = array();
        $headerCredentials['UsernameToken'] = ["Username" => $this->userid, "Password" => $this->passwd];
        $headerCredentials['ServiceAccessToken'] = ["AccessLicenseNumber" => $this->keyaccess];

        //Instantiate Soap Header Handler
        $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0', 'UPSSecurity', $headerCredentials);
        $client->__setSoapHeaders($header);

        return $client;
    }

    /**
     * Define correct web service URL
     *
     * @return string Web service URL
     */
    private function getEndPoint()
    {
        switch ($this->mode) {
            case "Production":
                return "https://onlinetools.ups.com/webservices/Track";
                break;

            default:
                //Test enviroment by default
                return "https://wwwcie.ups.com/webservices/Track";
        }
    }
}
