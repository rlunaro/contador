<?php
/**
  * visitas.php 
  */
// configuration goes here
$servername = "localhost"; 
$username = "contador"; 
$password = "Voltaren75mg";
$database = "contador";
$header_content = "Location: #dest#";

// next step: get parameters
$destination_url = $_GET["dest"];

$conn = new mysqli( $servername, $username, $password, $database );

if( !$conn->connect_error ) {
  if( $destination_url == "" ) 
    $total_visits = get_total_visits( $conn );
  else
    $detailed_visits = get_detailed_visits( $conn, $destination_url ); 
}


function get_total_visits( $conn ) {
    $sql = "select destination_url, 
            totalvisits 
            from total_visits"; 
    return $conn->query( $sql ); 
}


function get_detailed_visits( $conn, $destination_url ) {
  $sql = "select date( access_date ) day, 
                 count(*) total 
            from visits
           where destination_url = '#dest#'
           group by date( access_date )"; 
  $sql = str_replace( "#dest#", 
            mysqli_real_escape_string( $conn, $destination_url ), 
            $sql ); 
  return $conn->query( $sql );
}



?>
<!doctype html>
<html lang="es">

  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Visitas</title>
    
    
  </head>

  <body>


    <div class="container-fluid">
    
      <h1>Visitas</h1>

      <div class="row justify-content-md-center">
       <div class="col col-md-8">
        <div class="mb-3">

          <?php
          if( $destination_url == "" ) {
          ?>
          
          <table class="table table-primary table-striped">
            <thead>
              <tr class="table-primary">
                <th>Destino</th>
                <th>Visitas</th>
              </tr>
            </thead>
            <tbody>
              <?php
                while( ($row = $total_visits->fetch_assoc()) ){
                  echo("<tr class=\"table-primary\">");
                  $url = "<a href=\"?dest=#url#\">#text#</a>";
                  $url = str_replace( "#url#", $row["destination_url"], $url );
                  $url = str_replace( "#text#", $row["destination_url"], $url );
                  printf( "<td class=\"table-primary\">%s</td>\n", $url );
                  printf( "<td class=\"table-primary\">%s</td>\n", $row["totalvisits"] );
                  echo("</tr>");
                }
              ?>
            </tbody>
          </table>
          
          
          <?php
          }else{
          ?>
          
          <p style='font-color: blue; font-size: 1.1em;' class='mt-3 mx-3'>
          <?=$destination_url?>
          </p>
          <table class="table table-primary table-striped">
            <thead>
              <tr class="table-primary">
                <th>Dia</th>
                <th>Visitas</th>
              </tr>
            </thead>
            <tbody>
              <?php
                while( ($row = $detailed_visits->fetch_assoc()) ){
                  echo("<tr class=\"table-primary\">");
                  printf( "<td class=\"table-primary\">%s</td>\n", $row["day"] );
                  printf( "<td class=\"table-primary\">%s</td>\n", $row["total"] );
                  echo("</tr>");
                }
              ?>
            </tbody>
          </table>
          
          <p style='font-color: blue; font-size: 1.1em;' class='mt-3 mx-3'>
          <a href="visitas.php">Todas las visitas</a>
          </p>
          
          
          <?php
          }
          ?>


        </div>
       </div>
     </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>

<?php

$conn->close();

?>








