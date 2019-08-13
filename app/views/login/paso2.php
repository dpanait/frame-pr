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
    
    .title{
        text-align: center;
        color: #fff;
        padding-top: 26px;
        font-size: x-large;
    }
    .form-group label{
        color: #fff;
    }
    .row{
        height: 100vh;
    }
    .text-danger {
        color: #f8f9fa!important;
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
    }
    @media (max-width: 812px) and (orientation: landscape){
        .left {
            width: 30%;
            min-height: 100%;
            background-size: cover;
        }
        .right{
            width: 70%;
            min-height: 100%;
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

    }
    @media (max-width: 768px) and (orientation: landscape){
        .left {
            width: 30%;
            min-height: 100%;
            background-size: cover;
        }
        .right{
            width: 70%;
            min-height: 100%;
        }
    }
</style>
<script>
    var num_attempts = 0;
    <?php if(isset($num_attempts)):?>
        num_attempts = <?=$num_attempts;?>;
    <?php endif;?>
    if(num_attempts > 10){
        alert("Demasiados intentos para guardar esta tarjeta, contacta con el administrador");
        window.location =  `login/index/`;
    }
    /*var form_paso2 = document.getElementById("formulario");
    function reset_form(evt){
        evt.preventDefault();
        console.log("submit",evt);
        form_paso2.reset();
        return true;
    }*/
</script>
<div class="container-fluid" style="">
        <div class="row">
            <div class="col-xl-6 left" style="background-image: url(<?=URLPUBLIC?>img/img_pasos/chicos_movilshutterstock_1220284780.jpg)">
            <!--<img class="img_hafe_screen" src="<?=PROOT?>img/img_pasos/1_KXb8dCcJl4a6bNiMgQQB3A.jpeg">-->
            </div>
        
            <div class="col-xl-6 right" style="background-color: #f35972;">
                
                <!--<div class="col-md-6 offset-3 well">-->
                <h5 class="title">INTRODUCE TUS DATOS PERSONALES Y FISCALES SI LO NECESITAS</h5>
                <?php if($this->displayErrors != ""):?>
                    <div class="bg-danger white-color"><?=$this->displayErrors;?></div>
                <?php endif;?>
                    <div id ="register" class="" style="width: 20rem; margin: 0 auto;">
                    
                            <!--<p class="card-text">Nunca compartiremos tu correo electrónico con nadie más.</p>-->
                            <div class="container-btn">
                            <form action="<?=PROOT?>login/paso2" id="formulario" method="post" onsubmit="return reset_form(event);">
                                <div class="form-group">
                                    <label for="cardNumber">Tarjeta</label>
                                    <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Introduce el numero de tarjeta" required="required">		
                                </div>
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Introduce tu nombre" required="required">
                                </div>
                                <div class="form-group">
                                    <label for="telephone">Teléfono</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Introduce tu teléfono" required="required">
                                </div>
                                <div class="form-group">
                                    <label for="nif">DNI</label>
                                    <input type="text" class="form-control" id="nif" name="nif" placeholder="Introduce tu DNI" required="required">
                                </div>
                                    <center><button style="margin-top: 20px;" type="submit" class="btn btn-primary">Guardar</button></center>
                            </form>
                        </div>
                    </div>
                <!--</div>-->
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){
       
    })
    var form_paso2 = document.getElementById("formulario");
    function reset_form(evt){
        //evt.preventDefault();
        console.log("submit",evt);
        let cardNumber = $("#cardNumber");
        let name = $("#name");
        let telephone = $("#telephone");
        let nif = $("#nif");

        if(cardNumber.val() != "" && name.val() != "" && telefone.val() != "" && nif.val() != ""){
            console.log("cardNumber");
            //form_paso2.reset();
            return false
        }
        return false;
    }
    </script>
<?php $this->end(); ?>