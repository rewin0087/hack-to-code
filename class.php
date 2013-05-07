<?php //-->

class User {
	
	protected $_name 	= NULL;
	protected $_email	= NULL;
	protected $_age		= 0;
	protected $_data	= array();
	
	public static function i() {
		return new User();	
	}
	
	public static function output($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';	
	}
		
	public function setName($name) {
		$this->_name = $name;
		
		return $this;	
	}
	
	public function setEmail($email) {
		$this->_setEmail($email);
		
		return $this;	
	}
	
	public function setAge($age) {
		$this->_setAge($age);	
		
		return $this;
	}
	
	public function getName() {
		return $this->_name;	
	}
	
	public function getAge() {
		return $this->_age;	
	}
	
	public function getEmail() {
		return $this->_email;	
	}
	
	public function getUser() {
		return $this->_getUser();	
	}
	
	
	protected function _getUser() {
		$this->_data['name'] 	= $this->_name;
		$this->_data['email']	= $this->_email;
		$this->_data['age']		= $this->_age;
		
		return $this->_data;
	}
	protected function _setEmail($email) {
		$this->_email = $email;
		
		return $this;	
	}
	
	private function _setAge($age) {
		$this->_age = $age;
		
		return $this;	
	}
	
	protected function _setName($name) {
		$this->_name = $name;	
		
		return $this;
	}
	
}

class Me extends User {
	
	public 	$username = NULL;
	protected $_phone = NULL;
	protected $_me	  = array();
	
	public static function i() {
		return new Me();	
	}	
	
	public function setEmail($email) {
		return $this->_setEmail($email);	
	}
	
	public function setPhoneNumber($phone) {
		return $this->_setPhoneNumber($phone);
	}
	
	public function setUsername($username) {
		$this->username = $username;
		
		return $this;	
	}
	
	public function getMe() {
		return $this->_getMe();	
	}
	
	protected function _getMe() {
		$this->_me 				= $this->_getUser();
		$this->_me['username'] 	= $this->username;
		$this->_me['phone']		= $this->_phone;
		
		return $this->_me;	
	}
	
	private function _setPhoneNumber($phone) {
		$this->_phone = $phone;
		
		return $this;		
	}
}

$user = new User();
//echo $user->setName('erwin')->getName();
//User::output(User::i()->setAge(20)->getAge());
//User::output(User::i()->setName('erwin seribo')->getName());
//User::output(User::i()->setName('erwin seribo')->setAge(22)->setEmail('erwin_rulezzz87@yahoo.com')->getUser());
//User::output(Me::i()->setEmail('erwin_rulezzz87@yahoo.com')->getEmail());
//User::output(Me::i()->setUsername('rewin0087')->username);
//User::output(Me::i()->setUsername('rewin0087')->setPhoneNumber('4444-333')->setAge(22)->setName('erwin')->getMe());
//User::output(Me::i()->setUsername('rewin0087')->setPhoneNumber('4444-333')->setAge(22)->setName('erwin')->getUser());


