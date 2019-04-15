<?php

class Friends {

    var $mainid = "";
    private $allfriends = array();    
    private $reqfriends = array();    
    
    function __construct($id) {
        $this->mainid = $id;
    }
    
    private function Getfriends($stat) {
        $id = $this->mainid;
        include 'db_con.php';
        
        if ($stmt = $mysqli->prepare("SELECT id, u_1_id, u_2_id, last_act_id FROM user_rel WHERE (status = ? ) AND ((u_1_id = ? ) OR (u_2_id = ? ))")) {
        $stmt->bind_param('iii', $stat,$id, $id);
        $stmt->execute();   
        $stmt->store_result();
        return $stmt;
       }
    }
    
    function ProcessFriends(){
        include 'db_con.php';
        $id = $this->mainid;    
        $stmt = $this->Getfriends(1);
        $stmt->bind_result($fshipid, $id1, $id2, $lastactid);
        $friendlist = "";
        
        while ($row = $stmt->fetch()) {
            if ($id1 == $id) { $fid = $id2; } else { $fid = $id1; }
            array_push($this->allfriends, $fid);
            if ($stmt1 = $mysqli->prepare("SELECT email , name, surname,image FROM user WHERE id = ? LIMIT 1")) {
                 $stmt1->bind_param('i', $fid);  
                 $stmt1->execute();    
                 $stmt1->store_result();

                 $stmt1->bind_result($email, $name, $surname, $image);
                 $stmt1->fetch();
                 $friendlist = $friendlist.'<div class="friendunit"><div class="fimage" style="background-image: url(\'etc/'.$image.'\');"></div><div class="fdetail"><p>'.$name.' '.$surname.'</p><p>'.$email.'</p></div></div>';
            }
         }
        return $friendlist;
    }
    
    function ProcessReqeusts() {
        
        include 'db_con.php';
        $id = $this->mainid;    
        $stmt = $this->Getfriends(0);
        $stmt->bind_result($fshipid, $id1, $id2, $lastactid);
        $reqeustlist = "";
        
        while ($row = $stmt->fetch()) {
             
            if ($id1 == $id) { $fid = $id2; } else { $fid = $id1; }
            array_push($this->reqfriends, $fid);
            if ($lastactid != $id) {
                
                if ($stmt1 = $mysqli->prepare("SELECT email , name, surname,image FROM user WHERE id = ? LIMIT 1")) {
                     $stmt1->bind_param('i', $fid);  
                     $stmt1->execute();    
                     $stmt1->store_result();

                     $stmt1->bind_result($email, $name, $surname, $image);
                     $stmt1->fetch();
                    $reqeustlist = $reqeustlist.'<div class="friendunit"><div class="fimage" style="background-image: url(\'etc/'.$image.'\');"></div><div class="fdetail"><p>'.$name.' '.$surname.'</p><p>'.$email.'</p></div>  <div class="reqbuttoncontain"><button data-accdec="1" value="'.$fshipid.'" class="reqbuttacc butt reqbutt">Accept</button><button value="'.$fshipid.'" data-accdec="2" class="reqbuttdecl butt reqbutt">Decline</button></div></div>';

                     }
      
                 }         
         }
         return $reqeustlist;
    }
    
    function ProcessNotfriends() {
           include 'db_con.php';
        
           $id = $this->mainid;    

            $notfriendlist = "";

            if ($stmt = $mysqli->prepare("SELECT id, email , name, surname,image FROM user")) { 
                 $stmt->execute();    
                 $stmt->store_result();

                 $stmt->bind_result($fid, $email, $name, $surname, $image);
                 $stmt->fetch();
                  while ($row = $stmt->fetch()) {
                      if ((!in_array($fid, $this->allfriends))&&($fid != $id)) {
                            if (in_array($fid,$this->reqfriends)) {
                                $disablebutt = 'disabled="disabled"';
                                $butttext = "Invited";
                            }else{
                                $disablebutt = "";
                                 $butttext = "Invite";
                            }
                            $notfriendlist = $notfriendlist.'<div class="friendunit"><div class="fimage" style="background-image: url(\'etc/'.$image.'\');"></div><div class="fdetail"><p>'.$name.' '.$surname.'</p><p>'.$email.'</p></div>  <div class="reqbuttoncontain"><button data-accdec="0" value="'.$fid.'" '.$disablebutt.' class="reqbuttacc butt reqbutt">'.$butttext.'</button></div></div>';
                        }
                   
                  }
                  return $notfriendlist;
                 
            }  

    }
}
