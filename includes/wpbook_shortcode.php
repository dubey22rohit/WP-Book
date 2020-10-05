<?php 
    function wpbook_shortcode( $arrtibs ){
        $arrtibs = shortcode_arrtibs(
            array(
                'ID' => '',
                'author_name' => '',
                'category' => '',
                'tag' => '',
                'publisher' => '',
                'year' => ''
            ),
            $arrtibs
        );
        
        $args = array(
                'post_type' => 'book',
                'post_status' => 'publish',
                'author' => $arrtibs['author_name'],
            );
            
            if($arrtibs['ID'] != ''){
                $args['ID'] = $arrtibs['ID'];
            }
            if($arrtibs['category'] != ''){
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'book_category',
                        'terms' => array( $arrtibs['category'] ),
                        'field' => 'name',
                        'operator' => 'IN'
                    ),
                );
            }
            if($arrtibs['tag'] != ''){
                $args[ 'tax_query' ] = array(
                    array(
                        'taxonomy' => 'book_tags',
                        'terms' => array($arrtibs['tag']),
                        'field' => 'name',
                        'operator' => 'IN'
                    ),
                );
            }
        return wpbook_shortcode_function( $args );
    }
    add_shortcode('book','wpbook_shortcode'); 
    
    function wpbook_shortcode_function( $args ){
        
        global $wpbook_settings;
        
        $shortcode_query = new WP_Query( $args );
        if ( $shortcode_query->have_posts() ) {
            while($shortcode_query->have_posts()){
                $shortcode_query->the_post();
                
                //retriving the meta info of book from database
                $wpbook_info_author_name = get_metadata( 'book', get_the_id(), 'author-name' )[0];
                $wpbook_info_price = get_metadata( 'book', get_the_id(), 'price' )[0];
                $wpbook_info_publisher = get_metadata( 'book', get_the_id(), 'publisher' )[0];
                $wpbook_info_year = get_metadata( 'book', get_the_id(), 'year' )[0];
                $wpbook_info_edition = get_metadata( 'book', get_the_id(), 'edition' )[0];
                $wpbook_info_url = get_metadata( 'book', get_the_id(), 'url' )[0];
                
                ?>
                <ul>
                <?php
                    if ( get_the_title() != ''){
                        ?>
                        <li>Title: <a href="<?php get_post_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                        <?php
                    }
                    if( $wpbook_info_price != '' ){
                        ?>
                        <li>Price: <?php echo $wpbook_info_price . ' ' . $wpbook_settings[ 'currency' ] ; ?></li>
                        <?php
                    }
                    if( $wpbook_info_author_name != ''  ){
                        ?>
                        <li>Author: <?php echo $wpbook_info_author_name; ?></li>
                        <?php
                    }
                    if( $wpbook_info_publisher != '' ){
                        ?>
                        <li>Publisher: <?php echo $wpbook_info_publisher; ?></li>
                        <?php
                    }
                    if( $wpbook_info_year != '' ){
                        ?>
                        <li>Year: <?php echo $wpbook_info_year; ?></li>
                        <?php
                    }
                    
                    if( $wpbook_info_edition != '' ){
                        ?>
                        <li>Edition: <?php echo $wpbook_info_edition; ?></li>
                        <?php
                    }
                    if( $wpbook_info_url  != '' ){
                        ?>
                        <li>Url: <?php echo $wpbook_info_url; ?></li>
                        <?php
                    }
                    if ( get_the_content() != '' ) {
                        ?>
                        <li>Content: <?php echo get_the_content(); ?></li>
                        <?php
                    }
                ?>
                </ul>
                <?php
            }
        }else {
            ?>
            <h1>No Books Found</h1>
            <?php
        }
    }