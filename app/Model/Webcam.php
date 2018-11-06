<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Webcam Model
 *
*/
class Webcam extends AppModel{
    
    public $useTable = false;

    private $imageFolder = "files/snapshots/";
    
    //This function will create a new name for every image captured using the current data and time.
    private function getNameWithPath($type){
        $name = $type == 'avatar' ? 'refimg.jpg' : 'unknown.jpg';
        //$name = $this->imageFolder.$name;
        $name = $this->imageFolder.date('YmdHis').".jpg";
        return $name;
    }

    public function sendImage($type){
    	$filepath = $this->getNameWithPath($type);
    	$file = file_put_contents( $filepath, file_get_contents('php://input') );
    	//retorna o filepath, caso tenha enviado com sucesso
    	return $file ? $filepath : false;
    }

    public function saveImage($filepath=false, $user_id=false){
    	if( $filepath and $user_id ){
            $this->query("UPDATE users SET avatar = '{$filepath}' WHERE id = '{$user_id}' LIMIT 1");
            return true;
    		//$this->loadModel('User');
    		//$this->User->id = $user_id;
    		//return $this->User->saveField('avatar', $filepath);
    	}
    }

    public function compare($avatar, $snapshot){
    	return true;
    }
    
    //function will get the image data and save it to the provided path with the name and save it to the database
    public function showImage($type){
        $file = file_put_contents( $this->getNameWithPath($type), file_get_contents('php://input') );
        if(!$file){
            return "ERROR: Failed to write data to ".$this->getNameWithPath($type).", check permissions\n";
        }
        else
        {
            //$this->saveImageToDatabase($this->getNameWithPath());         // this line is for saveing image to database
            return $this->getNameWithPath($type);
        } 
    }
    
    //function for changing the image to base64
    public function changeImagetoBase64($image){
        $path = $image;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
    
    public function saveImageToDatabase($imageurl){
        $image=$imageurl;
//        $image=  $this->changeImagetoBase64($image);          //if you want to go for base64 encode than enable this line
        if($image){
            $query="Insert into snapshot (Image) values('$image')";
            $result= $this->query($query);
            if($result){
                return "Image saved to database";
            }
            else{
                return "Image not saved to database";
            }
        }
    }   
}