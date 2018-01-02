<?php
require_once 'database.php';

function get_login(){
    $login = null;
    if( isset($_SESSION['uid']) && is_numeric($_SESSION['uid']) ){
        $login = get_details('Users', $_SESSION['uid']);
    }
    return $login;
}

function is_login(){
    $is_logged = true;
    $is_logged = $is_logged && isset($_SESSION['uid']) && is_numeric($_SESSION['uid']);
    $is_logged = $is_logged && isset($_SESSION['username']) && !empty($_SESSION['username']);
    $is_logged = $is_logged && isset($_SESSION['account']) && in_array($_SESSION['account'], ['U', 'A']);
    return $is_logged;
}

function login_user( $email, $password ){
    $is_logged = false;
    $login = get_details('Users', "'{$email}'", 'Email');
    if( !is_null($login) ){
        if( $login['Password'] == $password ){
            $_SESSION['uid']      = $login['ID'];
            $_SESSION['username'] = $login['UserName'];
            $_SESSION['account']  = $login['Account'];
            if( $login['Account'] == 'U' ){
                $_SESSION['sid'] = $login['StudentID'];
            }
            $is_logged = true;
        }
    }
    return $is_logged;
}

function logout_user(){
    $_SESSION['uid']      = null;
    $_SESSION['username'] = null;
    $_SESSION['account']  = null;
    $_SESSION['sid']      = null;

    unset($_SESSION['uid']);
    unset($_SESSION['username']);
    unset($_SESSION['account']);
    unset($_SESSION['sid']);

    session_destroy();
    session_regenerate_id();
}

function create_user( $student_id, $password ){
    $user_id = false;
    $student = get_student($student_id);
    $user_data = [
        'UserName' => "'{$student['FirstName']} {$student['LastName']}'",
        'Password' => "'{$password}'",
        'Email'    => "'{$student['Email']}'",
        'Account'  => "'U'",
        'StudentID'=> $student_id
    ];
    $insert = mysql_insert('Users', $user_data, $user_id);
    if( $insert ) {
        $message = '<div class="alert alert-success">successfully created account for student</div>';
    }else{
        $message = '<div class="alert alert-danger">error create account try again</div>';
    }
    return $message;
}

function list_users( $account = '' ){
    $filter = !empty($account) ? "Account='{$account}'" : null;
    $users = get_list('Users', $filter);
    return $users;
}