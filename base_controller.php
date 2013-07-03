<?php //-->

class Base_Controllers extends CI_Controller {
    protected $_meta        = array();
	protected $_head		= array();
    protected $_body        = array();
    protected $_title       = 'VMC - Control';
    protected $_class       = '';
    protected $_template    = NULL;
	protected $_message		= array();
	protected $_root		= NULL;
    protected $_fields		= array();
	protected $_error		= 'We have Encountered an error while saving the data. Please Try again';
	
    public function __construct() {
        parent::__construct();
        $this->load->add_package_path(APPPATH.'../third_party/');
		$this->_root = dirname(__FILE__).'/../../../';
		
    }
	
	protected function _loginCheck() {
		if(empty($this->session->userdata['user'])) {
			redirect(base_url() .'user/login');
		}
	}
	
    protected function _renderPage()
    {
		$this->load->model('user_model', 'user');
		
		$user = $this->user->get($this->session->userdata['user']['user_id']);
		
		if(empty($user)) {
			redirect('/user/login');
		}
		
		$this->_head = array('url' => $this->uri->segment(1),
				'user'	=> $user);
		
        $head   = $this->load->view('default/_header', $this->_head, true);
        $body   = $this->load->view($this->_template, $this->_body, true);
        $foot   = $this->load->view('default/_footer', array(), true);

        return $this->load->view('default/_page', array(
            'head'  => $head,
            'body'  => $body,
            'foot'  => $foot,
            'class' => $this->_class,
            'title' => $this->_title));
    }
	
	protected function _upload($file) {
		$path			= $this->_root.'upload';
		$max 			= 4000 * 1024;
		$fileExtension 	= pathinfo($file['name']);
		$name			= basename($file['name']);
		$extension 		= $fileExtension['extension'];
		$temp			= $file['tmp_name'];
		$file 			= $path.'/'.url_title($name).'.'.strtolower($extension);
		
		// move files to new directory
		move_uploaded_file($temp, $file);
		
		// check file if now move to new directory
		if(file_exists($file)) {
			return true;	
		} else {
			return false;
		}	 
	}
	
	/* Title: Model
	* Description: Load a specifice model. Instead of always using $this->load->model
	* Author: rewin & jhime
	* @param: varchar
	* @return: object
	*/
	protected function _model($model_name) {
		$this->load->model($model_name.'_model', $model_name);
		
		return $this->$model_name;
	}
	
	/* Title: View
	* Description: Load a specifice view. Instead of always using $this->load->view
	* Author: rewin & jhime
	* @param: varchar
	* @param: array
	* @param: boolean
	* @return: string
	*/
	protected function _view($view_name, $data = array(), $default = true) {
		return $this->load->view($view_name, $data, $default);
	}
	
}
