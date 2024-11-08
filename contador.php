<?php
/**
  * contador.php 
  */

require 'config.php';
require 'common.php';

$header_content = "Location: #dest#";

// next step: get parameters
$destination_url = $_GET["dest"];

$conn = new mysqli( $servername, $username, $password, $database );

if( !$conn->connect_error ) {
    $total_visits = get_total_visits( $conn, $destination_url );
    $total_visits++;
    update_total_visits( $conn, $destination_url, $total_visits );
    register_visit( $conn, $destination_url );
    $conn->close();
}



// this function is not needed, because the 
// header function sets the status code, 
// but I prefer to set it
http_response_code( 302 );
header( str_replace( "#dest#", 
         $destination_url, 
         $header_content ) );
exit;


    

?>

