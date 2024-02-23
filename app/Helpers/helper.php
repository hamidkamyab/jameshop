<?php

use Morilog\Jalali\Jalalian;

function make_slug($string)
{
    $slug =  preg_replace('/\s+/u', '-', trim($string));
    return $slug;
}
function short_str($string,$maxLen)
{
    $result =  mb_substr($string, 0, $maxLen, 'utf-8');
    if(mb_strlen($string, 'UTF-8') > $maxLen){
        $result = $result.'...';
    }
    return $result;
}

// function get_Id($data)
// {
//     $result =  [];
//     foreach ($data as $key => $value) {
//         $result[] = $value->id;
//     }
//     return $result;
// }


function getParentID($data, &$idList = [], $count = 0)
{
    if (isset($data['id']) && $count > 0) {
        $idList[] = $data['id'];
    }
    if(isset($data['parent'])){
        if (sizeof(@$data['parent']) > 0) {
            getParentID($data['parent'][0], $idList, 1);
        }
    }
    return $idList;
}

function getChildrenID($data, &$idList = [], $count = 0)
{
    if (isset($data['id']) && $count > 0) {
        $idList[] = $data['id'];
    }
    if(isset($data['children'])){
        if (sizeof( $data['children']) > 0) {
            getChildrenID($data['children'][0], $idList, 1);
        }
    }

    return $idList;
}

function getOneFieldOfArray($data,$index = '')
{
    $idList = array();
    foreach ($data as $key => $value) {
        $idList[] = $value[$index];
    }
    return $idList;
}
function getManyFieldOfArray($data,$index = [])
{
    $itemList = array();
    $count = 0;
    foreach ($data as $key => $value) {
        foreach ($index as $key => $i) {
            $itemList[$count][] = $value[$i];
        }
        $count++;
    }
    return $itemList;
}


function convertJtoM($date){
    return Jalalian::fromFormat('Y-m-d H:i:s', $date)->toCarbon();
}
function convertMtoJ($date,$format = 'Y-m-d H:i:s'){
    return Jalalian::fromDateTime($date)->format($format);
}


function overwriteSetting($data){
    $result = [];
    foreach ($data as $item) {
        $result[$item->title] =$item->value;
    }
    return $result;
}
