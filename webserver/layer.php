<?php
include("config.php");
$sql = "select ST_asgeojson(the_geom) AS geometry, id,nama,alamat,image,id_jenis,pemilik,pegawai,kulkas,etalase,meja_kasir,meja_luar,mesin_kasir FROM data";
$result = pg_query($sql);
$hasil = array(
	'type'	=> 'FeatureCollection',
	'features' => array()
	);

while ($isinya = pg_fetch_assoc($result)) {
	$features = array(
		'type' => 'Feature',
		'geometry' => json_decode($isinya['geometry']),
		'properties' => array(
			'id' => $isinya['id'],
			'nama' => $isinya['nama'],
			'alamat' => $isinya['alamat'],
			'pemilik' => $isinya['pemilik'],
			'pegawai' => $isinya['pegawai'],
			'kulkas' => $isinya['kulkas'],
			'etalase' => $isinya['etalase'],
			'meja_kasir' => $isinya['meja_kasir'],
			'meja_luar' => $isinya['meja_luar'],
			'mesin_kasir' => $isinya['mesin_kasir']
			)
		);
	array_push($hasil['features'], $features);
}
echo json_encode($hasil);
?>