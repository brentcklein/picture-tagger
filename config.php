<?php 

require_once 'lib/class.db.php';


if (isset($_ENV["MODE"])) { // Check the heroku MODE and set db accordingly; default to development
  $MODE = $_ENV["MODE"];
  $DOC_ROOT = "/";
} else { // The app is running locally; default to development
  $MODE = "development";
  $DOC_ROOT = "'/punndit-tagger/'";
}

switch ($MODE) {
  case 'production':
    $dsn = "mysql:host=HOST;port=PORT;dbname=PRODUCTION_DB";
    $user = "psproduser";
    $pass = "9m4aJ2n6M96yL";
    break;

  case 'staging':
    $dsn = "mysql:host=HOST;port=PORT;dbname=STAGING_DB";
    $user = "psproduser";
    $pass = "9m4aJ2n6M96yL";
    break;

  case 'development':
    $dsn = "mysql:host=HOST;port=PORT;dbname=DEVELOPMENT_DB";
    $user = "psproduser";
    $pass = "9m4aJ2n6M96yL";
    break;
}

$db = new db($dsn, $user, $pass);

?>