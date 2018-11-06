<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * User View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>Auto Escola <small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar Auto Escolas'), '/manager/'.$this->params['controller'].'/index');?>
        <?php echo $this->Html->addCrumb('Editar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('School', array('class'=>'form-horizontal','role'=>'form','type'=>'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab"><i class="icon-pencil"></i> Detalhes</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php 
                        if( !empty($this->request->data['School']['image']) ){
                            echo '<div class="form-group text-center">';
                                echo $this->Html->image("/files/school/image/{$this->request->data['School']['id']}/thumb_{$this->request->data['School']['image']}?".time(),['class'=>'img-responsive img-thumbnail']);
                            echo "</div>";
                        }
                        echo $this->Form->input('image', array('type' => 'file','class' => 'form-control', 'label'=>__('Imagem')));?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('id');?>
                        <?php echo $this->Form->input('name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('phone',['class'=>'form-control','label'=>'Telefone','data-mask'=>'phone','required'=>true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('site', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('Site')));?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('facebook',['class'=>'form-control','label'=>'Facebook','data-mask'=>'name','required'=>false]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('zipcode',['class'=>'form-control','label'=>'CEP','data-mask'=>'zipcode','required'=>true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('address',['class'=>'form-control','label'=>'Endereço','required'=>true, 'data-toggle'=>'returnAddress']); ?>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('number',['class'=>'form-control','label'=>'Nº','required'=>true, 'data-toggle'=>'returnNumber']); ?>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('complement',['class'=>'form-control','label'=>'Compl.','required'=>false]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-12">
                        <?php echo $this->Form->input('neighborhood',['class'=>'form-control','label'=>'Bairro','required'=>true, 'data-toggle'=>'returnNeighborhood']); ?>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        <?php echo $this->Form->input('state_id',['class'=>'form-control','label'=>'Estado','required'=>true, 'data-toggle'=>'returnState']); ?>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        <?php echo $this->Form->input('city_id',['class'=>'form-control','label'=>'Cidade','required'=>true, 'data-toggle'=>'returnCity']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <?php echo $this->Form->input('cod_cfc',['class'=>'form-control','label'=>'Cód. CFC', 'style' => 'width:120px']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class='form-group'>
                            <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>
                            <div class='col-sm-10'>
                                <a class='btn <?php echo isset($this->request->data['School']['status']) ? $this->request->data['School']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
                                <?php echo $this->Form->input('status', array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                                <a class='btn <?php echo isset($this->request->data['School']['status']) ? $this->request->data['School']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
    <?php echo $this->Html->link('Cancelar',array('action'=>'index'), array('class'=>'btn btn-danger'));?>
    <input type="submit" class="btn btn-primary" value="Salvar" name="aplicar" >
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>
<?php echo $this->Form->end(); ?>
