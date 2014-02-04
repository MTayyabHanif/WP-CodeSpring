/**
* WordPress Functions
* @author: Mayeenul Islam (@mayeenulislam)
* This function page can work under any WordPress theme
* The code here, are collected from various sources
*  where the code is collected from somewhere, is mentioned as a comment
*  where it's solely of Mayeenul Islam, is also mentioned as a comment
*/

/**
 * TRUNCK STRING TO SHORTEN THE STRING
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



/*
 * ENABLING ARROW ON PARENT MENU
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
