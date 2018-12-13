<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * User View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo $titlePage;?> <small>Adicionar novo</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/'.$action);?>
        <?php echo $this->Html->addCrumb('Adicionar novo', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('User', array('class'=>'form-horizontal','role'=>'form','type'=>'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab"><i class="icon-pencil"></i> Detalhes</a></li>
            <li class=""><a href="#address" data-toggle="tab"><i class="icon-home"></i> Endereço</a></li>
            <li><a href="#curriculum" data-toggle="tab"><i class="icon-file"></i> Observações</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php 
                echo $this->Form->hidden('group_id', array('value'=>$group_id));
                echo $this->Form->input('name', array('class' => 'form-control', 'data-mask' => 'name', 'required'=>true, 'label'=>__('name')));
                echo $this->Form->input('cpf', array('class' => 'form-control', 'data-mask' => 'cpf', 'required'=>true, 'label'=>__('cpf')));
                ?>
                <div class="form-group">
                    <label for="Partner0Birth" class="col-sm-2 control-label text-right"><?php echo __('birth')?></label>
                    <div class="col-sm-2">
                        <input type="date" name="data[Partner][0][birth]" class="form-control col-sm-9" required="required" id="Partner0Birth" autocomplete="off" value="<?php echo isset($this->request->data['Partner'][0]['birth']) ? $this->request->data['Partner'][0]['birth']  : ''?>">
                    </div>
                </div>
                <?php
                //echo $this->Form->input('username', array('class' => 'form-control', 'data-mask' => 'username', 'label'=>__('username')));
                echo $this->Form->input('email', array('class' => 'form-control', 'data-mask' => 'email', 'label'=>__('email')));
                //echo $this->Form->input('password', array('class' => 'form-control', 'data-mask' => 'password', 'label'=>__('password')));
                echo $this->Form->input('avatar', array('type' => 'file','class' => 'form-control', 'label'=>__('avatar')));
                echo $this->Form->hidden('newsletter', array('value' => 1));
                ?>
                <div class='form-group'>
                    <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>
                    <div class='col-sm-10'>
                        <a class='btn <?php echo isset($this->request->data['User']['status']) ? $this->request->data['User']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
                        <?php echo $this->Form->input('status', array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                        <a class='btn <?php echo isset($this->request->data['User']['status']) ? $this->request->data['User']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="address">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->hidden('Partner.0.status',['value'=>1]); ?>
                        <?php echo $this->Form->input('Partner.0.zipcode',['class'=>'form-control','label'=>'CEP','data-mask'=>'zipcode']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('Partner.0.address',['class'=>'form-control','label'=>'Endereço', 'data-toggle'=>'returnAddress']); ?>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('Partner.0.number',['class'=>'form-control','label'=>'Nº', 'data-toggle'=>'returnNumber']); ?>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <?php echo $this->Form->input('Partner.0.complement',['class'=>'form-control','label'=>'Compl.']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-12">
                        <?php echo $this->Form->input('Partner.0.neighborhood',['class'=>'form-control','label'=>'Bairro', 'data-toggle'=>'returnNeighborhood']); ?>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        <?php echo $this->Form->input('Partner.0.state_id',['class'=>'form-control','label'=>'Estado', 'data-toggle'=>'returnState']); ?>
                    </div>
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        <?php echo $this->Form->input('Partner.0.city_id',['class'=>'form-control','label'=>'Cidade', 'data-toggle'=>'returnCity']); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="curriculum">
                <?php echo $this->Form->input('Partner.0.text', array('class'=>'form-control ckeditor', 'id'=>'ckfinder','label'=>__('Observações sobre o parceiro')));?>
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