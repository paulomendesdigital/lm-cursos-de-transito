<div class="modal fade" id="modalPaymentLogin" role="dialog">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        		<h4 class="modal-title" id="modalCategoriaLabel">Login</h4>
      		</div>
      		<div class="modal-body">
		    	<div id='login-page' class="login page">
					<div id="content">
					    <div class="container-fluid">
					        <div class="lock-container">
					            <div class="panel panel-default text-center paper-shadow" data-z="0.5">
					                <div class="panel-body">
					                    <?php echo $this->Session->flash(); ?>
					                    <?php echo $this->Form->create('User', array('controller'=>'users','action' => 'login'));?>
					                        <div class="form-group">
					                            <div class="form-control-material">
					                                <label for="username">Informe seu CPF</label>
					                                <input class="form-control" id="username" type="text" placeholder="CPF" name="data[User][username]" data-mask="cpf" required="true" />
					                            </div>
					                        </div>
					                        <div class="form-group">
					                            <div class="form-control-material">
					                                <label for="password">Informe sua Senha</label>
					                                <input class="form-control" id="password" type="password" placeholder="Senha" name="data[User][password]" required="true" />
					                            </div>
					                        </div>
					                    	<button type="submit" class="btn btn-primary">Acessar <i class="fa fa-fw fa-unlock-alt"></i></button>
					                    <?php echo $this->Form->end();?>
					                    <?php echo $this->Html->link('Esqueci minha senha', ['action' => 'pass'], ['class' => 'forgot-password']);?>
					                </div>
					            </div>
					        </div>
					    </div>
					</div>
					</div>
					<script type="text/javascript">
					    $('#username').focus();
					</script>
    		</div>
  		</div>
	</div>
</div>