<?php 
namespace Visualize\Widgets\Template;


class VisualizeCarouselTemplate {
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct(){
		add_action( 'elementor/widget/render_content', array($this, 'content_template'), 10, 2);
	}
	// thumnbail related field
	public $show_title;
	public $show_custom_field;
	public $show_thumb;
	// content related field
	public $content_limit;
	// custom field
	public $custom_field;
	/**
	* Thumbnail Markup
	* sub element of main content
	* @since 1.0.0
	* @access public
	*/
	public function post_thumbnail(){
		$output ='';
		
		$output .='<div class="visualize-meta">';
			if( $this->show_thumb == 'yes' ){
				$output .='<div class="visualize-meta-thumb">';
						$output .= get_the_post_thumbnail();
				$output .='</div>';	
			}
			$output .='<div class="visualize-meta-content">';
				if( $this->show_title == 'yes' ){
					$output .='<h5 class="entry-title">'.get_the_title().'</h5>';
				}
				if( $this->show_custom_field == 'yes' && $this->custom_field != '' ){
					$output .='<h6 class="sub-title">'.get_post_meta(get_the_id(), $this->custom_field, true).'</h6>';
				}
			$output .='</div>		    			
		</div>';

		return $output;
	}
	/**
	* Post Title Markup
	* sub element of main content
	* @since 1.0.0
	* @access public
	*/
	public function post_title(){
		return '<h4 class="entry-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h4>';
	}
	/**
	* Post Content Markup
	* sub element of main content
	* @since 1.0.0
	* @access public
	*/
	public function post_content(){
		return '<p>'.wp_trim_words(get_the_content(), $this->content_limit, '...').'</p>';
	}
	/**
	* Post Readmore Markup
	* sub element of main content
	* @since 1.0.0
	* @access public
	*/
	public function post_readmore(){
		return '<a class="visualize-carousel-read-more" href="'.esc_url(get_the_permalink()).'">'.esc_html__('Read More', 'visualize').'</a>';
	}
	/**
	* Main Content Template
	* @since 1.0.0
	* @access public
	*/
	public function content_template( $content, $widget ){
		if ( 'Visualize-Carousel' === $widget->get_name() ) {
	   		$settings = $widget->get_settings();
	   		$elements = $settings['element_order_and_visibility_list'];
	   		$activeItems = $settings['carousel_active_items'];
	   		$spacebetween = $settings['carousel_item_distance'];
	   		$this->custom_field = $settings['custom_field'];
			$arrow_button_position = $settings['arrow_button_position'];
			   
	    // Query
   		$query = new \WP_Query(
			array(
				'post_type'			=> $settings['data_source'],
				'posts_per_page' 	=> 10,
				'order'				=> $settings['order']
			)
		);
		$content .='<div class="visualize-carousel-wrap">	
			<div class="visualize-carousel owl-carousel owl-theme" data-items="'.(isset($activeItems) && $activeItems != "" ? $activeItems : '2').'" data-spacebetween="'.$spacebetween.'">';
				
					if($query->have_posts()) :
						while($query->have_posts()) : $query->the_post();
						    $content .='<div class="item">
						    	<div class="visualize-carousel-item">';
						    		foreach ($elements as $element_item) {
						    			// thumbnail related field data
						    			$this->show_custom_field = $element_item['show_custom_field'];
	   									$this->show_title = $element_item['show_title'];
	   									$this->show_thumb = $element_item['show_thumb'];
	   									// content realted field data
	   									$this->content_limit = $element_item['content_limit'];

						    			$method = $element_item['element_order_and_visibility'];
						    			if(method_exists($this, $method)){
						    				$content .=  $this->$method();
						    			}
						    		}
						    	$content .='</div>
						    </div>';
			    		endwhile;
			    		wp_reset_postdata(); 
			    	endif;
			   
			$content .='</div>
		</div>';
	   }
	   
	   print $content;
	}
}