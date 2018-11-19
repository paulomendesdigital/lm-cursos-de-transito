<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * QuemSomos View
 *
*/ ?>
<div id='who-we-are' class='page'>
	<div class='container'>
		<?php echo $this->Utility->breadcumbs([
			'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
			"{$quemsomos['Grille']['name']}" => ['controller'=>'pages','action'=>'quemsomos','prefixes'=>false]
		]); ?>
		<div class='box-who-we-are box-grey big-box'>
			<span class='description'>
				<?php echo $quemsomos['Grille']['text'];?>					
			</span>																	
		</div>
	</div>
</div>