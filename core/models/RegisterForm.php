<?php


namespace models;


use base\BaseForm;
use library\Auth;
use library\Request;
use ReCaptcha\ReCaptcha;

class RegisterForm extends BaseForm {
    public $login;
    public $password;
    public $password_confirm;
    public $email;
    public $captcha_response;

    protected $_tableName = 'user';

    /**
     * Must return an array, the keys must be the names of the fields,
     * the values are the arrays of the necessary rules .
     * @return array
     */
    public function getRules(){
        return [
            'login' => ['requiredFill', 'login', 'unique', 'trim', 'htmlSpecialChars'],
            'password' => ['requiredFill', 'password', 'confirm'],
            'password_confirm' => ['requiredFill', 'password'],
            'email' => ['requiredFill', 'email', 'unique', 'trim', 'htmlSpecialChars']
        ];
    }

    public function register(){
        $this->captcha_response=Request::getPostParam('g-recaptcha-response');
        if(!empty($this->captcha_response)){
            //Captcha Check:
            $config = require_once __DIR__.'/../config/captcha.php';
            $recaptcha = new \ReCaptcha\ReCaptcha($config['secret']);
            $res_captcha=$recaptcha->verify($this->captcha_response, $_SERVER['REMOTE_ADDR']);
            //----
            if($res_captcha->isSuccess()){
                $hash = password_hash($this->password,PASSWORD_DEFAULT);
                $sql = "INSERT INTO `{$this->_tableName}`(`login`, `password`, `email`) VALUES ('{$this->login}', '{$hash}', '{$this->email}'); ";
                $res = $this->_db->sendQuery($sql);
                if (!$res){
                    $this->_errors['register'] = 'DB Error!';
                    return false;
                }
                $id=$this->_db->getLastInsertId();
                Auth::login($id, $this->login, 'user','unknown.png');
                return true;
            }else{
                $this->addErrors(['captcha'=>'check failed']);
                return false;
            }

        }else{
            $this->addErrors(['captcha'=>'empty']);
            return false;
        }

    }




    private static function SiteVerify($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36");
        $curlData = curl_exec($curl);
        curl_close($curl);
        return $curlData;
    }
}