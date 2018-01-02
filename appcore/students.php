<?php
require_once 'database.php';
require_once 'getinfo.php';

function is_datetime( $str_date, $date_format = 'Y-m-d', $timezone = null ) {
    // $zone = !is_null($timezone) ? new DateTimeZone($timezone) : null;
    $date = DateTime::createFromFormat($date_format, $str_date);
    return $date && DateTime::getLastErrors()["warning_count"] == 0
                 && DateTime::getLastErrors()["error_count"]   == 0;
}

function get_student_schools( $student_id ){
    $schools = [];
    if( is_numeric($student_id) && $student_id > 0 ){
        $query_schools = 'SELECT *, A.ID AS RID FROM Registration A INNER JOIN School B ON A.SchoolID = B.ID WHERE A.StudentID = '.$student_id;
        $schools = mysql_execute($query_schools);
        foreach ( $schools as $index => $details ){
            $schools[$index]['Location'] = get_town($details['TownID']);
        }
    }
    return $schools;
}

function set_student_schools( &$studentInfo ){
    if( is_array($studentInfo) && count($studentInfo) > 0 ){
        $studentInfo['Schools'] = [];
        $schools = get_student_schools($studentInfo['ID']);
        if( is_array($schools) && count($schools) > 0 ){
            $studentInfo['Schools'] = $schools;
        }
    }
}

function get_student( $student_id ){
    $student = get_details('Student', $student_id);
    set_student_schools($student);
    return $student;
}

function get_student_tcn( $tc_number ){
    $student = get_details('Student', $tc_number, 'TCNo');
    set_student_schools($student);
    return $student;
}

function validation_student( $data, $update = false ){
    $errors = '';
    if( !$update ){
        if( !isset($data['tc_number']) || !is_numeric($data['tc_number']) || strlen($data['tc_number']) <> 6 ){
            $errors .= '<div>invalid value of field T.C. Number</div>';
        }else{
            $student = get_student_tcn($data['tc_number']);
            $invalid = (is_array($student) && count($student) > 0);
            if( $invalid ){
                $errors .= '<div>invalid value of field T.C. Number. is used by other registration</div>';
            }
        }
    }
    if( !isset($data['first_name']) || empty($data['first_name']) || strlen($data['first_name']) < 3 ){
        $errors .= '<div>invalid value of field First Name</div>';
    }
    if( !isset($data['last_name']) || empty($data['last_name']) || strlen($data['last_name']) < 3 ){
        $errors .= '<div>invalid value of field Last Name</div>';
    }
    if( !isset($data['birth_date']) || !is_datetime($data['birth_date']) ){
        $errors .= '<div>invalid value of field Date of Birth</div>';
    }
    $phone_pattern = "/^[0-9]{10}$/";
    if( !isset($data['phone']) || !is_numeric($data['phone']) || strlen($data['phone']) <> 10 ){
        $errors .= '<div>invalid value of field Phone Number</div>';
    }elseif( !preg_match($phone_pattern, $data['phone']) ){
        $errors .= '<div>invalid value of field Phone Number</div>';
    }
    if( !isset($data['email']) || empty($data['email']) ){
        $errors .= '<div>invalid value of field Email</div>';
    }elseif( !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ){
        $errors .= '<div>invalid value of field Email</div>';
    }
    $errors = trim($errors) == '' ? true : $errors;
    return $errors;
}

function remove_student( $student_id ){
    mysql_delete('Registration', 'StudentID='.$student_id);
    $remove = mysql_delete('Student', 'ID='.$student_id);
    if( $remove ){
        $message = '<div class="alert alert-success">successfully removed student details</div>';
    }else{
        $message = '<div class="alert alert-danger">error remove student details. try again</div>';
    }
    return $message;
}

function edit_student( $data ){
    $valid_student = validation_student($data, true);
    if( $valid_student !== true ){
        $message = '<div class="alert alert-danger">error update student details. check : '.$valid_student.'</div>';
    }else{
        $student_id   = $data['student_id'];
        $student_data = [
            'FirstName' => "'".$data['first_name']."'",
            'LastName'  => "'".$data['last_name'] ."'",
            'BirthDate' => "'".$data['birth_date']."'",
            'Phone'     => "'".$data['phone']     ."'",
            'Address'   => "'".$data['address']   ."'",
            'Email'     => "'".$data['email']     ."'",
        ];
        $update = mysql_update('Student', $student_data, 'ID='.$student_id);
        if( $update ){
            $user_update = [
                'UserName' => "'".$data['first_name']." ".$data['last_name']."'",
                'Email'    => "'".$data['email']     ."'",
            ];
            mysql_update('Users', $user_update, 'StudentID='.$student_id);
            $message = '<div class="alert alert-success">successfully update student details.</div>';
        }else{
            $message = '<div class="alert alert-danger">error update student details try again.</div>';
        }
    }
    return $message;
}

function save_student( $data ){
    $student_id = false;
    $student_data = [
        'TCNo'      => "'".$data['tc_number'] ."'",
        'FirstName' => "'".$data['first_name']."'",
        'LastName'  => "'".$data['last_name'] ."'",
        'BirthDate' => "'".$data['birth_date']."'",
        'Phone'     => "'".$data['phone']     ."'",
        'Address'   => "'".$data['address']   ."'",
        'Email'     => "'".$data['email']     ."'",
    ];
    $insert = mysql_insert('Student', $student_data, $student_id);
    $student_id = $insert ? $student_id : false;
    return $student_id;
}

function get_registration( $id ){
    $registration = get_details('Registration', $id);
    if( !is_null($registration) ){
        $school  = get_school($registration['SchoolID']);
        $registration['School'] = $school;

        $student = get_details('Student', $registration['StudentID']);
        $registration['Student'] = $student;
    }
    return $registration;
}

function update_register_state( $data ){
    $register_id = $data['register_id'];
    $update_date = @date('Y-m-d');
    $register_data = [
        'Notes'      => "'".$data['note']."'",
        'AcceptDate' => "'".$update_date."'",
        'Accept'     => "'".$data['state']."'",
    ];
    $update = mysql_update('Registration', $register_data, 'ID='.$register_id);
    return $update;
}

function register_student( $student_id, $school_id ){
    $regist_id   = false;
    $reg_date    = @date('Y-m-d');
    $regist_data = [
        'StudentID'  => $student_id      ,
        'SchoolID'   => $school_id       ,
        'RegistDate' => "'".$reg_date."'",
        'Accept'     => "'N'"
    ];
    $insert = mysql_insert('Registration', $regist_data, $regist_id);
    $regist_id = $insert ? $regist_id : false;
    return $regist_id;
}

function add_registration( $data ){
    $message    = '';
    $schoolInfo = null;
    if( isset($data['school_id']) && is_numeric($data['school_id']) ){
        $schoolInfo = get_school($data['school_id']);
    }
    if( !is_array($schoolInfo) || count($schoolInfo) <= 0 ){
        $message = '<div class="alert alert-danger">error add registration unknown school! </div>';
    }else{
        if( isset($data['tc_number']) && is_numeric($data['tc_number']) ){
            $studentInfo = get_student_tcn($data['tc_number']);
            if( is_array($studentInfo) && count($studentInfo) >= 0 ){
                $school_ids = array_column($studentInfo['Schools'], 'ID');
                $in_school  = in_array( $schoolInfo['ID'], $school_ids );
                if( $in_school ){
                    $message = '<div class="alert alert-danger">error registration student has T.C.Number '.$studentInfo['tc_number'].' already registered in school '.$schoolInfo['Name'].' </div>';
                }else{
                    $register_id = register_student($studentInfo['ID'], $schoolInfo['ID']);
                    if( is_numeric($register_id) && $register_id > 0 ){
                        $message = '<div class="alert alert-success">successfully registration student in school '.$schoolInfo['Name'].'!, please wait confirm your request by us.</div>';
                    }else{
                        $message = '<div class="alert alert-danger">error add registration for student try again!</div>';
                    }
                }
            }else{
                $valid_student = validation_student($data);
                if( $valid_student !== true ){
                    $message = '<div class="alert alert-danger">error add registration invalid fields! : '.$valid_student.'</div>';
                }else{
                    $student_id = save_student($data);
                    if( is_numeric($student_id) && $student_id > 0 ){
                        $register_id = register_student($student_id, $schoolInfo['ID']);
                        if( is_numeric($register_id) && $register_id > 0 ){
                            $message = '<div class="alert alert-success">successfully registration student in school '.$schoolInfo['Name'].'!, please wait confirm your request by us.</div>';
                        }else{
                            $message = '<div class="alert alert-danger">error add registration for student try again!</div>';
                        }
                    }else{
                        $message = '<div class="alert alert-danger">error add registration for student try again!</div>';
                    }
                }
            }
        }
    }
    return $message;
}


function list_registrations(){
    $students = get_list('Student');
    if( !is_null($students) ){
        foreach ($students as $index => $info){
            $schools = get_student_schools($info['ID']);
            $students[$index]['Schools'] = $schools;
        }
    }
    return $students;
}