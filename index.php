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

abstract class Writer
{
    abstract protected function process($data);

    public function write($filename, $info)
    {
        $file = fopen($filename, "w");
        fwrite($file, $info);
        fclose($file);
    }
}
// Poorly pu to files
class WriterJSON extends Writer
{
    public function process($data)
    {
        $file = fopen("database.json", "w");
        $output = array();
        for($index = 0; $index < count($data); $index++){
            $output[] = $data[$index];
        }
        fwrite($file, json_encode($output));
        fclose($file);
    }
}

class WriterCSV extends Writer
{
    public function process($data)
    {
        $header = array();
        $file = fopen("database.csv", "w");
        for($index = 0; $index < count($data); $index++){
            $info = array();
            foreach($data[$index] as $key => $value){
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

class WriterXML extends Writer
{
    public function process($data)
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

$writer = new WriterJSON();
$writer->process($data);
$writer = new WriterCSV();
$writer->process($data);
$writer = new WriterXML();
$writer->process($data);
?>