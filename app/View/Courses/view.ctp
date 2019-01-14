<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * NossaEquipe View
 *
*/ ?>
<div id='course' class='page'>
	<div class='container'>
		<?php echo $this->Utility->breadcumbs([
			'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
			$course['Course']['name'] => ['controller'=>'courses','action'=>'view',$course['Course']['id'],'prefixes'=>false]
		]);
		?>
		<section class="course">
			<?php if(!empty($course)){ ?>
				<h1 class='course-name'><?php echo $course['Course']['name'];?></h1>

                <?php if ($recycle) {?>
                    <div class="row">
                        <div class="col-xs-12">
                            <article class="course-description">
                                <figure class="course-image thumbnail">
                                    <?php echo $this->Html->image('/files/course/image/'.$course['Course']['id'].'/xvga_'.$course['Course']['image'],['alt'=>$course['Course']['name'],'title'=>$course['Course']['name']]); ?>
                                </figure>
                                <?php echo ($currentCourseState && !empty($currentCourseState['CourseState']['description'])) ? $currentCourseState['CourseState']['description'] : $course['Course']['excerpt']; ?>
                            </article>
                        </div>
                    </div>
                    <?php if ($currentCourseState) {?>
                        <div class="row">
                            <div class="col-xs-12">

                                <?php $sender = 'LM'; ?>
                                <?php echo $this->Element('site/course-cart-form', ['course' => $course, 'course_scopes' => $course_scopes, 'currentCourseState' => $currentCourseState, 'sender' => $sender]); ?>
                            </div>
                        </div>
                        
                        <?php echo $this->Element('site/phones'); ?>

                        <?php echo $this->Element('site/credenciamentos'); ?>

                        <div class="row">
                            <div class="col-xs-12">
                                <article class="course-description">
                                    <?php echo !empty($currentCourseState['CourseState']['text']) ? $currentCourseState['CourseState']['text'] : $course['Course']['text']; ?>
                                </article>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="row">

                        <div class="col-md-9">
                            <article class="course-description">
                                <figure class="course-image thumbnail">
                                    <?php echo $this->Html->image('/files/course/image/'.$course['Course']['id'].'/xvga_'.$course['Course']['image'],['alt'=>$course['Course']['name'],'title'=>$course['Course']['name']]); ?>
                                </figure>
                                <?php echo $course['Course']['excerpt']; ?>
                                <?php echo $course['Course']['text']; ?>
                            </article>
                        </div>
                        <div class="col-md-3">
                            <?php echo $this->Element('site/course-cart-form', ['class' => 'vertical']); ?>
                        </div>
                    </div>
                <?php } ?>

				<div class='modules-container'>
					<?php if(!empty($course['ModuleCourse'])){ ?>
						<?php echo $this->Element('site/course-modules-table',['course'=>$course, 'view' => true]); ?>
					<?php } ?>
				</div>
			<?php }else{ ?>
				<h1 class='course-name orange-text'>Curso não encontrado</h1>
			<?php } ?>
		</section>
	</div>

    <div id="modal-estado" class="modal fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <?php echo $this->Html->image('site/logo-header.png'); ?>
                </div>
                <div class="modal-title">Selecione o Estado abaixo no qual irá estudar</div>

                <div class="modal-body">
                        <?php echo $this->Form->input('state_id',['empty'=>'Selecione o estado','required'=>true,'options'=>$statesAbbreviation,'label'=>false,'div'=>false, 'class' => 'form-control', 'id' => 'selecaoEstado']); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" onclick="goToEstado()">OK</button>
                </div>
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
</div>

<div class="modal fade in" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="modalCategoriaLabel" style="padding-right: 17px;" aria-hidden="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="modalCategoriaLabel">Categoria da CNH</h4>
      </div>
      <div class="modal-body">
		    <table class="table table-striped table-condensed">
			    <thead>
			      <tr>
			        <th><strong>CATEGORIA</strong></th>
			        <th><strong>ESPECIFICAÇÃO</strong></th>
			      </tr>
			    </thead>
			    <tbody>
			      <tr>
			        <td>A</td>
			        <td>Motocicleta, Ciclomotor, Motoneta ou Triciclo.</td>
			      </tr>
			      <tr>
			        <td>B</td>
			        <td>Automóvel, caminhonete, camioneta, utilitário. </td>
			      </tr>
			      <tr>
			        <td>C</td>
			        <td>Caminhão. O trator de roda, o trator de esteira, o trator misto ou o equipamento automotor destinado à movimentação de cargas ou execução de trabalho agrícola, de terraplenagem, de construção ou de pavimentação. Combinação de veículos em que a unidade acoplada, reboque, não exceda a 6.000 kg.</td>
			      </tr>
			      <tr>
			        <td>D</td>
			        <td>Microônibus, Ônibus. </td>
			      </tr>
			      <tr>
			        <td>E</td>
			        <td>Ônibus Articulado, Ônibus Biarticulado, veículo com dois reboques acoplados.</td>
			      </tr>
			      <tr>
			        <td>ACC</td>
			        <td>Ciclomotores. Condutor de veículos de duas ou três rodas com potência até 50 cilindradas.</td>
			      </tr>
			    </tbody>
			  </table>
    	</div>
  	</div>
	</div>
</div>

<script>
	window.addEventListener('DOMContentLoaded', function() {

          getModuleCourseCityOptionsTrigger();
          course_scopes = new Array();
          <?php foreach($course_scopes as $key => $value){ ?>
            course_scopes['<?php echo $key; ?>'] = <?php echo $value; ?>;
          <?php } ?>

            $("[data-toggle='course-module-state']").val('');
            $("[data-toggle='course-module-city']").val('');

            $("#cart-form").validate();
            $("#cart-form").on('submit', function() {
                if ($("#cart-form").valid()) {
                    $('.btn-matricula').attr('disabled', 'disabled');
                    $('.btn-matricula').html('Aguarde...');
                }
            });


        <?php if ($recycle && !isset($currentCourseState)) { ?>
        $('#modal-estado').modal({backdrop: 'static', keyboard: false});
        <?php } ?>
    }, true);

	function goToEstado() {
	    if ($('#selecaoEstado').val() != '') {
            var url = '<?php echo Router::url(['controller' => 'courses', 'action' => 'view', 'id' => $course['Course']['id'], 'slug' => $this->Utility->__Normalize($course['Course']['name'])], true);?>';
            window.location = url + '/' + $('#selecaoEstado').val();
        }
    }

</script>
