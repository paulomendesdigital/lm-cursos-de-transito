<div id="signup" class="page">
    <div class="container">

        <?php echo $this->Utility->breadcumbs([
            'Início'   => ['controller' => 'pages', 'action' => 'index', 'prefixes' => false],
            'Cadastro' => ['controller' => 'users', 'action' => 'add', 'prefixes' => false]
        ]);
        ?>

        <h1>CADASTRO</h1>
        <h2>Preencha os campos abaixo e clique no botão finalizar cadastro para concluir.</h2>

        <p class="info">Todos os campos com asterisco <span style='color:red'>*</span>, são de preenchimento obrigatório.</p>

       <?php
       echo $this->Form->create('User', ['id' => 'form-cadastro', 'class' => 'form-horizontal']);
       $this->Form->inputDefaults(['divControls' => 'col-sm-2', 'class' => 'form-control']);
       $labelClass = 'col-sm-3 control-label';
       ?>

        <h3>Dados Pessoais</h3>
        <div class="form-group required">
            <?php echo $this->Form->input('User.name', ['label'=> ['text' => 'Nome completo:', 'class' => $labelClass], 'divControls' => 'col-sm-5', 'required' => true, 'minlength' => 10, 'maxlength' => 40]); ?>
        </div>
        <div class="form-group required">
            <?php echo $this->Form->input('User.email', ['label'=> ['text' => 'E-mail:', 'class' => $labelClass], 'divControls' => 'col-sm-5', 'type' => 'email', 'required' => true]); ?>
        </div>
        <div class="form-group required">
            <?php echo $this->Form->input('Student.0.cellphone', ['label'=> ['text' => 'Telefone:', 'class' => $labelClass], 'data-mask' => 'cellphone', 'required' => true]); ?>
        </div>
        <div class="form-group required">
            <?php echo $this->Form->input('Student.0.birth', ['label'=> ['text' => 'Data de Nascimento:', 'class' => $labelClass], 'data-mask' => 'date', 'required' => true, 'type' => 'text', 'data-rule-dateITA' => 'true']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.gender', ['label'=> ['text' => 'Sexo:', 'class' => $labelClass], 'empty' => ' ', 'options' => $genders]); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.rg', ['label'=> ['text' => 'RG:', 'class' => $labelClass], 'required' => false]); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.rg_uf', ['label'=> ['text' => 'Órgão Expedidor/UF:', 'class' => $labelClass], 'required' => false]); ?>
        </div>

        <h3>Endereço</h3>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.zipcode', ['label'=> ['text' => 'CEP:', 'class' => $labelClass], 'required' => false, 'data-mask' => 'zipcode', 'data-rule-postalcodeBR' => 'true']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.address', ['label'=> ['text' => 'Endereço:', 'class' => $labelClass], 'divControls' => 'col-sm-5', 'required' => false, 'data-toggle' => 'returnAddress']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.number', ['label'=> ['text' => 'Número:', 'class' => $labelClass], 'required' => false, 'data-toggle' => 'returnNumber']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.complement',['label'=> ['text' => 'Complemento:', 'class' => $labelClass], 'required' => false]); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.neighborhood', ['label'=> ['text' => 'Bairro:', 'class' => $labelClass], 'required' => false, 'data-toggle' => 'returnNeighborhood']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.state_id', ['label'=> ['text' => 'Estado:', 'class' => $labelClass], 'divControls' => 'col-sm-3', 'empty' => ' ', 'data-toggle' => 'returnState']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('Student.0.city_id', ['label'=> ['text' => 'Cidade:', 'class' => $labelClass], 'divControls' => 'col-sm-3', 'required' => false, 'empty' => ' ', 'data-toggle' => 'returnCity']); ?>
        </div>

        <h3>Dados de Acesso</h3>
        <div class="form-group required">
            <?php echo $this->Form->input('User.cpf', ['label'=> ['text' => 'CPF:', 'class' => $labelClass], 'required' => true, 'maxlength' => 20, 'data-mask' => 'cpf', 'data-msg-required' => 'Digite o seu CPF.', 'data-rule-cpfbr' => true]); ?>
        </div>
        <div class="form-group required">
            <?php echo $this->Form->input('User.password', ['label'=> ['text' => 'Senha:', 'class' => $labelClass], 'type' => 'password', 'minlength' => 4, 'maxlength' => 8, 'required' => true]); ?>
            <p class="info-senha">
                Essa senha será usada para acessar o curso.<br>
                A senha deve conter no mínimo 4 e no máximo 8 caracteres.
            </p>
        </div>

        <div class="row">
            <button type="submit" class="btn btn-cadastrar">Finalizar Cadastro</button>
        </div>

        <?php echo $this->Form->end(); ?>

        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function () {

        $.validator.setDefaults({
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
        $.validator.messages.required = 'Preencha este campo.';

        $("#form-cadastro").validate({
            onkeyup: false
        });

    }), true;
</script>

<?php echo $this->Element('site/modal-categoria-cnh'); ?>
