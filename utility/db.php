<?php
	$sysConn = null;
	$sysConnDebug = false;

	$db_connection = null;

	$db_host		= SYS_DBHOST;
	$db_port		= SYS_DBPORT;
	$db_name		= SYS_DBNAME;
	$db_username	= SYS_DBACCOUNT;
	$db_password	= SYS_DBPASSWD;
	$db_option		= null;

	if( SYS_DBTYPE == "mysql" )
	{
		$db_connection = "mysql:host={$db_host};port={$db_port};dbname={$db_name}";
		$db_option = array(
		    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		);
	}
	else if( SYS_DBTYPE == "mssql" )
	{
		$db_connection = "sqlsrv:Server={$db_host},{$db_port};Database={$db_name}";
	}
	else if( SYS_DBTYPE == "oci8" )
	{
		$db_connection = "oci:dbname=//{$db_host}:{$db_port}/{$db_name}";
	}

	try {
		if( empty( $db_option ) )
		{
			$sysConn = new PDO($db_connection, $db_username, $db_password);
		}
		else
		{
			$sysConn = new PDO($db_connection, $db_username, $db_password, $db_option);
		}
	} catch( PDOException $e ) {
		echo  "Database connect fail: " . ( $e -> getMessage() );
	}

	$sysConn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	function _initExec()
	{
		global $sysConn;

		if( SYS_DBTYPE == "mysql" )
		{
			$sql = "SET NAMES utf8";
			$sysConn->exec($sql);
			debugOutput($sql, $sysConn, true);
		}
		else if( SYS_DBTYPE == "mssql" )
		{

		}
		else if( SYS_DBTYPE == "oci8" )
		{

		}
	}

	function _pdoStatement( $sql, $fetchMode )
	{
		global $sysConn;

		_initExec();
		try
		{
			$rs = $sysConn->query($sql);
			debugOutput($sql, $sysConn, $rs);
			$rs->setFetchMode($fetchMode);
		}
		catch( PDOException $e )
		{
			debugOutputException($sql, $e);
			return false;
		}

		return $rs;
	}

	function _insertUpdatePrepare( $queryType, $table, $arrField, $whereClause='' )
	{
		global $sysConn;


		if( empty($arrField) )
		{
			return false;
		}

		$sql = null;

		$array_table_column = array_keys($arrField);
		$array_column_value	= array();

		$stmt = null;
		if( $queryType == "INSERT" )
		{
			$column	= $array_table_column[0];
			$value	= "?";

			for( $i = 0; $i < count($array_table_column); $i++ )
			{
				$array_column_value[$i] = $arrField[$array_table_column[$i]];

				if( $i != 0 )
				{
					$column	.= "," . $array_table_column[$i];
					$value	.= ", ?";
				}
			}
			_initExec();
			$sql = "INSERT INTO {$table} ({$column}) VALUES ({$value})";
			$stmt = $sysConn->prepare($sql);
		}
		else if( $queryType == "UPDATE" )
		{
			$set = $array_table_column[0] . "=?";

			for( $i = 0; $i < count($array_table_column); $i++ )
			{
				$array_column_value[$i] = $arrField[$array_table_column[$i]];
				if( $i != 0 )
				{
					$set .= ", " . $array_table_column[$i] . "=?";
				}
			}
			_initExec();
			$sql = "UPDATE {$table} SET {$set} WHERE {$whereClause}";
			$stmt = $sysConn->prepare($sql);
		}

		try
		{
			$result =  $stmt->execute($array_column_value);
			debugOutput($sql, $stmt, $result, true, $array_column_value);
		}
		catch(PDOException $e)
		{
			debugOutputException($sql, $e, true, $array_column_value);
			return false;
		}

		return $result;
	}

	function dbGetOne( $sql, $fetchMode=PDO::FETCH_NUM )
	{
		$sql = $sql . " LIMIT 1";
		$rs = _pdoStatement($sql, $fetchMode);

		if( !$rs )
		{
			return false;
		}

		return $rs->fetchColumn();
	}

	function dbGetCol( $sql, $fetchMode=PDO::FETCH_NUM )
	{
		$rs = _pdoStatement($sql, $fetchMode);

		if( !$rs )
		{
			return false;
		}

		return $rs->fetchAll(PDO::FETCH_COLUMN, 0);
	}

	function dbGetRow( $sql, $fetchMode=PDO::FETCH_ASSOC )
	{
		$rs = _pdoStatement($sql, $fetchMode);

		if( !$rs )
		{
			return false;
		}

		return $rs->fetch($fetchMode);
	}

	function dbGetAll( $sql, $fetchMode=PDO::FETCH_ASSOC )
	{
		$rs = _pdoStatement($sql, $fetchMode);
		return $rs->fetchAll();
	}

	function dbSelectLimit( $sql, $count=10, $start=0, $fetchMode=PDO::FETCH_ASSOC )
	{
		$rs = _pdoStatement($sql, $fetchMode);
		$data = $rs->fetchAll();
		$data_limit = array();
		for( $i = $start, $j = 0; $i < $start + $count; $i++, $j++ )
		{
			$data_limit[$j] = $data[$i];
		}
		return $data_limit;
	}

	function dbInsert( $table, $arrField )
	{
		return _insertUpdatePrepare("INSERT", $table, $arrField);
	}

	function dbUpdate( $table, $arrField, $whereClause )
	{
		return _insertUpdatePrepare("UPDATE", $table, $arrField, $whereClause);
	}

	function dbDelete( $table, $whereClause )
	{
		$sql['delete'] = array(
			'mysql'	=>	"DELETE FROM {$table} WHERE {$whereClause}",
			'mssql'	=>	"DELETE FROM {$table} WHERE {$whereClause}",
			'oci8'	=>	"DELETE FROM {$table} WHERE {$whereClause}"
		);

		return dbExecute($sql['delete'][SYS_DBTYPE]);
	}

	// for insert, update with affected row number count
	function dbExecute( $sql )
	{
		global $sysConn;

		_initExec();
		$result = false;
		try
		{
			$affectedRow = $sysConn->exec($sql);
			if( !$affectedRow )
			{
				$result = false;
			}
			else if( $affectedRow > 0 )
			{
				$result = true;
			}
			else {
				$result = false;
			}
			debugOutput($sql, $sysConn, $result);
		}
		catch(PDOException $e)
		{
			debugOutputException($sql, $e);
			return false;
		}

		return $result;
	}

	// for select with pdo statement class(result set)
	function dbQuery( $sql, $fetchMode=PDO::FETCH_ASSOC )
	{
		return _pdoStatement($sql, $fetchMode);
	}

	function debugOutput( $sql, $pdoExecObj, $isExecSqlCorrect, $isAffectedRowStmt=false, $stmtArrayValue=array() )
	{
		global $sysConnDebug;
		if( $sysConnDebug )
		{
			echo "<hr>";
			echo "(" . SYS_DBTYPE . "): {$sql}";
			if( $isAffectedRowStmt )
			{
				for( $i = 0; $i < count( $stmtArrayValue ); $i++ )
				{
					echo "value[$i]: " . $stmtArrayValue[$i] . "<br />";
				}
			}
			if( !$isExecSqlCorrect )
			{
				$errorInfo = $pdoExecObj->errorInfo();
				echo "<br />";
				echo "<pre>";
				echo "<b>SQLSTATE error code:</b> " . $errorInfo[0];
				echo "<br />";
				echo "<b>" . SYS_DBTYPE . " error code:</b> " . $errorInfo[1];
				echo "<br />";
				echo "<b>Error message:</b> " . $errorInfo[2];
				echo "</pre>";
			}
			echo "<hr>";
		}
	}

	function debugOutputException( $sql, $exceptionObj, $isAffectedRowStmt=false, $stmtArrayValue=array() )
	{
		global $sysConnDebug;
		if( $sysConnDebug )
		{
			echo "<hr>";
			echo "(" . SYS_DBTYPE . "): {$sql}";
			echo "<br />";
			if( $isAffectedRowStmt )
			{
				for( $i = 0; $i < count( $stmtArrayValue ); $i++ )
				{
					echo "value[$i]: " . $stmtArrayValue[$i] . "<br />";
				}
			}
			echo "<pre>";
			echo $exceptionObj->getMessage();
			echo "</pre>";
			echo "<hr>";
		}
	}
?>
