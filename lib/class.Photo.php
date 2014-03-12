<?php 

class Photo {
    // Properties
    public $num, $id, $tags, $smallUrl, $mediumUrl, $largeUrl, $xlUrl, $xxlUrl;

    // Methods
    public function setNum($n){
        $this->num = $n;
    }
    public function setId($i){
        $this->id = $i;
    }
    public function setTags($t){
        $this->tags = $t;
    }
    public function setSmallUrl($u){
        $this->smallUrl = $u;
    }
    public function setMediumUrl($u){
        $this->mediumUrl = $u;
    }
    public function setLargeUrl($u){
        $this->largeUrl = $u;
    }
    public function setxlUrl($u){
        $this->xlUrl = $u;
    }
    public function setxxlUrl($u){
        $this->xxlUrl = $u;
    }

    public function getNum(){
        return $this->num;
    }
    public function getId(){
        return $this->id;
    }
    public function getTags(){
        return $this->tags;
    }
    public function getSmallUrl(){
        return $this->smallUrl;
    }
    public function getMediumUrl(){
        return $this->mediumUrl;
    }
    public function getLargeUrl(){
        return $this->largeUrl;
    }
    public function getXlUrl(){
        return $this->xlUrl;
    }
    public function getXxlUrl(){
        return $this->xxlUrl;
    }

    public function init($options){ // Really ugly, but needed a way to account for the lack of addition url fields in the development and staging dbs
        if (isset($options[0])) {
            $this->setNum($options[0]);
        } else {
            $this->setNum(null);
        }
        if (isset($options[1])) {
            $this->setId($options[1] ? $options[1] : null);
        } else {
            $this->setId(null);
        }
        if (isset($options[2])) {
            $this->setTags($options[2] ? $options[2] : array());
        } else {
            $this->setTags(array());
        }
        if (isset($options[3])) {
            $this->setSmallUrl($options[3] ? $options[3] : null);
        } else {
            $this->setSmallUrl(null);
        }
        if (isset($options[4])) {
            $this->setMediumUrl($options[4] ? $options[4] : null);
        } else {
            $this->setMediumUrl(null);
        }
        if (isset($options[5])) {
            $this->setLargeUrl($options[5] ? $options[5] : null);
        } else {
            $this->setLargeUrl(null);
        }
        if (isset($options[6])) {
            $this->setXlUrl($options[6] ? $options[6] : null);
        } else {
            $this->setXlUrl(null);
        }
        if (isset($options[7])) {
            $this->setxxlUrl($options[7] ? $options[7] : null);
        } else {
            $this->setxxlUrl(null);
        }
        
    }
}

?>