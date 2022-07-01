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

class Person skirta naudoti kaip data struktura. Atsiminti zmogaus informacijai.
Constructor paiima 3 kintamuosius. ir juos isimena.
Funkcijos get leidzia pasiekti kintamousius atitinkamai.

*/

class Person
{

    private $name;
    private $age;
    private $gender;

    public function __construct($name, $age, $gender)
    {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
    }

    public function __destruct()
    {

    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function asArray()
    {
        return array('first_name'=>$this->name, 'age'=>$this->age, 'gender'=>$this->gender);
    }

}

/*

class Reader skirta doumenu skaitymui is masyvo.
constructor sukuria nauja masyva atminciai. 
Galima perskaityti kelis skirtingus masyvus ir tada viska irasyti vienu kartu.
Taip pat galima pasiekti atminti,
jeigu del kazkokiu atveju reiktu kazka istrinti ar pakeist.

*/

class Reader
{
     // atmintis
    private $data;

    public function __construct() 
    {
        $data = array();
    }

    public function __destruct()
    {}

    // Skaito is skirto masyvo -> data.
    public function read($data)
    {
        for($i = 0; $i < count($data); $i++){ 
            $this->data[] = new Person($data[$i]['first_name'], $data[$i]['age'], $data[$i]['gender']);
        }
    }

    // Galima pasiekti atminti.
    public function getData()
    {
        return $this->data;
    }

    // funkcija skirta isvalyti visa atminti
    public function clear()
    {
        $this->data = array();
    }

}

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
            $output[] = $data[$index]->asArray();
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
            $person = $data[$index]->asArray();
            foreach($data[$index]->asArray() as $key => $value){
                if($index == 0){
                    $header[] = $key;
                }
                $info[] = $value;
            }
            echo var_dump($person) . "<br>";
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
        foreach($data[$i]->asArray() as $key => $value){
            $attribute = $document->createElement($key, $value);
            $item->appendChild($attribute);
        }
        $items->appendChild($item);
    }

    $document->appendChild($items);
	$document->save($filename);
    }
}

$reader = new Reader();
$reader->read($data);
$info = $reader->getData();
$writer = new WriterJSON();
$writer->process($info);
$writer = new WriterCSV();
$writer->process($info);
$writer = new WriterXML();
$writer->process($info);
?>