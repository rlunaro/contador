<?php


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

function get_total_visits( $conn, $destination_url="" ) {
    if( $destination_url == "" ){
        $sql = "select destination_url, 
                totalvisits 
                from total_visits"; 
        return $conn->query( $sql ); 
    }else{
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