<?php
  include "connection.php";

  checkLogin();

  $cookie_name = "agenda";
  $cookieValue = createCookieValue(256);
  $key = "b91a25e358ab4ac402fa85466bc64216629d5a7a91f21c5075194c265e21e02b";

  $encryptedCookieValue = encrypt($cookieValue, $key);

  setcookie($cookie_name, $encryptedCookieValue, time() + (3600), '/');

  echo "ok";

  function createCookieValue($len){
    $value = '';

    for($i = 0; $i < $len; $i++){
      $value .= rand(0, 9);
    }

    return $value;
  };

  function encrypt($string, $key) {
  	$result = '';

  	for($i=0, $k= strlen($string); $i<$k; $i++) {
  		$char = substr($string, $i, 1);
  		$keychar = substr($key, ($i % strlen($key))-1, 1);
  		$char = chr(ord($char)+ord($keychar));
  		$result .= $char;
  	}
  	return base64_encode($result);
  }

  function checkLogin() {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
       $mysqli =  mysqli_connect($GLOBALS['path'], $GLOBALS['usr'], $GLOBALS['psw'], $GLOBALS['db']);

       if ($mysqli->connect_errno) {
           echo "Connect failed: %s\n", $mysqli->connect_error;
           exit();
       }

       $myusername = $_POST['username'];
       $mypassword = $_POST['password'];
       $encryptedmypassword = md5($mypassword);

       $sql = "SELECT id FROM login WHERE user = '$myusername' and password = '$encryptedmypassword'";
       $result = mysqli_query($mysqli,$sql);
       $count = mysqli_num_rows($result);

       if(!$count == 1) {
          $error = "Your Login Name or Password is invalid";
          die($error) ;
       }
     }
   }


 ?>
