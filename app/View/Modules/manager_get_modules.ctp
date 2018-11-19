<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleCourse View
 *
*/ ?>

<?php echo $this->Form->create('Module', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <h3>Escolha de qual tipo de curso deseja importar:</h3>
                <?php
                echo $this->Form->input('course_types', array('data-toggle'=>'listCourseTypes', 'class'=>'form-control', 'empty'=>'Selecione', 'required'=>true,'options'=>$course_types, 'label'=>false));
        		//echo $this->Form->input('states', array('class' => 'form-control', 'multiple' => true, 'label'=>__('Estados')));
                ?>
                <div class="row">
                    <div class="col-md-12" id="returnModules"></div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>

<?php echo $this->Form->end(); ?>

<?php //if( isset($isAjax) and $isAjax ):?>
    <script>
        $(document).ready(function(){
            //carregar cidades pelo estado (campo unico no form)
            $('select[data-toggle="listCourseTypes"]').on('change',function () {
                var course_type_id = $(this).val();

                if( course_type_id ){
                    $('#returnModules').html("carregando...");
                    $.get('/modules/ajax_getModules/'+course_type_id,function(modules){
                        if( modules ){
                            $('#returnModules').html( modules );
                        }
                    });
                }
            });
        });
    </script>
<?php //endif;?>