<?php
wp_register_script('axios', ASSETS_URI . '/js/axios.min.js');
wp_register_script('vue-comment-grid', ASSETS_URI . '/js/vue-comment-grid.js',
    array('axios')
);
wp_register_script('twenty-post', LOADER_URI . '/twenty-post/index.js',
    array('vue-comment-grid')
);