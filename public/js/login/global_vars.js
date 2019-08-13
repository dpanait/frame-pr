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
var scopes = 'profile';
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
     // gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);
      // Handle the initial sign-in state.
      //updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
      //authorizeButton.onclick = handleAuthClick;
      //signoutButton.onclick = handleSignoutClick;
    })
    .catch(err => console.log(err));
  }
  function updateSigninStatus(isSignedIn) {
    if (isSignedIn) {
      authorizeButton.style.display = 'none';
      signoutButton.style.display = 'initial';
      makeApiCall2();
    } else {
      authorizeButton.style.display = 'initial';
      signoutButton.style.display = 'none';
    }
  }
  function handleAuthClick() {
    gapi.auth2.getAuthInstance().signIn();
  }
  function handleSignoutClick() {
    gapi.auth2.getAuthInstance().signOut();
  }


  ///////////////////////////////////////
  /// login with facebook ///////////////
  /////////////////////////////////////////
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '2326662040983995',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v4.0' // The Graph API version to use for the call
    })
  }
  
  function Facebook_logout () {
    FB.logout(function(response) {
        console.log("response",response);
        // handle the response
        document.getElementById("signin_facebook").style.display = "initial";
        document.getElementById("signout_facebook").style.display = "none";
    }, {scope: 'public_profile,email'});
} 