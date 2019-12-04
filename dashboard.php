<?php require "Classes.php"; ?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="gmaps/gmaps.js"></script>
    <script type="text/javascript">
      var map;
      $(document).ready(function(){
        map = new GMaps({
          el: '#map',
          lat: -19.9230159,
          lng: -43.9414548,
          click: function(e){
            console.log(e);
          }
        });
        path = [[-19.925429, -43.939445], [-19.925470, -43.939301],[-19.925530, -43.939129],[-19.925598, -43.938936],
        [-19.925638, -43.938764],[-19.925648, -43.938625],[-19.925658, -43.938496],[-19.925698, -43.938346],
        [-19.925748, -43.938196],[-19.925778, -43.938035],[-19.925798, -43.937885],[-19.925879, -43.937713],
        [-19.925798, -43.937520],[-19.925798, -43.937295],[-19.925717, -43.937198],[-19.925646, -43.937069],
        [-19.925565, -43.936951],[-19.925464, -43.936833],[-19.925414, -43.936704],[-19.925343, -43.936586],
        [-19.925252, -43.936468],[-19.925191, -43.936382],[-19.925158, -43.936192],[-19.925103, -43.936172],
        [-19.925012, -43.936070],[-19.924977, -43.935968],[-19.924937, -43.935888],[-19.924917, -43.935802],
        [-19.924851, -43.935722],[-19.924826, -43.935636],[-19.924765, -43.935572],[-19.924730, -43.935481],
        [-19.924685, -43.935411],[-19.924650, -43.935325],[-19.924605, -43.935234],[-19.924605, -43.935121],
        [-19.924605, -43.935121]];
        map.drawPolyline({
          path: path,
          strokeColor: '#131540',
          strokeOpacity: 0.6,
          strokeWeight: 6
        });
      });
      </script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>

  <body>
      <?php
      
        if(empty($_SESSION["userAtual"])){
          echo '<script type="text/javascript">';
          echo 'alert("Usuario não logado.");';
          echo 'window.location = "sign-up.html";';
          echo '</script>';
        }

        $logado = unserialize($_SESSION["userAtual"]); 

      ?>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?php echo $logado->Nome; ?></a>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="logout.php">Sair</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="insert-pet.php">
                  <span data-feather="plus"></span>
                  Adicionar Pet
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="insert-rastreador.php">
                  <span data-feather="plus"></span>
                  Adicionar Rastreador
                </a>
              </li>
            </ul>
          </div>
        </nav>
        
        <script>
      
              function initMap() {
              var map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(-19.9235257,-43.9358465),
                zoom: 12
                });
              

              var infoWindow = new google.maps.InfoWindow;
      
                // Change this depending on the name of your PHP or XML file
                downloadUrl('result.php', function(data) {
                  var xml = data.responseXML;
                  var markers = xml.documentElement.getElementsByTagName('marker');
                  Array.prototype.forEach.call(markers, function(markerElem) {
                    var id = markerElem.getAttribute('id');
                    var name = markerElem.getAttribute('name');
                    var address = markerElem.getAttribute('address');
                    var type = markerElem.getAttribute('type');
                    var point = new google.maps.LatLng(
                        parseFloat(markerElem.getAttribute('lat')),
                        parseFloat(markerElem.getAttribute('lng')));
      
                    var infowincontent = document.createElement('div');
                    var strong = document.createElement('strong');
                    strong.textContent = name
                    infowincontent.appendChild(strong);
                    infowincontent.appendChild(document.createElement('br'));
      
                    var text = document.createElement('text');
                    text.textContent = address
                    infowincontent.appendChild(text);
                    var icon = customLabel[type] || {};
                    var marker = new google.maps.Marker({
                      map: map,
                      position: point,
                      label: icon.label
                    });
                    marker.addListener('click', function() {
                      infoWindow.setContent(infowincontent);
                      infoWindow.open(map, marker);
                    });
                  });
                });
              }

            function downloadUrl(url, callback) {
              var request = window.ActiveXObject ?
                  new ActiveXObject('Microsoft.XMLHTTP') :
                  new XMLHttpRequest;
      
              request.onreadystatechange = function() {
                if (request.readyState == 4) {
                  request.onreadystatechange = doNothing;
                  callback(request, request.status);
                }
              };
      
              request.open('GET', url, true);
              request.send(null);
            }
      
            function doNothing() {}
          </script>
          <script async defer
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUQA2oFffBAAqRXz0-JXLf0Gye5FvtutE&callback=initMap">
          </script>
          
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
          </div>
          
        </main>
      </div>
      
      <div class="row">
        <div class="col-md-9 ml-sm-auto col-lg-10 px-4">

          <?php 
            if(empty($_SESSION["PetLocal"])){
              echo '<h3>Pet não foi Selecionado</h3>';
            }else{
              echo '<div id="map"></div>';
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
