<?php
/**
 * WordPress Functions
 * @author: Mayeenul Islam (@mayeenulislam)
 * 
 * This function page can work under any WordPress theme
 * The code here, are collected from various sources
 * where the code is collected from somewhere, is mentioned as a comment
 * where it's solely of Mayeenul Islam, is also mentioned as a comment
*/


/**
 * CHANGE THE 'WPLANG' IN wp-config.php TO bn_BD ON THEME SWITCHING
 * Thanks: toscho
 * Source: http://wordpress.stackexchange.com/a/121136/22728
*/

add_filter( 'locale', 'toscho_change_language' );

function toscho_change_language( $locale ) {
    return 'bn_BD';
}


/**
 * TRUNCK STRING TO SHORTEN THE STRING
 * 
 * the code block was collected from Ms. Tahmina Aktar (PHP and WordPress developer)
 * The function shorten any string limiting with the parameter passed
 * through the funciton
 * 
 * Usage:
 * <?php
 * $string = "I'm Mayeenul Islam";
 * $truncked_string = trunck_string( $string, 4, true ); ?>
*/

function trunck_string($str = "", $len = 150, $more = 'true') {

    if ($str == "") return $str;
    if (is_array($str)) return $str;
    $str = strip_tags($str);
    $str = trim($str);
    // if it's les than the size given, then return it

    if (strlen($str) <= $len) return $str;

    // else get that size of text
    $str = substr($str, 0, $len);
    // backtrack to the end of a word
    if ($str != "") {
        // check to see if there are any spaces left
        if (!substr_count($str , " ")) {
            if ($more == 'true') $str .= "...";
            return $str;
        }
        // backtrack
        while(strlen($str) && ($str[strlen($str)-1] != " ")) {
            $str = substr($str, 0, -1);
        }
        $str = substr($str, 0, -1);
        if ($more == 'true') $str .= "...";
        if ($more != 'true' and $more != 'false') $str .= $more;
    }
    return $str;
}



/**
 * ENABLING ARROW ON PARENT MENU
 * 
 * This code snippet adds an arrow to the parent menu item
 * where there is/are sub menu[s]
 *
 * Source: http://stackoverflow.com/a/3594567/1743124
 *
 * Usage:
 * With the general register_nav_menus() function this function needs to be in functions.php
 * Then in the template's wp_nav_menu() function, add the 'walker' parameter
 * <?php wp_nav_menu( array( 'walker' => new arrow_walker_nav_menu, 'theme_location' => 'menu_slug' ) ); ?>
*/

class arrow_walker_nav_menu extends walker_nav_menu {
    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $id_field = $this->db_fields['id'];
        if (!empty($children_elements[$element->$id_field])) { 
            $element->classes[] = 'arrow'; //CSS classname here
            $element->title .= '<span class="caret right-caret">&raquo;</span>'; //append html here
        }
        walker_nav_menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}



/**
 * GRAB THE FIRST IMAGE FROM THE POST CONTENT
 * 
 * This function will grab the first image from the post
 * searching the <img> tags inside the post content
 * 
 * Source: WordPress.StackExchange.com - Forgotten
*/

function grab_first_image() {
    global $post;
    $first_image = '';
    ob_start();
    ob_end_clean();
    if( $the_output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches) )
    $first_image = $matches[1][0];

    return $first_image;
}



/**
 * REMOVE UNNECESSARY HEADER INFO
 * 
 * This function will remove unnecessary information from the <head> tag
 * to make the site's head more clean and make the site more speedy
 * 
 * Source: WordPress.StackExchange.com - Forgotten
*/

function remove_header_info() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'start_post_rel_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'adjacent_posts_rel_link');         // for WordPress <  3.0
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); // for WordPress >= 3.0
}
add_action('init', 'remove_header_info');



/**
 * THE EXCERPT FILTERS
 * 
 * This group of functions will make a new controllable excerpt
 *  called nano_excerpt()
 * 
 * Source: Codex - http://codex.wordpress.org/Function_Reference/the_excerpt
*/

function nano_excerpt( $limit ) {
    $limited_excerpts = wp_trim_words( get_the_excerpt(), $limit, new_excerpt_more() );
    echo $limited_excerpts;
    return $limited_excerpts;
}

function new_excerpt_more() {
    return '... <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">'. __( '&raquo;', 'your-theme' ) .'</a>';
}

function custom_excerpt_length( $length ) {
    return 200;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
