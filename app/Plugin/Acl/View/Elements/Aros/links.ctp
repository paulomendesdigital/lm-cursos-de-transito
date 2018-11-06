<div id="aros_link" class="acl_links">
<?php
$selected = isset($selected) ? $selected : $this->params['action'];

$links = array();
$links[] = $this->Html->link(__d('acl', 'Build missing AROs'), '/manager/acl/aros/check', array('class' => ($selected == 'manager_check' )? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Users roles'), '/manager/acl/aros/users', array('class' => ($selected == 'manager_users' )? 'selected' : null));

if(Configure :: read('acl.gui.roles_permissions.ajax') === true)
{
    $links[] = $this->Html->link(__d('acl', 'Roles permissions'), '/manager/acl/aros/ajax_role_permissions', array('class' => ($selected == 'manager_role_permissions' || $selected == 'manager_ajax_role_permissions' )? 'selected' : null));
}
else
{
    $links[] = $this->Html->link(__d('acl', 'Roles permissions'), '/manager/acl/aros/role_permissions', array('class' => ($selected == 'manager_role_permissions' || $selected == 'manager_ajax_role_permissions' )? 'selected' : null));
}
$links[] = $this->Html->link(__d('acl', 'Users permissions'), '/manager/acl/aros/user_permissions', array('class' => ($selected == 'manager_user_permissions' )? 'selected' : null));

echo $this->Html->nestedList($links, array('class' => 'acl_links'));
?>
</div>