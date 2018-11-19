<footer id='footer'>
	<div class='footer-main'>
		<div class='container'>
			<div class='row'>
				<div class='col-md-3 col-lg-2 col-menu col-footer'>
					<h3 class='menu-title' data-target='#menu-footer-1'>Menu</h3>									
					<nav id='menu-footer-1' class='menu footer-col-content menu-site-map'>
						<ul>
							<li><?php echo $this->Html->link('Início',['controller'=>'pages','action'=>'index','prefixes'=>false],['class'=>$this->Utility->__getActiveClass('pages','index')]); ?></li>
							<li><?php echo $this->Html->link('Quem Somos',['controller'=>'pages','action'=>'quemsomos','prefixes'=>false],['class'=>$this->Utility->__getActiveClass('pages','quemsomos')]); ?></li>
							<li><?php echo $this->Html->link('Nossa Equipe',['controller'=>'instructors','action'=>'index','prefixes'=>false]); ?></li>
							<li><?php echo $this->Html->link('Termo de Serviço',['controller'=>'pages','action'=>'termoservico','prefixes'=>false],['class'=>$this->Utility->__getActiveClass('pages','termoservico')]); ?></li>
						</ul>
					</nav>					
				</div>
				<div class='col-md-3 col-lg-4 col-distance col-footer'>
					<h3 class='menu-title' data-target='#menu-footer-2'>Ensino a Distância</h3>
					<div class='footer-col-content'>						
						<nav id='menu-footer-2' class='menu'>
							<ul>
								<?php foreach($footer_courses as $key => $course){ ?>
									<li><?php echo $this->Html->link($course,['controller'=>'courses','action'=>'view','prefixes'=>false, $key]); ?></li>					
								<?php } ?>	
							</ul>
						</nav>
						<?php echo $this->Html->image('site/logo-footer.png',['class'=>'logo-footer hidden-xs hidden-sm']); ?>
					</div>
				</div>
				<div class='col-md-3 col-lg-4 col-lm col-footer'>
					<h3>LM Cursos de Trânsito</h3>
					<div class='footer-col-content'>
						<p><b>E-mail:</b> <?php echo $this->Html->link(Configure::read('Sistems.EmailTo'),['controller'=>'pages','action'=>'contact','prefixes'=>false]);  ?></p>
						<p>Endereço - Estrada do Cafundá, 820, Sala 202 - Tanque, Rio de Janeiro - RJ, 22730-540</p>
						<p>CNPJ: <?php echo Configure::read('Sistems.CNPJ'); ?></p>
						<ul class='socials'>
							<li><?php echo $this->Html->link("<i class='fa fa-youtube-square fa-3x'></i>",Configure::read('Sistems.Youtube'),['escape'=>false,'class'=>'social','target'=>'_blank', 'title' => 'YouTube']); ?></li>
							<li><?php echo $this->Html->link("<i class='fa fa-envelope-square fa-3x'></i>",['controller'=>'pages','action'=>'contact','prefixes'=>false],['escape'=>false,'class'=>'social','target'=>'_blank', 'title' => 'E-mail']); ?></li>
                            <li><?php echo $this->Html->link("<i class='fa fa-facebook-square fa-3x'></i>",'https://www.facebook.com/lmcursosdetransito',['escape'=>false,'class'=>'social', 'title' => 'Facebook']); ?></li>
                            <li><?php echo $this->Html->link("<i class='fa fa-instagram fa-instagram-square fa-3x'></i>",'https://www.facebook.com/lmcursosdetransito',['escape'=>false,'class'=>'social', 'title' => 'Instagram']); ?></li>
						</ul>
					</div>
				</div>
				<div class='col-md-3 col-lg-2 col-work-hour col-footer'>
					<h3>Atendimento</h3>
					<div class='footer-col-content'>
						<ul class='work-hours'>
							<li><b>Seg. à Sex.</b> 08h às 20h*</li>
							<li><b>Sábado</b> 08h às 14h</li>
							<li><b>Domingo</b> 08h às 12h</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class='copyright text-center'>
		<div class='container-fluid'>
			<div class="col-md-5 col-xs-12 text-center">
				© <?php echo date('Y');?>, LM Cursos de Trânsito.<br class='visible-xs'/> Todos os direitos reservados
			</div>
			<div class="col-md-7 col-xs-12 powered">
				<div class="col-md-3 col-xs-12 text-right hidden-xs">
					Desenvolvido por: 
				</div>
				<div class="col-md-2 col-xs-12 text-center">
		            <a class="" href="http://www.grupogrow.com.br" title="Powered by Grupo Grow | Agência de Desenvolvimento Web" target="_blank">
		                <?php echo $this->Html->image('site/logo-grupogrow.jpg',['style'=>'height: 35px; margin-right: 10px;margin-top: -5px;']); ?>
		            </a>
		        </div>
		        <div class="col-md-1 hidden-xs text-center">
		            <span class="" style="width: 20px;"> | </span>
		        </div>
	            <div class="col-md-3 col-xs-12 text-center">
		            <a class="" href="http://www.unixwork.com.br" title="Powered by Unix Work | Infrastructure as Service" target="_blank">
		                <?php echo $this->Html->image('site/logo-unix-work.png');?>
		            </a>
		        </div>
		        <div class="col-md-1 hidden-xs text-center">
		            <span class="" style="width: 20px;"> | </span>
		        </div>
	            <div class="col-md-2 col-xs-12 text-center">
		            <a class="" href="http://www.digitaluow.com.br" title="Powered by Digital UOW | Agência de Marketing Digital" target="_blank">
		                <?php echo $this->Html->image('site/logo-digitaluow.png');?>
		            </a>
		        </div>
	        </div>
		</div>
	</div>
</footer>
<!-- Footer -->
