<?php

/**
 * Helper to create form fields.
 *
 * @filesource
 * @copyright  Copyright 2018
 * @author     Dayvison Silva - www.lmcursosdetransito.com.br
 * @since      2.0
 */
App::uses('AppHelper', 'View/Helper');

/*
 * Actions
 * __FormatDate
 * __FormatDatePicker
 * __Normalize
 * __LimitText
 * __SumDate
 * __FormatStatus
 * __FormatStar
 * __ArrayRandom
 * __FormatPrice
 * __ExtractCourses
 * __getConfigCourse
 */

class UtilityHelper extends AppHelper { 
    
    public $helpers = array('Html', 'Text','Session');

    /*
     * Função responsável por tratar uma data,
     * formatando ela de diferentes formas.
     * 
     * Exemplos:
     * Normal (00/00/0000)
     * DayWeekMonth (Dia (00.Mês))
     * Week (Dia)
     * NormalWithTime (00/00/0000 às 00:00:00)
     * WithoutExtensiveYear (Dia de Mês)
     * WithExtensiveYear (Dia, 00 de Mês de 0000)
     * ExtensiveMonth (Mês)
     */
    public function __FormatDate($USDate, $Format="normal")
    {
        if(!$USDate):
            return false;
        endif;
        
        if($USDate != '0000-00-00' && $USDate != '0000-00-00 00:00:00' && (strstr($USDate, '-'))):
            
            if(strstr( $USDate, ' ' )):
                list($date, $time) = explode(' ', $USDate);
            else:
                $date = $USDate;
            endif;

            list($year, $month, $day) = explode('-', $date);
            
            $Months = array(
                '01'=>'Janeiro',
                '02'=>'Fevereiro',
                '03'=>'Março',
                '04'=>'Abril',
                '05'=>'Maio',
                '06'=>'Junho',
                '07'=>'Julho',
                '08'=>'Agosto',
                '09'=>'Setembro',
                '10'=>'Outubro',
                '11'=>'Novembro',
                '12'=>'Dezembro'
            );
            
            $Week = array(
                '0'=>'Domingo',
                '1'=>'Segunda-feira',
                '2'=>'Terça-feira',
                '3'=>'Quarta-feira',
                '4'=>'Quinta-feira',
                '5'=>'Sexta-feira',
                '6'=>'Sábado'
            );

            $tstamp = strtotime($USDate);
            $tstamp = date("w", $tstamp);
            
            if ($Format == "Normal"):
                return "$day/$month/$year";

            elseif($Format == "DayWeekMonth"):
                return "$Week[$tstamp] ($day.$month)";

            elseif($Format == "Week"):
                return "$Week[$tstamp]";

            elseif($Format == "NormalWithTime"):
                return "$day/$month/$year às $time";
            
            elseif($Format == "WithoutExtensiveYear"):
                return "$day de $Months[$month]";

            elseif($Format == "WithExtensiveYear"):
                return "$Week[$tstamp], $day de $Months[$month] de $year";

            elseif($Format == "ExtensiveMonth"):
                return "$Months[$month]";

            else:
                return "$day/$month/$year às $time";
            endif;
            
            
        endif;
    }

    
    public function __FormatDatePicker($data)
    {
        return date('d/m/Y', strtotime($data));
    }
    
    /*
     * Função responsável por tratar uma string,
     * retirando os espaços e caracteres especiais.
     */
    public function __Normalize($string)
    {
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b);
        $string = str_replace("-","",$string);
        $string = str_replace("&","e",$string);
        $string = str_replace(" ","-",$string);
        $string = str_replace(".","",$string);
        $string = str_replace("!","",$string);
        $string = str_replace("?","",$string);
        $string = str_replace(":","",$string);
        $string = str_replace(";","",$string);
        $string = str_replace(";","",$string);
        $string = str_replace(",","",$string);
        $string = str_replace("'","",$string);
        $string = str_replace("\"","",$string);
        $string = str_replace("/","",$string);
        $string = str_replace("|","",$string);
        $string = str_replace("--","-",$string);
        $string = str_replace("---","-",$string);
        $string = str_replace("----","-",$string);
        $string = strtolower($string);

        return utf8_encode($string);
    }

    /*
     * Função responsável por tratar uma string,
     * limitando a quantidade de caracteres sem cortar a palavra.
     */
    function __LimitText($string, $length = 60, $center = false, $append = null)
    {
        // Set the default append string
        if ($append === null)
            $append = ($center === true) ? ' ... ' : '...';

        // Get some measurements
        $len_string = strlen($string);
        $len_append = strlen($append);

        // If the string is longer than the maximum length, we need to chop it
        if ($len_string > $length) {
            // Check if we want to chop it in half
            if ($center === true) {
                // Get the lengths of each segment
                $len_start = $length / 2;
                $len_end = $len_start - $len_append;

                // Get each segment
                $seg_start = substr($string, 0, $len_start);
                $seg_end = substr($string, $len_string - $len_end, $len_end);

                // Stick them together
                $string = $seg_start.$append.$seg_end;
            } else {
                // Otherwise, just chop the end off
                $string = substr($string, 0, $length - $len_append).$append;
            }
        }

        return $string;
    }
    
    /*
     * Função responsável por somar dias,
     * passando uma data atual + x dias para uma data futura.
     * 
     * Exemplo:
     * __sumDate('2013-01-01', 10);
     * Seu retorno será 10 dias da data informada.
     */
    function __SumDate( $datein , $count = 1 )
    {
        $datexplode = explode('-',$datein);
        $dias = +$count;
        $dia = $datexplode[2];
        $mes = $datexplode[1];
        $ano = $datexplode[0];
        $datein = mktime(24*$dias, 0, 0, $mes, $dia, $ano);
        $datein = date('Y-m-d',$datein);

        return $datein;
    }
    
    /*
     * Função responsável por tratar status,
     * aplicando layout bootstrap e click para atualização de status ajax.
     * 
     * Ao passar o valor $remote, ele irá aplicar ao click.
     */
    function __FormatStatus($data,$remote=null)
    {

        // Inactive
        if($data == 0):
            if($remote):
                $data = '<a onclick="'.$remote.'"><span class="label label-danger">Inativo</span></a>';
            else:
                $data = '<span class="label label-danger">Inativo</span>';
            endif;

        // Active
        elseif($data == 1):
            if($remote):
                $data = '<a onclick="'.$remote.'"><span class="label label-success">Ativo</span></a>';
            else:
                $data = '<span class="label label-success">Ativo</span>';
            endif;
            
        endif;

        return $data;

    }
    
    
    function __FormatQuestion($data){

        // Inactive
        if($data == 0):
            $data = '<span class="label label-default">Não</span>';

        // Active
        elseif($data == 1):
            $data = '<span class="label label-success">Sim</span>';
        endif;

        return $data;

    }
    
    
    function __ArrayRandom($arr, $num = 1) 
    {
        shuffle($arr);

        $r = array();
        for ($i = 0; $i < $num; $i++) {
            if(isset($arr[$i])):
                $r[] = $arr[$i];
            endif;
        }
        return $num == 1 ? $r[0] : $r;
    }
    
    
    function __FormatPrice($data, $format=null, $cent=null)
    {
        if($data==0):
            $data = '0.00';
        endif;

        /**
        * Formatação de Real.
        * Padrão ex: 10,00
        * Personalizado ex: R$ 10,00
        *
        * Para utilizar o personalizado envie formatMoeda($valor, 'cifrao')
        */
        $data_string = str_replace(',','.',$data);
        if($data_string):
            if($format=='cifrao'){
                $data = 'R$ '.number_format($data_string,2,',','.');
            }else{
                $data = number_format($data_string,2,',','.');
            }

            if($cent):
                if($format=='cifrao'){
                    $data = 'R$ '.number_format($data_string,0,',','.');
                }else{
                    $data = number_format($data_string,0,',','.');
                }
            endif;

            return $data;
        else:
            return false;
        endif;
    }

    public function is_block($data){
        if($data==1):
            return '<b style="color:green;">Desbloqueado</b>';
        else:
            return '<b style="color:red;">Bloqueado</b>';
        endif;
    }

    public function clockTimeDiff($diff = null){
        if($diff):
            if($diff['month']):
                $plural = $diff['month']>1?' meses':' mês';
                return '<i class="fa fa-fw fa fa-clock-o"></i> ' .$diff['month'].$plural;
            elseif($diff['day']):
                $plural = $diff['day']>1?' dias':' dia';
                return '<i class="fa fa-fw fa fa-clock-o"></i> ' .$diff['day'].$plural;
            elseif($diff['hour'] && $diff['hour']!='00'):
                $plural = $diff['hour']>1?' horas':' hora';
                return '<i class="fa fa-fw fa fa-clock-o"></i> ' .$diff['hour'].$plural;
            elseif($diff['minute']==0):
                return '<i class="fa fa-fw fa fa-clock-o"></i> ' .'alguns segundos';
            else:
                $plural = $diff['minute']>1?' minutos':' minuto';
                return '<i class="fa fa-fw fa fa-clock-o"></i> ' .$diff['minute'].$plural;
            endif;
        endif;
    }

    public function avatarUser($user_id = null, $avatar = null, $class = null, $id = null){
        if($avatar):
            return $this->Html->image('../files/user/avatar/'.$user_id.'/thumb_'.$avatar, ['class' => $class, 'id' => $id]);
        else:
            return $this->Html->image('../themes/images/people/avatar_2x.png', ['class' => $class, 'id' => $id]);
        endif;
    }

    public function getFirstName($full_name = '')
    {
        if (trim($full_name) != '') {
            $strNomeSplit = explode(' ', trim($full_name));
            return (count($strNomeSplit) > 1 && strpos($strNomeSplit[0], '.') !== false) ? $strNomeSplit[0] . ' ' . $strNomeSplit[1] : $strNomeSplit[0];
        }
        return $full_name;
    }

    public function playerMp3($url = null, $path = null){
        $src = Router::url('/', true).'files/'.$path.$url;
        return '<audio controls><source src="'.Router::url('/', true).'files/'.$path.$url.'" type="audio/mpeg"></audio>';
    }
    
    public function __ExtractCourses($data, $showStatusDetran = false){
        $courses = '';
        if( !empty($data) ){
            foreach ($data as $course) {
                $status = $showStatusDetran ? $this->__StatusDetran($course) : '';
                $courses .= "<li>{$course['Course']['name']} {$status}</li>";
            }
        }
        return $courses;
    }

    public function __StatusDetran($course) {
        if ($course['Course']['course_type_id'] == CourseType::RECICLAGEM || $course['Course']['course_type_id'] == CourseType::ESPECIALIZADOS || $course['Course']['course_type_id'] == CourseType::ATUALIZACAO) {

            $intStatusDetran = isset($course['StatusDetran']['id'])   ? $course['StatusDetran']['id']   : null;
            $strStatusDetran = isset($course['StatusDetran']['nome']) ? $course['StatusDetran']['nome'] : 'Não comunicado';

            if (empty($course['mensagem_retorno_detran'])) {
                $title = 'Não houve comunicação com o Detran para esta matrícula.';
            } else {
                $strCodigoRetorno = !empty($course['codigo_retorno_detran']) ? $course['codigo_retorno_detran'] . ' - ' : '';
                $title            = $strCodigoRetorno . $course['mensagem_retorno_detran'] . ' <br><br> ' . date_create($course['data_status_detran'])->format('d/m/Y H:i:s');
            }

            switch ($intStatusDetran) {
                case 1:
                case 6:
                    $class = 'danger';
                    break;
                case 2:
                    $class = 'warning';
                    break;
                case 3:
                    $class = 'primary';
                    break;
                case 4:
                    $class = 'info';
                    break;
                case 5:
                    $class = 'success';
                    break;
                default:
                    $class = 'default';
            }
            $status = '<span class="label-status-detran label label-'. $class . '" data-toggle="tooltip" data-original-title="' . $title . '" data-html="true">' . $strStatusDetran . '</span>';
        } else {
            $status = '';
        }

        return $status;
    }

    public function __ExtractCities($data){
        $cities = '';
        if( !empty($data) ){
            foreach ($data as $citie) {
                if( !empty($citie['Citie']) ){
                    $cities .= "<li>{$citie['Citie']['name']}</li>";
                }
            }
        }
        return $cities;
    }

    public function __ExtractStates($data){
        $cities = '';
        if( !empty($data) ){
            foreach ($data as $state) {
                if( !empty($state['State']) ){
                    $cities .= "<li>{$state['State']['name']}</li>";
                }
            }
        }
        return $cities;
    }

    public function __getConfigCourse($dataConfig, $course){

        if( isset($course['UserQuestion'][0]['result']) ){
            //Se já foi respondida e conseguiu a média
            $dataConfig['mensage_avaliation_module'] = "<span class='text-green-300'><i class='fa fa-fw fa-trophy'></i> Parabéns! Você atingiu {$course['UserQuestion'][0]['value_result']} pts.</span>";
            $dataConfig['cicle_box'] = 'bg-orange-300 text-white';
            $dataConfig['url_simulate_course'] = $dataConfig['is_avaliation_module_block'] ? '' : Router::url('/', true).'meus-cursos/simulate_result/'.$this->params['pass'][0].'/'.$course['UserQuestion'][0]['id'];
        }else{
            //Se não foi respondida ou não conseguiu tirar a média
            if( isset($course['UserQuestion'][0]['value_avaliation']) ){
                $dataConfig['mensage_avaliation_module'] = "<span class='text-red-300'><i class='fa fa-fw fa-trophy'></i> Pontuação mínima não atingida! Você tirou {$course['UserQuestion'][0]['value_result']} pts, o mínimo necessário é {$course['Course']['value_course_avaliation']} pts.</span>";
                $dataConfig['cicle'] = 'text-red-200';
            }
            if( $dataConfig['is_avaliation_result_certificate_block'] ){
                $dataConfig['url_simulate_course'] = Router::url('/', true).'meus-cursos/simulate_courses/'.$this->params['pass'][0].'/'.$course['Course']['token'];
            }
        }
        return $dataConfig;
    }

    public function __getInactiveColor($slide){
        return !empty($slide['UserModuleLog'])?'disabled':'';
    }

    public function __getAuthor($author){
        return $author == 'Student' ? 'User' : 'Instructor';
    }

    public function breadcumbs($links = array()){
        $breadcumbs = '';
        if(!empty($links)){
            $breadcumbs = '<ul class="breadcumbs">';
            $i = 1;
            foreach($links as $title => $url){
                $breadcumbs .= '<li>'.$this->Html->link($title,$url,['escape'=>false]);
                if($i++ < count($links)){
                    $breadcumbs .=  '<i class="fa fa-chevron-right arrow hidden-xs"></i>';
                    $breadcumbs .=  '<i class="fa fa-chevron-down arrow hidden-sm hidden-lg hidden-md"></i>';
                }
                $breadcumbs .= '</li>';
            }
            $breadcumbs .= '</ul>';
        }
        return $breadcumbs;
    }

    public function __getActiveClass($controller, $action){
        return ($this->params['controller'] == $controller and $this->params['action'] == $action) ? 'active' : ''; 
    }

    public function __getTarget($target){
        $return = '';
        switch($target){
            case 0:
                $return = '_self';
                break;
            case 1:
                $return = '_blank';
                break;
        }
        return $return;
    }

    public function __isScopeNacional($scope){
        return $scope == CourseType::AMBITO_NACIONAL;
    }

    public function __isScopeEstadual($scope){
        return $scope == CourseType::AMBITO_ESTADUAL;
    }

    public function __isScopeMunicipal($scope){
        return $scope == CourseType::AMBITO_MUNICIPAL;
    }

    public function __getBgColorModuleList($is_time_complete){
        return $is_time_complete ? 'bg-success complete' : '';
    }

    public function __getIconModuleList($is_time_complete){
        return $is_time_complete ? 'fa-check' : 'fa-circle';
    }

    public function __ShowTitleModule($module, $progress_in_module, $in_column_right){
        
        $style_icon_block_half = $in_column_right ? 'width: 20px;height: 20px;line-height: 20px;font-size: 20px;' : '';
        $style_icon_block_half_icon = $in_column_right ? 'font-size: 14px;' : '';
        $style_text_headline = $in_column_right ? 'font-size: 18px;line-height:1.46rem;margin-top:0px;' : '';
        $style_h4_text_light_spam = $in_column_right ? 'font-size: 12px;' : '';
        
        $class_icon_desblock = $module['Module']['desblock']?'bg-indigo-300 text-white':'bg-default text-gray';
        $text_value_time = $module['Module']['value_time'] ? "<p><h4 class='text-left text-light' style='{$style_h4_text_light_spam}'><i class='fa fa-fw fa-clock-o'></i> <span class='hidden-xs'>Carga Horária Total do Módulo: </span>{$module['Module']['value_time']}hs.</h4></p>" : "";
        $text_progress_in_module = $progress_in_module ? "<div class='progress-bar1 pull-right' data-percent='{$module['Module']['progress']}' data-duration='1000' data-color='#ccc,yellow'></div>" : '';
        

        return "<div class='media'>
                    <div class='media-left'>
                        <span class='icon-block img-circle {$class_icon_desblock} half' style='{$style_icon_block_half}'><i class='fa fa-graduation-cap' style='{$style_icon_block_half_icon}'></i></span>
                    </div>
                    <div class='media-body'>
                        <h4 class='text-headline' style='{$style_text_headline}'>{$module['Module']['name']}</h4>
                        {$text_value_time}
                        <p>{$module['Module']['text']}</p>
                        {$text_progress_in_module}
                    </div>
                </div>";
    }
    
    public function __ShowLineDiscipline($module, $module_discipline, $progress_in_module, $in_column_right){

        $return = '';
        $icon_module_list = $this->__getIconModuleList($module_discipline['is_discipline_complete']);
        $class_desblock = $module_discipline['desblock']?'text-green-300':'text-grey-200';
        $text_value_time = $module['Module']['value_time'] ? "<span class='pull-right'><i class='fa fa-fw fa-clock-o'></i> {$module_discipline['hours']} hs</span>" : '';

        if( !$in_column_right ){
            $return .= '<i class="fa fa-fw fa-file-text text-indigo-300"></i>';
            $return .= '<i class="fa fa-fw '.$icon_module_list.' '.$class_desblock.'"></i>';
            $return .= $module_discipline['name'];
            $return .= $text_value_time;
        }
        else{
            $return .= '<i class="fa fa-fw '.$icon_module_list.' '.$class_desblock.'"></i>';
            $return .= $this->Text->truncate($module_discipline['name'], 37);
        }           
            
        if( $progress_in_module ){             
            $return .= "<div class='progress-bar1 pull-right' data-percent='{$module_discipline['progress']}' data-duration='1000' data-color='#ccc,yellow'></div>";
        }

        return $return; 
    }

    public function __showPaginationSliderOrPlayer($module_discipline, $page, $total_pages, $model){
        $return = '';
        if( isset($module_discipline[$model]) and !empty($module_discipline[$model]) ){
            for ( $i=0; $i < $total_pages; $i++ ){
                $inactiveColor = $this->__getInactiveColor($module_discipline[$model][$i]);
                
                //if( ($i <= ($page + 1)) OR ($inactiveColor == 'disabled') ){
                //    $linkPage = ['action' => $this->params['action'], $this->params['pass'][0], $this->params['pass'][1], $i];
                //}else{
                //    $linkPage = 'javascript:void(0);';
                //}

                if( $inactiveColor == 'disabled' ){
                    $linkPage = ['action' => $this->params['action'], $this->params['pass'][0], $this->params['pass'][1], $i];
                }else{
                    if( (($i+1) == $total_pages) OR ($i <= ($page + 1)) ){
                        $linkPage = ['action' => $this->params['action'], $this->params['pass'][0], $this->params['pass'][1], $i];
                    }else{
                        $linkPage = 'javascript:void(0);';
                        $linkPage = ['action' => $this->params['action'], $this->params['pass'][0], $this->params['pass'][1], $i];
                    }
                }

                $class = $page == $i ? 'active' : $inactiveColor;
                $return .= "<li class='{$class}'>";
                $return .= $this->Html->link($i+1, $linkPage);
                $return .= "</li>";
            }
        }
        return $return;
    }

    public function __MaskOrderId($id, $tam=6){
        return str_pad($id, $tam, '0', STR_PAD_LEFT);
    }

    public function __ShowModulesInCertificate($modules){
        $string = [];
        foreach ($modules as $module) {
            $string[] = "{$module['value_time']} hora(s) de {$module['module_name']}";
        }
        return join(', ', $string);
    }

    public function __isBoleto($method_id){        
        if(in_array($method_id,[Method::PAGARME_BOLETO])){
            return true;
        }
        return false;
    }

    private function isEmpty(array $data, $key){
        return !isset($data[$key]) || empty($data[$key]);
    }

    public function getStudentAddressString(array $studentData) {

        $ret = '';

        if (!$this->isEmpty($studentData, 'address') && !$this->isEmpty($studentData, 'number')) {
            $ret .= $studentData['address'] . ', ' . $studentData['number'] . ' - ';
        } elseif (!$this->isEmpty($studentData, 'address')) {
            $ret .= $studentData['address'] . ' - ';
        }

        if (!$this->isEmpty($studentData, 'neighborhood')) {
            $ret .= $studentData['neighborhood'] . ', ';
        }

        if (!$this->isEmpty($studentData, 'City') && !$this->isEmpty($studentData['City'], 'name') &&
            !$this->isEmpty($studentData, 'State') && !$this->isEmpty($studentData['State'], 'abbreviation')) {
            $ret .= $studentData['City']['name'] . ' / ' . $studentData['State']['abbreviation'];

        } elseif (!$this->isEmpty($studentData, 'City') && !$this->isEmpty($studentData['City'], 'name')) {
            $ret .= $studentData['City']['name'];
        } elseif (!$this->isEmpty($studentData, 'State') && !$this->isEmpty($studentData['State'], 'abbreviation')) {
            $ret .= $studentData['State']['abbreviation'];
        }


        return $ret;
    }

    public function __isAmbientSchool(){
        $student = $this->Session->read('Auth.User.Student');
        $student = isset($student[0]) ? $student[0] : $student;
        return !empty($student['School']) ? true : false;
    }

    public function __getSchool($student){
        $student = isset($student[0]) ? $student[0] : $student;
        return !empty($student['School']) ? $student['School'] : false;
    }

    public function __getLogo(){
        $school = $this->__getSchool($this->Session->read('Auth.User.Student'));
        if( !$school ){
            echo $this->Html->link($this->Html->image('site/logo-header.png',['class'=>'logo']),['controller'=>'pages','action'=>'index','school'=>false],['escape'=>false]); 
        }else{
            if( !empty($school['image']) ){
                echo $this->Html->link($this->Html->image("/files/school/image/{$school['id']}/thumb_{$school['image']}",['class'=>'logo']),['controller'=>'meus-cursos','action'=>'index','school'=>false],['escape'=>false]); 
            }else{
                 echo $this->Html->link( "<span style='font-size: 15px;'>{$school['name']}</span>", ['controller'=>'meus-cursos','action'=>'index','school'=>false],['escape'=>false]); 
            }
        }
    }

    /**
     * [__isAllowedChat função que permite ou não a exibição do chat no site]
     * @return [booolean] [retorna true se puder mostrar o chat e false se não puder]
     */
    public function __isAllowedChat(){

        //se entrar aqui, mas o aluno não estiver logado, não veio do ambiente da autoescola, então pode liberar
        if( !$this->Session->read('Auth.User.Student') ){
            return true;
        }

        $school = $this->__getSchool($this->Session->read('Auth.User.Student'));

        //se não for aluno de escola, então o ambiente nào é da escola, pode autorizar a exibicao do char
        if( !$school ){
            return true;
        }else{
            return false;
        }
    }

    public function __getLinkAtendimento(){
        $school = $this->__getSchool($this->Session->read('Auth.User.Student'));
        if( !$school ){
            echo $this->Html->link('Atendimento', ['controller' => 'atendimento', 'action' => 'contact_us','school'=>false]);
        }else{
            echo $this->Html->link('Atendimento', ['controller' => 'virtual_rooms', 'action' => 'contact_us', 'school'=>true]);
        }
    }

    public function __getMetaTitle(){
        $school = $this->__getSchool($this->Session->read('Auth.User.Student'));
        if( !$school ){
            return Configure::read('Developer.Title');
        }else{
            return 'Ambiente Auto Escola';
        }
    }

    public function __FormatTime($intMinutes)
    {
        $strHoras   = str_pad(floor($intMinutes / 60), 2, '0', STR_PAD_LEFT);
        $strMinutos = str_pad($intMinutes % 60, '2', '0', STR_PAD_LEFT);
        return "$strHoras:$strMinutos";
    }

    public function __getSeoPage($data=false){
        switch ($this->request->params['action']) {
            case 'view':
                if( $this->request->params['controller'] == 'courses' ){
                    return [
                        'title'=>"{$data['Course']['name']} - {$data['Course']['firstname']} ".Configure::read('Sistems.Title'),
                        'description'=>"No {$data['Course']['name']} {$data['Course']['firstname']} você encontra um conteúdo online claro e objetivo apresentado de forma dinâmica, participativa, buscando análise e reflexão sobre a responsabilidade de cada um para um trânsito seguro.",
                        'keyword'=>Configure::read('Sistems.Keyword')
                    ]; 
                }
                else{
                    return [
                        'title'=>Configure::read('Sistems.Title'),
                        'description'=>Configure::read('Sistems.Description'),
                        'keyword'=>Configure::read('Sistems.Keyword')
                    ];
                }
            default:
                return [
                    'title'=>Configure::read('Sistems.Title'),
                    'description'=>Configure::read('Sistems.Description'),
                    'keyword'=>Configure::read('Sistems.Keyword')
                ];
        }
    }
}
