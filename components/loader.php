<?php
$dirURI = get_template_directory_uri() . '/' . basename(__DIR__);

function components_loader_format_script_tag($input) {
    // if path is for components folder
    if (str_pos($input, $dirURI) !== false) {

        
        $input = str_replace("type='text/javascript' ", '', $input);
        return str_replace("'", '"', $input);
    } 
  
}
add_filter('script_loader_tag', 'components_loader_format_script_tag');

// wp_enqueue_script(
//     'twenty-post',
//     get_theme_file_uri('/components/twenty-post/index.js' ),
//     array( 'jquery' ), '1.0', true
// );