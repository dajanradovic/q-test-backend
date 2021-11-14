<?php

namespace App\Validators;

class Login{

    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const REQUIRED_MESSAGE = 'is required';

    private $formData;

    public function __construct(array $data){
    
        $this->formData = $data;
    }

    public function validate() : array{
        
        $errorsArray= [];

        foreach($this->formData as $index=>$item){

            if($index == self::EMAIL && (!$item || $item == '')){
                $errorsArray['email'] = $index . ' ' . self::REQUIRED_MESSAGE;
                continue;
            }
            if($index == self::PASSWORD && (!$item || $item == '')){
                $errorsArray['password'] = $index . ' ' . self::REQUIRED_MESSAGE;
                continue;
            }
        
        }
        
        return $errorsArray;
    }


}