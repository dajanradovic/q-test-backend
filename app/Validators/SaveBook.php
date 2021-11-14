<?php

namespace App\Validators;

class SaveBook{

    public const TITLE = 'title';
    public const DESCRIPTION = 'description';
    public const ISBN = 'isbn';
    public const RELEASE_DATE = 'release_date';
    public const FORMAT = 'format';
    public const NUMBER_OF_PAGES = 'number_of_pages';
    public const AUTHOR_ID = 'author_id';
    public const REQUIRED_MESSAGE = 'is required';

    private $formData;

    public function __construct(array $data){
    
        $this->formData = $data;
    }

    public function validate() : array{
        $errorsArray= [];

        foreach($this->formData as $index=>$item){

            if($index == self::TITLE && (!$item || $item == '')){
                $errorsArray['title'] = $index . ' ' . self::REQUIRED_MESSAGE;
                continue;
            }
            if($index == self::DESCRIPTION && (!$item || $item == '')){
                $errorsArray['description'] = $index . ' ' . self::REQUIRED_MESSAGE;
                continue;
            }
            if($index == self::ISBN && (!$item || $item == '')){
                $errorsArray['isbn'] = $index . ' ' . self::REQUIRED_MESSAGE;
                continue;
            }
            if($index == self::FORMAT && (!$item || $item == '')){
                $errorsArray['format'] = $index . ' ' . self::REQUIRED_MESSAGE;
                continue;
            }
            if($index == self::NUMBER_OF_PAGES && (!$item || $item == '')){
                $errorsArray['number_of_pages'] = $index . ' ' . self::REQUIRED_MESSAGE;
                continue;
            }
            if($index == self::RELEASE_DATE && (!$item || $item == '')){
                $errorsArray['release_date'] = $index . ' ' . self::REQUIRED_MESSAGE;
                continue;
            }
        }
        
        return $errorsArray;
    }


}