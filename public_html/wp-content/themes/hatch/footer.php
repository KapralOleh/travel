<?php
/**
 * Hatch Theme footer file
 * @package WordPress
 * @subpackage Hatch Theme
 * @since 1.0
 * TO BE INCLUDED IN ALL OTHER PAGES
 */
 ?>
  <?php
 $hgr_options = get_option( 'redux_options' );
 $allowed_html_array = array(
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array(),
);
 
 ?>
 
  <?php if ( dynamic_sidebar('Footer') ) : ?>
<?php endif; ?>
 
<?php if ( !empty($hgr_options['footer-copyright']) ) : ?>
<div class="row bka_footer <?php echo esc_attr($hgr_options['footer_color_scheme']);?>" style="padding:10px; <?php echo( !empty($hgr_options['footer-bgcolor']) ? ' background-color:' . esc_attr( $hgr_options['footer-bgcolor'] ) . ';' : '');?>">
    <div class="travel-container">
    <div class="row">
      <div class="vc_col-sm-3">
        <div class="row">
          <img class="footer-logo" src="/wp-content/assets/images/travel-logo.png" alt="travel look">
        </div>
      </div>
      <div class="vc_col-sm-9">
        <div class="row">
          <div class="vc_col-sm-4">
            <ul>
              <li><a href="/online-search/">Підбір туру</a></li>
              <hr>
              <li><a href="/online-search/">Болгарія</a></li>
              <li><a href="/online-search/">Чорногорія</a></li>
            </ul>
          </div>
          <div class="vc_col-sm-4">
            <ul>
              <li><a href="/news/">Новини</a></li>
              <hr>
              <li><a href="/relax/">Відпочивай з нами</a></li>
              <li><a href="/country/">Країни</a></li>
            </ul>
          </div>
          <div class="vc_col-sm-4">
            <ul>
              <li><a href="/contact/">Контакт</a></li>
              <hr>
              <li><a href="/guestbook/">Відгуки</a></li>
            </ul>
          </div>
        </div>
      </div>
      </div>
      <div class="vc_col-sm-12">
        <div class="row">
          <div class="vc_col-sm-3"></div>
          <div class="vc_col-sm-3">
            <p>Вітовського, 10<br>
            м. Львів</p>
          </div>
          <div class="vc_col-sm-3">
            <a class="link-travel" href="tel:+380960041010">+380-96-004-10-10<br>
            <a class="link-travel" href="mailto:travellook.lviv@gmail.com">travellook.lviv@gmail.com</a></p>
          </div>
          <div class="vc_col-sm-3">
            <p><i class="icon fa fa-instagram" style="font-size: 24px!important;"></i>&nbsp;&nbsp;<i class="icon fa fa-facebook" style="font-size: 24px!important;"></i>&nbsp;&nbsp;<i class="icon fa fa-vk" style="font-size: 24px!important;"></i></p>
          </div>
        </div>
        <div class="row">
          <p class="copyright">Travel Look Copyright © 2017</p>
        </div>
      </div>
    </div>
</div>
<?php endif; ?>

  <script type="text/javascript">
	var home_url					=	'<?php echo esc_url( home_url("/") );?>';
	var template_directory_uri	=	'<?php echo esc_url( get_template_directory_uri() );?>';
	var retina_logo_url			=	'<?php echo( !empty($hgr_options['retina_logo']['url']) ? esc_url($hgr_options['retina_logo']['url']) : "''" );?>';
	var menu_style				=	'<?php echo( !empty($hgr_options['header_floating']) ? esc_attr($hgr_options['header_floating']) : '' );?>';
	var is_front_page			=	'<?php echo( is_front_page() ? 'true' : 'false' );?>';
 	var custom_js 				=	<?php echo( isset($hgr_options['enable_js-code']) && $hgr_options['enable_js-code'] == 'custom_js_on' ? json_encode( $hgr_options['js-code']) : "''" );?>;
  </script>
    <div id="hgr_left"></div>
    <div id="hgr_right"></div>
    <div id="hgr_top"></div>
    <div id="hgr_bottom"></div>
 
 
<?php 
  /*
  * Custom hook
  */
  hatch_before_footer_open(); 
?>


</div> <!--Website Boxed END-->

  <?php wp_footer();?>
    
 </body>
 <!-- <script src="/wp-content/assets/js/jquery-3.1.1.min.js"></script> -->
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBGjXHUp72CZej_umEzKGXfdRKs_pncl9k"></script>
  <script src="/wp-content/assets/js/custom-js.js"></script>
  <script src="/wp-content/assets/js/mapping.js"></script>
  
  <!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'jjJe8MZJHD';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->
</html>