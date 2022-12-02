<?php
/**
 * Plugin Name:   Display Google Reviews
 * Plugin URI:    https://www.kevinstevemaningo.com
 * Description:   Display Google Reviews
 * Version:       1.1.3
 * Author:        Kevin Steve Maningo
 * Author URI:    https://www.kevinstevemaningo.com
 * GitHub Plugin URI: kevinsteve5810/display-google-reviews
 * Primary Branch: main
 * Text Domain:   display-google-reviews
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;


add_action( 'wp_enqueue_scripts', 'style_init' );
function style_init(){
	wp_register_style( 'style', plugins_url('style.css',__FILE__ ));
	wp_enqueue_style('style');
}

require_once(plugin_dir_path( __FILE__ ) . 'admin/dashboard-settings.php');
require_once(plugin_dir_path( __FILE__ ) . 'admin/register-cpt.php');

// Add Shortcode
function get_greviews() {

	$url = 'https://maps.googleapis.com/maps/api/place/details/json?placeid=' . get_option( 'dgr_place_id') . '&key=' . get_option( 'dgr_key');
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec ($ch);
	$res        = json_decode($result,true);
	$reviews    = $res['result']['reviews'];


	$args = array(  
		'post_type' => 'greviews_display',
		'post_status' => 'publish',
	);

	$loop = new WP_Query( $args ); 
	foreach($reviews as $review_time){
		$review_timestamp_array[] = $review_time['time'];
	}
	if($loop->have_posts()){
		while ( $loop->have_posts() ) : $loop->the_post();
			$posted_review[] = get_post_meta( get_the_ID(), 'timestamp', true);
		endwhile;
		wp_reset_postdata();
	}else{
		$posted_review = NULL;
	}
	
	
	
	
	if(!empty($posted_review)){
		$review_time_not_stored = array_diff($review_timestamp_array, $posted_review);
		
		foreach($reviews as $review){
			if(in_array($review['time'], $review_time_not_stored)){
				$my_post = array(
					'post_title'    => wp_strip_all_tags($review['author_name']),
					'post_content'  => $review['text'],
					'post_status'   => 'publish',
					'post_type' 	=> 'greviews_display',
					'meta_input'	=> array(
						'timestamp' => $review['time'],
						'rating' => $review['rating'],
						'author_url' => $review['author_url'],
						'profile_photo_url' => $review['profile_photo_url'],
						'relative_time_description' => $review['relative_time_description']
					)
				);
				wp_insert_post($my_post);
			}
		}
	}else{
		foreach($reviews as $review){
			$my_post = array(
				'post_title'    => wp_strip_all_tags($review['author_name']),
				'post_content'  => $review['text'],
				'post_status'   => 'publish',
				'post_type' 	=> 'greviews_display',
				'meta_input'	=> array(
					'timestamp' => $review['time'],
					'rating' => $review['rating'],
					'author_url' => $review['author_url'],
					'profile_photo_url' => $review['profile_photo_url'],
					'relative_time_description' => $review['relative_time_description']
				)
			);
			wp_insert_post($my_post);
		}	
	}
	





	$a = '<div class="reviews-main-container dgr-cols-' . get_option( 'dgr_cols') . '">';
	if($loop->have_posts()){
		while ( $loop->have_posts() ) : $loop->the_post();
			
			if(get_post_meta( get_the_ID(), 'rating', true) >= 4){
			$a .= '<div class="review-container">';
			$a .= '<div class="review-header">';
			$a .= '<div class="author-img">';
			$a .= '<a href="' . get_post_meta( get_the_ID(), 'author_url', true) . '" target="_blank">';
			$a .= '<img src="' . get_post_meta( get_the_ID(), 'profile_photo_url', true) . '" />';
			$a .= '</a>';
			$a .= '</div>';
			$a .= '<div class="author-name">';
			$a .= '<a href="' . get_post_meta( get_the_ID(), 'author_url', true) . '" target="_blank">' . get_the_title() . '</a>';
			$a .= '<p class="time">' . get_post_meta( get_the_ID(), 'relative_time_description', true) . '</p>';
			$a .= '</div>';
			$a .= '</div>';
			$a .= '<div class="star-container">';
			$a .= '<span class="star-rating star-' . get_post_meta( get_the_ID(), 'rating', true) . '">';
			$a .= '<span class="star-img s-1"></span>';
			$a .= '<span class="star-img s-2"></span>';
			$a .= '<span class="star-img s-3"></span>';
			$a .= '<span class="star-img s-4"></span>';
			$a .= '<span class="star-img s-5"></span>';
			$a .= '</span>';
			$a .= '</div>';
			$a .= '<div class="review-content">';
			$a .= '<p>' . get_the_content() . '</p>';
			$a .= '</div>';
			$a .= '</div>';
		}
		endwhile;
		wp_reset_postdata();

	}else{
		//$posted_review = NULL;
	}
	$a .= '</div>';
	//print_r($x);
	return $a;


}
add_shortcode( 'greviews', 'get_greviews' );


function dgr_add_meta_boxes_all() {
	add_meta_box( 'pd_meta_box', 'Review Details', 'dgr_metabox_callback', [ 'greviews_display' ], 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'dgr_add_meta_boxes_all' );

function dgr_metabox_callback($post) {
	wp_nonce_field('property', 'property_nonce');

	$post_id = $post->ID;
?>

<p><?php echo 'Rating: ' . get_post_meta( $post_id, 'rating', true ); ?></p>
<p><?php echo 'Time: ' . get_post_meta( $post_id, 'timestamp', true ); ?></p>
<?php
}
