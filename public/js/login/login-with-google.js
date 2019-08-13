// Enter an API key from the Google API Console:
//   https://console.developers.google.com/apis/credentials
var apiKey = 'AIzaSyA2gsm0LRr_zFnUT4XnCuxY8qNNOTxMwI4';
// Enter the API Discovery Docs that describes the APIs you want to
// access. In this example, we are accessing the People API, so we load
// Discovery Doc found here: https://developers.google.com/people/api/rest/
var discoveryDocs = ["https://people.googleapis.com/$discovery/rest?version=v1"];
// Enter a client ID for a web application from the Google API Console:
//   https://console.developers.google.com/apis/credentials?project=_
// In your API Console project, add a JavaScript origin that corresponds
//   to the domain where you will be running the script.
var clientId = '792247211311-6bkp7nvph51ep49tpe18rkjkb933un95.apps.googleusercontent.com';
// Enter one or more authorization scopes. Refer to the documentation for
// the API or https://developers.google.com/people/v1/how-tos/authorizing
// for details.
var scopes = 'profile';
var authorizeButton = document.getElementById('authorize-button');
var signoutButton = document.getElementById('signout-button');
function handleClientLoad() {
  // Load the API client and auth2 library
  gapi.load('client:auth2', initClient);
}
function initClient() {
  gapi.client.init({
      apiKey: apiKey,
      discoveryDocs: discoveryDocs,
      clientId: clientId,
      scope: scopes
  }).then(function () {
    // Listen for sign-in state changes.
    gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);
    // Handle the initial sign-in state.
    updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
    authorizeButton.onclick = handleAuthClick;
    signoutButton.onclick = handleSignoutClick;
  })
  .catch(err => console.log(err));
}
function updateSigninStatus(isSignedIn) {
  if (isSignedIn) {
    authorizeButton.style.display = 'none';
    signoutButton.style.display = 'initial';
    makeApiCall();
  } else {
    authorizeButton.style.display = 'initial';
    signoutButton.style.display = 'none';
  }
}
function handleAuthClick(event) {
  gapi.auth2.getAuthInstance().signIn();
}
function handleSignoutClick(event) {
  gapi.auth2.getAuthInstance().signOut();
}

function makeApiCall() {
    var profile = gapi.auth2.getAuthInstance().currentUser.Ab.w3;
    var access_token = gapi.auth2.getAuthInstance().currentUser.Ab.Zi.access_token;
    console.log("Profile",profile);
    console.log("access_token",access_token);
    send_user_data(profile,access_token);
    
  }
  function send_user_data(profile,service_token){
    
      var url = "//yuubbb.com/api-bullcard/api_web/api/?action=log_google";
      var data ={
          "profile":profile,
          "service_token":service_token
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
            //send_post_to_home(data);
            /*let fetchData = {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'//x-www-form-urlencoded
                    },
            };
            
            fetch("https://yuubbb.com/api-bullcard/api_web/",fetchData)
            .then(res => {
                return res.json()
            })
            .catch(error => {
                console.error('Error:', error)
            })
            .then(res =>{
                console.log(res);
            });
           /* */
        } else {
            console.log("No recargar");
        }
    });

  }
 function send_post_to_home(data){
      //console.log(await $.ajax());
      /*let fetchData = {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'//x-www-form-urlencoded
            },
    };
    
    fetch("https://yuubbb.com/api-bullcard/api_web/",fetchData)
    .then(res => {
        return res.json()
    })
    .then(res =>{
        console.log(res);
    })
    .catch(error => {
        console.error('Error:', error)
    });
   */

 $.post("https://yuubbb.com/api-bullcard/api_web/",
  data,
  function(data, status){
    alert("Data: " + data + "\nStatus: " + status);
  });
      return;
    $.ajax({
        type:"POST",
        data:data,
        url:"#", //page where you want to submit the form
        success:function (data) {
            // response from the server in browsers console
            console.log(data)
        }
    });
  }