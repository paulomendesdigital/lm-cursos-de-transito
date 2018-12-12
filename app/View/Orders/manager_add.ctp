<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Order View
 *
*/ ?><div class="page-header">
    <div class="page-title">
        <h3><?php echo __($pageTitle);?> <small>Adicionar novo</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>
        <?php echo $this->Html->addCrumb('Adicionar novo', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('Order', array('id' => 'order-add-form', 'class'=>'form-horizontal', 'role'=>'form','autocomplete' => 'off')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Matricular Aluno</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
              <?php
		      echo $this->Form->hidden('order_type_id',array('value'=>$paymentStatus));
              echo $this->Form->hidden('User.id', ['class' => 'input-user-id']);
		      echo $this->Form->hidden('User.Student.0.id', ['class' => 'input-student-id']);
              echo $this->Form->hidden('User.Student.0.cpf', array('class'=>'input-cpf'));
              echo $this->Form->hidden('User.Student.0.birth', array('class'=>'input-birth'));
              echo $this->Form->hidden('OrderCourse.0.cod_cfc', array('class'=>'input-cod-cfc', 'value' => isset($user['User']['School']['cod_cfc']) ? $user['User']['School']['cod_cfc'] : null));
		      ?>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php
                        if ($user) {
                            echo $this->Form->input('user_id', array('type' => 'text', 'class' => 'input-user form-control auto-select2', 'label' => __('Aluno'), 'required' => true, 'data-url' => '/manager/users/ajaxSelect2Students', 'data-initial-id' => $user['User']['id'], 'data-initial-text' => $user['Student']['name'] . ' - ' . $user['User']['cpf']));
                        } else {
                            echo $this->Form->input('user_id', array('type' => 'text', 'class' => 'input-user form-control auto-select2', 'label' => __('Aluno'), 'required' => true, 'data-url' => '/manager/users/ajaxSelect2Students', 'placeholder' => 'Selecione'));
                        }
                        ?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Html->link('Novo aluno', array('controller' => 'users', 'action' => 'add_student'), array('class' => 'btn btn-xs btn-default')); ?>
                        <?php echo $this->Html->link('Editar o aluno selecionado', isset($user['User']['id']) ? '/manager/users/edit_student/' . $user['User']['id'] : '', array('class' => 'btn-editar btn btn-xs btn-default', 'style' => isset($user['User']['id']) ? '' : 'display:none')); ?>
                        <span class="auto-escola" style="margin-left: 10px; font-weight: bold"><?php echo isset($user['User']['School']['name']) ? ('Autoescola: ' . $user['User']['School']['name'] . (isset($user['User']['School']['cod_cfc']) ? ' - Cód. CFC: ' . $user['User']['School']['cod_cfc'] : '') ) : ''?></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('User.Student.0.cpf', array('class'=>'input-cpf form-control', 'disabled' => true, 'label'=>__('cpf')));?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('OrderCourse.0.cnh', array('class'=>'input-cnh form-control', 'minlength' => 11, 'maxlength' => 11, 'label'=>__('CNH')));?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('OrderCourse.0.renach', array('class'=>'input-renach form-control text-uppercase', 'minlength' => 11, 'maxlength' => 11, 'label'=>__('RENACH')));?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('OrderCourse.0.cnh_category', array('class'=>'input-cnh_category form-control', 'empty' => ' ', 'label'=>__('Categoria CNH')));?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('OrderCourse.0.course_id', array('type' => 'select','class' => 'input-course form-control', 'options' => $courses, 'empty' => 'Selecione o curso', 'required'=>true,'onchange'=>'courseChange(this, \'OrderCourse\', 0)')); ?>
                    </div>

                    <div class="col-md-6">
                        <?php
                        echo $this->Form->input('value', array('class' => 'form-control', 'type' => 'number', 'label'=> ['text' => __('price'), 'class' => 'col-sm-2 control-label text-right'], 'divControls' => ['class' => 'col-sm-10']));
                        ?>
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12 col-tipo_reciclagem" style="display: none">
                        <?php echo $this->Form->input('OrderCourse.0.tipo_reciclagem', array('class'=>'input-tipo_reciclagem form-control', 'options' => ['' => '', '1' => 'Reciclagem Preventiva', '2' => 'Reciclagem Infrator'], 'label'=>__('Tipo Reciclagem')));?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 state">
                        <?php echo $this->Form->input('OrderCourse.0.state_id', array('required'=>true,'class'=>'input-state form-control','label'=>__('state_id'), 'empty'=>'Selecione', 'data-reference'=>'state', 'onchange'=>'stateChange(this, \'OrderCourse\', 0)')); ?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 city">
                        <?php echo $this->Form->input('OrderCourse.0.citie_id', array('class'=>'input-city form-control','required'=>true,'label'=>__('citie_id'), 'data-reference'=>'city', 'options' => $cities, 'empty'=>'Selecione'));?>
                    </div>
                </div>


                <!-- <a data-toggle="addOrderCourse" class="btn btn-icon btn-primary" title="Adicionar novo curso"><i class="icon-plus"></i></a> -->
                <input type="hidden" data-toggle="countOrderCourse" value="1">
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
     <?php echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>    <input type="submit" class="btn btn-primary" value="Salvar" name="aplicar" >
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>

<script>

    var coursesType     =  <?php echo json_encode($coursesType);?>;
    var currentUserData = null;

    processScope('<?php echo $scope;?>');

    $('.input-user').on('change', function (e) {

        if (e.added && e.added.extra && e.added.extra.User && e.added.extra.Student) {
            currentUserData = e.added.extra;

            var user    = e.added.extra.User;
            var student = e.added.extra.Student;
            var school  = e.added.extra.School;

            $('.btn-editar').attr('href', '/manager/users/edit_student/' + user.id);
            $('.btn-editar').show();

            if (school && school.hasOwnProperty('name') && school.name) {
                var cod_cfc = school.hasOwnProperty('cod_cfc') && school.cod_cfc ? school.cod_cfc : '';
                $('.auto-escola').html('Autoescola: ' + school.name + (cod_cfc ? ' - Cód. CFC: ' + cod_cfc : ''));
                $('.input-cod-cfc').val(cod_cfc);
            } else {
                $('.auto-escola').html('');
                $('.input-cod-cfc').val('');
            }

            $('.input-user-id').val(user.id);
            $('.input-student-id').val(student.id);
            $('.input-cpf').val(user.cpf);
            $('.input-renach').val(student.renach);
            $('.input-cnh').val(student.cnh);
            $('.input-cnh_category').val(student.cnh_category);
            $('.input-birth').val(student.birth);
            if (student.state_id) {
                $('.input-state').val(student.state_id).change();
            }
            if ($('.input-state').val() == student.state_id && student.city_id) {
                $('.input-city').val(student.city_id);
            }
        } else {
            $('.input-user-id').val('');
            $('.input-student-id').val('');

            $('.btn-editar').hide();
            $('.input-cpf').val('');
            $('.input-renach').val('');
            $('.input-cnh').val('');
            $('.input-cnh_category').val('');
            $('.input-birth').val('');
        }
    });

    $('.input-state').on('change', function () {
       if (currentUserData) {
           $(document).ajaxStop(function () {
               if ($('.input-state').val() == currentUserData.Student.state_id && currentUserData.Student.city_id) {
                   //$('.input-city').val(currentUserData.Student.city_id);
               }
               $(this).unbind("ajaxStop");
           });
       }
    });

    $('.input-course,.input-state').on('change', function () {
        var course_type_id = coursesType[$('.input-course').val()];
        var state_id       = $('.input-state').val();

        if (course_type_id == 3) { //CURSO DE RECICLAGEM
            if (state_id == 19) { //RJ
                $('.input-cpf,.input-renach,.input-cnh_category').attr('required', true);
            } else if (state_id == 2 || state_id == 26) { //SE E AL
                $('.input-cpf').attr('required', true);
                $('.input-renach,.input-cnh_category').attr('required', false);
            } else if (state_id == 16) {
                $('.input-cpf,.input-cnh,.input-birth').attr('required', true);
                $('.input-renach,.input-cnh_category,.input-birth').attr('required', false);
            } else if (state_id == 10) { //MA
                $('.input-cpf').attr('required', true);
                $('.input-renach,.input-cnh_category').attr('required', false);
            }
        } else {
            $('.input-cpf,.input-renach,.input-cnh_category').attr('required', false);
        }
    });

    $('#order-add-form').on('submit', function() {

        var course_type_id = coursesType[$('.input-course').val()];
        var state_id       = $('.input-state').val();

        if (course_type_id == 3 && state_id != 19 && state_id != 26 && state_id != 2 && state_id != 16 && state_id != 10) {
            return confirm("Este curso ainda não está integrado ao estado selecionado. Deseja continuar?");
        } else {
            return true;
        }
    });
</script>


<?php echo $this->Form->end(); ?>
