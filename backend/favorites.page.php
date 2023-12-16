<?php
include_once "db.php";

$userId = 1;

$stmt = $db_connect->prepare('SELECT userId, url, rating FROM favorites join users on users.id=userId WHERE userId=:post_user_id;');
$stmt->bindValue(':post_user_id',$userId);
$stmt->execute();
$mas=[];
$response = array('status' => 'success');
while($result=$stmt->fetch(\PDO::FETCH_ASSOC)){
    $response[] = ['userid'=>$result['userid'],
    'url'=>$result['url'],
    'rating'=>$result['rating'],
];

}
echo json_encode($response);
?>