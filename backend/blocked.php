<?php
include_once "db.php";

$postData = file_get_contents("php://input");

$data = json_decode($postData, true);

if ($data === null || !isset($data['userId'])) {
    $response = array('status' => 'error', 'message' => 'Ошибка при декодировании JSON или отсутствие необходимых данных');
} else {
    $userId = $data['userId'];
    $stmt = $db_connect->prepare('SELECT userId, url FROM blocked join users on users.id=userId WHERE userId=:post_user_id;');
    $stmt->bindValue(':post_user_id',$userId);
    $stmt->execute();
    $response = array('status' => 'success');
    while($result=$stmt->fetch(\PDO::FETCH_ASSOC)){
        $response[] = ['userid'=>$result['userid'],
        'url'=>$result['url'],
        ];
    }
}
header('Content-Type: application/json');
echo json_encode($response);
?>