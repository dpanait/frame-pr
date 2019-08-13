function loginTwitter(){
    var provider = new firebase.auth.TwitterAuthProvider();
    console.log(provider)
    firebase.auth().signInWithPopup(provider).then(function(result) {
    // This gives you a the Twitter OAuth 1.0 Access Token and Secret.
    // You can use these server side with your app's credentials to access the Twitter API.
    var token = result.credential.accessToken;
    var secret = result.credential.secret;
    document.getElementById("signin_twitter").style.display = "none";
    document.getElementById("signout_twitter").style.display = "initial";
  
    // The signed-in user info.
    var user = result.user;
    console.log("user",user);
    send_to_twitter(user);
    
  }).catch(function(error) {
      console.log("EROR",error);
    // Handle Errors here.
    var errorCode = error.code;
    var errorMessage = error.message;
    // The email of the user's account used.
    var email = error.email;
    // The firebase.auth.AuthCredential type that was used.
    var credential = error.credential;
    // ...
  });
  }
  function logoutTwitter(){
  
    firebase.auth().signOut().then(e=> {
        // Sign-out successful.
        console.log("e",e);
        document.getElementById("signin_twitter").style.display = "initial";
        document.getElementById("signout_twitter").style.display = "none";
    }).catch(function(error) {
        // An error happened.
        console.log("error",error);
    });
  }

  function send_to_twitter(user_data){

    var url = "//yuubbb.com/api-bullcard/api_web/api/?action=log_twitter";
    var data ={
        "profile":user_data.providerData[0],
        "service_token": user_data.refreshToken
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
  }
window.twttr = (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0],
      t = window.twttr || {};
    if (d.getElementById(id)) return t;
    js = d.createElement(s);
    js.id = id;
    js.src = "https://platform.twitter.com/widgets.js";
    fjs.parentNode.insertBefore(js, fjs);
  
    t._e = [];
    t.ready = function(f) {
      t._e.push(f);
    };
  
    return t;
  }(document, "script", "twitter-wjs"));/*

function loginTwitter(){
    cb.__call("oauth/authenticate", function(reply, rate, err) {
        console.log(reply, rate, err)
      });
      return;
    cb.__call("oauth2_token", {}, function(reply, err) {
        var bearer_token;
        if (err) {
          console.log("error response or timeout exceeded" + err.error);
        }
        if (reply) {
          bearer_token = reply.access_token;
        }
      });
    /*let url = "https://api.twitter.com/oauth/authenticate?oauth_token=qgCXnBfI2OQYFOptl8XHxEEmOio1uH8mpjS9XBruJTDv07TmrO"
    let fetchData = {
        method: 'GET',
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

            /*if(res.status){
                console.log("Recargar");
                //window.location.href= "//yuubbb.com/api-bullcard/api_web/home/home";
                document.getElementById("users_id").value = res.users_id;
                if(!submit){
                    document.getElementById("form_login").submit();
                }
                
                
                var data = {"users_id": res.users_id};
                
            } else {
                console.log("No recargar");
            }*
        });*
}*/
  