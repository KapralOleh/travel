<?php
/**
 * Hatch Theme header file
 * @package WordPress
 * @subpackage Hatch Theme
 * @since 1.0
 * TO BE INCLUDED IN ALL OTHER PAGES
 */
 $hgr_options = get_option( 'redux_options' );
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 ie-lt10 ie-lt9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 ie-lt10 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. --> 
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) : ?>
<?php echo ( !empty($hgr_options['retina_favicon']['url']) ? '<link href="'.$hgr_options['retina_favicon']['url'].'" rel="icon">'."\r\n" : '' ); ?>
<?php echo ( !empty($hgr_options['iphone_icon']['url']) ? '<link href="'.$hgr_options['iphone_icon']['url'].'" rel="apple-touch-icon">'."\r\n" : ''); ?>
<?php echo ( !empty($hgr_options['retina_iphone_icon']['url']) ? '<link href="'.$hgr_options['retina_iphone_icon']['url'].'" rel="apple-touch-icon" sizes="76x76" />'."\r\n" : ''); ?>
<?php echo ( !empty($hgr_options['ipad_icon']['url']) ? '<link href="'.$hgr_options['ipad_icon']['url'].'" rel="apple-touch-icon" sizes="120x120" />'."\r\n" : ''); ?>
<?php echo ( !empty($hgr_options['ipad_retina_icon']['url']) ? '<link href="'.$hgr_options['ipad_retina_icon']['url'].'" rel="apple-touch-icon" sizes="152x152" />'."\r\n" : ''); ?>
<?php endif; ?>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="<?php echo trailingslashit( get_template_directory_uri() ) . 'highgrade/js/html5shiv.js'; ?>"></script>
      <script src="<?php echo trailingslashit( get_template_directory_uri() ) . 'highgrade/js/respond.min.js'; ?>"></script>
    <![endif]-->


<!--[if lte IE 6]>
	<style>#hgr_top, #hgr_bottom, #hgr_left, #hgr_right { display: none; }</style>
<![endif]-->

<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

<?php 
	// Any custom CSS?
	hatch_get_custom_css();
?>

<?php
	hatch_styles();
?>

 <?php 
 	// VC Custom CSS
 	echo hatch_get_post_meta_by_key('_wpb_shortcodes_custom_css');
 ?>
 
 <!-- LESSPHP Styles -->
<?php hatch_do_less(false);?>
<!-- / LESSPHP Styles -->

<?php wp_head(); ?>
<link href='/wp-content/assets/css/custom-css.css' rel='stylesheet' type='text/css'>
</head>
<body <?php body_class(''); ?> >

<?php 
	/*
	*	Custom hook
	*/
	hatch_after_body_open(); 
?>

<!--Website Boxed START-->
<div id="website_boxed">

<?php
	if( class_exists('Mobile_Detect') ){
		$detect = new Mobile_Detect;
		if( $detect->isMobile() || $detect->isTablet() ){
			// IS MOBILE
			$hgr_options['header_floating'] = 1;
			//$hgr_options['logo_position'] = 'left_logo';
			// TBR
		}
	}
?>


<div class="row bkaTopmenu bka_menu <?php echo ( !is_front_page() ? '' : ( $hgr_options['header_floating'] == 2 ? 'hidden' : '') ); ?>">

<?php echo ( isset($hgr_options['menu_bar_width']) && $hgr_options['menu_bar_width'] == 'menu_contained' ? ' <div class="container"> ' : '');?>
    
    <?php
		/*
		*	Header layout render
		*	Do we use left positioned logo OR the Centered logo?
		*/
		$selected_header = ( isset($hgr_options['logo_position']) && 
							!empty($hgr_options['logo_position']) ? 
							$hgr_options['logo_position'] : 'left_logo');
		@require_once( get_template_directory() . '/layouts/headers/'.$selected_header.'.php' );
    ?>
    
  <?php echo ( isset($hgr_options['menu_bar_width']) && $hgr_options['menu_bar_width'] == 'menu_contained' ? ' </div> <!--.container--> ' : '');?>
  
  <?php 
    /*
    * Do the header style: fixed, appear after scroll, dissapear after scroll
    * Settings are made from Theme Options
    */
       if( function_exists('hatch_do_header') ) { hatch_do_header(); }
    ?>
    
</div>

<!--/ header --> 

<div class="header_spacer"></div>

<?php  if ( isset($hgr_options['back_to_top_button']) && $hgr_options['back_to_top_button'] == '1' ) { ?>
<div class="top">
	<a href="#" class="back-to-top"><i class="icon fa fa-chevron-up"></i></a>
</div>

<?php  }; ?>