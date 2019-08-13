
<?php $this->start('body');?>
<link href="<?=URLPUBLIC?>js/bootstrap-social/bootstrap-social.css" rel="stylesheet">
    <!--<link href="./fontawesome/css/all.css" rel="stylesheet">-->
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<!--<meta name="google-signin-client_id" content="792247211311-6bkp7nvph51ep49tpe18rkjkb933un95.apps.googleusercontent.com">-->
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script src="<?=v?>js/login/global_vars.js"></script>  
<style>
  @font-face {
        font-family: "Futura PT Medium";
       
        src: url("<?=URLPUBLIC?>fonts/LemonMilklightitalic.otf") format("otf");
        src: url("<?=URLPUBLIC?>fonts/Majesti-Banner-Heavy.otf") format("otf");
        src: url("<?=URLPUBLIC?>fonts/MyriadPro-Regular.otf") format("otf");
        src: url("<?=URLPUBLIC?>fonts/brown-light-webfont.ttf") format("ttf");
        src: url("<?=URLPUBLIC?>fonts/Futura PT Medium.ttf");
    }
    body{
        font-family: "Futura PT Medium"
    }
    .container-btn{
      width: 310px;
      margin: 0 auto;
    }
    #content{
      text-align: center;
      margin-top: 20px;
    }
    .btn-email{
	    background: orange;
	    font-weight: bold;
	    color: white;
	    margin-bottom: 5px;
		border-color: rgba(0,0,0,0.2);
		width: 275px;
    }
    .btn-email:hover{
	    color: white;
	    background: #ec9a01;
    }
    .btn-google, .btn-twitter, .btn-facebook{
	    font-weight: bold;
	    width: 185px;
	    
    }
    .btn-google, .btn-facebook{
	    margin-bottom: 5px;
	    width: 185px;
    }
    .btn-primary{
	    margin-top: 5px;
    }
    .btn_login{
        width: 275px;
    }
    .row_pri{
        height: 100vh;
        margin-right: -15px;
        margin-left: -15px;
        display: flex;
        flex-wrap: wrap;
    }
    .left{
        background-size: 85%;
        background-repeat: no-repeat;
        background-position: center center;
        text-align: center;
        padding: 0;
    }
    .bulcard-txt{
      /*position: absolute;*/
      display: flex;
      flex-direction: column;
      text-align: center;
      font-size: 68px;
      line-height: 0.9;
      bottom: 34px;
      width: 100%;
  
    }
    .img_comp{
        width: 100%;
        height: 70%;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
    }
    @media only screen and (max-width: 1024px){
        .left {
            max-width: 100%;
            min-height: 30%;
            /*background-size: cover;
            flex: auto;
            background-position: initial;*/
            
        }
        .right{
            min-width: 100%;
            min-height: 70%;
        }
        .bulcard-txt{
          font-size: 28px;
          bottom: -50px;
          width: 100%;
        }

    }
    @media (max-width: 1024px) and (orientation: landscape){
        .left{
            width: 50%;
            min-height: 100%;
           /* background-position: center;
            background-size: cover;
            transform: scale(0.8);*/
        }
        .right{
            min-width: 50%;
            min-height: 100%;
            overflow: scroll;
            max-width: 70%;
        }
        .bulcard-txt{
          font-size: 26px;
          bottom: 120px;
          /* left: 77px; */
          width: 100%;
        }
    }
    @media only screen and (max-width: 812px) and (orientation: landscape){
        .left {
            width: 50%;
            min-height: 100%;
           /* background-size: cover;*/
        }
        .right{
            max-width: 50%;
            min-height: 100%;
            flex: auto;
        }
        .bulcard-txt{
          font-size: 26px;
          bottom: -23px;
          /* left: 77px; */
          width: 100%;
        }
        
    }
    @media only screen and (max-width: 768px){
        .left {
            max-width: 100%;
            min-height: 50%;
            /*background-size: cover;
            flex: auto;*/
        }
        .right{
            min-width: 100%;
            min-height: 50%;
        }
        .bulcard-txt{
          font-size: 26px;
          bottom: -46px;
          width: 100%
        }
        /*.img_comp{
            height: 100%;
        }*/
    }
    @media (max-width: 768px) and (orientation: landscape){
        .left {
            width: 30%;
            min-height: 100%;
            /*background-size: cover;
            background-position: center;*/
        }
        .right{
            min-width: 70%;
            min-height: 100%;
        }
        .bulcard-txt{
          font-size: 17px;
          bottom: 44px;
          width: 100%
        }
        /*.img_comp{
            height: 70%;
        }*/
    }
    @media only screen and (max-width: 375px){
      .bulcard-txt {
          font-size: 26px;
          bottom: -46px;
          width: 100%;
      }
      /*.img_comp{
        height: 100%;
      }*/
    } 

</style>
<script>
    var submit = "<?=$submit?>";

   
</script>
<script async defer src="https://apis.google.com/js/api.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.3.5/firebase-app.js"></script>
    <script defer src="https://www.gstatic.com/firebasejs/5.10.1/firebase-auth.js"></script>
    <!--<script src="<?=URLPUBLIC?>js/login/login-with-google.js"></script>-->
    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#config-web-app -->
    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyCui3tyXSSHwfGonMfL9WrG3zSKRNyTVko",
            authDomain: "login-android-bullcard.firebaseapp.com",
            databaseURL: "https://login-android-bullcard.firebaseio.com",
            projectId: "login-android-bullcard",
            storageBucket: "",
            messagingSenderId: "574774623964",
            appId: "1:574774623964:web:553c048ec8e4e1d2"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
    </script>    

    <script>
      // Your web app's Firebase configuration
      /*var firebaseConfig = {
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
      // style="background-image: url(<?=PROOT?>img/img_pasos/bulcard.png)
      */
    </script>
  <div class="container-fluid" style="">
        <div class="row_pri justify-content-center">
            <div class="col-md-6 left">
                    <div class="img_comp" style="background-image: url(<?=URLPUBLIC?>img/img_pasos/bulcard.png)"></div>
            <!--<img class="img_hafe_screen" src="<?=PROOT?>img/img_pasos/bulcard.png">-->
              <div class="bulcard-txt">
                <div><span style="color: #313d90;">BULL</span> <span style="color: #4c4d4f;">CARD</span></div>
                <div style="color: #adb5bd;">FUEL CASH <span style="color: #313d90;">&</span> SERVICES</div>
              </div>
            </div>
        
        <div class="col-md-6 right" style="text-align: center;background-color: #fff;">  
  
            <!--<img id="profile-img" src="" class="card-img-top" alt="">-->
            <!--<div class="card-body">-->
                <h2 class="">Activa tu tarjeta en un minuto</h2>
                <div class="container-btn">
                    <button  onclick="location.href='<?=PROOT?>login/index'" class="btn btn-social btn-email btn-lg btn_login" id="email-password-button" style="display: auto;"><i class="fa fa-envelope"></i>Sign with Email</button>
                <button class="btn btn-social btn-google btn-lg btn_login" id="authorize-button" style="display: initial;" onclick="initClient();"><span class="fa fa-google"></span> Sign with Google</button>
                <button class="btn btn-social btn-google btn-lg btn_login" id="signout-button" style="display: none;"><span class="fa fa-google"></span> Sign Out</button>
                <button class="btn btn-social btn-facebook btn-lg btn_login" id="signin_facebook" onclick="Facebook_login();" style="display: initial;"><span class="fa fa-facebook"></span>Sign with Facebook</button>
                <button class="btn btn-social btn-facebook btn-lg btn_login" id="signout_facebook"onclick="Facebook_logout();" style="display: none;"><span class="fa fa-facebook"></span>Sign out</button>
                <!--<button class="fb-login-button" onclick="Facebook_login();" autologoutlink="true" [parameters]><i class="fa fa-facebook">Sign with Facebook</button>
                <button class="btn btn-social btn-facebook" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false" scope="public_profile,email" onload="checkLoginState();"><i class="fa fa-facebook"></i> Sign with Facebook</button>-->
                <button class="btn btn-social btn-twitter btn-lg btn_login" onclick="loginTwitter();" id="signin_twitter" style="display: initial;"><span class="fa fa-twitter"></span> Sign with Twitter</button>
                <button class="btn btn-social btn-twitter btn-lg btn_login" onclick="logoutTwitter();" id="signout_twitter" style="display: none;"><span class="fa fa-twitter"></span> Sign Out</button>
                <div class="g-signin2" data-onsuccess="onSignIn"></div>
                </div>
                <div id="content"></div>
            <!-- </div>-->
            </div>
        </div>
        <div style="display: none">
        <form id="form_login" action="<?=PROOT?>home/" method="post">
            <input name=users_id id="users_id">
            <input type="submit">
        </form>
        </div>
</div>  
<script>
$(document).ready(function(){
  /*var provider = new firebase.auth.TwitterAuthProvider();
  console.log(provider)*/
  handleClientLoad();
})

</script>
    
   
    <script src="<?=URLPUBLIC?>js/login/login-with-email.js"></script>
    <script src="<?=URLPUBLIC?>js/login/login-with-google.js"></script>
    <script src="<?=URLPUBLIC?>js/login/funtions.js"></script>
    <script src="<?=URLPUBLIC?>js/login/login-with-facebook.js"></script>
    <script src="<?=URLPUBLIC?>js/login/login-with-twitter.js"></script>
    <script src="<?=URLPUBLIC?>js/login/codebird.js"></script>
    <script type="text/javascript">
      var cb = new Codebird;
      cb.setConsumerKey("TL58gmjLw2X9SsRAjUKLyDXDD", "qgCXnBfI2OQYFOptl8XHxEEmOio1uH8mpjS9XBruJTDv07TmrO");
    </script>

    <!--<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v4.0&appId=2326662040983995&autoLogAppEvents=1"></script>-->
    <!--<script async defer src="https://apis.google.com/js/api.js"></script>
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<?php $this->end(); ?>
