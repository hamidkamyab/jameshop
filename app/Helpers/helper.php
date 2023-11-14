﻿<?php
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
function getParentID($data, &$idList = [], $count = 0)
{
    if (isset($data['id']) && $count > 0) {
        $idList[] = $data['id'];
    }
    if (sizeof( $data['parent']) > 0) {
        getParentID($data['parent'][0], $idList, 1);
    }
    return $idList;
}

function getChildrenID($data, &$idList = [], $count = 0)
{
    if (isset($data['id']) && $count > 0) {
        $idList[] = $data['id'];
    }
    if (sizeof( $data['children']) > 0) {
        getChildrenID($data['children'][0], $idList, 1);
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
