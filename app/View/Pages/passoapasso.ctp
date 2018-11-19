<div id='passo-a-passo' class='page'>
	<div class='container'>
		<?php echo $this->Utility->breadcumbs([
			'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
			"{$passoapasso['Grille']['name']}" => ['controller'=>'pages','action'=>'passoapasso','prefixes'=>false]
		]); ?>
		<div class='passo-a-passo'>
			<span class='description'>
				<?php echo $passoapasso['Grille']['text'];?>
			</span>																	
		</div>
	</div>
</div>
