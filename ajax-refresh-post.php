<?php
/*
Plugin Name: Ajax Refresh Post
Plugin URI: 
Description: Plugin pour refresh en ajax les posts
Version: 0.1
Author: Rollingbox
Author URI: https://rollingbox.com
Text Domain: ajax-refresh-post
Domain Path: /languages/
GitHub Plugin URI: 
*/

if (!defined('ABSPATH')) {
	exit;
}

//if ( !function_exists( 'arp_init' ) ) {
//	register_activation_hook( __FILE__, 'arp_init' );
//  function arp_init() {
//
//		
//  }
//}

if ( !function_exists( 'arp_init' ) ) {
	add_action( 'init', 'arp_init' );
  function arp_init() {
		
		/* PLUGIN */
		wp_enqueue_script('script-arp', plugins_url('script.js', __FILE__), false, '', true);
//		wp_enqueue_style('wpk-admin-css', plugins_url('/style.min.css', dirname(__FILE__)));											 
		wp_localize_script( 'script-arp', 'arpAjax', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
				)
    );
  }
}

if ( !function_exists( 'arp_post_shortcode' ) ) {
	add_shortcode('arp_post' , 'arp_post_shortcode');
	function arp_post_shortcode(){
	?>
<select id="categoriePost">
		<option data-type="all" class="active">Catégorie</option>
<?php
		$type = get_terms( array(
				'taxonomy' => 'category',
				'hide_empty' => false,
				'order' => 'ASC'
		) );
		if ( ! empty( $type ) && ! is_wp_error( $type ) ){
				foreach ( $type as $term_type ) {
						echo '<option data-type="'. $term_type->slug . '">' . $term_type->name . '</option>';
				}
		}
?>
</select>
<div id='arp_post'></div>
<?php
	}
}

add_action( 'wp_ajax_' . 'updatePostAjax', 'updatePostAjax_function' );
add_action( 'wp_ajax_nopriv_' . 'updatePostAjax', 'updatePostAjax_function' );
if ( !function_exists( 'updatePostAjax_function' ) ) {
	function updatePostAjax_function(){
		
		global $wpdb;
		
		$category = $_POST['data'];
		
		if($category != 'all'){
			$args = array(
					'post_type' => 'post',
					'paged' => get_query_var('paged'),
					'category_name' => $category
			);
		} else{
			$args = array(
					'post_type' => 'post',
					'paged' => get_query_var('paged')
			);
		}
		
//		var_dump($args);
		
		$query = new WP_Query($args);
		?>
		<ul>
		<?php
		if( $query -> have_posts() ): while( $query -> have_posts() ) : $query -> the_post();
    ?>

		<li>
				<a href="<?php echo get_permalink(); ?>">
						<?php echo the_post_thumbnail('thumbnail'); ?>
						<div><span><?php echo the_title(); ?></span></div>
				</a>
		</li>

    <?php
		endwhile;
		endif;
		?>
		</ul>
		<?php
		wp_reset_query();
		
		die();
	}
}