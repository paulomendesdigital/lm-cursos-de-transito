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
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$Sistems = Configure::read('Sistems');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body>
    <table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="650">
        <tr>
            <td style="line-height: 0;"><img src="<?php echo Router::url('/', true)?>img/site/header_email.png" alt="" style="display: block;" /></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#717171; padding:10px 0; background: #e8e8e8">

                <div style="margin: 10px;">
                    <?php echo $this->fetch('content'); ?>
                </div>

                <div style="text-align: left; margin: 10px;">
                    <br/><hr/>
                    <p style="font-size:10px;">
                        Esta mensagem foi enviada para [<?php echo $data['content']['email'];?>] pela <?php echo $Sistems['Title'];?>.<br/>
                        <?php echo $Sistems['CorporateName'];?><br/>
                        <?php echo isset($Sistems['Cnpj']) && $Sistems['Cnpj']!=''?'CNPJ: '.$Sistems['Cnpj']:'';?><br/>
                        (c) <?php echo date('Y');?> <?php echo $Sistems['Title'];?>.
                    </p>
                </div>
                
            </td>
        </tr>
        <tr>
            <td height="5" style="background: #DDD;"></td>
        </tr>
    </table>    
</body>
</html>