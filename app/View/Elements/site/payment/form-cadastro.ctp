<?php
echo $this->Form->create('User', ['url' => ['controller' => 'users', 'action' => 'payment_identification', 'cadastro'], 'id' => 'cadastro-form', 'default' => false]);
$this->Form->inputDefaults(['div' => false, 'class' => 'form-control']);
echo $this->Form->hidden('User.id');
echo $this->Form->hidden('Student.0.id');
?>

    <h5>Dados Pessoais</h5>

    <div class="form-group required">
        <?php echo $this->Form->input('User.name', ['id' => 'input-cadastro-name', 'label' => 'Nome Completo', 'required' => true, 'minlength' => 10, 'maxlength' => 40]); ?>
    </div>
    <div class="form-group required">
        <?php echo $this->Form->input('User.email', ['label' => 'E-mail', 'required' => true, 'type' => 'email']); ?>
    </div>

    <div class="form-group required">
        <?php echo $this->Form->input('Student.0.cellphone', ['label' => 'Telefone', 'required' => true, 'maxlength' => 15, 'data-mask' => 'cellphone']); ?>
    </div>
    <div class="form-group required">
        <?php echo $this->Form->input('Student.0.birth', ['label' => 'Data de Nascimento', 'type' => 'text', 'required' => true, 'data-mask' => 'date', 'data-rule-dateITA' => 'true']); ?>
    </div>

    <div class="form-group">
        <?php echo $this->Form->input('Student.0.gender', ['label' => 'Sexo', 'empty' => ' ', 'options' => [1 => 'Masculino', 2 => 'Feminino']]); ?>
    </div>

    <h5>Dados de Acesso</h5>
    <div class="form-group required">
        <?php echo $this->Form->input('User.cpf', ['id' => 'input-cadastro-cpf', 'label' => 'CPF', 'required' => true, 'maxlength' => 40, 'data-mask' => 'cpf']); ?>
        <?php if ($this->Form->isFieldError('User.cpf') && strpos($this->Form->error('User.cpf'), 'cadastrado') !== false) { ?>
            <br><span class="help-inline error-message"><a href="/recuperar-senha">Esqueceu a senha? Clique aqui.</a></span>
        <?php } ?>
    </div>
    <div class="form-group required">
        <?php echo $this->Form->input('User.password', ['label' => 'Senha', 'required' => true, 'type' => 'password', 'minlength' => 4, 'maxlength' => 8, 'value' => '']); ?>
    </div>

    <button type="submit" class="btn btn-checkout btn-cadastrar">CADASTRAR</button>

<?php echo $this->Form->end(); ?>
