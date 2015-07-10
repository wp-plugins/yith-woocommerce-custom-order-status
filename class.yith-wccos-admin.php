<?php
/**
 * Admin class
 *
 * @author Yithemes
 * @package YITH WooCommerce Custom Order Status
 * @version 1.0.0
 */

if ( !defined( 'YITH_WCCOS' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_WCCOS_Admin' ) ) {
    /**
     * Admin class.
	 * The class manage all the admin behaviors.
     *
     * @since 1.0.0
     * @author   Leanza Francesco <leanzafrancesco@gmail.com>
     */
    class YITH_WCCOS_Admin {
		
        /**
         * Single instance of the class
         *
         * @var \YITH_WCQV_Admin
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Plugin options
         *
         * @var array
         * @access public
         * @since 1.0.0
         */
        public $options = array();

        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version = YITH_WCCOS_VERSION;

        /**
         * @var $_panel Panel Object
         */
        protected $_panel;

        /**
         * @var string Premium version landing link
         */
        protected $_premium_landing = 'https://yithemes.com/themes/plugins/yith-woocommerce-custom-order-status/';

        /**
         * @var string Quick View panel page
         */
        protected $_panel_page = 'yith_wccos_panel';

        /**
         * Various links
         *
         * @var string
         * @access public
         * @since 1.0.0
         */
        public $doc_url = 'http://yithemes.com/docs-plugins/yith-woocommerce-custom-order-status/';

        public $templates = array();

        /**
         * Returns single instance of the class
         *
         * @return \YITH_WCCOS
         * @since 1.0.0
         */
        public static function get_instance(){
            if( is_null( self::$instance ) ){
                self::$instance = new self();
            }

            return self::$instance;
        }

    	/**
		 * Constructor
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct() {

            add_action( 'admin_menu', array( $this, 'register_panel' ), 5) ;

            //Add action links
            
            add_filter( 'plugin_action_links_' . plugin_basename( YITH_WCCOS_DIR . '/' . basename( YITH_WCCOS_FILE ) ), array( $this, 'action_links') );
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

            add_action('init', array( $this, 'post_type_register'));

            add_filter('wc_order_statuses', array( $this,  'get_custom_statuses' ) );
            //add_filter('woocommerce_order_actions', array( $this, 'get_custom_statuses') );
            add_action( 'init', array( $this,  'register_my_new_order_statuses' ) );

            add_filter( 'woocommerce_admin_order_actions', array($this, 'add_submit_to_order_admin_actions'), 10, 3 );

            add_filter('manage_yith-wccos-ostatus_posts_columns' , array($this, 'order_status_columns') );
            add_action( 'manage_posts_custom_column' , array($this, 'custom_columns'), 10, 2 );

            // Premium Tabs
            add_action( 'yith_wccos_premium_tab', array( $this, 'show_premium_tab' ) );
			
		}

        /**
         * Add Icon Column in WP_List_Table of order custom statuses
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function order_status_columns( $columns ){

            $new_columns = array(
                'cb'                    => $columns['cb'],
                'yith_status_icon'      => '<span id="yith_wccos_status_icon_head tips"></span>',
            );
            unset($columns['cb']);
            return array_merge( $new_columns, $columns);
        }

        public function custom_columns( $column, $post_id ) {
            if ( $column == 'yith_status_icon' ){
                echo '<mark class="'. get_post_meta( $post_id, 'slug', true) .' tips">'. get_the_title($post_id) .'</mark>';
            }
        } 

        /**
         * Add Button Actions in Order list
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */
        function add_submit_to_order_admin_actions($actions) {
            global $post;
            global $the_order;

            $status_posts = get_posts( array( 
                                        'posts_per_page' => -1,
                                        'post_type' => 'yith-wccos-ostatus', 
                                        'post_status' => 'publish')  
                        );
            $status_names = array();

            foreach ($status_posts as $sp) {
                $status_names[] = get_post_meta( $sp->ID, 'slug', true);
            }

            if ( $the_order->has_status( $status_names ) ) {
                $actions['processing'] = array(
                    'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=processing&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
                    'name'      => __( 'Processing', 'woocommerce' ),
                    'action'    => "processing"
                );
            }

            if ( $the_order->has_status( $status_names ) ) {
                $actions['complete'] = array(
                    'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=completed&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
                    'name'      => __( 'Complete', 'woocommerce' ),
                    'action'    => "complete"
                );
            }
           
            foreach ($status_posts as $sp) {
                $meta = array(
                    'label'         => $sp->post_title,
                    'color'         => get_post_meta( $sp->ID, 'color', true),
                    'slug'          => get_post_meta( $sp->ID, 'slug', true)
                    );
                if($meta['slug'] == 'completed'){
                    $actions[ 'complete' ] = array(
                        'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=' . $meta['slug'] . '&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
                        'name'      => $meta['label'],
                        'action'    => 'complete'
                    );
                }else{
                    $actions[ $meta['slug'] ] = array(
                        'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=' . $meta['slug'] . '&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
                        'name'      => $meta['label'],
                        'action'    => $meta['slug']
                    );
                }
            }      

            return $actions;
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
         * Register Order Status custom post type with options metabox
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function post_type_register() {
            $labels = array(
                'name'                  => __('Order Status', 'yith-wccos'),
                'singular_name'         => __('Order Status', 'yith-wccos'),
                'add_new'               => __('Add Order Status', 'yith-wccos'),
                'add_new_item'          => __('New Order Status', 'yith-wccos'),
                'edit_item'             => __('Edit Order Status', 'yith-wccos'),
                'view_item'             => __('View Order Status', 'yith-wccos'),
                'not_found'             => __('Order Status not found', 'yith-wccos'),
                'not_found_in_trash'    => __('Order Status not found in trash', 'yith-wccos')
            );

            $args = array(
                'labels'                    => $labels,
                'public'                    => true,
                'show_ui'                   => true,
                'menu_position'             => 10,
                'exclude_from_search'       => true,
                'capability_type'           => 'post',
                'map_meta_cap'              => true,
                'rewrite'                   => true,
                'has_archive'               => true,
                'hierarchical'              => false,
                'show_in_nav_menus'         => false,
                'menu_icon'                 => 'dashicons-pressthis',
                'supports'                  => array('title'),
            );

            register_post_type('yith-wccos-ostatus', $args);

            $args = array(
                 'label'    => __('Status Options', 'yith-wccos'),
                 'pages'    => 'yith-wccos-ostatus',
                 'context'  => 'normal',
                 'priority' => 'high',
                 'tabs'     => apply_filters( 'yith_wccos_tabs_metabox', array(
                            'settings' => array( //tab
                                    'label'  => __( 'Settings', 'yith-wccos' ),
                                    'fields' => array(
                                        'slug' => array(
                                                'label'    => __( 'Slug', 'yith-wccos' ) ,
                                                'desc'     => __( 'Unique slug of your status', 'yith-wccos' ) ,
                                                'type'     => 'text',
                                                'private'  => false,
                                                'std'      => ''
                                           ),
                                        'color' => array(
                                                'label'    => __( 'Color', 'yith-wccos' ) ,
                                                'desc'     => __( 'Color of your status', 'yith-wccos' ) ,
                                                'type'     => 'colorpicker',
                                                'private'  => false,
                                                'std'      => '#2470FF'
                                           ),
                                    ),
                                ) 
                            )) 
            );
           $metabox = YIT_Metabox( 'yith-wccos-metabox' );
            $metabox->init( $args );
        }

        /**
         * Action Links
         *
         * add the action links to plugin admin page
         *
         * @param $links | links plugin array
         *
         * @return   mixed Array
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         * @return mixed
         * @use plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-wccos' ) . '</a>';
            if ( defined( 'YITH_WCCOS_FREE_INIT' ) ) {
                $links[] = '<a href="' . $this->_premium_landing . '" target="_blank">' . __( 'Premium Version', 'ywcm' ) . '</a>';
            }
            return $links;
        }

        /**
         * plugin_row_meta
         *
         * add the action links to plugin admin page
         *
         * @param $plugin_meta
         * @param $plugin_file
         * @param $plugin_data
         * @param $status
         *
         * @return   Array
         * @since    1.0
         * @use plugin_row_meta
         */
        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {

            if ( defined( 'YITH_WCCOS_FREE_INIT' ) && YITH_WCCOS_FREE_INIT == $plugin_file ) {
                $plugin_meta[] = '<a href="' . $this->doc_url . '" target="_blank">' . __( 'Plugin Documentation', 'yith-wccos' ) . '</a>';
            }
            return $plugin_meta;
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         * @use     /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function register_panel() {

            if ( ! empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs_free = array(
                //'settings'      => __( 'Settings', 'yith-wccos' ),
                'premium'       => __( 'Premium Version', 'yith-wccos' )
                );

            $admin_tabs = apply_filters('yith_wccos_settings_admin_tabs', $admin_tabs_free);

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Custom Order Status', 'yith-wccos' ),
                'menu_title'       => __( 'Custom Order Status', 'yith-wccos' ),
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YITH_WCCOS_DIR . '/plugin-options'
            );

            /* === Fixed: not updated theme  === */
            if( ! class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
                require_once( 'plugin-fw/lib/yit-plugin-panel-wc.php' );
            }

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
            
            add_action( 'woocommerce_admin_field_yith_wccos_upload', array( $this->_panel, 'yit_upload' ), 10, 1 );
            add_action( 'woocommerce_update_option_yith_wccos_upload', array( $this->_panel, 'yit_upload_update' ), 10, 1 );
        }

        public function admin_enqueue_scripts() {
            wp_enqueue_style( 'yith-wccos-admin-styles', YITH_WCCOS_ASSETS_URL . '/css/admin.css');
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_style('jquery-ui-style-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css');
            wp_enqueue_style('googleFontsOpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300');
            
            $screen     = get_current_screen();
            $metabox_js = defined( 'YITH_WCCOS_PREMIUM' ) ? 'metabox_options_premium.js' : 'metabox_options.js';

            if( 'yith-wccos-ostatus' == $screen->id  ) {
                wp_enqueue_script( 'yith_wccos_metabox_options', YITH_WCCOS_ASSETS_URL .'/js/' . $metabox_js, array('jquery', 'wp-color-picker'), '1.0.0', true );
            }

            wp_add_inline_style('yith-wccos-admin-styles', $this->get_status_inline_css() );
        }

        /**
         * Get Status Inline CSS
         *
         * Return the css for custom status
         *
         * @return   string
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function get_status_inline_css(){
            $css = '';
            $status_posts = get_posts( array( 
                                        'posts_per_page' => -1,
                                        'post_type' => 'yith-wccos-ostatus', 
                                        'post_status' => 'publish')  
                        );
            
            foreach ($status_posts as $sp) {
                $name = get_post_meta( $sp->ID, 'slug', true);
                $meta = array(
                    'label'         => $sp->post_title,
                    'color'         => get_post_meta( $sp->ID, 'color', true)
                    );

                $css .= '.widefat .column-order_status mark.' . $name . '::after, .yith_status_icon mark.' . $name . '::after{
                            content:"\e039";
                            color:'. $meta['color'] .';
                            font-family: WooCommerce;
                            font-weight: 400;
                            font-variant: normal;
                            text-transform: none;
                            line-height: 1;
                            margin: 0px;
                            text-indent: 0px;
                            position: absolute;
                            top: 0px;
                            left: 0px;
                            width: 100%;
                            height: 100%;
                            text-align: center;
                        }';

                $css .= '.order_actions .' . $name . '{
                            display: block;
                            text-indent: -9999px;
                            position: relative;
                            padding: 0px !important;
                            height: 2em !important;
                            width: 2em;
                        }';

                $css .= '.order_actions .' . $name . '::after {
                            content: "\e039";
                            color: '. $meta['color'] .';
                            text-indent: 0px;
                            position: absolute;
                            width: 100%;
                            height: 100%;
                            font-weight: 400;
                            text-align: center;
                            margin: 0px;
                            font-family: WooCommerce;
                            font-variant: normal;
                            text-transform: none;
                            top: 0px;
                            left: 0px;
                            line-height: 1.85;
                        }';
            }

            return $css;
        }

        /**
         * Show premium landing tab
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function show_premium_tab(){
            $landing = YITH_WCCOS_TEMPLATE_PATH . '/premium.php';
            file_exists( $landing ) && require( $landing );
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Leanza Francesco <leanzafrancesco@gmail.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri() {
            return defined( 'YITH_REFER_ID' ) ? $this->_premium_landing . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing . '?refer_id=1030585';
        }
    }
}

/**
 * Unique access to instance of YITH_WCCOS_Admin class
 *
 * @return \YITH_WCCOS_Admin
 * @since 1.0.0
 */
function YITH_WCCOS_Admin(){
    return YITH_WCCOS_Admin::get_instance();
}
?>
