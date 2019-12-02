<?php

require 'Conexao.php';

session_start();

class Tutor{

    public $CPF;
    public $DataNascimento;
    public $Endereco;
    public $Nome;
    public $Login;
    public $Senha;

    public function CadastrarTutor(){

        $c1 = new Conexao();
        $c1->Open();

        $stmt = $c1->conn->prepare("insert into Tutor(CPF,Login,Senha,Nome,DataNascimento,Endereco)values(?,?,?,?,?,?)");

        if (!$stmt) {
            $_SESSION["erroT"] = $c1->conn->error;
        }else{
            $stmt->bind_param('isssss',$this->CPF,$this->Login,$this->Senha,$this->Nome,$this->DataNascimento,$this->Endereco);
            $stmt->execute();

            if($stmt->error){
                $_SESSION["erroT"] = $stmt->error;
            }else{
                $_SESSION["erroT"] = true;
            }
        }

        $stmt->close();
        $c1->conn->Close();
    }

    private function AutenticarUsuario($login,$senha){
        $c1 = new Conexao();
        $c1->Open();
        $loginU = strtoupper($login);

        $sql = "SELECT * FROM Tutor WHERE UPPER(Login) like ?";
        $stmt = $c1->conn->prepare($sql);
        $stmt->bind_param('s',$loginU);
        $stmt->execute();

        if($stmt->error){
            $_SESSION["erroT"] = $stmt->error;
            $stmt->close();
            $c1->conn->Close();
            exit();
        }else{
            $_SESSION["erroT"] = "";
        }

        $result = $stmt->get_result();
        $sucesso = false;

        while($row = $result->fetch_assoc()) {
            if($row["Login"] == $login){
                if($row["Senha"] == $senha){

                    $ta = new Tutor();
                    $ta->CPF = $row["CPF"];
                    $ta->Login = $row["Login"];
                    $ta->Nome = $row["Nome"];
                    $ta->DataNascimento = $row["DataNascimento"];
                    $ta->Endereco = $row["Endereco"];
                    $ta->Senha = "";

                    $_SESSION["userAtual"] = serialize($ta);
                    $sucesso = true;
                }
            }
        }

        $c1->conn->Close();
        $stmt->close();
        return $sucesso;
    }

    public function FazerLogin(){
        return $this->AutenticarUsuario($this->Login,$this->Senha);
    }
}

class Rastreador{
    public $DataCadastro;
    public $DataAtivacao;
    public $Identificador;
    public $Cpf_tutor;

    public function CadastrarRastreador(Tutor $tutor){
        $c1 = new Conexao();
        $c1->Open();

        $stmt = $c1->conn->prepare("insert into Rastreador(DataCadastro,DataAtivacao,CPF_Tutor)values(NOW(),?,?)");

        if (!$stmt) {
            $_SESSION["erroR"] = $c1->conn->error;
        }else{
            $stmt->bind_param('si',$this->DataAtivacao,$tutor->CPF);
            $stmt->execute();

            if($stmt->error){
                $_SESSION["erroR"] = $stmt->error;
            }else{
                $_SESSION["erroR"] = true;
            }
        }

        $stmt->close();
        $c1->conn->Close();
    }

    public function VincularPet(Rastreador $r,Pet $pet,$georeferencia){
        $c1 = new Conexao();
        $c1->Open();

        $sql = "SELECT * FROM Pet_Rastreador WHERE IdRastreador = ?";
        $sql2 = "SELECT * FROM Pet_Rastreador WHERE IdPet = ?";

        //verifica rastreador
        $stmt = $c1->conn->prepare($sql);
        $stmt->bind_param('i',$r->Identificador);
        $stmt->execute();
        if($stmt->error){
            $_SESSION["erroR"] = $stmt->error;
            $stmt->close();
            $c1->conn->Close();
            exit();
        }else{
            $_SESSION["erroR"] = "";
        }
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $stmt->close();
            $c1->conn->Close();
            return "Este rastreador ja esta ativo com outro Pet.";
        }

        //verifica pet
        $stmt2 = $c1->conn->prepare($sql2);
        $stmt2->bind_param('i',$pet->IdPet);
        $stmt2->execute();
        if($stmt2->error){
            $_SESSION["erroR"] = $stmt2->error;
            $stmt2->close();
            $c1->conn->Close();
            exit();
        }else{
            $_SESSION["erroR"] = "";
        }
        $result2 = $stmt2->get_result();

        if($result2->num_rows > 0){
            $stmt2->close();
            $c1->conn->Close();
            return "Este Pet ja esta ativo com outro Rastreador.";
        }

        //cria vinculo
        $stmt3 = $c1->conn->prepare("insert into Pet_Rastreador(IdRastreador,IdPet,DataHora,Georeferencia)values(?,?,NOW(),?)");

        if (!$stmt3) {
            $_SESSION["erroR"] = $c1->conn->error;
        }else{
            $stmt3->bind_param('iis',$r->Identificador,$pet->idpet,$georeferencia);
            $stmt3->execute();

            if($stmt3->error){
                $_SESSION["erroR"] = $stmt3->error;
            }else{
                $stmt3->close();
                $c1->conn->Close();
                $_SESSION["erroR"] = "";
                return true;
            }
        }

        $stmt->close();
        $stmt2->close();
        $stmt3->close();
        $c1->conn->Close();
    }

    public function ListarRastreadores(Tutor $tutor){
        $c1 = new Conexao();
        $c1->Open();

        $sql = "SELECT * FROM Rastreador WHERE CPF_Tutor = ?";

        $stmt = $c1->conn->prepare($sql);
        $stmt->bind_param('i',$tutor->CPF);
        $stmt->execute();
        if($stmt->error){
            $_SESSION["erroR"] = $stmt->error;
            $stmt->close();
            $c1->conn->Close();
            exit();
        }else{
            $_SESSION["erroR"] = "";
        }
        $result = $stmt->get_result();

        $arr = [];

        while($row = $result->fetch_assoc()){
            $r1 = new Rastreador();
            $r1->Identificador = $row["Identificador"];
            $r1->DataCadastro = $row["DataCadastro"];
            $r1->DataAtivacao = $row["DataAtivacao"];
            $r1->CPF_Tutor = $row["CPF_Tutor"];

            $arr[] = $r1;
        }

        return $arr;

        $stmt->close();
        $c1->conn->Close();
    }
}

class Pet_Rastreador{
    public $IdRastreador;
    public $IdPet;
    public $Identificador;
    public $DataHora;
    public $Georeferencia;
}

class Pet{
    public $IdPet;
    public $Nome;
    public $Tipo;
    public $DataNascimento;
    public $Sexo;
    public $CPF_Tutor;

    public function CadastrarPet(Tutor $tutor){
        $c1 = new Conexao();
        $c1->Open();

        $stmt = $c1->conn->prepare("insert into Pet(Nome,Tipo,DataNascimento,Sexo,CPF_Tutor)values(?,?,?,?,?)");

        if (!$stmt) {
            $_SESSION["erroP"] = $c1->conn->error;
        }else{
            $stmt->bind_param('ssssi',$this->Nome,$this->Tipo,$this->DataNascimento,$this->Sexo,$tutor->CPF);
            $stmt->execute();

            if($stmt->error){
                $_SESSION["erroP"] = $stmt->error;
            }else{
                $_SESSION["erroP"] = true;
            }
        }

        $stmt->close();
        $c1->conn->Close();
    }

    public function LocalizarPet(Pet $pet){
        $c1 = new Conexao();
        $c1->Open();

        $sql = "SELECT * FROM Pet_Rastreador WHERE IdPet = ?";

        $stmt = $c1->conn->prepare($sql);
        $stmt->bind_param('i',$pet->IdPet);
        $stmt->execute();
        if($stmt->error){
            $_SESSION["erroP"] = $stmt->error;
            $stmt->close();
            $c1->conn->Close();
            exit();
        }

        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $stmt->close();
            $c1->conn->Close();
            
            $pr = new Pet_Rastreador();

            while($row = $result->fetch_assoc()){
                $pr->IdRastreador = $row["IdRastreador"];
                $pr->IdPet = $row["IdPet"];
                $pr->Identificador = $row["Identificador"];
                $pr->DataHora = $row["DataHora"];
                $pr->Georeferencia = $row["Georeferencia"];
            }

            return $pr;

        }else{
            $stmt->close();
            $c1->conn->Close();
            return false;
        }
    }

    public function ListarPets(Tutor $tutor){
        $c1 = new Conexao();
        $c1->Open();

        $sql = "SELECT * FROM Pet WHERE CPF_Tutor = ?";

        $stmt = $c1->conn->prepare($sql);
        $stmt->bind_param('i',$tutor->CPF);
        $stmt->execute();
        if($stmt->error){
            $_SESSION["erroP"] = $stmt->error;
            $stmt->close();
            $c1->conn->Close();
            exit();
        }else{
            $_SESSION["erroP"] = "";
        }
        $result = $stmt->get_result();

        $arr = [];

        while($row = $result->fetch_assoc()){
            $p = new Pet();
            $p->IdPet = $row["IdPet"];
            $p->Nome = $row["Nome"];
            $p->Tipo = $row["Tipo"];
            $p->DataNascimento = $row["DataNascimento"];
            $p->Sexo = $row["Sexo"];
            $p->CPF_Tutor = $row["CPF_Tutor"];

            $arr[] = $p;
        }

        return $arr;

        $stmt->close();
        $c1->conn->Close();
    }
}