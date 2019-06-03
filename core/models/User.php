<?php


namespace models;


use base\BaseForm;
use library\Db;
use library\HttpException;
use library\Request;
use mysql_xdevapi\Exception;

class User extends BaseForm {
    public $id;
    public $login;
    public $regDate;


    public $email;
    public $sex;
    public $name;
    public $city;

    public $password;
    public $password_new;
    public $password_new_confirm;

    public $avatarPath;

    protected $_tableName = 'user';

    /**
     * Must return an array, the keys must be the names of the fields,
     * the values are the arrays of the necessary rules .
     * @return array
     */
    public function getRules()
    {
        if(Request::getPostParam('password')==''){
            return [
                'email' =>                  ['requiredFill', 'email', 'trim', 'htmlSpecialChars'],
                'sex' =>                    ['requiredFill', 'trim', 'htmlSpecialChars', 'len100'],
                'name' =>                   ['trim', 'htmlSpecialChars', 'len100'],
                'city' =>                   ['trim', 'htmlSpecialChars', 'len100']
            ];
        }else{
            return [
                'password' =>               ['requiredFill', 'password'],
                'password_new' =>           ['requiredFill', 'password', 'confirm'],
                'password_new_confirm' =>   ['requiredFill', 'password'],
            ];
        }
    }

    public function __construct($id){
        parent::__construct();
        if (($id!=null) and is_numeric($id)){
            $sql= "SELECT id, login, email, regdate, avatar, name, sex, city FROM {$this->_tableName} WHERE id={$id}";
            $res=$this->_db->sendQuery($sql);
            if($res->num_rows == 0){
                throw new HttpException("Not Found", 404);
            }
            $user = $res->fetch_assoc();
            foreach ($user as $key => $value){
                if(property_exists($this,$key)){
                    $this->$key=$user[$key];
                }
            }


            $this->regDate = $user['regdate'];


            $this->avatarPath = "/assets/img/avatars/".$user['avatar'];

        }else{
            throw new HttpException('Not Found', 404);
        }
    }

    public function updateInfo($id){
        $oldModel= new User($id);
        $sql = "UPDATE {$this->_tableName} SET ";
        $temp=false;
        if($this->email!=$oldModel->email){
            $sql.="email = '{$this->email}'";
            $temp=true;
        }
        if($this->sex!=$oldModel->sex){
            if($temp) $sql.=', ';
            $sql.="sex = '{$this->sex}'";
            $temp=true;
        }
        if($this->name!=$oldModel->name){
            if($temp) $sql.=', ';
            $sql.="name = '{$this->name}'";
            $temp=true;
        }
        if($this->city!=$oldModel->city){
            if($temp) $sql.=', ';
            $sql.="city = '{$this->city}'";
            $temp=true;
        }
        $sql.=" WHERE id=".$id;
        if($temp){
            $this->_db->sendQuery($sql);
        }
        return true;
    }

    public function updatePassword(){
        $passwordOld = $this->password;
        $sql="SELECT password FROM {$this->_tableName} WHERE login='{$this->login}'";
        $res = $this->_db->sendQuery($sql);
        if($res->num_rows === 0) {
            throw new \Exception("User with such login not found: ".$this->login);
        }

        $user=$res->fetch_assoc();
        $true_hash=$user['password'];
        if (password_verify($passwordOld, $true_hash)){
            $hash = password_hash($this->password_new,PASSWORD_DEFAULT);
            $sql = "UPDATE {$this->_tableName} SET password = '{$hash}' WHERE id = {$this->id}";
            $this->_db->sendQuery($sql);
            return true;
        }else{
            $this->_errors['login_error'] ='incorrect';
            return false;
        }
    }

    public function delete(){
        $sql = "DELETE FROM {$this->_tableName} WHERE id = {$this->id}";
        $this->_db->sendQuery($sql);
        return true;
    }


    public static function getAllUsers(){
        $sql = "SELECT * FROM user";
        $db=Db::getDb();
        $res=$db->sendQuery($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}