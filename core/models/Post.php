<?php


namespace models;


use base\BaseForm;
use library\Auth;
use library\HttpException;

class Post extends BaseForm {
    public $id;
    public $title;
    public $content;
    public $author;
    public $pubDate;

    public $categoryName;
    public $categoryStyle;
    public $categoryId;

    public $comments = [];

    protected $_tableName='post';

    /**
     * Post constructor.
     *
     * @param $id
     * @throws HttpException
     */
    public function __construct($id){
        parent::__construct();
        /*
         * as I understand it, php with the existence of ANY constructor ignores the implicit constructor of the parent.
         * ¯\_(ツ)_/¯ so with Post() this constructor will be called, not the parent constructor.
         * Therefore, it is necessary to check the existence of the argument.
         */
        if (($id!=null) and is_numeric($id)){
            $sql= "SELECT post.id, post.title, post.content, post.pubdate, user.id as author_id, user.login as author_name, category.id as category_id, category.title as category_name, category.badge_style FROM post, user, category WHERE post.author_id = user.id and post.category_id = category.id and post.id = {$id}";
            $result=$this->_db->sendQuery($sql);
            if($result->num_rows == 0){
                throw new HttpException('Not Found', 404);
            }
            $post = $result->fetch_assoc();
            //todo: implements as fetch_object()
            $this->id=$post['id'];
            $this->title=htmlspecialchars(strip_tags($post['title']));
            $this->content=$post['content'];
            $this->author=[
                'name' =>  htmlspecialchars($post['author_name']),
                'id' => $post['author_id']];
            $this->pubDate=$post['pubdate'];
            $this->categoryName=$post['category_name'];
            $this->categoryId=$post['category_id'];
            $this->categoryStyle=$post['badge_style'];

            $this->comments=Comment::getAllComments($id);
        }
    }



    /**
     * Must return an array, the keys must be the names of the fields,
     * the values are the arrays of the necessary rules .
     * @return array
     */
    public function getRules(){
        return [
            'title' => ['requiredFill', 'trim', 'htmlSpecialChars', 'len100'],
            'content' => ['requiredFill', 'trim', 'htmlSpecialChars']
        ];
    }

    public function create(){
        $id = Auth::getId();
        $sql = "INSERT INTO `{$this->_tableName}` (`title`, `content`, `author_id`, `category_id`) VALUES ('{$this->title}', '{$this->content}', {$id}, {$this->categoryId})";
        $this->_db->sendQuery($sql);
        $this->id = $this->_db->getLastInsertId();
        return true;
    }

    public function update(){
        $current_id = Auth::getId();
        $sql = "UPDATE {$this->_tableName} SET title = '{$this->title}', content = '{$this->content}', category_id = {$this->categoryId} WHERE id = {$this->id}";
        $this->_db->sendQuery($sql);
        return true;
    }

    public function delete(){
        $sql = "DELETE FROM {$this->_tableName} WHERE id = {$this->id}";
        $this->_db->sendQuery($sql);
        return true;
    }

}