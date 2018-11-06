<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * NossaEquipe View
 *
*/ ?>
<div id='our-team' class='page'>
	<div class='container'>
		<?php echo $this->Utility->breadcumbs([
			'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
			'Nossa Equipe' => ['controller'=>'instructores','action'=>'index','prefixes'=>false]
		]);
		?>
		<div class='big-box box-grey'>
			<div class='resource-list'>
				<?php $i=1; foreach ($instructors as $instructor) :?>
					<div class='resource'>
						<div class='row'>
							<div class=' col-sm-4 col-photo'>
								<figure class='resource-photo thumbnail'>
									<?php echo $this->Html->image("/files/user/avatar/{$instructor['User']['id']}/vga_{$instructor['User']['avatar']}"); ?>
								</figure>
							</div>
							<div class=' col-sm-8 col-description'>
								<h1 class='resource-name'><?php echo $instructor['Instructor']['name'];?></h1>
								<?php echo $instructor['Instructor']['text'];?>
							</div>
						</div>
					</div>
					<?php if( $i < $instructors): ?>
						<hr/>
					<?php endif;?>
				<?php $i++; endforeach;?>
			</div>
		</div>
	</div>
</div>