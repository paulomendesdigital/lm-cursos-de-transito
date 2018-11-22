<?php
/**
 * This is email configuration file.
 *
 * Use it to configure email transports of Cake.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *		Mail 		- Send using PHP mail function
 *		Smtp		- Send using SMTP
 *		Debug		- Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */

class EmailConfig {

    public $smtp = array(
        'transport' => 'Smtp',
        'from' => array('sender@seusite.com.br' => 'Nome do Remetente'),
        'sender' => 'sender@seusite.com.br',
        'host' => 'smtp.seusite.com.br',
        'port' => 587,
        'timeout' => 30,
        'username' => 'sender@seusite.com.br',
        'password' => '123456',
        'client' => null,
        'log' => false,
        'emailFormat' => 'both',
        'charset' => 'utf-8',
        'headerCharset' => 'utf-8',
    );

    // public $sendGrid = array(
    //     'transport' => 'Smtp',
    //     'from' => array('contato@lmcursosdetransito.com.br' => 'LM Cursos'),
    //     'sender' => 'contato@lmcursosdetransito.com.br',
    //     'host' => 'ssl://smtp.sendgrid.net',
    //     'port' => 465,
    //     'timeout' => 30,
    //     'username' => 'apikey',
    //     'password' => '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',
    // );

    public $gmail = array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => 465,
        'username' => 'webmaster@lmcursosdetransito.com.br',
        'password' => 'LmCursos@@2018!',
        'transport' => 'Smtp'
    );
}
