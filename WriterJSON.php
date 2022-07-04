<?php

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

?>