<?php 

class Wpbook_Category_Widget extends WP_Widget {
    public function __construct() {

        $category_options = array(
            'classname' => 'wpbook-category-widget',
            'description' => __('A Widget to display the selected category\'s books', 'wp-book'),
        );
        parent::__construct('wpbook_category', __('Book Category', 'wp-book'), $category_options);

    }

    public function CategoryForm ( $inst ) {
        $title 		= esc_attr($inst['title']);
	    $number	= esc_attr($inst['number']);
	    $taxonomy	= esc_attr($inst['taxonomy']);
	    ?>
	    <p>
	        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title : '); ?></label>
	        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	    </p>
	    <p>
	        <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of categories to display : '); ?></label>
	        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
	    </p>
	    <p>	
		    <label for="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>"><?php esc_html_e('Choose the Taxonomy to display : '); ?></label> 
		    <select  class="widefat" name="<?php echo esc_attr($this->get_field_name('taxonomy')); ?>" id="<?php echo esc_attr( $this->get_field_id('taxonomy')); ?>" />
			    <?php
			    $taxonomies = get_taxonomies(array('public'=>true), 'names');
			    foreach ($taxonomies as $taxonomy) {
				    echo '<option id="' . $taxonomy . '"', $taxonomy == $taxonomy ? ' selected="selected"' : '', '>', esc_attr($taxonomy), '</option>';
			    }
			    ?>
		    </select>		
	    </p>
	    <?php
}
    public function update ( $new_inst, $old_inst) {
	    $inst = $old_inst;
	    $inst['title'] = strip_tags($new_inst['title']);
	    $inst['number'] = strip_tags($new_inst['number']);
	    $inst['taxonomy'] = $new_inst['taxonomy'];
	    return $inst;
    }
    public function widget ( $args, $inst) {
	    extract( $args );//phpcs:ignore
	    $title 		= apply_filters('widget_title', $inst['title']);
	    $number 	= $inst['number'];
	    $taxonomy 	= $inst['taxonomy'];
			
	    $args = array(
		    'number' 	=> $number,
		    'taxonomy'	=> $taxonomy
	    );
	    $categories = get_categories($args);
	    ?>
		<?php echo esc_attr($before_widget); ?>
	    <?php if ( $title ) { 
			echo esc_attr($before_title) . $title . $after_title; } ?>
		<ul>
		<?php foreach ($categories as $category) { ?>
		<li><a href="<?php echo esc_attr(get_term_link($category->slug, $taxonomy)); ?>" title="<?php sprintf( __( 'View all posts in %s' ), $category->name ); ?>"><?php echo $category->name; ?></a></li>
		<?php } ?>
		</ul>
    	<?php echo esc_attr($after_widget); ?>
	<?php
    }

}
add_action('widgets_init', function() {
    register_widget('Wpbook_Category_Widget');
}); 