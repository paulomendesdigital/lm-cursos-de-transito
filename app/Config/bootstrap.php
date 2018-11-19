<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

CakePlugin::load('AclExtras');
CakePlugin::load('Acl', array('bootstrap' => true));

CakePlugin::load('FilterResults');

CakePlugin::load('Upload');
CakePlugin::load('FindCeps');
CakePlugin::load('PagarMe');

CakePlugin::load('Dompdf', array('bootstrap' => true));

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter . By Default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

/**
 * Configuration Of Sistems
 */
Configure::write('Sistems', array(

    //Corporate Informations
    'CNPJ'              => '18.657.198/0001-46', // 00.000.000/0000-00
    'CorporateName'     => 'LM CURSOS DE TRÂNSITO', // Nome fantasia
    'CorporateFantasy'  => 'LM Cursos', // Nome da empresa
    'ZipCode'           => '', // 00.000-000
    'AddressForCertificate' => 'Estrada do Cafundá Nº 820, Sala 202 - Taquara, Rio de Janeiro - RJ', // R. das Flores, 123
    'Address'           => 'Estrada do Cafundá Nº 820', // R. das Flores, 123
    'complement1'       => 'Sala 202', // R. das Flores, 123
    'complement2'       => '', // R. das Flores, 123
    'State'             => 'Rio de Janeiro - RJ', // Rio de Janeiro - RJ
    'Email'             => '', // abc@def.com.br
    'Phone1'            => '', // (xx) xxxx-xxxx
    'Phone2'            => '', // (xx) xxxx-xxxx
    
    //Website Details
    'Title'             => 'LM Cursos de Trânsito', // Título da Página
    'SubTitle'          => '', // Sub-título
    'Analytics'         => '', // UA-XXXXXX-X
    'Verification'      => '', // Código de validação Google Web Master
    'Keyword'           => '', // Palavras-chave
    'Description'       => 'A LM Cursos de Trânsito é uma entidade educacional especializada em cursos na área de trânsito, na modalidade à distância (EAD). Realize de forma rápida o Curso de Reciclagem para Condutores Infratores do Rio de Janeiro.', // Descrição Básica

    //Social Url
    'UrlFacebook'       => '#', // Url social Facebook
    'UrlInstagram'      => '#', // Url social Instagram
    'UrlTwitter'        => '#', // Url social Twitter
    'UrlGoogle'         => '#', // Url social Google
    'UrlYoutube'        => '#', // Url social Youtube
    'FacebookImage'     => 'logo-200x200.jpg', // Imagem social Facebook compartilhamento
    
    //Sistems Operations
    'databaseName'      => '',
    'Domain'            => Router::url('/', true),
    'DomainImagesCertificate' => 'http://lmcursosdetransito.dayvisonsilva.com.br',
    'EmailTo'           => 'contato@lmcursosdetransito.com.br', // Email utilizado como send de envio
    'EmailCc' => '',
    'EmailBcc' => '',
    'EmailName'         => 'LM Cursos', // Nome utilizado como send de envio
    //SuperAdmin
    'superAdmins'       => ['dayvisonsilva'],

    //Socials
    'Youtube'          => 'https://www.youtube.com/channel/UCpxwxlQyLFbtMusdmT3ExOQ',
    'TimeForBiometriaFacial' => '300000', //5 min = 300000 //4 min = 240000 //1 min = 60000
    'DataDefaultPollQuestionAlternatives'=>[
        0 => array('name' => '0'),
        1 => array('name' => '1'),
        2 => array('name' => '2'),
        3 => array('name' => '3'),
        4 => array('name' => '4'),
        5 => array('name' => '5'),
        6 => array('name' => '6'),
        7 => array('name' => '7'),
        8 => array('name' => '8'),
        9 => array('name' => '9'),
        10 => array('name' => '10')
    ],
 ));

/**
 * Configuration Of Result of Pages
 */
Configure::write('ResultPage', 20);

/**
 * Configuration Of Status User
 */
Configure::write('ForumPostCommentStatus',1);
Configure::write('ForumPostStatus',1);
Configure::write('ForumStatus',1);
Configure::write('DirectMessageStatus',1);

//dev ou prod
Configure::write('Branch','prod');

/*Configuration Of Pagarme*/
Configure::write('Pagarme',[
    //'api_key' => 'ak_test_W6xJpNHFL50sOyi9b40I6E9wJEOcbe',
    //'encryption_key' => 'ek_test_vZECuesBG6lMV0KNdNPIYJePaLtJPK',
    //'postback_url' => Configure::read('Branch') == 'dev' ? 'https://requestb.in/zstw3vzs' : Router::url(array('controller'=>'orders','action'=>'postback_pagarme','prefixes'=>false),true)
    'api_key' => 'ak_live_0vz1gyusrf0JRCmacvythVEoaVqCds',
    'encryption_key' => 'ek_live_jYE80z3OKPnAYOVcCdAmsOY69VmOGb',
    'postback_url' => 'https://lmcursosdetransito.com.br/orders/postback_pagarme'
]);

/**
 * Configuration Of Developer
 */
Configure::write('Developer', array(
    'Title' => 'LM Cursos',
    'Company' => 'LM Cursos',
    'Email' => 'dayvisonsilva@gmail.com',
    'Website' => 'http://www.dayvisonsilva.com.br/',
    'Author' => 'Dayvison Silva',
    'AuthorEmail' => 'dayvisonsilva@gmail.com',
));

setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');