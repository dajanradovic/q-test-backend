<?php

namespace App\Services;

use Exception;


class AuthenticationService{

    public function saveToken(array $data){
       
        try{
            $randomString = $this->generateUniqueId();
            $tokenFile = fopen(__DIR__ . '/../files/' . $randomString . "key.txt", "w");

            fwrite($tokenFile, $data ['token_key'] . "\n");
            fwrite($tokenFile, $data['user']['first_name'] . ' ' . $data['user']['last_name']);
            $this->setValidationCookie($randomString);
        }
        catch(Exception $e){

        }finally{
            fclose($tokenFile); 
        }
        
               
    }

    private function generateUniqueId() : string{

        return md5(microtime(true).mt_Rand());
    }

    private function setValidationCookie($value){

        setcookie('id', $value, time() + (86400 * 30), "/"); // 86400 = 1 dan
    }

    public function getToken() : ?bool{

        if(isset($_COOKIE['id']) && file_exists(__DIR__ . '/../files/' . $_COOKIE['id'] . 'key.txt')){
            try{

                $myfile = fopen(__DIR__ . '/../files/' . $_COOKIE['id'] . 'key.txt', "r");
                $token = trim(fgets($myfile));
                $name = trim(fgets($myfile));
               
                $_SESSION['user'] = [
                    'api_token' => $token,
                    'name' => $name
                 ];
                
                 return true;
            
            }catch(Exception $e){
                 return false;

            }finally{
                fclose($myfile);
            }
        }
        return false;

    }

    public function storeUserDataInSession(array $response){
       
        $_SESSION['user'] = [
            'api_token' => $response['token_key'],
            'name' => $response['user']['first_name'] . ' ' . $response['user']['last_name']
           ];

        }

    public function removeUserFromSessionAndInvalidateCookie() : void {
        setcookie('id', time() - 3600);
        unset($_SESSION['user']);
    
    }


}