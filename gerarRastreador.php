<?php
require 'Classes.php';

$user = unserialize($_SESSION["userAtual"]);

$r1 = new Rastreador();
$r1->DataAtivacao = "0000/00/00";

$r1->CadastrarRastreador($user);

$resu = $_SESSION["erroR"];

if($resu){
    echo '<script type="text/javascript">';
    echo 'alert("Rastreador Gerado com sucesso.");';
    echo 'window.location = "insert-rastreador.php";';
    echo '</script>';
}else{
    echo '<script type="text/javascript">';
    echo 'alert("Erro no cadastro");';
    echo 'window.location = "insert-rastreador.php";';
    echo '</script>';
}