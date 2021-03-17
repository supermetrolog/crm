<?php
namespace Bitkit\Core\Files ;
class File{

    public $filename;
    public $content;

    public $buffer;

    public function __construct($filename) {
        $this->filename = $filename;
    }


    public function fileDelete(){
        if(file_exists($this->filename && is_file($this->filename))){ //delete file
            if(unlink($this->filename)){
                return true;
            }
        }
        return false;
    }

    public function createFile($content){
        if(file_put_contents($this->filename,$content)){
            return true;
        }else{
            return false;
        }
    }

    public function readFile(){
        $this->content = file_get_contents($this->filename);
        if($this->content){
            return $this->content;
        }else{
            return NULL;
        }
    }

    public function updateFile(){
        if(file_put_contents($this->filename,$this->content)){
            return true;
        }else{
            return false;
        }
    }


    public function appendFile($content){
        $file_cont = file_get_contents($this->filename);
        $file_cont.=$content;
        if(file_put_contents($this->filename,$file_cont)){
            $this->content = $file_cont;
            return true;

        }
        return false;

    }

    public function prependFile($content){
        $file_cont = file_get_contents($this->filename);
        $file_cont = $content.$file_cont;
        if(file_put_contents($this->filename,$file_cont)){
            $this->content = $file_cont;
            return true;

        }
        return false;
    }


    public function getFileExtension(){
        $ext = array_pop(explode('.',$this->filename));
        return $ext;
    }


    public function getFileName(){
        $name_parts = explode('/',$this->filename);
        $name = array_pop($name_parts);
        return $name;
    }

    public function getFilePureName(){
        $name_parts = explode('.',$this->getFileName());
        array_pop($name_parts);
        return implode('.',$name_parts);
    }

    public function getFileType(){
        return filetype($this->filename);
    }

    public function getFileInfo(){
        return stat($this->filename);
    }

    public function getFileSize(){
        return filesize($this->filename);
    }

    public function lastUpdate(){
        return filectime($this->filename);
    }




}