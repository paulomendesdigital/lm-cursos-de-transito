<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Index View
 *
*/ ?>
<div id='home' class='page'>
	<?php echo $this->Element('site/login-box',['class'=>'visible-xs','container'=>true, 'id' => 1]); ?>
	<?php if(!empty($webdoors)){ ?>
		<section id='webdoor-container'>
			<div class='container'>
				<div id="carouselWebdoor" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				  	<?php $i = 0; ?>
				  	<?php foreach($webdoors as $webdoor){ ?>					  	
				    	<li data-target="#carouselWebdoor" data-slide-to="<?php echo $i; ?>" class="<?php echo $i++ == 0 ? 'active' : ''; ?>"></li>					    
					<?php } ?>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner">
				  	<?php $i = 1; ?>
				  	<?php foreach($webdoors as $webdoor){ ?>					  	
				    	<div class="item <?php echo $i++ == 1 ? 'active' : ''; ?>">				    		
				    		<?php $url = !empty($webdoor['Webdoor']['url']) ? $webdoor['Webdoor']['url'] : 'javascript:void(0)'; ?>
				    		<?php $target = !empty($webdoor['Webdoor']['url']) ? $this->Utility->__getTarget($webdoor['Webdoor']['target']) : ''; ?>
				    		<?php $img = $this->Html->image("/files/webdoor/image/{$webdoor['Webdoor']['id']}/vga_{$webdoor['Webdoor']['image']}",['alt'=>$webdoor['Webdoor']['name'],'title' => $webdoor['Webdoor']['name']]); ?>
				    		<?php echo $this->Html->link($img,$url,['escape'=>false,'target'=>$target]); ?>
				    	</div>			      					    
				  	<?php } ?>
				  </div>
				</div>
			</div>
		</section>
	<?php } ?>

	<?php echo !empty($banners) ? $this->Element("site/banner") : ''; ?>

	<section class="reciclagens-buttons">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class='section-title'>Cursos de Reciclagem</h4>
					<hr/>
					
					<div class="row">
						<div class="col-md-1"></div>
						<?php
						$i = 0;
						foreach ($states as $state) {
							
							echo '<div class="col-md-2">';
								echo $this->Html->link($state['name'], ['controller' => 'courses', 'action' => 'view', 'id' => $course['Course']['id'], 'slug' => $this->Utility->__Normalize($course['Course']['name']), 'uf' => $state['abbreviation']], ['class' => 'button btn btn-'.$colorStates[$i], 'escape' => false]);

							echo '</div>';

							$i++;
						}
						?>
						<div class="col-md-1"></div>
					</div>
						
				</div>
			</div>
		</div>

		<hr/>
	</section>

	<section id='courses-login-section'>
		<div class='container'>
			<div class='row'>				
				<div class='col-md-9'>
					<div id='courses'>
						<h4 class='section-title'>Cursos em Destaque</h4>
						<hr/>
						<?php if(!empty($courses)){ ?>
							<ul class='courses-list row'>								
								<?php foreach($courses as $course){ ?>
									<li class='course col-md-4 col-sm-6'>
										<div class='box-course thumbnail'>
											<figure>
												<?php
                                                $img = $this->Html->image('/files/course/image/'.$course['Course']['id'].'/xvga_'.$course['Course']['image'],['alt'=>$course['Course']['name'],'title'=>$course['Course']['name']]);
                                                if ($course['Course']['active_order']) {
                                                    echo $this->Html->link($img, ['controller' => 'courses', 'action' => 'view', 'id' => $course['Course']['id'], 'slug' => $this->Utility->__Normalize($course['Course']['name'])], ['escape' => false]);
                                                } else {
                                                    echo $img;
                                                }
												?>
											</figure>
											<hr/>
											<?php 
											if( $course['Course']['active_order'] ):
												echo $this->Html->link("COMPRAR",['controller'=>'courses','action'=>'view', 'id' => $course['Course']['id'], 'slug' => $this->Utility->__Normalize($course['Course']['name'])],['class'=>'button btn-primary']);
											else:
												echo $this->Html->link("EM BREVE!",'javascript:void(0);',['class'=>'button btn-primary']);
											endif;
											?>
										</div>
									</li>
								<?php } ?>
							</ul>
						<?php }else{ ?>
							<h3 class='orange-text text-center'>Não há cursos disponíveis!</h3>
						<?php } ?>												
					</div>
				</div>
				<div class='col-md-3'>
					<?php echo $this->Element('site/login-box',['class'=>'hidden-xs', 'id' => 2]); ?>
					<div id='our-representants'>
						<?php echo $this->Html->link($this->Html->image('site/nossos-representantes.png'),['controller'=>'pages','action'=>'nossosrepresentantes'],['escape'=>false,'class'=>'thumbnail']); ?>
					</div>
				</div>
			</div>			
		</div>
	</section>
	<?php echo $this->Element('site/phones'); ?>
</div>
