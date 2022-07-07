<?php 
include_once 'inc/db.inc';
 if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
    $url = "https://";   
else  
    $url = "http://";   
$url.= $_SERVER['HTTP_HOST'];   
$url.= $_SERVER['REQUEST_URI'];    
$url_components = parse_url($url);
parse_str($url_components['query'], $params);
$HWID = $params['hwid'];
if ($HWID == '') {
    $Obj->ID = Null;
    $Obj->HWID = $HWID;
    $Obj->Status = 'False';
    $Obj->Encrypted_HWID = Null;
    $Obj->Error = "No HWID Value";
    $JSON = json_encode($Obj);
    echo $JSON;
}
else {
   $hash = hash('sha256', $HWID);
   $sql = "SELECT * from Auth WHERE HWID='$hash'";
   $result = mysqli_query($conn, $sql);
   $resultcheck = mysqli_num_rows($result);
   $row = $result->fetch_assoc();
   if ($hash = $row['HWID'])
     {
        $Obj->ID = $row['ID'];
        $Obj->HWID = $HWID;
        $Obj->Status = 'True';
        $Obj->Encrypted_HWID = $row['HWID'];
        $JSON = json_encode($Obj);
        echo $JSON;
     }
    else {
        $Obj->ID = Null;
        $Obj->HWID = $HWID;
        $Obj->Status = 'False';
        $Obj->Encrypted_HWID = Null;
        $JSON = json_encode($Obj);
        echo $JSON;
    }
}
?>