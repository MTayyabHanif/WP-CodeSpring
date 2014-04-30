<?php
/**
 *  Template Name: Get Today's News
 *  
 *  @Developer: Mayeenul Islam, Afiful Islam
 *
 *  A template for WordPress page to get News (Posts)
 *   from the defined categories
 *   where they are with meta_key => print_version
 *   and with meta_value => yes
 *   and from today's date
 */

get_header(); ?>

<?php

/**
 *	ACTIVATING THE VARIABLE ON THE URL
 *	This will activate the ?cat= parameter on the URL
 *	 to get them using get_query_var( 'cat' )
 */
 
function add_query_vars_filter( $vars ){
  $vars[] = "cat";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


/**
 *	SETUP THE NECESSARY FEATURES HERE, FIRST
 *
 *	1.	Enter the Default Category ID
 *		It'll work like a fallback, when you will be on the first page
 *		 where no ?cat= is defined on the URL
 *		Typically the "First Page" where news updated every day
 *
 *	2.	Enter Maximum Number of News to Show
 *		Enter the number of news from ALL THE CATEGORIES
 *		 to show on the page
 *	
 *	3.	Meta Key and Meta Value by which you are filtering
 *		 the web contents from the print contents
 *		 i.e. 'meta_key' => 'meta_value'
 * 
 * 	4.	Input the Page ID where the Template is used
 */

$default_category = '13'; //Cat ID Only
$maximum_limit = '30';
$meta_key = 'print_version';
$meta_value = 'yes';
$template_page_id = 25;

?>
<!-- FOR TEST PURPOSE ONLY -->
<style>
ul.categories{
	list-style-type: none;
	clear: both;
}

ul.categories li{
	float: left;
	margin-right: 10px;
}
</style>
<!-- FOR TEST PURPOSE ONLY -->

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<h2><?php the_title(); ?></h2>

			    <?php
	        $year_today = date( 'Y', current_time( 'timestamp' ) );
	        $month_today = date( 'm', current_time( 'timestamp' ) );
	        $day_today = date( 'd', current_time( 'timestamp' ) );
			
    		$cat_args = array(
				'date_query' => array(
				  array(
				    'year'  => $year_today,
				    'month' => $month_today,
				    'day'   => $day_today,
				  ),
				),
				'meta_key' => $meta_key,
				'meta_value' => $meta_value,
                    	    );
	            
	        $get_cats = new WP_Query( $cat_args );
	    		
	        ?>

	        <?php
      		while( $get_cats->have_posts() ){
      			
	      	    $get_cats->the_post();
	      		
	      	    $category = get_the_category();
	      		
	      	    $cat_ID[] = $category[0]->cat_ID;
                }
      		
      		$the_categories = array_unique( $cat_ID ); //merging common categories
      				 
      		?>

      		<ul class="categories">
	        <?php foreach( $the_categories as $news_cat ) { ?>
	        	<li>
	                <a href="<?php echo get_page_link( $template_page_id ) . '?cat='. $news_cat .'';?>">
	                    <?php echo get_cat_name( $news_cat ); ?>
	                </a>
	            </li>
	        <?php } ?>
	        </ul> <!-- .categories -->
  
  	      <div style="clear: both;"></div>
    
	        <ul>
	        <?php
    			//get from the URL, otherwise go with the default category		
    	        if( get_query_var( 'cat' ) != '' ){
    			$this_category = get_query_var( 'cat' );
    		} else {
    			$this_category = $default_category;
    		}
	        
	        $news_args = array(
	            'cat' => $this_category,
	            'posts_per_page' => $maximum_limit,
	            'date_query' => array(
	                array(
	                  'year'  => $year_today,
	                  'month' => $month_today,
	                  'day'   => $day_today,
	                ),
	              ),
      		    'meta_key' => $meta_key,
		    'meta_value' => $meta_value
	        );
	        
	        $get_news = new WP_Query( $news_args );
			
	        while ( $get_news->have_posts() ) : $get_news->the_post(); ?>    
	        
	            <?php echo '<li>'. get_the_title() . '</li>'; ?>
	        
	        <?php endwhile; ?>
	        </ul>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
