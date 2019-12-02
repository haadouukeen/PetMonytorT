<?php
    require 'Classes.php';

    $cpf = $_POST['CPF'];
    $nome = $_POST['Nome'];
    $dataNascimento = $_POST['DataNascimento'];
    $endereco = $_POST['Endereco'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $tutor = new Tutor();
    $tutor->CPF = $cpf;
    $tutor->Nome = $nome;
    $tutor->DataNascimento = $dataNascimento;
    $tutor->Endereco = $endereco;
    $tutor->Login = $email;
    $tutor->Senha = $pass;

    $tutor->CadastrarTutor();

    $resu = $_SESSION["erroT"];

    if($resu === true){
        echo '<script type="text/javascript">';
        echo 'alert("Cadastrado com sucesso.");';
        echo 'window.location = "sign-up.html";';
        echo '</script>';
    }else{
        echo '<script type="text/javascript">';
        echo 'alert("Erro no cadastrado.");';
        echo 'window.location = "sign-up.html";';
        echo '</script>';
    }
?>