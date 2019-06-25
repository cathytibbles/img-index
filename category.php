<?php
/**
* Category Display
* requires Genesis HTML5 hooks
*/

// Remove Post Info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//image first and then title beneath
add_action('genesis_entry_header', 'genesis_do_post_format_image',1 );
add_action( 'genesis_entry_header', 'genesis_do_post_title', 15 );

//add term title
add_action('genesis_loop','wpb_tax_title', 1);
function wpb_tax_title() { ;?>
<h4 class="widget-title widgettitle">
	<?php single_term_title();?>
</h4>
<?php 
						 }

//add child-terms in list format
add_action('genesis_loop','wpb_list_tax',2);
function wpb_list_tax() {
	
	$terms = get_terms( array( 'taxonomy' => 'category', 'parent' => 0 ) );
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
  
    $term_list = '<div class="category-list"><ul class="item_cat">';
    // the first item is a 'view all' child terms item - hard coded
		$term_list .= '<li class="all"><a href="https://your-url.com/recipe-index1">ALL Recipes</a></li>';
    foreach ( $terms as $term ) {
        $term_list .= '<li><a href="' . esc_url( get_term_link( $term ) ) . '" alt="' . esc_attr( sprintf( __( 'View all post filed under %s', '' ), $term->name ) ) . '">' . $term->name . '</a></li>'; 
        }
    $term_list .= '</ul></div>'; 
	}
    echo $term_list;
}

//add post classes to create a grid 
//change columns to your desired #
//works with column css that ships with Genesis
add_filter( 'post_class', 'wpb_grid_post_class' );
function wpb_grid_post_class( $classes ) {

		$columns = 3;
		$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
		$classes[] = $column_classes[$columns];
		global $wp_query;

		if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns ) {
			$classes[] = 'first';
		}

	return $classes;

}


genesis();
