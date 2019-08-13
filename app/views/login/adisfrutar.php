<?php $this->start('body');?>
<style>
    @font-face {
        font-family: "Futura PT Medium";
        src: url("<?=URLPUBLIC?>fonts/Futura PT Medium.ttf");
        src: url("<?=URLPUBLIC?>fonts/LemonMilklightitalic.otf") format("otf");
        src: url("<?=URLPUBLIC?>fonts/Majesti-Banner-Heavy.otf") format("otf");
        src: url("<?=URLPUBLIC?>fonts/MyriadPro-Regular.otf") format("otf");
        src: url("<?=URLPUBLIC?>fonts/brown-light-webfont.ttf") format("ttf");
    }
    body{
        font-family: "Futura PT Medium"
    }
    
    .title{
        text-align: center;
        color: #fff;
    }
    .form-group label{
        color: #fff;
    }
    .row{
        height: 95vh;
    }
    .left{
        background-size: cover;
        color: #fff;
        text-align: center;
    }
    .casi_yaesta{
        display: flex;
        flex-direction: column;
        font-size: 59px;
        font-weight: 700;
        line-height: 0.8;
        width: 52%;
        margin: 0 auto;

    }
    .lema_login{
        font-size: 48px;
        font-weight: 700;
        line-height: 0.8;
        color: #313d90;
    }
    .row_pri{
        text-align: right;
    }
    .btn_incio{
        border-radius: 28px;
    }
    .title_left{
        margin-top: 60px;
        color: #313d90;
        font-size: 46px;
        font-weight: 700;
    }
    @media (max-width: 1024px){
        .left{
            width: 100%;
            min-height: 50vh;
            
            background-size: cover;
        }
        .right{
            width: 100%;
            min-height: 50vh;
        }
        .casi_yaesta{
            font-size: 28px;
        }
        .lema_login {
            font-size: 32px;
        }
        .row_pri{
            margin-top: -2%;
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
        }
        .casi_yaesta{
            font-size: 28px;
        }
        .lema_login {
            font-size: 32px;
        }
        .row_pri{
            margin-top: -2%;
        }
    }
    @media only screen and (max-width: 812px){
        .row{
            height: 100%;
        }
        .left {
            width: 100%;
            max-height: 50%;
            background-size: cover;
            padding-bottom: 58%;
        }
        .right{
            width: 100%;
            min-height: 50%;
        }
        .title_left{
            margin-top: 23px;
            font-size: 31px;
        }
        .casi_yaesta{
            font-size: 20px;
        }
        .lema_login{
            padding-top: unset;
            font-size: 28px;
        }
        .row_pri {
            padding-top: unset;
            margin-top: 40%;
        }

    }
    @media (max-width: 812px) and (orientation: landscape){
        .left {
            width: 50%;
            max-height: 100%;
            background-size: cover;
            padding-bottom: 28%;
        }
        .right{
            width: 70%;
            min-height: 100%;
        }
        .row_pri {
            padding-top: unset;
            margin-top: -14%;
        }
    }
    @media only screen and (max-width: 768px){
        .row{
            height: 100%;
        }
        .left {
            width: 100%;
            max-height: 50%;
            background-size: cover;
            padding-bottom: 47%;
        }
        .right{
            width: 100%;
            min-height: 50%;
        }
        .title_left{
            margin-top: 23px;
            font-size: 31px;
        }
        .casi_yaesta{
            font-size: 45px;
        }
        .lema_login{
            padding-top: unset;
            font-size: 28px;
        }
        .row_pri {
            padding-top: unset;
            margin-top: 16%;
        }

    }
    
    @media only screen and (max-width: 736px){
        .row{
            height: 100%;
        }
        .left {
            width: 100%;
            max-height: 50%;
            background-size: cover;
            padding-bottom: 61%;
        }
        .right{
            width: 100%;
            min-height: 50%;
        }
        .title_left{
            margin-top: 23px;
            font-size: 31px;
        }
        .casi_yaesta{
            font-size: 20px;
        }
        .lema_login{
            padding-top: unset;
            font-size: 28px;
        }
        .row_pri {
            padding-top: unset;
            margin-top: 24%;
        }

    }
    @media (max-width: 736px) and (orientation: landscape){
        .left {
            width: 50%;
            max-height: 100%;
            background-size: cover;
            padding-bottom: 36%;
        }
        .right{
            width: 50%;
            min-height: 100%;
        }
        .row_pri {
            padding-top: unset;
            margin-top: -17%;
        }
    }
    @media only screen and (max-width: 411px){
        .row{
            height: 100%;
        }
        .left {
            width: 100%;
            max-height: 50%;
            background-size: cover;
            padding-bottom: 42%;
        }
        .right{
            width: 100%;
            min-height: 50%;
        }
        .title_left{
            margin-top: 23px;
            font-size: 31px;
        }
        .casi_yaesta{
            font-size: 20px;
        }
        .lema_login{
            padding-top: unset;
            font-size: 28px;
        }
        .row_pri {
            padding-top: unset;
            margin-top: 24%;
        }

    }
    
    @media (max-width: 731px) and (orientation: landscape){
        .left {
            width: 50%;
            min-height: 100%;
            background-size: cover;
            /*padding-bottom: 36%;*/
        }
        .right{
            width: 50%;
            min-height: 100%;
        }
        .title_left{
            margin-top: 23px;
            font-size: 31px;
        }
        .casi_yaesta{
            font-size: 20px;
        }
        .lema_login{
            padding-top: unset;
            font-size: 28px;
        }
        .row_pri {
            padding-top: unset;
            margin-top: -21%;
        }
    }
    @media only screen and (max-width: 360px){
        .row{
            height: 100%;
        }
        .left {
            width: 100%;
            max-height: 50%;
            background-size: cover;
            padding-bottom: 42%;
        }
        .right{
            width: 100%;
            min-height: 50%;
        }
        .title_left{
            margin-top: 23px;
            font-size: 31px;
        }
        .casi_yaesta{
            font-size: 20px;
        }
        .lema_login{
            padding-top: unset;
            font-size: 28px;
        }
        .row_pri {
            padding-top: unset;
            margin-top: 24%;
        }

    }
    @media (max-width: 640px) and (orientation: landscape){
        .row {
            height: 100%;
        }
        .left {
            width: 50%;
            min-height: 100%;
            background-size: cover;
            padding-bottom: 33%;
        }
        .right{
            width: 50%;
            min-height: 100%;
        }
        .title_left{
            margin-top: 23px;
            font-size: 31px;
        }
        .casi_yaesta{
            font-size: 20px;
        }
        .lema_login{
            padding-top: unset;
            font-size: 28px;
        }
        .row_pri {
            padding-top: unset;
            margin-top: -24%;
        }
        }
    }
</style>
<div class="container-fluid" style="">
    <div class="row">
            <div class="col-md-6 left" style="background-image: url(<?=URLPUBLIC?>img/img_pasos/AAA157C0B0191792_crop.jpg)">
            <h3 class="title_left">¡LISTO!</h3>
                <div class="casi_yaesta">HAS CONFIGURADO
                                            CORRECTAMENTE
                                            TU CUENTA Y TU TARJETA
                                        </div>
            </div>
        
        <div class="col-md-6 right" style="text-align: center;background-color: #fff;">
            <div class="row align-items-center">
                <div class="col-md-6 mx-auto">
                    <div class="lema_login">EMPIEZA A DISFUTAR DE
                        LAS VENTAJAS DE
                        BULL CARDS
                        <?= $name;?>
                        <?= $cant;?>
                    </div>
                </div>
            </div> 
            <div class="row_pri">
                <div class="btn_inicio">
                    <div class="btn btn-primary btn-lg btn_incio" onclick="location.href='<?=PROOT?>perfil/'">Inicio</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>