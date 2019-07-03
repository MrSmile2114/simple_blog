<?php


namespace models;


use base\BaseForm;
use library\Auth;
use library\Db;
use library\HttpException;

class Comment extends BaseForm{
    public $id;
    public $author;
    public $postId;
    public $pubDate;
    public $content;

    protected $_tableName = 'comment';

    /**
     * Must return an array, the keys must be the names of the fields,
     * the values are the arrays of the necessary rules .
     * @return array
     */
    public function getRules(){
       return [
           'content' => ['requiredFill', 'trim', 'htmlSpecialChars'] ,
           'postId' =>  []
       ];
    }

    /**
     * @param $id
     * @throws HttpException
     * @return Comment
     */
    public static function __constructFromId($id){
        $self = new self();
        if ($id!=null){
            $sql= "SELECT comment.id, comment.content, comment.post_id, comment.pubdate, comment.author_id, user.avatar, user.login as author_name FROM user, comment WHERE comment.author_id = user.id and comment.id = {$id}";
            $result=$self->_db->sendQuery($sql);
            if($result->num_rows == 0){
                throw new HttpException('Not Found', 404);
            }
            $comment = $result->fetch_assoc();
            //todo: implements as fetch_object()
            $self->id=$comment['id'];
            $self->content=$comment['content'];
            $self->author=[
                'name' =>  htmlspecialchars($comment['author_name']),
                'id' => $comment['author_id'],
                'avatar' => $comment['avatar'],
            ];
            $self->pubDate=$comment['pubdate'];
            $self->postId=$comment['post_id'];
        }
        return $self;
    }

    public function create(){
        $id = Auth::getId();
        $sql = "INSERT INTO `{$this->_tableName}` (`post_id`, `author_id`, `content`) VALUES ('{$this->postId}', {$id}, '{$this->content}')";
        $this->_db->sendQuery($sql);
        $this->id = $this->_db->getLastInsertId();
        return true;
    }

    public function update(){
        $sql = "UPDATE {$this->_tableName} SET post_id = '{$this->postId}', author_id = '{$this->author['id']}', content = '{$this->content}' WHERE id = {$this->id}";
        $this->_db->sendQuery($sql);
        return true;
    }

    public function delete(){
        $sql = "DELETE FROM {$this->_tableName} WHERE id = {$this->id}";
        $this->_db->sendQuery($sql);
        return true;
    }

    public function markup(){
        if((\library\Auth::getId()==$this->author['id']) or \library\Auth::canAccess('admin')){
            return
                "<div class=\"media mt-4\" id=\"comment_".$this->id."\">
           
                <a href='/user/view/".$this->author['id']."'>
                    <img class=\"d-flex mr-3 rounded-circle img-fluid\" src=\"/assets/img/avatars/".$this->author['avatar']."\" alt=\"\" height='100' width='100'>
                </a>
        
            <div class=\"media-body overflow-auto\">
                <div class=\"row m-md-1\">
                    <h5 class=\"mt-0 col\">".$this->author['name']."</h5>
                    <div class=\"col-auto\">
                        <button class=\"btn btn-dark\" onclick=\"editComment(".$this->id.")\" id=\"editBtn_".$this->id."\">Редактировать</button>
                        <button class=\"btn btn-danger col-auto\" onclick=\"delComment(".$this->id.")\" id=\"delBtn_".$this->id."\">Удалить</a>
                    </div>
                </div>
                <div id='content_".$this->id."'>
                ".$this->content."
                </div>  
                </div>
            </div>";
        }else{
            return
                "<div class=\"media mt-4\" id=\"comment_".$this->id."\">
                    <a href='/user/view/".$this->author['id']."'>
                        <img class=\"d-flex mr-3 rounded-circle img-fluid\" src=\"/assets/img/avatars/".$this->author['avatar']."\" alt=\"\" height='100' width='100'>
                    </a>
                    <div class=\"media-body overflow-auto\">
                            <h5 class=\"mt-0\">".$this->author['name']."</h5>
                           <div id='content_".$this->id."'>
                            ".$this->content."
                            </div>
                    </div>
                </div>";
        }
    }

    public static function getAllComments($postId){
        $models = [];
        if(!is_numeric($postId)){
            return false;
        }
        $sql="SELECT comment.id, comment.content, comment.pubdate, comment.author_id, user.avatar, user.login as author_name FROM user, comment WHERE comment.author_id = user.id and comment.post_id = {$postId}";
        $db=Db::getDb();
        $res=$db->sendQuery($sql);
        if($res->num_rows == 0){
            return false;
        }
        $comments=$res->fetch_all(MYSQLI_ASSOC);
        foreach ($comments as $comment){
            $data=[
                'id' => $comment['id'],
                'postId' => $postId,
                'pubDate' => $comment['pubdate'],
                'content' => $comment['content']
            ];
            $model = new Comment();
            //cannot use load() due to the possibility of double shielding
            foreach ($data as $key => $value){
                $model->$key=$value;
            }
            $model->author['name']=$comment['author_name'];
            $model->author['id']=$comment['author_id'];
            $model->author['avatar']=$comment['avatar'];
            $models [] = $model;
        }
        return $models;
    }
}