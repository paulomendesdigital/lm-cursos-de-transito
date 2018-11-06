<div id='login-page' class="login page">
<div id="content">
    <div class="container-fluid">
        <div class="lock-container">
            <div class="panel panel-default text-center paper-shadow" data-z="0.5">
                <h2 class="text-center margin-bottom-none">Nova senha</h2>
                <?php 
                
                if(isset($public_url_avatar)):
                    echo '<img src="'.$public_url_avatar.'" class="img-circle width-80" />';
                else:
                    echo $this->Html->image('../themes/images/people/avatar_2x.png', ['class' => 'img-circle width-80']);
                endif;
                ?>
                <div class="panel-body">
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->Form->create('User', array('action' => 'pass'));?>
                        <div class="form-group">
                            <div class="form-control-material">
                                
                                <input class="form-control" id="cpf" type="text" data-mask='cpf' placeholder="Informe seu CPF" name="data[User][cpf]">    
                                <label for="cpf">CPF</label>                            
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    (function(){
        document.getElementById('cpf').focus();
    })();    
</script>