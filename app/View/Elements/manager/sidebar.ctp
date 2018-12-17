<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.grupogrow.com.br
 * Sidebar
 *
*/ ?>
<div class="sidebar">
	<div class="sidebar-content">
		<!-- User dropdown -->
		<div class="user-menu dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<div class="user-info">
					<?php echo $Auth['name'];?><span><?php echo $Auth['Group']['name'];?></span>
				</div>
			</a>
		</div>
		<!-- /user dropdown -->

		<!-- Main navigation -->
		<ul class="navigation">

			<!-- ### PÁGINAS INSTITUCIONAIS ###-->
			<li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='grilles') )?'active' :''; ?>">
				<?php echo $this->Html->link('<span>Institucionais</span> <i class="icon-newspaper"></i>', array('controller' => 'grilles', 'action' => 'index'),array('escape'=>false));?>
			</li>

			<!-- ### AUTO ESCOLAS ###-->
			<li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='schools') )?'active' :''; ?>">
				<?php echo $this->Html->link('<span>Auto Escolas</span> <i class="icon-home4"></i>', array('controller' => 'schools', 'action' => 'index'),array('escape'=>false));?>
			</li>

			<!-- ### WEBDOORS ###-->
			<li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='webdoors') )?'active' :''; ?>">
				<?php echo $this->Html->link('<span>Webdoors</span> <i class="icon-images"></i>', array('controller' => 'webdoors', 'action' => 'index'),array('escape'=>false));?>
			</li>
			
			<!-- ### VENDAS ###-->
			<li>
				<li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='orders') )?'active' :''; ?>">
					<?php echo $this->Html->link('<span>Matrículas</span> <i class="icon-cart"></i>', array('controller'=>'orders','action'=>'index'), array('escape' => false));?>
				</li>
			</li>

			<!-- ### ALUNOS ###-->
			<li>
				<li class="<?php echo (($this->params['controller'] == 'users') && ($this->params['action']=='manager_students') )?'active' :''; ?>">
					<?php echo $this->Html->link('<span>Alunos</span> <i class="icon-users"></i>', array('controller'=>'users','action'=> 'students'), array('escape' => false));?>
				</li>
			</li>

			<!-- ### PROFESSORES ###-->
			<li>
				<li class="<?php echo ($this->params['action']=='manager_instructors')?'active' :''; ?>">
					<?php echo $this->Html->link('<span>Professores</span> <i class="icon-user4"></i>', array('controller' => 'users', 'action' => 'instructors'), array('escape' => false));?>
				</li>
			</li>

			<!-- ### TIPOS DE CURSOS ###-->
			<li class="<?php echo \Hash::inArray($this->params['controller'], ['course_states','course_types']) ? 'active' :''; ?>">
				<?php echo $this->Html->link('<span>Tipos de curso</span> <i class="icon-list"></i>', array('controller' => 'course_types', 'action' => 'index'), array('escape' => false));?>
			</li>

			<!-- ### MÓDULOS ###-->
			<li class="<?php echo in_array($this->params['controller'], ['modules','module_disciplines'])?'active' :''; ?>">
				<?php echo $this->Html->link('<span>Módulos e Unidades</span> <i class="icon-puzzle3"></i>', array('controller' => 'modules', 'action' => 'index'),array('escape'=>false));?>
			</li>

			<!-- ### CURSOS ###-->
			<li class="<?php echo in_array($this->params['controller'], ['courses'])?'active' :''; ?>">
				<?php echo $this->Html->link('<span>Cursos</span> <i class="icon-book2"></i>', array('controller' => 'courses', 'action' => 'index'),array('escape'=>false));?>
			</li>

			<!-- ### BANCO DE QUESTÕES ###-->
			<li class="<?php echo in_array($this->params['controller'], ['question_alternatives'])?'active' :''; ?>">
				<?php echo $this->Html->link('<span>Banco de Questões</span> <i class="icon-question2"></i>', array('controller' => 'question_alternatives', 'action' => 'index'),array('escape'=>false));?>
			</li>

			<!-- ### ENQUETES ###-->
			<li class="<?php echo in_array($this->params['controller'], ['polls'])?'active' :''; ?>">
				<?php echo $this->Html->link('<span>Avaliação de Curso</span> <i class="icon-bubble4"></i>', array('controller' => 'polls', 'action' => 'index'),array('escape'=>false));?>
			</li>

			<!-- ### FORUNS ###-->
			<li>
				<a href="#"><span>Fóruns</span> <i class="icon-megaphone"></i></a>
				<ul>
					<li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='forums') )?'active' :''; ?>">
						<?php echo $this->Html->link('Listar Tópicos', array('controller' => 'forums', 'action' => 'index'));?>
					</li>
					<li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='forum_posts') )?'active' :''; ?>">
						<?php echo $this->Html->link('Listar Postagens', array('controller' => 'forum_posts', 'action' => 'index'));?>
					</li>
					<li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='forum_post_comments') )?'active' :''; ?>">
						<?php echo $this->Html->link('Listar Cómentários', array('controller' => 'forum_post_comments', 'action' => 'index'));?>
					</li>
				</ul>
			</li>

            <!-- ### TUTORIA ###-->
            <li>
                <a href="#"><span>Tutoria</span> <i class="icon-bubbles"></i></a>
                <ul>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='direct_messages') ) ? 'active' :''; ?>">
                        <?php echo $this->Html->link('Minhas Mensagens', array('controller' => 'direct_messages', 'action' => 'index',  'opt' => 'minhas'));?>
                    </li>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='direct_messages') ) ? 'active' :''; ?>">
                        <?php echo $this->Html->link('Mensagens não vistas', array('controller' => 'direct_messages', 'action' => 'index', 'opt' => 'nao_vistas'));?>
                    </li>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='direct_messages') ) ? 'active' :''; ?>">
                        <?php echo $this->Html->link('Todas as Mensagens', array('controller' => 'direct_messages', 'action' => 'index'));?>
                    </li>
                </ul>
            </li>

			<!-- ### RELAÓRIOS ###-->
			<li>
				<a href="#"><span>Relatórios</span> <i class="icon-bars"></i></a>
				<ul>
					<li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='reports') )?'active' :''; ?>">
						<?php echo $this->Html->link('Aprovados', array('controller' => 'reports', 'action' => 'approvals'));?>
					</li>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='reports') )?'active' :''; ?>">
                        <?php echo $this->Html->link('Vendas', array('controller' => 'reports', 'action' => 'sales'));?>
                    </li>
				</ul>
			</li>

			<!-- ### NOTAS DE SERVIÇOS ###-->
			<li class="<?php echo \Hash::inArray($this->params['controller'], ['course_states','course_types']) ? 'active' :''; ?>">
				<?php echo $this->Html->link('<span>Notas Serviços</span> <i class="icon-barcode"></i>', array('controller' => 'invoices', 'action' => 'index'), array('escape' => false));?>
			</li>

            <!-- ### CUPONS DE DESCONTO ###-->
            <li class="<?php echo in_array($this->params['controller'], ['tickets']) ? 'active' : ''; ?>">
                <?php echo $this->Html->link('<span>Cupons de Desconto</span> <i class="icon-tag4"></i>', array('controller' => 'tickets', 'action' => 'index'),array('escape'=>false));?>
            </li>

			<!-- ### SISTEMAS ###-->
			<li>
				<a href="#"><span>Sistema</span> <i class="icon-cogs"></i></a>
				<ul>
					<li class="<?php echo ( $this->params['action']=='manager_administrators')?'active' :''; ?>">
						<?php echo $this->Html->link('Listar Administradores', array('controller'=>'users','action'=>'index'));?>
					</li>
					<li class="<?php echo ( $this->params['controller']=='groups' )?'active' :''; ?>">
						<?php //echo $this->Html->link('Grupos', array('controller' => 'groups', 'action' => 'index'));?>
					</li>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='log_detrans') )?'active' :''; ?>">
                        <?php echo $this->Html->link('Logs de Integração c/ Detrans', array('controller'=>'log_detrans','action'=>'index'));?>
                    </li>

					<?php if( \Hash::inArray( $Auth['username'], $Sistems['superAdmins'] ) ):?>
						
						<!-- ### STATUS DE VENDAS ###-->
						<li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='order_types') )?'active' :''; ?>">
							<?php echo $this->Html->link('Tipos de Status de Vendas', array('controller' => 'order_types', 'action' => 'index'));?>
						</li>
					<?php endif;?>
				</ul>
			</li>

		</ul>
		<!-- /main navigation -->
	</div>
</div>
