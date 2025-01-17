<?php
/***************************************************************************
*
*	ProjectTheme - copyright (c) - sitemile.com
*	The only project theme for wordpress on the world wide web.
*
*	Coder: Andrei Dragos Saioc
*	Email: sitemile[at]sitemile.com | andreisaioc[at]gmail.com
*	More info about the theme here: http://sitemile.com/products/wordpress-project-freelancer-theme/
*	since v1.2.5.3
*
***************************************************************************/
if(!function_exists('ProjectTheme_display_provider_search_page_disp'))
{
function ProjectTheme_display_provider_search_page_disp()
{
	
?>	
	
    	<div id="content" >
        	
            <div class="my_box3">
            	<div class="padd10">
            
            	<div class="box_title"><?php _e("Service Provider Search", "ProjectTheme"); ?></div>
                <div class="box_content"> 
<?php
			
			$ProjectTheme_enable_2_user_tp = get_option('ProjectTheme_enable_2_user_tp');
			
			
			$pg = $_GET['pg'];
			if(empty($pg)) $pg = 1;
			
			$nrRes = 15;
			
			//------------------
			
			$offset = ($pg-1)*$nrRes;
			
			//------------------
			
						if(isset($_GET['username']))
				$args['search'] = "*".trim($_GET['username'])."*";
			
			
			// prepare arguments
			$args['orderby']  = 'display_name';
			$arr_aray = array();
			
			
			
			if(!empty($_GET['rating_over'])) 
			{
				$arr_sbg = 	array(
						// uses compare like WP_Query
						'key' => 'cool_user_rating',
						'value' => $_GET['rating_over'],
						'compare' => '>'
						);
						
				array_push(	$arr_aray, 	$arr_sbg);
			}
			
			if($ProjectTheme_enable_2_user_tp == "yes")
			{
				$arr_sbg = 	array(
						// uses compare like WP_Query
						'key' => 'user_tp',
						'value' => 'service_provider',
						'compare' => '='
						);
						
				array_push(	$arr_aray, 	$arr_sbg);
				
			}
			
			//-----------------------------------------------
			
			$args['meta_query']  	= $arr_aray;
			$args['number'] 		= $nrRes;
			$args['offset'] 		= $offset;
			$args['count_total'] 	= true;
			
			//-----------------------------------------------
			
			$wp_user_query = new WP_User_Query($args);
			// Get the results
			$ttl = $wp_user_query->total_users;
			$nrPages = ceil($ttl / $nrRes);
			
			$authors = $wp_user_query->get_results();
	
			// Check for results
			if (!empty($authors))
			{
				echo '<table width="100%">';
				// loop trough each author
				
				echo '<tr>';
					echo '<td><strong>'.__('Username','ProjectTheme').'</strong></td>';
					echo '<td><strong>'.__('User Rating','ProjectTheme').'</strong></td>';
					echo '<td><strong>'.__('Options','ProjectTheme').'</strong></td>';
					
					echo '</tr>';
				
				foreach ($authors as $author)
				{
					// get all the user's data
					$author_info = get_userdata($author->ID);
					echo '<tr>';
					echo '<td><a href="'.ProjectTheme_get_user_profile_link($author->ID).'">'.$author_info->user_login.'<a/></td>';
					echo '<td>'.ProjectTheme_project_get_star_rating($author->ID).'</td>';
					echo '<td><a href="'.ProjectTheme_get_priv_mess_page_url('send', '', '&uid='.$author_info->ID).'">'.__('Contact Provider','ProjectTheme').'</a></td>';
					
					echo '</tr>';
				}
				echo '</table>';
				
				echo '<div class="div_class_div">';
				
				$totalPages = $nrPages;
				$my_page = $pg;
				$page = $pg;
				
				$batch = 10;
				$nrpostsPage = $nrRes;
				$end = $batch * $nrpostsPage;
				
				if ($end > $pagess) {
					$end = $pagess;
				}
				$start = $end - $nrpostsPage + 1;
				
				if($start < 1) $start = 1;
				
				$links = '';
				
				$raport = ceil($my_page/$batch) - 1; if ($raport < 0) $raport = 0;
		
				$start 		= $raport * $batch + 1; 
				$end		= $start + $batch - 1;
				$end_me 	= $end + 1;
				$start_me 	= $start - 1;
				
				if($end > $totalPages) $end = $totalPages;
				if($end_me > $totalPages) $end_me = $totalPages;
				
				if($start_me <= 0) $start_me = 1;
				
				$previous_pg = $page - 1;
				if($previous_pg <= 0) $previous_pg = 1;
				
				$next_pg = $pages_curent + 1;
				if($next_pg > $totalPages) $next_pg = 1;
		
		
		
		
				if($my_page > 1)
				{
					echo '<a href="'.projectTheme_provider_search_link() .'pg='.$previous_pg.'" class="bighi"><< '.__('Previous','ProjectTheme').'</a>';
					echo '<a href="'.projectTheme_provider_search_link() .'pg='.$start_me.'" class="bighi"><<</a>';
				}
				
					for($i=$start;$i<=$end;$i++)
					{
						if($i == $pg)
						echo '<a href="#" class="bighi" id="activees">'.$i.'</a>';
						else
						echo '<a href="'.projectTheme_provider_search_link() .'pg='.$i.'" class="bighi">'.$i.'</a>';	
					}	
				
				if($totalPages > $my_page)
				echo '<a href="'.projectTheme_provider_search_link() .'pg='.$end_me.'" class="bighi">>></a>';
				
				if($page < $totalPages)
				echo '<a href="'.projectTheme_provider_search_link() .'pg='.$next_pg.'" class="bighi">'.__('Next','ProjectTheme').' >></a>';						
		
					
				echo '</div>';
				
			} else {
				echo 'No authors found';
			}



?>
    
    			</div>
                </div>
                </div>
                </div>
                
                <!-- ############## -->
                
                
                <div id="right-sidebar"> <ul class="xoxo">
	<li class="">
    	<h3 class="widget-title"><?php _e('Filter Options','ProjectTheme'); ?></h3>
    	
        <form method="get">
		<table width="100%">
        <tr>
        <td><?php _e('Username Like','ProjectTheme'); ?></td>
        <td><input type="text" size="20" value="<?php echo $_GET['username']; ?>" name="username" /></td>
        </tr>
        
        
        <tr>
        <td><?php _e('Rating Over','ProjectTheme'); ?></td>
        <td><input type="text" size="10" value="<?php echo $_GET['rating_over']; ?>" name="rating_over" /> [0-5]</td>
        </tr>
        
        
         <tr>
        <td></td>
        <td><input type="submit" value="<?php _e('Search','ProjectTheme'); ?>" name="search_provider" /></td>
        </tr>
        
        
        </table>
    	</form>
        <div class="clear10"></div>
    </li>
    
	<?php dynamic_sidebar( 'other-page-area' ); ?>
</ul>
</div>

                
                
   <?php 
}}

?>