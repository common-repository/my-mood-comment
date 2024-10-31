<?php
/**
Plugin Name:My Mood Comment
Plugin URI:http://www.wongkey.com/archives/wp-moodcomment
Version: 1.2
Author:wongkey
Author URI: http://www.wongkey.com/
Description:This plugin can help readers express their attitude to your archives quickly.And everyone can easily know others' attitude. (based on mood comment)这个插件提供心情评论，能够让读者看完文章后快速发表心情评论，所有人都能看到各种评论的次数.(基于mood comment修改而来)
*/
// load_plugin_textdomain("my_mood_comment","/wp-content/plugins/my-mood-comment/");
require_once("mood_config.php");
require_once("mood_comment.php");
$moodComment = new mood_comment($mood_comment_config);

add_action('wp_head', 'wp_mood_comment_head');

$post_id = intval($_GET['mood_comment_post_id']);
if($post_id>0){
  die($moodComment->updateMoodComment());
}


function mood_comment() {
	global $moodComment;
    echo $moodComment->getOutPutTemplate();
}

function wp_mood_comment_head(){
	global $moodComment;
	echo $moodComment->getMoodCommentHeader();
}




add_action('publish_post', 'add_mood_comment_fields');

add_action('delete_post', 'delete_mood_comment_fields');

function delete_mood_comment_fields($post_ID) {

    global $wpdb;

    if (!wp_is_post_revision($post_ID)) {

        delete_post_meta($post_ID,META_KEY);

    }

}


function add_mood_comment_fields($post_ID) {

    global $wpdb, $moodComment;

    if (!wp_is_post_revision($post_ID)) {

        add_post_meta($post_ID, META_KEY, $moodComment->getInitSerialize(), true);

    }

}


?>