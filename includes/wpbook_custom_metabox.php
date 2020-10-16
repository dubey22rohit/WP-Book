<?php 
function wpbook_custom_metabox() {
    add_meta_box(
        'wpbook_meta_box',
        __('Book Information', 'wp-book'),
        'wpbook_meta_callback',
        'book'
    );

}

add_action( 'add_meta_boxes', 'wpbook_custom_metabox' );

function wpbook_meta_callback( $post ) {
    $wpbook_author_name = get_metadata( 'book', $post->ID, 'author-name',$single=true);
    $wpbook_price = get_metadata( 'book', $post->ID, 'price',$single=true);
    $wpbook_publisher = get_metadata( 'book', $post->ID, 'publisher',$single=true);
    $wpbook_year = get_metadata( 'book', $post->ID, 'year',$single=true);
    $wpbook_edition = get_metadata( 'book', $post->ID, 'edition',$single=true);
    $wpbook_url = get_metadata( 'book', $post->ID, 'url',$single=true);
    ?>
    <div>
        <div class="meta-row">
            <div class="meta-th">
                <label for="author_name" class="wpbook-row-title">Author Name : </label>
            </div>
            <div class="meta-td"> 
                <input type="text" name="author_name" id="author-name" value="<?php echo esc_attr( $wpbook_author_name ); ?>"/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="price" class="wpbook-row-title">Price : </label>
            </div>
            <div class="meta-td">
                <input type="number" name="price" id="price" value="<?php echo esc_attr( $wpbook_price ); ?>"/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="publisher" class="wpbook-row-title">Publisher : </label>
            </div>
            <div class="meta-td">
                <input type="text" name="publisher" id="publisher" value="<?php echo esc_attr( $wpbook_publisher ); ?>"/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="year" class="wpbook-row-title">Year : </label>
            </div>
            <div class="meta-td">
                <input type="number" name="year" id="year" value="<?php echo esc_attr( $wpbook_year ); ?>"/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="edition" class="wpbook-row-title">Edition : </label>
            </div>
            <div class="meta-td">
                <input type="text" name="edition" id="edition" value="<?php echo esc_attr( $wpbook_edition ); ?>"/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="url" class="wpbook-row-title">URL : </label>
            </div>
            <div class="meta-td">
                <input type="url" name="url" id="url" value="<?php echo esc_attr( $wpbook_url ); ?>"/>
            </div>
        </div>
    <?php wp_nonce_field( 'wpbook_custom_book_info', 'wpbook_book_info' ); ?>
    </div>
    <?php
}
function wpbook_custom_book_info( $post_id ) {
    
    if ( ! isset( $_POST['wpbook_book_info'] ) || ! wp_verify_nonce( $_POST['wpbook_book_info'], 'wpbook_custom_book_info' ) ) {
        return $post_id;
    }

    if ( isset( $_POST['author_name'] )) {
        update_metadata('book', $post_id, 'author-name', sanitize_text_field($_POST['author_name']) );
    }

    if ( isset( $_POST['price'] ) ) {
        update_metadata('book', $post_id, 'price', sanitize_text_field($_POST['price']) );
    }

    if ( isset( $_POST['publisher'] )) {
        update_metadata('book', $post_id, 'publisher', sanitize_text_field($_POST['publisher']) );
    }

    if ( isset( $_POST['year'] )) {
        update_metadata('book', $post_id, 'year', sanitize_text_field($_POST['year']) );
    } 

    if ( isset( $_POST['edition'] )) {
        update_metadata('book', $post_id, 'edition', sanitize_text_field($_POST['edition']) );
    }

    if ( isset( $_POST['url'] ) ) {
        update_metadata('book', $post_id, 'url', sanitize_text_field($_POST['url']) );
    }
    
}
add_action( 'save_post', 'wpbook_custom_book_info');
?>