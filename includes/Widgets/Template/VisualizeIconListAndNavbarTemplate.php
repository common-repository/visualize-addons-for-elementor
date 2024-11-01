<?php 
namespace Visualize\Widgets\Template;

use Elementor\Icons_Manager;

class VisualizeIconListAndNavbarTemplate {
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct(){
		add_action( 'elementor/widget/render_content', array($this, 'content_template'), 10, 2);
		add_filter('nav_menu_css_class', array($this, 'add_additional_class_on_li'), 1, 3);
	}
	
	public function add_additional_class_on_li($classes, $item, $args) {
	    if($args->add_li_class) {
	        $classes[] = $args->add_li_class;
	    }
	    return $classes;
	}

	
	
	
	/**
	* Main Content Template
	* @since 1.0.0
	* @access public
	*/
	public function content_template( $content, $widget ){
		if ( 'visualize-icon-list-and-nav' === $widget->get_name() ) {
	   		$settings = $widget->get_settings_for_display();

	   		$list_nav_type = $settings['list_nav_type'];
	   		$select_nav_menu = $settings['select_nav_menu'];
	   		

			$fallback_defaults = [
				'fa fa-check',
				'fa fa-times',
				'fa fa-dot-circle-o',
			];

			$widget->add_render_attribute( 'icon_list', 'class', 'elementor-icon-list-items ' );
			$widget->add_render_attribute( 'list_item', 'class', 'elementor-icon-list-item ' );

			if ( 'inline' === $settings['view'] ) {
				$widget->add_render_attribute( 'icon_list', 'class', 'elementor-inline-items ' );
				$widget->add_render_attribute( 'list_item', 'class', 'elementor-inline-item ' );
			}


			if( $list_nav_type == "navbar" ) :
                wp_nav_menu( 
                    array( 
                        'menu' => $select_nav_menu, 
                        'menu_class'     => trim($widget->get_render_attribute_string( 'icon_list' ), 'class="'),
                        'container'      => false,
                        'fallback_cb'    => ' ',
                        'add_li_class'  => 'elementor-icon-list-item'
                    ) 
                );         
			else:
			?>
			<ul <?php echo $widget->get_render_attribute_string( 'icon_list' ); ?>>
				<?php
				foreach ( $settings['icon_list'] as $index => $item ) :
					// $repeater_setting_key = $widget->get_repeater_setting_key( 'text', 'icon_list', $index );

					// $widget->add_render_attribute( $repeater_setting_key, 'class', 'elementor-icon-list-text' );

					// $widget->add_inline_editing_attributes( $repeater_setting_key );
					$migration_allowed = Icons_Manager::is_migration_allowed();
					?>
					<li class="elementor-icon-list-item" >
						<?php
						if ( ! empty( $item['link']['url'] ) ) {
							$link_key = 'link_' . $index;

							$widget->add_render_attribute( $link_key, 'href', $item['link']['url'] );

							if ( $item['link']['is_external'] ) {
								$widget->add_render_attribute( $link_key, 'target', '_blank' );
							}

							if ( $item['link']['nofollow'] ) {
								$widget->add_render_attribute( $link_key, 'rel', 'nofollow' );
							}

							echo '<a ' . $widget->get_render_attribute_string( $link_key ) . '>';
						}

						// add old default
						if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
							$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
						}

						$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
						$is_new = ! isset( $item['icon'] ) && $migration_allowed;
						if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) :
							?>
							<span class="elementor-icon-list-icon">
								<?php
								if ( $is_new || $migrated ) {
									Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
								} else { ?>
										<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
								<?php } ?>
							</span>
						<?php endif; ?>
						<span <?php echo $widget->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['text']; ?></span>
						<?php if ( ! empty( $item['link']['url'] ) ) : ?>
							</a>
						<?php endif; ?>
					</li>
					<?php
				endforeach;
				?>
			</ul>
			<?php
			endif;
	   }
	}
}