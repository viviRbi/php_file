<?php 
    function checkLength($header_type, $min, $max){
        $content = $_POST[$header_type];
        $wordCount = str_word_count($content);
        $lengthError= false;
        if($wordCount< $min || $wordCount > $max ) $lengthError = true;
        return $lengthError;
    }

    function randomString($length=5){
        $arr= array_merge(range("A","Z"),range("a","z"),range(0,9));
        $arr= implode($arr, '');
        $arr = str_shuffle($arr);

        $firstFive= substr($arr,0,$length);
        $timeStamp = getdate()[0];

        $result= $firstFive . $timeStamp;
        echo $result;
        return $result;
    }
?>