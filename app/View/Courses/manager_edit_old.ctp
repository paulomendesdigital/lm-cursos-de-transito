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
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <div class="row">
                    <div class="col-md-8"> 
                        <?php
                         echo $this->Form->input('id');
                         if( !empty($this->request->data['Course']['image']) ){
                            echo '<div class="form-group text-center">';
                            echo $this->Html->image("/files/course/image/{$this->request->data['Course']['id']}/thumb_{$this->request->data['Course']['image']}?".time(),['class'=>'img-responsive img-thumbnail']);
                            echo "</div>";
                         }
                         $text_after_guide = $this->request->data['Course']['student_guide'] ? '<small class="text-warning">Guia enviado!</small>' : '';
                         echo $this->Form->input('image', array('type' => 'file','class' => 'form-control', 'label'=>__('Imagem')));
                         echo $this->Form->input('student_guide', array('type' => 'file','class' => 'form-control', 'label'=>__('Guia do Aluno'), 'after'=>$text_after_guide));
                         echo $this->Form->input('name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));
                         echo $this->Form->input('firstname', array('class' => 'form-control', 'data-mask' => 'firstname', 'label'=>__('firstname')));
                         echo $this->Form->input('course_type_id', array('class' => 'form-control', 'data-mask' => 'course_type_id', 'label'=>__('course_type_id')));
                         echo $this->Form->input('text', array('class' => 'form-control ckeditor', 'id'=>'ckfinder', 'label'=>__('text')));
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
                <div class="row">
                    <div class="col-md-5"><h6>Módulos</h6></div>

                    <?php if( !$this->Utility->__isScopeNacional($this->request->data['CourseType']['scope']) ):?>
                        <?php if( $this->Utility->__isScopeEstadual($this->request->data['CourseType']['scope']) OR $this->Utility->__isScopeMunicipal($this->request->data['CourseType']['scope']) ):?>
                            <div class="col-md-2"><h6>Estados</h6></div>
                            <?php if( $this->Utility->__isScopeMunicipal($this->request->data['CourseType']['scope']) ):?>
                                <div class="col-md-3"><h6>Cidades</h6></div>
                            <?php endif;?>
                        <?php endif;?>
                    <?php endif;?>
                    <div class="col-md-2"><h6>Posição</h6></div>
                </div>

                <div data-toggle="modules">
                    <?php $i=0; foreach($this->request->data['ModuleCourse'] as $key => $ModuleCourse):?>
                        <div data-toggle="module<?php echo $key;?>">
                            <div data-toggle="formModule<?php echo $key;?>">
                                <div class="row">
                                    <div class="col-md-5">
                                        <?php echo $this->Form->input('ModuleCourse.'.$key.'.id', array('class' => 'form-control', 'data-mask' => 'id', 'label'=>false)); ?>
                                        <a onclick="removeModuleCourse(<?php echo $key;?>)" class="btn btn-link btn-icon btn-xs pull-left" title="Remover módulo <?php echo $key;?>"><i class="icon-remove3 text-danger"></i></a>
                                        <?php echo $this->Form->hidden('ModuleCourse.'.$key.'.course_id'); ?>
                                        <?php echo $this->Form->input('ModuleCourse.'.$key.'.module_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>false, 'data-reference' => "module{$i}")); ?>
                                    </div>
                                    <?php if( !$this->Utility->__isScopeNacional($this->request->data['CourseType']['scope']) ):?>
                                        <?php if( $this->Utility->__isScopeEstadual($this->request->data['CourseType']['scope']) OR $this->Utility->__isScopeMunicipal($this->request->data['CourseType']['scope']) ):?>
                                            <div class="col-md-2"><?php echo $this->Form->input('ModuleCourse.'.$key.'.state_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>false, 'empty' => 'Selecione', 'data-reference' => "state{$i}", 'data-toggle' => 'returnState')); ?></div>
                                            <?php if( $this->Utility->__isScopeMunicipal($this->request->data['CourseType']['scope']) ):?>
                                                <div class="col-md-3"><?php echo $this->Form->input('ModuleCourse.'.$key.'.citie_id', array('class' => 'form-control', 'data-toggle' => 'returnCity', 'label'=>false, 'options' => [$ModuleCourse['Citie']['id'] => $ModuleCourse['Citie']['name']])); ?></div>
                                            <?php else:?>
                                                <?php echo $this->Form->hidden('ModuleCourse.'.$key.'.city_id', array('value' => 0)); ?>
                                            <?php endif;?>
                                        <?php else:?>
                                            <?php echo $this->Form->hidden('ModuleCourse.'.$key.'.state_id', array('value' => 0)); ?>
                                        <?php endif;?>
                                    <?php endif;?>
                                    <div class="col-md-2"><?php echo $this->Form->input('ModuleCourse.'.$key.'.position', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>false)); ?></div>
                                </div>
                             </div>
                        </div>
                    <?php $i++; endforeach;?>
                    <?php if( empty($this->request->data['ModuleCourse']) ):?>
                        <div data-toggle="module1">
                            <div data-toggle="formModule1">
                                <div class="row">
                                    <div class="col-md-5">
                                        <a onclick="removeModuleCourse(1)" class="btn btn-link btn-icon btn-xs pull-left" title="Remover módulo 1"><i class="icon-remove3 text-danger"></i></a>
                                        <?php echo $this->Form->input('ModuleCourse.1.module_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>false, 'data-reference' => 'module0')); ?>
                                    </div>
                                    <div class="col-md-2"><?php echo $this->Form->input('ModuleCourse.1.state_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>false, 'empty' => 'Selecione', 'data-reference' => 'state0', 'data-toggle' => 'returnState')); ?></div>
                                    <div class="col-md-3"><?php echo $this->Form->input('ModuleCourse.1.citie_id', array('class' => 'form-control', 'data-toggle' => 'returnCity', 'label'=>false, 'empty' => 'Selecione o estado' )); ?></div>
                                    <div class="col-md-2"><?php echo $this->Form->input('ModuleCourse.1.position', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>false)); ?></div>
                                </div>
                             </div>
                        </div>
                    <?php endif;?>
                 </div>
                
                <a data-toggle="addModuleCourse" class="btn btn-icon btn-primary" title="Adicionar novo módulo"><i class="icon-plus"></i></a>
                <input type="hidden" data-toggle="countModuleCourse" value="<?php echo (count($this->request->data['ModuleCourse']) > 0 ? count($this->request->data['ModuleCourse']) : 1);?>">
    
                <?php if( $this->Utility->__isScopeMunicipal($this->request->data['CourseType']['scope']) ):?>
                    <input type="hidden" data-toggle="scope" name="scope" value="municipal" />
                <?php elseif( $this->Utility->__isScopeEstadual($this->request->data['CourseType']['scope']) ):?>
                    <input type="hidden" data-toggle="scope" name="scope" value="estadual" />
                <?php else:?>
                    <input type="hidden" data-toggle="scope" name="scope" value="nacional" />
                <?php endif;?>
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
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
     <?php echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>    <input type="submit" class="btn btn-primary" value="Salvar" name="aplicar" >
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>


<?php echo $this->Form->end(); ?>
