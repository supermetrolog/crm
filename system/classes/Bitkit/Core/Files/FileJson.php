<?php
namespace Bitkit\Core\Files ;
class FileJson extends \Bitkit\Core\Files\File
{
    public $jsonModel;


    public function getJsonModel(){
        $this->content = file_get_contents($this->filename);
        if($this->content){
            return json_decode($this->content);
        }else{
            return NULL;
        }
    }




}