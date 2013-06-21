<?php //-->

$serverName = "localhost";
$connectionInfo = array( "Database"=>"test");

$sql = 'SELECT *
  FROM [test].[dbo].[user]';
 
 print '<pre>'; 
class Mssql {
	protected $_connection   = NULL;
	protected $_query		= NULL;
	
	public function __construct($serverInstance, $connectionInfo ) {
		$this->_connection = sqlsrv_connect($serverInstance, $connectionInfo);
		
		return $this->_connection;
	}
	
	public static function i($serverInstance, $connectionInfo) {
		$class = __CLASS__;
		
		return new $class($serverInstance, $connectionInfo);
	}
	
	public function query($query) {
		$this->_query = sqlsrv_query($this->_connection, $query);
		
		return $this;	
	}
	
	public function getResult() {
		$result = array();
		
		while($rows = sqlsrv_fetch_array($this->_query, SQLSRV_FETCH_ASSOC)) {
			$result[] = $rows;
		}
		
		return $result;	
	}
	
}

print_r(Mssql::i($serverName, $connectionInfo)->query($sql)->getResult());
