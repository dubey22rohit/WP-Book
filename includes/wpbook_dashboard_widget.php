<?php
function wpbook_dashboard_widget(){

    wp_add_dashboard_widget(

        'wpbook_dashboard_widget',
        __('Top 5 Book category', 'wp-book'),
        'wpbook_dashboard_widget_callback',
        'dashboard',
        'side',
        'high'
        
    );

}
add_action('wp_dashboard_setup', 'wpbook_dashboard_widget');
function wpbook_dashboard_widget_callback(){
    $categories = get_terms( array( 
	        'taxonomy' => 'book_category',
	        'order' => 'DESC',
	        'number' => 5,
	        'hide_empty' => false
        ));
        if( !empty( $categories )): ?>
            <p class="book-table-head">
                <span><b><?php esc_html_e( 'Category Name', 'wp-book' ); ?></b></span>
            </p>
    <ul class="dashboard-book-display">
    <?php
            foreach($categories as $category){
            ?>  
                    <li><a href="<?php echo get_category_link( $category->term_id );?>">
                            <?php echo $category->name; ?>
                        </a>
                    </li>
                <?php
            }
            ?> 
    </ul>
    <?php else : ?>
        <p><?php esc_html_e( 'Add New Categories', 'wp-book' ); ?></p>
    <?php
    endif;
} 