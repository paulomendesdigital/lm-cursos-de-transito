<?php

class AclGenShell extends AppShell {

    public $uses = array('User', 'Aro');

    public function main() {
        $users = $this->User->find('all');
        foreach ($users as $user) {
            $this->Aro->create();
            $this->Aro->save(array(
               'model' => 'User',
               'foreign_key' => $user['User']['id'],
               'parent' => 'parent_ARO_alias'
            ));
        }
    }
}