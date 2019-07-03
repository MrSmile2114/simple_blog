<?php


namespace models;


use base\BaseForm;
use library\Auth;
use library\Db;
use library\HttpException;

class Category extends BaseForm {
    public $id;
    public $title;
    public $style;
    public $parentId;

    protected $_tableName = 'category';


    public function __construct($id){
        parent::__construct();
        if ($id != null) {
            $sql = "SELECT id, parent_id, title, badge_style FROM {$this->_tableName} WHERE id = {$id}";
            $result = $this->_db->sendQuery($sql);
            if ($result->num_rows == 0) {
                throw new HttpException('Not Found', 404);
            }
            $category = $result->fetch_assoc();
            //todo: implements as fetch_object()
            $this->id = $category['id'];
            $this->title = htmlspecialchars(strip_tags($category['title']));
            $this->style = $category['badge_style'];
            $this->parentId = $category['parent_id'];

        }
    }

    /**
     * Must return an array, the keys must be the names of the fields,
     * the values are the arrays of the necessary rules .
     * @return array
     */
    public function getRules(){
        return [
            'title' =>      ['requiredFill', 'trim', 'htmlSpecialChars', 'unique', 'stripTags'],
            'style' =>      ['requiredFill', 'trim', 'htmlSpecialChars'],
            'parentId' =>   []
        ];
    }

    public function create(){
        $id = Auth::getId();
        if(empty($this->parentId)){
            $this->parentId=1;
        }
        $sql = "INSERT INTO `{$this->_tableName}` (`title`, `parent_id`, `badge_style`) VALUES ('{$this->title}', {$this->parentId}, '{$this->style}')";
        $this->_db->sendQuery($sql);
        $this->id = $this->_db->getLastInsertId();
        return true;
    }

    public function update(){
        $current_id = Auth::getId();
        $sql = "UPDATE {$this->_tableName} SET title = '{$this->title}', badge_style = '{$this->style}', parent_id = {$this->parentId} WHERE id = {$this->id}";
        $this->_db->sendQuery($sql);
        return true;
    }

    public function delete(){
        $sql = "DELETE FROM {$this->_tableName} WHERE id = {$this->id}";
        $this->_db->sendQuery($sql);
        return true;
    }


    public static function getAllCategories(){
        $sql = "SELECT * FROM category";
        $db=Db::getDb();
        $res=$db->sendQuery($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}