<div id="acos_link" class="acl_links">
<?php
$selected = isset($selected) ? $selected : $this->params['action'];

$links = array();
$links[] = $this->Html->link(__d('acl', 'Synchronize actions ACOs'), '/manager/acl/acos/synchronize', array(array('confirm' => __d('acl', 'are you sure ?')), 'class' => ($selected == 'manager_synchronize' ) ? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Clear actions ACOs'),       '/manager/acl/acos/empty_acos',  array(array('confirm' => __d('acl', 'are you sure ?')), 'class' => ($selected == 'manager_empty_acos' )  ? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Build actions ACOs'),       '/manager/acl/acos/build_acl',                                                     array('class' => ($selected == 'manager_build_acl' )   ? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Prune actions ACOs'),       '/manager/acl/acos/prune_acos',  array(array('confirm' => __d('acl', 'are you sure ?')), 'class' => ($selected == 'manager_prune_acos' )  ? 'selected' : null));


echo $this->Html->nestedList($links, array('class' => 'acl_links'));
?>
</div>