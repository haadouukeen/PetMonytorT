<?php 
    require 'Classes.php';

    $pet = new Pet();
    $pet->Nome = "teste";
    $_SESSION["PetLocal"] = serialize($pet);

    echo '<script type="text/javascript">';
        echo 'alert("Vinculado com Sucesso");';
        echo 'window.location = "dashboard.php";';
        echo '</script>';
?>