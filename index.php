<?php

require_once 'lib/Slim/Slim.php';
require_once 'lib/class.Photo.php';
require_once 'lib/dataOperations.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();



$app->get(
    '/',
    function () {

        require 'config.php';

        // Define and execute query for events dropdown
        $sql = <<<EOT
SELECT CONCAT(pc.title, ' ', psc.title) as title, psc.id
FROM punn_containers pc inner join punn_sub_containers psc on pc.id = psc.container_id
WHERE (SELECT COUNT(ph.id) from photos ph where ph.punn_sub_container_id = psc.id)
order by title
EOT;

        $events = $db->run($sql);  
        $pics = array();
        $pics = prepareObjects($pics);   
        $events = ConvertToHTMLSelectOptions ($events);
        $tableData = ConvertToHTMLTable($pics);
        $carouselData = ConvertToCarouselData($pics);
        $imagePos = 0;

        require("templates/tagger.php");  

    }
);

// POST route
$app->post(
    '/',
    function () {


        require 'config.php';

        // Define and execute query for events dropdown
        $sql = <<<EOT
SELECT CONCAT(pc.title, ' ', psc.title) as title, psc.id
FROM punn_containers pc inner join punn_sub_containers psc on pc.id = psc.container_id
WHERE (SELECT COUNT(ph.id) from photos ph where ph.punn_sub_container_id = psc.id)
order by title
EOT;

        $events = $db->run($sql);


        //Define and execute query for photos 

        
        if ($MODE == "production"){
            $sql = <<<EOT
SELECT distinct ph.id, 
       ( SELECT GROUP_CONCAT(bib_number) FROM photo_tags pt WHERE pt.photo_id = ph.id) as tags,
       ph.small_url,
       ph.medium_url,
       ph.large_url,
       ph.xl_url,
       ph.xxl_url

FROM photos ph
inner join punn_sub_containers psc on ph.punn_sub_container_id = psc.id
inner join punn_containers pc on psc.container_id = pc.id
left join photo_tags pt on ph.id = pt.photo_id
WHERE 1=1
EOT;
        } else {
             $sql = <<<EOT
SELECT distinct ph.id, 
       ( SELECT GROUP_CONCAT(bib_number) FROM photo_tags pt WHERE pt.photo_id = ph.id) as tags,
       ph.small_url

FROM photos ph
inner join punn_sub_containers psc on ph.punn_sub_container_id = psc.id
inner join punn_containers pc on psc.container_id = pc.id
left join photo_tags pt on ph.id = pt.photo_id
WHERE 1=1
EOT;
        }

        $where = "";
        $bind = array();
        foreach ($_POST as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'eventSearch':
                        $where .= " AND (psc.id = :event)";
                        $bind[":event"] = $value;
                        break;

                    case 'albumSearch':
                        switch ($value) {
                            case 'none':
                                $where .= " AND (pt.album_tag IS NULL)";
                                break;
                            
                            default:
                                $where .= " AND (pt.album_tag = :album)";
                                $bind[':album'] = $value;
                                break;
                        }
                        break;

                    case 'untagged':
                        $where .= " AND ((SELECT COUNT(pt.id) from photo_tags pt where pt.photo_id = ph.id) = 0)";
                        break;
                }
            }
        }

        $sql .= $where;
        $sql .= " ORDER BY ph.id";
        
        $pics = $db->run($sql, $bind); // TODO: some meaningful error handling here
        // var_export($sql);
        $pics = prepareObjects($pics);


        // Filter images based on tag search and show full list option
        if (isset($_POST['all'])) {
            $showAll = true;
        } else {
            $showAll = false;
        }

        if (isset($_POST['tagSearch']) AND $_POST['tagSearch']) {
            if ($showAll) {
                foreach ($pics as $i => $pic) { // Look at each picture in the results and save the index of the first match
                    if (in_array($_POST['tagSearch'], $pic->tags)) {
                        $imagePos = $i;
                        break;
                    }      
                }
            } else {
                foreach ($pics as $i => $pic) { // If the show all option isn't selected, remove every picture that doesn't match
                    if (!in_array($_POST['tagSearch'], $pic->tags)) {
                        unset($pics[$i]);
                    }
                }
                $pics = array_values($pics);
            }
                                
        }
        
        

        $events = ConvertToHTMLSelectOptions ($events);
        $tableData = ConvertToHTMLTable($pics);
        $carouselData = ConvertToCarouselData($pics);
        if (!isset($imagePos)) {
            $imagePos = ($_POST['posSearch']) ? $_POST['posSearch']-1 : "0";
        }
        $currentAlbum = $_POST['albumSearch'];

        require("templates/tagger.php");
    }
);


$app->run();

