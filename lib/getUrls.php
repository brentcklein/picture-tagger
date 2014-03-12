<?php


if ($_SERVER["REQUEST_METHOD"] == "POST"){
  require_once '../config.php';
  // $log = fopen("../error.log", "w");
  // fwrite($log, var_export($_POST, true));
  // fclose($log);

  if ($MODE == "production"){
    $sql = "select ph.small_url as Small,
         ph.medium_url as Medium,
         ph.large_url as Large,
         ph.xl_url as X-Large,
         ph.xxl_url as XX-Large

      from photos ph
      where ph.id = :id";

  } else {
    $sql = "select ph.small_url as Small

      from photos ph
      where ph.id = :id";

  }

  $bind = array(":id" => $_POST['id']);
  $urls = $db->run($sql, $bind);

}

echo json_encode($urls);

?>