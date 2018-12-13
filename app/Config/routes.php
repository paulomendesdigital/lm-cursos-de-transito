<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/school', array('controller' => 'users', 'action' => 'login','school'=>true));
Router::connect('/', array('controller' => 'pages', 'action' => 'index'));
Router::connect('/quem-somos', array('controller' => 'pages', 'action' => 'quemsomos'));
Router::connect('/termos-de-servico', array('controller' => 'pages', 'action' => 'termoservico'));
Router::connect('/contato', array('controller' => 'pages', 'action' => 'contact'));
Router::connect('/parceria', array('controller' => 'pages', 'action' => 'partner'));
Router::connect('/nossa-equipe', array('controller' => 'instructors', 'action' => 'index'));
Router::connect('/recuperar-senha', array('controller' => 'users', 'action' => 'pass'));
Router::connect('/acesso-aluno', array('controller' => 'users', 'action' => 'login'));
Router::connect('/acesso-parceiro', array('controller' => 'users', 'action' => 'login_partner'));
Router::connect('/curso-para-taxistas-lei-1246811', array('controller' => 'courses', 'action' => 'view', 1,'curso-para-taxistas-lei-1246811'));
Router::connect('/passo-a-passo-para-recuperar-sua-cnh', array('controller' => 'pages', 'action' => 'passoapasso'));

Router::connect('/cursos/:id-:slug/:uf', array('controller' => 'courses', 'action' => 'view'), array('id' => '[0-9]+', 'pass' => ['id', 'slug', 'uf']));
Router::connect('/cursos/:id-:slug/:uf/:company', array('controller' => 'courses', 'action' => 'landing_page'), array('id' => '[0-9]+', 'pass' => ['id', 'slug', 'uf', 'company']));
Router::connect('/cursos/:id-:slug', array('controller' => 'courses', 'action' => 'view'), array('id' => '[0-9]+', 'pass' => ['id', 'slug']));
Router::connect('/cursos', array('controller' => 'courses', 'action' => 'index'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/manager', array('controller' => 'pages', 'action' => 'index', 'manager' => true));

#URUÁRIOS
//Router::connect('/manager/users/administradores',array('controller'=>'users','action'=>'administrators', 'manager' => true));
//Router::connect('/manager/users/professores', array('controller'=>'users','action'=>'instructors', 'manager' => true));
//Router::connect('/manager/users/alunos', array('controller'=>'users','action'=>'students', 'manager' => true));

Router::parseExtensions('rss','xml');  //parse XML extension
Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'index')); //rewrite URL

Router::parseExtensions('pdf');

//LMS
Router::connect('/meus-cursos', array('controller' => 'virtual_rooms', 'action' => 'index'));
Router::connect('/meus-cursos/:action/*', array('controller' => 'virtual_rooms', 'action' => 'course'));
Router::connect('/curso-progresso/:action/*', array('controller' => 'virtual_rooms', 'action' => 'course_progress'));
Router::connect('/apostilas/:action/*', array('controller' => 'virtual_rooms', 'action' => 'workbooks'));
Router::connect('/biblioteca-virtual/:action/*', array('controller' => 'virtual_rooms', 'action' => 'libraries'));
Router::connect('/sala-multimidia', array('controller' => 'virtual_rooms', 'action' => 'multimidias'));
Router::connect('/sala-multimidia/:action/*', array('controller' => 'virtual_rooms', 'action' => 'multimidia'));
Router::connect('/fale-com-equipe-multidisciplinar/:action/*', array('controller' => 'virtual_rooms', 'action' => 'contact_team'));
Router::connect('/biometria/*', array('controller' => 'virtual_rooms', 'action' => 'biometria_facial'));
Router::connect('/biometria-facial/*', array('controller' => 'virtual_rooms', 'action' => 'biometria_facial'));
Router::connect('/atendimento/:action', array('controller' => 'virtual_rooms', 'action' => 'contact_us'));
Router::connect('/school/atendimento/contact_us', array('controller' => 'virtual_rooms', 'action' => 'school_contact_us'));

//PARTNERS
Router::connect('/minhas-vendas', array('controller' => 'partners', 'action' => 'index'));


Router::connect('/foruns/:action/*', array('controller' => 'virtual_room_forums', 'action' => 'index'));
//Router::connect('/foruns/:action/*', array('controller' => 'virtual_room_forums', 'action' => 'index'));

Router::connect('/meu-perfil/:action', array('controller' => 'virtual_room_users', 'action' => 'edit'));

Router::connect('/fale-com-instrutores/:action/*', array('controller'=>'virtual_room_direct_messages','action' => 'index'));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
