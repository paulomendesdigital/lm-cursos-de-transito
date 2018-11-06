<?php
echo $this->Form->create('User', ['url' => ['controller' => 'users', 'action' => 'payment_identification', 'login'], 'id' => 'login-form', 'default' => false]);
$this->Form->inputDefaults(['div' => false, 'class' => 'form-control']);
echo $this->Form->hidden('facebook_json', ['id' => 'input-facebook-json']);
?>
    <div class="form-group">
        <?php echo $this->Form->input('User.username', ['label' => 'CPF', 'required' => true, 'id' => 'input-login-cpf', 'data-mask' => 'cpf']); ?>
    </div>
    <div class="form-group">
        <?php echo $this->Form->input('User.password', ['label' => 'Senha', 'type' => 'password',  'id' => 'input-login-senha', 'required' => true]); ?>
        <?php if (isset($message)) { ?>
            <span class="help-inline error-message"><?php echo $message ?></span>
        <?php } ?>
    </div>
    <small><a href="/recuperar-senha" target="_blank">Esqueci minha senha</a></small>

    <button type="submit" class="btn btn-checkout btn-entrar">ENTRAR <i class="glyphicon glyphicon-log-in"></i></button>
<?php echo $this->Form->end();?>

<button class="btn btn-checkout btn-entrar-facebook">ENTRAR COM O FACEBOOK</button>
