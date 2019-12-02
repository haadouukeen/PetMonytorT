<?php
    require 'Classes.php';
    $tutor = new Tutor();
    $tutor->Login = $_POST['login'];
    $tutor->Senha = $_POST['pass'];
    $_SESSION["userAtual"] = null;
    $_SESSION["erroT"] = null;
    $resu = $tutor->FazerLogin();

    if(!$resu){
        echo '<script type="text/javascript">';
        echo 'alert("Erro ao logar. Verifique seu Login/Senha");';
        echo 'window.location = "login.html";';
        echo '</script>';
    }else{
        echo '<script type="text/javascript">';
        echo 'alert("Bem vindo");';
        echo 'window.location = "dashboard.php";';
        echo '</script>';
    }
    
    
?>