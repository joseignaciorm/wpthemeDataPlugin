<?php

function modify_queries($query) {
    if( !is_admin() AND is_post_type_archive('resource') AND $query->is_main_query() ) {
        $query->set('posts_per_page', 2);
    }

    if( !is_admin() AND is_post_type_archive('event') AND $query->is_main_query() ) {
        $query->set('posts_per_page', 1);
    }

}
add_action('pre_get_posts', 'modify_queries');

?>