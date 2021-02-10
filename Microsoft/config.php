<?php
 
 
require_once '../vendor/autoload.php';

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

$guzzle = new \GuzzleHttp\Client();
$tenantId = '24f6db21-f88d-477f-836a-36c4a35661bb';
$clientId = '8444d010-a0e2-4308-bcd7-41f77a32b78c';
$clientSecret = 'T-7l1mQU8b_k1w_cXHOJ-fkVTRM9y~U-yz';
$url = 'https://login.microsoftonline.com/' . $tenantId . '/adminconsent?client_id='.$clientId;
$token = json_decode($guzzle->post($url, [
    'form_params' => [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'resource' => 'https://graph.microsoft.com/',
        'grant_type' => 'client_credentials',
    ],
])->getBody()->getContents());
$accessToken = $token->access_token;


$graph = new Graph();
$graph->setAccessToken($accessToken);

$user = $graph->createRequest("GET", "/me/drive")
              ->setReturnType(Microsoft\Graph\Model\DriveItem::class)
              ->execute();


print_r($user);