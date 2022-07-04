<?php

/*
Uzduotis #2:
Issaugoti duomenis is masyvo, i faila (CSV, JSON, XML)

Reikalavimai:
KISS funkcija turi buti maziau negu 50 liniju kodo.
DRY negalima kopijuoti arba rasyti identisko kodo.
SOLID Kiekviena class turi buti naudojama vienai reksmei.


Uzduociai atlikti buvo naudojamas PHP su XAMPP pagalba.

*/

echo "DEBUG";

include("Writer.php");
include("WriterJSON.php");
include("WriterXML.php");
include("WriterCSV.php");

$data = array(array('first_name'=>'Kiestis', 'age'=>'29', 'gender'=>'male'),
array('first_name'=>'Vytska', 'age'=>'32', 'gender'=>'male'),
array('first_name'=>'Karina', 'age'=>'25', 'gender'=>'female'));

// Pagrindine programa:

$writer = new WriterJSON();
$writer->write($data);

$writer = new WriterCSV();
$writer->write($data);
$writer = new WriterXML();
$writer->write($data);

?>