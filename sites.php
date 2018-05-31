<?php

class Sites {

    public function make($fileclass, $code){
        require_once("Shop/".$fileclass.'.php');
        $class_name = ucfirst($fileclass);
        $w = new $class_name;
        $result = $w::GetProduct($code);
       return $result;
    }

}