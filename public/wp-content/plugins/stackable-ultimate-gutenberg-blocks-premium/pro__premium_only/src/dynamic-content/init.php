<?php
namespace Stackable\DynamicContent;
use \Stackable\DynamicContent\Sources\Util;

class Stackable_Dynamic_Content {
    const STK_NAMESPACE = 'stackable_dynamic_content';

    function __construct() {
        // Register a render filter responsible for parsing `data-stk-dynamic` contents.
        add_filter( 'render_block', array( $this, 'render_block_dynamic_content' ) );

        // Initialize Dynamic Content API for Gutenberg.
        add_filter( 'rest_api_init', array( $this, 'initialize_api_routes' ) );
    }

    /**
     * Function used for initializing all API routes.
     *
     *   API Endpoints
     *  `stackable_dynamic_content/sources`
     *  Method: GET
     *  Description: API for fetching the list of registered sources.
     *
     *  `stackable_dynamic_content/fields/`
     *  Method: GET
     *  Description: API for fetching the list of fields by source and id.
     *  Arguments:
     *  source - selected source id
     *  id - selected id
     *
     *  `stackable_dynamic_content/search/`
     *  Method: GET
     *  Description: API for fetching the list of posts by source and search term.
     *  Arguments:
     *  source - selected source id
     *  search_term - search keyword
     *
     *  `stackable_dynamic_content/content/`
     *  Method: GET
     *  Description: API for fetching the dynamic content by data-stk-dynamic content
     *  Arguments:
     *  field_data - generated data-stk-dynamic content
     *
     *  `stackable_dynamic_content/entity/`
     *  Method: GET
     *  Description: API for fetching the entity title by source and id
     *  Arguments:
     *  source - selected source id
     *  id - selected id
     *
     * @return void
     */
    public function initialize_api_routes() {
        $this->initialize_content_api();
        $this->initialize_fields_api();
        $this->initialize_sources_api();
        $this->initialize_search_api();
        $this->initialize_entity_api();
    }

    /**
     * Function for initializing the Content API.
     *
     * @return void
     */
    public function initialize_content_api() {
        $route = 'content';
        $args = array(
            'field_data' => array(
                'required' => true,
            ),
        );

        register_rest_route(
            self::STK_NAMESPACE,
            $route,
            array(
                'callback' => array( $this, 'get_content' ),
                'permission_callback' => function() {
                    return current_user_can( 'edit_posts' );
                },
                'args' => $args,
            )
        );
    }

    /**
     * Function for initializing the Fields API.
     *
     * @return void
     */
    function initialize_fields_api() {
        $route = 'fields';
        $args = array(
            'source' => array(
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'id' => array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        register_rest_route(
            self::STK_NAMESPACE,
            $route,
            array(
                'methods' => 'GET',
                'callback' => array( $this, 'get_fields' ),
                'permission_callback' => function() {
                    return current_user_can( 'edit_posts' );
                },
                'args' => $args,
            )
        );
    }

    /**
     * Function for initializing the Sources API.
     *
     * @return void
     */
    function initialize_sources_api() {
        $route = 'sources';
        $args = array();

        register_rest_route(
            self::STK_NAMESPACE,
            $route,
            array(
                'methods' => 'GET',
                'callback' => array( $this, 'get_sources' ),
                'permission_callback' => function() {
                    return current_user_can( 'edit_posts' );
                },
                'args' => $args,
            )
        );
    }

    /**
     * Function for initializing the Search API.
     *
     * @return void
     */
    function initialize_search_api() {
        $route = 'search';
        $args = array(
            'search_term' => array(
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'source' => array(
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        register_rest_route(
            self::STK_NAMESPACE,
            $route,
            array(
                'methods' => 'GET',
                'callback' => array( $this, 'get_search' ),
                'permission_callback' => function() {
                    return current_user_can( 'edit_posts' );
                },
                'args' => $args,
            )
        );
    }

    /**
     * Function for initializing the Entity API
     *
     * @return void
     */
    function initialize_entity_api() {
        $route = 'entity';
        $args = array(
            'id' => array(
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'source' => array(
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field'
            )
        );

        register_rest_route(
            self::STK_NAMESPACE,
            $route,
            array(
                'method' => 'GET',
                'callback' => array( $this, 'get_entity' ),
                'permission_callback' => function() {
                    return current_user_can( 'edit_posts' );
                },
                'args' => $args,
            )
        );
    }

    /**
     * Function for getting the dynamic content by passed
     * field_data
     *
     * @param string $field_data
     * @param boolean if true, the content will be passed inside the editor. otherwise, in the frontend.
     * @return string content
     */
    public static function get_dynamic_content( $field_data, $is_editor_content = false ) {

        $args = Util::parse_field_data( $field_data );
        $args['id'] = apply_filters( self::STK_NAMESPACE . '/' . $args['source'] . '/custom_id', $args['id'], $is_editor_content );

        $fields_data = Stackable_Dynamic_Content::get_fields_data( $args['source'], $args['id'], $is_editor_content );

        $args['field_data'] = array();

        if ( array_key_exists( $args['field'], $fields_data ) && array_key_exists( 'data', $fields_data[ $args['field'] ] ) ) {
          $args['field_data'] = $fields_data[ $args['field'] ]['data'];
        }

        $args['is_editor_content'] = $is_editor_content;
        $output = null;
        $output = apply_filters( self::STK_NAMESPACE . '/' . $args['source'] . '/content', $output, $args, $is_editor_content );
        $output = apply_filters( self::STK_NAMESPACE . '/' . $args['source'] . '/' . $args['field'], $output, $args, $is_editor_content );
        $output = apply_filters( self::STK_NAMESPACE . '/' . $args['source'] . '/' . $args['field'] . '/' . $args['id'], $output, $args, $is_editor_content );

        if ( is_array( $output ) && array_key_exists( 'error', $output ) ) {
            return $output;
        }

        if ( $output === null ) {
            return array(
                'error' => __( 'Invalid parameters. Please try again.', 'stackable' ),
            );
        }

        return Util::is_valid_output( $output ) ? wp_kses_post( $output ) : '';
    }

    /**
     * Function for handling the API callback.
     *
     * @param WPRequest request object
     * @return string generated content
     */
    public function get_content( $request ) {
        return Stackable_Dynamic_Content::get_dynamic_content( $request->get_param( 'field_data' ), true );
    }

    /**
     * Function for getting the fields data.
     *
     * @param string $source the selected source
     * @param string $id the selected id
     * @param boolean $is_editor_content
     *
     * @return array all fields.
     */
    public static function get_fields_data( $source, $id, $is_editor_content = false ) {
        $id = apply_filters( self::STK_NAMESPACE . '/' . $source . '/custom_id', $id, $is_editor_content );
        $output = apply_filters( self::STK_NAMESPACE . '/' . $source . '/fields', array(), $id, $is_editor_content );

        return $output;
    }

    /**
     * Function for handling the API callback.
     *
     * @param WPRequest request object
     * @return array fields
     */
    function get_fields( $request ) {
        $source = $request->get_param( 'source' );
        $id = $request->get_param( 'id' );
        return Stackable_Dynamic_Content::get_fields_data( $source, $id, true );
    }

    /**
     * Function for handling the API callback.
     *
     * @return array sources
     */
    function get_sources() {
        return apply_filters( self::STK_NAMESPACE . '/sources', array() );
    }

    /**
     * Function for handling the API callback.
     *
     * @param WPRequest request object
     * @return array search result
     */
    function get_search( $request ) {
        $search_term = $request->get_param( 'search_term' );
        $source = $request->get_param( 'source' );
        $search = apply_filters( self::STK_NAMESPACE . '/' . $source . '/search', null, $search_term );

        return ( ! is_array( $search ) ) ? array() : $search;
    }

    /**
     * Function for handling the API callback.
     *
     * @param WPRequest request object
     * @return string entity title
     */
    function get_entity( $request ) {
        $source = $request->get_param( 'source' );
        $id = apply_filters( 'stackable_dynamic_content/' . $source . '/custom_id', $request->get_param( 'id' ), true );
        $entity = apply_filters( self::STK_NAMESPACE . '/' . $source . '/entity', '', $id );

        return $entity;
    }

    /**
     * Function for handling render_block filter in Frontend.
     *
     * @param string $block_content stringified block content.
     * @return string new block content.
     */
    function render_block_dynamic_content( $block_content ) {
        /**
         * Only do this when `stk-dynamic-content` string matches the block content.
         */
        if ( strpos( $block_content, 'class="stk-dynamic-content"' ) === false ) {
            return $block_content;
        }

        preg_match_all( '/<span data-stk-dynamic="(.*?(?="))"[^>]*>(.*?)<\/span[^\>]*>/', $block_content, $matches );
        $stk_dynamic_content_instances = $matches[0];
        if ( ! is_array( $stk_dynamic_content_instances ) ) {
            return $block_content;
        }
        foreach ( $stk_dynamic_content_instances as $dynamic_entry ) {
            preg_match( '/data-stk-dynamic="(.*?(?="))"/', $dynamic_entry, $route );
            $args = Util::parse_field_data( $route[1] );
            $args['id'] = apply_filters( 'stackable_dynamic_content/' . $args['source'] . '/custom_id', $args['id'], false );
            $output = Stackable_Dynamic_Content::get_dynamic_content( $route[1] );
            if ( Util::is_valid_output( $output ) ) {
                $block_content = str_replace( $dynamic_entry, $output, $block_content );
            } else {
                $block_content = str_replace( $dynamic_entry, '', $block_content );
            }
        }
        return $block_content;
    }
}

new Stackable_Dynamic_Content();
