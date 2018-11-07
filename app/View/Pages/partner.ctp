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
			'Parceria' => ['controller'=>'pages','action'=>'partner','prefixes'=>false]
		]);
		?>
		<div class='row'>
			<div class='col-md-12 col-form'>
				<?php echo $this->Form->create('Contact'); ?>

                    <h3>Dados Pessoais</h3>

					<div class='row-form-element'>
						<div class='form-element'>
							<?php echo $this->Form->input('name',['placeholder'=>'Nome','div'=>false,'label'=>false]); ?>
						</div>
					</div>

					<div class='row-form-element row'>
						<div class='form-element col-md-4'>
                            <?php 
                                echo $this->Form->input('sex',[
                                    'placeholder'=>'Telefone',
                                    'div'=>false,
                                    'label'=>false,
                                    'data-mask'=>'cellphone',
                                    'options' => ['Masculino', 'Feminino'],
                                    'empty' => 'Sexo'
                                    ]); ?>
						</div>
						
						<div class='form-element col-md-4'>
							<?php echo $this->Form->input('birth',['placeholder'=>'Data de Nasc.','type'=>'number','div'=>false,'label'=>false,'data-mask'=>'date']); ?>
						</div>

						<div class='form-element col-md-4'>
                            <?php echo $this->Form->input('cpf',['placeholder'=>'CPF','div'=>false,'label'=>false]); ?>
						</div>
					</div>

                    <h3>Endereço Comercial</h3>

                    <div class="row-form-element row">
						<div class='form-element col-md-8'>
							<?php echo $this->Form->input('street',['placeholder'=>'Rua/Av','div'=>false,'label'=>false]); ?>
						</div>

						<div class='form-element col-md-4'>
							<?php echo $this->Form->input('number',['placeholder'=>'Nº','div'=>false,'label'=>false]); ?>
						</div>

						<div class='form-element col-md-12'>
							<?php echo $this->Form->input('complement',['placeholder'=>'Complemento','div'=>false,'label'=>false]); ?>
						</div>
                    </div>

                    <div class="row-form-element row">
						<div class='form-element col-md-8'>
							<?php echo $this->Form->input('neighborhood',['placeholder'=>'Bairro','div'=>false,'label'=>false]); ?>
						</div>

						<div class='form-element col-md-4'>
							<?php echo $this->Form->input('zip_code',['placeholder'=>'CEP','div'=>false,'label'=>false,'data-mask'=>'zipcode']); ?>
						</div>

						<div class='form-element col-md-9'>
							<?php echo $this->Form->input('city',['placeholder'=>'Cidade','div'=>false,'label'=>false]); ?>
						</div>

                        <div class='form-element col-md-3'>
                            <?php echo $this->Form->input('state',['placeholder'=>'UF','div'=>false,'label'=>false,'empty'=>'UF']); ?>
                        </div>
                    </div>

                    <div class="row-form-element row">
						<div class='form-element col-md-6'>
							<?php echo $this->Form->input('phone',['placeholder'=>'Telefone Res.','div'=>false,'label'=>false,'data-mask'=>'phone']); ?>
						</div>

						<div class='form-element col-md-6'>
							<?php echo $this->Form->input('cellphone',['placeholder'=>'Telefone Cel.','div'=>false,'label'=>false,'data-mask'=>'cellphone']); ?>
						</div>
                    </div>
					
                    <div class='row-form-element'>
						<div class='form-element'>
							<?php echo $this->Form->input('email',['placeholder'=>'E-mail','div'=>false,'label'=>false]); ?>
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

			<div class='col-md-12 col-socials'>
				<div class='socials'>
					<div class='social col-md-6'>
						<i class='fa fa-youtube'></i>
						<span><?php echo $this->Html->link('LM Cursos',Configure::read('Sistems.Youtube'),['target'=>'_blank']) ?></span>
					</div>
					<div class='social col-md-6'>
						<i class='fa fa-envelope'></i>
						<span><?php echo $this->Html->link(Configure::read('Sistems.EmailTo'),'javascript:void(0)') ?></span>
					</div>
					<div class='social col-md-6'>
						<i class='fa fa-map-marker'></i>
						<span>Estrada do Cafundá, 820, Sala 202<br> Tanque, Rio de Janeiro - RJ</span>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>