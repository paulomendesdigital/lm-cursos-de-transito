<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * Order View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($pageTitle);?> <small>Visualização do histórico</small></h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($pageTitle).'s', '/manager/'.$this->params['controller'].'/index');?> 
        <?php echo $this->Html->addCrumb('Visualizar histórico', '');?> 
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<div class="panel">
	<h3>Visualização dos dados</h3>

	<ul class="list-group">
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('#ref.'); ?></strong></div> 
				<div class='col-md-10'><?php echo $order['Order']['id']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Order Type'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Html->link($order['OrderType']['name'], array('controller' => 'orders', 'action' => 'edit', $order['Order']['id']), array('data-toggle'=>'tooltip', 'data-original-title'=>'Editar Compra')); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('User'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Html->link($order['User']['name'], array('controller' => 'users', 'action' => 'view', $order['User']['id']), array('data-toggle'=>'tooltip', 'data-original-title'=>'Visualizar Histórico do Aluno')); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Data da Matrícula no Sistema'); ?></strong></div>
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($order['Order']['created']); ?></div>
			</div>
		</li>
	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Cursos Matriculados'); ?></h3>
	<?php if (!empty($order['OrderCourse'])): ?>
		<table class="table table-striped table-hover table-condensed well" cellpadding = "0" cellspacing = "0">
			<tbody>
				<?php foreach ($order['OrderCourse'] as $orderCourse):?>
					<tr>
						<td colspan="4">
							<div class="callout callout-info" style="margin: 0px;">
								<h5><?php echo h($orderCourse['Course']['name']); ?></h5>
								<?php echo isset($orderCourse['State']['name'])?"<p><b>Estado: </b>{$orderCourse['State']['name']}</p>":''; ?>
								<?php echo isset($orderCourse['Citie']['name'])?"<p><b>Cidade: </b>{$orderCourse['Citie']['name']}</p>":''; ?>
                                <?php
                                if ($orderCourse['Course']['course_type_id'] == CourseType::RECICLAGEM || $orderCourse['Course']['course_type_id'] == CourseType::ESPECIALIZADOS) {
                                    $classDetran = 'default';
                                    if (isset($orderCourse['StatusDetran']['id'])) {
                                        switch ($orderCourse['StatusDetran']['id']) {
                                            case 1:
                                            case 6:
                                                $classDetran = 'danger';
                                                break;
                                            case 2:
                                                $classDetran = 'warning';
                                                break;
                                            case 3:
                                                $classDetran = 'primary';
                                                break;
                                            case 4:
                                                $classDetran = 'info';
                                                break;
                                            case 5:
                                                $classDetran = 'success';
                                                break;
                                            default:
                                                $classDetran = 'default';
                                        }
                                    }
                                    echo isset($orderCourse['StatusDetran']['id'])?"<p><b>Status do Detran: </b><span class='label-status-detran label label-{$classDetran}' style='font-size: 1.2em'>{$orderCourse['StatusDetran']['nome']}</span></p> ":'';
                                    if (isset($orderCourse['StatusDetran']['id']) && $orderCourse['StatusDetran']['id'] == 6) {
                                        echo '<p class="text-danger">A integração com o Detran neste pedido foi cancelada. Possíveis causas:</p><ul class="text-danger"><li>Esgotou-se o limite de tentativas automáticas com erros.</li><li>Processo cancelado.</li><li>Intervenção técnica.</li></ul><p class="text-danger">Para maiores informações, verifique os Logs ou contate a equipe técnica.</p>';
                                    }
                                    echo isset($orderCourse['data_matricula_detran'])?"<p><b>Data da Matrícula no Detran: </b>{$this->Utility->__FormatDate($orderCourse['data_matricula_detran'])}</p> ":'';
                                    echo isset($orderCourse['data_status_detran'])?"<p><b>Data do Status do Detran: </b>{$this->Utility->__FormatDate($orderCourse['data_status_detran'])}</p> ":'';
                                    echo isset($orderCourse['codigo_retorno_detran'])?"<p><b>Código da Última Comunicação com o Detran: </b>{$orderCourse['codigo_retorno_detran']}</p> ":'';
                                    echo isset($orderCourse['mensagem_retorno_detran'])?"<p><b>Mensagem da Última Comunicação com o Detran: </b>{$orderCourse['mensagem_retorno_detran']}</p> ":'';
                                    echo $this->Html->link('Atualizar Detran',['controller' => 'orders', 'action' => 'recomunicar', $order['Order']['id']],['class'=>'btn btn-xs btn-warning','escape'=>false, 'data-toggle' => 'tooltip', 'data-original-title' => 'Use em caso de erro na comunicação com o Detran. O sistema irá tentar atualizar as informações pendentes de envio.']) . ' ';
                                    echo $this->Html->link('Ver Logs da Matrícula',['controller' => 'log_detrans', 'action'=>'index', 'matricula' => $order['Order']['id']],['class'=>'btn btn-xs btn-primary','escape'=>false]) . ' ';
                                    echo $this->Html->link('Ver Logs do CPF',['controller' => 'log_detrans', 'action'=>'index', 'cpf' => $order['User']['cpf']],['class'=>'btn btn-xs btn-primary','escape'=>false]) . ' ';

                                    if ($orderCourse['state_id'] == State::SERGIPE) {
                                        echo $this->Html->link('Ver Créditos de Aulas', 'javascript:void(0)', ['class' => 'btn btn-xs btn-info btn-credito-aulas', 'data-href' => $this->Html->url(['action' => 'credito_aulas', $order['Order']['id']])]) . ' ';
                                    }
                                }
                                ?>
                            </div>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="callout callout-info" style="margin: 0px;">
								<?php if( empty($order['UserModuleSummary']) ):?>
									<?php echo $this->Html->link('Gerar Grade de Estudo',['action'=>'insertUserModuleSummary', $order['Order']['id']],['class'=>'btn btn-primary','escape'=>false]);?>
								<?php else:?>
									<span class="text-success">Grade de Estudos Montada!</span>
								<?php endif;?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<?php foreach ( $orderCourse['Course']['ModuleCourse'] as $moduleCourse ):?>
								<h3>
									<b>Módulo: </b><?php echo $moduleCourse['Module']['name'];?>
									<span class="">
										<?php if( !empty($moduleCourse['Module']['UserModuleSummary']) ):?>
											<?php if( $moduleCourse['Module']['UserModuleSummary'][0]['desblock'] ):?>
												<i class="icon icon-checkmark3 text-success tip" data-original-title="Módulo Liberado"></i>
											<?php else:?>
												<i class="icon icon-cancel text-danger tip" data-original-title="Módulo Bloqueado"></i>
											<?php endif;?>
										<?php else:?>
											--
										<?php endif;?>
									</span>
								</h3>
								<?php foreach ($moduleCourse['Module']['ModuleDiscipline'] as $moduleDiscipline): ?>
									
									<div class="panel panel-default">
						                <div class="panel-heading">
						                	<h6 class="panel-title"><i class="icon-table2"></i> <b>Unidade: </b><?php echo $moduleDiscipline['name'];?></h6>
						                </div>
						                <div class="table-responsive">
							                <table class="table">
							                    <tbody>
							                    	<?php $i=1; foreach ($moduleDiscipline['ModuleDisciplineSlider'] as $slide): ?>
							                        <tr>
							                            <td><b>Slide <?php echo $i;?></td>
							                            <td><?php echo $slide['name'];?></td>
							                            <td>
							                            	<?php if( !empty($slide['UserModuleLog']) ):?>
																<i class="icon icon-checkmark3 text-success"></i>
															<?php else:?>
																<i class="icon icon-cancel text-danger"></i>
															<?php endif;?>
														</td>
							                        </tr>
							                        <?php $i++; endforeach; ?>
							                    </tbody>
							                </table>
						                </div>
							        </div>
								<?php endforeach; ?>
								<?php if( !empty($moduleCourse['Module']['UserQuestion'])): ?>
									<div class="panel panel-primary">
						                <div class="panel-heading">
						                	<h6 class="panel-title"><i class="icon-file"></i> <b>Simulados realizados</b></h6>
						                </div>
						                <div class="table-responsive">
							                <table class="table">
							                	<thead>
							                        <tr>
							                            <th>Tentativas</th>
							                            <th>Nota Mínima</th>
							                            <th>Nota do Aluno</th>
							                            <th>Situação</th>
							                            <th>Data</th>
							                        </tr>
							                    </thead>
							                    <tbody>
													<?php $i=1; foreach( $moduleCourse['Module']['UserQuestion'] as $avaliation ):?>
														<tr>
								                            <td><?php echo $i;?>å</td>
								                            <td><?php echo round($avaliation['value_avaliation'],0);?>%</td>
								                            <td><?php echo round($avaliation['value_result'],0);?>%</td>
								                            <td>
								                            	<?php if( $avaliation['result'] > 0 ):?>
																	<span class="text-success">Aprovado</span>
																<?php else:?>
																	<span class="text-danger">Reprovado</span>
																<?php endif;?>
															</td>
															<td><?php echo $avaliation['created'];?></td>
								                        </tr>
													<?php $i++; endforeach;?>
												</tbody>
											</table>
										</div>
									</div>
								<?php endif;?>
							<?php endforeach; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
	<?php endif; ?>
</div>

<div id="modal-credito-aulas" class="modal fade in" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Crédito de Aulas para o DETRAN</h4>
            </div>

            <div class="modal-body with-padding">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.btn-credito-aulas').on('click',function(){
            var url= $(this).attr('data-href');
            $('#modal-credito-aulas .modal-body').load(url, function() {
                $('#modal-credito-aulas').modal({show:true});
            });
        });
    });
</script>
