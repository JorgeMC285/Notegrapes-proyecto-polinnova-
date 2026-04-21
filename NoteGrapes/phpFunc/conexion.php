<?php
        $ser  = 'localhost';
        $usr  = 'root'; //El usuario 'root' no sera el que se usara, se realizara otro -J
        $pas  = '';
        $bds  ='notegrapes2'; 
    
        $conect = mysqli_connect($ser, $usr, $pas, $bds);
/*
    if ($conect) {
        echo "Si";
    }else{
        echo "no";
    }*/ 
    
?>