<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Element View
 *
*/ ?>
<div class="panel panel-default curriculum <?php echo $module['Module']['desblock']?'open':''; ?> paper-shadow" data-z="0.5">
  <div class="panel-heading panel-heading-gray" data-toggle="collapse" data-target="#module-<?php echo $module['Module']['id'];?>">

    <?php 
    $progress_in_module = (isset($progress_in_module) and $progress_in_module) ? true : false;
    $in_column_right = (isset($in_column_right) and $in_column_right) ? true : false;

    echo $this->Utility->__ShowTitleModule($module, $progress_in_module, $in_column_right);
    ?>
    
    <span class="collapse-status collapse-open"><i class="fa fa-fw fa fa-angle-double-down"></i></span>
    <span class="collapse-status collapse-close"><i class="fa fa-fw fa fa-angle-double-up"></i></span>
  </div>
  <div class="disciplines-list list-group collapse <?php echo $module['Module']['desblock']?'in':''; ?>" id="module-<?php echo $module['Module']['id'];?>">
     
    <?php /* Lista de disciplinas */ ?>
    <?php if( isset($module['Module']['ModuleDiscipline']) and !empty($module['Module']['ModuleDiscipline']) ):?>
     <?php $i = 1; foreach ($module['Module']['ModuleDiscipline'] as $module_discipline): ?>
     <?php 
       $url_discipline_module = $module_discipline['desblock']? Router::url('/', true).'meus-cursos/discipline/'.$this->params['pass'][0].'/'.$module_discipline['token']:'javascript:void();'; ?>
       <div style="<?php echo isset($page_progress) ? 'min-height: 80px;' : '';?>" class="list-group-item media <?php echo $this->Utility->__getBgColorModuleList($module_discipline['is_discipline_complete']);?>" data-target="<?php echo !isset($progress) || !$progress ? $url_discipline_module : 'javascript:void(0)';?>">
	        <div class="media-left">
	           <div class="text-crt"><?php echo $i;?>.</div>
	        </div>
	        <div class="media-body">
            
            <?php $showProgress = isset($page_progress) and $page_progress ? true : false;?>
            <?php echo $this->Utility->__ShowLineDiscipline($module, $module_discipline, $showProgress, $in_column_right);?>
            
	        </div>
	     </div>
     <?php $i++; endforeach;?>
    <?php endif;?>
    <?php 
    /* Se o módulo não está concluído com a carga horária, bloqueia a avaliação do curso e a avaliação do módulo */
    if( !$module['Module']['is_time_complete'] ):
      $is_avaliation_result_certificate_block = true; 
      $is_avaliation_module_block = true; 
    endif;
    ?>

    <?php 
    /* Se o módulo tiver avaliação */
    if( $module['Module']['is_show_avaliation'] ):
    	
    	$mensage_avaliation_module = '';
    	$url_simulate_module = '';
    	$cicle = 'text-grey-200';
      $label_simulado = 'Fazer Simulado';

    	if(isset($is_avaliation_module_block)):
    		$is_avaliation_result_certificate_block = true;
  		endif;
      
  		if( $module['Module']['is_avaliation_result'] ):
      	$mensage_avaliation_module = '<span class="text-green-300"><i class="fa fa-fw fa-trophy"></i> Parabéns! Você atingiu '.$module['Module']['avaliation_value_result'].' %.</span>';
      	$cicle = 'text-green-300';
        $url_simulate_module = isset($is_avaliation_module_block)? '':Router::url('/', true).'meus-cursos/simulate_result/'.$this->params['pass'][0].'/'.$module['Module']['avaliation_result_id'];
  			unset($is_avaliation_result_certificate_block);
        $label_simulado = 'Ver Simulado';
  		else:
  			if( $module['Module']['avaliation_value_result'] ):
  				$mensage_avaliation_module = '<span class="text-red-300">Pts mínimos não atingidos! Você acertou '.number_format($module['Module']['avaliation_value_result'],0).'%, o mínimo necessário é '.number_format($module['Course']['value_module_avaliation'],0).'%.</span>';
  				$cicle = 'text-red-200';
          $label_simulado = 'Refazer Simulado';
  			endif;
  				$url_simulate_module = isset($is_avaliation_module_block)? '':Router::url('/', true).'meus-cursos/simulate_modules/'.$this->params['pass'][0].'/'.$module['Module']['token'];
  		endif;

      	echo '<div class="list-group-item media bg-grey-200 text-center" data-target="'.$url_simulate_module.'">
      		<h3 class="text-grey-500"><i class="fa fa-fw fa-edit"></i> '.$label_simulado.'</h3>
      		'.$mensage_avaliation_module.'
  		</div>';
  	endif;
	?>

  </div>
</div>