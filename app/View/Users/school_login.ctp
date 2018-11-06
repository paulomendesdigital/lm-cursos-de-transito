<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * Login
 *
*/?>
<div id='login-page' class="login page">
<div id="content">
    <div class="container-fluid">
        <div class="lock-container">
            <div class="panel panel-default text-center paper-shadow" data-z="0.5">
                <h2 class="text-center margin-bottom-none">Acesso aluno</h2>
                <?php 
                
                if(isset($public_url_avatar)):
                    echo '<img src="'.$public_url_avatar.'" class="img-circle width-80" />';
                else:
                    echo $this->Html->image('../themes/images/people/avatar_2x.png', ['class' => 'img-circle width-80']);
                endif;
                ?>
                <div class="panel-body">
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->Form->create('User', array('action' => 'login'));?>
                        <div class="form-group">
                            <div class="form-control-material">
                                <input class="form-control" id="username" type="text" placeholder="CPF" name="data[User][username]" data-mask="cpf" value="<?php echo isset($public_login)?$public_login:'';?>">
                                <label for="username">CPF</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-control-material">
                                <input class="form-control" id="password" type="password" placeholder="Senha" name="data[User][password]">
                                <label for="password">Senha</label>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary">Acessar <i class="fa fa-fw fa-unlock-alt"></i></button>
                    <?php echo $this->Form->end();?>
                    <?php //echo $this->Html->link('Esqueci minha senha', ['action' => 'pass'], ['class' => 'forgot-password']);?>
                    <?php //echo $this->Html->link('Cadastrar', ['action' => 'add']);?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $('#username').focus();
</script>