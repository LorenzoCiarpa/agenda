<?php
    include "connection.php";

    header('Content-Type: application/json');

    $cookie = isset($_COOKIE['agenda']) ? $_COOKIE['agenda'] : null;

    if($cookie == null || !validCookie($cookie)) {
        die( 'error: You are not logged in' );
    }

    $mysqli = mysqli_connect($GLOBALS['path'], $GLOBALS['usr'], $GLOBALS['psw'], $GLOBALS['db']);

    if ($mysqli->connect_errno) {
        echo "Connect failed: %s\n", $mysqli->connect_error;
        exit();
    }
    $command = $_GET['command'];

    switch( $command ){

        case 'getUsers':

            echo getUsers($mysqli, $_GET['gruppo_id']);

            break;

        case 'getUser':

            echo getUser($mysqli, $_GET['utente_id']);

            break;

        case 'getGroups':

            echo getGroups($mysqli);

            break;

        case 'getNextDates':

            echo getNextDates($mysqli);

            break;

        case 'getDatesFullcalendar':

            $start = isset( $_GET['start'] ) ? $_GET['start'] : null;
            $end = isset( $_GET['end'] ) ? $_GET['end'] : null;

            echo getDatesFullcalendar($mysqli, $start, $end);

            break;

        case 'getClaims':

            $sinistro_utente_id = isset( $_GET['utente_id'] ) ? $_GET['utente_id'] : null;

            echo getClaims($mysqli, $sinistro_utente_id);

            break;

        case 'getActiveClaims':

            echo getActiveClaims($mysqli);

            break;

        case 'getUnactiveClaims':

            echo getUnactiveClaims($mysqli);

            break;

        case 'getFiles':

            $file_utente_id = isset( $_GET['utente_id'] ) ? $_GET['utente_id'] : null;

            echo getFiles($mysqli, $file_utente_id);

            break;

        case 'setUser':

            $gruppo_id = isset( $_GET['gruppo_id'] ) ? $_GET['gruppo_id'] : null;
            $user_nome = isset( $_GET['user_nome'] ) ? $_GET['user_nome'] : null;
            $user_cognome = isset( $_GET['user_cognome'] ) ? $_GET['user_cognome'] : null;
            $user_luogo_residenza = isset( $_GET['user_luogo_residenza'] ) ? $_GET['user_luogo_residenza'] : null;
            $user_data_nascita = isset( $_GET['user_data_nascita'] ) ? $_GET['user_data_nascita'] : null;
            $user_descrizione = isset( $_GET['user_descrizione'] ) ? $_GET['user_descrizione'] : null;
            $user_numero_telefono = isset( $_GET['user_numero_telefono'] ) ? $_GET['user_numero_telefono'] : null;
            $user_mail = isset( $_GET['user_mail'] ) ? $_GET['user_mail'] : null;

            echo setUser($mysqli, $gruppo_id, $user_nome, $user_cognome, $user_luogo_residenza, $user_data_nascita, $user_descrizione, $user_numero_telefono, $user_mail);

            break;

        case 'setGroup':

            $gruppo_nome = isset( $_GET['gruppo_nome'] ) ? $_GET['gruppo_nome'] : null;

            echo setGroup($mysqli, $gruppo_nome);

            break;

        case 'setDate':

            $appuntamento_utente_id = isset( $_GET['appuntamento_utente_id'] ) ? $_GET['appuntamento_utente_id'] : null;
            $appuntamento_datetime = isset( $_GET['appuntamento_datetime'] ) ? $_GET['appuntamento_datetime'] : null;
            $appuntamento_luogo = isset( $_GET['appuntamento_luogo'] ) ? $_GET['appuntamento_luogo'] : null;
            $appuntamento_descrizione = isset( $_GET['appuntamento_descrizione'] ) ? $_GET['appuntamento_descrizione'] : null;

            echo setDate($mysqli, $appuntamento_utente_id, $appuntamento_datetime, $appuntamento_luogo, $appuntamento_descrizione);

            break;

        case 'setClaim':

            $sinistro_utente_id = isset( $_GET['sinistro_utente_id'] ) ? $_GET['sinistro_utente_id'] : null;

            $sinistro_data = isset( $_GET['sinistro_data'] ) ? $_GET['sinistro_data'] : null;
            $sinistro_luogo = isset( $_GET['sinistro_luogo'] ) ? $_GET['sinistro_luogo'] : null;
            $sinistro_compagnia_utente = isset( $_GET['sinistro_compagnia_utente'] ) ? $_GET['sinistro_compagnia_utente'] : null;
            $sinistro_compagnia_controparte = isset( $_GET['sinistro_compagnia_controparte'] ) ? $_GET['sinistro_compagnia_controparte'] : null;
            $sinistro_diagnosi = isset( $_GET['sinistro_diagnosi'] ) ? $_GET['sinistro_diagnosi'] : null;

            $sinistro_fisici_visite = isset( $_GET['sinistro_fisici_visite'] ) ? $_GET['sinistro_fisici_visite'] : null;
            $sinistro_fisici_esami = isset( $_GET['sinistro_fisici_esami'] ) ? $_GET['sinistro_fisici_esami'] : null;
            $sinistro_fisici_certificazione = isset( $_GET['sinistro_fisici_certificazione'] ) ? $_GET['sinistro_fisici_certificazione'] : null;
            $sinistro_fisici_parte = isset( $_GET['sinistro_fisici_parte'] ) ? $_GET['sinistro_fisici_parte'] : null;
            $sinistro_fisici_controparte = isset( $_GET['sinistro_fisici_controparte'] ) ? $_GET['sinistro_fisici_controparte'] : null;

            $sinistro_materiali_preventivo = isset( $_GET['sinistro_materiali_preventivo'] ) ? $_GET['sinistro_materiali_preventivo'] : null;
            $sinistro_materiali_perizia = isset( $_GET['sinistro_materiali_perizia'] ) ? $_GET['sinistro_materiali_perizia'] : null;
            $sinistro_materiali_liquidazione = isset( $_GET['sinistro_materiali_liquidazione'] ) ? $_GET['sinistro_materiali_liquidazione'] : null;

            $sinistro_attivo  = isset( $_GET['sinistro_attivo'] ) ? $_GET['sinistro_attivo'] : null;

            echo setClaim(
              $mysqli, $sinistro_utente_id,
              $sinistro_data, $sinistro_luogo, $sinistro_compagnia_utente, $sinistro_compagnia_controparte, $sinistro_diagnosi,
              $sinistro_fisici_visite, $sinistro_fisici_esami, $sinistro_fisici_certificazione,
              $sinistro_fisici_parte, $sinistro_fisici_controparte,
              $sinistro_materiali_preventivo, $sinistro_materiali_perizia, $sinistro_materiali_liquidazione,
              $sinistro_attivo
            );

            break;

        case 'setFile':

            $nome_file_temporaneo = $_FILES['file_inviato']['tmp_name'];
            $nome_file_vero = $_FILES['file_inviato']['name'];
            $tipo_file = $_FILES['file_inviato']['type'];

            echo setFile($mysqli, $nome_file_temporaneo, $nome_file_vero, $tipo_file);

            break;

         case 'updateDate':

            $appuntamento_id = isset( $_GET['appuntamento_id'] ) ? $_GET['appuntamento_id'] : null;
            $appuntamento_datetime = isset( $_GET['appuntamento_datetime'] ) ? $_GET['appuntamento_datetime'] : null;
            $appuntamento_luogo = isset( $_GET['appuntamento_luogo'] ) ? $_GET['appuntamento_luogo'] : null;
            $appuntamento_descrizione = isset( $_GET['appuntamento_descrizione'] ) ? $_GET['appuntamento_descrizione'] : null;

            updateDate($mysqli, $appuntamento_id, $appuntamento_datetime, $appuntamento_luogo, $appuntamento_descrizione);

            break;

         case 'updateUser':

            $utente_id = isset( $_GET['utente_id'] ) ? $_GET['utente_id'] : null;
            $update_nome = isset( $_GET['user_nome'] ) ? $_GET['user_nome'] : null;
            $update_cognome = isset( $_GET['user_cognome'] ) ? $_GET['user_cognome'] : null;
            $update_luogo_residenza = isset( $_GET['user_luogo_residenza'] ) ? $_GET['user_luogo_residenza'] : null;
            $update_data_nascita = isset( $_GET['user_data_nascita'] ) ? $_GET['user_data_nascita'] : null;
            $update_descrizione = isset( $_GET['user_descrizione'] ) ? $_GET['user_descrizione'] : null;
            $update_numero_telefono = isset( $_GET['user_numero_telefono'] ) ? $_GET['user_numero_telefono'] : null;
            $update_mail = isset( $_GET['user_mail'] ) ? $_GET['user_mail'] : null;

            updateUser($mysqli, $update_nome, $update_cognome, $update_luogo_residenza, $update_data_nascita, $update_descrizione, $update_numero_telefono, $update_mail, $utente_id);

            break;


         case 'updateClaim':

             $sinistro_id = isset( $_GET['sinistro_id'] ) ? $_GET['sinistro_id'] : null;

             $sinistro_data = isset( $_GET['sinistro_data'] ) ? $_GET['sinistro_data'] : null;
             $sinistro_luogo = isset( $_GET['sinistro_luogo'] ) ? $_GET['sinistro_luogo'] : null;
             $sinistro_compagnia_utente = isset( $_GET['sinistro_compagnia_utente'] ) ? $_GET['sinistro_compagnia_utente'] : null;
             $sinistro_compagnia_controparte = isset( $_GET['sinistro_compagnia_controparte'] ) ? $_GET['sinistro_compagnia_controparte'] : null;
             $sinistro_diagnosi = isset( $_GET['sinistro_diagnosi'] ) ? $_GET['sinistro_diagnosi'] : null;

             $sinistro_fisici_visite = isset( $_GET['sinistro_fisici_visite'] ) ? $_GET['sinistro_fisici_visite'] : null;
             $sinistro_fisici_esami = isset( $_GET['sinistro_fisici_esami'] ) ? $_GET['sinistro_fisici_esami'] : null;
             $sinistro_fisici_certificazione = isset( $_GET['sinistro_fisici_certificazione'] ) ? $_GET['sinistro_fisici_certificazione'] : null;
             $sinistro_fisici_parte = isset( $_GET['sinistro_fisici_parte'] ) ? $_GET['sinistro_fisici_parte'] : null;
             $sinistro_fisici_controparte = isset( $_GET['sinistro_fisici_controparte'] ) ? $_GET['sinistro_fisici_controparte'] : null;

             $sinistro_materiali_preventivo = isset( $_GET['sinistro_materiali_preventivo'] ) ? $_GET['sinistro_materiali_preventivo'] : null;
             $sinistro_materiali_perizia = isset( $_GET['sinistro_materiali_perizia'] ) ? $_GET['sinistro_materiali_perizia'] : null;
             $sinistro_materiali_liquidazione = isset( $_GET['sinistro_materiali_liquidazione'] ) ? $_GET['sinistro_materiali_liquidazione'] : null;

             $sinistro_attivo  = isset( $_GET['sinistro_attivo'] ) ? $_GET['sinistro_attivo'] : null;

             echo updateClaim(
               $mysqli, $sinistro_id,
               $sinistro_data, $sinistro_luogo, $sinistro_compagnia_utente, $sinistro_compagnia_controparte, $sinistro_diagnosi,
               $sinistro_fisici_visite, $sinistro_fisici_esami, $sinistro_fisici_certificazione,
               $sinistro_fisici_parte, $sinistro_fisici_controparte,
               $sinistro_materiali_preventivo, $sinistro_materiali_perizia, $sinistro_materiali_liquidazione,
               $sinistro_attivo
             );

             break;

         case 'updateGroup':

             $gruppo_id = isset( $_GET['gruppo_id'] ) ? $_GET['gruppo_id'] : null;
             $update_nome = isset( $_GET['gruppo_nome'] ) ? $_GET['gruppo_nome'] : null;

             updateGroup($mysqli, $gruppo_id, $update_nome);

             break;

         case 'deleteFile':

             $file_id = isset( $_GET['file_id'] ) ? $_GET['file_id'] : null;

             deleteFile($mysqli, $file_id);

             break;

         case 'deleteUser':

            $utente_id = isset( $_GET['utente_id'] ) ? $_GET['utente_id'] : null;

            deleteUser($mysqli, $utente_id);

            break;

         case 'deleteGroup':

            $gruppo_id = isset( $_GET['gruppo_id'] ) ? $_GET['gruppo_id'] : null;

            deleteGroup($mysqli, $gruppo_id);

            break;

         case 'deleteClaim':

             $sinistro_id = isset( $_GET['sinistro_id'] ) ? $_GET['sinistro_id'] : null;

             deleteClaim($mysqli, $sinistro_id);

             break;

         case 'deleteDate':

              $appuntamento_id = isset( $_GET['appuntamento_id'] ) ? $_GET['appuntamento_id'] : null;

              deleteDate($mysqli, $appuntamento_id);

              break;
    }

    mysqli_close($mysqli);

    //START getUsers
    function getUsers($mysqli, $gruppo_id) {

        $query = "SELECT utente.* FROM utente INNER JOIN gruppo ON utente.gruppo_id=gruppo.id WHERE gruppo_id=$gruppo_id";

        $json_utenti = '{ "utenti" : [';

        $counter = 0;

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $json_utenti .= json_encode($row);

                $counter++;

                if($counter != mysqli_num_rows($result)){
                    $json_utenti .= ",";
                }

            }

            $json_utenti .= "]}";

        }

        return $json_utenti;

    }//END getUsers

    //START getUser
    function getUser($mysqli, $utente_id) {

        $query = "SELECT * FROM utente WHERE id = $utente_id";

        $json_utente = '{ "utente" : [';

        $counter = 0;

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $json_utente .= json_encode($row);

                $counter++;

                if($counter != mysqli_num_rows($result)){
                    $json_utente .= ",";
                }

            }

            $json_utente .= "]}";

        }

        return $json_utente;

    }//END getUser

    //START getNextDates
    function getNextDates($mysqli) {

        $query = "SELECT
          appuntamento.id as appuntamentoId,
          appuntamento.utente_id as appuntamentoUtenteId,
          appuntamento.datetime as appuntamentoDatetime,
          appuntamento.luogo as appuntamentoLuogo,
          appuntamento.descrizione as appuntamentoDescrizione,
          utente.nome as utenteNome,
          utente.cognome as utenteCognome
        FROM appuntamento INNER JOIN utente ON appuntamento.utente_id = utente.id
        WHERE datetime >= CURDATE()
        ORDER BY datetime ASC";

        $json_appuntamenti = '{ "appuntamenti" : [';

        $counter = 0;

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $row_array = array(
                  'id' => $row['appuntamentoId'],
                  'utente_id' => $row['appuntamentoUtenteId'],
                  'title' => $row['utenteNome'] . ' ' . $row['utenteCognome'],
                  'start' => $row['appuntamentoDatetime'],
                  'luogo' => $row['appuntamentoLuogo'],
                  'descrizione' => $row['appuntamentoDescrizione']
                );

                $json_appuntamenti .= json_encode($row_array);

                $counter++;

                if($counter != mysqli_num_rows($result)){
                    $json_appuntamenti .= ",";
                }

            }

            $json_appuntamenti .= "]}";

        }

        return $json_appuntamenti;

    }//END getNextDates

    //START getDatesFullcalendar
    function getDatesFullcalendar($mysqli, $start, $end) {

        $query = "SELECT
          appuntamento.id as appuntamentoId,
          appuntamento.utente_id as appuntamentoUtenteId,
          appuntamento.datetime as appuntamentoDatetime,
          appuntamento.luogo as appuntamentoLuogo,
          appuntamento.descrizione as appuntamentoDescrizione,
          utente.nome as utenteNome,
          utente.cognome as utenteCognome
        FROM appuntamento INNER JOIN utente ON appuntamento.utente_id = utente.id
        WHERE appuntamento.datetime > '$start' AND appuntamento.datetime < '$end'
        ORDER BY datetime ASC";

        $json_appuntamenti = '[';

        $counter = 0;

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $row_array = array(
                  'id' => $row['appuntamentoId'],
                  'utente_id' => $row['appuntamentoUtenteId'],
                  'title' => $row['utenteNome'] . ' ' . $row['utenteCognome'],
                  'start' => $row['appuntamentoDatetime'],
                  'luogo' => $row['appuntamentoLuogo'],
                  'descrizione' => $row['appuntamentoDescrizione']
                );

                $json_appuntamenti .= json_encode($row_array);

                $counter++;

                if($counter != mysqli_num_rows($result)){
                    $json_appuntamenti .= ",";
                }

            }

            $json_appuntamenti .= "]";

        }

        return $json_appuntamenti;

    }//END getDatesFullcalendar

    //START getGroups
    function getGroups($mysqli) {

        $query = "SELECT id, nome FROM gruppo";

        $json_gruppi = '{ "gruppi" : [';

        $counter = 0;

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $json_gruppi .= json_encode($row);

                $counter++;

                if($counter != mysqli_num_rows($result)){
                    $json_gruppi .= ",";
                }

            }

            $json_gruppi .= "]}";

        }

        return $json_gruppi;

    }//END getGroups

    //START getClaims
    function getClaims($mysqli, $sinistro_utente_id) {

        $query = "SELECT sinistro.* FROM sinistro INNER JOIN utente ON sinistro.utente_id=utente.id WHERE sinistro.utente_id = $sinistro_utente_id";

        $json_sinistri = '{ "sinistri" : [';

        $counter = 0;

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $json_sinistri .= json_encode($row);

                $counter++;

                if($counter != mysqli_num_rows($result)){
                    $json_sinistri .= ",";
                }

            }

            $json_sinistri .= "]}";

        }

        return $json_sinistri;

    }//END getClaims

    //START getActiveClaims
    function getActiveClaims($mysqli) {

        $query = "SELECT sinistro.*, utente.nome, utente.cognome FROM sinistro INNER JOIN utente ON sinistro.utente_id=utente.id WHERE attivo = '1'";

        $json_sinistri = '{ "sinistri" : [';

        $counter = 0;

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $json_sinistri .= json_encode($row);

                $counter++;

                if($counter != mysqli_num_rows($result)){
                    $json_sinistri .= ",";
                }

            }

            $json_sinistri .= "]}";

        }

        return $json_sinistri;

    }//END getActiveClaims

    //START getUnactiveClaims
    function getUnactiveClaims($mysqli) {

        $query = "SELECT sinistro.*, utente.nome, utente.cognome FROM sinistro INNER JOIN utente ON sinistro.utente_id=utente.id WHERE attivo = '0'";

        $json_sinistri = '{ "sinistri" : [';

        $counter = 0;

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $json_sinistri .= json_encode($row);

                $counter++;

                if($counter != mysqli_num_rows($result)){
                    $json_sinistri .= ",";
                }

            }

            $json_sinistri .= "]}";

        }

        return $json_sinistri;

    }//END getUnactiveClaims

    //START getFiles
    function getFiles($mysqli, $file_utente_id) {

        $query = "SELECT file.id, file.nome, file.tipo, file.size FROM file INNER JOIN utente ON file.utente_id=utente.id WHERE file.utente_id = $file_utente_id";

        $json_files = '{ "files" : [';

        $counter = 0;

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $json_files .= json_encode($row);

                $counter++;

                if($counter != mysqli_num_rows($result)){
                    $json_files .= ",";
                }

            }

            $json_files .= "]}";

        }

        return $json_files;

    }//END getFiles

    //START setUser
    function setUser($mysqli, $gruppo_id, $user_nome, $user_cognome, $user_luogo_residenza, $user_data_nascita, $user_descrizione, $user_numero_telefono, $user_mail) {

        $stmt = $mysqli->prepare("INSERT INTO utente (gruppo_id, nome, cognome, luogo_residenza, data_nascita, descrizione, numero_telefono, mail) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $gruppo_id, $user_nome, $user_cognome, $user_luogo_residenza, $user_data_nascita, $user_descrizione, $user_numero_telefono, $user_mail);
        $stmt->execute();

        return $mysqli->insert_id;

    }//END setUser

    //START setGroup
    function setGroup($mysqli, $gruppo_nome) {

        $stmt = $mysqli->prepare("INSERT INTO gruppo (nome) VALUES (?)");
        $stmt->bind_param("s", $gruppo_nome);
        $stmt->execute();

        return $mysqli->insert_id;

    }//END setGroup

    //START setDate
    function setDate($mysqli, $appuntamento_utente_id, $appuntamento_datetime, $appuntamento_luogo, $appuntamento_descrizione) {

        $stmt = $mysqli->prepare("INSERT INTO appuntamento (utente_id, datetime, luogo, descrizione) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $appuntamento_utente_id, $appuntamento_datetime, $appuntamento_luogo, $appuntamento_descrizione);
        $stmt->execute();

        return $mysqli->insert_id;

    }//END setDate

     //START setClaim
    function setClaim(
        $mysqli, $sinistro_utente_id,
        $sinistro_data, $sinistro_luogo, $sinistro_compagnia_utente, $sinistro_compagnia_controparte, $sinistro_diagnosi,
        $sinistro_fisici_visite, $sinistro_fisici_esami, $sinistro_fisici_certificazione,
        $sinistro_fisici_parte, $sinistro_fisici_controparte,
        $sinistro_materiali_preventivo, $sinistro_materiali_perizia, $sinistro_materiali_liquidazione,
        $sinistro_attivo
      ){

        $query = "INSERT INTO sinistro (utente_id, data, luogo, compagnia_utente, compagnia_controparte, diagnosi, "
                . "fisici_visite, fisici_esami, fisici_certificazione, fisici_parte, fisici_controparte, "
                . "materiali_preventivo, materiali_perizia, materiali_liquidazione, attivo) "
                . " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("issssssssssssss", $sinistro_utente_id, $sinistro_data, $sinistro_luogo, $sinistro_compagnia_utente, $sinistro_compagnia_controparte, $sinistro_diagnosi, $sinistro_fisici_visite, $sinistro_fisici_esami, $sinistro_fisici_certificazione, $sinistro_fisici_parte, $sinistro_fisici_controparte, $sinistro_materiali_preventivo, $sinistro_materiali_perizia, $sinistro_materiali_liquidazione, $sinistro_attivo);

        $stmt->execute();

        return $mysqli->insert_id;

    }//END setClaim

     //START setFile

     //START setFile
    function setFile($mysqli, $nome_file_temporaneo, $nome_file_vero, $tipo_file) {
        $dati_file = file_get_contents($nome_file_temporaneo);
        $dati_null = NULL ;

        $stmt = $mysqli->prepare("INSERT INTO file (nome, tipo_file, dati_file) VALUES (?, ?, ?)");
        $stmt->bind_param("ssb", $nome_file_vero, $tipo_file, $dati_null);
        $stmt->send_long_data(2,$dati_file);
        $stmt->execute();

        return $mysqli->insert_id;

    }//END setFile
    //end setFile

    //START updateDate
    function updateDate($mysqli, $appuntamento_id, $appuntamento_datetime, $appuntamento_luogo, $appuntamento_descrizione){

      $sql = 'UPDATE appuntamento SET datetime = ?, luogo = ?, descrizione = ? WHERE appuntamento.id = ?';

      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param("sssi", $appuntamento_datetime, $appuntamento_luogo, $appuntamento_descrizione, $appuntamento_id);
      $stmt->execute();
    }
    //END updateDate

    //START updateUser
    function updateUser($mysqli, $update_nome, $update_cognome, $update_luogo_residenza, $update_data_nascita, $update_descrizione, $update_numero_telefono, $update_mail, $utente_id){

      $sql = 'UPDATE utente SET nome = ?, cognome = ?, luogo_residenza = ?, data_nascita = ?, descrizione = ?, numero_telefono = ?, mail = ? WHERE utente.id = ?';

      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param("sssssssi", $update_nome, $update_cognome, $update_luogo_residenza, $update_data_nascita, $update_descrizione, $update_numero_telefono, $update_mail, $utente_id);
      $stmt->execute();
    }
    //END updateUser

    //START updateUser
    function updateClaim(
        $mysqli, $sinistro_id,
        $sinistro_data, $sinistro_luogo, $sinistro_compagnia_utente, $sinistro_compagnia_controparte, $sinistro_diagnosi,
        $sinistro_fisici_visite, $sinistro_fisici_esami, $sinistro_fisici_certificazione,
        $sinistro_fisici_parte, $sinistro_fisici_controparte,
        $sinistro_materiali_preventivo, $sinistro_materiali_perizia, $sinistro_materiali_liquidazione,
        $sinistro_attivo
      ){

        $query = "UPDATE sinistro SET data = ?, luogo = ?, compagnia_utente = ?, compagnia_controparte = ?, diagnosi = ?, "
                . "fisici_visite = ?, fisici_esami = ?, fisici_certificazione = ?, fisici_parte = ?, fisici_controparte = ?, "
                . "materiali_preventivo = ?, materiali_perizia = ?, materiali_liquidazione = ?, attivo = ? "
                . " WHERE sinistro.id = ?";

        $stmt = $mysqli->prepare($query);

        $stmt->bind_param("ssssssssssssssi", $sinistro_data, $sinistro_luogo, $sinistro_compagnia_utente, $sinistro_compagnia_controparte, $sinistro_diagnosi, $sinistro_fisici_visite, $sinistro_fisici_esami, $sinistro_fisici_certificazione, $sinistro_fisici_parte, $sinistro_fisici_controparte, $sinistro_materiali_preventivo, $sinistro_materiali_perizia, $sinistro_materiali_liquidazione, $sinistro_attivo, $sinistro_id);

        $stmt->execute();

        return $mysqli->insert_id;

    }//END setClaim

    function updateGroup($mysqli, $gruppo_id, $update_nome){

        $sql = 'UPDATE gruppo SET nome = ? WHERE gruppo.id = ?';

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $update_nome, $gruppo_id);
        $stmt->execute();

    }//END updtateGroup
    //START updateGroup

    //START deleteFile
    function deleteFile($mysqli, $file_id){

      $sql = "DELETE FROM file WHERE file.id = $file_id";
      mysqli_query($mysqli, $sql);

    }//END deleteFile

    //START deleteUser
    function deleteUser($mysqli, $utente_id){

      $sql = "DELETE FROM utente WHERE utente.id = $utente_id";
      mysqli_query($mysqli, $sql);

    }//END deleteUser

    //START deleteGROUP
    function deleteGroup($mysqli, $gruppo_id){

      $sql = "DELETE FROM gruppo WHERE gruppo.id = $gruppo_id";
      mysqli_query($mysqli, $sql);

    }//END deleteGROUP

    //START deleteClaim
    function deleteClaim($mysqli, $sinistro_id){

      $sql = "DELETE FROM sinistro WHERE sinistro.id = $sinistro_id";
      mysqli_query($mysqli, $sql);

    }//END deleteClaim

    //START deleteGroup
    function deleteDate($mysqli, $appuntamento_id){

      $sql = "DELETE FROM appuntamento WHERE appuntamento.id = $appuntamento_id";

      mysqli_query($mysqli, $sql);

    }
    //END deleteGroup

    //START validCookie
    function validCookie($cookieValue){

      $key = 'b91a25e358ab4ac402fa85466bc64216629d5a7a91f21c5075194c265e21e02b';
      $decryptedCookie = decrypt($cookieValue, $key);

      if(is_numeric($decryptedCookie) && strlen($decryptedCookie) == 256) {

          return true;
      }

      else {

          return false;
      }

    }
    //END validCookie

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
