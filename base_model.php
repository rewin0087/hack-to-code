<?php //-->

class Base_Model extends CI_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_table		= NULL;
	protected $_key			= NULL;
	protected $_data		= array();
	protected $_filters		= array();
	
	/* Private Properties
	-------------------------------*/
	 /* Magic
    -------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/* Public Methods
	-------------------------------*/
	
	/*
	* Title: Save data to database
	* Description: Store new data into database base on table name and table fields with data
	* Author : rewin
	* return object
	*/
	public function save() {
		return $this->db
			->insert($this->_table, $this->_data);
	}
	
	
	/*
	* Title: Save data to database
	* Description: Store new data into database base on table name and table fields with data
	* Author : rewin
	* return object
	*/
	public function remove() {
		return $this->db
			->delete($this->_table, $this->_filters);
	}
	
	
	/*
	* Title: Update data to database
	* Description: Store new data into database base on table name and table fields with data
	* Author : rewin
	* return object
	*/
	public function update() {
		return $this->db
			->where($this->_filters)
			->update($this->_table, $this->_data);
	}
	
	/*
	* Title: Set Filters
	* Description: Set Filters for next proccess maybe update or something
	* Author : rewin
	* return object
	*/
	public function filters($array) {
		$this->_filters = $array;
		
		return $this;
	}
	
	/*
	* Title: Set Table name
	* Description: Set Table name
	* Author : rewin
	* @param string
	* return array
	*/
	public function setTable($table) {
		$this->_table = $table;
		
		return $this;
	}
	
	/*
	* Title: Set Fields with value
	* Description: Set Fields with value
	* Author : rewin
	* @param string
	* @param string
	* return object
	*/
	public function set($index, $value) {
		$this->_data[$index] = $value;
		
		return $this;
	}
	
	/*
	* Title: Get One Data from specific table
	* Description: 
	* Author : rewin
	* @param bigint
	* return array
	*/
	public function get($id) {
		return $this->db
			->select('*')
			->from($this->_table)
			->where($this->_key, $id)
			->get()
			->row_array();
	}
	
	/*
	* Title: Get All Data 
	* Description: Get All data
	* Author : rewin
	* @param varchar
	* return array
	*/
	public function returnAll($pagination = 0, $start = NULL, $range = NULL) {
		$rows = array();
		$this->db->start_cache();
			$query = $this->db
				->select('*')
				->from($this->_table);
		$this->db->stop_cache();
		
		if($pagination) {
			$query->count_all_results();
			$rows = $query
				->limit($range, $start)
				->get()
				->result_array();					
		} else {
			$rows = $query
				->get()
				->result_array();
		}
		
		$this->db->flush_cache();
			
		return !empty($rows) ? $rows : array();	
	}
	
}