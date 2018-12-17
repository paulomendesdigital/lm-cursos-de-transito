<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Course View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>
        <?php echo __($this->params['controller']);?> 
        <small>Lista de resultados</small>
        </h3>
    </div>

    <div class="visible-xs header-element-toggle">
        <a class="btn btn-primary btn-icon collapsed" data-toggle="collapse" data-target="#header-buttons"><i class="icon-insert-template"></i></a>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?>   
    </ul>
</div>

<?php echo $this->Search->create(null, array('class' => '','role'=>'form')); ?> 
<div class="row">
    <div class="col-sm-12 col-md-1">
        <div class="form-group">
        <?php echo $this->Search->input('filter1', array('class' => 'form-control', 'placeholder'=>'Id'));?> 
        </div>
    </div>
    
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
        <?php echo $this->Search->input('filter_rps', array('class' => 'form-control', 'placeholder'=>'Número RPS'));?> 
        </div>
    </div>
    
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
        <?php echo $this->Search->input('filter_invoice', array('class' => 'form-control', 'placeholder'=>'Número NFSe'));?> 
        </div>
    </div>

    <div class="col-sm-12 col-md-3">
        <div class="form-group">
        <?php echo $this->Search->input('filter_client', array('class' => 'form-control', 'placeholder'=>'Cliente'));?> 
        </div>
    </div>

    <div class="col-sm-12 col-md-2">
        <div class="form-group">
        <?php echo $this->Search->input('filter_cpf', array('class' => 'form-control', 'placeholder'=>'CPF'));?> 
        </div>
    </div>
    
    <div class="col-sm-12 col-md-2">
        <button class="btn btn-default" type="submit">Buscar</button>
    </div>
</div>
<?php echo $this->Search->end(); ?>
<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id',__('id', true)); ?></th>
                <th><?php echo $this->Paginator->sort('rps_number',__('rps_number', true)); ?></th>
                <th><?php echo $this->Paginator->sort('invoice_number',__('invoice_number', true)); ?></th>
                <th><?php echo $this->Paginator->sort('value',__('value', true)); ?></th>
                <th><?php echo $this->Paginator->sort('invoice_link',__('invoice_link', true)); ?></th>
                <th><?php echo $this->Paginator->sort('name',__('client', true)); ?></th>
                <th><?php echo $this->Paginator->sort('cpf',__('cpf', true)); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoices as $invoice): ?>
                <tr>
                    <td><?php echo h($invoice['Invoice']['id']); ?></td>
                    <td><?php echo $invoice['Invoice']['rps_number']; ?></td>
                    <td><?php echo $this->Utility->__LimitText($invoice['Invoice']['invoice_number'],100); ?></td>
                    <td><?php echo $this->Utility->__FormatPrice($invoice['Invoice']['value']); ?></td>
                    
                    <td>
                        <?php 
                        echo $this->Html->link(
                            'Acessar NFSe',
                            $invoice['Invoice']['invoice_link'],
                            array('target' => '_blank')
                        );
                        ?>
                    </td>

                    <td><?php echo $this->Utility->__LimitText($invoice['Invoice']['name']); ?></td>
                    <td><?php echo h($invoice['Invoice']['cpf']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /table-responsive-->

<?php echo $this->Element('manager/pagination'); ?>