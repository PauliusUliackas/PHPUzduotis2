<?php

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

?>