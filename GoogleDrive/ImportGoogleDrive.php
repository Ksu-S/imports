<?php

require_once '../vendor/autoload.php';

        function getClient()
        {
            $client = new Google_Client();
            $client->setApplicationName('Import');
            $client->setScopes(Google_Service_Drive::DRIVE_READONLY);
            $client->setAuthConfig('../credentials.json');
            $client->setAccessType('offline');
            $tokenPath = 'token2.json';
            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                $client->setAccessToken($accessToken);
            }
            return $client;
        }
        
        $client = getClient();

$service = new Google_Service_Drive($client);

$fileId = "1zfyhX_c6Ih0FWMTn0-89loVblo6fYKca";

$file = $service->files->get($fileId);

// print "Title: " . $file->getName();
// print "Description: " . $file->getDescription();
// print "MIME type: " . $file->getMimeType();

$content = $service->files->get($fileId, array("alt" => "media"));
file_put_contents("googledrive.xlsx", $content->getBody());


//print as array

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

// $xlsx = SimpleXLSX::parse('googledrive.xlsx');	
// echo 'Sheet Name 2 = '.$xlsx->sheetName(1);

// if ( $xlsx = SimpleXLSX::parse('text.xlsx') ) {
// 	echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
// 	foreach( $xlsx->rows() as $r ) {
// 		echo '<tr><td>'.implode('</td><td>', $r ).'</td></tr>';
// 	}
// 	echo '</table>';
// 	// or $xlsx->toHTML();	
// } else {
// 	echo SimpleXLSX::parseError();
// }