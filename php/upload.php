<?php
    include "connection.php";
    
    $cookie = isset($_COOKIE['agenda']) ? $_COOKIE['agenda'] : null;

    if($cookie == null || !validCookie($cookie)) {
        die( 'error: You are not logged in' );
    }

    $mysqli = mysqli_connect($GLOBALS['path'], $GLOBALS['usr'], $GLOBALS['psw'], $GLOBALS['db']);

    if(isset($_REQUEST['utente_id'])){
      $nome_file_temporaneo = $_FILES['file_inviato']['tmp_name'];
    	$nome_file_vero = $_FILES['file_inviato']['name'];
    	$tipo_file = $_FILES['file_inviato']['type'];
      $size_file = $_FILES['file_inviato']['size'];
      $utente_id = $_REQUEST['utente_id'];

    	$dati_file = file_get_contents($nome_file_temporaneo);
      $dati_null = NULL ;

    	$stmt = $mysqli->prepare("INSERT INTO file (utente_id, nome, tipo, size, dati) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("issib", $utente_id, $nome_file_vero, $tipo_file, $size_file, $dati_file);
      $stmt->send_long_data(4, $dati_file);
      $stmt->execute();

      echo "ok";
    }else{
      die('-');
    }

    function validCookie($cookieValue){
      $key = 'b91a25e358ab4ac402fa85466bc64216629d5a7a91f21c5075194c265e21e02b';
      $decryptedCookie = decrypt($cookieValue, $key);

      if(is_numeric($decryptedCookie) && strlen($decryptedCookie) == 256) {
        return true;
      } else {
        return false;
      }
    }

    function decrypt($string, $key) {
      $result = '';
      $string = base64_decode($string);
      for($i=0,$k=strlen($string); $i< $k ; $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
      }
      return $result;
    }
?>
