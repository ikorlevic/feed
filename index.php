<?php
use \Lib\Client;

$feed = "https://dev98.de/category/general/feed/";

$client = new Client;
$client->fetchFeed($feed);
