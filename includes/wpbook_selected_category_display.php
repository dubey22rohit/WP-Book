<?php
class Wpbook_Book_Display_Widget extends WP_Widget {
    public function __construct() {
        $display_options = array(
            'classname' => 'wpbook-book-widget', 
            'description' => __( 'Custom Widget To Display Books of Selected Category In The Sidebar.', 'wp-book' ),
        );
        parent::__construct( 'wpbook_book', __('Books', 'wp-book'), $display_options );
    }
    public function form( $inst ) {
        if ( isset( $inst[ 'title' ] ) ) {
            $title = $inst[ 'title' ];
        } else {
            $title = 'Selected Books';
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title : ' ); ?>:</label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <?php
        $categories = get_terms( array(
            'taxonomy'   => 'book_category',
            'hide_empty' => false,
        ) );
        ?>
        
        <p><?php esc_html_e('Select Categories To Display', 'wp-book' ); ?>: </p>
        
        <?php
	        if ( isset( $inst[ 'selected_categories' ] ) ) {
                $selected_categories = $inst[ 'selected_categories' ];
            } else {
                $selected_categories = array();
            }
	    ?>
	<ul>
	<?php foreach ( $categories as $category ) { ?>

		<li>
            <input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'selected_categories' )); ?>[<?php echo esc_attr($category->term_id); ?>]" 
            name="<?php echo esc_attr( $this->get_field_name( 'selected_categories' ) ); ?>[]" value="<?php echo esc_attr($category->term_id); ?>"  <?php checked( ( in_array( $category->term_id, $selected_categories ) ) ? $category->term_id : '', $category->term_id ); ?> />
            <label for="<?php echo esc_attr($this->get_field_id( 'selected_categories' )); ?>[<?php echo esc_attr($category->term_id); ?>]"><?php echo esc_attr($category->name); ?> (<?php echo esc_attr($category->count); ?>)</label>
	    </li>

	<?php } ?>
	</ul>
        <?php
    }
    public function update( $new_inst, $old_inst ) {
        $inst = array();
        $inst['title'] = (!empty( $new_inst[ 'title' ])) ? strip_tags( $new_inst[ 'title' ] ) : '';
        $selected_categories = (! empty( $new_inst[ 'selected_categories' ] ) ) ? (array) $new_inst['selected_categories'] : array();
        $inst[ 'selected_categories' ] = array_map( 'sanitize_text_field', $selected_categories );
        return $inst;
    }
    public function widget( $args, $inst ) {
        echo esc_attr($args[ 'before_widget' ]);?>
        <h2 class="widget-title">
                <?php
                    if ( isset( $inst[ 'title' ] ) ) {
                        $title = $inst[ 'title' ];
                    } else {
                        $title = 'Book';
                    }
                    echo esc_attr($title);
                ?>
        </h2>

        <?php
        if ( ! empty( $inst[ 'selected_categories' ] ) && is_array( $inst[ 'selected_categories' ] ) ) { 
            global $num_books; 
            if ( $num_books[ 'num_of_books' ] == '0' ) {
                return;
            }
            $display_posts = get_posts( array( 
                'post_type'   => 'book',
                'post_status' => 'publish',
                'numberposts' => $num_books[ 'num_of_books' ],
                'tax_query'   => array(
                    array(
                      'taxonomy' => 'book_category',
                      'field'    => 'term_id', 
                      'terms'    => $inst[ 'selected_categories' ],
                    )
                  )
            ) );
        ?>
            <ul>
                <?php foreach ( $display_posts as $display_post ) { ?>
                    <li><a href="<?php echo esc_attr(get_permalink( $display_post->ID )); ?>">
                            <?php echo esc_attr($display_post->post_title); ?>
                        </a>
                    </li>		
                <?php } ?>
            </ul>
            <?php 
            
        } else {
            echo esc_html__( 'No Selected Posts!', 'text_domain' );	
        }
        echo $args[ 'after_widget' ];//phpcs:ignore
    }
}
add_action('widgets_init', function() {
    register_widget('Wpbook_Book_Display_Widget');
});
    
    