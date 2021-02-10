<?php
 
require_once '../vendor/autoload.php';

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

$tokenPath = 'token.txt';
$accessToken = file_get_contents($tokenPath);
$graph = new Graph();
$graph->setAccessToken($accessToken);

$docId = '016ETYLGD4GNOSKE2GCNFKFWJ3SDDNA2E4';
$file = $graph->createRequest("GET", "/me/drive/items/".$docId."/content")
            ->download('googledrive.xlsx');


                

if ( $xlsx = SimpleXLSX::parse('googledrive.xlsx')) {
                        
$header_values = $rows = [];
    foreach ( $xlsx->rows() as $k => $r ) {
    if ( $k === 0 ) {
    $header_values = $r;
    continue;
        }
    $rows[] = array_combine( $header_values, $r );
    }
    print_r( $rows );
    }