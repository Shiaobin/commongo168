<?php
function selectAll_no_where($connect,$column,$table,$order_by)
{
  $query= "SELECT ".$column." FROM ".$table." ORDER BY ".$order_by;
  $result = mysql_query($query, $connect) or die("cannot connect to table" . mysql_error( ));

  return $result;
}
function selectAll($connect,$column,$table,$where,$order_by)
{
  $query= "SELECT ".$column." FROM ".$table." WHERE ".$where." ORDER BY ".$order_by;
  $result = mysql_query($query, $connect) or die("cannot connect to table" . mysql_error( ));

  return $result;
}
function selectOne($connect,$column,$table,$where,$order_by)
{
  $query= "SELECT ".$column." FROM ".$table." WHERE ".$where." ORDER BY ".$order_by;
  $result = mysql_query($query, $connect) or die("cannot connect to table" . mysql_error( ));
  $rs = mysql_fetch_array($result);

  return $rs;
}
function countAll($result)
{
  $count = mysql_num_rows($result);
  return $count;
}
function updateAll_no_where($connect,$table,$set)
{
  $query= "UPDATE ".$table." SET ".$set;
  $result = mysql_query($query, $connect) or die("cannot connect to table" . mysql_error( ));
}
function updateAll($connect,$table,$set,$where)
{
  $query= "UPDATE ".$table." SET ".$set." WHERE ".$where;
  $result = mysql_query($query, $connect) or die("cannot connect to table" . mysql_error( ));
}
function updateOne($connect,$table,$column,$value,$where)
{
  $query= "UPDATE ".$table." SET ".$column."='".$value."' WHERE ".$where;
  $result = mysql_query($query, $connect) or die("cannot connect to table" . mysql_error( ));
}
function deleteAll($connect,$table,$where)
{
  $query= "DELETE FROM ".$table." WHERE ".$where;
  $result = mysql_query($query, $connect) or die("cannot connect to table" . mysql_error( ));
}
function insertAll($connect,$table,$column,$value)
{
  $query= "INSERT INTO ".$table."(".$column.") VALUES(".$value.")";
  $result = mysql_query($query, $connect) or die("cannot connect to table" . mysql_error( ));
}



?>