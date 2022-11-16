<?php

$data = array('name'=>'name1', 'sname'=>'sname1', 'telno'=>'telno1', 'email'=>'email1');
print_r($data);

echo buildInsertUpdateSQL('update', 'table1', $data, ' id=9 ');
echo buildInsertUpdateSQL('insert', 'table1', $data);


function buildInsertUpdateSQL($type, $table, $data, $where=''){

  $sql_u = $sql_f = $sql_v = '';

  foreach ($data as $f => $v) {
    $v = mysqli_real_escape_string($v);
    
    if($type=='update'){
      $sql_u .= sprintf(" %s='%s',", $f, $v);
      
    }else if($type=='insert'){
      $sql_f .= $v.',';
      $sql_v .= " '".$f."',";
    }
  }
  if($type=='update'){
    $sql_ptn = "UPDATE $table SET %s WHERE ".$where;

    $sql_u = " (".(rtrim($sql_u, ',')).") ";

    $sql = sprintf($sql_ptn, $sql_u);

  }else if($type=='insert'){
    $sql_ptn = "INSERT INTO $table (%s) VALUES (%s)";

    $sql_f = " (".(rtrim($sql_f, ',')).") ";
    $sql_v = " (".(rtrim($sql_v, ',')).") ";

    $sql = sprintf($sql_ptn, $sql_f, $sql_v);
  }
  return $sql;
}

?>
