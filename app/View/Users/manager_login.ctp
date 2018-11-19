<!-- Login wrapper -->
<div class="login-wrapper">
    <?php echo $this->Form->create('User', array('action' => 'login'));?>
        <div class="popup-header">
            <span class="text-semibold">Acesso Restrito</span>
        </div>
        <div class="well">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Session->flash('auth'); ?>
            <div class="form-group has-feedback">
                <label>Usuário</label>
                <input name="data[User][username]" maxlength="255" type="text" id="UserUsername" required="required" class="form-control" placeholder="Seu login de acesso">
                <i class="icon-users form-control-feedback"></i>
            </div>

            <div class="form-group has-feedback">
                <label>Senha</label>
                <input name="data[User][password]" maxlength="255" type="password" id="UserPassword" required="required" class="form-control" placeholder="Sua senha de acesso">
                <i class="icon-lock form-control-feedback"></i>
            </div>

            <div class="row form-actions">
                <div class="col-xs-6">
                </div>

                <div class="col-xs-6">
                    <button type="submit" class="btn btn-warning pull-right"><i class="icon-menu2"></i> Acessar</button>
                </div>
            </div>
        </div>
    <?php echo $this->Form->end();?>
</div>  
<!-- /login wrapper -->
    


