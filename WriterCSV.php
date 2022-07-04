<?php

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

?>