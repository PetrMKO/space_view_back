<?php
include_once "db.php";

$postData = file_get_contents("php://input");

$data = json_decode($postData, true);

if ($data === null || !isset($data['login']) || !isset($data['password'])) {
    $response = array('status' => 'error', 'message' => 'Ошибка при декодировании JSON или отсутствие необходимых данных');
} else {
    $login = $data['login'];
    $password = $data['password'];

    $stmt = $db_connect->prepare('SELECT id FROM users WHERE login=:post_login');
    $stmt->bindValue(':post_login',$login);
    $stmt->bindValue(':post_password',$password);
    $stmt->execute();
    $result=$stmt->fetch(\PDO::FETCH_ASSOC);
    if($result){
        $response = array('status' => 'error', 'message' => 'Такой пользователь уже существует');
    }else{
        $stmt1 = $db_connect->prepare("INSERT INTO users(login,password) VALUES (':post_login',':post_password')");
        $stmt1->bindValue(':post_login',$login);
        $stmt1->bindValue(':post_password',$password);
        $stmt1->execute();
        $result1=$stmt1->fetch(\PDO::FETCH_ASSOC);
        $response = array('status' => 'success', 'id'=>$result['id'], 'login'=>$result['login']);
    }
}
header('Content-Type: application/json');
echo json_encode($response);
?>