<?php
   /*
   Plugin Name: My Ajax Search
   Plugin URI: http://my-awesomeness-emporium.com
   Description: a plugin to create awesomeness and spread joy
   Version: 1.2
   Author: Mr. Me
   Author URI: http://mrtotallyawesome.com
   License: GPL2
   */


//enqueue scripts


function ajax_search() {
    wp_enqueue_script( 'ajax-js', plugins_url( 'ajax-js.js', __FILE__ ) , array('jquery') );

    $ajax_search_nonce = wp_create_nonce( 'my_search' );
    wp_localize_script( 'ajax-js', 'my_ajax_obj', array(
         'ajax_url' => admin_url( 'admin-ajax.php' ),
         'nonce'    => $ajax_search_nonce,
    ) );
}
add_action( 'wp_enqueue_scripts', 'ajax_search' );
add_action( 'wp_ajax_my_load_search_results', 'my_load_search_results' );
add_action( 'wp_ajax_nopriv_my_load_search_results', 'my_load_search_results' );


function my_load_search_results() {
check_ajax_referer( 'my_search' );

$query = $_POST['query'];
// creating a search query

$newquery = sanitize_text_field($query);

$qtid = get_cat_ID( 'Quotes');
$qtide = -$qtid;
$args = array(

'post_type' => 'any',
'post_status' => 'publish',
'order' => 'DESC',
'orderby' => 'date',
's' => $newquery,
'posts_per_page' =>10,
'cat' => $qtide

);

if ($newquery != '') {
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {

	echo '<ul id="searchpost">';

	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		echo the_title( sprintf( '<li class="ajsearch"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></li>');
        //echo '<p>' . the_excerpt() . '</p></div>';
	}
	echo '</ul>';
	/* Restore original Post Data */
	//wp_reset_postdata();
    die();
} else {
	// no posts found
    echo '<ul id="searchpost"><li class="ajsearch">Nothing Found</li></ul>';
    die();
}
}
}
