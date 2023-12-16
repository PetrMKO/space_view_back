<?php
include_once "db.php";

$postData = file_get_contents("php://input");

$data = json_decode($postData, true);

if ($data === null || !isset($data['userId']) || !isset($data['url'])) {
    $response = array('status' => 'error', 'message' => 'Ошибка при декодировании JSON или отсутствие необходимых данных');
} else {
    $userId = $data['userId'];
    $url = $data['url'];

    $stmt = $db_connect->prepare("INSERT INTO favorites(url,userId) VALUES (':post_url',':post_user_id')");
    $stmt->bindValue(':post_user_id',$userId);
    $stmt->bindValue(':post_url',$url);
    $stmt->execute();
}

?>