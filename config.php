<?php 

require_once 'lib/class.db.php';


if (isset($_ENV["MODE"])) { // Check the heroku MODE and set db accordingly; default to development
  $MODE = $_ENV["MODE"];
  $DOC_ROOT = "/";
} else { // The app is running locally; default to development
  $MODE = "development";
  $DOC_ROOT = "'/picture-tagger/'";
}

switch ($MODE) {
  case 'production':
    $dsn = "mysql:host=HOST;port=PORT;dbname=PRODUCTION_DB";
    $user = "user";
    $pass = "pass";
    break;

  case 'staging':
    $dsn = "mysql:host=punnditproduction.cor694qld8fp.us-east-1.rds.amazonaws.com;port=3306;dbname=punndit_development";
    $user = "psproduser";
    $pass = "9m4aJ2n6M96yL";
    break;

  case 'development':
    // $host = "ec2-54-225-124-205.compute-1.amazonaws.com";
    // $port = 5432;
    // $dbname = "dbmgmg42ui1md9";
    // $dsn = sprintf("pgsql:host=%s;port=%d;dbname=%s", $host, $port, $dbname); ;sslfactory=org.postgresql.ssl.NonValidatingFactory

    $dsn = "pgsql:host=ec2-54-225-124-205.compute-1.amazonaws.com;port=5432;dbname=dbmgmg42ui1md9;sslmode=require";
    $user = "tejvldddpcbkzv";
    $pass = "APy209IVgH_C-r11BSh9w2rfo8";
    break;
}

try {
  $db = new db($dsn, $user, $pass);
} catch (Exception $e) {
  echo "<pre>" . var_export($e, true) . "</pre>";
}

?>

