<?php
/**
  * crear.php 
  */
// configuration goes here
$servername = "localhost";
$database = "contador";
$username = "contador"; 
$password = "Voltaren75mg";

// next step: get parameters
$destination_url = $_POST["destination_url"];

$conn = new mysqli( $servername, $username, $password, $database ); 

$registration_result = false;
$url_registered = false;
if( !$conn->connect_error ) {
  if( $destination_url ) {
    $url_registered = url_is_registered( $conn, $destination_url );
    if( !$url_registered ){
      $registration_result = register_url( $conn, $destination_url ); 
    }
  } 
  $conn->close();
}


function url_is_registered( $conn, $destination_url ) {

    $sql = "select destination_url 
            from total_visits 
            where destination_url = '#destination_url#'";
    $sql = str_replace( "#destination_url#",
            mysqli_real_escape_string($conn, $destination_url), 
            $sql );
    $rs = $conn->query( $sql );
    if( $rs ) {
      $row = $rs->fetch_assoc(); 
      if( $row ) 
        return true; 
      else
        return false;
    }else
      return false; 
}

function register_url( $conn, $destination_url ) {

  $sql = "insert into total_visits 
        (destination_url, 
         totalvisits)
        values
        ('#dest#', 
        0 )";
  $sql = str_replace( "#dest#", 
                mysqli_real_escape_string( $conn, $destination_url ), 
                $sql ); 
  $rs = $conn->query( $sql ); 
  return $rs;
}


?>
<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<title>sample page</title>
</head>

<body>

   <div class="container-fluid">

    <div class="row">
     <div class="col">
   
      <h1>Crear contador de visitas</h1>
      
     </div>
    </div>
    <div class="row">
     <div class="col">
    
     <p>
     Introduce la dirección de destino y crearemos una 
     dirección que podrá contar las visitas. Recuerda 
     que las visitas podrás verlas en esta dirección:</p>

     </div>
    </div>
    <div class="row">
     <div class="col">
     
        <p class="text-center mx-5">
        <?php
          $schema = 'http';
          if( $_SERVER['HTTPS'] != "" )
            $schema = 'https';
          $visits_page = str_replace( "crear.php", "visitas.php", $_SERVER['REQUEST_URI'] );
        ?> 
        <input type="text" class="form-control" 
          id="visits_page" 
          value="<?=$schema."://".$_SERVER['SERVER_NAME'].$visits_page?>"
          readonly/>
       </p>
     </div>
    </div>
    <div class="row">
     <div class="col">
     
     <form method="POST">
      <div class="form-group mx-5">
        <label for="destination_url">Url:</label>
        <input type="text" class="form-control" 
              name="destination_url"
              id="destination_url"
              placeholder="Introduce la url aquí"/>
      </div>
      <div class="form-group mt-3 mx-5">
        <button type="submit" class="btn btn-primary">Crear</button>
      </div>
     </form>
   
     </div>
    </div>
    <div class="row mt-5">
     <div class="col">

      <?php
        if( $url_registered ) 
          echo( "<p style='color: red; font-size: 1.1em;' class='mx-3'>La url " . $destination_url . " ya estaba registrada</p>");
        if( $registration_result ){
          echo( "<p style='font-color: blue; font-size: 1.1em;' class='mx-3'>El registro se ha realizado con éxito</p>");

          $page = str_replace( "crear.php", "contador.php", $_SERVER['REQUEST_URI'] );
          $complete_url = $schema . "://" . $_SERVER['HTTP_HOST'] . $page . "?dest=#destination_url#";
          $complete_url = str_replace( "#destination_url#", $destination_url, $complete_url );
          $html_url = str_replace( "#url#", $complete_url, '<a href="#url#">#url#</a>' );
          echo( "<p style='font-color: blue; font-size: 1.1em;' class='mx-3'>La nueva direccion de redirección es:</p>" );
          ?>
          <input type="text" class="form-control" id="destination_url"
                 placeholder="Introduce la url aquí"
                 value="<?=$complete_url?>"/>
          <p style='font-color: blue; font-size: 1.1em;' class='mt-3 mx-3'>Puedes probarlo aquí:</p>
          <p style='font-color: blue; font-size: 1.1em;' class='mx-3'><?=$html_url?></p>
          <?php 
        }
      ?>

     </div>
    </div>

   
   </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

</body>
</html>

