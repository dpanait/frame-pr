/**var activeRegister = function() {
   	var element = document.getElementById("register");
	if (element.style.visibility == "hidden"){
		element.style.visibility = "visible";
	}else{
		element.style.visibility = "hidden";
	}
}
*/
var activePrivacyPolicy = function(){
  	var element = document.getElementById("privacyPolicy");
	if (element.style.display == "none"){
		element.style.display = "block";
	}else{
		element.style.display = "none";
	}
}

function comprobarClave(){
	    let password = document.getElementById("exampleInputPassword1").value;  
   		let passwordConfirm = document.getElementById("exampleInputPassword2").value;
   		if (password == passwordConfirm) {
      		alert("Las dos claves son iguales");
      		return true;
	  		}else {
	  			alert("Las dos claves son distintas");
	  			return false;
	  			} 
	}

// esta funcion se llama cunado le das clik en el botton registrar usuario
// completar los campos que faltan numero trageta, email, password, en el caso de email
var send_data = function(){
    let email = document.getElementById("exampleInputEmail1").value;
    let password = document.getElementById("exampleInputPassword1").value;
    //let token = "3fys5jjdjd04dyetejnd86";
    let cp = document.getElementById("exampleInputNumber2").value;
    let cardNumber = document.getElementById("exampleInputNumber").value;
    let policyPrivacy = document.getElementById("exampleInputCheck").checked;
    let name = document.getElementById("exampleInputText").value;
    let telephone = document.getElementById("exampleInputTel").value;
    let nif = document.getElementById("exampleInputText2").value;
    var url = 'https://yuubbb.com/api-bullcard/api/?action=save-android';
    var comprobarClaves = comprobarClave();
    var data = {email: email,password: password, cp: cp, cardNumber: cardNumber, policyPrivacy: policyPrivacy, name: name, telephone: telephone, nif: nif};//token: token};
    let fetchData = {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'//x-www-form-urlencoded
          },
    };
    fetch(url,fetchData).then(res => {
        return res.json()
    })
    .catch(error => {
        console.error('Error:', error)
    })
    .then(response => {
        console.log('Success:', response)
    });
}
var get_user = function(){
  let email = document.getElementById("exampleInputEmail1").value;
  let password = document.getElementById("exampleInputPassword1").value;
  var url = 'https://yuubbb.com/api-bullcard/api/?action=signin';
  var data = {email: email,password: password};
  let fetchData = {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
          'Content-Type': 'application/json'//x-www-form-urlencoded
        },
  };
  fetch(url,fetchData)
  .then(res => {
      return res.json()
  })
  .catch(error => {
      console.error('Error:', error)
  })
  .then(res =>{
      console.log('Success:', res)

      if(res.login_status){
        console.log("Redireccionar a pantalla user data");
        if(res.step == null){
            /*var url = 'https://yuubbb.com/api-bullcard/api_web/login/paso2/';
            var data = {users_id: res.data_user.users_id};
            let fetchData = {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'//x-www-form-urlencoded
                    },
            };
            fetch(url,fetchData)
                .then(res => {
                    return res.json
                })
                .catch(error =>{
                    console.error("Error:", error)
                })
                .then(res=>{
                    console.log("Success: ",res)
                    
                })*/
           // window.location =  `<?=PROOT?>login/paso2/${res.data_user.users_id}`;
           window.location =  `/paso2/`;
        }
      } else {
        console.log("Redireccionar a pantalla Registrar");
      }
  });
  
  }
  /// guardamos los datos que vamos a completar del usuario paso 2
  var signup_complete = function(){
    let tarjeta = document.getElementById("compTarjeta").value;
    let nombre = document.getElementById("compNombre").value;
    let telefono = document.getElementById("compTelefono").value;
    let dni = document.getElementById("compDNI").value;

    var url = 'https://yuubbb.com/api-bullcard/api/?action=signup_complete';
    var data = {cardNumber: tarjeta, name: nombre, nif: dni, telephone: telefono};
    let fetchData = {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'//x-www-form-urlencoded
            },
    };
    
  }
