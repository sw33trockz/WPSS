<?php
		global $pageTitle;
		$pageTitle = '';
				if(is_search()) {
					 if(have_posts()){
						$pageTitle .= __('Results for ','rb').'"'.get_search_query();
					}else{ 
						$pageTitle .= __('Not found for ','rb').'"'.get_search_query();
					}
				}elseif(is_page()){
					if(have_posts()){
						$pageTitle .= get_the_title();
					}else{
						$pageTitle .= __('Page request could not be found.','rb');
					}
				}elseif(is_tag()){
					if(have_posts()){
						$pageTitle .= __('Tag, ','rb').single_tag_title('',false);
					 }else{ 
						$pageTitle .= __('Page request could not be found.','rb');
					 }
				
				}elseif(is_category()){
					if(have_posts()){
						$pageTitle .= __('Category, ','rb').single_tag_title('',false);
					}else{
						$pageTitle .= __('Page request could not be found.','rb');
					}
				
				}elseif(is_archive()){
					if(have_posts()){
						$pageTitle .='';
						if(is_day())
							$pageTitle .= __('Daily Archives, ','rb').get_the_date();
						elseif(is_month())
							$pageTitle .= __('Monthly Archives, ','rb').get_the_date('F Y');
						elseif(is_year())
							$pageTitle .= __('Yearly Archives, ','rb').get_the_date('Y');
						else
							$pageTitle .= __('Blog Archives','rb');
						$pageTitle .= '';
					}else{
						$pageTitle .= __('Page request could not be found.','rb');
					}
				}elseif(is_404()){
						$pageTitle .= __('You may find your requested page by searching.','rb');
				}else{
					$pageTitle .= get_the_title(); 
				}
	
	global $pageDescription;
	if(have_posts() && is_single() OR is_page())
	{
		while(have_posts())
		{
			the_post();
			$out_excerpt = str_replace(array("\r\n", "\r", "\n"), "", get_the_excerpt());
			$pageDescription = apply_filters('the_excerpt_rss', $out_excerpt);
		}
	}elseif(is_category() OR is_tag()){
	if(is_category())
		$pageDescription = "Posts related to Category:".ucfirst(single_cat_title("", FALSE));
	elseif(is_tag())
		$pageDescription = "Posts related to Tag:".ucfirst(single_tag_title("", FALSE));
	}
?>