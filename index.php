

<?php

/*
Uzduotis #2:
Issaugoti duomenis is masyvo, i faila (CSV, JSON, XML)

Reikalavimai:
KISS funkcija turi buti maziau negu 50 liniju kodo.
DRY negalima kopijuoti arba rasyti identisko kodo.
SOLID Kiekviena class turi buti naudojama vienai reksmei (Planas naudoti interface CSV JSON ir XML atskirai).


Uzduociai atlikti buvo naudojamas PHP su XAMPP pagalba.

*/

echo " DEBUG";

/*

    Class Reader:
    Skirta skaityti duomenu failui.
    Contructor priima failo varda ($filename)

*/

$data = array(array('first_name'=>'Kiestis', 'age'=>'29', 'gender'=>'male'),array('first_name'=>'Vytska', 'age'=>'32', 'gender'=>'male'),array('first_name'=>'Karina', 'age'=>'25', 'gender'=>'female'));

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

    function __construct($name, $age, $gender)
    {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
    }

    function __destruct(){}

    function get_name()
    {
        return $this->name;
    }

    function get_age()
    {
        return $this->age;
    }

    function get_gender()
    {
        return $this->gender;
    }

}

/*

    class Reader skirta doumenu skaitymui is masyvo.
    constructor sukuria nauja masyva atminciai. Ideja yra ta, jog galima perskaityti kelis skirtingus masyvus ir tada viska irasyti vienu kartu.
    Taip pat galima pasiekti atminti jeigu del kazkokiu atveju reiktu kazka irtrinti ar pakeist.

*/

class Reader
{
    private $data; // atmintis

    function __construct() 
    {
        $data = array();
    }

    function __destruct()
    {}
    // Skaito is skirto masyvo -> data.
    function read($data)
    {
        for($i = 0; $i < count($data); $i++)
        {  
            $this->data[] = new Person($data[0], $data[1], $data[2]);
        }
    }
    // Galima pasiekti atminti.
    function get_data()
    {
        return $data;
    }
    // funkcija skirta isvalyti visa atminti
    function clear()
    {
        $this->data = array();
    }

};

$reader = new Reader();
$reader->read($data);




?>