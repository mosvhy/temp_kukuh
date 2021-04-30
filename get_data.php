<?php
header('Content-type:application/json')
$servername = "localhost";
$username = "root";
$password = "";

$connection = new mysqli($servername, $username, $password);

$tables = [
  "karyawan"  => "",
  "salary"    => "",
  "transaksi" => "",
];


if($connection->connect_error) {
  echo json_encode(['code'=>0,'msg'=>'Error Connection']);
  die("Connection failed: " . $connection->connect_error);
}else{
  $response = [
    'code'=>0,
    'msg'=>'Failed get data',
    'data'=>[]
  ];
  $dataKaryawan  = "SELECT * FROM ".$tables["karyawan"];
  $dataSalary    = "SELECT * FROM ".$tables["salary"];
  $dataTransaksi = "SELECT 
    T.Id_tran,
    T.Id_kar,
    T.Jml_Lembur,
    (T.Jml_Lembur * 35000) AS Total_Lembur,
    (Total_Lembur + S.Tunjangan + Total_Lembur) AS Total_Salary
  FROM ".$tables["transaksi"]+" T 
    LEFT JOIN "+$tables["karyawan"]+" K ON T.Id_kar = K.Id_kar
    LEFT JOIN "+$tables["salary"]+" S ON K.Grade = S.Id_gol
  ";
  $response = [
    'code'=>1,
    'msg'=>'Success get data',
    'data'=>[
      'dataKaryawan'=>$dataKaryawan,
      'dataSalary'=>$dataSalary,
      'dataTransaksi'=>$dataTransaksi
    ]
  ];
  echo json_encode($response);
}