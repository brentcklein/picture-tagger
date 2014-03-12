<?php

function ConvertToHTMLSelectOptions ($data) { 
    $options = "";
    foreach ($data as $event) {
        $item = "<option value='" . $event['id'] . "'";
        if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST['eventSearch'])) { 
            if ($_POST['eventSearch'] == $event['id']) {                                             
                $item .= " selected='selected'"; 
            }
        } 
        $item .= ">" . $event['title'] . "</option>";
            $options .= $item;
        }
    return $options;
}

function ConvertToHTMLTable ($data) { //Displays picture data as HTML in order to allow javascript to traverse
    $tableData = "<table id='data' class='table'>
              <tbody>";

    foreach ($data as $i => $member) {
        $dataRow = "<tr class='" . $i . "'>";
        $dataRow .= "<td class='num'>" . $member->num . "</td>";
        $dataRow .= "<td class='id'>" . $member->id . "</td>";
        $dataRow .= "<td class='tags'>";
        $i=0;
        // var_export($member->tags);
        foreach ($member->tags as $tag) {
            if (!$i++) {
                $dataRow .= $tag;
            } else {
                $dataRow .= ", " . $tag;
            }
        }
        $dataRow .= "</td>";
        $dataRow .= "</tr>";
        $tableData .= $dataRow;
    }

    $tableData .= "</tbody></table>";

    return $tableData;

}

function ConvertToCarouselData ($data) {
    $carouselData = "";
    if (!count($data)) {
        $item = "<div class='item'><p>There are no images to display</p></div>";
        $carouselData .= $item;
        return $carouselData;
    }
    foreach ($data as $i => $member) {
        if ($member->mediumUrl) {
            $url = $member->mediumUrl;
        } else if ($member->largeUrl) {
            $url = $member->largeUrl;
        } else if ($member->smallUrl) {
            $url = $member->smallUrl;
        } else if ($member->xlUrl) {
            $url = $member->xlUrl;
        } else if ($member->xxlUrl) {
            $url = $member->xxlUrl;
        } else {
            $url = "";
        }

        $item = "<a class='item link'><img class='lazyOwl' data-src='" . $url . "' alt='Photo # " . $member->id . "'></a>";
        $carouselData .= $item;
    }
    return $carouselData;
}

function prepareObjects($data) {
    foreach ($data as $key => $value) {
        $params = array();
        $params[] = $key;
        foreach ($value as $field => $val) {
            if ($field == 'tags') {
                $params[] = str_getcsv($val);
            } else {
                $params[] = $val;
            }
        }
         
        $obj = new Photo;
        $obj->init($params); 
        $data[$key] = $obj;
    }
    return $data;
}

?>