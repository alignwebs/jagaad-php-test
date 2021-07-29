<?php

include 'classes/Musement.php';

$musement = new Musement\Musement();
$cities = $musement->getCities();
print_r($cities);
