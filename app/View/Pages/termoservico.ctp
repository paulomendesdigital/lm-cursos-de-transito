<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Termo de Serviço View
 *
*/ ?>
<div id='terms-service' class='page'>
	<div class='container'>
		<?php echo $this->Utility->breadcumbs([
			'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
			"{$termoservico['Grille']['name']}" => ['controller'=>'pages','action'=>'termoservico','prefixes'=>false]
		]);
		?>
		<div class='big-box box-grey'>
			<span class='description'>
			<?php echo $termoservico['Grille']['text'];?>					    
			</span>
		</div>
	</div>
</div>