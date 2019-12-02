<?php require 'Classes.php'; ?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Pet Monitor - Cadastro de rastreador</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
    <link href="signin.css" rel="stylesheet">
  </head>
  <?php $user = unserialize($_SESSION["userAtual"]); ?>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?php echo $user->Nome; ?></a>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="#">Sair</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="dashboard.php">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="insert-pet.php">
                  <span data-feather="plus"></span>
                  Cadastrar Pet
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="insert-rastreador.php">
                  <span data-feather="plus"></span>
                  Cadastrar Rastreador
                </a>
              </li>
            </ul>
          </div>
        </nav>
          
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Rastreador</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
            
          </div>
          <form class="form-insert" method="POST" action="gerarRastreador.php">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Gerar</button>
          </form>
        </main>
      </div>
      <div class="row">
        <div class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <?php 
              $user = unserialize($_SESSION["userAtual"]);
              $p1 = new Rastreador();
              $pets = $p1->ListarRastreadores($user);

              if(count($pets) > 0){
            ?>
            <table class="table table-dark">
              <thead>
                <td>
                    <b>Identificador</b>
                </td>
                <td>
                    <b>Data de Ativação</b>
                </td>
                <td>
                    <b>Data de Cadastro</b>
                </td>
                <th>
                    Vincular a um Pet
                </th>
              </thead>
              <?php foreach($pets as $pet){ ?>
                <tr>
                <td>
                     <?php echo $pet->Identificador; ?>
                    </td>
                    <td>
                        <?php echo $pet->DataAtivacao; ?>
                    </td>
                    <td>
                        <?php echo $pet->DataCadastro; ?>
                    </td>
                    <td>
                    <button onclick="showModalPopUp(<?php echo $pet->Identificador; ?>);return false;" class="btn btn-dark">Vincular</button>

                    </td>
                </tr>
            <?php } ?>
            </table>
            <?php
              }else{
                  echo '<p><b style="color:#C9FF24;">Você não possui Rastreadores gerados.</b></p>';
              }
            ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
  </body>
</html>
