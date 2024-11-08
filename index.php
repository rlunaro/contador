<html>
 
<body>
 
 
<p>
This is your user agent: 
<?php
echo $_SERVER['HTTP_USER_AGENT']; 
?>
</p>
 
<p>
Today is: 
<?php echo( date( 'd/m/Y H:i:s' ) ); ?>
</p>
 
<p>
Current php version: <?php echo(phpversion()); ?>
</p>
 
 
<p>
Mysql connection test:
<?php
# $mysqli = new mysqli('localhost', 'joseluisluna', 'PUT-HERE-THE-PASSWORD', 'joseluisluna');
 
#if( $mysqli->connect_errno) {
#    echo("<b>Connection failed</b><br>");
#    echo("Errno: " . $mysqli->connect_errno . "\n"); 
#    echo("Error: " . $mysqli->connect_error . "\n");  
#} else {
#    if($mysqli->query('show variables like \'%version%\'')){
#        echo("<b>OK</b>");
#    }else{
#        echo("<b>Error in the query</b>");
#    }    
#}
?>
</p>
 
</body>
 
</html>


