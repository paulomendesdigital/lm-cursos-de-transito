<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * NossaEquipe View
 *
*/ ?>
<div id='our-representants' class='page'>
	<div class='container'>
		<?php echo $this->Utility->breadcumbs([
			'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
			'Nossos Representantes' => ['controller'=>'pages','action'=>'nossosrepresentantes','prefixes'=>false]
		]);
		?>
		<div class='box-representants box-grey'>
			<figure class='main-image'>
				<?php echo $this->Html->image('site/nossos-representantes/main.png',['class'=>'img-responsive']); ?>
			</figure>
			<div class='map-values'>
				<h3>A LM Concursos de Trânsito</h3>
				<?php echo $this->Html->image('site/nossos-representantes/map.png',['class'=>'map']); ?>
				<span class='description'>
					<p>A LM Cursos de Trânsito é uma entidade educacional especializada em cursos na área de trânsito, na modalidade à distância (EAD). Contabiliza mais de 50.000 taxistas em todo Brasil capacitados com o Curso para Taxistas - LEI 12.468/11, 5.000 condutores do Estado do Rio de Janeiro que tiveram sua carteira suspensa e foram aperfeiçoados com o Curso de Reciclagem, 2.000 alunos aprovados nos concursos para Polícia Rodoviária Federal somados ao expressivo número de ex-alunos, atualmente, servidores públicos dos Detran’s pelo Brasil.</p>
					<p><b>Missão:</b> Ofertar a melhor qualificação ao condutor brasileiro, contribuindo assim, para a construção de um trânsito mais humano.</p>
					<p><b>Visão:</b> Tornar-se referência nacional de qualidade em Educação para o Trânsito na modalidade de Ensino a Distância – EAD.</p>
					<p>
						<b>Valores:</b>
						<ul>
							<li>Compromisso com a Educação;</li>
							<li>Ética nos serviços prestados;</li>
							<li>Busca contínua pela satisfação do cliente.</li>
						</ul>
					</p>
				</span>
			</div>
			<div class='the-program'>
				<h3>O Programa de Representação</h3>
				<span class='description'>
					<p>
						Diariamente <b>milhares de carteiras são suspensas e cassadas</b>. O condutor que não tiver ânimo ou tempo para realizar o curso presencial, que leva muitos dias, <b>pode realizar o curso à distância</b>.
					</p>
					<p>
						O <b>LM Cursos de Trânsito</b> oferece para o Estado do Rio de Janeiro o <b>Curso de Reciclagem à distância</b>. Esse é modo mais simples e rápido para se realizar o curso, podendo estudar no smartphone, tablet, notebook ou computador. Os conteúdos estarão disponíveis 24 horas por dia e o aluno poderá concluir o curso no prazo mínimo de 3 dias.
					</p>
					<p>
						Viu que oportunidade? Venha para o LM Cursos de Trânsito ajudar milhares de condutores que tiveram a carteira suspensa oferecendo o modo mais simples e rápido para recuperar a habilitação e ainda ganhe renda extra por isso!
					</p>
				</span>
			</div>
			<div class='features'>
				<h3>Só os Representantes LM Cursos de Trânsito Tem:</h3>
				<ul class='row features-list'>
					<li class='feature col-md-4'>
						<figure>
							<?php echo $this->Html->image('site/nossos-representantes/features/atendimento.png'); ?>
							<figcaption>Atendimento e treinamentos</figcaption>
						</figure>						
					</li>
					<li class='feature col-md-4'>
						<figure>
							<?php echo $this->Html->image('site/nossos-representantes/features/preco.png'); ?>
							<figcaption>Preço especial para representantes</figcaption>
						</figure>						
					</li>
					<li class='feature col-md-4'>
						<figure>
							<?php echo $this->Html->image('site/nossos-representantes/features/10000.png'); ?>
							<figcaption>Ganhe até R$ 10.000,00 mensal</figcaption>
						</figure>						
					</li>
					<li class='feature col-md-4'>
						<figure>
							<?php echo $this->Html->image('site/nossos-representantes/features/palestras.png'); ?>
							<figcaption>Palestras para aperfeiçoamento</figcaption>
						</figure>						
					</li>
					<li class='feature col-md-4'>
						<figure>
							<?php echo $this->Html->image('site/nossos-representantes/features/vendas.png'); ?>
							<figcaption>Acompanhamento das vendas</figcaption>
						</figure>						
					</li>
					<li class='feature col-md-4'>
						<figure>
							<?php echo $this->Html->image('site/nossos-representantes/features/plataforma.png'); ?>
							<figcaption>Plataforma para acompanhamento dos alunos</figcaption>
						</figure>						
					</li>
				</ul>
			</div>
			<figure class='start-now-image'>
				<?php echo $this->Html->image('site/nossos-representantes/start-now.png',['class'=>'img-responsive']); ?>
			</figure>
			<div class='contact'>
				<h3>Contato</h3>
				<span class='description'>
					<i class='fa fa-envelope-o'></i>
					<span>
						<p>Ficou com alguma dúvida? Ou quer conversar com a gente?</p>
						<p>
							Mande um e-mail para <?php echo $this->Html->link(Configure::read('Sistems.EmailTo'),['controller'=>'pages','action'=>'contact','prefixes'=>false]);  ?> ou <br class='hidden-xs'>							
							ligue para <b>(21) 96428-8218 / (21) 3268-3204 / (21) 3268-3207</b>
						</p>
					</span>
				</span>
			</div>
			<div class='wait-you'>
				<h3>Esperamos Você</h3>
			</div>
		</div>
	</div>
</div>