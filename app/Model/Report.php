<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Report Model
 * @property Product $Product
 */
class Report extends AppModel {

	public $useTable = false; //este mode não terá tabela própria

	public function download($file){
	  	if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}
	}

    public function __FormatXLS($reports){
		$data = [];
		$i=0;
        foreach ( $reports as $report ) {
            $data[$i]['aluno'] = str_pad(mb_strtoupper(str_replace('-','',$this->__Normalize($report['User']['name']))), 40);
            $data[$i]['cpf'] = $this->__Normalize($report['User']['cpf']);
            $data[$i]['start'] = date('d-m-Y', strtotime($report['UserCertificate']['start']));
            $data[$i]['finish'] = date('d-m-Y', strtotime($report['UserCertificate']['finish']));
            $data[$i]['nota'] = $report['UserCertificate']['score'];
           	$i++;
        }
        return $data;
	}

	public function __FormatAVL($reports){
		$data = '18657198000146'.str_replace('-', '', date('d-m-Y')).PHP_EOL;
        foreach ( $reports as $report ) {
            $aluno = str_pad(mb_strtoupper(str_replace('-','',$this->__Normalize($report['User']['name']))), 40);
            $cpf = $this->__Normalize($report['User']['cpf']);
            $start = date('d-m-Y', strtotime($report['UserCertificate']['start']));
            $finish = date('d-m-Y', strtotime($report['UserCertificate']['finish']));
            $nota = $report['UserCertificate']['score'];
           
            $data .= $cpf.$aluno.str_replace('-', '', $start).str_replace('-', '', $finish).'D'.((strlen($nota) > 2) ? $nota : '0'.$nota).PHP_EOL;
        }
        return trim($data);
	}

	public function __GenerateAVL($content){
		$name = "18657198000146".str_replace('-', '', date('d-m-Y')).".avl";

        if ( file_exists('files/reports/'.$name) ) {
            @unlink('files/reports/'.$name);
        }
        
        $file = fopen('files/reports/'.$name, 'a');
        fwrite($file, $content);
        fclose($file);

        if ( file_exists('files/reports/'.$name) ) {
            return 'files/reports/'.$name;
        }else{
        	return false;
        }
	}
}