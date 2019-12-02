<?php

require "Classes.php";

$user = unserialize($_SESSION["userAtual"]);
$pet = new Pet();

$pet->Nome = $_POST["inputNome"];
$pet->Tipo = $_POST["inputTipo"];
$pet->Sexo = $_POST["inputSexo"];
$pet->DataNascimento = $_POST["inputNascimento"];

$pet->CadastrarPet($user);

$resu = $_SESSION["erroP"];

if($resu){
    echo '<script type="text/javascript">';
    echo 'alert("Pet cadastrado com sucesso.");';
    echo 'window.location = "insert-pet.php";';
    echo '</script>';
}else{
    echo '<script type="text/javascript">';
    echo 'alert("Erro no cadastro");';
    echo 'window.location = "insert-pet.php";';
    echo '</script>';
}