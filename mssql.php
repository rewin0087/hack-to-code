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


// sql function freetds

function sql($sql)
{
	try {
		$db = new PDO('odbc:Driver=FreeTDS; Server=192.168.1.36; Port=1433; Database=test; UID=sa; PWD=developer;');
	} catch(PDOException $exception) {
		die("Unable to open database.Error message:$exception.");
	}

	$statement = $db->prepare($sql);
	$statement->execute();

	/* Fetch all of the remaining rows in the result set */
	print("Fetch all of the remaining rows in the result set:\n");
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	return $result;
}

sql("SELECT CAST([user_id] AS BIGINT) AS [user_id], 
			CAST([user_name] AS VARCHAR) AS [user_name], CAST([user_email] AS VARCHAR) AS [user_email] 
		FROM [test].[dbo].[user]");