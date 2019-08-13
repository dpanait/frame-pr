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
    .btn_container{
        padding-top: 20px;
    }
    .form-group label{
        color: #fff;
    }
    .form-group{
        width: 100px;
        text-align: center;
    }
    .row_pri{
        height: 100vh;
        margin-right: -15px;
        margin-left: -15px;
        display: flex;
        flex-wrap: wrap;
    }
    .left{
        background-size: cover;
    }
    @media only screen and (max-width: 1024px){
        .left {
            max-width: 100%;
            min-height: 30%;
            background-size: cover;
            flex: auto;
        }
        .right{
            min-width: 100%;
            min-height: 70%;
        }

    }
    @media (max-width: 1024px) and (orientation: landscape){
        .left{
            width: 30%;
            min-height: 100%;
            
            background-size: cover;
        }
        .right{
            min-width: 70%;
            min-height: 100%;
            overflow: scroll;
            max-width: 70%;
        }
    }
    @media only screen and (max-width: 812px) and (orientation: landscape){
        .left {
            width: 30%;
            min-height: 100%;
            background-size: cover;
        }
        .right{
            max-width: 70%;
            min-height: 100%;
            flex: auto;
        }
    }
    @media only screen and (max-width: 768px){
        .left {
            max-width: 100%;
            min-height: 30%;
            background-size: cover;
            flex: auto;
        }
        .right{
            min-width: 100%;
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
            min-width: 70%;
            min-height: 100%;
        }
    }
</style>
<div class="container-fluid" style="">
        <div class="row_pri">
            <div class="col-md-6 left" style="background-image: url(<?=URLPUBLIC?>img/img_pasos/DSCN1088.jpg)">
            <!--<img class="img_hafe_screen" src="<?=PROOT?>img/img_pasos/1_KXb8dCcJl4a6bNiMgQQB3A.jpeg">-->
            </div>
        
        <div class="col-md-6 right" style="text-align: center;background-color: #4b7d69;">
            <p class="title">QUEREMOS CONOCERTE UN POQUITO MÁS</p>
            <div id ="register" class="" style="width: 20rem; margin: 0 auto;">
            
                <div class="">
                    <!--<h2 class="card-title">Porfavor_selecciona_una_o_mas_opciones_a_su_gusto</h2>-->
                
                    <div class="container-btn">
                    <form action="<?=PROOT?>login/gustos" id="formulario" method="post">
                        <div class="row justify-content-around">
                            <div class="form-group">
                                <label for="arte">Arte</label>
                                <input type="checkbox" class="form-control" id="arte" name="arte">		
                            </div>
                            <div class="form-group">
                                <label for="aviones">Aviones</label>
                                <input type="checkbox" class="form-control" id="aviones" name="aviones">
                            </div>
                            <div class="form-group">
                                <label for="baile">Baile</label>
                                <input type="checkbox" class="form-control" id="baile" name="baile">
                            </div>
                        </div>
                        <div class="row justify-content-around">
                            <div class="form-group">
                                <label for="cine">Cine</label>
                                <input type="checkbox" class="form-control" id="cine" name="cine">
                            </div>
                            <div class="form-group">
                                <label for="coches">Coches</label>
                                <input type="checkbox" class="form-control" id="coches" name="coches">		
                            </div>
                            <div class="form-group">
                                <label for="cocina">Cocina</label>
                                <input type="checkbox" class="form-control" id="cocina" name="cocina">
                            </div>
                        </div>
                        <div class="row justify-content-around">
                            <div class="form-group">
                                <label for="compras">Compras</label>
                                <input type="checkbox" class="form-control" id="compras" name="compras">
                            </div>
                            <div class="form-group">
                                <label for="deportes">Deportes</label>
                                <input type="checkbox" class="form-control" id="deportes" name="deportes">
                            </div>
                            <div class="form-group">
                                <label for="fotografia">Fotografia</label>
                                <input type="checkbox" class="form-control" id="fotografia" name="fotografia">		
                            </div>
                        </div>
                        <div class="row justify-content-around">
                            <div class="form-group">
                                <label for="juegos">Juegos</label>
                                <input type="checkbox" class="form-control" id="juegos" name="juegos">
                            </div>
                            <div class="form-group">
                                <label for="internet">Internet</label>
                                <input type="checkbox" class="form-control" id="internet" name="internet">
                            </div>
                            <div class="form-group">
                                <label for="mascotas">Mascotas</label>
                                <input type="checkbox" class="form-control" id="mascotas" name="mascotas">
                            </div>
                        </div>
                        <div class="row justify-content-around">
                            <div class="form-group">
                                <label for="moda">Moda</label>
                                <input type="checkbox" class="form-control" id="moda" name="moda">
                            </div>
                            <div class="form-group">
                                <label for="musica">Musica</label>
                                <input type="checkbox" class="form-control" id="musica" name="musica">
                            </div>
                            <div class="form-group">
                                <label for="pintura">Pintura</label>
                                <input type="checkbox" class="form-control" id="pintura" name="pintura">
                            </div>
                        </div>
                        <div class="row justify-content-around">
                            <div class="form-group">
                                <label for="viajar">Viajar</label>
                                <input type="checkbox" class="form-control" id="viajar" name="viajar">
                            </div>
                        </div>
                        <div class=btn_container>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button style="margin-left: 10px;" type="button" onclick="location.href='<?=PROOT?>perfil/'" class="btn btn-primary">En otro momento</button>
                        </div>    
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div> 

<?php $this->end(); ?>