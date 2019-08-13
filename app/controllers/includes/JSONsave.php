<?php
$api_request = $this->api_request;

$action = $_GET["action"];
switch($action){
case "get-user":
  // Takes raw data from the request
  $json = file_get_contents('php://input');
  // Converts it into a PHP object
  $data = json_decode($json);
  //print_r($data);
  $email = $data->email;
  $password = $data->password;
  $msg = "";
  $user_status = false;
  if($email && $password){
    // query al abase de datos
    $sql = $db_bullcard->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $sql->bindParam(':email', $email,PDO::PARAM_STR);
    $sql->bindParam(':password', $password,PDO::PARAM_STR);
    $sql->execute();
    $rows = $sql->fetchAll(PDO::FETCH_OBJ);
    //echo gettype($rows);
    //print_r($rows);
    if(!empty((array)$rows)){
      $msg = "Recibidos los datos";
      $user_status = true;
    }

  }
  echo json_encode(["status"=>$user_status,"msg"=>$msg,"rows"=>$rows]);
break;
case "signin":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }
   
    if($data->email && $data->password){
        $res_login = $api_request->login($data);
    } else {
        $msg = "Error email y contraseña no recibidos.";
        $res_login = ["msg" => $msg, "login_status" => false, "data_user" => null];
    }
    echo json_encode($res_login);
break;
case "signup":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }
    
    if($data->email && $data->password){
        
        $res_registro = $api_request->signup($data);
    } else {
        $msg = "Error no recibioms el email y la contraseña de forma correcta.";
        $res_registro = ["msg" => $msg, "user_created" => $false, "data_user" => null];
    }
    echo json_encode($res_registro);
break;
case "signup_complete":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }
    
    if($data->cardNumber && $data->name){
        $res_complete_reg = $api_request->signup_complete($data);
        echo json_encode($res_complete_reg);
    } else {
        $msg = "Error, datos necesarios para completar el registro no recibidos.";
        $res_complete_reg = ["msg" => $msg, "status" => false];
    }
    echo json_encode($res_complete_reg);
    
break;
case "preferences":
    if(count($_POST) > 0){
        // este es el caso de post desde aplicacion android
        $data = (object)($_POST);
        $v_gustos = str_replace(['"',']','[',' '],['','','',''],$data->gustos);  
        $a_gustos_save = explode(",",$v_gustos);

    } else {
        // post desde fetch
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
        $a_gustos_save = [];
    }
    /*$a_gustos_ser = [
        1=>"Arte",
        2=>"Aviones",
        3=>"Baile",
        4=>"Cine",
        5=>"Cocina",
        6=>"Coche",
        7=>"Compras",
        8=>"Deportes",
        9=>"Fotografia",
        10=>"Internet",
        11=>"Mascotas",
        12=>"Moda",
        13=>"Musica",
        14=>"Pintura",
        15=>"Viajar",
        16=>"Juegos"
    ];
    $a_gustos_ser = [
        "Arte"=>1,
        "Aviones"=>2,
        "Baile"=>3,
        "Cine"=>4,
        "Cocina"=>5,
        "Coches"=>6,
        "Compras"=>7,
        "Deportes"=>8,
        "Fotografia"=>9,
        "Internet"=>10,
        "Mascotas"=>11,
        "Moda"=>12,
        "Musica"=>13,
        "Pintura"=>14,
        "Viajar"=>15,
        "Juegos"=>16
        ];*/
    if($data->users_id && !empty($a_gustos_save)){
        $res_save_gustos = $api_request->preferences($data, $a_gustos_save);
    } else {
        $msg = "Error, usuario y gustos no recibidos correctamente.";
        $res_save_gustos = ["msg" => $msg, "status" => false];
    } 
    echo json_encode($res_save_gustos); 
    
break;
case"users_data":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }

    if($data->users_id){
        $data_user_req = $api_request->get_data_user($data);
    } else {
        $msg = "No recibimos el usuario_id.";
        $data_user_req = ["msg" => $msg, "status" => false, "users_data" => null];
    }

    echo json_encode($data_user_req);
break;
case"remove_tarjeta":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }
    $users_id = $data->users_id;
    $number = $data->num_tarjeta;

    if($data->users_id && $data->num_tarjeta){
        $res_tarjeta = $api_request->remove_tarjeta($data);
        // si se ha borado la targeta mandamos los datos a la applicacion
        if($res_tarjeta){
            $data_user_req = $api_request->get_data_user($data);
        } else {
            $msg = "Error no se a borrado el numero targeta.";
            $data_user_req = ["msg" => $msg, "status" => false, "users_data" => null];
        }
    } else {
        $msg = "Error datos de usuario y tarjeta no mandados correctamente.";
        $data_user_req = ["msg" => $msg, "status" => false, "users_data" => null];
    }
    echo json_encode($data_user_req);
    
break;
case"add_tarjeta":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }

    if($data->users_id && $data->num_tarjeta){
        $res_add = $api_request->add_tarjeta($data);
        //print_r($res_add);
        $res_add_tarjeta = ["msg" =>$res_add["msg"], "status" => false];
        if($res_add["status"]){
            $res_add_tarjeta = $api_request->get_data_user($data);
        }
    } else {
        $msg = "Error, datos necesarios no recibidos correctamente.";
        $res_add_tarjeta = ["msg" =>$msg, "status" => false];
    }
    echo json_encode($res_add_tarjeta);
break;
case"save_data_user":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }
    $users_id = (int)$data->users_id;
    $name = $data->name;
    $email = $data->email;
    $nif = $data->nif;
    $telephone = $data->telephone;
    $password_new = $data->password_new;
    $password_old = $data->password_old;
    $password_new_check = $data->password_new_check;
    if(!empty($data)){
        $res_save_user = $api_request->save_data_user($data);
    }else {
        $msg = "Error, datos necesarios no recibidos correctamente.";
        $res_save_user = ["msg" =>$msg, "status" => false];
    }
    echo json_encode($res_add_tarjeta);
break;
case"log_google":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }
    
    if(!empty($data)){
        $res_insert_google = $api_request->insert_from_google($data);
    } else {
        $msg = "Datos no recibidos.";
        $res_insert_google = ["msg"=>$msg,"status"=> flase];
    }
    echo json_encode($res_insert_google);
break;
case"log_facebook":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }
    if(!empty($data)){
        $res_insert_facebook = $api_request->insert_from_facebook($data);
    } else {
        $msg = "Datos no recibidos.";
        $res_insert_facebook = ["msg"=>$msg,"status"=> flase];
    }
    echo json_encode($res_insert_facebook);
break;
case"log_twitter":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }
    //echo json_encode($data);exit;
    if(!empty($data)){
        $res_insert_twitter = $api_request->insert_from_twitter($data);
    } else {
        $msg = "Datos no recibidos.";
        $res_insert_twitter = ["msg"=>$msg,"status"=> flase];
    }
    echo json_encode($res_insert_twitter);
break;
case "save-android":
    if(count($_POST) > 0){
        $data = (object)($_POST);
    } else {
        // Takes raw data from the request
        $json = file_get_contents('php://input');
        // Converts it into a PHP object
        $data = json_decode($json);
    }
   
    //print_r($data);
    $email = $data->email;
    $password = $data->password;
    $cardNumber = $data->cardNumber;
    $name = $data->name;
    $nif = $data->nif;
    $telephone = $data->telephone;

    if(isset($data->token)){
        $token = $data->token;
    } else {
        $token = null;
    }
    
    $b_create_user = false;
    $msg = "No insertado";
    $email_valid = false;
    if($email && $password){
        $msg = "";
        // para guardar en esta tabla tenemos que insertar el token , email, password, typo login(seria email, google, facebook,twitter)
        // campos obligatorios
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            // buscamos si existe el numero de target
            $sql_targeta = $db_bullcard->prepare("SELECT cards_id FROM cards WHERE number = :number");
            $sql_targeta->bindParam(':number', $cardNumber,PDO::PARAM_INT);
            $sql_targeta->execute();
            $num_targeta = $sql_targeta->fetchAll(PDO::FETCH_OBJ);
            if($num_targeta){
                $cards_id = $num_targeta[0]->cards_id;
                $msg.=" El numero target es: $num_target";
            } else {
                $msg.=" El numero target no existe lo insertamos";
                $sql_targ_insert = $db_bullcard->prepare("INSERT INTO cards (number, active, locked ) VALUES (?,?,?)");//(:email, :password, :token)");
                $res_targ_insert = $sql_targ_insert->execute([$cardNumber, 0, 0]);
                if($res_targ_insert){
                    $cards_id = $db_bullcard->lastInsertId();
                    $msg = "Insertado con exito";
                }
            }
            // tenemos que insertar en la base de datos YUB_GLOBAL._address_book el usuario y lego insertar en la base de datos bullcard
            $sql_address = $db_buygest->prepare("INSERT INTO _address_book (entry_emailE, entry_firstname, entry_NIF, IDCLIENTE, entry_telephone, countries_id ) VALUES (?,?,?,?,?,?)");//(:email, :password, :token)");
            $res_address = $sql_address->execute([$email, $name, $nif, 127, $telephone, 1]);
            if($res_address){
                $address_book_id = $db_buygest->lastInsertId();
                $msg = "Insertado con exito";
            }

            // insertamos en la base de datos users el usuario
            if($cards_id && $address_book_id){
                // Prepare
                $sql = $db_bullcard->prepare("INSERT INTO users (email, password, token, cards_id, login_type_id, address_book_id ) VALUES (?,?,?,?,?,?)");//(:email, :password, :token)");
                $res = $sql->execute([$email, $password, $token, $cards_id, 1, $address_book_id]);
                if($res){
                    $msg = "Insertado con exito";
                    $b_create_user = true; 
                }
            }
            
        } else {
            $msg .= "El email no es valido";
        }
    }
    echo json_encode(["msg"=>$msg,"create_user"=> $b_create_user,"num_targeta"=>$num_targeta[0]->cards_id,"cards_id"=>$cards_id,"address_book_id"=>$address_book_id]);
break;
default:
$prueba = new Prueba();
echo $prueba->prueba()."<br>";
echo json_encode(["Action no contemplado (no declarado)"]);

}