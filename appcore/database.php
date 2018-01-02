<?php
error_reporting(1);
@date_default_timezone_set('Africa/Tripoli');
//---------------------------------------------------------------------------------------------------------
// database info :
define("DB_SERVER" , "localhost");
define("DB_NAME"   , "webschool");
define("USER_NAME" , "root");
define("PASSWORD"  , "123456789");
//---------------------------------------------------------------------------------------------------------
function connect(){
    $con = @mysqli_connect( DB_SERVER, USER_NAME, PASSWORD );
    if( $con ){
        @mysqli_set_charset($con, "UTF8");
        $db = @mysqli_select_db( $con, DB_NAME );
        if( $db ){
            return $con;
        }
    }
    return false;
}
//---------------------------------------------------------------------------------------------------------
function mysql_insert( $table, $data, &$generated_id = NULL ){
    $con   = connect();
    $table = @mysqli_real_escape_string($con, $table);
    $sql = 'INSERT INTO '.$table.' SET ';
    foreach( $data as $clm_name => $value ){
        $clm_name = @mysqli_real_escape_string($con, $clm_name);
        $sql  .= $clm_name.'='.$value.', ';
    }
    $sql = trim($sql, ', ');
    $result = @mysqli_query($con, $sql);
    if( $result ){
        $generated_id = @mysqli_insert_id($con);
    }
    @mysqli_close($con);
    return $result;
}
//---------------------------------------------------------------------------------------------------------
function mysql_update( $table, $data, $where ){
    $con   = connect();
    $table = @mysqli_real_escape_string($con, $table);
    $sql = 'UPDATE '.$table.' SET ';
    foreach( $data as $clm_name => $value ){
        $clm_name = @mysqli_real_escape_string($con, $clm_name);
        $sql  .= $clm_name.'='.$value.', ';
    }
    $sql  = trim($sql, ', ');
    $sql .= ' WHERE '.$where;
    $result = @mysqli_query($con, $sql);
    @mysqli_close($con);
    return $result;
}
//---------------------------------------------------------------------------------------------------------
function mysql_delete( $table, $where ){
    $con    = connect();
    $table  = @mysqli_real_escape_string($con, $table);
    $where  = @mysqli_real_escape_string($con, $where);
    $sql    = 'DELETE FROM '.$table.' WHERE '.$where;
    $result = @mysqli_query($con, $sql);
    @mysqli_close($con);
    return $result;
}
//---------------------------------------------------------------------------------------------------------
function mysql_scalar( $query, $column_name ){
    if( is_null($query) || empty($query)  ){
        return null;
    }
    $con    = connect();
    $result = @mysqli_query($con, $query);
    $scalar = null;
    if( $result ){
        $count  = @mysqli_num_rows($result);
        if( is_array($result) && $count > 0 ){
            $row    = @mysqli_fetch_array($result, MYSQLI_BOTH);
            $scalar = isset($row[$column_name]) ? $row[$column_name] : $row[0];
        }
    }
    @mysqli_free_result($result);
    @mysqli_close($con);
    return $scalar;
}
//---------------------------------------------------------------------------------------------------------
function mysql_execute( $query ){
    if( is_null($query) || empty($query)  ){
        return null;
    }
    $con    = connect();
    $result = @mysqli_query($con, $query);
    echo @mysqli_error($con);
    $column = columns_result($result);
    $values = result_array($result, $column, '');
    @mysqli_free_result($result);
    @mysqli_close($con);
    return $values;
}
//---------------------------------------------------------------------------------------------------------
function mysql_select($table, $columns = "*", $where = null, $orderby = null, $limit = null){
    $con     = connect();
    $table   = @mysqli_real_escape_string($con, $table);
    $columns = @mysqli_real_escape_string($con, $columns);
    $sql = 'SELECT '.$columns.' FROM '.$table;

    if( !is_null($where) && !empty($where)  ){
        $sql .= ' WHERE '.$where;
    }

    if( !is_null($orderby) && !empty($orderby)  ){
        $sql .= ' ORDER BY '.$orderby;
    }
    if( !is_null($limit) && is_numeric($limit) && $limit > 0 ){
        $sql .= ' LIMIT '.$limit;
    }

    $result = @mysqli_query($con, $sql);
    $values = result_array($result, $columns, $table);
    @mysqli_free_result($result);
    @mysqli_close($con);
    return $values;
}
//---------------------------------------------------------------------------------------------------------
function columns_names( $table ){
    $con    = connect();
    $table  = @mysqli_real_escape_string($con, $table);
    $sql    = 'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=\''.DB_NAME.'\' AND TABLE_NAME=\''.$table.'\'';
    $result = @mysqli_query($con, $sql);
    if( $result ){
        $count  = @mysqli_num_rows($result);
        if( !is_array($result) && $count <= 0 ){
            return null;
        }else{
            $columns = array();
            $index   = 0;
            while( $c = @mysqli_fetch_array($result) ){
                $columns[$index] = $c['COLUMN_NAME'];
                $index ++;
            }
            return $columns;
        }
    }else{
        return null;
    }
}
//---------------------------------------------------------------------------------------------------------
function columns_result( $result ){
    $columns = '';
    $count   = @mysqli_num_fields($result);
    $i = 0;
    while ( $i < $count ) {
        $meta = @mysqli_fetch_field($result);
        if( $meta ) { $columns .= $meta->name.','; }
        $i++;
    }
    return rtrim( $columns, ',' );
}
//---------------------------------------------------------------------------------------------------------
function result_array( $result, $columns, $table ){
    $items = [];
    if( $result ){
        if( @mysqli_num_rows($result) > 0 ){
            $columns = trim($columns);
            if( $columns != '*' ){
                $clm_names = explode(',', $columns);
            }else{
                $clm_names = columns_names($table);
            }
            while( $row = @mysqli_fetch_array($result) ){
                $details = [];
                foreach( $clm_names as $clm ){
                    $details[$clm] = $row[$clm];
                }
                $items[] = $details;
            }
        }
    }
    return $items;
}
//---------------------------------------------------------------------------------------------------------
function get_details( $table_name, $id, $column = null ){
    $column = is_null($column) ? 'ID' : $column;
    $result = mysql_select($table_name, '*', $column.'='.$id);
    if( is_array($result) && count($result) > 0 ){
        return $result[0];
    }
    return null;
}
//---------------------------------------------------------------------------------------------------------
function get_list( $table_name, $filter = null ){
    $result = mysql_select($table_name, '*', $filter);
    if( is_array($result) && count($result) > 0 ){
        return $result;
    }
    return null;
}
//---------------------------------------------------------------------------------------------------------
function get_value( $table_name, $id, $column ){
    $result = mysql_select($table_name, $column, "ID={$id}");
    $value  = '';
    if( is_array($result) && count($result) > 0 ){
        $value = $result[0][$column];
    }
    return $value;
}
//---------------------------------------------------------------------------------------------------------