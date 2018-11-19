<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>



<?php $Sistems = Configure::read('Sistems'); ?>

<div style="text-align: left; font-size: 12px;margin: 10px 0;padding: 13px 18px;">
    <p><strong>Recuperação de Senha:</strong></p>
    <p><?php echo $data['content']['messenger'];?><br><br></p>
	<p><hr /></p>
	<p>
	<b>Dados de Acesso:</b> <br />
    Login: <?php echo $data['content']['Login'];?><br>
    Senha: <?php echo $data['content']['Senha'];?><br>
    </p>
</div>