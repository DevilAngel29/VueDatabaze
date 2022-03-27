<?php
$conn = new mysqli("localhost", "root","","zakaznickadatabaze");
if($conn->connect_error){
    die("Connection Failed!" .$conn->connect_error);
}

$result = array('error'=>false);
$action = '';

if(isset($_GET['action'])){
    $action = $_GET['action'];
}

if($action == 'read'){
    $sql = $conn->query("SELECT * FROM users");
    $users = array();
    while($row = $sql->fetch_assoc()){
        array_push($users, $row);
    }
    $result['users'] = $users;
}

if($action == 'create'){
    $jmeno = $_POST['jmeno'];
    $prijmeni = $_POST['prijmeni'];
    $adresa = $_POST['adresa'];

    $sql = $conn->query("INSERT INTO users (jmeno, prijmeni,adresa) VALUES('$jmeno', '$prijmeni', '$adresa')");

   if($sql) {
       $result['message'] ="Zakaznik uspesne pridan!";
   }
   else{
       $result['error'] = true;
       $result['message'] = "Nelze pridat zakaznika!";
   }
}

if($action == 'update'){
    $id = $_POST['id'];
    $jmeno = $_POST['jmeno'];
    $prijmeni = $_POST['prijmeni'];
    $adresa = $_POST['adresa'];

    $sql = $conn->query("UPDATE users SET jmeno='$jmeno', prijmeni='$prijmeni', adresa='$adresa' WHERE id='$id'");

   if($sql) {
       $result['message'] ="Zakaznik uspesne upraven!";
   }
   else{
       $result['error'] = true;
       $result['message'] = "Nelze upravit zakaznika!";
   }
}

if($action == 'delete'){
    $id = $_POST['id'];

    $sql = $conn->query("DELETE FROM users WHERE id='$id'");

   if($sql) {
       $result['message'] ="Zakaznik uspesne smazan!";
   }
   else{
       $result['error'] = true;
       $result['message'] = "Nelze smazat zakaznika!";
   }
}

$conn->close();
echo json_encode($result);
?>