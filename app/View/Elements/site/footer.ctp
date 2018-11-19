<footer id='footer'>
	<div class='footer-main'>
		<div class='container'>
			<div class='row'>
				<div class='col-md-2 col-menu'>
					<h3 class='menu-title' data-target='#menu-footer-1'>Menu</h3>									
					<nav id='menu-footer-1' class='menu footer-col-content menu-site-map'>
						<ul>
							<li><?php echo $this->Html->link('Início',['controller'=>'pages','action'=>'index','prefixes'=>false],['class'=>'active']); ?></li>
							<li><?php echo $this->Html->link('Quem Somos','javascript:void(0)'); ?></li>
							<li><?php echo $this->Html->link('Nossa Equipe','javascript:void(0)'); ?></li>
							<li><?php echo $this->Html->link('Termo de Serviço','javascript:void(0)'); ?></li>
						</ul>
					</nav>					
				</div>
				<div class='col-md-4 col-distance'>
					<h3 class='menu-title' data-target='#menu-footer-2'>Ensino a Distância</h3>
					<div class='footer-col-content'>						
						<nav id='menu-footer-2' class='menu'>
							<ul>
								<?php for($i = 1; $i<=2;$i++){ ?>
									<li><?php echo $this->Html->link('Curso '.$i,'javascript:void(0)'); ?></li>					
								<?php } ?>	
							</ul>
						</nav>
						<?php echo $this->Html->image('site/logo-footer.png',['class'=>'logo-footer']); ?>
					</div>
				</div>
				<div class='col-md-4 col-lm'>
					<h3>LM Cursos de Trânsito</h3>
					<div class='footer-col-content'>
						<p><b>E-mail:</b> <?php echo $this->Html->link(Configure::read('Sistems.EmailTo'),'mailto:'.Configure::read('Sistems.EmailTo'));  ?></p>
						<p>Endereço - Estrada do Cafundá, 820, Sala 202 - Tanque, Rio de Janeiro - RJ, 22730-540</p>
						<p>CNPJ: <?php echo Configure::read('Sistems.CNPJ'); ?></p>
						<ul class='socials'>
							<li><?php echo $this->Html->link("<i class='fa fa-youtube-square fa-3x'></i>",'https://www.youtube.com/channel/UCpxwxlQyLFbtMusdmT3ExOQ',['escape'=>false,'class'=>'social', 'title' => 'YouTube']); ?></li>
							<li><?php echo $this->Html->link("<i class='fa fa-envelope-square fa-3x'></i>",'mailto:'.Configure::read('Sistems.EmailTo'),['escape'=>false,'class'=>'social', , 'title' => 'E-mail']); ?></li>
                            <li><?php echo $this->Html->link("<i class='fa fa-facebook-square fa-3x'></i>",'https://www.facebook.com/lmcursosdetransito',['escape'=>false,'class'=>'social', 'title' => 'Facebook']); ?></li>
                            <li><?php echo $this->Html->link("<i class='fa fa-instagram fa-instagram-square fa-3x'></i>",'https://www.facebook.com/lmcursosdetransito',['escape'=>false,'class'=>'social', 'title' => 'Instagram']); ?></li>
						</ul>
					</div>
				</div>
				<div class='col-md-2 col-work-hour'>
					<h3>Atendimento</h3>
					<div class='footer-col-content'>
						<ul class='work-hours'>
							<li><b>Seg. à Sex.</b> 08h às 20h</li>
							<li><b>Sábado</b> 08h às 14h</li>
							<li><b>Domingo</b> 08h às 12h</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='copyright text-center'>
		<div class='container'>
			© 2015, LM Cursos de Trânsito, Todos os direitos reservados
		</div>
	</div>
</footer>

<!-- Footer -->
<!-- <footer class="footer">
    <strong><?php echo $Developer['Title'];?></strong> v1.0.0 &copy; Copyright <?php echo date('Y');?>
</footer> -->
