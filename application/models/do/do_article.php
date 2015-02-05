<?php

class Do_article extends CI_Model {

 	var $collection_name = 'Article';

    function __construct(){
    	parent::__construct();
    	$this->load->library('cimongo');
        $this->cimongo->switch_db('misc');
        $this->load->database();
	}

    #sql加入log操作日志
    // public function insert_log($refrence_id, $business, $data){

    //     $sql = " INSERT INTO `operation_log` (`id`, `refrence_id`, `business`, `create_time`, `data`) VALUES (NULL, '{$refrence_id}', '{$business}', CURRENT_TIMESTAMP, '{$data}') ";
    //     $query = $this->db->query($sql);
    //     return $query;
    // }

    #foradmin管理员获取所有
    function get_all_Info($page, $pagesize, $params = array()){

        $offset = ($page - 1) * $pagesize;

        $data = array();
        $data = $params;
        if($params['id']){
             unset($data['id']); 
             $id = new MongoId($params['id']);
             $data['_id'] = (object)$id;
        }
        
        return $this->cimongo->get_where($this->collection_name, $data, $pagesize, $offset)->result();
    }

    #foradmin管理员获取计数
    function get_Info_cnt($params){

        $data = array();
        $data = $params;
        if($params['id']){
             $data = $params;
             unset($data['id']); 
             $id = new MongoId($params['id']);
             $data['_id'] = (object)$id;
        }

        return $this->cimongo->where($params)->count_all_results($this->collection_name); 
    }

    #添加文章内容
    function add($data){
        $article = array(
            'title' => isset($data['title']) ? $data['title'] : '',
            'source' => isset($data['source']) ? $data['source'] : '',
            'authorName' => isset($data['authorName']) ? $data['authorName'] : '',
            'desc' => isset($data['desc']) ? $data['desc'] : '',
            'images' => isset($data['images']) ? $data['images'] : '',
            'publishTime' => isset($data['publishTime']) ? $data['publishTime'] : '',
            'content' => isset($data['content']) ? $data['content'] : ''
            // 'enabled' => true
        );
        
        $this->cimongo->insert($this->collection_name, $article);
        $json_data = json_encode($article, JSON_UNESCAPED_UNICODE);
        mysql_query("SET NAMES 'UTF8'");
        return true;
        // return  $this->insert_log('', 'add_article', $json_data);
    }

    #根据_id获取运营信息
    public function get_articleinfo_by_ids($ids){
        $data = array();
        if(! $ids){
            return array();
        }

        $id = new MongoId($ids);
        $re = $this->cimongo->where(array('_id'=>(object)$id))->get($this->collection_name)->result();

        $data['article_id'] = (string)($re['0']->_id);
        $data['title'] = $re['0']->title;
        $data['source'] = $re['0']->source;
        $data['publishtime'] = $re['0']->publishtime;
        $data['authorname'] = $re['0']->authorname;
        $data['desc'] = $re['0']->desc;
        $data['images'] = $re['0']->images;
        $data['content'] = $re['0']->content;

        return  $data;
    }


    #更新运营内容
    public function article_update($data){
        $article = array(
            'title' => isset($data['title']) ? $data['title'] : '',
            'source' => isset($data['source']) ? $data['source'] : '',
            'authorName' => isset($data['authorName']) ? $data['authorName'] : '',
            'desc' => isset($data['desc']) ? $data['desc'] : '',
            'images' => isset($data['images']) ? $data['images'] : '',
            'publishTime' => isset($data['publishTime']) ? $data['publishTime'] : '',
            'content' => isset($data['content']) ? $data['content'] : ''
            // 'enabled' => true
        );
       	$id = new MongoId($data['article_id']);
       	$this->cimongo->where(array('_id'=>(object)$id))->update($this->collection_name, $article);

       	$json_data = json_encode($article, JSON_UNESCAPED_UNICODE);
       	mysql_query("SET NAMES 'UTF8'");
        return true;
       	// return  $this->insert_log($data['article_id'], 'update_article', $json_data);
    }

}





