<?php

/*
Uzduotis #2:
Issaugoti duomenis is masyvo, i faila (CSV, JSON, XML)

Reikalavimai:
KISS funkcija turi buti maziau negu 50 liniju kodo.
DRY negalima kopijuoti arba rasyti identisko kodo.
SOLID Kiekviena class turi buti naudojama vienai reksmei


Uzduociai atlikti buvo naudojamas PHP su XAMPP pagalba.

*/

$data = array(array('first_name'=>'Kiestis', 'age'=>'29', 'gender'=>'male'),
array('first_name'=>'Vytska', 'age'=>'32', 'gender'=>'male'),
array('first_name'=>'Karina', 'age'=>'25', 'gender'=>'female'));

/*
    abstract class Writer skirta 3 kitom Writer klasem naudojama kaip interface.
*/

abstract class Writer
{
    abstract protected function write($data);
}

/*
    class WriterJSON saugo duomenis is asociatyvinio masyvo i JSON faila.
*/

class WriterJSON extends Writer
{
    public function write($data)
    {
        $file = fopen("database.json", "w");
        fwrite($file, json_encode($data));
        fclose($file);
    }
}

/*

class WriterCSV saugo duomenis is asociatyvinio masyvo i CSV faila.

*/

class WriterCSV extends Writer
{

    /*

    funkcija write turi antra array header jis naudojamas isiminti
    parametram (first_name, age ir gender). Jei bus prodeta nauju
    parametru i data masyva 17 eiluteje funkcija automatiskai
    peisitakys.

    if naudojami kad pirma karta isiminti failu parametrus (keys) ir
    juos atspauzdinti failu virsuje (1 eiluteje).

    */

    public function write($data)
    {
        $header = array();
        $file = fopen("database.csv", "w");

        for($index = 0; $index < count($data); $index++){
            $info = array();
            foreach($data[$index] as $key => $value){
                // isimena parametrus tik piramji karta.
                if($index == 0){
                    $header[] = $key;
                }
                $info[] = $value;
            }

            if($index == 0){
                fputcsv($file, $header);
            }

            fputcsv($file, $info);
        }
        fclose($file);
    }
}

/*

class WriterXML saugo duomenis is asociatyvinio masyvo i XML faila.

*/

class WriterXML extends Writer
{

    /*

    funkcija wirte sukuria XML documenta ir iraso doumenis i
    faila naudodamasis createElement() ir issaugodamas jous
    tarp 'tags' appendChild() funkcijomis.
    */

    public function write($data)
    {
    
    $document = new DOMDocument();
	$document->encoding = 'utf-8';
    $document->xmlVersion = '1.0';
    $document->formatOutput = true;

	$filename = 'database.xml';
    $items = $document->createElement('items');
    
    
    for($i = 0; $i < count($data); $i++){
        $item = $document->createElement('item');
        foreach($data[$i] as $key => $value){
            $attribute = $document->createElement($key, $value);
            $item->appendChild($attribute);
        }
        $items->appendChild($item);
    }

    $document->appendChild($items);
	$document->save($filename);
    }
}

// Pagrindine programa:
$writer = new WriterJSON();
$writer->write($data);
$writer = new WriterCSV();
$writer->write($data);
$writer = new WriterXML();
$writer->write($data);
?>