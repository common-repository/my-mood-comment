<?php

define("META_KEY", "MOOD_COMMENT");

define("VERSION","V 1.0");

$mood_comment_config=array(
    "tagNumber"=>6,
    "tag"=>array(
      "good"=>0,"great"=>0,"bored"=>0,"nonsense"=>0,"notunderstand"=>0,"passing"=>0
    ),
	'type'=>array(
      "good","great","bored","nonsense","notunderstand","passing"
    ),
    "img"=>array(
        "good"=>"1.gif","great"=>"2.gif","bored"=>"3.gif","nonsense"=>"4.gif","notunderstand"=>"5.gif","passing"=>"6.gif"
    ),
    "description"=>array(
         "good"=>"不错","great"=>"超赞","bored"=>"无聊","nonsense"=>"扯淡","notunderstand"=>"不解","passing"=>"路过"
    )
);


if (!function_exists('add_action')) {

	$wp_root = '../../../';

	if (file_exists($wp_root.'wp-load.php')) {

		require_once($wp_root.'wp-load.php');

	} else {

		require_once($wp_root.'wp-config.php');

	}


}






?>