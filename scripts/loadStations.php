#!/usr/bin/php
<?php

require_once 'bootstrap.php';

$dom = new DOMDocument();
$filename = '../docs/stations.xml';

if (!is_readable($filename)) {
    fwrite(STDOUT, 'Unable to read input file' . PHP_EOL);
    exit(1);
    }

$dom->load($filename);
$xpath = new DOMXpath($dom);
$mapper = new Application_Model_TrainStationMapper();

$results = $xpath->query('//station');
fwrite(STDOUT, 'Found ' . $results->length . ' stations' . PHP_EOL);

foreach ($results as $result) {
    $station = new Application_Model_TrainStation();

    $station
        ->setName($xpath->query('name', $result)->item(0)->nodeValue)
        ->setCode($xpath->query('code', $result)->item(0)->nodeValue)
        ->setCountry($xpath->query('country', $result)->item(0)->nodeValue)
        ->setLatitude((float) $xpath->query('lat', $result)->item(0)->nodeValue)
        ->setLongitude((float) $xpath->query('long', $result)->item(0)->nodeValue)
        ->setAlias((bool) $xpath->query('alias', $result)->item(0)->nodeValue);

    $mapper->save($station);
}
