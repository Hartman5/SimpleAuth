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
    $sql = "INSERT INTO Auth (HWID) VALUES ('$hash')";
    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT * from Auth WHERE HWID='$hash'";
        $result = mysqli_query($conn, $sql);
        $resultcheck = mysqli_num_rows($result);
        $row = $result->fetch_assoc();
        $Obj->ID = $row['ID'];
        $Obj->HWID = $HWID;
        $Obj->Status = 'True';
        $Obj->Encrypted_HWID = $row['HWID'];
        $Obj->Created_At = date("Y-m-d h:i:sa");
        $JSON = json_encode($Obj);
        echo $JSON;
        $conn->close();
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