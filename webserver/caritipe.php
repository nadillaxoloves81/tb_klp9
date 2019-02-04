<?php
include ('config.php');
$dataarray=array();

$sql=pg_query("select * from jenis_fasilitas");
			
while($row = pg_fetch_array($sql))
	{
		  $data=$row['tipe'];
		  $dataarray[]=$data;
	}
echo json_encode ($dataarray);
   

					  
?>