<?php
include './db_con.php';

include './getfriends.php';

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT); 
$fid = filter_input(INPUT_POST, 'fid', FILTER_SANITIZE_NUMBER_INT); 
$accdec = filter_input(INPUT_POST, 'accdecl', FILTER_SANITIZE_NUMBER_INT);

if ($accdec == 1 || $accdec == 2) {
    
    $update_stmt = $mysqli->prepare("UPDATE user_rel SET status = ? ,last_act_id = ? WHERE id = ?");
    if ($update_stmt) {
        $update_stmt->bind_param('iii', $accdec, $id, $fid);

        if (! $update_stmt->execute()) {
            $error_msg .= $update_stmt->error.'Database insert error';
            } else {
                    $friends= new Friends($id);
                    $data['friendlist'] = $friends->ProcessFriends();
                    $data['reqeustlist'] =  $friends->ProcessReqeusts();              
                    $data['notfriendlist'] = $friends->ProcessNotfriends();               
                    echo json_encode($data);
                }  
    }

}elseif ($accdec == 0) {
    $insert_stmt = $mysqli->prepare("INSERT INTO user_rel(u_1_id, u_2_id, status, last_act_id) VALUES (?,?,?,?)");
    if ($insert_stmt) {
        $insert_stmt->bind_param('iiii', $id, $fid, $accdec, $id);
        
        if (! $insert_stmt->execute()) {
             $error_msg .= $insert_stmt->error.'Database insert error';
            } else {
                $friends= new Friends($id);
                $data['friendlist'] = $friends->ProcessFriends();
                $data['reqeustlist'] =  $friends->ProcessReqeusts();           
                $data['notfriendlist'] = $friends->ProcessNotfriends();
                echo json_encode($data);
            }  
    }
                
    
}