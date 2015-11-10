<?php
/**
 * Frontend class
 *
 * @author Yithemes
 * @package YITH WooCommerce Custom Order Status
 * @version 1.1.1
 */

if ( ! defined( 'YITH_WCCOS' ) ) { exit; } // Exit if accessed directly

if( ! class_exists( 'YITH_WCCOS_Frontend' ) ) {
    /**
     * Frontend class.
     * The class manage all the Frontend behaviors.
     *
     * @since 1.0.0
     * @author   Leanza Francesco <leanzafrancesco@gmail.com>
     */
    class YITH_WCCOS_Frontend {

        /**
         * Single instance of the class
         *
         * @var \YITH_WCQV_Frontend
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version = YITH_WCCOS_VERSION;


        public $this_is_product = NULL;

        public $templates = array();


        /**
         * Constructor
         *
         * @access public
         * @since 1.0.0
         */
        public function __construct() {
            add_filter('wc_order_statuses', array( $this,  'get_custom_statuses' ) );
            add_action( 'init', array( $this,  'register_my_new_order_statuses' ) );
        }

        /**
         * Get custom statuses
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function get_custom_statuses( $statuses ){
            $status_posts = get_posts( array( 
                                        'posts_per_page' => -1,
                                        'post_type' => 'yith-wccos-ostatus', 
                                        'post_status' => 'publish')  
                        );
            foreach ($status_posts as $sp) {
                $statuses[ 'wc-' . get_post_meta( $sp->ID, 'slug', true) ] = $sp->post_title;
            }

            return $statuses;
        }

        /**
         * Register custom statuses
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */
        function register_my_new_order_statuses() {
            $status_posts = get_posts( array( 
                                        'posts_per_page' => -1,
                                        'post_type' => 'yith-wccos-ostatus', 
                                        'post_status' => 'publish')  
                        );
            foreach ($status_posts as $sp) {
                $label = $sp->post_title;
                $slug = 'wc-' . get_post_meta( $sp->ID, 'slug', true);

                register_post_status( $slug , array(
                    'label'                     => $label,
                    'public'                    => true,
                    'exclude_from_search'       => false,
                    'show_in_admin_all_list'    => true,
                    'show_in_admin_status_list' => true,
                    'label_count'               => _n_noop( $label.' <span class="count">(%s)</span>', $label.' <span class="count">(%s)</span>' )
                ) );
            }
        }

        /**
         * Returns single instance of the class
         *
         * @return \YITH_WCQV_Frontend
         * @since 1.0.0
         */
        public static function get_instance(){
            if( is_null( self::$instance ) ){
                self::$instance = new self();
            }

            return self::$instance;
        }
    }
}
/**
 * Unique access to instance of YITH_WCCOS_Frontend class
 *
 * @return \YITH_WCCOS_Frontend
 * @since 1.0.0
 */
function YITH_WCCOS_Frontend(){
    return YITH_WCCOS_Frontend::get_instance();
}
?>
