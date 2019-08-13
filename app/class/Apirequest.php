<?php
class Apirequest {
    private $_db_bullcard = null;
    private $_db_buygest = null;
    private $_data  = [];
    private $_usersAdd = null;
    function __construct($db_bullcard,$db_buygest)
    {
        $this->_db_bullcard = $db_bullcard;
        $this->_db_buygest = $db_buygest;
        $this->_usersAdd = new UsersAdd();
        
    }
    // metodo login usuario
    public function login($data){
        $msg = "";
        $login_status = false;
        $step = null;
        $data_user = [];
        if($data->email && $data->password){
            $email = $data->email;
            $password = $data->password;
            // comprobamos la contraseña si es correcta
            $sql_user_find = $this->_db_bullcard->prepare("SELECT password, users_id, email FROM users WHERE email = :email");
            $sql_user_find->bindParam(':email', $email,PDO::PARAM_STR);
            $sql_user_find->execute();
            $res_user= $sql_user_find->fetchAll(PDO::FETCH_OBJ);
            if($res_user){
                $password_check = $res_user[0]->password;

                if(password_verify($password,$password_check)){
                    $users_id = $res_user[0]->users_id;
                    $email = $res_user[0]->email;
                    $data_user = [
                        "email" => $email,
                        "users_id" => $users_id
                    ];
                    $msg ="Bienvenido.";
                    $login_status = true;
                    //buscamos si el proceso de registracion esta completado o amedias
                    $sql_register_step = $this->_db_bullcard->prepare("SELECT step FROM users_steps WHERE users_id = :users_id");
                    $sql_register_step->bindParam(":users_id", $users_id, PDO::PARAM_INT);
                    $sql_register_step->execute();
                    $res_register_step = $sql_register_step->fetchAll(PDO::FETCH_OBJ);
                    if($res_register_step){
                        $step = $res_register_step[0]->step;
                    }
                } else {
                    $msg ="La contaseña introducida no es correcta.";
                }
            } else {
                $msg ="El email introducido no esta registrado en el sistema.";
            }
        }
        return ["msg" => $msg, "login_status" => $login_status, "step" => $step, "data_user" => $data_user];
    }
    // metodo registrar usuario paso 1
    public function signup($data){
        $msg = "";
        $b_create_user = false; 
        $data_user = [];
        if($data->email && $data->password){
            $email = $data->email;
            $password = $data->password;
            // encriptar contraseña
            $pass_encripted = password_hash($password,PASSWORD_DEFAULT);
            // comprobamos s existe el email que a introducido el usuario para no tener dulicados (lios)
            $sql_user_find = $this->_db_bullcard->prepare("SELECT users_id, email, address_book_id FROM users WHERE email = :email");
            $sql_user_find->bindParam(':email', $email,PDO::PARAM_STR);
            $sql_user_find->execute();
            $res_user= $sql_user_find->fetchAll(PDO::FETCH_OBJ);
            
            if($res_user){
                $users_id = $res_user[0]->users_id;
                $email = $res_user[0]->email;
                $address_book_id = $res_user[0]->address_book_id;
                $data_user = [
                    "email"   => $email,
                    "users_id"=> $users_id
                ];
                $msg.=" El email: $email ya esta registrado en el sistema.";

                if($users_id){
                    // creamos el usuario en buygest 
                    if($address_book_id == null){
                        $sql_address = $this->_db_buygest->prepare("INSERT INTO _address_book (entry_emailE, IDCLIENTE, countries_id ) VALUES (?,?,?)");
                        $res_address = $sql_address->execute([$email, 127, 1]);
                        if($res_address){
                            $address_book_id = $this->_db_buygest->lastInsertId();
                            $sql_update_address = $this->_db_bullcard->prepare("UPDATE users SET address_book_id = :address_book_id WHERE users_id = :users_id");
                            $sql_update_address->bindParam(':address_book_id', $address_book_id, PDO::PARAM_INT);
                            $sql_update_address->bindParam(':users_id', $users_id, PDO::PARAM_INT);
                            $sql_update_address->execute();
                            $msg .=" Creada la cuenta en el BuyGest.";
                            
                        }
                    }
                    $b_create_user = true;

                   // evidencia de los pasoso
                   $sql_pasos_insert = $this->_db_bullcard->prepare("INSERT INTO users_steps(users_id, step) VALUES(?,?)");
                   $sql_pasos_insert->execute([$users_id, 1]);
   
               }
            } else {
               
                // crear nuevo usuario en la tabla users de bullcard
                $sql = $this->_db_bullcard->prepare("INSERT INTO users (email, password, login_type_id ) VALUES (?,?,?)");
                $res = $sql->execute([$email, $pass_encripted, 1]);
                if($res){
                    $msg = "Su cuenta a sido creada con exito.";
                    $b_create_user = true; 
                    $users_id = $this->_db_bullcard->lastInsertId();
                    $data_user = [
                        "email"   => $email,
                        "users_id"=> $users_id
                    ];
                }
               
                if($users_id){
                    // creamos el usuario en buygest 
                   $sql_address = $this->_db_buygest->prepare("INSERT INTO _address_book (entry_emailE, IDCLIENTE, countries_id ) VALUES (?,?,?)");
                   $res_address = $sql_address->execute([$email, 127, 1]);
                   if($res_address){
                       $address_book_id = $this->_db_buygest->lastInsertId();
                       $sql_update_address = $this->_db_bullcard->prepare("UPDATE users SET address_book_id = :address_book_id WHERE users_id = :users_id");
                       $sql_update_address->bindParam(':address_book_id', $address_book_id, PDO::PARAM_INT);
                       $sql_update_address->bindParam(':users_id', $users_id, PDO::PARAM_INT);
                       $sql_update_address->execute();
                       $msg .=" Creada la cuenta en el BuyGest.";
                   }

                   // evidencia de los pasoso
                   $sql_pasos_insert = $this->_db_bullcard->prepare("INSERT INTO users_steps(users_id, step) VALUES(?,?)");
                   $sql_pasos_insert->execute([$users_id, 1]);
   
               }
                
        
               
            }
        }
        return ["msg" => $msg, "user_created" => $b_create_user, "step" => "1","data_user" => $data_user];
    }
    // completamos los datos de usuario paso 2
    public function signup_complete($data){
        $proceso = false;
        $msg = "";
        $data_user = [];
        if($data->cardNumber && $data->name){
            // variables necesarias para completar el registro de usuario
            $cardNumber = $data->cardNumber;
            $name = $data->name;
            $nif = $data->nif;
            $telephone = $data->telephone;
            $users_id = $data->users_id;

            // buscamos y comprobamos que existe usuario
            $sql_user_find = $this->_db_bullcard->prepare("SELECT users_id, email FROM users WHERE users_id = :users_id");
            $sql_user_find->bindParam(':users_id', $users_id,PDO::PARAM_INT);
            $sql_user_find->execute();
            $res_user= $sql_user_find->fetchAll(PDO::FETCH_OBJ);
            if($res_user){
                $data_user = [
                    "email" => $res_user[0]->email,
                    "users_id" => $res_user[0]->users_id
                ];
                // comprobamos la targeta si esta registrada en el sistem
                $sql_tarjeta = $this->_db_bullcard->prepare("SELECT cards_id FROM cards WHERE number = :number");
                $sql_tarjeta->bindParam(':number', $cardNumber,PDO::PARAM_INT);
                $sql_tarjeta->execute();
                $num_tarjeta = $sql_tarjeta->fetchAll(PDO::FETCH_OBJ);

                if($num_tarjeta){
                    $cards_id = $num_tarjeta[0]->cards_id;
                    $msg.=" El numero tarjeta es: $cards_id.";
                    // activar la targeta
                    $sql_cards_upd = $this->_db_bullcard->prepare("UPDATE cards SET active = 1 WHERE cards_id = :cards_id");
                    $sql_cards_upd->bindParam(":cards_id", $cards_id, PDO::PARAM_INT);
                    $sql_cards_upd->execute();

                } /*else {
                    $msg.=" El numero targeta no existe lo insertamos.";
                    $sql_targ_insert = $this->_db_bullcard->prepare("INSERT INTO cards (number, active, locked ) VALUES (?,?,?)");
                    $res_targ_insert = $sql_targ_insert->execute([$cardNumber, 0, 0]);
                    if($res_targ_insert){
                        $cards_id = $this->_db_bullcard->lastInsertId();
                        $msg .= " Registrada la tarjeta en el sistema.";
                    }
                }*/

                //vinculamos latarget con el usuario en la tabla que las vincula
                if($users_id && $cards_id){
                    $sql_cards_users = $this->_db_bullcard->prepare("INSERT INTO cards_users(cards_id, users_id) VALUES (?,?)");
                    $res_cards_users = $sql_cards_users->execute([$cards_id, $users_id]);
                    if($res_cards_users){
                        $msg .=" Vinculadas las tajetas con usuarios.";
                    }
                }
                //buscamos el address_book_id
                if($users_id){
                    $sql_get_addres_book_id = $this->_db_bullcard->prepare("SELECT address_book_id FROM users WHERE users_id = :users_id");
                    $sql_get_addres_book_id->bindParam(':users_id', $users_id, PDO::PARAM_INT);
                    $sql_get_addres_book_id->execute();
                    $res_address_book_id = $sql_get_addres_book_id->fetchAll(PDO::FETCH_OBJ);
                    if($res_address_book_id){
                        $address_book_id = $res_address_book_id[0]->address_book_id;
                    }
                }
                // creamos el usuario en buygest 
                if($address_book_id){
                    $sql_address = $this->_db_buygest->prepare("UPDATE _address_book SET entry_firstname = :entry_firstname, entry_NIF = :entry_NIF, entry_telephone = :entry_telephone WHERE  address_book_id = :address_book_id");
                    $sql_address->bindParam(':entry_firstname', $name, PDO::PARAM_STR);
                    $sql_address->bindParam(':entry_NIF', $nif, PDO::PARAM_STR);
                    $sql_address->bindParam(':entry_telephone', $telephone, PDO::PARAM_INT);
                    $sql_address->bindParam(':address_book_id', $address_book_id, PDO::PARAM_INT);
                    $res_address = $sql_address->execute();
                    if($res_address){
                        $address_book_id = $this->_db_buygest->lastInsertId();
                        $msg .= " Se a creado con exito el usuario en buygest.";
                    }
                    // evidencia de los pasoso
                    $sql_pasos_upd = $this->_db_bullcard->prepare("UPDATE users_steps SET step = 2 WHERE users_id = :users_id");
                    $sql_pasos_upd->bindParam(":users_id", $users_id, PDO::PARAM_INT);
                    $sql_pasos_upd->execute();
                }
                $proceso = true;
            }
        }
        return ["msg" => $msg, "status" => $proceso,"step" => "2", "data_user" => $data_user];
    }
    // gurdamos las preferencias del usuario
    public function preferences($data, $a_gustos_save){
        $process = false; 
        $msg = "";
        if($data->users_id && !empty($a_gustos_save)){
            $users_id = $data->users_id;
            // generamos el array de gustos     
            $sql = $this->_db_bullcard->prepare("SELECT * FROM gustos");
            $sql->execute();  
            $res_gustos = $sql->fetchAll(PDO::FETCH_OBJ); 
            $a_gustos_ser = [];
            foreach($res_gustos as $gusto){
                $a_gustos_ser[$gusto->gusto] = (int)$gusto->gustos_id;
            } 
        
            $a_gustos_cli = $this->key_values_intersect($a_gustos_ser,$a_gustos_save);
            foreach($a_gustos_cli as $key => $val){
                $sql_gustos_cli = $this->_db_bullcard->prepare("INSERT INTO gustos_users(gustos_id, users_id) VALUES (?,?)");
                $res_gustos_cli = $sql_gustos_cli->execute([$val, $users_id]);
                if($res_gustos_cli){
                    $process = true;
                    $msg = "Se a guardado con exito tus gustos.";
                }
            }
            // evidencia de los pasoso
            $sql_pasos_upd = $this->_db_bullcard->prepare("DELETE FROM users_steps WHERE users_id = :users_id");
            $sql_pasos_upd->bindParam(":users_id", $users_id, PDO::PARAM_INT);
            $sql_pasos_upd->execute();
        }   
       
        return ["msg"=>$msg,"status"=> $process];
    }
    //devuelve los datos del cliente
    public function get_data_user($data){
        $users_find = false;
        $msg = "";
        $users_data = [];

        if($data->users_id){
            $users_id = $data->users_id;
            
            // buscamos datos de usuario
            $sql_users = $this->_db_bullcard->prepare("SELECT email,address_book_id FROM users WHERE users_id = :users_id");
            $sql_users->bindParam(':users_id', $users_id, PDO::PARAM_INT);
            $sql_users->execute();
            $res_users = $sql_users->fetchAll(PDO::FETCH_OBJ);
            if($res_users){
                $address_book_id = $res_users[0]->address_book_id;
                if($address_book_id){
                    //buscamos mas datos del usuario
                    $sql_address_users = $this->_db_buygest->prepare("SELECT entry_emailE, entry_NIF, entry_firstname, entry_telephone  FROM _address_book WHERE address_book_id = :address_book_id");
                    $sql_address_users->bindParam(":address_book_id", $address_book_id, PDO::PARAM_INT);
                    $sql_address_users->execute();
                    $res_address_users = $sql_address_users->fetchAll(PDO::FETCH_OBJ);
                    if($res_address_users){
                        foreach($res_address_users as $data_user_address){
                            $users_data['data'] = $data_user_address;
                        }
                        $users_find = true;
                        $msg = "Datos de usuario";
                    }
                    // buscamos los gustos
                    $sql_gustos = $this->_db_bullcard->prepare("SELECT b.gusto FROM gustos_users a LEFT JOIN gustos b ON a.gustos_id = b.gustos_id WHERE users_id = :users_id");
                    $sql_gustos->bindParam(':users_id', $users_id, PDO::PARAM_INT);
                    $sql_gustos->execute();
                    $res_gustos = $sql_gustos->fetchAll(PDO::FETCH_OBJ);
                    if($res_gustos){
                        $users_data['gustos'] = $res_gustos;

                    }
                    // buscamos el numero de targeta
                    $sql_targ = $this->_db_bullcard->prepare("SELECT a.number FROM cards a LEFT JOIN cards_users b ON a.cards_id = b.cards_id WHERE b.users_id = :users_id");
                    $sql_targ->bindParam(':users_id', $users_id, PDO::PARAM_INT);
                    $sql_targ->execute();
                    $res_targ = $sql_targ->fetchAll(PDO::FETCH_OBJ);
                    if($res_targ){
                        //$res_targ[]=['number'=>"243678545682"];
                        $users_data['nums_tarjetas'] = $res_targ;

                    }


                }
            } else {
                $msg = "Usuario no encontrado";
            }
        }
        

        return ["msg" => $msg, "status" => $users_find, "users_data" => $users_data];
    }
    // borra el numero target enviado
    public function remove_tarjeta($data){
        $v_tarjeta_borrada = false;
        if($data->users_id && $data->num_tarjeta){
            $users_id = $data->users_id;
            $number = $data->num_tarjeta;
            // buscamos datos de usuario
            $sql_users = $this->_db_bullcard->prepare("SELECT email,address_book_id FROM users WHERE users_id = :users_id");
            $sql_users->bindParam(':users_id', $users_id, PDO::PARAM_INT);
            $sql_users->execute();
            $res_users = $sql_users->fetchAll(PDO::FETCH_OBJ);
            if($res_users){
                $sql_num = $this->_db_bullcard->prepare("SELECT cards_id FROM cards WHERE number = :number");
                $sql_num->bindParam(':number', $number, PDO::PARAM_INT);
                $sql_num->execute();
                $res_num = $sql_num->fetchAll(PDO::FETCH_OBJ);
                if($res_num){
                    $cards_id = $res_num[0]->cards_id;
                    // boramos el numero de targeta
                    // desactivamos targeta actualizar el campo active a 0 en la tabla cards
                    $sql_cards_upd = $this->_db_bullcard->prepare("UPDATE cards SET active = 0 WHERE cards_id = :cards_id");
                    $sql_cards_upd->bindParam(":cards_id", $cards_id, PDO::PARAM_INT);
                    $sql_cards_upd->execute();

                    /*$sql_del_targeta = $this->_db_bullcard->prepare("DELETE FROM cards WHERE number = ?");
                    $sql_del_targeta->execute([$number]);*/
                    // boramos el numero de targeta
                    $sql_del_targeta = $this->_db_bullcard->prepare("DELETE FROM cards_users WHERE cards_id = ? AND users_id = ?");
                    $sql_del_targeta->execute([$cards_id, $users_id]);
                    $v_tarjeta_borrada = true;
                } 
            } 
        }
        return $v_tarjeta_borrada;   
    }
    // añadimos nueva tarjeta al usuario
    public function add_tarjeta($data){
        $msg = "";
        $status = false;
        if($data->users_id && $data->num_tarjeta){
            $users_id = (int)$data->users_id;
            $num_tarjeta = (int)$data->num_tarjeta;
            //echo $num_tarjeta;
            // comprobamos si exsiste esta targeta registrada
            $sql_find_card = $this->_db_bullcard->prepare("SELECT cards_id FROM cards WHERE number = :number AND active = 0");
            $sql_find_card->bindParam(":number", $num_tarjeta, PDO::PARAM_INT);
            $sql_find_card->execute();
            $res_find_card = $sql_find_card->fetchALL(PDO::FETCH_OBJ);
            
            //print_r($res_find_card);
            //echo json_encode([$res_find_card, $users_id, $num_tarjeta]);
            if($res_find_card){
                $cards_id = $res_find_card[0]->cards_id;
               // echo json_encode([$cards_id]);
                /*
                // si existe buscamospara ver si esta asignada a algun usuario
                $sql_card_asign = $this->_db_bullcard->prepare("SELECT users_id FROM cards_users WHERE cards_id = :cards_id");
                $sql_card_asign->bindParam(":cards_id",$cards_id, PDO::PARAM_INT);
                $sql_card_asign->execute();
                $res_card_asign = $sql_card_asign->fetchAll(PDO::FETCH_OBJ); 
                if($res_card_asign){
                    $users_asigned_id = $res_card_asign[0]->users_id;

                }*/


                // si existe actualizamos el active a 1 y vinculamos la targeta al ausuario

                // insertamos la tarjeta nueva para el usuario
                $sql_cards_upd = $this->_db_bullcard->prepare("UPDATE cards SET active = 1 WHERE cards_id = :cards_id");
                $sql_cards_upd->bindParam(":cards_id", $cards_id,PDO::PARAM_INT);
                $sql_cards_upd->execute();


                /*$sql_insert_card = $this->_db_bullcard->prepare("INSERT INTO cards(number, active, locked) VALUES(?,?,?)");
                $res_insert_card = $sql_insert_card->execute([$num_tarjeta, 0, 0]);
                if($res_insert_card){
                    $cards_id = $this->_db_bullcard->lastInsertId();
                    $msg = "Tarjeta añadida correctamente.";
                    $status = true;
                }*/
                // vinculamos la tarjeta con el usuario
                if($cards_id){
                    $sql_link_cards_users = $this->_db_bullcard->prepare("INSERT INTO cards_users(cards_id, users_id) VALUES(?,?)");
                    $res_link_cards_users = $sql_link_cards_users->execute([$cards_id, $users_id]);
                    if($res_link_cards_users){
                        $msg .=" Vinculada la tarjeta con el usuario";
                        $status = true;
                    }
                }
            } else {
                $msg = "Este numero de tarjeta no esta registrado en el sistema, o esta asignada a otro usuario";
            }
        }
        return ["msg" =>$msg, "status" => $status];
    }
    /**
     * Acualiza los datos del usuario
     */
    public function save_data_user($data = []){
        $msg = "";
        $status = false;
        if(!empty($data)){
            $users_id = (int)$data->users_id;
            $name = $data->name;
            $email = $data->email;
            $nif = $data->nif;
            $telephone = $data->telephone;
            $password_new = $data->password_new;
            $password_old = $data->password_old;
            $password_new_check = $data->password_new_check;
            //return ["msg"=>"Todo a ido bien","status"=> true,$users_id, $name, $email, $nif, $telephone, $password_new, $password_old,$password_new_check];//dnd("save_data_users");
            // buscamos el address_book_id desde la tabla users
            $sql_address = $this->_db_bullcard->prepare("SELECT address_book_id FROM users WHERE users_id = :users_id");
            $sql_address->bindParam(":users_id", $users_id, PDO::PARAM_INT);
            $sql_address->execute();
            $res_address = $sql_address->fetchAll(PDO::FETCH_OBJ);
            if($res_address){
                $address_book_id = $res_address[0]->address_book_id;
                // actualizamos los datos en la tabla _address_book de buygest
                $sql_address_upd = $this->_db_buygest->prepare("UPDATE _address_book SET entry_firstname = :name, entry_emailE = :email, entry_NIF = :nif,entry_telephone = :telephone WHERE address_book_id = :address_book_id");
                $sql_address_upd->bindParam(":name",$name, PDO::PARAM_STR);
                $sql_address_upd->bindParam(":email", $email,PDO::PARAM_STR);
                $sql_address_upd->bindParam(":nif", $nif, PDO::PARAM_STR);
                $sql_address_upd->bindParam(":telephone", $telephone, PDO::PARAM_STR);
                $sql_address_upd->bindParam(":address_book_id", $address_book_id, PDO::PARAM_INT);
                $res_address_upd = $sql_address_upd->execute();
    
                if($res_address_upd){
                    $msg .= " Actualizados los datos del usuario en Buygest.";
                    $status = true;
                } else {
                    $msg .= " No se han actualizados los datos del usuario en Buygest.";
                    $status = false;
                }

            }
            // si el campo de password_new_check esta vacio no hacemos nada para cambiar contrasena
            if($password_new_check != ""){
                // actualizamos la contraseña comprobando que la password_old es la misma que tiene que cambiar
                $sql_pass = $this->_db_bullcard->prepare("SELECT password FROM users WHERE users_id = :users_id");
                $sql_pass->bindParam(":users_id", $users_id, PDO::PARAM_INT);
                $sql_pass->execute();
                $res_pass = $sql_pass->fetchAll(PDO::FETCH_OBJ);
                if($res_pass){
                    $password_saved = $res_pass[0]->password;
                    if(password_verify($password_old,$password_saved)){
                        $pass_encripted = password_hash($password_new,PASSWORD_DEFAULT);
                        $res_pass_update = $this->_usersAdd->update_users_column("password", $users_id, $pass_encripted);
                        if($res_pass_update){
                            $msg .= " <br>Actualizada la contraseña.";
                            $status = true;
                        } else {
                            $msg .= " <br> No se a actualizada la contraseña.";
                            $status = false;
                        }
                    }
                }
            }
            // si tengo email actualizo email en la tabla users
            if($email != ""){
                $res_email_upd = $this->_usersAdd->update_users_column("email", $users_id, $email);
               
                if($res_email_upd){
                    $msg .=" <br>Email actualizado.";
                    $status = true;
                } else {
                    $msg .=" <br>No se a actualizado el email.$res_email_upd";
                    $status = false;
                }
            }
        }
        //$status = false;
        return ["msg"=>$msg, "status" => $status];
    }
    /**
     * se usa para filtrar l array de gustos
     */
    private function key_values_intersect($values,$keys) {
        foreach($keys AS $key) {
            $key_val_int[$key] = $values[$key];
        }
        return $key_val_int;
    }
    /**
     * gusrdamos los datos de usuario desde google
     */
    public function insert_from_google($data = []){
        if(!empty($data)){

            $check_data = new stdClass();
            $check_data->email = $data->profile->U3;
            $check_data->service_id = $data->profile->Eea;
            $users_id_exist = $this->user_exist($check_data);

            if(!$users_id_exist){
                $users_id = $this->_usersAdd->insert_from_google($data);
                if($users_id){
                    // si se crea el usuario y no ay error devolvemos el users_id
                    return ["msg"=>"Insertado el usuario.", "status" => true, "users_id" =>$users_id];
                } else {
                    // si error devolvemos el users_id a null
                    return ["msg"=>"Error.", "status" => false,"users_id"=>null];
                }
                
            } else {
                // si se encuentra el ususrio devilvemos su users_id 
                return ["msg"=>"Usuaro existe en el sistema.", "status" => true, "users_id" =>$users_id_exist];
            }
           
        }
        // si no se manda nada en el data retornamos un error
        return ["msg"=>"Error.", "status" => false,"users_id"=>null];
    }
    /**
     * buscamos si existe el usuario
     */
    public function user_exist($data = []){
        if(!empty($data)){
            //buscamos el usuario en la base de datos 
            $email = $data->email;
            $token = $data->service_id;
            // buscamos el usuario
            $sql_user_find = $this->_db_bullcard->prepare("SELECT users_id FROM users WHERE email = :email AND service_id = :service_id");
            $sql_user_find->bindParam(":email", $email, PDO::PARAM_STR);
            $sql_user_find->bindParam(":service_id", $token, PDO::PARAM_STR);
            $sql_user_find->execute();
            $res_user_find = $sql_user_find->fetchAll(PDO::FETCH_OBJ);
            if($res_user_find){
                return $res_user_find[0]->users_id;
            }
        }
        return false;
    }
    /**
     * inserar datos desde facebook
     */
    public function insert_from_facebook($data){
        if(!empty($data)){
            //print_r($data);
            // comprobamos si el usuario esta registrado
            $check_data = new stdClass();
            $check_data->email = $data->profile->email;
            $check_data->service_id = $data->profile->id;
            $users_id_exist = $this->user_exist($check_data);
            if(!$users_id_exist){
                $users_id = $this->_usersAdd->insert_from_facebook($data);
                if($users_id){
                    // si se crea el usuario y no ay error devolvemos el users_id
                    return ["msg"=>"Insertado el usuario.", "status" => true, "users_id" =>$users_id];
                } else {
                    // si error devolvemos el users_id a null
                    return ["msg"=>"Error.", "status" => false,"users_id"=>null];
                }
                
            } else {
                // si se encuentra el ususrio devilvemos su users_id 
                return ["msg"=>"Usuaro existe en el sistema.", "status" => true, "users_id" =>$users_id_exist];
            }
        } 
        // si no se manda nada en el data retornamos un error
        return ["msg"=>"Error.", "status" => false,"users_id"=>null];
    }
    /**
     * isertamos dat from Twitter
     */
    public function insert_from_twitter($data){
        if(!empty($data)){
            //print_r($data);
            // comprobamos si el usuario esta registrado
            $check_data = new stdClass();
            $check_data->email = $data->profile->email;
            $check_data->service_id = $data->profile->uid;
            $users_id_exist = $this->user_exist($check_data);
            if(!$users_id_exist){
                $users_id = $this->_usersAdd->insert_from_twitter($data);
                if($users_id){
                    // si se crea el usuario y no ay error devolvemos el users_id
                    return ["msg"=>"Insertado el usuario.", "status" => true, "users_id" =>$users_id];
                } else {
                    // si error devolvemos el users_id a null
                    return ["msg"=>"Error.", "status" => false,"users_id"=>null];
                }
                
            } else {
                // si se encuentra el ususrio devilvemos su users_id 
                return ["msg"=>"Usuaro existe en el sistema.", "status" => true, "users_id" =>$users_id_exist];
            }
        } 
        // si no se manda nada en el data retornamos un error
        return ["msg"=>"Error.", "status" => false,"users_id"=>null];
    }
    /**
     * buscamos el email 
     */
    /**
     * Actualiza campos dados en la tabla users
     */
    /*private function update_users_column($column, $users_id, $value){
        if($column != "" && $users_id != "" && $value != ""){
            //actualizamos datos en la tabla users
            $sql_users_upd = $this->_db_bullcard->prepare("UPDATE users SET {$column} = :{$column} WHERE users_id = :users_id");
            $sql_users_upd->bindParam(":{$column}", $value, PDO::PARAM_STR);
            $sql_users_upd->bindParam(":users_id", $users_id, PDO::PARAM_INT);
            $sql_users_upd->execute();
            $res_users_upd = $sql_users_upd->fetchAll(PDO::FETCH_OBJ);
            if($res_users_upd){
                return true;
            }
        }
        return false;
    }*/
}