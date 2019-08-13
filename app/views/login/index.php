<?php $this->start('body');?>
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
      /*width: 184px;
      margin: 0 auto;*/
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
    }
    .btn-email:hover{
	    color: white;
	    background: #ec9a01;
	  
    }
    .btn-google{
	    font-weight: bold;
	    
    }
    .btn-primary{
	    margin-top: 5px;
    }
    .card-title, .card-text{
	    text-align: center;
    }
    .text-danger{
        color: #fff!important;
    }
    .img_hafe_screen{
        width: 100%;
        height: 100%;
        
    }
    .row{
        height: 100vh;
    }
    .lema_login{
        text-align: left;
        color: white;
        font-size: 131px;
        font-weight: 700;
        line-height: 0.8;
        position: fixed;
        bottom: 0px;
    }
    .left{
        background-size: cover;
    }
    @media only screen and (max-width: 1024px){
        .left {
            width: 100%;
            min-height: 30%;
            background-size: cover;
        }
        .right{
            width: 100%;
            min-height: 70%;
        }
        .lema_login{
            text-align: left;
            color: white;
            font-size: 130px;
            font-weight: 700;
            line-height: 0.8;
            /*display: inline-flex;*/
        }
        .lema_login div{
            margin: 5px;
        }

    }
    @media only screen and (max-width: 768px){
        .left {
            width: 100%;
            min-height: 30%;
            background-size: cover;
        }
        .right{
            width: 100%;
            min-height: 70%;
        }
        .lema_login{
            text-align: left;
            color: white;
            font-size: 24px;
            font-weight: 700;
            line-height: 0.8;
            display: inline-flex;
            position: unset;
        }
        .lema_login div{
            margin: 5px;
        }

    }
    @media (max-width: 1366px) and (orientation: landscape){
    .left{
        width: 30%;
        min-height: 100%;
        
        background-size: cover;
    }
    .right{
        width: 70%;
        min-height: 100%;
        overflow: scroll;
        max-width: 70%;
    }
    .lema_login{
        font-size: 102px;
        bottom: 0px;
        position: fixed;
    }
    .form-group {
        margin-bottom: 0rem;
    
    }
  }
    @media (max-width: 1024px) and (orientation: landscape){
    .left{
        width: 30%;
        min-height: 100%;
        
        background-size: cover;
    }
    .right{
        width: 70%;
        min-height: 100%;
        overflow: scroll;
        max-width: 70%;
    }
    .lema_login{
        font-size: 102px;
        bottom: 0px;
        position: fixed;
    }
    .form-group {
        margin-bottom: 0rem;
    
    }
  }
  @media (max-width: 812px) and (orientation: landscape){
    .lema_login{
        font-size: 30px;
        bottom: 0px;
        position: static;
        display: inline-flex;
    }
  }
    @media (max-width: 768px) and (orientation: landscape){
    
    .lema_login{
        font-size: 14px;
        bottom: 0px;
        position: static;
    }
  }
    @media (max-width: 700px) and (orientation: landscape){
    .left{
        width: 30%;
        min-height: 100%;
        
        background-size: cover;
    }
    .right{
        width: 70%;
        min-height: 100%;
        overflow: scroll;
        max-width: 70%;
    }
    .lema_login{
        font-size: 14px;
        bottom: 0px;
        position: static;
    }
    .form-group {
        margin-bottom: 0rem;
    
    }
  }
  @media (max-width: 639px) and (orientation: landscape){
    .left{
        width: 30%;
        min-height: 100%;
        
        background-size: cover;
    }
    .right{
        width: 70%;
        min-height: 100%;
        overflow: scroll;
        max-width: 70%;
    }
    .lema_login{
        font-size: 14px;
        bottom: 0px;
    }
    .form-group {
        margin-bottom: 0rem;
    
    }
  }
    </style>
    <link href="<?=PROOT?>js/bootstrap-social/bootstrap-social.css" rel="stylesheet">
    <!--<link href="./fontawesome/css/all.css" rel="stylesheet">-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container-fluid" style="">
        <div class="row">
            <div class="col-xl-6 left" style="background-image: url(<?=URLPUBLIC?>img/img_pasos/1_KXb8dCcJl4a6bNiMgQQB3A.jpeg)">
            <!--<img class="img_hafe_screen" src="<?=PROOT?>img/img_pasos/1_KXb8dCcJl4a6bNiMgQQB3A.jpeg">-->
            </div>
        
            <div class="col-xl-6 right" style="background-color: #99d8ba;">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#login">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#newClient">Registrarse</a>
                    </li>
                    
                </ul>
                <!-- Tab panes -->
                <div class="tab-content" align="center">
                    <div class="tab-pane active container" id="login">
                    <div class="col-md-6">
                        <div id ="register" class="" style="">
                            <div class="bg-danger"><?=$this->displayErrors;?></div>
                                <img id="profile-img" src="" class="card-img-top" alt="">
                                <h2 class="card-title">Inicio de sesión</h2>
                                <p class="card-text">Nunca compartiremos tu correo electrónico con nadie más.</p>
                                <div class="container-btn">
                                <form action="<?=PROOT?>login/index" id="formulario" method="post">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Introduce tu email" required="required">		
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu clave" required="required">
                                        <input type="hidden" name="type_form" value="login">
                                    </div>
                                        <center><button type="submit" class="btn btn-primary">Login</button></center>
                                </form>
                                <div id="content"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane container" id="newClient">
                    <div class="col-md-6 well">
                        <div id ="register" class="" style="">
                            <img id="profile-img" src="" class="card-img-top" alt="">
                            <h2 class="card-title">Registro de usuarios</h2>
                            <p class="card-text">Rellena todos los campos para registrarte correctamente.</p>
                            <div class="container-btn">
                                <form id="formulario" action="<?=PROOT?>login/index" method="post">
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Email</label>
                                        <input type="email" class="form-control" id="regEmail" name="regEmail" aria-describedby="emailHelp" placeholder="Introduce tu email" 									required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Contraseña</label>
                                        <input type="password" class="form-control" id="regPassword" name="regPassword" placeholder="Introduce tu clave" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword3">Confirmar contraseña</label>
                                        <input type="password" class="form-control" id="regPasswordCheck" name="regPasswordCheck" placeholder="Confirma tu clave" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputCheck" onclick="activePrivacyPolicy();">Aceptar política de privacidad</label>
                                        <input type="checkbox"  id="exampleInputCheck" required="required">
                                        <input type="hidden" name="type_form" value="signin">
                                    </div>
                                    <div id ="privacyPolicy" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</div>
                                        <center><button type="submit" class="btn btn-primary">Registrarse</button></center>
                                </form>
                            </div>
                            <div id="content"></div>
                        </div>
                    </div>
                </div> 
                <div class="lema_login">
                    <div>ADOPTA</div> 
                    <div>UN</div> 
                    <div>TORO</div> 
                </div>
            </div>  
        </div>
    </div>  
    <script src="<?=URLPUBLIC?>js/login/login-with-google.js"></script>
    <script src="<?=URLPUBLIC?>js/login/login-with-email.js"></script>
    <script src="<?=URLPUBLIC?>js/login/funtions.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php $this->end(); ?>