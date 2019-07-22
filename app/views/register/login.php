<?php $this->start('head');?>

<?php $this->end(); ?>
<?php $this->start('body');?>
<div class="center_con">
<div class="col-md-6 col-md-offset-3 well">
    <form action="<?=PROOT?>register/login" id="myForm" class="form" method="post">
        <div class="bg-danger"><?=$this->displayErrors;?></div>
        <h3 class="text-center">Log In</h3>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username">
        </div>
        <div class="form-group">
            <label for="password">Pasword</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="remember_me">Remember me<input type="checkbox" name="remember_me" id="remember_me" value="on"></label>
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn btn-large btn-primary">
        </div>
        <div class="text-right">
            <a href="<?=PROOT?>register/register" class="text-primary">Register</a>
        </div>
    </form>
</div>
</div>
<script>
$(document).ready(function(){
    document.getElementById("myForm").reset();
})
</script>
<?php $this->end(); ?>