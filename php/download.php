<?php
  include "connection.php";
  
  $cookie = isset($_COOKIE['agenda']) ? $_COOKIE['agenda'] : null;

  if($cookie == null || !validCookie($cookie)) {
      die( 'error: You are not logged in' );
  }

  $mysqli =  mysqli_connect($GLOBALS['path'], $GLOBALS['usr'], $GLOBALS['psw'], $GLOBALS['db']);

  if (isset($_GET['id'])){
    $id = $_GET['id'];

    $query = "SELECT * FROM file WHERE id = '$id'";
    $result = mysqli_query($mysqli,$query) or die('Error, query failed');
    list($id, $user_id, $file, $type, $size,$content) = mysqli_fetch_array($result);

    header("Content-type: ".$type);
    header('Content-Disposition: attachment; filename="'. $file .'"');
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Pragma: no-cache');
    header("Content-Length: ".$size);

    echo $content;

    ob_clean();
    flush();

    mysqli_close($connection);

    exit;
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
