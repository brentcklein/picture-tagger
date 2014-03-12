<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  require_once '../config.php';
  // $log = fopen("../error.log", "w");
  // fwrite($log, var_export($_POST, true));
  // fclose($log);

  $tags = "";
  foreach (array('tag1', 'tag2', 'tag3', 'tag4', 'tag5') as $field) {
    if ($_POST[$field]) {
      $db->insert(
                  "photo_tags", 
                  array(
                        "id" => "((SELECT id from photo_tags order by id DESC LIMIT 1) + 1)",
                        "punn_sub_container_id" => "(SELECT punn_sub_container_id from photos WHERE id=" . $_POST["imageIdInput"] . ")",
                        "photo_id" => $_POST["imageIdInput"],
                        "bib_number" => $_POST[$field]
                      )
                );
      
      $tags .= ", " . $_POST[$field];
    }
  }
  echo $tags;
}

?>