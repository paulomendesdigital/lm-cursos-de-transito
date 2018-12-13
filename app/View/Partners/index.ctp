<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * NossaEquipe View
 *
*/ ?>
<?php 
// echo '<pre>'; print_r($orders); echo '</pre>';
?>
<div id='contact' class='page'>
	<div class='container'>
		<?php echo $this->Utility->breadcumbs([
			'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
			'Minhas Vendas' => ['controller'=>'partners','action'=>'index','prefixes'=>false]
		]);
		?>
		<div class='row'>
			<div class='col-md-12 col-form'>

                <h3>Minhas Vendas</h3>
                <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo 'id'; ?></th>
                            <th><?php echo 'Status'; ?></th>
                            <th><?php echo 'Alunos'; ?></th>
                            <th><?php echo 'CPF'; ?></th>
                            <th><?php echo 'Data da '.$pageTitle; ?></th>
                            <th><?php echo 'Vendedor'; ?></th>
                            <th><?php echo 'Curso(s)'; ?></th>
                            <th>Status Detran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order):
                            $aprovado = $order['OrderType']['id'] == 3 || $order['OrderType']['id'] == 4;
                            $intCountCursos = count($order['OrderCourse']);
                            $bolMultiplo    = $intCountCursos > 1;
                            $strRowspan = $bolMultiplo ? (' rowspan="' . ($intCountCursos + 1) . '"') : '';
                            ?>
                            <tr>
                                <td<?php echo $strRowspan ?>><?php echo $order['Order']['id']; ?></td>
                                <td<?php echo $strRowspan ?>><?php echo $order['OrderType']['name']; ?></td>
                                <td<?php echo $strRowspan ?>><?php echo $order['User']['name']; ?></td>
                                <td<?php echo $strRowspan ?> style="white-space: nowrap"><?php echo $order['User']['cpf']; ?></td>
                                <td<?php echo $strRowspan?>><?php echo $this->Utility->__FormatDate($order['Order']['created']); ?></td>
                            
                            <?php if ($bolMultiplo) { ?>
                                </tr>
                            <?php } ?>

                        <?php foreach ($order['OrderCourse'] as $c => $course) { ?>
                            
                            <?php if ($bolMultiplo) { ?>
                                <tr>
                            <?php } ?>
                            
                                <td>
                                    <?php echo (!empty($order['Order']['sender']) ? $order['Order']['sender'] : 'LM'); ?>
                                </td>
                                <td><?php echo $course['Course']['name']?></td>
                                <td><?php echo $this->Utility->__StatusDetran($course)?></td>

                            <?php if ($bolMultiplo) { ?>
                                </tr>
                            <?php } ?>
                        
                        <?php } //end foreach cursos ?>

                        <?php if (!$bolMultiplo) { ?>
                            </tr>
                        <?php } ?>
                        <?php endforeach; ?>

                    </tbody>
                </table>
			</div>

		</div>
	</div>
</div>