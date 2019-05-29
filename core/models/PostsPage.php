<?php


namespace models;


use base\BaseModel;
use library\HttpException;

class PostsPage extends BaseModel {
    public $nextPageLink;
    public $prevPageLink;
    public $currentPage;
    public $postsData = [];
    public $postsTitle;

    static $contentCharCount = 300;


    public function __construct($pageNumb, $countPostsOnPage, $searchData){
        parent::__construct();
        if((is_null($pageNumb)) or (!is_numeric($pageNumb))){
            $pageNumb=1;
        }

        $searchSql='';//getting additions to sql query if search is needed
        if((!is_null($searchData)) and (!empty($searchData))){
            $searchSqlMethod='search_'.$searchData['type'];
            if (method_exists($this, $searchSqlMethod)){
                $searchSql=$this->$searchSqlMethod($searchData['value']);
            }else{
                $searchSql=$this->search_all($searchData['value']);
            }
        }

        $this->prevPageLink=$this->buildPrevLink($searchData,$pageNumb);
        $this->nextPageLink=$this->buildNextLink($searchData,$pageNumb);


        $start_row = ($pageNumb-1)*$countPostsOnPage;
        $count=$countPostsOnPage+1;//11 record - shows if there are records on the next "page"
        $sql="SELECT post.id, post.title, post.content, post.pubdate, user.id as author_id, user.login as author_name, category.id as category_id, category.title as category_name, category.badge_style FROM post, user, category WHERE post.author_id = user.id and post.category_id = category.id {$searchSql} ORDER BY `post`.`pubdate` DESC LIMIT {$start_row},{$count}";
        $result=$this->_db->sendQuery($sql);
        if($result->num_rows == 0){
            //todo
            //throw new HttpException('Not Found', 404);
        }

        if (!($result->num_rows == $countPostsOnPage+1)) {
            $this->nextPageLink = null;
        }


        $posts=$result->fetch_all(MYSQLI_ASSOC);
        foreach ($posts as $post_num => $post){
            if($post_num < $countPostsOnPage){ //display only the required number of posts
                foreach ($post as $field => $value){
                    //call the method to process the data if required:
                    $methodName='process_'.$field;
                    if(method_exists($this, $methodName)){
                        $this->postsData[$post_num][$field] = $this->$methodName($value);
                    }else{
                        $this->postsData[$post_num][$field] = $value;
                    }

                }
            }
        }
        $this->currentPage=$pageNumb;
        //var_dump($this->postsData);

    }

    protected function search_all($data){
        $data=$this->_db->getSafeData($data);
        return "AND ( post.title LIKE '%{$data}%' OR post.content LIKE '%{$data}%' )";
    }

    protected function search_title($data){
        $data=$this->_db->getSafeData($data);
        return "AND post.title LIKE '%{$data}%'";
    }

    protected function search_category($data){
        $data=$this->_db->getSafeData($data);
        return "AND category.title LIKE '{$data}'";
    }


    protected function process_title($data){
        $data=$this->_db->getSafeData($data);
        return strip_tags($data);
    }

    protected function process_content($data){
        $rawData=(strip_tags($data));
        if(strlen($rawData)>=PostsPage::$contentCharCount){
            $res=mb_strimwidth($rawData,0, (PostsPage::$contentCharCount));
            $res.='...';
        }else{
            $res=$rawData;
        }

        return $res;
    }



    protected function buildNextLink($searchData, $pageNumb){
        if(is_null($searchData) or empty($searchData)){
            $nextPageLink="/posts/?page=".($pageNumb+1);
        }else{
            $nextPageLink="/posts/search/?q=".$searchData['value']."&type=".$searchData['type']."&page=".($pageNumb+1);
        }
        return $nextPageLink;
    }

    protected function buildPrevLink($searchData, $pageNumb){
        if($pageNumb==1){
            return null;
        }
        if(is_null($searchData) or empty($searchData)){
            $prevPageLink="/posts/?page=".($pageNumb-1);
        }else{
            $prevPageLink="/posts/search/?q=".$searchData['value']."&type=".$searchData['type']."&page=".($pageNumb-1);
        }
        return $prevPageLink;
    }

}