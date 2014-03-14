<?php 

require_once 'lib/class.db.php';

// if $_ENV["DATABASE_URL"] is empty then the app is not running on Heroku
if (empty($_ENV["DATABASE_URL"])) {
    $config["db"]["driver"] = "sqlite";
    $config["db"]["url"] = "sqlite://" . realpath("data/my.db");
}
else {
    // translate the database URL to a PDO-friendly DSN
    $url = parse_url($_ENV["DATABASE_URL"]);
    $config["db"]["driver"] = $url["scheme"];
    $config["db"]["url"] = sprintf(
        "pgsql:user=%s;password=%s;host=%s;dbname=%s",
         $url["user"], $url["pass"], $url["host"],
         trim($url["path"], "/"));
}


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
    $dsn = "mysql:host=HOST;port=PORT;dbname=STAGING_DB";
    $user = "user";
    $pass = "pass";
    break;

  case 'development':
    $host = "ec2-54-225-124-205.compute-1.amazonaws.com";
    $port = "5432";
    $dbname = "dbmgmg42ui1md9";
    $dsn = sprintf("postgressql:host=%s;port=%s;dbname=%s", $host, $port, $dbname);

    // set up tagger to run using heroku shared postgressql db
    // $url = parse_url($_ENV["DATABASE_URL"]);
    // $driver = $url["scheme"];
    // $dsn = sprintf(
    //     "pgsql:host=%s;dbname=%s",
    //      $url["host"],
    //      trim($url["path"], "/"));

    $user = "tejvldddpcbkzv";
    $pass = "APy209IVgH_C-r11BSh9w2rfo8";
    break;
}

$db = new db($dsn, $user, $pass);

?>

