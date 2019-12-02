<?php 
    require 'Classes.php';

    $petid = $_POST["inputIdPet"];
    $pet = unserialize($_SESSION["Pet".$petid]);

    $local = $pet->LocalizarPet($pet);

    if(!$local){
        echo '<script type="text/javascript">';
        echo 'alert("Pet não esta vinculado a um Rastreador.");';
        echo 'window.location = "insert-pet.php";';
        echo '</script>';
    }

    $_SESSION["PetLocal"] = serialize($local);

    echo '<script type="text/javascript">';
    echo 'window.location = "dashboard.php";';
    echo '</script>';
?>