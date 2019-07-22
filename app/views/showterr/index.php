<?php $this->start('body');?>
<style>
.ter_container{
    width: 21cm;
    margin-left: -20px;
}
.img{
    height: 100%;
    width: 100%;
    
}
.img_container{
    width: 375px;
    height: 540px;
    float: left;
    padding-left: 20px;
    padding-bottom: 20px;
}
</style>
<!--<h1 class="text-center red">Welcome to page showterr</h1>-->
<div class="ter_container">
    <?php usort($data['img'],'strnatcmp'); ?>
    <?php foreach($data['img'] as $image): ?>
    <div class="img_container"><img class="img"src="<?php echo "/prueba/img/teritorios/".$image;?>"/></div>
    <?php endforeach ?>
</div>
<?php $this->end(); ?>