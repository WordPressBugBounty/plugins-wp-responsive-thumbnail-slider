<?php
   /* 
    Plugin Name: WordPress Responsive Thumbnail Carousel Slider
    Plugin URI:https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/
    Author URI:https://www.i13websolution.com/
    Description: This is beautiful responsive thumbnail image slider plugin for WordPress.Add any number of images from admin panel.
    Author:I Thirteen Web Solution
    Version:1.1.12
    Text Domain:wp-responsive-thumbnail-slider
    Domain Path: /languages
    */

    add_action('admin_menu', 'add_responsive_thumbnail_slider_admin_menu');
    //add_action( 'admin_init', 'my_responsive_thumbnailSlider_admin_init' );
    register_activation_hook(__FILE__,'install_responsive_thumbnailSlider');
    register_deactivation_hook(__FILE__,'rts_responsive_thumbnail_slider_remove_access_capabilities');
    add_action('wp_enqueue_scripts', 'responsive_thumbnail_slider_load_styles_and_js');
    add_shortcode('print_responsive_thumbnail_slider', 'print_responsive_thumbnail_slider_func' );
    add_action ( 'admin_notices', 'responsive_thumbnail_slider_admin_notices' );
    add_filter('widget_text', 'do_shortcode');
    add_filter( 'user_has_cap', 'rts_responsive_thumbnail_slider_admin_cap_list' , 10, 4 );
    add_action('plugins_loaded', 'writs_load_lang_for_responsive_thumbnail_slider');
    add_action( 'wp_ajax_mass_upload_wrthslider', 'wrthslider_slider_mass_upload_wrthslider' );

    function writs_load_lang_for_responsive_thumbnail_slider() {
            
            load_plugin_textdomain( 'wp-responsive-thumbnail-slider', false, basename( dirname( __FILE__ ) ) . '/languages/' );
            add_filter( 'map_meta_cap',  'map_rts_responsive_thumbnail_slider_meta_caps', 10, 4 );
    }
    
   
    function rsths_save_image_remote($url,$saveto){
    
        $raw = wp_remote_retrieve_body( wp_remote_get( $url ) );

        if(file_exists($saveto)){
            @unlink($saveto);
        }
        $fp = @fopen($saveto,'x');
        @fwrite($fp, $raw);
        @fclose($fp);
    }

    
    function map_rts_responsive_thumbnail_slider_meta_caps( array $caps, $cap, $user_id, array $args  ) {
        
       
        if ( ! in_array( $cap, array(
                                      'rts_responsive_thumbnail_slider_settings',
                                      'rts_responsive_thumbnail_slider_view_images',
                                      'rts_responsive_thumbnail_slider_add_image',
                                      'rts_responsive_thumbnail_slider_edit_image',
                                      'rts_responsive_thumbnail_slider_delete_image',
                                      'rts_responsive_thumbnail_slider_preview',
                                      
                                    ), true ) ) {
            
			return $caps;
         }

       
         
   
        $caps = array();

        switch ( $cap ) {
            
                 case 'rts_responsive_thumbnail_slider_settings':
                        $caps[] = 'rts_responsive_thumbnail_slider_settings';
                        break;
              
                 case 'rts_responsive_thumbnail_slider_view_images':
                        $caps[] = 'rts_responsive_thumbnail_slider_view_images';
                        break;
              
                case 'rts_responsive_thumbnail_slider_add_image':
                        $caps[] = 'rts_responsive_thumbnail_slider_add_image';
                        break;
              
                case 'rts_responsive_thumbnail_slider_edit_image':
                        $caps[] = 'rts_responsive_thumbnail_slider_edit_image';
                        break;
              
                case 'rts_responsive_thumbnail_slider_delete_image':
                        $caps[] = 'rts_responsive_thumbnail_slider_delete_image';
                        break;
              
                case 'rts_responsive_thumbnail_slider_preview':
                        $caps[] = 'rts_responsive_thumbnail_slider_preview';
                        break;
              
                default:
                        
                        $caps[] = 'do_not_allow';
                        break;
        }

      
     return apply_filters( 'rts_responsive_thumbnail_slider_meta_caps', $caps, $cap, $user_id, $args );
}


 function rts_responsive_thumbnail_slider_admin_cap_list($allcaps, $caps, $args, $user){
        
        
        if ( ! in_array( 'administrator', $user->roles ) ) {
            
            return $allcaps;
        }
        else{
            
            if(!isset($allcaps['rts_responsive_thumbnail_slider_settings'])){
                
                $allcaps['rts_responsive_thumbnail_slider_settings']=true;
            }
            
            if(!isset($allcaps['rts_responsive_thumbnail_slider_view_images'])){
                
                $allcaps['rts_responsive_thumbnail_slider_view_images']=true;
            }
            
            if(!isset($allcaps['rts_responsive_thumbnail_slider_add_image'])){
                
                $allcaps['rts_responsive_thumbnail_slider_add_image']=true;
            }
            if(!isset($allcaps['rts_responsive_thumbnail_slider_edit_image'])){
                
                $allcaps['rts_responsive_thumbnail_slider_edit_image']=true;
            }
            if(!isset($allcaps['rts_responsive_thumbnail_slider_delete_image'])){
                
                $allcaps['rts_responsive_thumbnail_slider_delete_image']=true;
            }
            if(!isset($allcaps['rts_responsive_thumbnail_slider_preview'])){
                
                $allcaps['rts_responsive_thumbnail_slider_preview']=true;
            }
         
        }
        
        return $allcaps;
        
    }

function  rts_responsive_thumbnail_slider_add_access_capabilities() {
     
    // Capabilities for all roles.
    $roles = array( 'administrator' );
    foreach ( $roles as $role ) {
        
            $role = get_role( $role );
            if ( empty( $role ) ) {
                    continue;
            }
         
            
            if(!$role->has_cap( 'rts_responsive_thumbnail_slider_settings' ) ){
            
                    $role->add_cap( 'rts_responsive_thumbnail_slider_settings' );
            }
            
            if(!$role->has_cap( 'rts_responsive_thumbnail_slider_view_images' ) ){
            
                    $role->add_cap( 'rts_responsive_thumbnail_slider_view_images' );
            }
         
            
            if(!$role->has_cap( 'rts_responsive_thumbnail_slider_add_image' ) ){
            
                    $role->add_cap( 'rts_responsive_thumbnail_slider_add_image' );
            }
            
            if(!$role->has_cap( 'rts_responsive_thumbnail_slider_edit_image' ) ){
            
                    $role->add_cap( 'rts_responsive_thumbnail_slider_edit_image' );
            }
            
            if(!$role->has_cap( 'rts_responsive_thumbnail_slider_delete_image' ) ){
            
                    $role->add_cap( 'rts_responsive_thumbnail_slider_delete_image' );
            }
            
            if(!$role->has_cap( 'rts_responsive_thumbnail_slider_preview' ) ){
            
                    $role->add_cap( 'rts_responsive_thumbnail_slider_preview' );
            }
            
         
    }
    
    $user = wp_get_current_user();
    $user->get_role_caps();
    
}

function rts_responsive_thumbnail_slider_remove_access_capabilities(){
    
    global $wp_roles;

    if ( ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
    }

    foreach ( $wp_roles->roles as $role => $details ) {
            $role = $wp_roles->get_role( $role );
            if ( empty( $role ) ) {
                    continue;
            }

            $role->remove_cap( 'rts_responsive_thumbnail_slider_settings' );
            $role->remove_cap( 'rts_responsive_thumbnail_slider_view_images' );
            $role->remove_cap( 'rts_responsive_thumbnail_slider_add_image' );
            $role->remove_cap( 'rts_responsive_thumbnail_slider_edit_image' );
            $role->remove_cap( 'rts_responsive_thumbnail_slider_delete_image' );
            $role->remove_cap( 'rts_responsive_thumbnail_slider_preview' );
       

    }

    // Refresh current set of capabilities of the user, to be able to directly use the new caps.
    $user = wp_get_current_user();
    $user->get_role_caps();
    
}
    
    function responsive_thumbnail_slider_load_styles_and_js(){
        
         if (!is_admin()) {                                                       
             
            wp_register_style( 'images-responsive-thumbnail-slider-style', plugins_url('/css/images-responsive-thumbnail-slider-style.css', __FILE__),array(),'1.1.7' );
            wp_register_script('images-responsive-thumbnail-slider-jc',plugins_url('/js/images-responsive-thumbnail-slider-jc.js', __FILE__),array(),'1.1.7');
            
         }  
      }
      
     
    
    function responsive_thumbnail_slider_admin_notices() {
         
	if (is_plugin_active ( 'wp-responsive-thumbnail-slider/wp-responsive-images-thumbnail-slider.php' )) {
		
		$uploads = wp_upload_dir ();
		$baseDir = $uploads ['basedir'];
		$baseDir = str_replace ( "\\", "/", $baseDir );
		$pathToImagesFolder = $baseDir . '/wp-responsive-images-thumbnail-slider';
		
		if (file_exists ( $pathToImagesFolder ) and is_dir ( $pathToImagesFolder )) {
			
			if (! is_writable ( $pathToImagesFolder )) {
                            
                                 echo "<div class='updated'><p>".__( 'Responsive Thumbnail Slider is active but does not have write permission on','wp-responsive-thumbnail-slider')."</p><p><b>" . $pathToImagesFolder . "</b>".__( ' directory.Please allow write permission.','wp-responsive-thumbnail-slider')."</p></div> ";
				
			}
		} else {
			
			wp_mkdir_p ( $pathToImagesFolder );
			if (! file_exists ( $pathToImagesFolder ) and ! is_dir ( $pathToImagesFolder )) {
                            
                                echo "<div class='updated'><p>".__( 'Responsive Thumbnail Slider is active but plugin does not have permission to create directory','wp-responsive-thumbnail-slider')."</p><p><b>" . $pathToImagesFolder . "</b> ".__( '.Please create post-slider-carousel directory inside upload directory and allow write permission.','wp-responsive-thumbnail-slider')."</p></div> ";
				
			}
		}
	}
    } 
   function install_responsive_thumbnailSlider(){
         
           global $wpdb;
           $table_name = $wpdb->prefix . "responsive_thumbnail_slider";
           
                  $sql = "CREATE TABLE " . $table_name . " (
                       id int(10) unsigned NOT NULL auto_increment,
                       title varchar(1000) NOT NULL,
                       image_name varchar(500) NOT NULL,
                       createdon datetime NOT NULL,
                       custom_link varchar(1000) default NULL,
                       post_id int(10) unsigned default NULL,
                      PRIMARY KEY  (id)
                );";
               require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
               dbDelta($sql);
               
               
               $responsive_thumbnail_slider_settings=array('linkimage' => '1','pauseonmouseover' => '1','auto' =>'','speed' => '1000','pause'=>1000,'circular' => '1','imageheight' => '120','imagewidth' => '120','visible'=> '5','min_visible'=> '1','scroll' => '1','resizeImages'=>'1','scollerBackground'=>'#FFFFFF','imageMargin'=>'15','show_caption'=>'0','show_pager'=>'0');
               
               $existingopt=get_option('responsive_thumbnail_slider_settings');
               if(!is_array($existingopt)){

                    update_option('responsive_thumbnail_slider_settings',$responsive_thumbnail_slider_settings);

                }
                else{
                    
                    $flag=false;
                    if(!isset($existingopt['show_caption'])){

                       $flag=true; 
                       $existingopt['show_caption']='0'; 

                    }
                    if(!isset($existingopt['show_pager'])){

                        $flag=true; 
                        $existingopt['show_pager']='0'; 

                     }
                    
                    if($flag==true){
                        
                       update_option('responsive_thumbnail_slider_settings', $existingopt); 
                       
                      }
                }
                
              
               
                $uploads = wp_upload_dir ();
                $baseDir = $uploads ['basedir'];
                $baseDir = str_replace ( "\\", "/", $baseDir );
                $pathToImagesFolder = $baseDir . '/wp-responsive-images-thumbnail-slider';
                wp_mkdir_p ( $pathToImagesFolder );
                rts_responsive_thumbnail_slider_add_access_capabilities();
                
     } 
    
    
    
   
    function add_responsive_thumbnail_slider_admin_menu(){
        
        $hook_suffix_r_t_s=add_menu_page( __( 'Responsive Thumbnail Slider','wp-responsive-thumbnail-slider'), __( 'Responsive Thumbnail Slider','wp-responsive-thumbnail-slider' ), 'rts_responsive_thumbnail_slider_settings', 'responsive_thumbnail_slider', 'responsive_thumbnail_slider_admin_options' );
        $hook_suffix_r_t_s=add_submenu_page( 'responsive_thumbnail_slider', __( 'Slider Setting','wp-responsive-thumbnail-slider'), __( 'Slider Setting','wp-responsive-thumbnail-slider' ),'rts_responsive_thumbnail_slider_settings', 'responsive_thumbnail_slider', 'responsive_thumbnail_slider_admin_options' );
        $hook_suffix_r_t_s_1=add_submenu_page( 'responsive_thumbnail_slider', __( 'Manage Images','wp-responsive-thumbnail-slider'), __( 'Manage Images','wp-responsive-thumbnail-slider'),'rts_responsive_thumbnail_slider_view_images', 'responsive_thumbnail_slider_image_management', 'responsive_thumbnail_image_management' );
        $hook_suffix_r_t_s_2=add_submenu_page( 'responsive_thumbnail_slider', __( 'Preview Slider','wp-responsive-thumbnail-slider'), __( 'Preview Slider','wp-responsive-thumbnail-slider'),'rts_responsive_thumbnail_slider_preview', 'responsive_thumbnail_slider_preview', 'responsivepreviewSliderAdmin' );
        
        add_action( 'load-' . $hook_suffix_r_t_s , 'my_responsive_thumbnailSlider_admin_init' );
        add_action( 'load-' . $hook_suffix_r_t_s_1 , 'my_responsive_thumbnailSlider_admin_init' );
        add_action( 'load-' . $hook_suffix_r_t_s_2 , 'my_responsive_thumbnailSlider_admin_init' );
        
    }
    
    function my_responsive_thumbnailSlider_admin_init(){
      
      $url = plugin_dir_url(__FILE__);  
      
      wp_enqueue_script( 'jquery.validate', $url.'js/jquery.validate.js' );  
      wp_enqueue_script( 'images-responsive-thumbnail-slider-jc', $url.'js/images-responsive-thumbnail-slider-jc.js' );  
      wp_enqueue_style('images-responsive-thumbnail-slider-style',$url.'css/images-responsive-thumbnail-slider-style.css');
      wp_enqueue_style( 'admin-css-resp-slider', plugins_url('/css/admin-css.css', __FILE__) );
      responsive_thumbnail_slider_admin_scripts_init();
    }
    
     function responsive_thumbnail_slider_get_wp_version() {
     
        global $wp_version;
        return $wp_version;
     }
 
 function responsive_thumbnail_slider_is_plugin_page() {
    
   $server_uri = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
   
   foreach (array('responsive_thumbnail_slider_image_management') as $allowURI) {
       
       if(stristr($server_uri, $allowURI)) return true;
   }
   
   return false;
}

function responsive_thumbnail_slider_admin_scripts_init() {
    
   if(responsive_thumbnail_slider_is_plugin_page()) {
      //double check for WordPress version and function exists
      if(function_exists('wp_enqueue_media') && version_compare(responsive_thumbnail_slider_get_wp_version(), '3.5', '>=')) {
         //call for new media manager
         wp_enqueue_media();
      }
      wp_enqueue_style('media');
     
   }
    wp_enqueue_style( 'wp-color-picker' );
      wp_enqueue_script( 'wp-color-picker' );
} 

function responsive_thumbnail_slider_admin_options(){
       
     if ( ! current_user_can( 'rts_responsive_thumbnail_slider_settings' ) ) {

           wp_die( __( "Access Denied", "wp-responsive-thumbnail-slider" ) );

      } 
       
     if(isset($_POST['btnsave'])){
         
          if(!check_admin_referer( 'action_settings_add_edit','add_edit_nonce' )){

                wp_die('Security check fail','wp-responsive-thumbnail-slider'); 
           }

         $auto=trim(esc_html(sanitize_text_field($_POST['isauto'])));
         
         if($auto=='auto')
           $auto=true;
         else if($auto=='manuall')
           $auto=false; 
         else
           $auto=2;   
            
         $speed=(int)trim(esc_html(sanitize_text_field($_POST['speed'])));
         $pause=(int)trim(esc_html(sanitize_text_field($_POST['pause'])));
         
         if(isset($_POST['circular']))
           $circular=true;  
        else
           $circular=false;  

         //$scrollerwidth=$_POST['scrollerwidth'];
         
         $visible=intval(htmlentities(sanitize_text_field($_POST['visible']),ENT_QUOTES));
         
         $min_visible=intval(htmlentities(sanitize_text_field($_POST['min_visible']),ENT_QUOTES));
         
         
         $show_caption=intval(htmlentities(sanitize_text_field($_POST['show_caption'],ENT_QUOTES)));  

         $show_pager=intval(htmlentities(sanitize_text_field($_POST['show_pager'],ENT_QUOTES)));  

        
         if(isset($_POST['pauseonmouseover']))
           $pauseonmouseover=true;  
         else 
          $pauseonmouseover=false;
         
         if(isset($_POST['linkimage']))
           $linkimage=true;  
         else 
          $linkimage=false;
         
         $scroll=intval(trim(htmlentities(sanitize_text_field($_POST['scroll']),ENT_QUOTES)));
         
         if($scroll=="")
          $scroll=1;
         
         $imageMargin=(int)trim(htmlentities(sanitize_text_field($_POST['imageMargin']),ENT_QUOTES));
         $imageheight=(int)trim(htmlentities(sanitize_text_field($_POST['imageheight']),ENT_QUOTES));
         $imagewidth=(int)trim(htmlentities(sanitize_text_field($_POST['imagewidth']),ENT_QUOTES));
         
         $scollerBackground=trim(htmlentities(sanitize_text_field($_POST['scollerBackground']),ENT_QUOTES));
         
         $options=array();
         $options['linkimage']=$linkimage;  
         $options['pauseonmouseover']=$pauseonmouseover;  
         $options['auto']=$auto;  
         $options['speed']=$speed;  
         $options['pause']=$pause;  
         $options['circular']=$circular;  
         //$options['scrollerwidth']=$scrollerwidth;  
         $options['imageMargin']=$imageMargin;  
         $options['imageheight']=$imageheight;  
         $options['imagewidth']=$imagewidth;  
         $options['visible']=$visible;  
         $options['min_visible']=$min_visible;  
         $options['scroll']=$scroll;  
         $options['resizeImages']=1;  
         $options['scollerBackground']=$scollerBackground;  
         $options['show_caption']=$show_caption;  
         $options['show_pager']=$show_pager;  
        
         
         $settings=update_option('responsive_thumbnail_slider_settings',$options); 
         $responsive_thumbnail_slider_messages=array();
         $responsive_thumbnail_slider_messages['type']='succ';
         $responsive_thumbnail_slider_messages['message']=__( 'Settings saved successfully.','wp-responsive-thumbnail-slider');
         update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);

        
         
     }  
      $settings=get_option('responsive_thumbnail_slider_settings');
      
?>      
<div id="poststuff" > 
   <div id="post-body" class="metabox-holder columns-2" >  
      <div id="post-body-content">
          <div class="wrap">
              <table><tr>
                     <td>
                          <div class="fb-like" data-href="https://www.facebook.com/i13websolution" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
                          <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=158817690866061&autoLogAppEvents=1';
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                      </td>
                      <td>
                          <a target="_blank" title="<?php echo __( 'Donate','wp-responsive-thumbnail-slider');?>" href="http://www.i13websolution.com/donate-wordpress_image_thumbnail.php">
                              <img id="<?php echo __( 'help us for free plugin','wp-responsive-thumbnail-slider');?>" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="<?php echo __( 'help us for free plugin','wp-responsive-thumbnail-slider');?>" title="<?php echo __( 'help us for free plugin','wp-responsive-thumbnail-slider');?>">
                          </a>
                      </td>
                  </tr>
              </table>

              <?php
                  $messages=get_option('responsive_thumbnail_slider_messages'); 
                  $type='';
                  $message='';
                  if(isset($messages['type']) and $messages['type']!=""){

                      $type=$messages['type'];
                      $message=$messages['message'];

                  }  


                 if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                 else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}
        


                  update_option('responsive_thumbnail_slider_messages', array());     
              ?>      
              <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/"><?php echo __( 'UPGRADE TO PRO VERSION','wp-responsive-thumbnail-slider');?></a></h3></span>
              <h1><?php echo __( 'Slider Settings','wp-responsive-thumbnail-slider');?></h1>
              <div id="poststuff">
                  <div id="post-body" class="metabox-holder columns-2">
                      <div id="post-body-content">
                          <form method="post" action="" id="scrollersettiings" name="scrollersettiings" >

                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label><?php echo __( 'Link images with url ?','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="checkbox" id="linkimage" size="30" name="linkimage" value="" <?php if($settings['linkimage']==true){echo "checked='checked'";} ?> style="width:20px;">&nbsp;<?php echo __( 'Add link to image ?','wp-responsive-thumbnail-slider');?> 
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>
                                      <div style="clear:both"></div>
                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label><?php echo __( 'Auto Scroll ?','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <?php $settings['auto']=(int)$settings['auto'];?>
                                                  <input style="width:20px;" type='radio' <?php if($settings['auto']==1){echo "checked='checked'";}?>  name='isauto' value='auto' ><?php echo __( 'Auto','wp-responsive-thumbnail-slider');?> &nbsp;<input style="width:20px;" type='radio' name='isauto' <?php if($settings['auto']==0){echo "checked='checked'";} ?> value='manuall' ><?php echo __( 'Scroll By Left & Right Arrow','wp-responsive-thumbnail-slider');?> &nbsp; &nbsp;<input style="width:20px;" type='radio' name='isauto' <?php if($settings['auto']==2){echo "checked='checked'";} ?> value='both' ><?php echo __( 'Scroll Auto With Arrow','wp-responsive-thumbnail-slider');?>
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>
                                      <div style="clear:both"></div>
                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label ><?php echo __( 'Speed','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="text" id="speed" size="30" name="speed" value="<?php echo $settings['speed']; ?>" style="width:100px;">
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>
                                      <div style="clear:both"></div>

                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label ><?php echo __( 'Pause','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="text" id="pause" size="30" name="pause" value="<?php echo $settings['pause']; ?>" style="width:100px;">
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>
                                      <div style="clear:both"><?php echo __( 'The amount of time (in ms) between each auto transition','wp-responsive-thumbnail-slider');?></div>

                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label ><?php echo __( 'Circular Slider ?','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="checkbox" id="circular" size="30" name="circular" value="" <?php if($settings['circular']==true){echo "checked='checked'";} ?> style="width:20px;">&nbsp;<?php echo __( 'Circular Slider ?','wp-responsive-thumbnail-slider');?> 
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>
                                      <div style="clear:both"></div>

                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label><?php echo __( 'Slider Background Color','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="text" id="scollerBackground" size="30" name="scollerBackground" value="<?php echo $settings['scollerBackground']; ?>" style="width:100px;">
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>

                                      <div style="clear:both"></div>
                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label><?php echo __( 'Max Visible','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="text" id="visible" size="30" name="visible" value="<?php echo $settings['visible']; ?>" style="width:100px;">
                                                  <div style="clear:both"><?php echo __( 'This will decide your slider width automatically','wp-responsive-thumbnail-slider');?></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>
                                      <?php echo __( 'Specify the number of items visible at all times within the slider.','wp-responsive-thumbnail-slider');?>
                                      <div style="clear:both"></div>

                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                 <h3><label><?php echo __( 'Min Visible','wp-responsive-thumbnail-slider');?></label></h3>
                                <div class="inside">
                                     <table>
                                       <tr>
                                         <td>
                                           <input type="text" id="min_visible" size="30" name="min_visible" value="<?php echo $settings['min_visible']; ?>" style="width:100px;">
                                           <div style="clear:both"><?php echo __( 'This will decide your slider width in responsive layout','wp-responsive-thumbnail-slider');?></div>
                                           <div></div>
                                         </td>
                                       </tr>
                                     </table>
                                     <?php echo __( 'The responsive layout decide by slider itself using min visible.','wp-responsive-thumbnail-slider');?>
                                     <div style="clear:both"></div>
                                   
                                 </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label><?php echo __( 'Scroll','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="text" id="scroll" size="30" name="scroll" value="<?php echo $settings['scroll']; ?>" style="width:100px;">
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>
                                      <?php echo __( 'You can specify the number of items to scroll when you click the next or prev buttons.','wp-responsive-thumbnail-slider');?>
                                      <div style="clear:both"></div>
                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label><?php echo __( 'Pause On Mouse Over ?','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="checkbox" id="pauseonmouseover" size="30" name="pauseonmouseover" value="" <?php if($settings['pauseonmouseover']==true){echo "checked='checked'";} ?> style="width:20px;">&nbsp;<?php echo __( 'Pause On Mouse Over ?','wp-responsive-thumbnail-slider');?> 
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>
                                      <div style="clear:both"></div>
                                  </div>
                              </div>
                          
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label><?php echo __( 'Image Height','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="text" id="imageheight" size="30" name="imageheight" value="<?php echo $settings['imageheight']; ?>" style="width:100px;">
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>

                                      <div style="clear:both"></div>
                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label><?php echo __( 'Image Width','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="text" id="imagewidth" size="30" name="imagewidth" value="<?php echo $settings['imagewidth']; ?>" style="width:100px;">
                                                  <div style="clear:both"></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>

                                      <div style="clear:both"></div>
                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                  <h3><label><?php echo __( 'Image Margin','wp-responsive-thumbnail-slider');?></label></h3>
                                  <div class="inside">
                                      <table>
                                          <tr>
                                              <td>
                                                  <input type="text" id="imageMargin" size="30" name="imageMargin" value="<?php echo $settings['imageMargin']; ?>" style="width:100px;">
                                                  <div style="clear:both;padding-top:5px"><?php echo __( 'Gap between two images','wp-responsive-thumbnail-slider');?></div>
                                                  <div></div>
                                              </td>
                                          </tr>
                                      </table>

                                      <div style="clear:both"></div>
                                  </div>
                              </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                <h3><label><?php echo __( 'Show Caption ?','wp-responsive-thumbnail-slider');?></label></h3>
                               <div class="inside">
                                    <table>
                                      <tr>
                                        <td>
                                          <input style="width:20px;" type='radio' <?php if($settings['show_caption']==true){echo "checked='checked'";}?>  name='show_caption' value='1' ><?php echo __( 'Yes','wp-responsive-thumbnail-slider');?> &nbsp;<input style="width:20px;" type='radio' name='show_caption' <?php if($settings['show_caption']==false){echo "checked='checked'";} ?> value='0' ><?php echo __( 'No','wp-responsive-thumbnail-slider');?>
                                          <div style="clear:both"></div>
                                          <div></div>
                                        </td>
                                      </tr>
                                    </table>
                                    <div style="clear:both"></div>
                                </div>
                             </div>
                              <div class="stuffbox" id="namediv" style="width:100%;">
                                <h3><label><?php echo __( 'Show Pager ?','wp-responsive-thumbnail-slider');?></label></h3>
                               <div class="inside">
                                    <table>
                                      <tr>
                                        <td>
                                          <input style="width:20px;" type='radio' <?php if($settings['show_pager']==true){echo "checked='checked'";}?>  name='show_pager' value='1' ><?php echo __( 'Yes','wp-responsive-thumbnail-slider');?> &nbsp;<input style="width:20px;" type='radio' name='show_pager' <?php if($settings['show_pager']==false){echo "checked='checked'";} ?> value='0' ><?php echo __( 'No','wp-responsive-thumbnail-slider');?>
                                          <div style="clear:both"></div>
                                          <div></div>
                                        </td>
                                      </tr>
                                    </table>
                                    <div style="clear:both"></div>
                                </div>
                             </div>
                               <?php wp_nonce_field('action_settings_add_edit','add_edit_nonce'); ?>  
                              <input type="submit"  name="btnsave" id="btnsave" value="<?php echo __( 'Save Changes','wp-responsive-thumbnail-slider');?>" class="button-primary">&nbsp;&nbsp;<input type="button" name="cancle" id="cancle" value="<?php echo __( 'Cancel','wp-responsive-thumbnail-slider');?>" class="button-primary" onclick="location.href='admin.php?page=responsive_thumbnail_slider_image_management'">
                              
                          </form> 
                          <script type="text/javascript">

                              jQuery(document).ready(function() {

                                      jQuery("#scrollersettiings").validate({
                                              rules: {
                                                  isauto: {
                                                      required:true
                                                  },speed: {
                                                      required:true, 
                                                      number:true, 
                                                      maxlength:15
                                                  },pause: {
                                                      required:true, 
                                                      number:true, 
                                                      maxlength:15
                                                  },
                                                  visible:{
                                                      required:true,  
                                                      number:true,
                                                      maxlength:15

                                                  },
                                                  min_visible:{
                                                      required:true,  
                                                      number:true,
                                                      maxlength:15

                                                  },
                                                  scroll:{
                                                      required:true,
                                                      number:true,
                                                      maxlength:15  
                                                  },
                                                  scollerBackground:{
                                                      required:true,
                                                      maxlength:7  
                                                  },
                                                  /*scrollerwidth:{
                                                  required:true,
                                                  number:true,
                                                  maxlength:15    
                                                  },*/imageheight:{
                                                      required:true,
                                                      number:true,
                                                      maxlength:15    
                                                  },
                                                  imagewidth:{
                                                      required:true,
                                                      number:true,
                                                      maxlength:15    
                                                  },imageMargin:{
                                                      required:true,
                                                      number:true,
                                                      maxlength:15    
                                                  }

                                              },
                                              errorClass: "image_error",
                                              errorPlacement: function(error, element) {
                                                  error.appendTo( element.next().next());
                                              } 


                                      })
                                      
                                       jQuery('#scollerBackground').wpColorPicker();
                                       
                              });

                          </script> 

                      </div>
                  </div>
              </div>  
          </div>      
      </div>
      <div id="postbox-container-1" class="postbox-container" > 

            <div class="postbox"> 
                <h3 class="hndle"><span></span><?php echo __( 'New DIVI AI Theme','wp-responsive-thumbnail-slider');?></h3> 
                <div class="inside">
                    <center><a href="https://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715&url=80806" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/divi_300x250.jpg', __FILE__ );?>" width="250" height="250"></a></center>

                    <div style="margin:10px 5px">

                    </div>
                </div></div>
            <div class="postbox"> 
                <h3 class="hndle"><span></span><?php echo __('Google For Business Coupon','wp-responsive-thumbnail-slider');?></h3> 
                    <div class="inside">
                        <center><a href="https://goo.gl/OJBuHT" target="_blank">
                                <img src="<?php echo plugins_url( 'images/g-suite-promo-code-4.png', __FILE__ );?>" width="250" height="250" border="0">
                            </a></center>
                        <div style="margin:10px 5px">
                        </div>
                    </div>
                    
                </div>

        </div>      
     <div class="clear"></div>
  </div>  
 </div> 
<?php
   }        
   function responsive_thumbnail_image_management(){
     
     $action='gridview';
      global $wpdb;
      
     
      if(isset($_GET['action']) and $_GET['action']!=''){
         
   
         $action=trim(sanitize_text_field($_GET['action']));
       }
       
    ?>
    <?php
      if (isset ( $_GET ['action'] ) and $_GET ['action'] != '') {
		
		$action = trim ( sanitize_text_field($_GET ['action'] ));
                
                if(isset($_GET['order_by'])){
        
                    if(sanitize_sql_orderby($_GET['order_by'])){
                        $order_by=trim($_GET['order_by']); 
                    }
                    else{
                        
                        $order_by=' id ';
                    }
                 }

                 if(isset($_GET['order_pos'])){

                    $order_pos=trim(sanitize_text_field($_GET['order_pos'])); 
                 }

                 $search_term_='';
                 if(isset($_GET['search_term'])){

                    $search_term_='&search_term='.urlencode(esc_html(sanitize_text_field($_GET['search_term'])));
                 }
	}
        
         $search_term_='';
        if(isset($_GET['search_term'])){

           $search_term_='&search_term='.urlencode(esc_html(sanitize_text_field($_GET['search_term'])));
        }
	?>
  <?php 
      if(strtolower($action)==strtolower('gridview')){ 
      
          
          if ( ! current_user_can( 'rts_responsive_thumbnail_slider_view_images' ) ) {

                wp_die( __( "Access Denied", "wp-responsive-thumbnail-slider" ) );

           }
           
          $wpcurrentdir=dirname(__FILE__);
          $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
          $url = plugin_dir_url(__FILE__);  
      
   ?> 
          <div id="modelMainDiv" style="display:none;z-index: 1000; border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt; left: 0pt; background-color: rgb(0, 0, 0); opacity: 0.2; cursor: wait; position: fixed;filter:alpha(opacity=15)" ></div>
            <div id="LoaderDiv" style="display:none;z-index: 1000; border: medium none; margin: 0pt; padding: 0pt; width: 100%; height: 100%; top: 0pt; left: 0pt; background-color: rgb(0, 0, 0); opacity: 0.2; cursor: wait; position: fixed;filter:alpha(opacity=15)" ></div>
            <div id="ContainDiv" style="display:none;z-index: 1056; position: fixed; padding: 5px; margin: 0px; width: 30%; top: 40%; left: 35%; text-align: center; color: rgb(0, 0, 0); border: 1px solid #999999; background-color: rgb(255, 255, 255); cursor: wait;" >
              <img src="<?php echo $url.'images/loading.gif'?>" />
               <h5 id="wait"><?php echo __('Please wait while uploading images...','wp-responsive-thumbnail-slider');?></h5>
            </div>
            
          <div id="poststuff"  class="wrap">
              <div id="post-body" class="metabox-holder columns-2">
                  <table><tr>
                          <td>
                          <div class="fb-like" data-href="https://www.facebook.com/i13websolution" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
                          <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=158817690866061&autoLogAppEvents=1';
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                      </td>
                          <td>
                              <a target="_blank" title="Donate" href="http://www.i13websolution.com/donate-wordpress_image_thumbnail.php">
                                  <img id="help us for free plugin" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="<?php echo __( 'help us for free plugin','wp-responsive-thumbnail-slider');?>" title="<?php echo __( 'help us for free plugin','wp-responsive-thumbnail-slider');?>">
                              </a>
                          </td>
                      </tr>
                  </table>

                  <?php 

                      $messages=get_option('responsive_thumbnail_slider_messages'); 
                      $type='';
                      $message='';
                      if(isset($messages['type']) and $messages['type']!=""){

                          $type=$messages['type'];
                          $message=$messages['message'];

                      }  


                      if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                      else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}
        


                      update_option('responsive_thumbnail_slider_messages', array());   
                      
                      $uploads = wp_upload_dir ();
                      $baseDir = $uploads ['basedir'];
                      $baseDir = str_replace ( "\\", "/", $baseDir );

                      $baseurl=$uploads['baseurl'];
                      $baseurl.='/wp-responsive-images-thumbnail-slider/';
                      $pathToImagesFolder = $baseDir . '/wp-responsive-images-thumbnail-slider';

                  ?>

                  <div id="post-body-content" >  
                      <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/"><?php echo __( 'UPGRADE TO PRO VERSION','wp-responsive-thumbnail-slider');?></a></h3></span>
                      <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                      <h1><?php echo __( 'Images','wp-responsive-thumbnail-slider');?> 
                          <a class="button add-new-h2" href="admin.php?page=responsive_thumbnail_slider_image_management&action=addedit"><?php echo __( 'Add New','wp-responsive-thumbnail-slider');?></a> 
                       &nbsp;&nbsp;
                       <a class="massAdd button add-new-h2" href="javascript:void(0)"><?php echo __('Mass Add','wp-responsive-thumbnail-slider');?></a>
                      </h1>
                      <br/>
                      <br/>
                      <form method="POST" action="admin.php?page=responsive_thumbnail_slider_image_management&action=deleteselected"  id="posts-filter" onkeypress="return event.keyCode != 13;">
                          <div class="alignleft actions">
                              <select name="action_upper">
                                  <option selected="selected" value="-1"><?php echo __( 'Bulk Actions','wp-responsive-thumbnail-slider');?></option>
                                  <option value="delete"><?php echo __( 'Delete','wp-responsive-thumbnail-slider');?></option>
                              </select>
                              <input type="submit" value="<?php echo __( 'Apply','wp-responsive-thumbnail-slider');?>" class="button-secondary action" id="deleteselected" name="deleteselected">
                          </div>
                          <br class="clear">
                           <?php
                                $setacrionpage='admin.php?page=responsive_thumbnail_slider_image_management';

                                if(isset($_GET['order_by']) and $_GET['order_by']!=""){
                                  $setacrionpage.='&order_by='.esc_html(sanitize_text_field($_GET['order_by']));   
                                }

                                if(isset($_GET['order_pos']) and $_GET['order_pos']!=""){
                                 $setacrionpage.='&order_pos='.esc_html(sanitize_text_field($_GET['order_pos']));   
                                }

                                $seval="";
                                if(isset($_GET['search_term']) and $_GET['search_term']!=""){
                                 $seval=trim(esc_html(sanitize_text_field($_GET['search_term'])));   
                                }

                            ?>
                          <?php 

                                 $settings=get_option('responsive_thumbnail_slider_settings'); 
                                 $visibleImages=$settings['visible'];
                              
                                $order_by='id';
                                $order_pos="asc";

                                if(isset($_GET['order_by']) and sanitize_sql_orderby($_GET['order_by'])!==false){

                                   $order_by=trim(esc_html(sanitize_text_field($_GET['order_by']))); 
                                }

                                if(isset($_GET['order_pos'])){

                                   $order_pos=trim(esc_html(sanitize_text_field($_GET['order_pos']))); 
                                }
                                 $search_term='';
                                if(isset($_GET['search_term'])){

                                   $search_term= sanitize_text_field(esc_sql($_GET['search_term']));
                                }
                                
                              $query="SELECT * FROM ".$wpdb->prefix."responsive_thumbnail_slider";
                              $queryCount="SELECT count(*) FROM ".$wpdb->prefix."responsive_thumbnail_slider";
                              if($search_term!=''){
                                $query.=" where id like '%$search_term%' or title like '%$search_term%' "; 
                                $queryCount.=" where id like '%$search_term%' or title like '%$search_term%' "; 
                              }

                              $order_by=sanitize_text_field(sanitize_sql_orderby($order_by));
                              $order_pos=sanitize_text_field(sanitize_sql_orderby($order_pos));
                              
                              $rowsCount=$wpdb->get_var($queryCount);

                              $query.=" order by $order_by $order_pos";
                              $query1="SELECT count(*) FROM ".$wpdb->prefix."responsive_thumbnail_slider";
                              $rowCount=$wpdb->get_var($query1);
                              
                         
                          ?>
                          <?php if($rowCount<$visibleImages){ ?>
                              <h4 style="color: green"><?php echo __( 'Current slider setting - Total visible images ','wp-responsive-thumbnail-slider');?><?php echo $visibleImages; ?></h4>
                              <h4 style="color: green"><?php echo __( 'Please add atleast ','wp-responsive-thumbnail-slider');?><?php echo $visibleImages; ?> <?php echo __( ' images','wp-responsive-thumbnail-slider');?></h4>
                              <?php 
                              
                          } else{
                                  echo "<br/>";
                          }?>
                              
                          <div style="padding-top:5px;padding-bottom:5px">
                                <b><?php echo __( 'Search','wp-responsive-thumbnail-slider');?> : </b>
                                  <input type="text" value="<?php echo $seval;?>" id="search_term" name="search_term">&nbsp;
                                  <input type='button'  value='<?php echo __( 'Search','wp-responsive-thumbnail-slider');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;
                                  <input type='button'  value='<?php echo __( 'Reset Search','wp-responsive-thumbnail-slider');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" >
                            </div>  
                            <script type="text/javascript" >
                                jQuery('#search_term').on("keyup", function(e) {
                                       if (e.which == 13) {

                                           SearchredirectTO();
                                       }
                                  });   
                             function SearchredirectTO(){
                               var redirectto='<?php echo $setacrionpage; ?>';
                               var searchval=jQuery('#search_term').val();
                               redirectto=redirectto+'&search_term='+jQuery.trim(encodeURIComponent(searchval));  
                               window.location.href=redirectto;
                             }
                            function ResetSearch(){

                                 var redirectto='<?php echo $setacrionpage; ?>';
                                 window.location.href=redirectto;
                                 exit;
                            }
                            </script>      
                          <div id="no-more-tables">
                          <table cellspacing="0" id="gridTbl" class="table-bordered table-striped table-condensed cf" >
                              <thead>
                                  <tr>
                                  <th class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
                                  <?php if($order_by=="title" and $order_pos=="asc"):?>
                                        <th><a href="<?php echo $setacrionpage;?>&order_by=title&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Title','wp-responsive-thumbnail-slider');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                   <?php else:?>
                                       <?php if($order_by=="title"):?>
                                   <th><a href="<?php echo $setacrionpage;?>&order_by=title&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Title','wp-responsive-thumbnail-slider');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                       <?php else:?>
                                           <th><a href="<?php echo $setacrionpage;?>&order_by=title&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Title','wp-responsive-thumbnail-slider');?></a></th>
                                       <?php endif;?>    
                                   <?php endif;?>  
                                   <th><span></span></th>
                                  <?php if($order_by=="createdon" and $order_pos=="asc"):?>
                                    <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Published On','wp-responsive-thumbnail-slider');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                    <?php else:?>
                                        <?php if($order_by=="createdon"):?>
                                    <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Published On','wp-responsive-thumbnail-slider');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                        <?php else:?>
                                            <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Published On','wp-responsive-thumbnail-slider');?></a></th>
                                        <?php endif;?>    
                                    <?php endif;?> 
                                  <th><span><?php echo __( 'Edit','wp-responsive-thumbnail-slider');?></span></th>
                                  <th><span><?php echo __( 'Delete','wp-responsive-thumbnail-slider');?></span></th>
                                  </tr>
                              </thead>
                              
                              <tbody id="the-list">
                                  <?php

                                      if($rowsCount > 0){

                                          global $wp_rewrite;
                                          $rows_per_page = 5;

                                          $current = (isset($_GET['paged'])) ? ((int)$_GET['paged']) : 1;
                                          $pagination_args = array(
                                              'base' => @add_query_arg('paged','%#%'),
                                              'format' => '',
                                              'total' => ceil($rowsCount/$rows_per_page),
                                              'current' => $current,
                                              'show_all' => false,
                                              'type' => 'plain',
                                          );


                                          $offset = ($current - 1) * $rows_per_page;
                                          $query.=" limit $offset, $rows_per_page";
                                          $rows = $wpdb->get_results ( $query ,ARRAY_A);

                                          $delRecNonce=wp_create_nonce('delete_image');
                                          foreach ($rows as $row ) {

                                              $id=$row['id'];
                                              $editlink="admin.php?page=responsive_thumbnail_slider_image_management&action=addedit&id=$id";
                                              $deletelink="admin.php?page=responsive_thumbnail_slider_image_management&action=delete&id=$id&nonce=$delRecNonce";
                                              
                                              $outputimgmain = $baseurl.$row['image_name']; 
                                             

                                          ?>
                                          <tr valign="top" >
                                              <td class="alignCenter check-column"   data-title="<?php echo __( 'Select Record','wp-responsive-thumbnail-slider');?>" ><input type="checkbox" value="<?php echo $row['id'] ?>" name="thumbnails[]"></td>
                                              <td   data-title="<?php echo __( 'Title','wp-responsive-thumbnail-slider');?>" ><strong><?php echo $row['title']; ?></strong></td>  
                                              <td  data-title="<?php echo __( 'Image','wp-responsive-thumbnail-slider');?>" class="alignCenter">
                                              <img src="<?php echo $outputimgmain;?>" style="width:50px" height="50px"/>
                                          </td> 
                                              <td class="alignCenter"   data-title="<?php echo __( 'Published On','wp-responsive-thumbnail-slider');?>" ><?php echo $row['createdon'] ?></td>
                                              <td class="alignCenter"   data-title="<?php echo __( 'Edit Record','wp-responsive-thumbnail-slider');?>" ><strong><a href='<?php echo $editlink; ?>' title="<?php echo __( 'Edit','wp-responsive-thumbnail-slider');?>"><?php echo __( 'Edit','wp-responsive-thumbnail-slider');?></a></strong></td>  
                                              <td class="alignCenter"   data-title="<?php echo __( 'Delete Record','wp-responsive-thumbnail-slider');?>" ><strong><a href='<?php echo $deletelink; ?>' onclick="return confirmDelete();"  title="<?php echo __( 'Delete','wp-responsive-thumbnail-slider');?>"><?php echo __( 'Delete','wp-responsive-thumbnail-slider');?></a> </strong></td>  
                                          </tr>
                                          <?php 
                                          } 
                                      }
                                      else{
                                      ?>

                                         <tr valign="top" class="" id="">
                                           <td colspan="6" data-title="<?php echo __( 'No Record','wp-responsive-thumbnail-slider');?>" align="center"><strong><?php echo __( 'No Images Found','wp-responsive-thumbnail-slider');?></strong></td>  
                                         </tr>
                 
                                      <?php 
                                      } 
                                  ?>      
                              </tbody>
                          </table>
                          </div>
                          <?php
                              if($rowsCount>0){
                                  echo "<div class='pagination' style='padding-top:10px'>";
                                  echo paginate_links($pagination_args);
                                  echo "</div>";
                              }
                          ?>
                          <br/>
                          <div class="alignleft actions">
                              <select name="action">
                                  <option selected="selected" value="-1"><?php echo __( 'Bulk Actions','wp-responsive-thumbnail-slider');?></option>
                                  <option value="delete"><?php echo __( 'Delete','wp-responsive-thumbnail-slider');?></option>
                              </select>
                              <?php wp_nonce_field('action_settings_mass_delete','mass_delete_nonce'); ?>
                              <input type="submit" value="<?php echo __( 'Apply','wp-responsive-thumbnail-slider');?>" class="button-secondary action" id="deleteselected" name="deleteselected">
                          </div>

                      </form>
                      <script>

                          function  confirmDelete(){
                              var agree=confirm("<?php echo __( 'Are you sure you want to delete this image?','wp-responsive-thumbnail-slider');?>");
                              if (agree)
                                  return true ;
                              else
                                  return false;
                          }
                          
                          
                        
                                    
                                    var nonce_sec='<?php echo wp_create_nonce( "thumbnail-mass-image" );?>';
                                    jQuery(document).ready(function() {
                                           //uploading files variable
                                           var custom_file_frame;
                                           jQuery(".massAdd").click(function(event) {
                                              var slider_id=jQuery(this).attr('id'); 
                                              event.preventDefault();
                                              //If the frame already exists, reopen it
                                              if (typeof(custom_file_frame)!=="undefined") {
                                                 custom_file_frame.close();
                                              }

                                              //Create WP media frame.
                                              custom_file_frame = wp.media.frames.customHeader = wp.media({
                                                 //Title of media manager frame
                                                 title: "<?php echo __("WP Media Uploader",'wp-responsive-thumbnail-slider');?>",
                                                 library: {
                                                    type: 'image'
                                                 },
                                                 button: {
                                                    //Button text
                                                    text: "<?php echo __("Set Image",'wp-responsive-thumbnail-slider');?>"
                                                 },
                                                 //Do not allow multiple files, if you want multiple, set true
                                                 multiple: true
                                              });

                                              //callback for selected image

                                              custom_file_frame.on('select', function() {


                                                    jQuery("#modelMainDiv").show();
                                                    jQuery("#LoaderDiv").show();
                                                    jQuery("#ContainDiv").show();
                                                    var selection = custom_file_frame.state().get('selection');
                                                    selection.map(function(attachment) {

                                                        attachment = attachment.toJSON();
                                                        var validExtensions=new Array();
                                                        validExtensions[0]='jpg';
                                                        validExtensions[1]='jpeg';
                                                        validExtensions[2]='png';
                                                        validExtensions[3]='gif';


                                                        var inarr=parseInt(jQuery.inArray( attachment.subtype, validExtensions));

                                                        if(inarr>0 && attachment.type.toLowerCase()=='image' ){

                                                              var titleTouse="";
                                                              var imageDescriptionTouse="";

                                                              if(jQuery.trim(attachment.title)!=''){

                                                                 titleTouse=jQuery.trim(attachment.title); 
                                                              }  
                                                              else if(jQuery.trim(attachment.caption)!=''){

                                                                 titleTouse=jQuery.trim(attachment.caption);  
                                                              }

                                                              if(jQuery.trim(attachment.description)!=''){

                                                                 imageDescriptionTouse=jQuery.trim(attachment.description); 
                                                              }  
                                                              else if(jQuery.trim(attachment.caption)!=''){

                                                                 imageDescriptionTouse=jQuery.trim(attachment.caption);  
                                                              }

                                                              var data = {
                                                                        imagetitle:titleTouse,
                                                                        image_description: imageDescriptionTouse,
                                                                        attachment_id:attachment.id,
                                                                        slider_id:slider_id,
                                                                        action: 'mass_upload_wrthslider',
                                                                        thumbnail_security:nonce_sec
                                                                    };

                                                                url='admin.php?page=responsive_thumbnail_slider_image_management&action=mass_upload_wrthslider';
                                                                jQuery.ajax({
                                                                      type: 'POST',
                                                                      url: ajaxurl,
                                                                      data: data,
                                                                      success: function(result) {
                                                                          if(result.isOk == false)
                                                                              alert(result.message);
                                                                      },
                                                                      dataType:'html'
                                                                      
                                                                    });


                                                        }  

                                                    });

                                                    jQuery("#modelMainDiv").hide();
                                                    jQuery("#LoaderDiv").hide();
                                                    jQuery("#ContainDiv").hide();

                                                });
                                                
                                                 custom_file_frame.on('close', function() {
                                                     setTimeout(function() {window.location.reload();}, 500);

                                                     
                                                  });
                                                
                                              //Open modal
                                              custom_file_frame.open();
                                           });
                                        })
                                    
                      </script>

                      <br class="clear">
                      
                      <h3><?php echo __( 'To print this slider into WordPress Post/Page use below Shortcode','wp-responsive-thumbnail-slider');?></h3>
                      <input type="text" value="[print_responsive_thumbnail_slider]" style="width: 400px;height: 30px" onclick="this.focus();this.select()" />
                      <div class="clear"></div>
                      <h3><?php echo __( 'To print this slider into WordPress theme/template PHP files use below php code','wp-responsive-thumbnail-slider');?></h3>
                      <input type="text" value="echo do_shortcode('[print_responsive_thumbnail_slider]');" style="width: 400px;height: 30px" onclick="this.focus();this.select()" />
                    
                      <div class="clear"></div>
                  </div>
                  <div id="postbox-container-1" class="postbox-container"> 
                      <div class="postbox"> 
                          <h3 class="hndle"><span></span><?php echo __( 'Recommended WordPress Themes','wp-responsive-thumbnail-slider');?></h3> 
                          <div class="inside">
                              <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/300x250.gif', __FILE__ );?>" width="250" height="250"></a></center>
                              <div style="margin:10px 5px">

                              </div>
                          </div></div>
                      <div class="postbox"> 
                        <h3 class="hndle"><span></span><?php echo __('Google For Business Coupon','wp-responsive-thumbnail-slider');?></h3> 
                            <div class="inside">
                                <center><a href="https://goo.gl/OJBuHT" target="_blank">
                                        <img src="<?php echo plugins_url( 'images/g-suite-promo-code-4.png', __FILE__ );?>" width="250" height="250" border="0">
                                    </a></center>
                                <div style="margin:10px 5px">
                                </div>
                            </div>

                        </div>

                      <div style="clear: both;"></div>
                      <?php $url = plugin_dir_url(__FILE__);  ?>


                  </div>  
              </div>
          </div>
     
<?php 
  }   
  else if(strtolower($action)==strtolower('addedit')){
      $url = plugin_dir_url(__FILE__);
       
    ?>
    <?php        
    if(isset($_POST['btnsave'])){
        
        
         if ( !check_admin_referer( 'action_image_add_edit','add_edit_image_nonce')){

            wp_die('Security check fail'); 
         }

        $uploads = wp_upload_dir ();
        $baseDir = $uploads ['basedir'];
        $baseDir = str_replace ( "\\", "/", $baseDir );
        $pathToImagesFolder = $baseDir . '/wp-responsive-images-thumbnail-slider';
       
       //edit save
       if(isset($_POST['imageid'])){
       
                if ( ! current_user_can( 'rts_responsive_thumbnail_slider_edit_image' ) ) {

                    $location='admin.php?page=responsive_thumbnail_slider_image_management';
                    $responsive_thumbnail_slider_messages=array();
                    $responsive_thumbnail_slider_messages['type']='err';
                    $responsive_thumbnail_slider_messages['message']=__('Access Denied. Please contact your administrator.','wp-responsive-thumbnail-slider');
                    update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                    exit;   

                }
           
              //add new
                $location='admin.php?page=responsive_thumbnail_slider_image_management';
                $title=trim(esc_html(sanitize_text_field($_POST['imagetitle'])));
                $title = str_replace("'", "’", $title);
                $title = str_replace('"', '”', $title);
                $imageurl=trim(htmlentities(esc_url_raw($_POST['imageurl']),ENT_QUOTES));
                $imageid=intval(htmlentities(sanitize_text_field($_POST['imageid']),ENT_QUOTES));
                
                     
                $imagename="";
                if(trim($_POST['HdnMediaSelection'])!=''){
                        
                    $postThumbnailID=(int) htmlentities(sanitize_text_field($_POST['HdnMediaSelection']),ENT_QUOTES);
                    $photoMeta = wp_get_attachment_metadata( $postThumbnailID );
                    if(is_array($photoMeta) and isset($photoMeta['file'])) {

                            $fileName=$photoMeta['file'];
                            $phyPath=ABSPATH;
                            $phyPath=str_replace("\\","/",$phyPath);

                            $pathArray=pathinfo($fileName);

                            $imagename=$pathArray['basename'];

                            $upload_dir_n = wp_upload_dir(); 
                            $upload_dir_n=$upload_dir_n['basedir'];
                            $fileUrl=$upload_dir_n.'/'.$fileName;
                            $fileUrl=str_replace("\\","/",$fileUrl);

                            $wpcurrentdir=dirname(__FILE__);
                            $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                            $imageUploadTo=$pathToImagesFolder.'/'.$imagename;
                            @copy($fileUrl, $imageUploadTo);
                             if(!file_exists($imageUploadTo)){
                                rsths_save_image_remote($fileUrl,$imageUploadTo);
                               }

                       }
                    }
                    
                try{
                        if($imagename!=""){
                            $query = "update ".$wpdb->prefix."responsive_thumbnail_slider set title='$title',image_name='$imagename',
                                      custom_link='$imageurl' where id=$imageid";
                         }
                        else{
                             $query = "update ".$wpdb->prefix."responsive_thumbnail_slider set title='$title',
                                       custom_link='$imageurl' where id=$imageid";
                        } 
                        $wpdb->query($query); 

                         $responsive_thumbnail_slider_messages=array();
                         $responsive_thumbnail_slider_messages['type']='succ';
                         $responsive_thumbnail_slider_messages['message']=__( 'Image updated successfully.','wp-responsive-thumbnail-slider');
                         update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);


                 }
               catch(Exception $e){

                     
                      $responsive_thumbnail_slider_messages=array();
                      $responsive_thumbnail_slider_messages['type']='err';
                      $responsive_thumbnail_slider_messages['message']=__( 'Error while updating image.','wp-responsive-thumbnail-slider');
                      update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                }  
                
                          
              echo "<script type='text/javascript'> location.href='$location';</script>";
              exit;
       }
      else{
      
             //add new
                
                 if ( ! current_user_can( 'rts_responsive_thumbnail_slider_add_image' ) ) {

                    $location='admin.php?page=responsive_thumbnail_slider_image_management';
                    $responsive_thumbnail_slider_messages=array();
                    $responsive_thumbnail_slider_messages['type']='err';
                    $responsive_thumbnail_slider_messages['message']=__('Access Denied. Please contact your administrator.','wp-responsive-thumbnail-slider');
                    update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                    exit;   

                }
                
                $location='admin.php?page=responsive_thumbnail_slider_image_management';
                $title=trim(esc_html(sanitize_text_field($_POST['imagetitle'])));
                $title = str_replace("'", "’", $title);
                $title = str_replace('"', '”', $title);
                $imageurl=trim(htmlentities(esc_url_raw($_POST['imageurl']),ENT_QUOTES));
                $createdOn=date('Y-m-d h:i:s');
                if(function_exists('date_i18n')){
                    
                    $createdOn=date_i18n('Y-m-d'.' '.get_option('time_format') ,false,false);
                    if(get_option('time_format')=='H:i')
                        $createdOn=date('Y-m-d H:i:s',strtotime($createdOn));
                    else   
                        $createdOn=date('Y-m-d h:i:s',strtotime($createdOn));
                        
                }
                

                    $location='admin.php?page=responsive_thumbnail_slider_image_management';

                    try{




                        if(trim($_POST['HdnMediaSelection'])!=''){

                                    $postThumbnailID=(int) htmlentities(strip_tags($_POST['HdnMediaSelection']),ENT_QUOTES);
                                    $photoMeta = wp_get_attachment_metadata( $postThumbnailID );

                                    if(is_array($photoMeta) and isset($photoMeta['file'])) {

                                        $fileName=$photoMeta['file'];
                                        $phyPath=ABSPATH;
                                        $phyPath=str_replace("\\","/",$phyPath);

                                        $pathArray=pathinfo($fileName);

                                        $imagename=$pathArray['basename'];

                                        $upload_dir_n = wp_upload_dir(); 
                                        $upload_dir_n=$upload_dir_n['basedir'];
                                        $fileUrl=$upload_dir_n.'/'.$fileName;
                                        $fileUrl=str_replace("\\","/",$fileUrl);

                                        $wpcurrentdir=dirname(__FILE__);
                                        $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                                        $imageUploadTo=$pathToImagesFolder.'/'.$imagename;

                                        @copy($fileUrl, $imageUploadTo);
                                         if(!file_exists($imageUploadTo)){
                                        rsths_save_image_remote($fileUrl,$imageUploadTo);
                                       }

                                    }

                            }



                           $query = "INSERT INTO ".$wpdb->prefix."responsive_thumbnail_slider (title, image_name,createdon,custom_link) 
                                     VALUES ('$title','$imagename','$createdOn','$imageurl')";

                           $wpdb->query($query); 

                            $responsive_thumbnail_slider_messages=array();
                            $responsive_thumbnail_slider_messages['type']='succ';
                            $responsive_thumbnail_slider_messages['message']=__('New image added successfully.','wp-responsive-thumbnail-slider');
                            update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);


                    }
                  catch(Exception $e){

                         $responsive_thumbnail_slider_messages=array();
                         $responsive_thumbnail_slider_messages['type']='err';
                         $responsive_thumbnail_slider_messages['message']=__('Error while adding image.','wp-responsive-thumbnail-slider');;
                         update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                   }  
                     
                         
                echo "<script type='text/javascript'> location.href='$location';</script>";     
                exit;     
            
       } 
        
    }
   else{ 
       
        $uploads = wp_upload_dir ();
        $baseurl=$uploads['baseurl'];
        $baseurl.='/wp-responsive-images-thumbnail-slider/';
        
  ?>
     <div id="poststuff">  
        <div id="post-body" class="metabox-holder columns-2" >
          <div id="post-body-content">
           <?php if(isset($_GET['id']) and intval($_GET['id'])>0)
               { 


                   $id= intval($_GET['id']);
                   $query="SELECT * FROM ".$wpdb->prefix."responsive_thumbnail_slider WHERE id=$id";
                   $myrow  = $wpdb->get_row($query);

                   if(is_object($myrow)){

                       $title=$myrow->title;
                       $image_link=$myrow->custom_link;
                       $image_name=$myrow->image_name;

                   }   

                    if ( ! current_user_can( 'rts_responsive_thumbnail_slider_edit_image' ) ) {

                        $location='admin.php?page=responsive_thumbnail_slider_image_management';
                        $responsive_thumbnail_slider_messages=array();
                        $responsive_thumbnail_slider_messages['type']='err';
                        $responsive_thumbnail_slider_messages['message']=__('Access Denied. Please contact your administrator.','wp-responsive-thumbnail-slider');
                        update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                        echo "<script type='text/javascript'> location.href='$location';</script>";     
                        exit;   

                    }
                    
               ?>

               <h1><?php echo __( 'Update Image','wp-responsive-thumbnail-slider');?> </h1>

               <?php 
               
                   }
               else{ 

                   $title='';
                   $image_link='';
                   $image_name='';
                   
                   if ( ! current_user_can( 'rts_responsive_thumbnail_slider_add_image' ) ) {

                        $location='admin.php?page=responsive_thumbnail_slider_image_management';
                        $responsive_thumbnail_slider_messages=array();
                        $responsive_thumbnail_slider_messages['type']='err';
                        $responsive_thumbnail_slider_messages['message']=__('Access Denied. Please contact your administrator.','wp-responsive-thumbnail-slider');
                        update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                        echo "<script type='text/javascript'> location.href='$location';</script>";     
                        exit;   

                    }

               ?>
               <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/product/wordpress-responsive-thumbnail-html-slider-pro/"><?php echo __( 'UPGRADE TO PRO VERSION','wp-responsive-thumbnail-slider');?></a></h3></span>
               <h1><?php echo __( 'Add Image','wp-responsive-thumbnail-slider');?> </h1>
               <?php } ?>

           <br/>
           <div id="poststuff">
               <div id="post-body" class="metabox-holder columns-2">
                   <div id="post-body-content">
                       <form method="post" action="" id="addimage" name="addimage" enctype="multipart/form-data" >
                              <div class="stuffbox" id="namediv" style="width:100%;">
                         <h3><label for="link_name"><?php echo __( 'Upload Image','wp-responsive-thumbnail-slider');?></label></h3>
                         <div class="inside" id="fileuploaddiv">
                              <?php if($image_name!=""){ ?>
                                    <div><b><?php echo __( 'Current Image ','wp-responsive-thumbnail-slider');?>: </b><a id="currImg" href="<?php echo $baseurl;?><?php echo $image_name; ?>" target="_new"><?php echo $image_name; ?></a></div>
                              <?php } ?>      
                         
                             <div></div>
                             <div class="uploader">
                              <br/>
                             
                                <a href="javascript:;" class="niks_media" id="myMediaUploader"><b><?php echo __( 'Click here to upload image','wp-responsive-thumbnail-slider');?></b></a>
                                <input id="HdnMediaSelection" name="HdnMediaSelection" type="hidden" value="" />
                              <br/>
                            </div>  
                            
                              <script>
                            jQuery(document).ready(function() {
                                   //uploading files variable
                                   var custom_file_frame;
                                   jQuery("#myMediaUploader").click(function(event) {
                                      event.preventDefault();
                                      //If the frame already exists, reopen it
                                      if (typeof(custom_file_frame)!=="undefined") {
                                         custom_file_frame.close();
                                      }
                                 
                                      //Create WP media frame.
                                      custom_file_frame = wp.media.frames.customHeader = wp.media({
                                         //Title of media manager frame
                                         title: "<?php echo __( 'WP Media Uploader','wp-responsive-thumbnail-slider');?>",
                                         library: {
                                            type: 'image'
                                         },
                                         button: {
                                            //Button text
                                            text: "<?php echo __( 'Set Image','wp-responsive-thumbnail-slider');?>"
                                         },
                                         //Do not allow multiple files, if you want multiple, set true
                                         multiple: false
                                      });
                                 
                                      //callback for selected image
                                      custom_file_frame.on('select', function() {
                                         
                                          var attachment = custom_file_frame.state().get('selection').first().toJSON();
                                          
                                           var validExtensions=new Array();
                                            validExtensions[0]='jpg';
                                            validExtensions[1]='jpeg';
                                            validExtensions[2]='png';
                                            validExtensions[3]='gif';
                                            
                                                        
                                            var inarr=parseInt(jQuery.inArray( attachment.subtype, validExtensions));
                                
                                            if(inarr>0 && attachment.type.toLowerCase()=='image' ){
                                                
                                                  var titleTouse="";
                                                  var imageDescriptionTouse="";
                                                  
                                                  if(jQuery.trim(attachment.title)!=''){
                                                      
                                                     titleTouse=jQuery.trim(attachment.title); 
                                                  }  
                                                  else if(jQuery.trim(attachment.caption)!=''){
                                                     
                                                     titleTouse=jQuery.trim(attachment.caption);  
                                                  }
                                                  
                                                  if(jQuery.trim(attachment.description)!=''){
                                                      
                                                     imageDescriptionTouse=jQuery.trim(attachment.description); 
                                                  }  
                                                  else if(jQuery.trim(attachment.caption)!=''){
                                                     
                                                     imageDescriptionTouse=jQuery.trim(attachment.caption);  
                                                  }
                                                  
                                                jQuery("#imagetitle").val(titleTouse);  
                                                jQuery("#image_description").val(imageDescriptionTouse);  
                                                
                                                if(attachment.id!=''){
                                                    jQuery("#HdnMediaSelection").val(attachment.id);  
                                                }   
                                                
                                            }  
                                            else{
                                                
                                                alert('<?php echo __( 'Invalid image selection.','wp-responsive-thumbnail-slider');?>');
                                            }  
                                             //do something with attachment variable, for example attachment.filename
                                             //Object:
                                             //attachment.alt - image alt
                                             //attachment.author - author id
                                             //attachment.caption
                                             //attachment.dateFormatted - date of image uploaded
                                             //attachment.description
                                             //attachment.editLink - edit link of media
                                             //attachment.filename
                                             //attachment.height
                                             //attachment.icon - don't know WTF?))
                                             //attachment.id - id of attachment
                                             //attachment.link - public link of attachment, for example ""http://site.com/?attachment_id=115""
                                             //attachment.menuOrder
                                             //attachment.mime - mime type, for example image/jpeg"
                                             //attachment.name - name of attachment file, for example "my-image"
                                             //attachment.status - usual is "inherit"
                                             //attachment.subtype - "jpeg" if is "jpg"
                                             //attachment.title
                                             //attachment.type - "image"
                                             //attachment.uploadedTo
                                             //attachment.url - http url of image, for example "http://site.com/wp-content/uploads/2012/12/my-image.jpg"
                                             //attachment.width
                                      });
                                 
                                      //Open modal
                                      custom_file_frame.open();
                                   });
                                })
                            </script>
                           
                         </div>
                       </div>
                           <div class="stuffbox" id="namediv" style="width:100%;">
                               <h3><label for="link_name"><?php echo __( 'Image Title','wp-responsive-thumbnail-slider');?></label></h3>
                               <div class="inside">
                                   <input type="text" id="imagetitle"  size="30" name="imagetitle" value="<?php echo $title;?>">
                                   <div style="clear:both"></div>
                                   <div></div>
                                   <div style="clear:both"></div>
                                   <p><?php _e('Used in image alt for seo','wp-responsive-thumbnail-slider'); ?></p>
                               </div>
                           </div>
                           <div class="stuffbox" id="namediv" style="width:100%;">
                               <h3><label for="link_name"><?php echo __( 'Image Url','wp-responsive-thumbnail-slider');?>(<?php _e('On click redirect to this url.','wp-responsive-thumbnail-slider'); ?>)</label></h3>
                               <div class="inside">
                                   <input type="text" id="imageurl" class=""   size="30" name="imageurl" value="<?php echo $image_link; ?>">
                                   <div style="clear:both"></div>
                                   <div></div>
                                   <div style="clear:both"></div>
                                   <p><?php _e('On image click users will redirect to this url.','wp-responsive-thumbnail-slider'); ?></p>
                               </div>
                           </div>
                        
                           <?php if(isset($_GET['id']) and intval($_GET['id'])>0){ ?> 
                               <input type="hidden" name="imageid" id="imageid" value="<?php echo intval($_GET['id']);?>">
                               <?php
                               } 
                           ?>
                           <?php wp_nonce_field('action_image_add_edit','add_edit_image_nonce'); ?>
                           <input type="submit" onclick="return validateFile();" name="btnsave" id="btnsave" value="<?php echo __( 'Save Changes','wp-responsive-thumbnail-slider');?>" class="button-primary">&nbsp;&nbsp;<input type="button" name="cancle" id="cancle" value="<?php echo __( 'Cancel','wp-responsive-thumbnail-slider');?>" class="button-primary" onclick="location.href='admin.php?page=responsive_thumbnail_slider_image_management'">

                       </form> 
                       <script type="text/javascript">

                           
                           jQuery(document).ready(function() {

                                   jQuery("#addimage").validate({
                                           rules: {
                                               imagetitle: {
                                                   required:true, 
                                                   maxlength: 200
                                               },imageurl: {
                                                   url2:true,  
                                                   maxlength: 500
                                               },
                                               image_name:{
                                                   isimage:true  
                                               }
                                           },
                                           errorClass: "image_error",
                                           errorPlacement: function(error, element) {
                                               error.appendTo( element.next().next().next());
                                           } 


                                   })
                           });

                            function validateFile(){

                                
                                if(jQuery('#currImg').length>0 || jQuery.trim(jQuery("#HdnMediaSelection").val())!="" ){
                                    return true;
                                }
                                else
                                    {
                                    jQuery("#err_daynamic").remove();
                                    jQuery("#myMediaUploader").after('<br/><label class="image_error" id="err_daynamic"><?php echo __( 'Please select file','wp-responsive-thumbnail-slider');?>.</label>');
                                    return false;  
                                } 

                            }
                                    
                                 
                       </script> 

                   </div>
               </div>
           </div>  
       </div>      
        
        <div id="postbox-container-1" class="postbox-container"> 
            <div class="postbox"> 
              <h3 class="hndle"><span></span><?php echo __( 'Access All Themes In One Price','wp-responsive-thumbnail-slider');?></h3> 
              <div class="inside">
                  <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/300x250.gif', __FILE__ );?>" width="250" height="250"></a></center>

                  <div style="margin:10px 5px">

                  </div>
              </div></div>
             <div class="postbox"> 
                <h3 class="hndle"><span></span><?php echo __('Google For Business Coupon','wp-responsive-thumbnail-slider');?></h3> 
                    <div class="inside">
                        <center><a href="https://goo.gl/OJBuHT" target="_blank">
                                <img src="<?php echo plugins_url( 'images/g-suite-promo-code-4.png', __FILE__ );?>" width="250" height="250" border="0">
                            </a></center>
                        <div style="margin:10px 5px">
                        </div>
                    </div>
                    
                </div>

           </div>
        </div>
    <?php 
    } 
  }  
       
  else if(strtolower($action)==strtolower('delete')){
  
           $retrieved_nonce = '';

            if(isset($_GET['nonce']) and $_GET['nonce']!=''){

                $retrieved_nonce=sanitize_text_field($_GET['nonce']);

            }
            if (!wp_verify_nonce($retrieved_nonce, 'delete_image' ) ){


                wp_die('Security check fail','wp-responsive-thumbnail-slider'); 
            }
           
          if ( ! current_user_can( 'rts_responsive_thumbnail_slider_delete_image' ) ) {

                $location='admin.php?page=responsive_thumbnail_slider_image_management';
                $responsive_thumbnail_slider_messages=array();
                $responsive_thumbnail_slider_messages['type']='err';
                $responsive_thumbnail_slider_messages['message']=__('Access Denied. Please contact your administrator.','wp-responsive-thumbnail-slider');
                update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                echo "<script type='text/javascript'> location.href='$location';</script>";     
                exit;   

         }
        $uploads = wp_upload_dir ();
        $baseDir = $uploads ['basedir'];
        $baseDir = str_replace ( "\\", "/", $baseDir );
        $pathToImagesFolder = $baseDir . '/wp-responsive-images-thumbnail-slider';

        $location='admin.php?page=responsive_thumbnail_slider_image_management';
        $deleteId=intval($_GET['id']);
                 
                try{
                         
                    
                        $query="SELECT * FROM ".$wpdb->prefix."responsive_thumbnail_slider WHERE id=$deleteId";
                        $myrow  = $wpdb->get_row($query);
                                    
                        if(is_object($myrow)){
                            
                            $image_name=$myrow->image_name;
                            $wpcurrentdir=dirname(__FILE__);
                            $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                            
                            $imagetoDel=$pathToImagesFolder.'/'.$image_name;
                            @unlink($imagetoDel);
                                        
                             $query = "delete from  ".$wpdb->prefix."responsive_thumbnail_slider where id=$deleteId";
                             $wpdb->query($query); 
                           
                             $responsive_thumbnail_slider_messages=array();
                             $responsive_thumbnail_slider_messages['type']='succ';
                             $responsive_thumbnail_slider_messages['message']=__( 'Image deleted successfully.','wp-responsive-thumbnail-slider');
                             update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                        }    

     
                 }
               catch(Exception $e){
               
                      $responsive_thumbnail_slider_messages=array();
                      $responsive_thumbnail_slider_messages['type']='err';
                      $responsive_thumbnail_slider_messages['message']=__( 'Error while deleting image.','wp-responsive-thumbnail-slider');
                      update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                }  
                          
          echo "<script type='text/javascript'> location.href='$location';</script>";
          exit;
              
  }  
  else if(strtolower($action)==strtolower('deleteselected')){
  
          if(!check_admin_referer('action_settings_mass_delete','mass_delete_nonce')){
               
                wp_die('Security check fail'); 
            }
            
            if ( ! current_user_can( 'rts_responsive_thumbnail_slider_delete_image' ) ) {

                    $location='admin.php?page=responsive_thumbnail_slider_image_management';
                    $responsive_thumbnail_slider_messages=array();
                    $responsive_thumbnail_slider_messages['type']='err';
                    $responsive_thumbnail_slider_messages['message']=__('Access Denied. Please contact your administrator.','wp-responsive-thumbnail-slider');
                    update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                    exit;   

             }
               
           $location='admin.php?page=responsive_thumbnail_slider_image_management'; 
           $uploads = wp_upload_dir ();
           $baseDir = $uploads ['basedir'];
           $baseDir = str_replace ( "\\", "/", $baseDir );
           $pathToImagesFolder = $baseDir . '/wp-responsive-images-thumbnail-slider';
          if(isset($_POST) and isset($_POST['deleteselected']) and  ( $_POST['action']=='delete' or $_POST['action_upper']=='delete')){
          
                if(sizeof($_POST['thumbnails']) >0){
                
                        $deleteto=$_POST['thumbnails'];
                        $implode=implode(',',$deleteto);   
                        
                        try{
                                
                               foreach($deleteto as $img){ 
                                   
                                    $img=intval($img);
                                    $query="SELECT * FROM ".$wpdb->prefix."responsive_thumbnail_slider WHERE id=$img";
                                    $myrow  = $wpdb->get_row($query);
                                    
                                    if(is_object($myrow)){
                                        
                                        $image_name=$myrow->image_name;
                                        $wpcurrentdir=dirname(__FILE__);
                                        $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                                       
                                        $imagetoDel=$pathToImagesFolder.'/'.$image_name;
                                        @unlink($imagetoDel);
                                        $query = "delete from  ".$wpdb->prefix."responsive_thumbnail_slider where id=$img";
                                        $wpdb->query($query); 
                                   
                                        $responsive_thumbnail_slider_messages=array();
                                        $responsive_thumbnail_slider_messages['type']='succ';
                                        $responsive_thumbnail_slider_messages['message']=__( 'Selected images deleted successfully.','wp-responsive-thumbnail-slider');
                                        update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                                   }
                                  
                             }
             
                         }
                       catch(Exception $e){
                       
                              $responsive_thumbnail_slider_messages=array();
                              $responsive_thumbnail_slider_messages['type']='err';
                              $responsive_thumbnail_slider_messages['message']=__( 'Error while deleting image.','wp-responsive-thumbnail-slider');
                              update_option('responsive_thumbnail_slider_messages', $responsive_thumbnail_slider_messages);
                        }  
                              
                       echo "<script type='text/javascript'> location.href='$location';</script>";
                       exit;
                
                }
                else{
                
                    echo "<script type='text/javascript'> location.href='$location';</script>";
                    exit;   
                }
            
           }
           else{
           
                echo "<script type='text/javascript'> location.href='$location';</script>"; 
                exit;     
           }
     
      }      
   } 
   
function responsivepreviewSliderAdmin(){
       
       
    if ( ! current_user_can( 'rts_responsive_thumbnail_slider_settings' ) ) {

       wp_die( __( "Access Denied", "wp-responsive-thumbnail-slider" ) );

    } 
      
       $settings=get_option('responsive_thumbnail_slider_settings');
       $settings['auto']=(int)$settings['auto'];
       
 ?>      
  <style type='text/css' >
      .bx-wrapper .bx-viewport {
          background: none repeat scroll 0 0 <?php echo $settings['scollerBackground']; ?> !important;
          border: 0px none !important;
          box-shadow: 0 0 0 0 !important;
       }
  </style>
   <div style="">  
        <div style="float:left;">
            <div class="wrap">
                    <h1><?php echo __( 'Slider Preview','wp-responsive-thumbnail-slider');?></h1>
            <br>
            <?php
                $wpcurrentdir=dirname(__FILE__);
                $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                $uploads = wp_upload_dir ();
                $baseDir = $uploads ['basedir'];
                $baseDir = str_replace ( "\\", "/", $baseDir );
                
                $baseurl=$uploads['baseurl'];
                $baseurl.='/wp-responsive-images-thumbnail-slider/';
                $pathToImagesFolder = $baseDir . '/wp-responsive-images-thumbnail-slider';
                
                                    
            ?>
            <div id="poststuff">
              <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                     <div style="clear: both;"></div>
                    <?php $url = plugin_dir_url(__FILE__);  ?>
                    <div id="divSliderMain_admin">
                     <div class="responsiveSlider" style="margin-top: 2px !important;">
                      <?php
                              global $wpdb;
                              $imageheight=$settings['imageheight'];
                              $imagewidth=$settings['imagewidth'];
                              $query="SELECT * FROM ".$wpdb->prefix."responsive_thumbnail_slider order by createdon desc";
                              $rows=$wpdb->get_results($query,'ARRAY_A');
                            
                            if(count($rows) > 0){
                                
                                foreach($rows as $row){
                                    
                                            $imagename=$row['image_name'];
                                            $imageUploadTo=$pathToImagesFolder.'/'.$imagename;
                                            $imageUploadTo=str_replace("\\","/",$imageUploadTo);
                                            $pathinfo=pathinfo($imageUploadTo);
                                            $filenamewithoutextension=$pathinfo['filename'];
                                            $outputimg="";
                                            
                                            
                                            if($settings['resizeImages']==0){
                                                
                                               $outputimg = $baseurl.$row['image_name']; 
                                               
                                            }
                                            else{
                                                    $imagetoCheck=$pathToImagesFolder.'/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                    $imagetoCheckLower=$pathToImagesFolder.'/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                                    
                                                    if(file_exists($imagetoCheck)){
                                                        $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                    }
                                                    else if(file_exists($imagetoCheckLower)){
                                                        
                                                         $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                                    }
                                                   else{
                                                         
                                                         if(function_exists('wp_get_image_editor')){
                                                                
                                                                $image = wp_get_image_editor($pathToImagesFolder."/".$row['image_name']); 
                                                                
                                                                if ( ! is_wp_error( $image ) ) {
                                                                    $image->resize( $imagewidth, $imageheight, true );
                                                                    $image->save( $imagetoCheck );
                                                                    //$outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                                    
                                                                     if(file_exists($imagetoCheck)){
                                                                            $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                                        }
                                                                        else if(file_exists($imagetoCheckLower)){

                                                                             $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                                                        }
                                                                }
                                                               else{
                                                                     $outputimg = $baseurl.$row['image_name'];
                                                               }     
                                                            
                                                          }
                                                         else if(function_exists('image_resize')){
                                                            
                                                            $return=image_resize($pathToImagesFolder."/".$row['image_name'],$imagewidth,$imageheight) ;
                                                            if ( ! is_wp_error( $return ) ) {
                                                                
                                                                  $isrenamed=rename($return,$imagetoCheck);
                                                                  if($isrenamed){
                                                                    //$outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];  
                                                                      
                                                                      if(file_exists($imagetoCheck)){
                                                                            $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                                        }
                                                                        else if(file_exists($imagetoCheckLower)){

                                                                             $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                                                        }
                                                                        
                                                                  }
                                                                 else{
                                                                      $outputimg = $baseurl.$row['image_name']; 
                                                                 } 
                                                            }
                                                           else{
                                                                 $outputimg = $baseurl.$row['image_name'];
                                                             }  
                                                         }
                                                        else{
                                                            
                                                            $outputimg = $baseurl.$row['image_name'];
                                                        }  
                                                            
                                                          //$url = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                          
                                                   } 
                                            } 
                                            
                                                     
                                              
                                 ?>         
                              
                                    <div class="limargin i13_thumslider"> 
                                      <?php if($settings['linkimage']==true){ ?>                                                                                                                                                                                                                                                                                     
                                        <a target="_blank" <?php if($row['custom_link']!=""):?>  href="<?php echo $row['custom_link']; ?>" <?php endif;?> ><img src="<?php echo $outputimg; ?>" alt="<?php echo $row['title']; ?>" title="<?php echo $row['title']; ?>"   /></a>
                                      <?php }else{ ?>
                                            <img src="<?php echo $outputimg; ?>" alt="<?php echo $row['title']; ?>" title="<?php echo $row['title']; ?>"   />
                                      <?php } ?> 
                                     </div>
                               
                           <?php }?>   
                      <?php }?>   
                    </div>
                    </div>
                     <script>
                        
                        jQuery(document).ready(function(){
                         var sliderMainHtml=jQuery('#divSliderMain').html();   
                         var slider= jQuery('.responsiveSlider').bxSlider({
                              <?php if( $settings['visible']==1):?>
                                  mode:'fade',
                               <?php endif;?>
                               slideWidth: <?php echo $settings['imagewidth'];?>,
                                minSlides: <?php echo $settings['min_visible'];?>,
                                maxSlides: <?php echo $settings['visible'];?>,
                                moveSlides: <?php echo $settings['scroll'];?>,
                                slideMargin: <?php echo $settings['imageMargin'];?>,  
                                touchEnabled:true,
                                speed:<?php echo $settings['speed']; ?>,
                                pause:<?php echo $settings['pause']; ?>,
                                <?php if($settings['pauseonmouseover'] and ($settings['auto']==1 or $settings['auto']==2) ){ ?>
                                  autoHover: true,
                                <?php }else{ if($settings['auto']==1 or $settings['auto']==2){?>   
                                  autoHover:false,
                                <?php }} ?>
                                <?php if($settings['auto']==1):?>
                                 controls:false,
                                <?php else: ?>
                                  controls:true,
                                <?php endif;?>
                                pager:false,
                                useCSS:false,
                                <?php if($settings['show_caption']):?>
                                  captions:true,  
                                <?php else:?>
                                  captions:false,
                                <?php endif;?>
                                <?php if($settings['show_pager']):?>
                                  pager:true,  
                                <?php else:?>
                                  pager:false,
                                <?php endif;?>
                                <?php if($settings['auto']==1 or $settings['auto']==2):?>
                                 auto:true,       
                                <?php endif;?>
                                <?php if($settings['circular']):?>
                                infiniteLoop: true,
                                <?php else: ?>
                                infiniteLoop: false,
                                <?php endif;?>
                                 onSlideBefore: function(slideElement){

                                        jQuery(slideElement).find('img').each(function(index, elm) {

                                                if(!elm.complete || elm.naturalWidth === 0){

                                                   var toload='';
                                                   var toloadval='';
                                                   jQuery.each(elm.attributes, function(i, attrib){

                                                       var value = attrib.value;
                                                       var aname=attrib.name;

                                                       var pattern = /^((http|https):\/\/)/;

                                                       if(pattern.test(value) && aname!='src' && aname.indexOf('data-html5_vurl')==-1) {

                                                           toload=aname;
                                                           toloadval=value;
                                                           }
                                                       // do your magic :-)
                                                   });

                                                   vsrc= jQuery(elm).attr("src");
                                                   jQuery(elm).removeAttr("src");
                                                   dsrc= jQuery(elm).attr("data-src");
                                                   lsrc= jQuery(elm).attr("data-lazy-src");

                                                   if(dsrc!== undefined && dsrc!='' && dsrc!=vsrc){
                                                            jQuery(elm).attr("src",dsrc);
                                                       }
                                                       else if(lsrc!== undefined && lsrc!=vsrc){

                                                            jQuery(elm).attr("src",lsrc);
                                                       }
                                                        else if(toload!='' && toload!='srcset' && toloadval!='' && toloadval!=vsrc){

                                                           $(elm).attr("src",toloadval);


                                                           } 
                                                       else{

                                                            jQuery(elm).attr("src",vsrc);

                                                       }   

                                                   elm= jQuery(elm)[0];      
                                                   if(!elm.complete && elm.naturalHeight == 0){

                                                        jQuery(elm).removeAttr('loading');
                                                        jQuery(elm).removeAttr('data-lazy-type');


                                                        jQuery(elm).removeClass('lazy');

                                                        jQuery(elm).removeClass('lazyLoad');
                                                        jQuery(elm).removeClass('lazy-loaded');
                                                        jQuery(elm).removeClass('jetpack-lazy-image');
                                                        jQuery(elm).removeClass('jetpack-lazy-image--handled');
                                                        jQuery(elm).removeClass('lazy-hidden');

                                               }


                                           }

                                        });

                                  }   

                          });


                          <?php if($settings['auto']==1 or $settings['auto']==2){?>

                               var is_firefox=navigator.userAgent.toLowerCase().indexOf('firefox') > -1;  
                              var is_android=navigator.userAgent.toLowerCase().indexOf('android') > -1;
                              var is_iphone=navigator.userAgent.toLowerCase().indexOf('iphone') > -1;
                              var width = jQuery(window).width();
                             if(is_firefox && (is_android || is_iphone)){

                             }else{
                                    var timer;
                                    jQuery(window).bind('resize', function(){
                                       if(jQuery(window).width() != width){

                                        width = jQuery(window).width(); 
                                        timer && clearTimeout(timer);
                                        timer = setTimeout(onResize, 600);

                                       }
                                    });

                              }    

                               function onResize(){

                                              jQuery('#divSliderMain').html('');   
                                              jQuery('#divSliderMain').html(sliderMainHtml);
                                                var slider= jQuery('.responsiveSlider').bxSlider({
                                                <?php if( $settings['visible']==1):?>
                                                    mode:'fade',
                                                 <?php endif;?>
                                                 slideWidth: <?php echo $settings['imagewidth'];?>,
                                                  minSlides: <?php echo $settings['min_visible'];?>,
                                                  maxSlides: <?php echo $settings['visible'];?>,
                                                  moveSlides: <?php echo $settings['scroll'];?>,
                                                  slideMargin: <?php echo $settings['imageMargin'];?>,  
                                                  speed:<?php echo $settings['speed']; ?>,
                                                  pause:<?php echo $settings['pause']; ?>,
                                                  touchEnabled:true,
                                                  <?php if($settings['pauseonmouseover'] and ($settings['auto']==1 or $settings['auto']==2) ){ ?>
                                                    autoHover: true,
                                                  <?php }else{ if($settings['auto']==1 or $settings['auto']==2){?>   
                                                    autoHover:false,
                                                  <?php }} ?>
                                                  <?php if($settings['auto']==1):?>
                                                   controls:false,
                                                  <?php else: ?>
                                                    controls:true,
                                                  <?php endif;?>
                                                  pager:false,
                                                  useCSS:false,
                                                   <?php if($settings['show_caption']):?>
                                                    captions:true,  
                                                  <?php else:?>
                                                    captions:false,
                                                  <?php endif;?>
                                                  <?php if($settings['show_pager']):?>
                                                    pager:true,  
                                                  <?php else:?>
                                                    pager:false,
                                                  <?php endif;?>
                                                  <?php if($settings['auto']==1 or $settings['auto']==2):?>
                                                   auto:true,       
                                                  <?php endif;?>
                                                  <?php if($settings['circular']):?>
                                                  infiniteLoop: true,
                                                  <?php else: ?>
                                                  infiniteLoop: false,
                                                  <?php endif;?>
                                                    onSlideBefore: function(slideElement){

                                                        jQuery(slideElement).find('img').each(function(index, elm) {

                                                                if(!elm.complete || elm.naturalWidth === 0){

                                                                   var toload='';
                                                                   var toloadval='';
                                                                   jQuery.each(elm.attributes, function(i, attrib){

                                                                       var value = attrib.value;
                                                                       var aname=attrib.name;

                                                                       var pattern = /^((http|https):\/\/)/;

                                                                       if(pattern.test(value) && aname!='src' && aname.indexOf('data-html5_vurl')==-1) {

                                                                           toload=aname;
                                                                           toloadval=value;
                                                                           }
                                                                       // do your magic :-)
                                                                   });

                                                                   vsrc= jQuery(elm).attr("src");
                                                                   jQuery(elm).removeAttr("src");
                                                                   dsrc= jQuery(elm).attr("data-src");
                                                                   lsrc= jQuery(elm).attr("data-lazy-src");

                                                                   if(dsrc!== undefined && dsrc!='' && dsrc!=vsrc){
                                                                            jQuery(elm).attr("src",dsrc);
                                                                       }
                                                                       else if(lsrc!== undefined && lsrc!=vsrc){

                                                                            jQuery(elm).attr("src",lsrc);
                                                                       }
                                                                        else if(toload!='' && toload!='srcset' && toloadval!='' && toloadval!=vsrc){

                                                                           $(elm).attr("src",toloadval);


                                                                           } 
                                                                       else{

                                                                            jQuery(elm).attr("src",vsrc);

                                                                       }   

                                                                   elm= jQuery(elm)[0];      
                                                                   if(!elm.complete && elm.naturalHeight == 0){

                                                                        jQuery(elm).removeAttr('loading');
                                                                        jQuery(elm).removeAttr('data-lazy-type');


                                                                        jQuery(elm).removeClass('lazy');

                                                                        jQuery(elm).removeClass('lazyLoad');
                                                                        jQuery(elm).removeClass('lazy-loaded');
                                                                        jQuery(elm).removeClass('jetpack-lazy-image');
                                                                        jQuery(elm).removeClass('jetpack-lazy-image--handled');
                                                                        jQuery(elm).removeClass('lazy-hidden');

                                                               }


                                                           }

                                                        });

                                                  }  

                                            });


                                  }

                                <?php }?>   




                  });
                  
                   window.addEventListener('load', function() {


                                        setTimeout(function(){ 

                                                if(jQuery("#divSliderMain").find('.bx-loading').length>0){

                                                        jQuery("#divSliderMain").find('img').each(function(index, elm) {
                                                            
                                                                if(!elm.complete || elm.naturalWidth === 0){

                                                                    var toload='';
                                                                    var toloadval='';
                                                                    jQuery.each(this.attributes, function(i, attrib){

                                                                            var value = attrib.value;
                                                                            var aname=attrib.name;

                                                                            var pattern = /^((http|https):\/\/)/;

                                                                            if(pattern.test(value) && aname!='src') {

                                                                                    toload=aname;
                                                                                    toloadval=value;
                                                                             }
                                                                            // do your magic :-)
                                                                     });

                                                                            vsrc=jQuery(elm).attr("src");
                                                                            jQuery(elm).removeAttr("src");
                                                                            dsrc=jQuery(elm).attr("data-src");
                                                                            lsrc=jQuery(elm).attr("data-lazy-src");


                                                                               if(dsrc!== undefined && dsrc!='' && dsrc!=vsrc){
                                                                                                             jQuery(elm).attr("src",dsrc);
                                                                                    }
                                                                                    else if(lsrc!== undefined && lsrc!=vsrc){

                                                                                                     jQuery(elm).attr("src",lsrc);
                                                                                    }
                                                                                    else if(toload!='' && toload!='srcset' && toloadval!='' && toloadval!=vsrc){

                                                                                            jQuery(elm).removeAttr(toload);
                                                                                            jQuery(elm).attr("src",toloadval);


                                                                                        } 
                                                                                    else{

                                                                                                    jQuery(elm).attr("src",vsrc);

                                                                               }   

                                                                            elm=jQuery(elm)[0];      
                                                                             if(!elm.complete && elm.naturalHeight == 0){

                                                                            jQuery(elm).removeAttr('loading');
                                                                            jQuery(elm).removeAttr('data-lazy-type');


                                                                            jQuery(elm).removeClass('lazy');

                                                                            jQuery(elm).removeClass('lazyLoad');
                                                                            jQuery(elm).removeClass('lazy-loaded');
                                                                            jQuery(elm).removeClass('jetpack-lazy-image');
                                                                            jQuery(elm).removeClass('jetpack-lazy-image--handled');
                                                                            jQuery(elm).removeClass('lazy-hidden');

                                                                        }
                                                                 }

                                                            }).promise().done( function(){ 

                                                                    jQuery("#divSliderMain").find('.bx-loading').remove();
                                                            } );

                                                    }


                                           }, 6000);

                                });


            
            </script>
                  
                </div>
          </div>      
        </div>  
     </div>      
</div>
<div class="clear"></div>
</div>
<h3><?php echo __( 'To print this slider into WordPress Post/Page use below Short code','wp-responsive-thumbnail-slider');?></h3>
<input type="text" value="[print_responsive_thumbnail_slider]" style="width: 400px;height: 30px" onclick="this.focus();this.select()" />
<div class="clear"></div>
<h3><?php echo __( 'To print this slider into WordPress theme/template PHP files use below php code','wp-responsive-thumbnail-slider');?></h3>
<input type="text" value="echo do_shortcode('[print_responsive_thumbnail_slider]');" style="width: 400px;height: 30px" onclick="this.focus();this.select()" />
<div class="clear"></div>
<?php       
   }
   
   function print_responsive_thumbnail_slider_func(){
       
       $wpcurrentdir=dirname(__FILE__);
       $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
       $settings=get_option('responsive_thumbnail_slider_settings');
       $settings['auto']=(int)$settings['auto'];
       $wpcurrentdir=dirname(__FILE__);
       $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
       
       $uploads = wp_upload_dir();
       $baseurl=$uploads['baseurl'];
       $baseurl.='/wp-responsive-images-thumbnail-slider/';
       $baseDir=$uploads['basedir'];
       $baseDir=str_replace("\\","/",$baseDir);
       $pathToImagesFolder=$baseDir.'/wp-responsive-images-thumbnail-slider';
      
       wp_enqueue_style('images-responsive-thumbnail-slider-style');
       wp_enqueue_script('jquery'); 
       wp_enqueue_script('images-responsive-thumbnail-slider-jc'); 
       
       ob_start();
 ?><!-- print_responsive_thumbnail_slider_func --><style type='text/css' >
.bx-wrapper .bx-viewport {
          background: none repeat scroll 0 0 <?php echo $settings['scollerBackground']; ?> !important;
          border: 0px none !important;
          box-shadow: 0 0 0 0 !important;
          /*padding:<?php echo $settings['imageMargin'];?>px !important;*/
        }
         </style>              
        <div style="clear: both;"></div>
        <?php $url = plugin_dir_url(__FILE__);  ?>
         <div style="width: auto;postion:relative;display:none" id="divSliderMain">
           <div class="responsiveSlider" style="margin-top: 2px !important;">
              <?php
                      global $wpdb;
                      $imageheight=$settings['imageheight'];
                      $imagewidth=$settings['imagewidth'];
                      $query="SELECT * FROM ".$wpdb->prefix."responsive_thumbnail_slider order by createdon desc";
                      $rows=$wpdb->get_results($query,'ARRAY_A');
                    
                    if(count($rows) > 0){
                        foreach($rows as $row){
                            
                                    $imagename=$row['image_name'];
                                    $imageUploadTo=$pathToImagesFolder.'/'.$imagename;
                                    $imageUploadTo=str_replace("\\","/",$imageUploadTo);
                                    $pathinfo=pathinfo($imageUploadTo);
                                    $filenamewithoutextension=$pathinfo['filename'];
                                    $outputimg="";
                                    
                                    
                                    if($settings['resizeImages']==0){
                                        
                                       $outputimg = $baseurl.$row['image_name']; 
                                       
                                    }
                                    else{
                                            $imagetoCheck=$pathToImagesFolder.'/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                            $imagetoCheckSmall=$pathToImagesFolder.'/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                            
                                            if(file_exists($imagetoCheck)){
                                                $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                            }
                                            else if(file_exists($imagetoCheckSmall)){
                                                $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                            }
                                           else{
                                                 
                                                 if(function_exists('wp_get_image_editor')){
                                                        
                                                        $image = wp_get_image_editor($pathToImagesFolder."/".$row['image_name']); 
                                                        
                                                        if ( ! is_wp_error( $image ) ) {
                                                            $image->resize( $imagewidth, $imageheight, true );
                                                            $image->save( $imagetoCheck );
                                                            //$outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                             
                                                            if(file_exists($imagetoCheck)){
                                                                    $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                                }
                                                                else if(file_exists($imagetoCheckSmall)){
                                                                    $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                                                }
                                                            
                                                        }
                                                       else{
                                                             $outputimg = $baseurl.$row['image_name'];
                                                       }     
                                                    
                                                  }
                                                 else if(function_exists('image_resize')){
                                                    
                                                    $return=image_resize($pathToImagesFolder."/".$row['image_name'],$imagewidth,$imageheight) ;
                                                    if ( ! is_wp_error( $return ) ) {
                                                        
                                                          $isrenamed=rename($return,$imagetoCheck);
                                                          if($isrenamed){
                                                            //$outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];  
                                                              
                                                               if(file_exists($imagetoCheck)){
                                                                        $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                                    }
                                                                    else if(file_exists($imagetoCheckSmall)){
                                                                        $outputimg = $baseurl.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.strtolower($pathinfo['extension']);
                                                                    }
                                            
                                                          }
                                                         else{
                                                              $outputimg = $baseurl.$row['image_name']; 
                                                         } 
                                                    }
                                                   else{
                                                         $outputimg = $baseurl.$row['image_name'];
                                                     }  
                                                 }
                                                else{
                                                    
                                                    $outputimg = $baseurl.$row['image_name'];
                                                }  
                                                    
                                                  //$url = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                  
                                           } 
                                    } 
                                    
                                             
                                      
                         ?>         
                              
                         <div class="limargin i13_thumslider"> 
                          <?php if($settings['linkimage']==true){ ?>                                                                                                                                                                                                                                                                                     
                            <a target="_blank" <?php if($row['custom_link']!=""):?>  href="<?php echo $row['custom_link']; ?>" <?php endif;?> ><img src="<?php echo $outputimg; ?>" alt="<?php echo $row['title']; ?>" title="<?php echo $row['title']; ?>" /></a>
                          <?php }else{ ?>
                                <img src="<?php echo $outputimg; ?>" alt="<?php echo $row['title']; ?>" title="<?php echo $row['title']; ?>"  />
                          <?php } ?> 
                         </div>
                       
                   <?php }?>   
                <?php }?>   
               </div>
         </div>                   
            <script>
        
           <?php $intval= uniqid('interval_');?>
               
           var slider;    
           var <?php echo $intval;?> = setInterval(function() {
               
           if(document.readyState === 'complete') {
  
              clearInterval(<?php echo $intval;?>);

                
                jQuery("#divSliderMain").show();
                var sliderMainHtml=jQuery('#divSliderMain').html();   
                slider= jQuery('.responsiveSlider').bxSlider({
                     <?php if( $settings['visible']==1):?>
                         mode:'fade',
                      <?php endif;?>
                      slideWidth: <?php echo $settings['imagewidth'];?>,
                       minSlides: <?php echo $settings['min_visible'];?>,
                       maxSlides: <?php echo $settings['visible'];?>,
                       moveSlides: <?php echo $settings['scroll'];?>,
                       slideMargin: <?php echo $settings['imageMargin'];?>,  
                       speed:<?php echo $settings['speed']; ?>,
                       pause:<?php echo $settings['pause']; ?>,
                       touchEnabled:true,
                       <?php if($settings['pauseonmouseover'] and ($settings['auto']==1 or $settings['auto']==2) ){ ?>
                         autoHover: true,
                       <?php }else{ if($settings['auto']==1 or $settings['auto']==2){?>   
                         autoHover:false,
                       <?php }} ?>
                       <?php if($settings['auto']==1):?>
                        controls:false,
                       <?php else: ?>
                         controls:true,
                       <?php endif;?>
                       pager:false,
                       useCSS:false,
                        <?php if($settings['show_caption']):?>
                       captions:true,  
                     <?php else:?>
                       captions:false,
                     <?php endif;?>
                     <?php if($settings['show_pager']):?>
                       pager:true,  
                     <?php else:?>
                       pager:false,
                     <?php endif;?>
                       <?php if($settings['auto']==1 or $settings['auto']==2):?>
                        auto:true,       
                       <?php endif;?>
                       <?php if($settings['circular']):?>
                       infiniteLoop: true,
                       <?php else: ?>
                       infiniteLoop: false,
                       <?php endif;?>
                         onSlideBefore: function(slideElement){

                            jQuery(slideElement).find('img').each(function(index, elm) {

                                    if(!elm.complete || elm.naturalWidth === 0){

                                       var toload='';
                                       var toloadval='';
                                       jQuery.each(elm.attributes, function(i, attrib){

                                           var value = attrib.value;
                                           var aname=attrib.name;

                                           var pattern = /^((http|https):\/\/)/;

                                           if(pattern.test(value) && aname!='src' && aname.indexOf('data-html5_vurl')==-1) {

                                               toload=aname;
                                               toloadval=value;
                                               }
                                           // do your magic :-)
                                       });

                                       vsrc= jQuery(elm).attr("src");
                                       jQuery(elm).removeAttr("src");
                                       dsrc= jQuery(elm).attr("data-src");
                                       lsrc= jQuery(elm).attr("data-lazy-src");

                                       if(dsrc!== undefined && dsrc!='' && dsrc!=vsrc){
                                                jQuery(elm).attr("src",dsrc);
                                           }
                                           else if(lsrc!== undefined && lsrc!=vsrc){

                                                jQuery(elm).attr("src",lsrc);
                                           }
                                            else if(toload!='' && toload!='srcset' && toloadval!='' && toloadval!=vsrc){

                                               $(elm).attr("src",toloadval);


                                               } 
                                           else{

                                                jQuery(elm).attr("src",vsrc);

                                           }   

                                       elm= jQuery(elm)[0];      
                                       if(!elm.complete && elm.naturalHeight == 0){

                                            jQuery(elm).removeAttr('loading');
                                            jQuery(elm).removeAttr('data-lazy-type');


                                            jQuery(elm).removeClass('lazy');

                                            jQuery(elm).removeClass('lazyLoad');
                                            jQuery(elm).removeClass('lazy-loaded');
                                            jQuery(elm).removeClass('jetpack-lazy-image');
                                            jQuery(elm).removeClass('jetpack-lazy-image--handled');
                                            jQuery(elm).removeClass('lazy-hidden');

                                   }


                               }

                            });

                        },    
                        onSliderLoad: function(){


                        }

                 });


                 <?php if($settings['auto']==1 or $settings['auto']==2){?>

                      var is_firefox=navigator.userAgent.toLowerCase().indexOf('firefox') > -1;  
                     var is_android=navigator.userAgent.toLowerCase().indexOf('android') > -1;
                     var is_iphone=navigator.userAgent.toLowerCase().indexOf('iphone') > -1;
                     var width = jQuery(window).width();
                    if(is_firefox && (is_android || is_iphone)){

                    }else{
                           var timer;
                           jQuery(window).bind('resize', function(){
                              if(jQuery(window).width() != width){

                               width = jQuery(window).width(); 
                               timer && clearTimeout(timer);
                               timer = setTimeout(onResize, 600);

                              }
                           });

                     }    

                      function onResize(){

                                     jQuery('#divSliderMain').html('');   
                                     jQuery('#divSliderMain').html(sliderMainHtml);
                                       var slider= jQuery('.responsiveSlider').bxSlider({
                                       <?php if( $settings['visible']==1):?>
                                           mode:'fade',
                                        <?php endif;?>
                                        slideWidth: <?php echo $settings['imagewidth'];?>,
                                         minSlides: <?php echo $settings['min_visible'];?>,
                                         maxSlides: <?php echo $settings['visible'];?>,
                                         moveSlides: <?php echo $settings['scroll'];?>,
                                         slideMargin: <?php echo $settings['imageMargin'];?>,  
                                         speed:<?php echo $settings['speed']; ?>,
                                         pause:<?php echo $settings['pause']; ?>,
                                         touchEnabled:true,
                                         <?php if($settings['pauseonmouseover'] and ($settings['auto']==1 or $settings['auto']==2) ){ ?>
                                           autoHover: true,
                                         <?php }else{ if($settings['auto']==1 or $settings['auto']==2){?>   
                                           autoHover:false,
                                         <?php }} ?>
                                         <?php if($settings['auto']==1):?>
                                          controls:false,
                                         <?php else: ?>
                                           controls:true,
                                         <?php endif;?>
                                         pager:false,
                                         useCSS:false,
                                          <?php if($settings['show_caption']):?>
                                           captions:true,  
                                         <?php else:?>
                                           captions:false,
                                         <?php endif;?>
                                         <?php if($settings['show_pager']):?>
                                           pager:true,  
                                         <?php else:?>
                                           pager:false,
                                         <?php endif;?>
                                         <?php if($settings['auto']==1 or $settings['auto']==2):?>
                                          auto:true,       
                                         <?php endif;?>
                                         <?php if($settings['circular']):?>
                                         infiniteLoop: true,
                                         <?php else: ?>
                                         infiniteLoop: false,
                                         <?php endif;?>
                                          onSlideBefore: function(slideElement){

                                                jQuery(slideElement).find('img').each(function(index, elm) {

                                                        if(!elm.complete || elm.naturalWidth === 0){

                                                           var toload='';
                                                           var toloadval='';
                                                           jQuery.each(elm.attributes, function(i, attrib){

                                                               var value = attrib.value;
                                                               var aname=attrib.name;

                                                               var pattern = /^((http|https):\/\/)/;

                                                               if(pattern.test(value) && aname!='src' && aname.indexOf('data-html5_vurl')==-1) {

                                                                   toload=aname;
                                                                   toloadval=value;
                                                                   }
                                                               // do your magic :-)
                                                           });

                                                           vsrc= jQuery(elm).attr("src");
                                                           jQuery(elm).removeAttr("src");
                                                           dsrc= jQuery(elm).attr("data-src");
                                                           lsrc= jQuery(elm).attr("data-lazy-src");

                                                           if(dsrc!== undefined && dsrc!='' && dsrc!=vsrc){
                                                                    jQuery(elm).attr("src",dsrc);
                                                               }
                                                               else if(lsrc!== undefined && lsrc!=vsrc){

                                                                    jQuery(elm).attr("src",lsrc);
                                                               }
                                                                else if(toload!='' && toload!='srcset' && toloadval!='' && toloadval!=vsrc){

                                                                   $(elm).attr("src",toloadval);


                                                                   } 
                                                               else{

                                                                    jQuery(elm).attr("src",vsrc);

                                                               }   

                                                           elm= jQuery(elm)[0];      
                                                           if(!elm.complete && elm.naturalHeight == 0){

                                                                jQuery(elm).removeAttr('loading');
                                                                jQuery(elm).removeAttr('data-lazy-type');


                                                                jQuery(elm).removeClass('lazy');

                                                                jQuery(elm).removeClass('lazyLoad');
                                                                jQuery(elm).removeClass('lazy-loaded');
                                                                jQuery(elm).removeClass('jetpack-lazy-image');
                                                                jQuery(elm).removeClass('jetpack-lazy-image--handled');
                                                                jQuery(elm).removeClass('lazy-hidden');

                                                       }


                                                   }

                                                });

                                          }

                                   });


                         }
                      
                    <?php }?>   
            
              
                
                
            }    
        }, 100);


             window.addEventListener('load', function() {


                                        setTimeout(function(){ 

                                                if(jQuery(".responsiveSlider").find('.bx-loading').length>0){

                                                        jQuery(".responsiveSlider").find('img').each(function(index, elm) {
                                                            
                                                                if(!elm.complete || elm.naturalWidth === 0){

                                                                    var toload='';
                                                                    var toloadval='';
                                                                    jQuery.each(this.attributes, function(i, attrib){

                                                                            var value = attrib.value;
                                                                            var aname=attrib.name;

                                                                            var pattern = /^((http|https):\/\/)/;

                                                                            if(pattern.test(value) && aname!='src') {

                                                                                    toload=aname;
                                                                                    toloadval=value;
                                                                             }
                                                                            // do your magic :-)
                                                                     });

                                                                            vsrc=jQuery(elm).attr("src");
                                                                            jQuery(elm).removeAttr("src");
                                                                            dsrc=jQuery(elm).attr("data-src");
                                                                            lsrc=jQuery(elm).attr("data-lazy-src");


                                                                               if(dsrc!== undefined && dsrc!='' && dsrc!=vsrc){
                                                                                                             jQuery(elm).attr("src",dsrc);
                                                                                    }
                                                                                    else if(lsrc!== undefined && lsrc!=vsrc){

                                                                                                     jQuery(elm).attr("src",lsrc);
                                                                                    }
                                                                                    else if(toload!='' && toload!='srcset' && toloadval!='' && toloadval!=vsrc){

                                                                                            jQuery(elm).removeAttr(toload);
                                                                                            jQuery(elm).attr("src",toloadval);


                                                                                        } 
                                                                                    else{

                                                                                                    jQuery(elm).attr("src",vsrc);

                                                                               }   

                                                                            elm=jQuery(elm)[0];      
                                                                             if(!elm.complete && elm.naturalHeight == 0){

                                                                            jQuery(elm).removeAttr('loading');
                                                                            jQuery(elm).removeAttr('data-lazy-type');


                                                                            jQuery(elm).removeClass('lazy');

                                                                            jQuery(elm).removeClass('lazyLoad');
                                                                            jQuery(elm).removeClass('lazy-loaded');
                                                                            jQuery(elm).removeClass('jetpack-lazy-image');
                                                                            jQuery(elm).removeClass('jetpack-lazy-image--handled');
                                                                            jQuery(elm).removeClass('lazy-hidden');

                                                                        }
                                                                 }

                                                            }).promise().done( function(){ 

                                                                    jQuery(".responsiveSlider").find('.bx-loading').remove();
                                                            } );

                                                    }


                                           }, 6000);

                                });
                                
              
            
            </script><!-- end print_responsive_thumbnail_slider_func --><?php
       $output = ob_get_clean();
       return $output;
   }
   
  function writ_remove_extra_p_tags($content){

        if(strpos($content, 'print_responsive_thumbnail_slider_func')!==false){
        
            
            $pattern = "/<!-- print_responsive_thumbnail_slider_func -->(.*)<!-- end print_responsive_thumbnail_slider_func -->/Uis"; 
            $content = preg_replace_callback($pattern, function($matches) {


               $altered = str_replace("<p>","",$matches[1]);
               $altered = str_replace("</p>","",$altered);
              
                $altered=str_replace("&#038;","&",$altered);
                $altered=str_replace("&#8221;",'"',$altered);
              

              return @str_replace($matches[1], $altered, $matches[0]);
            }, $content);

              
            
        }
        
        $content = str_replace("<p><!-- print_responsive_thumbnail_slider_func -->","<!-- print_responsive_thumbnail_slider_func -->",$content);
        $content = str_replace("<!-- end print_responsive_thumbnail_slider_func --></p>","<!-- end print_responsive_thumbnail_slider_func -->",$content);
        
        
        return $content;
  }
  
  function wrthslider_slider_mass_upload_wrthslider(){
        
       global $wpdb; 
      
        $uploads = wp_upload_dir ();
        $baseDir = $uploads ['basedir'];
        $baseDir = str_replace ( "\\", "/", $baseDir );
        $pathToImagesFolder = $baseDir . '/wp-responsive-images-thumbnail-slider/';

      if(isset($_POST) and sizeof($_POST)>0){
      
         if(!check_ajax_referer( 'thumbnail-mass-image','thumbnail_security' )){
          
          wp_die('Security check fail'); 
          
          }  
         if ( ! current_user_can( 'rts_responsive_thumbnail_slider_add_image' ) ) {

           wp_die( __( "Access Denied", "wp-responsive-images-thumbnail-slider" ) );

         }
         $createdOn=date('Y-m-d h:i:s');
         if(function_exists('date_i18n')){
            
             $createdOn=date_i18n('Y-m-d'.' '.get_option('time_format') ,false,false);
            if(get_option('time_format')=='H:i')
                $createdOn=date('Y-m-d H:i:s',strtotime($createdOn));
             else   
               $createdOn=date('Y-m-d h:i:s',strtotime($createdOn));
         } 
         $attachment_id=(int)$_POST['attachment_id'];
         $photoMeta = wp_get_attachment_metadata( $attachment_id );
        
         $open_link_in=0;
         $enable_light_box_img_desc=0;  
         $imageurl='';
         $title=trim(esc_html(strip_tags($_POST['imagetitle'])));
         $enable_light_box_img_desc=0;     
        
         if(is_array($photoMeta) and isset($photoMeta['file'])) {
             
                 $fileName=$photoMeta['file'];
                 $phyPath=ABSPATH;
                 $phyPath=str_replace("\\","/",$phyPath);
               
                 $pathArray=pathinfo($fileName);
               
                 $imagename=$pathArray['basename'];
                 $imagename_=$pathArray['filename'];
                 $file_ext=$pathArray['extension'];
                 $imagename=$imagename_.uniqid().".".$file_ext;
                 $upload_dir_n = wp_upload_dir(); 
                 $upload_dir_n=$upload_dir_n['basedir'];
                 $fileUrl=$upload_dir_n.'/'.$fileName;
                 $fileUrl=str_replace("\\","/",$fileUrl);
                 $wpcurrentdir=dirname(__FILE__);
                 $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                 $imageUploadTo=$pathToImagesFolder."/".$imagename;
                 @copy($fileUrl, $imageUploadTo);
                 
                  if(!file_exists($imageUploadTo)){
                    rsths_save_image_remote($fileUrl,$imageUploadTo);
                   }
                           
          }
      
          
           
          $query = "INSERT INTO ".$wpdb->prefix."responsive_thumbnail_slider (title, image_name,createdon) 
                      VALUES ('$title','$imagename','$createdOn')";
                                   
          $wpdb->query($query); 
         
      }  

 }
 
  add_filter('widget_text_content', 'writ_remove_extra_p_tags', 999);
  add_filter('the_content', 'writ_remove_extra_p_tags', 999);
   
  
  



function i13_th_modify_render_block_defaults($block_content, $block) { 

    $block_content=writ_remove_extra_p_tags($block_content);
    return $block_content; 

}

// add the filter

add_filter( 'render_block', 'i13_th_modify_render_block_defaults', 10, 2 );
