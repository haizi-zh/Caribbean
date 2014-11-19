<?php

class basemodel extends CI_Model {
	/**
	 * construct
	 */
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	/**
	 * 新增数据
	 * @table 表名
	 * @date 数据
	 */
	function add($table, $data) {
		$this->db->insert ( $table, $data );
		return $this->db->insert_id ();
	}
	/**
	 * 删除表信息
	 * @table 表名
	 * @where 条件
	 */
	function del($table, $where = 'id >0') {
		$this->db->where ( $where );
		return $this->db->delete ( $table );
	}
	/**
	 * 修改信息
	 * @table 表名
	 * @date 数据
	 * @where 条件
	 */
	function updates($table, $where = 'id >0', $data) {
		return $this->db->update ( $table, $data, $where );
	}
	
	/**
	 * 获得一条信息
	 * @table 表名
	 * @select 查询字段
	 * @where 条件
	 */
	function getone($table, $where = 'id >0', $select = '*') {
		$row = array ();
		$query = $this->db->select ( $select )->get_where ( $table, $where, 1, 0 );
		if ($query->num_rows () > 0) {
			$row = $query->row_array ();
		}
		return $row;
	}
	
	/**
	 * 得到多条信息 默认降序
	 * @table 表名
	 * @where 条件
	 * @select 查询字段
	 * @offset 从第几条开始查询
	 * @size 查询多少条
	 * @orderby 排序
	 */
	function getall($table, $where = 'id > 0', $select = '*', $offset = '0', $size = '15', $orderby = 'id DESC') {
		$res = array ();
		$query = $this->db->select ( $select )->order_by ( $orderby )->get_where ( $table, $where, $size, $offset );
		if ($query->num_rows () > 0) {
			$res = $query->result_array ();
		}
		return $res;
	}
	
	/**
	 * 允许where条件按照字符串查询
	 * @param string $table
	 * @param string $where
	 * @param string $select
	 * @param string $orderby
	 * @param string $limit
	 * @param string $offset
	 * @return array 查询结构
	 */
	public function getmore($table, $where = '`id` > 0', $select = '*', $orderby = '`id` DESC', $limit = 0, $offset = 15) {
		$rows = array ();
		$this->db->select ( $select );
		$this->db->order_by ( $orderby );
		$this->db->where ( $where, NULL, FALSE );
		if (! empty ( $limit )) {
			$query = $this->db->get ( $table, $limit, $offset );
		} else {
			$query = $this->db->get ( $table);
		}
		
		foreach ( $query->result_array () as $row ) {
			$rows [] = $row;
		}
		return $rows;
	}
	
	/**
	 * 统计数量(总页数、总条数)
	 * @table 表名
	 * @where 条件
	 * @size 查询多少条
	 * @param string $orderby
	 */
	function counts($table, $where, $size = 15, $orderby = '`id` DESC') {
		$this->db->order_by ( $orderby );
		$this->db->where ( $where, NULL, FALSE );
		$count = $this->db->from ( $table )->count_all_results ();
		$data = array (
				'allcount' => $count,
				'pagecount' => ceil ( $count / $size ) 
		);
		return $data;
	}
	
	/**
	 * 统计数量(总条数)
	 * @table 表名
	 * @where 条件
	 */
	function con($table, $where) {
		$count = $this->db->from ( $table )->where ( $where )->count_all_results ();
		return $count;
	}
	
	/**
	 * sql统计信息数量
	 * @sql 执行的sql
	 * @size 查询多少条
	 */
	function countsql($sql = '', $size = 15) {
		$count = $this->db->query ( $sql )->num_rows ();
		$data = array (
				'allcount' => $count,
				'pagecount' => ceil ( $count / $size ) 
		);
		return $data;
	}
	
	/**
	 * 只执行SQL语句
	 */
	function get_query($sql) {
		$query = $this->db->query ( $sql );
		return $query;
	}
	
	/**
	 * 执行SQL语句返回结果
	 */
	function getquery($sql) {
		$query = $this->db->query ( $sql );
		$res = array ();
		if ($query->num_rows () > 0) {
			$res = $query->result_array ();
		}
		return $res;
	}

}
