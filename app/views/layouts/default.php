<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $this->siteTitle(); ?></title>
    <!--<link rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <script src="<?=URLPUBLIC?>js/jquery-2.4.min.js"></script>
    <script src="<?=URLPUBLIC?>js/magnific-popup/1.1.0/jquery.magnific-popup.min.js"></script>
    <link rel="stylesheet" href="<?=URLPUBLIC?>js/magnific-popup/1.1.0/magnific-popup.min.css" />
    <link rel="stylesheet" href="<?=URLPUBLIC?>css/custom.css" media="screen" title="no title" charset="utf-8">
    
    <?= $this->content('head'); ?>
    </head>
    <script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};handleClientLoad()"
        onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js"></script>    
    <script src="<?=URLPUBLIC?>js/login/global_vars.js"></script> 
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <!--<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js"></script>
    <script defer src="https://www.gstatic.com/firebasejs/5.10.1/firebase-auth.js"></script>
    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#config-web-app --

    <script>
      // Your web app's Firebase configuration
      var firebaseConfig = {
        apiKey: "AIzaSyC1cQDfUhu3nMTBueEvsfExja0k-LWyUhI",
        authDomain: "login-ecd9e.firebaseapp.com",
        databaseURL: "https://login-ecd9e.firebaseio.com",
        projectId: "login-ecd9e",
        storageBucket: "",
        messagingSenderId: "315989352686",
        appId: "1:315989352686:web:b60107b4b4c21278"
      };
      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);
    </script>   -->                                  

  
  <script>
      // 
      // salir de la session de google
      function signout(){
        var isSiginIn = gapi.auth2.getAuthInstance().isSignedIn.get();
        if(isSiginIn){
            handleSignoutClick();
          }
    
      }
      function signoutFacebook(){
        FB.logout()
      }
      /*$(".content_btn_logout").on("mouseover",function(){
          console.log("Hober");
          $(".content_login").toggle();
      })*/
      $(".content_btn_logout").hover(function(){
        console.log("Hober");
      })
  </script>
  <body>
    <?php if( $this->ViewName() != "home" && $this->ViewName()."/".$this->ActionName() != "login/index" ):?>

	   <div id="content_btn_logout">
            <div class="users_name"><?=substr($profile_users->name,0,2);?></div>
        </div>
        <div class="content_login">
            <div class="content_log">
                <img src="<?=$profile_users->url_img_profile;?>" class="mr-5"/>
                <div>
                    <div class="pb-1"><?=$profile_users->name;?></div>
                    <div><?=$profile_users->email;?></div>
                    <a class="btn btn-secondary btn-sm mt-2" href="<?=PROOT?>logout/" onclick="signout();signoutFacebook();">Cerrar sesión</a>
                </div>
            </div>
        </div>    
    <?php endif ?>            
    <?= $this->content('body'); ?>
  </body>
  <script>
      $("#content_btn_logout").on("click",function(){
          $(".content_login").toggle();
      });
        ////////////////////////////////////////////////////////////////////
        // quitar menu del options cunado se hace click fuera del container
        ////////////////////////////////////////////////////////////////////
        $(document).mouseup(function (e)
                            {
        var container = $("#content_btn_logout"); // YOUR CONTAINER SELECTOR

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('.content_login').hide();
        }
        });
  </script>
  
  <script src="<?=URLPUBLIC?>js/login/funtions.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>