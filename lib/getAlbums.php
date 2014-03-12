<?php


if ($_SERVER["REQUEST_METHOD"] == "POST"){
  require_once '../config.php';
  // $log = fopen("../error.log", "w");
  // fwrite($log, var_export($_POST, true));
  // fclose($log);

  $sql = "select distinct pt.album_tag from photo_tags pt inner join photos ph on pt.photo_id = ph.id 
          where ph.punn_sub_container_id = :event and pt.album_tag is not null order by pt.album_tag";
  $bind = array("event" => $_POST['event']);
  $albums = $db->run($sql, $bind);

}

echo json_encode($albums);
// echo json_encode(array('foo' => 'bar'));
// echo json_encode($_POST);

?>