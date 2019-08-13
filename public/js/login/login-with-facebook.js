
 function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();

    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    /*FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });*/
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '2326662040983995',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v4.0' // The Graph API version to use for the call
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    /*FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });*/

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
  function Facebook_login () {
    FB.login(function(response) {
        console.log("response",response);
        if(response.status == "connected"){
            document.getElementById("signin_facebook").style.display = "none";
            document.getElementById("signout_facebook").style.display = "initial";
           
            //console.log(user_data);
            send_post_to_server();
            //window.location.href = "https://yuubbb.com/api-bullcard/api_web/perfil/index";
        }
        // handle the response
    }, {scope: 'public_profile,email'});
} 
function Facebook_logout () {
    FB.logout(function(response) {
        console.log("response",response);
        // handle the response
        document.getElementById("signin_facebook").style.display = "initial";
        document.getElementById("signout_facebook").style.display = "none";
    }, {scope: 'public_profile,email'});
} 

async function getMore(){
    var data = null;
    var res = FB.api('/me', {fields: 'first_name,last_name,name,id,email,picture.width(150).height(150)'}, function(response) {
        //console.log(response);
        //return response;
      });
      console.log(res);
    
}
async function send_post_to_server(){
    FB.api('/me', {fields: 'first_name,last_name,name,id,email,picture.width(150).height(150)'}, function(response) {
        var url = "//yuubbb.com/api-bullcard/api_web/api/?action=log_facebook";
        var data ={
            "profile":response,
            "service_token": FB.getAccessToken()
        };
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

            if(res.status){
                console.log("Recargar");
                //window.location.href= "//yuubbb.com/api-bullcard/api_web/home/home";
                document.getElementById("users_id").value = res.users_id;
                if(!submit){
                    document.getElementById("form_login").submit();
                }
                
                
                var data = {"users_id": res.users_id};
                
            } else {
                console.log("No recargar");
            }
        });
    })    
}
