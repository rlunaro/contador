<?php
/**
  * contador.php 
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


function get_total_visits( $conn, $destination_url ) {
    $sql = "select totalvisits 
            from total_visits
            where destination_url = '#dest#'"; 
    $sql = str_replace( "#dest#", 
            mysqli_real_escape_string( $conn, $destination_url ), 
            $sql ); 
    $rs = $conn->query( $sql ); 
    $row = $rs->fetch_assoc();
    if( $row ){
        return $row["totalvisits"];
    }else
        return 0;
}

function update_total_visits( $conn, $destination_url, $total_visits ) {
    $sql = "update total_visits 
        set totalvisits = #totalvisits#
        where destination_url = '#dest#'"; 
    $sql = str_replace( "#totalvisits#", 
                        mysqli_real_escape_string( $conn, $total_visits ), $sql ); 
    $sql = str_replace( "#dest#", 
                        mysqli_real_escape_string( $conn, $destination_url ), $sql );
    $conn->query( $sql );
}
    

function register_visit( $conn, $destination_url ) {
    $sql = "insert into visits 
            (destination_url, 
             access_date)
            values
            ('#destination_url#', 
             current_timestamp() )"; 
    $sql = str_replace( "#destination_url#", 
                        mysqli_real_escape_string( $conn, $destination_url ), 
                        $sql ); 
    $conn->query( $sql );  
}

?>