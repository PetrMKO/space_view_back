<?php
include_once "db.php";
// ты написал, что если фото не оценено - оно попадает еще и в избранное. 
// я не согласна, мне кажется это отдельные и независимые функции
// зато я добавила возвращение средней оценки, чтобы выводить ее
$postData = file_get_contents("php://input");

$data = json_decode($postData, true);

if ($data === null || !isset($data['userId']) || !isset($data['url'])|| !isset($data['rating'])) {
    $response = array('status' => 'error', 'message' => 'Ошибка при декодировании JSON или отсутствие необходимых данных');
} else {
    $userId = $data['userId'];
    $url = $data['url'];
    $rating = $data['rating'];

    $stmt = $db_connect->prepare("SELECT * from favorites where userId=:post_user_id");
    $stmt->bindValue(':post_user_id',$userId);
    $result=$stmt->fetch(\PDO::FETCH_ASSOC);
    if(!$result){
        $stmt1 = $db_connect->prepare("INSERT INTO favorites(url,userId,rating) VALUES (':post_url',':post_user_id',':post_rating')");
        $stmt1->bindValue(':post_user_id',$userId);
        $stmt1->bindValue(':post_url',$url);
        $stmt1->bindValue(':post_rating',$rating);
        $stmt1->execute();

        $stmt2 = $db_connect->prepare("SELECT url, avg(rating) as rating from favorites where url=:post_url");
        $stmt2->bindValue(':post_url',$url);
        $stmt2->execute();
        $result=$stmt2->fetch(\PDO::FETCH_ASSOC);
        $response = array('status' => 'success', 'url'=>$result['url'], 'rating'=>$result['rating']);
    }
}
header('Content-Type: application/json');
echo json_encode($response);

?>