<?php
include_once "db.php";

// $postData = file_get_contents("php://input");

// $data = json_decode($postData, true);

// if ($data === null || !isset($data['userId'])) {
//     $response = array('status' => 'error', 'message' => 'Ошибка при декодировании JSON или отсутствие необходимых данных');
// } else {
//     $userId = $data['userId'];

//     $stmt = $db_connect->prepare('SELECT userId, url, rating FROM favorites join users on users.id=userId WHERE userId=:post_user_id;');
//     $stmt->bindValue(':post_user_id',$userId);
//     $stmt->execute();
//     $mas=[];
//     while($result=$stmt->fetch(\PDO::FETCH_ASSOC)){
//             $mas[]=$result;
//     }
//     $response = array('status' => 'success', 'body'=>$mas);

// }
// header('Content-Type: application/json');
// echo json_encode($response);

$userId = 1;

$stmt = $db_connect->prepare('SELECT userId, url, rating FROM favorites join users on users.id=userId WHERE userId=:post_user_id;');
$stmt->bindValue(':post_user_id',$userId);
$stmt->execute();
$mas=[];
$response = array('status' => 'success');
while($result=$stmt->fetch(\PDO::FETCH_ASSOC)){
    // print_r($result);
    $response[] = ['userid'=>$result['userid'],
    'url'=>$result['url'],
    'rating'=>$result['rating'],
];

}
echo json_encode($response);
?>