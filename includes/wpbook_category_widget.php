<?php 

class Wpbook_Category_Widget extends WP_Widget {
    public function __construct(){

        $Category_Options = array(
            'classname' => 'wpbook-category-widget',
            'description' => __('A Widget to display the selected category\'s books', 'wp-book'),
        );
        parent::__construct('wpbook_category', __('Book Category', 'wp-book'), $Category_Options);

    }

    function CategoryForm($inst) {
        $title 		= esc_attr($inst['title']);
	    $number	= esc_attr($inst['number']);
	    $taxonomy	= esc_attr($inst['taxonomy']);
	    ?>
	    <p>
	        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title : '); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of categories to display : '); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
	    </p>
	    <p>	
		    <label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Choose the Taxonomy to display : '); ?></label> 
		    <select  class="widefat" name="<?php echo $this->get_field_name('taxonomy'); ?>" id="<?php echo $this->get_field_id('taxonomy'); ?>" />
			    <?php
			    $taxonomies = get_taxonomies(array('public'=>true), 'names');
			    foreach ($taxonomies as $taxonomy) {
				    echo '<option id="' . $taxonomy . '"', $taxonomy == $taxonomy ? ' selected="selected"' : '', '>', $taxonomy, '</option>';
			    }
			    ?>
		    </select>		
	    </p>
	    <?php
}
    function update($new_inst, $old_inst) {
	    $inst = $old_inst;
	    $inst['title'] = strip_tags($new_inst['title']);
	    $inst['number'] = strip_tags($new_inst['number']);
	    $inst['taxonomy'] = $new_inst['taxonomy'];
	    return $inst;
    }
    function widget($args, $inst) {
	    extract( $args );
	    $title 		= apply_filters('widget_title', $inst['title']);
	    $number 	= $inst['number'];
	    $taxonomy 	= $inst['taxonomy'];
			
	    $args = array(
		    'number' 	=> $number,
		    'taxonomy'	=> $taxonomy
	    );
	    $Categories = get_categories($args);
	    ?>
		<?php echo $before_widget; ?>
	    <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
		<ul>
		<?php foreach($Categories as $Category) { ?>
		<li><a href="<?php echo get_term_link($Category->slug, $taxonomy); ?>" title="<?php sprintf( __( "View all posts in %s" ), $Category->name ); ?>"><?php echo $Category->name; ?></a></li>
		<?php } ?>
		</ul>
    	<?php echo $after_widget; ?>
	<?php
    }

}
add_action('widgets_init', function(){
    register_widget('Wpbook_Category_Widget');
}); 