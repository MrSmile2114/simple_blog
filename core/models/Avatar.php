<?php


namespace models;


use base\BaseModel;
use library\Auth;

class Avatar extends BaseModel{
    /**
     * @var User
     */
    public $userModel;

    static $limitBytes  = 1024 * 1024 * 5;
    static $limitWidth  = 512;
    static $limitHeight = 512;

    static $errorCodeMessages = [
        UPLOAD_ERR_INI_SIZE     => 'Размер файла превысил значение 5 Мбайт.',
        UPLOAD_ERR_FORM_SIZE    => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
        UPLOAD_ERR_PARTIAL      => 'Загружаемый файл был получен только частично.',
        UPLOAD_ERR_NO_FILE      => 'Файл не был загружен.',
        UPLOAD_ERR_NO_TMP_DIR   => 'Отсутствует временная папка.',
        UPLOAD_ERR_CANT_WRITE   => 'Не удалось записать файл на диск.',
        UPLOAD_ERR_EXTENSION    => 'PHP-расширение остановило загрузку файла.',
    ];
    static $errorMessages =[
        'unknown'       => 'При загрузке файла произошла неизвестная ошибка.',
        'not_image'     => 'Можно загружать только изображения.',
        'wrong_width'   => 'Ширина изображения не должна превышать 512 точек.',
        'wrong_height'  => 'Высота изображения не должна превышать 512 точек.',
        'wrong_size'    => 'Размер изображения не должен превышать 5 Мбайт.',
        'write_error'   => 'Ошибка при записи файла на диск'
    ];

    /**
     * Avatar constructor.
     * @param $userModel User
     */
    public function __construct($userModel){
        parent::__construct();
        $this->userModel=$userModel;
    }

    public function set(){
        $filePath = $_FILES['upload']['tmp_name'];
        $errorCode = $_FILES['upload']['error'];

        //Checking successful download:
        if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {
            $outputMessage = isset($errorMessages[$errorCode]) ? Avatar::$errorCodeMessages[$errorCode] : Avatar::$errorMessages['unknown'];
            $this->_errors [] = $outputMessage;
            return false;
        }

        //File Type Check:
        $fi = finfo_open(FILEINFO_MIME_TYPE);
        $mime = (string) finfo_file($fi, $filePath);
            // Check the keyword image (image/jpeg, image/png, etc.):
        if (strpos($mime, 'image') === false) {
            $this->_errors [] = Avatar::$errorMessages['not_image'];
            return false;
        }

        //Check image parameters:
        $image = getimagesize($filePath);
        if (filesize($filePath) > Avatar::$limitBytes)  $this->_errors [] = Avatar::$errorMessages['wrong_size'];
        if ($image[1] > Avatar::$limitHeight)           $this->_errors [] = Avatar::$errorMessages['wrong_height'];
        if ($image[0] > Avatar::$limitWidth)            $this->_errors [] = Avatar::$errorMessages['wrong_width'];
        if(!empty($this->_errors)){
            return false;
        }

        $name = md5_file($filePath);//prevent sql injections

        $extension = image_type_to_extension($image[2]);
        $format = str_replace('jpeg', 'jpg', $extension);

        if($this->userModel->avatarPath != "/assets/img/avatars/unknown.png"){
            if(!unlink(__DIR__.'/../../'.$this->userModel->avatarPath)){
                $this->_errors [] = Avatar::$errorMessages['write_error'];
                return false;
            }
        }

        $fileName=$name.$format;
        $newPath='/assets/img/avatars/'.$fileName;
        $newPathFile=__DIR__.'/../../'.$newPath;

        if (!move_uploaded_file($filePath, $newPathFile)) {
            $this->_errors [] = Avatar::$errorMessages['write_error'];
            return false;
        }

        $sql="UPDATE user SET avatar='{$fileName}' WHERE id={$this->userModel->id}";
        $this->_db->sendQuery($sql);

        $this->userModel->avatarPath=$newPath;
        Auth::setAvatar($fileName);
        return true;
    }


    public function delete(){
        if($this->userModel->avatarPath!="/assets/img/avatars/unknown.png"){
            if(unlink(__DIR__.'/../../'.$this->userModel->avatarPath)){
                $sql="UPDATE user SET avatar='unknown.png' WHERE id={$this->userModel->id}";
                $this->_db->sendQuery($sql);
                Auth::setAvatar('unknown.png');
                return true;
            }
        }
        return false;
    }
}