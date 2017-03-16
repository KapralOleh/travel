<?php
/*
	Extension Name: Highgrade OneClickInstall
	Plugin URI: http://highgradelab.com/
	Author: HighGrade
	Author URI: https://highgradelab.com
	Version: 2.1.0
	Description: It executes the OneClick install of HGR Demos configured in import_config.php
	Text Domain: hgr

	If accesed directly, exit
*/
if ( !defined('ABSPATH') ) exit;




if( !class_exists('HGR_OCI') ) {

	class HGR_OCI {
		
		var $this_uri;
		var $this_dir;
		var $configFile;
		
		/*
		*	Constructor
		*/
		public function __construct(){	
			
			// This uri & dir
			$this->this_uri			=	get_template_directory_uri();
			$this->this_dir			=	get_template_directory('/highgrade/hgr_oci/');
			
			// Include necesarry files
			$this->configFile		=	include get_template_directory() . '/highgrade/hgr_oci/import_config.php';
			
			// WP-Admin Menu
			add_action('admin_menu', array($this,'oci_menu'));
	
			// Add necesary backend JS
			add_action('admin_enqueue_scripts', array($this,'load_backends') );
			
			// Actions for the ajax call
			add_action( 'wp_ajax_install_demo', array($this,'install_demo') );
			add_action( 'wp_ajax_nopriv_install_demo', array($this,'install_demo') );		
		}
		
		
		/*
		*	WP-ADMIN Menu for importer
		*/
		function oci_menu() {
			add_theme_page( 'OneClick Demo Install', 'OneClick Demo', 'manage_options', 'hgr_oci_install', array($this,'display_demos') );
		}
		
		
		/*
		*	Display the available demos
		*/
		function display_demos() {
				$i = 1;
				
				$theme = wp_get_theme();
				
				$return ='<div class="wrap"><h2>'.esc_html( $theme->get( 'Name' ) ).' OneClick Demo Setup</h2>';
				
				if( is_array( $this->configFile ) && !is_null( $this->configFile ) ){
					$return .='<p><div class="import_message">Click on the desired demo to install demo content and theme options setup.</div></p>';
					$return .='<p><input type="checkbox" name="resetall" id="resetall" value="true"> Reset WordPress Database? This will erase all content (posts, pages, etc) and install demo content.<p>';
					$return .='<div class="demos_container" style="max-width:90%;margin-right:auto;margin-left:auto;">';
					
					// Loop through demos
					foreach( $this->configFile as $demo => $demoContent ) {
						$return .='<div class="demo_container" style="float:left;margin:20px;text-align:center;max-width:315px;background-color:#fff">
							<img src="' . esc_url( trailingslashit( get_template_directory_uri() ) . 'highgrade/hgr_oci/gfx/' . $demoContent['demoImg'] ) . '" style="width:100%; height:auto;"><br>
							<h4>'.sprintf("%02d", $i++).'. ' . esc_html( $demoContent['demoName'] ).'</h4>
							<a href="' . esc_url( $demoContent['liveURL'] ) . '" target="_blank">
							<button style="margin:5px;background-color:#fff;border:1px solid #dedede;cursor:pointer;color:#000;padding:10px;width:143px;">PREVIEW</button>
							</a> 
							<button class="bootstrapguru_import" data-install="' . esc_attr( $demo ) . '" data-reset="false" style="margin:5px;background-color:#5194ec;border:0;cursor:pointer;color:#fff;padding:10px;width:143px;">INSTALL</button>
							</div>';
					}
				
					$return .='</div>';
				} else {
					$return .='<p><div class="import_message">It looks like the config file for the demos is missing or conatins errors!. Demo install can\'t go futher!</div><p>';
				}
				$return .='</div>';
				
				echo $return;
				
		}
		
		
		/*
		*	Do the install on ajax call
		*/
		function install_demo() {
			global $wpdb;
			$return = '';
			
			// Get the demo content from the right file
			$demo = $this->configFile[$_POST['demo']];

			
			
			// Should we reset database?
			if( isset($_POST['datareset']) && $_POST['datareset'] == 'true' ){
				if (current_user_can('manage_options'))  {
					// if demo == allpages we ignore database reset
					if( $demo['xmlContentFile'] != 'allpages.xml' ) {
						echo $this->database_reset();
					}
				}
			}
			
			
			// Import XML content
			if (current_user_can('manage_options'))  {
				$this->importDemoContent($demo['xmlContentFile']);
			}
			
			
			
			
			// Setup theme options
			if (current_user_can('manage_options'))  {
				// if demo == allpages we ignore theme options
				if( $demo['xmlContentFile'] != 'allpages.xml' ) {
					$this->importThemeOptions($demo['themeOptionsFile']);
				}
			}

			
			
			// Import Slider Revolution slides
			if( $demo['revSliderZipFiles'] && is_array($demo['revSliderZipFiles']) ) {
				$this->importSliderRev($demo['revSliderZipFiles']);
			}
			
			
			// Import Essential Grid
			if( $demo['essentialGridFile'] ) {
				$this->importEssGrid($demo['essentialGridFile']);
			}
			
			
			
			// this is required to return a proper result
			die();
		}
		
		
		/*
		*	Reset the database, if the case
		*/
		function database_reset() {
			global $wpdb;
			$options = array(
				'offset'          => 0,
				'orderby'         => 'post_date',
				'order'           => 'DESC',
				'post_type'       => 'post',
				'post_status'     => 'publish'
			);
	
			$statuses = array ( 'publish', 'future', 'draft', 'pending', 'private', 'trash', 'inherit', 'auto-draft', 'scheduled' );
			$types = array(	'post',
							'page',
							'attachment',
							'nav_menu_item',
							'wpcf7_contact_form',
							'hgr_portfolio',
							'hgr_team',
							'hgr_testimonials',
							'essential_grid',
							'product',
							'hgr_megamenu',
							'hgr_slide_in_panel',
							'hgr_popup',
							'hgr_info_bars',
						);
			
			// delete posts
			foreach( $types as $type ) {
				foreach( $statuses as $status ) {
					$options['post_type'] = $type;
					$options['post_status'] = $status;
					
					$posts = get_posts( $options );
					$offset = 0;
					while( count( $posts ) > 0 ) {
						if( $offset == 10 ) {
							break;
						}
						$offset++;
						foreach( $posts as $post ) {
							wp_delete_post( $post->ID, true );
						}
						$posts = get_posts( $options );
					}
				}
			}
			
			
			// Delete categories, tags, etc
			$taxonomies_array = array('category','post_tag','portfolio-category','nav_menu','essential_grid_category');
			foreach($taxonomies_array as $tax){
				$cats = get_terms( $tax, array( 'hide_empty' => false, 'fields' => 'ids' ) );
				foreach( $cats as $cat ) {
					wp_delete_term( $cat, $tax );
				}
			}
			
			
			// Delete Slider Revolution Sliders
			if ( class_exists( 'RevSlider' ) ) {
				$sliderObj = new RevSlider();
				foreach( $sliderObj->getArrSliders() as $slider ){
					$slider->initByID($slider->getID());
					$slider->deleteSlider();
				}
			}
			
			
			
			// Delete Essential Grid grids
			if( class_exists( 'Essential_Grid' ) ){
				
				$gridObj = new Essential_Grid();
				$table_name = $wpdb->prefix . Essential_Grid::TABLE_GRID;
				$grids = $gridObj->get_essential_grids();
				if( !empty($grids) ) {
					foreach( $grids as $grid => $elem ){
						$wpdb->delete($table_name, array('id' => $elem->id) );
					}
				}
			}
					
			return 'Database cleaned!<br>';
		}
		
		
		/*
		*	Set the menu on theme location
		*/
		function setMenu(){
			//TBD
			$menuname = 'Main Menu';
			$menu_exists = wp_get_nav_menu_object( $menuname );
			
			if( !$menu_exists){
				$term_id_of_menu = wp_create_nav_menu($menuname);
			} else {
				$term_id_of_menu = $menu_exists->term_id;
			}

			$locations = get_theme_mod('nav_menu_locations');
			$locations['header-menu'] = $term_id_of_menu;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
		
		
		/*
		*	Import Slider Revolution
		*/
		function importSliderRev($slidersArray){
			if ( class_exists( 'RevSlider' ) ) {
				foreach($slidersArray as $slider){
					// Get the zip file path
					$sliderFile = $this->this_dir.'/highgrade/hgr_oci/demo_files/revSlider/'.$slider;
					if ( file_exists( $sliderFile ) ) {
						$slider = new RevSlider();
						$slider->importSliderFromPost( true, true, $sliderFile );
					}
				}
			} else {
				echo 'It looks like you don\'t have Slider Revolution installed and activated. Sliders were not imported!<br>';
			}
		}
		
		
		/*
		*	Import Essential Grid
		*/
		function importEssGrid($essGridFile){
			
			$json_file = wp_remote_get($this->this_uri.'/highgrade/hgr_oci/demo_files/essGrid/'.$essGridFile);
			
			if ( class_exists( 'Essential_Grid_Import' ) ) {
				
				if( $json_file['response']['code'] == '200' && !empty($json_file['body']) ){
					$jsonGrids = json_decode($json_file['body'], true);
					$im = new Essential_Grid_Import();
					
					if(!empty($jsonGrids['skins']) && is_array($jsonGrids['skins'])){
						foreach($jsonGrids['skins'] as $key => $skin){
							$im->import_skins($jsonGrids['skins'], $skin);
						}
					}
					if( isset($jsonGrids['punch-fonts']) ) {
						$im->import_punch_fonts($jsonGrids['punch-fonts']);
					}
					
					$im->import_grids($jsonGrids['grids']);
					
				} else{
					return 'Essential Grids could not be imported.<br>';
				}
			} else {
				return 'It looks like you don\'t have Essential Grid installed and activated. Grids were not imported!<br>';
			}
		}
		
		
		/*
		*	 Import demo XML content
		*/
		function importDemoContent($demoXml){
		
			if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
		
			// Load Importer API
			require_once ABSPATH . 'wp-admin/includes/import.php';
		
			if ( !class_exists( 'WP_Importer' ) ) {
				$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				if ( file_exists( $class_wp_importer ) ){
					require $class_wp_importer;
				}
			}
		
			if ( !class_exists( 'WP_Import' ) ) {
				$class_wp_importer = get_template_directory() ."/highgrade/hgr_oci/wordpress-importer.php";
				if ( file_exists( $class_wp_importer ) )
					require $class_wp_importer;
			}
			
			// Import demo content from XML
			if ( class_exists( 'WP_Import' ) ) {
				$import_filepath = $this->this_dir.'/highgrade/hgr_oci/demo_files/content/'.$demoXml; // Get the xml file from directory 
				
				$wp_import = new WP_Import();
				$wp_import->fetch_attachments = true;
				$wp_import->import($import_filepath);
				// Import DONE
				
				
				// if demo == allpages we ignore set home and menu
				if( $demoXml == 'allpages.xml' ) {
				
				} else {
				
						// set homepage as front page
						$page = get_page_by_path('home');
						if ($page) {
							update_option('show_on_front', 'page');
							update_option('page_on_front', $page->ID);
						} else {
							$page = get_page_by_title( 'Home' );
							if ($page) {
								update_option('show_on_front', 'page');
								update_option('page_on_front', $page->ID);
							}
						}
						
						$blog = get_page_by_path('blog');
						if ($blog) {
							update_option('show_on_front', 'page');
							update_option('page_for_posts', $blog->ID);
					
						}
						
						// Set menu
						$this->setMenu();
				}
			}
		}
		
		
		
		/*
		*	Import Theme Options
		*/
		function importThemeOptions($themeOptionsFile){
			$json_file = wp_remote_get($this->this_uri.'/highgrade/hgr_oci/demo_files/themeOptions/'.$themeOptionsFile);
			if( is_array($json_file) ) {
				if( $json_file['response']['code'] == '200' && !empty($json_file['body']) ){
					if(update_option( 'redux_options', json_decode($json_file['body'], true), '', 'yes' )){
						echo 'Theme Options saved.<br>';
					}
				} else{
					echo 'Theme Options could not be imported.<br>';
				}
			} elseif( is_wp_error( $json_file ) ){
				echo $json_file->get_error_message();
			}
		}
		
		
		
		/*
			Register necessary backend js
		*/
		function load_backends(){
			wp_register_script('hgr_oci', $this->this_uri.'/highgrade/hgr_oci/hgr_oci.js', array('jquery'), '2.0.0', true );
			wp_localize_script( 'hgr_oci', 'this_dir', $this->this_uri.'/highgrade/hgr_oci/' );
			wp_enqueue_script('hgr_oci');
		}
	
	}
	
} new HGR_OCI;