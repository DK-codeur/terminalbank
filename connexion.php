<?php

    try
        {
            $Database = new PDO('mysql: host=localhost; dbname=tbank', 'root', '');
            $Database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

    catch (PDOException $e)
        {
            die('ERREUR :'.$e->getMessage());
        }

    $Database->Exec('SET CHARACTER SET utf8');

?>