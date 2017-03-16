<?php
/*
	Shortcode: Blog Posts
	If accesed directly, exit
*/
if (!defined('ABSPATH')) exit;

add_shortcode( 'hgr_blog_posts', 'hgr_blog_posts' );
function hgr_blog_posts ($atts) {
			/*
				 Empty vars declaration
			*/
			$output = $posts_number = $posts_columns = $display_order = $metas_separator = $meta_border = $display_by = $order = $links_color = $bg_color = $extra_class = $blogpost_footer = $footer_bg_color = $footer_sep_border_color = '';
			$validPosts = array();
			$this_post = array();
			$id_pot = array();
			$i = 0;
			
			/*
				WordPress function to extract shortcodes attributes
				Refference: http://codex.wordpress.org/Function_Reference/shortcode_atts
			*/
			extract(shortcode_atts(array(
				'posts_number'			=>	'6', 
				'posts_columns'			=>	'3',
				'display_order'			=>	'',
				'display_by'				=>	'',
				'order'					=>	'',
				'blog_post_title_size'	=>	'h2',
				'links_color'			=>	'#000',
				'bg_color'				=>	'',
				'extra_class'			=>	'',
				'blogpost_footer'		=>	'',
				'footer_bg_color'		=>	'',
				'footer_sep_border_color'=>	'',
			), $atts));
			
			$args = array(
				   'post_type'				=>	'post',
				   'posts_per_page'		=>	$posts_number,
				   'orderby'				=>	$display_by,
				   'order'					=>	$order,
				 );
			$hgr_query = new WP_Query($args);
			
			if( !empty($footer_sep_border_color) ){
				$metas_separator	=	' border-right:1px solid '.$footer_sep_border_color.'; ';
				$meta_border		=	' border:1px solid '.$footer_sep_border_color.'; ';
			}
			

			if( $hgr_query->have_posts()) {
				/*
					We add JS only if there are some posts to display
				*/
				wp_enqueue_script( 'isotope' );
				wp_enqueue_script('hgr-vc-tooltip');
				wp_enqueue_script('hgr-vc-blogposts');
				
				$output .='<div class="hgr_blog_posts" id="hgr_blog_section_'.uniqid().'" data-fetch="'.$posts_number.'" data-cols="'.$posts_columns.'">';
					
					while ( $hgr_query->have_posts() ) {
						
						$hgr_query->the_post();
						$output .='<div class="hgr_blog_post '.(!empty($extra_class) ? $extra_class : '').'">';
							$src = wp_get_attachment_image_src( get_post_thumbnail_id(), array( 5600,1000 ), false, '' );
							$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
							if ( $num_comments == 0 ) {
									$comments = esc_html__('No Comments');
							} elseif ( $num_comments > 1 ) {
									$comments = $num_comments . esc_html__(' Comments', 'hgr_lang');
							} else {
									$comments = esc_html__('1 Comment', 'hgr_lang');
							}
							$category = get_the_category();
							
							switch($display_order){
								case 'img_title_txt':
									if(!empty($src[0])) {
										$output .='<div class="hgr_post_image">';
											$output .='<a href="'.get_permalink().'"><img src="'.$src[0].'" alt="'.get_the_title().'" title="'.get_the_title().'"></a>';
										$output .='</div>';
									}
									elseif( get_post_format() == "video"){
											$output .='<div class="hgr_post_image">';
												$output .= HGR_XTND::hgr_xtnd_getPostContent();
											$output .='</div>';
										}
									
									$output .='<div class="hgr_post_content" '.(!empty($bg_color) ? 'style="background-color:'.$bg_color.';"' : '').'>';
										$output .='<'.$blog_post_title_size.'><a href="'.get_permalink().'" style="color:'.$links_color.';">'.get_the_title().'</a></'.$blog_post_title_size.'>';
										if( get_post_format() != "video"){
											$output .= HGR_XTND::hgr_xtnd_getPostContent();
										}
										
									$output .='</div>';
									
									if($blogpost_footer == 'iconbased') {
										$output .='<div class="hgr_post_metas" style="color:'.$links_color.';'.(!empty($bg_color) ? 'background-color:'.$bg_color.';"' : '"').'>';
											$output .='<div class="hgr_post_meta" title="'.get_the_time('M jS,  Y').'" data-toggle="tooltip" data-placement="top"><i class="icon fa fa-calendar"></i></div>';
											$output .='<div class="hgr_post_meta" title="'.__('Written by ', 'hgr_lang').ucwords(get_the_author()).'" data-toggle="tooltip" data-placement="top"><i class="icon fa fa-user"></i></div>';
											$output .='<div class="hgr_post_meta" title="'.__('Filled under ', 'hgr_lang').$category[0]->cat_name.'" data-toggle="tooltip" data-placement="top"><a href="'.get_category_link($category[0]->term_id ).'" style="color:'.$links_color.';"><i class="icon fa fa-folder"></i></a></div>';
											$output .='<div class="hgr_post_meta" title="'.$comments.'"><a href="' . get_comments_link() .'" data-toggle="tooltip" data-placement="top" style="color:'.$links_color.';"><i class="icon fa fa-comments-o"></i></a></div>';
											$output .='<div class="hgr_post_meta" title="'.__('Read more on ', 'hgr_lang').get_the_title().'" data-toggle="tooltip" data-placement="top"><a href="'.get_permalink().'" style="color:'.$links_color.';"><i class="icon fa fa-plus"></i></a></div>';
										$output .='</div>';
									}
									elseif($blogpost_footer == 'compact') {
										$output .='<div class="hgr_post_metas compact_metas" style="color:'.$links_color.';'.(!empty($footer_bg_color) ? 'background-color:'.$footer_bg_color.';' : '').' '.$meta_border.'">';
											if(is_sticky()){
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Sticky Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-bookmark"></i></div>';
											}
											elseif( get_post_format() == "audio"){
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Audio Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-music"></i></div>';
											}
											elseif( get_post_format() == "video"){
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Video Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-youtube-play"></i></div>';
											}
											elseif( get_post_format() == "quote"){
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Quote Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-quote-left"></i></div>';
											}
											else{
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Regular Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-align-left"></i></div>';
											}

											$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="'.get_the_time('M jS,  Y').'" data-toggle="tooltip" data-placement="top"><i class="icon fa fa-clock-o"></i> '.get_the_time('M jS').'</div>';
											$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="'.__('Written by ', 'hgr_lang').ucwords(get_the_author()).'" data-toggle="tooltip" data-placement="top"><i class="icon fa fa-user"></i></div>';
											$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="'.__('Filled under ', 'hgr_lang').$category[0]->cat_name.'" data-toggle="tooltip" data-placement="top"><a href="'.get_category_link($category[0]->term_id ).'" style="color:'.$links_color.';"><i class="icon fa fa-folder"></i></a></div>';
											$output .='<div style="" class="hgr_post_meta" title="'.$comments.'" data-toggle="tooltip" data-placement="left"><a href="' . get_comments_link() .'" style="color:'.$links_color.';"><i class="icon fa fa-comments-o"></i> '.$num_comments.'</a></div>';
										$output .='</div>';
									}
									else {
										$output .='<div class="hgr_post_metas_simple" '.(!empty($bg_color) ? 'style="background-color:'.$bg_color.';"' : '').'>';
											$output .='<div class="hgr_post_meta_simple">@ ' . HGR_XTND::hgr_xtnd_tes(get_the_time('M jS,  Y')) . esc_html__('by', 'hgr_lang').' '.ucwords(get_the_author()).'</div>';
										$output .='</div>';
									}
								break;
								
								case 'title_txt':
									$output .='<div class="hgr_post_content" '.(!empty($bg_color) ? 'style="background-color:'.$bg_color.';"' : '').'>';
										$output .='<'.$blog_post_title_size.'><a href="'.get_permalink().'" style="color:'.$links_color.';">'.get_the_title().'</a></'.$blog_post_title_size.'>';
										$output .='<p>'.HGR_XTND::hgr_xtnd_getPostContent().'</p>';
									$output .='</div>';
									
									if($blogpost_footer == 'iconbased') {
										$output .='<div class="hgr_post_metas" style="color:'.$links_color.';'.(!empty($bg_color) ? 'background-color:'.$bg_color.';"' : '"').'>';
											$output .='<div class="hgr_post_meta" title="'.get_the_time('M jS,  Y').'" data-toggle="tooltip" data-placement="top"><i class="icon fa fa-calendar"></i></div>';
											$output .='<div class="hgr_post_meta" title="'.__('Written by ', 'hgr_lang').ucwords(get_the_author()).'" data-toggle="tooltip" data-placement="top"><i class="icon fa fa-user"></i></div>';
											$output .='<div class="hgr_post_meta" title="'.__('Filled under ', 'hgr_lang').$category[0]->cat_name.'" data-toggle="tooltip" data-placement="top"><a href="'.get_category_link($category[0]->term_id ).'" style="color:'.$links_color.';"><i class="icon fa fa-folder"></i></a></div>';
											$output .='<div class="hgr_post_meta" title="'.$comments.'"><a href="' . get_comments_link() .'" data-toggle="tooltip" data-placement="top" style="color:'.$links_color.';"><i class="icon fa fa-comments-o"></i></a></div>';
											$output .='<div class="hgr_post_meta" title="'.__('Read more on ', 'hgr_lang').get_the_title().'" data-toggle="tooltip" data-placement="top"><a href="'.get_permalink().'" style="color:'.$links_color.';"><i class="icon fa fa-plus"></i></a></div>';
										$output .='</div>';
									}
									elseif($blogpost_footer == 'compact') {
										$output .='<div class="hgr_post_metas compact_metas" style="color:'.$links_color.';'.(!empty($footer_bg_color) ? 'background-color:'.$footer_bg_color.';' : '').' '.$meta_border.'">';
											if(is_sticky()){
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Sticky Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-bookmark"></i></div>';
											}
											elseif( get_post_format() == "audio"){
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Audio Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-music"></i></div>';
											}
											elseif( get_post_format() == "video"){
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Video Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-youtube-play"></i></div>';
											}
											elseif( get_post_format() == "quote"){
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Quote Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-quote-left"></i></div>';
											}
											else{
												$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="Regular Post" data-toggle="tooltip" data-placement="right"><i class="icon fa fa-align-left"></i></div>';
											}

											$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="'.get_the_time('M jS,  Y').'" data-toggle="tooltip" data-placement="top"><i class="icon fa fa-clock-o"></i> '.get_the_time('M jS').'</div>';
											$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="'.__('Written by ', 'hgr_lang').ucwords(get_the_author()).'" data-toggle="tooltip" data-placement="top"><i class="icon fa fa-user"></i></div>';
											$output .='<div style="'.$metas_separator.'" class="hgr_post_meta" title="'.__('Filled under ', 'hgr_lang').$category[0]->cat_name.'" data-toggle="tooltip" data-placement="top"><a href="'.get_category_link($category[0]->term_id ).'" style="color:'.$links_color.';"><i class="icon fa fa-folder"></i></a></div>';
											$output .='<div style="" class="hgr_post_meta" title="'.$comments.'" data-toggle="tooltip" data-placement="left"><a href="' . get_comments_link() .'" style="color:'.$links_color.';"><i class="icon fa fa-comments-o"></i> '.$num_comments.'</a></div>';
										$output .='</div>';
									}
									else {
										$output .='<div class="hgr_post_metas_simple" '.(!empty($bg_color) ? 'style="background-color:'.$bg_color.';"' : '').'>';
											$output .='<div class="hgr_post_meta_simple">@ ' . HGR_XTND::hgr_xtnd_tes(get_the_time('M jS,  Y')) . esc_html__('by', 'hgr_lang').' '.ucwords(get_the_author()).'</div>';
										$output .='</div>';
									}
								break;
							}
						$output .= '</div>';
					}
				$output .= '</div>';
			} else {
				$output .=	'<div class="hgr_blog_posts" data-fetch="'.$posts_number.'" data-cols="'.$posts_columns.'">';
				$output .=	'<p>'.__('No posts to display. Please add some blog posts!', 'hgr_lang').'</p>';
				$output .=	'</div>';
			}
			wp_reset_postdata();						
			return $output;
		}
?>