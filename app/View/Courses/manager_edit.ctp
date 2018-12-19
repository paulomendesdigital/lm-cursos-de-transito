<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Course View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>
        <?php echo $this->Html->addCrumb('Editar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>
<?php echo $this->Form->create('Course',array('class'=>'form-horizontal','role'=>'form','type'=>'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
            <li><a href="#modules" data-toggle="tab">Módulos</a></li>
            <li><a href="#libraries" data-toggle="tab">Biblioteca Virtual</a></li>
            <li><a href="#books" data-toggle="tab">Apostilas</a></li>
            <li><a href="#multimidia" data-toggle="tab">Sala Multimidia</a></li>
            <?php if ($courseType['scope'] == CourseType::AMBITO_ESTADUAL) { ?><li><a href="#states" data-toggle="tab">Dados por Estado</a></li><?php } ?>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <div class="row">
                    <div class="col-md-8"> 
                        <?php
                         echo $this->Form->input('id');
                         echo $this->Form->input('active_order', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'active_order', 'label'=> ['text' => __('Ativar Vendas'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6']));
                         if( !empty($this->request->data['Course']['image']) ){
                            echo '<div class="form-group text-center">';
                            echo $this->Html->image("/files/course/image/{$this->request->data['Course']['id']}/thumb_{$this->request->data['Course']['image']}?".time(),['class'=>'img-responsive img-thumbnail']);
                            echo "</div>";
                         }
                         $text_after_guide = $this->request->data['Course']['student_guide'] ? '<small class="text-warning">Guia enviado!</small>' : '';
                         $text_after_navigability_guide = $this->request->data['Course']['navigability_guide'] ? '<small class="text-warning">Guia enviado!</small>' : '';
                         echo $this->Form->input('image', array('type' => 'file','class' => 'form-control', 'label'=>__('Imagem')));
                         echo $this->Form->input('student_guide', array('type' => 'file','class' => 'form-control', 'label'=>__('Guia do Aluno'), 'after'=>$text_after_guide));
                         echo $this->Form->input('navigability_guide', array('type' => 'file','class' => 'form-control', 'label'=>__('Guia de Navegabilidade'), 'after'=>$text_after_navigability_guide));
                         echo $this->Form->input('ordination', array('class' => 'form-control', 'data-mask' => 'number', 'label'=>'Ordenação'));
                         echo $this->Form->input('name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));
                         echo $this->Form->input('firstname', array('class' => 'form-control', 'data-mask' => 'firstname', 'label'=>__('firstname')));
                         echo $this->Form->input('course_type_id', array('class' => 'form-control', 'data-mask' => 'course_type_id', 'label'=>__('course_type_id')));
                         echo $this->Form->input('excerpt', array('class' => 'form-control ckeditor', 'id'=>'ckfinder1', 'label'=>__('excerpt')));
                         echo $this->Form->input('text', array('class' => 'form-control ckeditor', 'id'=>'ckfinder2', 'label'=>__('text')));
                         echo $this->Form->input('description_certificate', array('class' => 'form-control', 'label'=>__('description_certificate'), 'helpBlock' => 'Descrição apresentada no verso do certificado.'));
                         echo $this->Form->input('Instructor.Instructor', array('class' => 'form-control', 'data-mask' => 'instructor_id', 'label'=>__('instructor_id'), 'multiple' => 'multiple', 'type' => 'select', 'options' => $instructors));         
                         echo $this->Form->input('min_time', array('class' => 'form-control', 'data-mask' => 'min_time', 'label'=>__('min_time'), 'helpBlock' => 'Tempo mínimo em <b>segundos</b> para estudo de cada conteúdo dentro da disciplina.'));
                         echo $this->Form->input('max_time', array('class' => 'form-control', 'data-mask' => 'max_time', 'label'=>__('max_time'), 'helpBlock' => 'Tempo máximo em <b>mínutos</b> para estudar diariamente. (Caso deixe <b>zerado</b>, o sistema não fará o bloqueio diário.)'));
                        ?>
                        <div class='form-group'>
                            <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>
                            <div class='col-sm-10'>
                                <a class='btn <?php echo isset($this->request->data['Course']['status']) ? $this->request->data['Course']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
                                <?php echo $this->Form->input('status', array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                                <a class='btn <?php echo isset($this->request->data['Course']['status']) ? $this->request->data['Course']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 colun-config-right">
                        <div class="panel panel-info">
                            <div class="panel-heading"><h6 class="panel-title"><i class="icon-cogs"></i> Configuração de Integração no DETRAN</h6></div>
                            <div class="panel-body">
                                <?php
                                echo $this->Form->input('detran_validation', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'is_module_avaliation', 'label'=> ['text' => __('Validação no DETRAN'), 'class' => 'col-sm-5 control-label text-right'], 'divControls' => ['class' => 'col-sm-7']));
                                echo $this->Form->input('course_code_id', array('class' => 'form-control', 'empty' => ' ', 'label' => ['text' => __('course_code_id'), 'class' => 'col-sm-5 control-label text-right'], 'divControls' => ['class' => 'col-sm-7']));
                                ?>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading"><h6 class="panel-title"><i class="icon-cogs"></i> Configuração de Biometria</h6></div>
                            <div class="panel-body">
                                <?php
                                echo $this->Form->input('face_recognition', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'is_module_avaliation', 'label'=> ['text' => __('Reconhecimento Facial'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6']));
                                ?>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading"><h6 class="panel-title"><i class="icon-cogs"></i> Configurações de Preço</h6></div>
                            <div class="panel-body">
                                <?php
                                echo $this->Form->input('price', array('class' => 'form-control', 'data-mask' => 'price', 'label'=> ['text' => '* ' . __('price'), 'class' => 'col-sm-3 control-label text-right'], 'divControls' => ['class' => 'col-sm-9'], 'helpBlock' => 'Preço padrão do curso.'));
                                echo $this->Form->input('promotional_price', array('class' => 'form-control', 'data-mask' => 'price', 'label'=> ['text' => '** ' . __('promotional_price'), 'class' => 'col-sm-3 control-label text-right'], 'divControls' => ['class' => 'col-sm-9'], 'helpBlock' => 'Preço Promocional usado em cursos de âmbito nacional.'));
                                ?>
                                <p class="help-block"><b>*</b> O preço padrão será usado no formato "De: Por:", sendo ele o "De:"</p>
                                <p class="help-block"><b>**</b> Este preço promocional será usado apenas em cursos que não tenham estados e cidades, ou seja, de âmbito nacional.</p>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading"><h6 class="panel-title"><i class="icon-cogs"></i> Configurações de Simulado</h6></div>
                            <div class="panel-body">
                                <?php
                                 echo $this->Form->input('is_module_avaliation', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'is_module_avaliation', 'label'=> ['text' => __('is_module_avaliation'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6']));
                                 echo $this->Form->input('is_module_block', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'is_module_block', 'label'=> ['text' => __('is_module_block'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6'], 'helpBlock' => 'Bloqueia próximo <b>módulos</b> por nota?'));
                                 echo $this->Form->input('max_time_module_avaliation', array('class' => 'form-control', 'data-mask' => 'max_time_module_avaliation', 'label'=> ['text' => __('max_time_module_avaliation'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6'], 'helpBlock' => 'Tempo total em <b>mínutos</b> para simulado.'));
                                 echo $this->Form->input('value_module_avaliation', array('class' => 'form-control', 'data-mask' => 'value_module_avaliation', 'label'=> ['text' => __('value_module_avaliation'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6'], 'id' => 'spinner-decimal', 'helpBlock' => 'Nota <b>mínima</b> do simulado em %.'));
                                 echo $this->Form->input('qt_question_module_avaliation', array('class' => 'form-control', 'data-mask' => 'qt_question_module_avaliation', 'label'=> ['text' => __('qt_question_module_avaliation'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6'], 'helpBlock' => 'Quantidade de questões <b>randômicas</b>.'));
                                ?>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading"><h6 class="panel-title"><i class="icon-cogs"></i> Configurações de Prova</h6></div>
                            <div class="panel-body">
                                <?php
                                 echo $this->Form->input('is_course_avaliation', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'is_course_avaliation', 'label'=> ['text' => __('is_course_avaliation'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6']));
                                 echo $this->Form->input('is_course_certificate', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'is_course_certificate', 'label'=> ['text' => __('is_course_certificate'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6'], 'helpBlock' => 'Será oferecido <b>certificado</b>?'));
                                 echo $this->Form->input('is_certificate_block', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'is_certificate_block', 'label'=> ['text' => __('is_certificate_block'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6'], 'helpBlock' => 'Bloqueia <b>certificado</b> por nota?'));
                                 echo $this->Form->input('max_time_course_avaliation', array('class' => 'form-control', 'data-mask' => 'max_time_course_avaliation', 'label'=> ['text' => __('max_time_course_avaliation'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6'], 'helpBlock' => 'Tempo total em <b>mínutos</b> para prova.'));
                                 echo $this->Form->input('value_course_avaliation', array('class' => 'form-control', 'data-mask' => 'value_course_avaliation', 'label'=> ['text' => __('value_course_avaliation'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6'], 'id' => 'spinner-decimal', 'helpBlock' => 'Nota <b>mínima</b> da prova.'));
                                 echo $this->Form->input('qt_question_course_avaliation', array('class' => 'form-control', 'data-mask' => 'qt_question_course_avaliation', 'label'=> ['text' => __('qt_question_course_avaliation'), 'class' => 'col-sm-6 control-label text-right'], 'divControls' => ['class' => 'col-sm-6'], 'helpBlock' => 'Quantidade de questões <b>randômicas</b>.'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="modules">
                <div data-toggle="modules">
                    <div class="table-responsive">
                        <?php echo $this->Html->link(__('<span class="icon-plus"></span>'), 'javascript:void(0);', array('data-href'=>$this->Html->url(array('controller' => 'module_courses', 'action' => 'add', $this->request->data['Course']['id'])),'class'=>'openPopup btn btn-icon btn-primary openPopup', 'escape' => false)); ?>
                        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Módulo</th>
                                    <th>Estado</th>
                                    <th>Cidade</th>
                                    <th>Posição</th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody data-toggle="libraries">
                                <?php $i=0; foreach($this->request->data['ModuleCourse'] as $key => $ModuleCourse): ?>
                                    <tr data-id="module-course-<?php echo $ModuleCourse['id'];?>">
                                        <td><?php echo $modules[$ModuleCourse['module_id']]; ?></td>
                                        <td><?php echo isset($ModuleCourse['State']['name'])?$ModuleCourse['State']['name']:'-'; ?></td>
                                        <td><?php echo isset($ModuleCourse['Citie']['name'])?$ModuleCourse['Citie']['name']:'-'; ?></td>
                                        <td><?php echo $ModuleCourse['position']; ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'module_courses', 'action' => 'edit', $ModuleCourse['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
                                            <?php echo $this->Html->link(__('<span class="icon-remove3"></span>'), array('controller' => 'module_courses', 'action' => 'delete', $ModuleCourse['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $ModuleCourse['id'])); ?>
                                        </td>
                                    </tr>
                                <?php $i++; endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br><br>
                <?php //echo $this->Html->link(__('<span class="icon-plus"></span>'), array('controller' => 'module_courses', 'action' => 'add', $this->request->data['Course']['id']), array('class' => 'btn btn-icon btn-primary', 'escape' => false)); ?>
                <?php echo $this->Html->link(__('<span class="icon-plus"></span>'), 'javascript:void(0);', array('data-href'=>$this->Html->url(array('controller' => 'module_courses', 'action' => 'add', $this->request->data['Course']['id'])),'class'=>'openPopup btn btn-icon btn-primary openPopup', 'escape' => false)); ?>

            </div>

            <div class="tab-pane" id="libraries">
                <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Biblioteca</th>
                                <th>Descrição</th>
                                <th>link</th>
                                <th>status</th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody data-toggle="libraries">
                            <?php foreach ($this->request->data['CourseLibrary'] as $CourseLibrary):?>
                                <tr data-id="library-<?php echo $CourseLibrary['id'];?>">
                                    <td class="td-img">
                                        <?php 
                                        if( !empty($CourseLibrary['image']) ){
                                            echo $this->Html->image( "/files/course_library/image/{$CourseLibrary['id']}/thumb_{$CourseLibrary['image']}",['class'=>'img-responsive','style'=>'width: 80px;']);
                                        }?>
                                    </td>
                                    <td><?php echo $CourseLibrary['name']; ?></td>
                                    <td><?php echo $this->Text->truncate( strip_tags($CourseLibrary['text']), 60); ?></td>
                                    <td><a href="<?php echo $CourseLibrary['url']; ?>" target="_blank"><?php echo $CourseLibrary['url']; ?></a></td>
                                    <td><?php echo $this->Utility->__FormatStatus($CourseLibrary['status']); ?></td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'course_libraries', 'action' => 'edit', $CourseLibrary['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
                                        <?php echo $this->Html->link(__('<span class="icon-remove3"></span>'), array('controller' => 'course_libraries', 'action' => 'delete', $CourseLibrary['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $CourseLibrary['id'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if(!$this->request->data['CourseLibrary']):?>
                                <tr>
                                    <td colspan="6">Não há resoluções ou livros cadastrados.</td>
                                </tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div><!-- /table-responsive-->
                <br><br>
                <?php echo $this->Html->link(__('<span class="icon-plus"></span>'), array('controller' => 'course_libraries', 'action' => 'add', $this->request->data['Course']['id']), array('class' => 'btn btn-icon btn-primary', 'escape' => false)); ?>
            </div>

            <div class="tab-pane" id="books">
                <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Título</th>
                                <th>Descrição</th>
                                <th>Arquivo</th>
                                <th>status</th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->request->data['CourseWorkbook'] as $CourseWorkbook):?>
                                <tr>
                                    <td class="td-img">
                                        <?php 
                                        if( !empty($CourseLibrary['image']) ){
                                            echo $this->Html->image( "/files/course_workbook/image/{$CourseWorkbook['id']}/thumb_{$CourseWorkbook['image']}",['class'=>'img-responsive','style'=>'width: 80px;']);
                                        }?>
                                    </td>
                                    <td><?php echo $CourseWorkbook['name'];?></td>
                                    <td><?php echo $CourseWorkbook['text'];?></td>
                                    <td><a href="/files/course_workbook/filename/<?php echo $CourseWorkbook['id']; ?>/<?php echo $CourseWorkbook['filename']; ?>" target="_blank"><?php echo $CourseWorkbook['filename']; ?></td>
                                    <td><?php echo $this->Utility->__FormatStatus($CourseWorkbook['status']); ?></td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'course_workbooks', 'action' => 'edit', $CourseWorkbook['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
                                        <?php echo $this->Html->link(__('<span class="icon-remove3"></span>'), array('controller' => 'course_workbooks', 'action' => 'delete', $CourseWorkbook['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $CourseWorkbook['id'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if(!$this->request->data['CourseWorkbook']):?>
                                <tr>
                                    <td colspan="6">Não há apostilas cadastradas.</td>
                                </tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div><!-- /table-responsive-->
                <br><br>
                <?php echo $this->Html->link(__('<span class="icon-plus"></span>'), array('controller' => 'course_workbooks', 'action' => 'add', $this->request->data['Course']['id']), array('class' => 'btn btn-icon btn-primary', 'escape' => false)); ?>
            </div>

            <div class="tab-pane" id="multimidia">
                <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Título</th>
                                <th>Descrição</th>
                                <th>status</th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->request->data['CourseMultimidia'] as $CourseMultimidia):?>
                                <tr>
                                    <td class="td-img">
                                        <?php 
                                        if( !empty($CourseLibrary['image']) ){
                                            echo $this->Html->image( "/files/course_multimidia/image/{$CourseMultimidia['id']}/thumb_{$CourseMultimidia['image']}",['class'=>'img-responsive','style'=>'width: 80px;']);
                                        }?>
                                    </td>
                                    <td><?php echo $CourseMultimidia['name'];?></td>
                                    <td><?php echo $CourseMultimidia['text'];?></td>
                                    <td><?php echo $this->Utility->__FormatStatus($CourseMultimidia['status']); ?></td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'course_multimidias', 'action' => 'edit', $CourseMultimidia['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
                                        <?php echo $this->Html->link(__('<span class="icon-remove3"></span>'), array('controller' => 'course_multimidias', 'action' => 'delete', $CourseMultimidia['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $CourseMultimidia['id'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if(!$this->request->data['CourseMultimidia']):?>
                                <tr>
                                    <td colspan="6">Não há multimidias cadastradas.</td>
                                </tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div><!-- /table-responsive-->
                <br><br>
                <?php echo $this->Html->link(__('<span class="icon-plus"></span>'), array('controller' => 'course_multimidias', 'action' => 'add', $this->request->data['Course']['id']), array('class' => 'btn btn-icon btn-primary', 'escape' => false)); ?>
            </div>

            <?php if ($courseType['scope'] == CourseType::AMBITO_ESTADUAL) { ?>
            <div class="tab-pane" id="states">
                <?php echo $this->Form->hidden('CourseType.id');?>
                <h3><?php echo $courseType['name']?></h3>
                <p>Estes dados são referentes ao <strong>Tipo de Curso</strong>. As alterações nestes campos serão aplicadas em todos os cursos do tipo <strong><?php echo $courseType['name']?></strong>.</p>
                <p><?php echo $this->Html->link('Ver ou editar os Estados liberados neste tipo de curso.', ['controller' => 'course_states', 'action' => 'index', $courseType['id']], ['target' => '_blank'])?></p>
                <hr/>

                <?php foreach ($courseStates as $key => $courseState) { ?>
                    <h4><?php echo $courseState['State']['name'];?></h4>
                    <?php echo $this->Form->hidden('CourseType.CourseState.' . $key . '.id');?>
                    <?php echo $this->Form->hidden('CourseType.CourseState.' . $key . '.course_type_id');?>
                    <?php echo $this->Form->input('CourseType.CourseState.' . $key . '.price', array('class' => 'form-control', 'data-mask' => 'price', 'label'=> 'Preço', 'helpBlock' => 'Preço promocional do curso no Estado.'));?>
                    <?php echo $this->Form->input('CourseType.CourseState.' . $key . '.scheduling_link_detran', array('class'=>'form-control','label'=> 'Link de agendamento da Prova do Detran-' . $courseState['State']['abbreviation']));?>
                    <?php echo $this->Form->input('CourseType.CourseState.' . $key . '.description', array('class' => 'form-control ckeditor', 'id'=>'ckfinderState' . $key, 'label'=> 'Descrição ' . $courseState['State']['abbreviation']));?>
                    <?php echo $this->Form->input('CourseType.CourseState.' . $key . '.text', array('class' => 'form-control ckeditor', 'id'=>'ckfinderState' . $key, 'label'=> 'Texto ' . $courseState['State']['abbreviation']));?>
                    <hr/>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
     <?php echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>    <input type="submit" class="btn btn-primary" value="Salvar" name="aplicar" >
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>

<?php echo $this->Form->end(); ?>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">fechar</button>
                <h4 class="modal-title">Módulos do Curso</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.openPopup').on('click',function(){
            var dataURL = $(this).attr('data-href');
            $('.modal-body').load(dataURL,function(){
                $('#myModal').modal({show:true});
            });
        }); 
    });
</script>
