<?php
namespace BZ_FLOWS;

define('BZFLOW_BASE_DIR', 	dirname(__FILE__) . '/');
define('BZFLOW_PRODUCT_ID',   'CFLOW');
define('BZFLOW_VERSION',   	'1.0');
define('BZFLOW_DIR_PATH', plugin_dir_path( __DIR__ ));
define('BZFLOW_PLUGIN_FILE', 'rebrand-cartflows/rebrand-cartflows.php');   //Main base file

use Cartflows_Flow_Meta;

class BZRebrandCartflowsSettings {
		
		public $pageslug 	   = 'cartflows_rebrand';
	
		static public $rebranding = array();
		static public $redefaultData = array();
	
		public function init() { 
		
			$blog_id = get_current_blog_id();
			
			self::$redefaultData = array(
				'plugin_name'       	 => '',
				'plugin_desc'       	 => '',
				'plugin_author'     	 => '',
				'plugin_uri'        	 => '',  
				
			);
        
			if ( is_plugin_active( 'blitz-rebrand-cartflows-pro/blitz-rebrand-cartflows-pro.php' ) ) {
			
			deactivate_plugins( plugin_basename(__FILE__) );
			$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'Plugin could not be activated, either deactivate the Lite version or Pro version', 'simplewlv' ). '</p>';
			die($error_message); 
		 
			return;
		}
			$this->bzflows_activation_hooks();	
		}
		   
	
		
		/**
		 * Init Hooks
		*/
		public function bzflows_activation_hooks() {
			
			global $blog_id;
			
			add_filter( 'gettext', 					array($this, 'bzflows_update_label'), 20, 3 );
			add_filter( 'all_plugins', 				array($this, 'bzflows_plugin_branding'), 10, 1 );
			add_action( 'admin_menu',				array($this, 'bzflows_menu'), 100 );
			add_action( 'admin_enqueue_scripts', 	array($this, 'bzflows_adminloadStyles'));
			add_action( 'admin_init',				array($this, 'bzflows_save_settings'));			
	        add_action( 'admin_head', 				array($this, 'bzflows_branding_scripts_styles') );
	        add_action( 'registered_post_type', 	array($this, 'bzflows_whitelabel_postype'), 10, 2 );
	        if(is_multisite()){
				if( $blog_id == 1 ) {
					switch_to_blog($blog_id);
						add_filter('screen_settings',			array($this, 'bzflows_hide_rebrand_from_menu'), 10, 2);	
					restore_current_blog();
				}
			} else {
				add_filter('screen_settings',			array($this, 'bzflows_hide_rebrand_from_menu'), 10, 2);
			}
			

		}
		
	
	  
			
		
		/**
		* Loads admin styles & scripts
		*/
		public function bzflows_adminloadStyles(){
			
			if(isset($_REQUEST['page'])){
				
				if($_REQUEST['page'] == $this->pageslug){
					
					wp_register_style( 'bzflows_css', plugins_url('assets/css/cartflows-main.css', __FILE__) );
					wp_enqueue_style( 'bzflows_css' );

					wp_enqueue_media();


					wp_register_script( 'bzflows_js', plugins_url('assets/js/cartflows-main-settings.js', __FILE__ ), '', '', true );
					wp_enqueue_script( 'bzflows_js' );
					
					
					
				}
			}
		}	
		
		
		
		
	   public function bzflows_get_rebranding() {
		   
		   global $wpdb, $blog_id;
			
			if ( ! is_array( self::$rebranding ) || empty( self::$rebranding ) ) {
			
				if(is_multisite()){
					switch_to_blog(1);
						self::$rebranding = get_option( 'cartflows_rebrand');
					restore_current_blog();
				} else {
					self::$rebranding = get_option( 'cartflows_rebrand');	
				}
						
			}

			return self::$rebranding;
		}
		
		
		
	    /**
		 * Render branding fields.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function bzflows_render_fields() {
			global $wpdb, $blog_id;
						
			if(is_multisite()){
				switch_to_blog(1);
					$branding = get_option( 'cartflows_rebrand');
				restore_current_blog();
			} else {
					$branding = get_option( 'cartflows_rebrand');	
			}
				
			include BZFLOW_BASE_DIR . 'admin/cartflows-settings-rebranding.php';
		}
		
		
				
		/**
		 * Admin Menu
		*/   
		public function bzflows_menu() {
			
			global $menu, $blog_id;
			global $submenu;	
			
		    $admin_label = __('Rebrand', 'bzflows');
			$rebranding = $this->bzflows_get_rebranding();
			
			if ( current_user_can( 'manage_options' ) ) {    

				$parent_slug = 'cartflows';
				$page_title  = __( 'Rebrand', 'bzflows' );
				$menu_title  = __( 'Rebrand', 'bzflows' );
				$capability  = 'manage_options';
				$menu_slug   = $this->pageslug;
				$callback    = array($this, 'bzflows_render');

				if( is_multisite() ) {
					if( $blog_id == 1 ) { 
						$hook = add_submenu_page(
							$parent_slug,
							$page_title,
							$menu_title,
							$capability,
							$menu_slug,
							$callback
						);
					}
				} else {
						$hook = add_submenu_page(
							$parent_slug,
							$page_title,
							$menu_title,
							$capability,
							$menu_slug,
							$callback
						);					
				}
			}	
		

			//~ echo '<pre/>';
			//~ print_r($menu);
				
			foreach($menu as $custommenusK => $custommenusv ) {  
				if( $custommenusK == '40' ) {
					if(isset($rebranding['plugin_name']) && $rebranding['plugin_name'] != '' ) {
						$menu[$custommenusK][0] = $rebranding['plugin_name']; //change menu Label
					}
						
				}
			}
			
			return $menu;
		}
		
			
		
		/**
		 * Renders to fields
		*/
		public function bzflows_render() {
			$this->bzflows_render_fields();
		}
		
	
	
		
		/**
		 * Add screen option to hide/show rebrand options
		*/
		public function bzflows_hide_rebrand_from_menu($current, $screen) {

			$rebranding = $this->bzflows_get_rebranding();

			$current .= '<fieldset class="admin_ui_menu"> <legend> Rebrand - '.$rebranding['plugin_name'].' </legend><p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>';
			
			$rsturl = $_SERVER['REQUEST_URI'];
		

			if($this->bzflows_getOption( 'rebrand_cartflows_screen_option','' )){
				
				$cartflows_screen_option = $this->bzflows_getOption( 'rebrand_cartflows_screen_option',''); 
				
				if($cartflows_screen_option=='show'){
					//$current .='It is showing now. ';
					$current .= __('Hide the "','bzflows').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzflows') .$hide;
					$current .= '<style>#adminmenu .toplevel_page_cartflows a[href="admin.php?page=cartflows_rebrand"]{display:block;}</style>';
				} else {
					//$current .='It is disabling now. ';
					$current .= __('Show the "','bzflows').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzflows') .$show;
					$current .= '<style>#adminmenu .toplevel_page_cartflows a[href="admin.php?page=cartflows_rebrand"]{display:none;}</style>';
				}		
				
			} else {
					//$current .='It is showing now. ';
					$current .= __('Hide the "','bzflows').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzflows') .$hide;
					$current .= '<style>#adminmenu .toplevel_page_cartflows a[href="admin.php?page=cartflows_rebrand"]{display:block;}</style>';
			}	

			$current .=' <br/><br/> </fieldset>' ;
			
			return $current;
		}
		
		
		
	
		/**
		 * Save the field settings
		*/
		public function bzflows_save_settings() {
			
			if ( ! isset( $_POST['flows_wl_nonce'] ) || ! wp_verify_nonce( $_POST['flows_wl_nonce'], 'flows_wl_nonce' ) ) {
				return;
			}
			if ( ! isset( $_POST['flows_submit'] ) ) {
				return;
			}
			$this->bzflows_update_branding();
		}
		
		
		
		
		/**
		 * Include scripts & styles
		*/
		public function bzflows_branding_scripts_styles() {   
			
			global $blog_id;
			
			if ( ! is_user_logged_in() ) {
				return; 
			}
			$rebranding = $this->bzflows_get_rebranding();
			
			echo '<style id="flows-wl-admin-style">';
			include BZFLOW_BASE_DIR . 'admin/cartflows-style.css.php';
			echo '</style>';
			
			echo '<script id="flows-wl-admin-script">';
			include BZFLOW_BASE_DIR . 'admin/cartflows-script.js.php';
			echo '</script>';
			
		}	
	
	

		/**
		 * Update branding
		*/
	    public function bzflows_update_branding() {
			
			global $blog_id, $wpdb;
			
			if ( ! isset($_POST['flows_wl_nonce']) ) {
				return;
			}
			
			$data = array(
			
				'plugin_name'       => isset( $_POST['flows_wl_plugin_name'] ) ? sanitize_text_field( $_POST['flows_wl_plugin_name'] ) : '',

				'plugin_desc'       => isset( $_POST['flows_wl_plugin_desc'] ) ? sanitize_text_field( $_POST['flows_wl_plugin_desc'] ) : '',
				
				'plugin_author'     => isset( $_POST['flows_wl_plugin_author'] ) ? sanitize_text_field( $_POST['flows_wl_plugin_author'] ) : '',
				
				'plugin_uri'        => isset( $_POST['flows_wl_plugin_uri'] ) ? sanitize_text_field( $_POST['flows_wl_plugin_uri'] ) : '',
				
				
					
			);

			update_option( 'cartflows_rebrand', $data );
		
		}
    
    
     
  
		
		/**
		 * change plugin meta
		*/  
        public function bzflows_plugin_branding( $all_plugins ) {
			
			
			if (  ! isset( $all_plugins['cartflows/cartflows.php'] ) ) {
				return $all_plugins;
			}

			$rebranding = $this->bzflows_get_rebranding();
			
			$all_plugins['cartflows/cartflows.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['cartflows/cartflows.php']['Name'];
			
			$all_plugins['cartflows/cartflows.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['cartflows/cartflows.php']['PluginURI'];
			
			$all_plugins['cartflows/cartflows.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['cartflows/cartflows.php']['Description'];
			
			$all_plugins['cartflows/cartflows.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['cartflows/cartflows.php']['Author'];
			
			$all_plugins['cartflows/cartflows.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['cartflows/cartflows.php']['AuthorURI'];
			
			$all_plugins['cartflows/cartflows.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['cartflows/cartflows.php']['Title'];
			
			$all_plugins['cartflows/cartflows.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['cartflows/cartflows.php']['AuthorName'];
			
			return $all_plugins;
			
		}
	
    	
	
		   
		/**
		 * update plugin label
		*/
		public function bzflows_update_label( $translated_text, $untranslated_text, $domain ) {
			
			$rebranding = $this->bzflows_get_rebranding();
			
			$bzflows_new_text = $translated_text;
			$bzflows_name = isset( $rebranding['plugin_name'] ) && ! empty( $rebranding['plugin_name'] ) ? $rebranding['plugin_name'] : '';
			$flows_title = isset( $rebranding['flows_title'] ) && ! empty( $rebranding['flows_title'] ) ? $rebranding['flows_title'] : '';
			$flows_lib_title = isset( $rebranding['flows_lib_title'] ) && ! empty( $rebranding['flows_lib_title'] ) ? $rebranding['flows_lib_title'] : '';
			$steps_lib_title = isset( $rebranding['steps_lib_title'] ) && ! empty( $rebranding['steps_lib_title'] ) ? $rebranding['steps_lib_title'] : '';
			
			if ( ! empty( $bzflows_name ) ) {
				$bzflows_new_text = str_replace( 'Cartflows', $bzflows_name, $bzflows_new_text );
				$bzflows_new_text = str_replace( 'CartFlows', $bzflows_name, $bzflows_new_text );
			}
			if ( ! empty( $flows_title ) ) {
				$bzflows_new_text = str_replace( 'Flows', $flows_title, $bzflows_new_text );
			}
			if ( ! empty( $steps_lib_title ) ) {
				$bzflows_new_text = str_replace( 'Steps Library', $steps_lib_title, $bzflows_new_text );
			}
			if ( ! empty( $flows_lib_title ) ) {
				$bzflows_new_text = str_replace( 'Flows Library', $flows_lib_title, $bzflows_new_text );
			}
			
			return $bzflows_new_text;
		}
	
	
	
		   
		/**
		 * whitelabel postype 
		*/
		public function bzflows_whitelabel_postype( $post_type, $args ) {
			
			
		    if ( 'cartflows_flow' != $post_type )
			return;

			$rebranding = $this->bzflows_get_rebranding();
   
			// Set menu icon
			$args->labels->name = $rebranding['flows_title'];
			$args->labels->singular_name = $rebranding['flows_title'];
			$args->labels->edit_item = 'Edit '.$rebranding['flows_title'];

			// Modify post type object
			global $wp_post_types;
			$wp_post_types[$post_type] = $args;
			
		}


		
		   
		/**
		 * update options
		*/
		public function bzflows_updateOption($key,$value) {
			if(is_multisite()){
				return  update_site_option($key,$value);
			}else{
				return update_option($key,$value);
			}
		}
		
		
	
		
		   
		/**
		 * get options
		*/	
		public function bzflows_getOption($key,$default=False) {
			if(is_multisite()){
				switch_to_blog(1);
				$value = get_site_option($key,$default);
				restore_current_blog();
			}else{
				$value = get_option($key,$default);
			}
			return $value;
		}
		
	
		
} //end Class
