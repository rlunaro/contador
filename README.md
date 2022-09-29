# Contador: simple page for count visits to a third url 

A php page for count visits to a QR and redirect to an url afterwards. 

I've created these three pages to help people to create 
url's for track the visits to a QR page for instance. 

## Creating the database

These pages use a database. To create the necessary tables, 
you can do for instance: 


	create database contador; 

	create user contador; 

	grant alter, create, delete, drop, index, lock tables, select, update, insert on
	contador.* to contador@'%';

	alter user contador identified by 'THE-PASSWORD-HERE'; 

	create table total_visits
	( destination_url  mediumtext, 
	  totalvisits bigint );

	create table visits 
	( destination_url  mediumtext, 
	  access_date  timestamp ); 

