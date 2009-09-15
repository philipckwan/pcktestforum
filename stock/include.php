<?php
session_start();

/*
 * App specific config - start
 */
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "fedora";
$dbname = "pck";
$debug = 1;
$q_debug = 1;
/*
 * App specific config - end
 */

$sp5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$sp10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die("Error connecting to mysql");

mysql_select_db($dbname);

function q($query){ // Query
    global $q_debug;
    if($q_debug) echo "<br/><font color = 'blue'>$query</font><br/>";
    return mysql_query($query);
}

function d($msg){ // Debug
    global $debug;
    if($debug) echo "<br/><font color = 'green'>$msg</font><br/>";
}

function f_assoc($mysql_result){
    return mysql_fetch_array($mysql_result, MYSQL_ASSOC);
}

function simple_form($form_action, $input_submit_value, $help){
    echo "<form action='{$form_action}' method='post'>".
        "<p>{$help}<input type='submit' value='{$input_submit_value}' /></p>".
        "</form>";
}

function getPost($post){
    return htmlspecialchars($_POST[$post]);
}
function process_show(){
    $name = getPost("name");
    $show = getPost("show");
    if($show == 'No Show'){
        $query = "update menu set display_1 = '0' where name = '{$name}'";
    }
    else{
        $query = "update menu set display_1 = '1' where name = '{$name}'";
    }
    q($query);    
}
function process_delete(){
    $name = getPost("name");
    $delete = getPost("delete");
    if($delete =='Delete Me' ){
        $query = "delete from menu where name = '{$name}'";
        q($query);
    }
}


?>