<?php 
namespace Visualize\Widgets\Template;



class VisualizeButtonTemplate {
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct(){
		add_action( 'elementor/widget/render_content', array($this, 'content_template'), 10, 2);
	}
	

	
	
	
	/**
	* Main Content Template
	* @since 1.0.0
	* @access public
	*/
	public function content_template( $content, $widget ){
		if ( 'Visualize-Button' === $widget->get_name() ) {
	   		$settings = $widget->get_settings();
	   		$icon = $settings['button_selected_icon']['value'];
	   		$iconPosition = $settings['button_icon_align'];

	   		// button attribute
	   		$widget->add_render_attribute( 'visualize_button', [
	   			'class' => 'visualize-button',
				'href'	=> esc_attr($settings['button_link']['url'] ),
			]);

			if( $settings['button_link']['is_external'] ) {
				$widget->add_render_attribute( 'visualize_button', 'target', '_blank' );
			}
			
			if( $settings['button_link']['nofollow'] ) {
				$widget->add_render_attribute( 'visualize_button', 'rel', 'nofollow' );
			}
			
			if ( ! empty( $settings['button_css_id'] ) ) {
				$widget->add_render_attribute( 'visualize_button', 'id', $settings['button_css_id'] );
			}

			if ( $settings['hover_animation'] ) {
				$widget->add_render_attribute( 'visualize_button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
			}

			// button inner class name
			$widget->add_render_attribute( [
				'icon-align' => [
					'class' => [
						'visualize-button-icon',
						'visualize-align-icon-' . $iconPosition,
					],
				],
				'text' => [
					'class' => 'visualize-button-text',
				],
			] );
			?>
				<a <?php echo $widget->get_render_attribute_string( 'visualize_button' ); ?>>
					<?php 
						// icon for left and top
						if($iconPosition == 'left' || $iconPosition == 'top') :
					?>
					<span <?php echo $widget->get_render_attribute_string( 'icon-align' ); ?>>
						<i class="<?php print $icon; ?>"></i>
					</span>
					<?php 
						endif;
					?>

					<span class="visualize-button-text"><?php print (isset($settings['button_text']) ? $settings['button_text'] : ''); ?></span>	

					<?php 
					// icon for bottom and right
						if($iconPosition == 'right' || $iconPosition == 'bottom') :
					?>
					<span <?php echo $widget->get_render_attribute_string( 'icon-align' ); ?>>
						<i class="<?php print $icon; ?>"></i>
					</span>
					<?php 
						endif;
					?>	
				</a>
			<?php
	   }
	}
}