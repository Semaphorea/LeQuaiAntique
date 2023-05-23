<?php
namespace App\Tools;

class Trace{

private $trace=null;

private function __construct(){
      
    $this->trace= debug_backtrace();
}


 

static function init(){
 return new Trace();
}

function args(){
    $this->trace[1]['args'];
} 

function c(){
      $this->trace[1]['class']; 
}

function file(){
    $this->trace[1]['file']; 
}

function func(){
    return $this->trace[1]['function'];  //nfunc
}

function l(){
 
    return  ($this->trace[1]["line"]); 
}

function ty(){
    $this->trace[1]['type']; 
}

/**
 * aargs() 
 * return string[]
 */
function aargs(){dd($this->args());}

/**
 * ac()
 * return string Classe Name
 */
function ac(){dd($this->c());}

/**
 * afunc()
 * return Function Name
 */
function afunc(){dd($this->func());}

/**
 * al() 
 * return string Line Number
 */
function al(){dd($this->l());}


/**
 * t()
 */
function t($message){ var_dump ("Classe : ".$this->c()." line : ".$this->l()." : ".$message); }

function getTrace(){
    return $this->trace;   
}



}
