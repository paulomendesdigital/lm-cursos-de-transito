<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * NossaEquipe View
 *
*/ ?>
<div id='contact' class='page'>
	<div class='container'>
		<?php echo $this->Utility->breadcumbs([
			'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
			'Contato' => ['controller'=>'pages','action'=>'contact','prefixes'=>false]
		]);
		?>
		<div class='row'>
			<div class='col-md-6 col-form'>
				<?php echo $this->Form->create('Contact'); ?>
					<div class='row-form-element'>
						<div class='form-element'>
							<?php echo $this->Form->input('name',['placeholder'=>'Nome','div'=>false,'label'=>false]); ?>
						</div>
					</div>
					<div class='row-form-element row'>
						<div class='form-element col-md-6'>
							<?php echo $this->Form->input('phone',['placeholder'=>'Telefone','div'=>false,'label'=>false,'data-mask'=>'cellphone']); ?>
						</div>
						<div class='form-element col-md-6'>
							<?php echo $this->Form->input('email',['placeholder'=>'E-mail','div'=>false,'label'=>false,'type'=>'email']); ?>
						</div>
					</div>
					<div class='row-form-element'>
						<div class='form-element'>
							<?php echo $this->Form->input('subject',['placeholder'=>'Assunto','div'=>false,'label'=>false]); ?>
						</div>
					</div>
					<div class='row-form-element'>
						<div class='form-element'>
							<?php echo $this->Form->input('message',['placeholder'=>'Mensagem','type'=>'textarea','div'=>false,'label'=>false]); ?>
						</div>
					</div>
					<div class='row-form-element'>
						<div class='form-element'>
							<button type='submit' class='btn btn-primary btn-block btn-lg button'>Enviar</button>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
			<div class='col-md-6 col-socials'>
				<ul class='socials'>
					<li class='social'>
						<i class='fa fa-youtube'></i>
						<span><?php echo $this->Html->link('LM Cursos',Configure::read('Sistems.Youtube'),['target'=>'_blank']) ?></span>
					</li>
					<li class='social'>
						<i class='fa fa-envelope'></i>
						<span><?php echo $this->Html->link(Configure::read('Sistems.EmailTo'),'javascript:void(0)') ?></span>
					</li>
					<li class='social'>
						<i class='fa fa-map-marker'></i>
						<span>Estrada do Cafundá, 820, Sala 202<br> Tanque, Rio de Janeiro - RJ</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>