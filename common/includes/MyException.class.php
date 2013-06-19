<?php

/**
 * Description of MyException
 * 自定义异常类
 * @author Administrator
 */
class MyException extends Exception{
    private $user='';
    public static $po_id=1;
    public function getNewMessage(){
        return $this->message.' -get by chenqingji.';
    }
    public function getNewLine(){
        return parent::code;
    }
    public function getUser(){
        return $this->user;
    }
    public function getPo_id(){
        self::vancl();
        $this->vancl();
        return self::$po_id;
    }
    public function output(){
        echo self::vancl();
        echo "\n";
        echo $this->vancl();
        echo "\n";
    }          
    private static function vancl(){
        return 'vancl .com';
    }
}

class Test{
    public static function getName(){
        return 'my name is yuanchen.';
    }
}

?>
