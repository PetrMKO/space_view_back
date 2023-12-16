<?php
include_once "db.php";

$postData = file_get_contents("php://input");

$data = json_decode($postData, true);

if ($data === null || !isset($data['login']) || !isset($data['password'])) {
    $response = array('status' => 'error', 'message' => 'Ошибка при декодировании JSON или отсутствие необходимых данных');
} else {
    $login = $data['login'];
    $password = $data['password'];

    $stmt = $db_connect->prepare('SELECT id, login FROM users WHERE login=:post_login and password=:post_password;');
    $stmt->bindValue(':post_login',$login);
    $stmt->bindValue(':post_password',$password);
    $stmt->execute();
    $result=$stmt->fetch(\PDO::FETCH_ASSOC);
    if(!$result){
        $response = array('status' => 'error', 'message' => 'Такого пользователя с таким паролем не существует');
    }else{
        $response = array('status' => 'success', 'id'=>$result['id'], 'login'=>$result['login']);
    }
}
header('Content-Type: application/json');
echo json_encode($response);
?>