<?php
namespace Stackable\DynamicContent\Sources;

class Other_Posts {

    private $source_slug = 'other-posts';

    function __construct() {
        add_filter( "stackable_dynamic_content/sources", array( $this, 'initialize_source' ), 2 );
        add_filter( "stackable_dynamic_content/$this->source_slug/fields", array( $this, 'initialize_fields' ), 1, 3 );
        add_filter( "stackable_dynamic_content/$this->source_slug/fields", array( $this, 'initialize_other_fields' ), 50, 3 );
        add_filter( "stackable_dynamic_content/$this->source_slug/search", array( $this, 'search_posts' ), 1, 2 );
        add_filter( "stackable_dynamic_content/$this->source_slug/content", array( $this, 'get_content' ), 1, 2 );
        add_filter( "stackable_dynamic_content/$this->source_slug/content", array( $this, 'get_custom_field_content' ), 50, 2 );
        add_filter( "stackable_dynamic_content/$this->source_slug/entity", array( $this, 'get_entity' ), 1, 2 );
    }

    /**
     * Function for registering the source.
     *
     * @param array previous sources object.
     * @return array newly generated $sources object.
     */
    public function initialize_source( $sources ) {
        $sources[ $this->source_slug ] = array(
            'title' => __( 'Other Posts', 'stackable' ),
            'with_input_box' => true,
            'with_search' => true,
            'input_label' => __( 'Posts/Pages', 'stackable' ),
            'input_placeholder' => __( 'Search for posts/pages', 'stackable' )
        );

        return $sources;
    }

    /**
     * Function for getting the content values.
     *
     * @param any previous output
     * @param array parsed args
     * @return string generated value.
     */
    public function get_content( $output, $args ) {
        if ( Util::is_valid_output( $output ) ) {
            return $output;
        }

        switch ( $args['field'] ) {
            case 'post-title': return $this->render_post_title( $args );
            case 'post-url': return $this->render_post_url( $args );
            case 'post-id': return $this->render_post_id( $args );
            case 'post-slug': return $this->render_post_slug( $args );
            case 'post-excerpt': return $this->render_post_excerpt( $args );
            case 'post-date': return $this->render_post_date( $args );
            case 'post-date-gmt': return $this->render_post_date_gmt( $args );
            case 'post-modified': return $this->render_post_modified( $args );
            case 'post-modified-gmt': return $this->render_post_modified_gmt( $args );
            case 'post-type': return $this->render_post_type( $args );
            case 'post-status': return $this->render_post_status( $args );
            case 'author-name': return $this->render_author_name( $args );
            case 'author-id': return $this->render_author_id( $args );
            case 'author-posts-url': return $this->render_author_posts_url( $args );
            case 'author-profile-picture': return $this->render_author_profile_picture( $args );
            case 'author-posts': return $this->render_author_posts( $args );
            case 'author-first-name': return $this->render_author_first_name( $args );
            case 'author-last-name': return $this->render_author_last_name( $args );
            case 'comment-number': return $this->render_comment_number( $args );
            case 'comment-status': return $this->render_comment_status( $args );
            case 'featured-image-data': return $this->render_featured_image_data( $args );
            default: return array(
                'error' => __( 'The field type provided is not valid.', 'stackable' )
            );
        }
    }

    public static function initialize_other_fields( $output, $id ) {
        global $wpdb;
        foreach ( get_post_custom( $id ) as $key => $custom_field ) {
            if (
                ! array_key_exists( $key, $output ) &&
                substr( $key, 0, 1 ) !== '_'
            ) {
                $output[ $key ] = array(
                    'title' => $key,
                    'group' => __( 'Detected Custom Fields', 'stackable' ),
                    'data' => array(
                        'custom_field_type' => 'meta'
                    )
                );
            }
        }

        foreach ( $wpdb->get_results( 'select distinct meta_key from ' . $wpdb->prefix . 'postmeta where meta_key not like "\_%" order by meta_key' ) as $meta ) {
            if ( ! array_key_exists( $meta->meta_key, $output ) ) {
                $output[ $meta->meta_key ] = array(
                    'title' => $meta->meta_key,
                    'group' => __( 'Detected Custom Fields', 'stackable' ),
                    'data' => array(
                        'custom_field_type' => 'meta'
                    )
                );
            }
        }

        return $output;
    }

    public static function get_custom_field_content( $output, $args ) {
        if ( ! array_key_exists( 'field_data', $args ) || ! array_key_exists( 'custom_field_type', $args['field_data'] ) ) {
          return $output;
        }

        if ( $args['field_data']['custom_field_type'] === 'meta' ) {
            $value = get_post_meta( $args['id'], $args['field'], true );
			return is_array( $value ) ? json_encode( $value ) : $value;
        }

		return $output;
    }


    /**
     * Function for initializing the fields.
     *
     * @param array previous field values.
     * @return array generated fields.
     */
    public static function initialize_fields( $output ) {
        return array_merge(
            $output,
            array(
                // Post Group
                'post-title' => array(
                    'title' => __( 'Post Title', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-url' => array(
                    'title' => __( 'Post URL', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-id' => array(
                    'title' => __( 'Post ID', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-slug' => array(
                    'title' => __( 'Post Slug', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-excerpt' => array(
                    'title' => __( 'Post Excerpt', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-date' => array(
                    'title' => __( 'Post Date', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-date-gmt' => array(
                    'title' => __( 'Post Date GMT', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-modified' => array(
                    'title' => __( 'Post Modified', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-modified-gmt' => array(
                    'title' => __( 'Post Modified GMT', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-type' => array(
                    'title' => __( 'Post Type', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                'post-status' => array(
                    'title' => __( 'Post Status', 'stackable' ),
                    'group' => __( 'Post', 'stackable' ),
                ),
                // Author Group
                'author-name' => array(
                    'title' => __( 'Author Name', 'stackable' ),
                    'group' => __( 'Author', 'stackable' ),
                ),
                'author-id' => array(
                    'title' => __( 'Author ID', 'stackable' ),
                    'group' => __( 'Author', 'stackable' ),
                ),
                'author-posts-url' => array(
                    'title' => __( 'Author Posts URL', 'stackable' ),
                    'group' => __( 'Author', 'stackable' ),
                ),
                'author-profile-picture' => array(
                    'title' => __( 'Author Profile Picture URL', 'stackable' ),
                    'group' => __( 'Author', 'stackable' ),
                ),
                'author-posts' => array(
                    'title' => __( 'Author Posts', 'stackable' ),
                    'group' => __( 'Author', 'stackable' ),
                ),
                'author-first-name' => array(
                    'title' => __( 'Author First Name', 'stackable' ),
                    'group' => __( 'Author', 'stackable' ),
                ),
                'author-last-name' => array(
                    'title' => __( 'Author Last Name', 'stackable' ),
                    'group' => __( 'Author', 'stackable' ),
                ),
                // Comment Group
                'comment-number' => array(
                    'title' => __( 'Comment Number', 'stackable' ),
                    'group' => __( 'Comment', 'stackable' ),
                ),
                'comment-status' => array(
                    'title' => __( 'Comment Status', 'stackable' ),
                    'group' => __( 'Comment', 'stackable' ),
                ),
                // Media Group
                'featured-image-data' => array(
                    'title' => __( 'Featured Image URL', 'stackable' ),
                    'group' => __( 'Media', 'stackable' ),
                ),
            )
        );
    }

    /**
     * Function for displaying the post-title content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_title( $args ) {
        $output = get_the_title( $args['id'] );

        if ( ! array_key_exists( 'with_link', $args['args'] ) || $args['args']['with_link'] === 'false' ) {
            return $output;
        }

        $href = Other_Posts::get_post_url( $args['id'] );
        $new_tab = array_key_exists( 'new_tab', $args['args'] ) && $args['args']['new_tab'];

        if ( empty( $output ) ) {
            $output = $href;
        }

        return Util::make_output_link( $output, $href, $new_tab );
    }

    /**
     * Function for getting the post URL.
     *
     * @param string post id
     * @return string post url
     */
    public static function get_post_url( $id ) {
        return get_permalink( $id );
    }

    /**
     * Function for displaying the post-url content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_url( $args ) {
        $output = Other_Posts::get_post_url( $args['id'] );

        if ( ! array_key_exists( 'with_link', $args['args'] ) || $args['args']['with_link'] === 'false' ) {
            return $output;
        }

        if ( ! array_key_exists( 'text', $args['args'] ) || empty( $args['args']['text'] ) ) {
            return array(
                'error' => __( 'Text input is empty', 'stackable' )
            );
        }

        $href = $output;
        $output = $args['args']['text'];
        $new_tab = array_key_exists( 'new_tab', $args['args'] ) && $args['args']['new_tab'];
        return Util::make_output_link( $output, $href, $new_tab );
    }

    /**
     * Function for displaying the post-id content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_id( $args ) {
        return $args['id'];
    }

    /**
     * Function for displaying the post-id content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_slug( $args ) {
        return get_post_field( 'post_name', $args['id'] );
    }

    /**
     * Function for displaying the post-excerpt content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_excerpt( $args ) {
        $post = new \WP_Post( get_post( $args['id'] ) );
        if ( ! $post ) {
            return array(
                'error' => __( 'Post not found.', 'stackable' )
            );
        }

        $excerpt = stackable_get_excerpt( $args['id'], $post->to_array() );

        if ( ! empty( $excerpt ) ) {
            $excerpt = explode( ' ', $excerpt );
            $trim_to_length = ( array_key_exists( 'length', $args['args'] )  ) ? ( int ) $args['args']['length'] : 55;
            if ( count( $excerpt ) > $trim_to_length ) {
                $excerpt = implode( ' ', array_slice( $excerpt, 0, $trim_to_length ) ) . '...';
            } else {
                $excerpt = implode( ' ', $excerpt );
            }
        }

        return strip_tags( $excerpt );
    }

    /**
     * Function for displaying the post-date content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_date( $args ) {
        if ( array_key_exists( 'format', $args['args'] ) ) {
            if ( $args['args']['format'] === 'custom' && array_key_exists( 'custom_format', $args['args'] ) ) {
                return Util::format_date( get_post_field( 'post_date', $args['id'] ), $args['args']['custom_format'] );
            }
            return Util::format_date( get_post_field( 'post_date', $args['id'] ), $args['args']['format'] );
        }
        return get_post_field( 'post_date', $args['id'] );
    }

    /**
     * Function for displaying the post-date-gmt content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_date_gmt( $args ) {
        if ( array_key_exists( 'format', $args['args'] ) ) {
            if ( $args['args']['format'] === 'custom' && array_key_exists( 'custom_format', $args['args'] ) ) {
                return Util::format_date( get_post_field( 'post_date', $args['id'] ), $args['args']['custom_format'] );
            }
            return Util::format_date( get_post_field( 'post_date_gmt', $args['id'] ), $args['args']['format'] );
        }
        return get_post_field( 'post_date_gmt', $args['id'] );
    }

    /**
     * Function for displaying the post-modified content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_modified( $args ) {
        if ( array_key_exists( 'format', $args['args'] ) ) {
            if ( $args['args']['format'] === 'custom' && array_key_exists( 'custom_format', $args['args'] ) ) {
                return Util::format_date( get_post_field( 'post_date', $args['id'] ), $args['args']['custom_format'] );
            }
            return Util::format_date( get_post_field( 'post_modified', $args['id'] ), $args['args']['format'] );
        }
        return get_post_field( 'post_modified', $args['id'] );
    }

    /**
     * Function for displaying the post-modified-gmt content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_modified_gmt( $args ) {
        if ( array_key_exists( 'format', $args['args'] ) ) {
            if ( $args['args']['format'] === 'custom' && array_key_exists( 'custom_format', $args['args'] ) ) {
                return Util::format_date( get_post_field( 'post_date', $args['id'] ), $args['args']['custom_format'] );
            }
            return Util::format_date( get_post_field( 'post_modified_gmt', $args['id'] ), $args['args']['format'] );
        }
        return get_post_field( 'post_modified_gmt', $args['id'] );
    }

    /**
     * Function for displaying the post-type content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_type( $args ) {
        return wp_kses_post( get_post_field( 'post_type', $args['id'] ) );
    }

    /**
     * Function for displaying the post-type content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_post_status( $args ) {
        return wp_kses_post( get_post_field( 'post_status', $args['id'] ) );
    }

    /**
     * Function for displaying the author-name content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_author_name( $args ) {
        $author_id = get_post_field( 'post_author', $args['id'] );
        return wp_kses_post( get_the_author_meta( 'display_name' , $author_id ) );
    }

    /**
     * Function for displaying the author-id content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_author_id( $args ) {
        return wp_kses_post( get_post_field( 'post_author', $args['id'] ) );
    }

    /**
     * Function for getting the author posts URL
     *
     * @param string author ID
     * @return string author posts url
     */
    public static function get_author_posts_url( $author_id ) {
        return get_author_posts_url( $author_id );
    }
    /**
     * Function for displaying the author-posts-url content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_author_posts_url( $args ) {
        $author_id = get_post_field( 'post_author', $args['id'] );

        $output = Other_Posts::get_author_posts_url( $author_id );

        if ( ! array_key_exists( 'with_link', $args['args'] ) || $args['args']['with_link'] === 'false' ) {
            return $output;
        }

        if ( ! array_key_exists( 'text', $args['args'] ) || empty( $args['args']['text'] ) ) {
            return array(
                'error' => __( 'Text input is empty', 'stackable' )
            );
        }

        $output = $args['args']['text'];
        $href = Other_Posts::get_author_posts_url( $author_id );
        $new_tab = array_key_exists( 'new_tab', $args['args'] ) && $args['args']['new_tab'];
        return Util::make_output_link( $output, $href, $new_tab );
    }

    /**
     * Function for displaying the author-profile-picture content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_author_profile_picture( $args ) {
        $author_id = get_post_field( 'post_author', $args['id'] );
        return get_avatar_url( $author_id );
    }

    /**
     * Function for displaying the author-posts content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_author_posts( $args ) {
        $author_id = get_post_field( 'post_author', $args['id'] );
        return wp_kses_post( count_user_posts( $author_id ) );
    }

    /**
     * Function for displaying the author-first-name content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_author_first_name( $args ) {
        $author_id = get_post_field( 'post_author', $args['id'] );
        return wp_kses_post( get_the_author_meta( 'first_name', $author_id ) );
    }

    /**
     * Function for displaying the author-last-name content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_author_last_name( $args ) {
        $author_id = get_post_field( 'post_author', $args['id'] );
        return wp_kses_post( get_the_author_meta( 'last_name', $author_id ) );
    }

    /**
     * Function for displaying the comment-number content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_comment_number( $args ) {
        $comments_number = get_comments_number( $args['id'] );
        return wp_kses_post( number_format_i18n( $comments_number ) );
    }

    /**
     * Function for displaying the comment-status content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_comment_status( $args ) {
        return wp_kses_post( get_post_field( 'comment_status', $args['id'] ) );
    }

    /**
     * Function for displaying the featured-image-data content.
     *
     * @param array parsed args
     * @return string generated output
     */
    public static function render_featured_image_data( $args ) {
        $thumbnail_id = get_post_thumbnail_id( $args['id'] );
        if ( ! $thumbnail_id ) {
            return '';
        }

        $attachment = get_post( $thumbnail_id );
        $size = 'full';

        if ( array_key_exists( 'size', $args['args'] ) ) {
            $size = $args['args']['size'];
        }

        $value = wp_get_attachment_image_src( $attachment->ID, $size );
        return ! empty( $value[0] ) ? $value[0] : '';
    }

    /**
     * Function for handling the search post field.
     *
     * @param array previous output value
     * @param string keyword
     * @return array post data object
     */
    function search_posts( $output, $s ) {
        $args = array(
            'posts_per_page' => 5,
            's' => $s
        );

        $the_query = new \WP_Query( $args );

        $posts = array();
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) : $the_query->the_post();
                $posts[ get_the_ID() ] = get_the_title() . ' (#' . get_the_ID() . ')';
            endwhile;
        }

        wp_reset_postdata();
        return $posts;
    }

    /**
     * Function for handling a single entity title.
     * Mainly used for displaying the title
     * of the entity on load.
     *
     * @param string previous output value
     * @param string id
     * @return array entity info.
     */
    public static function get_entity( $output, $id ) {
        return get_the_title( $id ) . ' (#' . $id . ')';
    }
}

new Other_Posts();
