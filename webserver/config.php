<?php
$host="localhost";
$user="postgres";
$password="root";
$port="5432";
$dbname="tb_gis_kel9";
$ttd='0b5ba19ad3f77462b202e1088b6e9081';
 
$link= pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$password) or die("Koneksi gagal");
?>