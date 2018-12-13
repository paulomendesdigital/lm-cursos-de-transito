<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Element View
 *
*/ ?>
<div id='login-box' class='<?php echo !empty($class) ? $class : ''; ?>'>
	<?php
    $id =  'UserIndexForm' . (isset($id) ? $id : '');
    echo !empty($container) && $container ? "<div class='container'>" : ""; ?>
		<h4 class='section-title'>Área do Aluno</h4>
		<hr/>
		<div class='box-grey'>
			<?php if( !$Auth ): ?>
				<p>Preencha os campos abaixo com seu <b>CPF</b> e <b>Senha</b> para começar a estudar.</p>
				<?php echo $this->Form->create('User',['url'=>['controller'=>'users','action'=>'login'], 'id' => $id]); ?>
					<div class='row-form-element'>
						<div class='form-element'>
							<label>CPF<span class='required'>*</span></label>									
							<?php echo $this->Form->input('username',['required'=>true,'data-mask'=>'cpf','label'=>false,'div'=>false, 'id' => $id . 'Username']); ?>
						</div>
					</div>
					<div class='row-form-element'>
						<div class='form-element'>
							<label>Senha<span class='required'>*</span></label>									
							<?php echo $this->Form->input('password',['required'=>true,'type'=>'password','label'=>false,'div'=>false, 'id' => $id . 'Password']); ?>
						</div>
					</div>
					<div class='row-form-element'>
						<button type='submit' class='button btn-success'>Entrar</button>
					</div>
					<div class='row-form-element'>
						<?php echo $this->Html->link("<i class='fa fa-unlock'></i> Esqueci a senha",['controller'=>'users','action'=>'pass'],['escape'=>false]); ?>									
					</div>
					<div class='row-form-element'>
						<?php echo $this->Html->link("<i class='fa fa-user'></i> Cadastrar",['controller'=>'users','action'=>'add'],['escape'=>false]); ?>		
					</div>
                <div class='row-form-element' style="padding: 20px 0">
                    <a href="https://www2.lmcursosdetransito.com.br">Não consegue entrar? Clique aqui para acessar a versão anterior</a>
                </div>
				<?php echo $this->Form->end(); ?>
			<?php else:?>
				<div class='row-form-element'>
					<div class='form-element'>
						<label>Nome:</label>									
						<?php echo $Auth['name']; ?>
					</div>
					<div class='form-element'>
						<label>CPF:</label>									
						<?php echo $Auth['cpf']; ?>
					</div>
				</div>
				<div class='row-form-element'>
					<?php
					if (!empty($this->Session->read('partner'))) {
						echo $this->Html->link('MINHAS VENDAS',['controller'=>'partners','action'=>'index'],['class'=>'btn btn-block btn-success btn-sw']);
					} else {
						echo $this->Html->link('SALA VIRTUAL',['controller'=>'virtual_rooms','action'=>'index'],['class'=>'btn btn-block btn-success btn-sw']);
					}
					?>
                    <br>
                    <?php echo $this->Html->link('Sair',['controller'=>'users','action'=>'logout', '?' => 'home']);?>
				</div>
			<?php endif;?>
		</div>
	<?php echo !empty($container) && $container ? "</div>" : ""; ?>
</div>
