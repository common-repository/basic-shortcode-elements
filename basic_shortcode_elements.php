<?php
/*
Plugin Name: Basic Shortcode Elements
Description: Easily add different shortcode elements in page such as: one or two columns, parallax image, buttons, latest publications, table, etc.
Plugin URI: http://amrani.es/wp-plugins/basic-shortcode-elements.php
Author: Amal Amrani
Author URI: http://amrani.es
Version: 1.3
Text Domain: basic_shortcode_elements
Domain Path: /languages
License: GPLv3 or later
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'BASIC_SHES_VERSION', '1.3' );
define( 'BASIC_SHES_URL', plugins_url( '', __FILE__ ) );
define( 'BASIC_SHES_TEXTDOMAIN', 'basic_shortcode_elements' );



function basic_shes_add_element_shortcode() {


$pt = get_current_screen()->post_type;


if ( $pt == 'page') :
	
    echo '<a href="#" id="insert-my-shortcode" class="button"><span class="icon-shortcodes">[ ]</span>'.__(' Add Element Shortcode',  'basic_shortcode_elements' ).'</a>';
    // add modal window
    echo'<div id="myModalShortcodes" >'.
    '<h2>'.__('Add element shortcode', 'basic_shortcode_elements' ).'</h2><span class="btclose"></span>'.

        '<div class="content-shortcodes">'. 

        '<div class="element-shortcode" id="full-width"><img src="'. plugins_url( 'admin/icons/full-width.png', __FILE__ ) .'" /><span>Full width</span></div>'.
        '<div class="element-shortcode" id="two-cols"><img src="'. plugins_url( 'admin/icons/two-cols.png', __FILE__ ) .'" /><span>Two cols</span></div>'.
        '<div class="separate"></div>'.
        '<div class="element-shortcode" id="parallax-image"><img src="'. plugins_url( 'admin/icons/parallax-image.png', __FILE__ ) .'" /><span>Parallax image</span></div>'.
        '<div class="element-shortcode" id="table"><img src="'. plugins_url( 'admin/icons/table2.png', __FILE__ ) .'" /><span>Table</span></div>'.
        
        '<div class="separate"></div>'.
        '<div class="element-shortcode" id="last-posts"><img src="'. plugins_url( 'admin/icons/last-posts2.png', __FILE__ ) .'" /><span>Last posts</span></div>'.
        '<div class="element-shortcode" id="button"><span>Button</span></div>'.
        '<div class="separate"></div>'.
        '<div class="element-shortcode" id="space-separation-60"><img src="'. plugins_url( 'admin/icons/vertical-space-separation.png', __FILE__ ) .'" /><span>Space separation 60</span></div>'.
        '<div class="element-shortcode" id="space-separation-80"><img src="'. plugins_url( 'admin/icons/vertical-space-separation.png', __FILE__ ) .'" /><span>Space separation 80</span></div>'.
        
        '<button type="button" class="btclose" id="button-close">Close</button>'.
        
        '</div>'.

        '<div id="content-form">'.

        basic_shes_get_form_element_shortcode('full-width').      
        basic_shes_get_form_element_shortcode('two-cols').
        basic_shes_get_form_element_shortcode('parallax-image').
        basic_shes_get_form_element_shortcode('table').
        basic_shes_get_form_element_shortcode('last-posts').
        basic_shes_get_form_element_shortcode('button').
        basic_shes_get_form_element_shortcode('space-separation-60').
        basic_shes_get_form_element_shortcode('space-separation-80').
                
        '<div id="buttons-form" class="noshow"><button type="button" id="bt-cancel">'.__('Cancel', 'basic_shortcode_elements' ).'</button><button type="button" id="insert-element-shortcode">'.__('Insert', 'basic_shortcode_elements' ).'</button></div>'.
        
        '</div>'.

    '</div>';
endif;
}


add_action('media_buttons', 'basic_shes_add_element_shortcode');


function basic_shes_basic_shortcodes_elements_js_file() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_script('basic_shes_basic_shortcodes_elements_admin_js', BASIC_SHES_URL.'/admin/js/basic_shortcode_elements.js', array('jquery'), '1.0', true);
}



function basic_shes_basic_shortcodes_elements_css_file(){
	wp_enqueue_style( 'basic_shes_basic_shortcodes_elements_admin_css', BASIC_SHES_URL. '/admin/css/basic_shortcode_elements.css', array(), BASIC_SHES_VERSION, 'all' );        

}


// scripts modal shortcodes
add_action('wp_enqueue_media', 'basic_shes_basic_shortcodes_elements_js_file');
// style modal shortcodes
add_action( 'admin_enqueue_scripts', 'basic_shes_basic_shortcodes_elements_css_file' );


function basic_shes_basic_shortcode_elements_enqueue_style(){
    $pluginPrefix = BASIC_SHES_TEXTDOMAIN;
    wp_enqueue_style( '{$pluginPrefix}style', plugins_url( '/public/css/style.css', __FILE__ ) , false );
}


add_action( 'wp_enqueue_scripts', 'basic_shes_basic_shortcode_elements_enqueue_style' );

/**
*  function to get the html form part of full width element shortcode
*/
function basic_shes_get_form_element_shortcode( $element_type ){

    $form_part = '';

    switch ( $element_type ) {
       
        case 'full-width':
                $form_part = '<div class="selected-shortcode-option noshow" id="full-width-option">'.
                    '<span class="title-option">Full width</span><div class="content-form-element">'.
                    '<span class="annonce">'.esc_html__('Don\'t nest this shortcode element inside other. They must be added separately', 'basic_shortcode_elements' ).'</span>'.
                    '<label for="title-full">'.__('Title', 'basic_shortcode_elements' ).'</label><input type="text" name="title-full"  id="title-full-width" class="title_element" value="" />'.
                    '<label for="subtitle-full">'.__('Subtitle', 'basic_shortcode_elements' ).'</label><input type="text" name="subtitle-full" id="subtitle-full-width" class="subtitle_element" value="" />'.
                    '<div id="radio-align-full">'.
                        '<span>Align text to</span><input type="radio" name="align-text-full" id="align-center" value="center" checked><label for="align-center">Center</label>'.
                        '<input type="radio" name="align-text-full" value="left"  id="align-left" ><label for="align-left">Left</label>'.
                        '<input type="radio" name="align-text-full" value="right"  id="align-right"><label for="align-right">Right</label>'.
                    '</div>'.
                    '<span id="make_text_cursive"><input type="checkbox" name="text_cursive" value="cursive"><label for="text_cursive">Make text cursive</label></span>'.                    
                    '</div></div>';

        
        break;

        case 'two-cols':
                $form_part = '<div class="selected-shortcode-option noshow" id="two-cols-option">'.
                                '<span class="title-option">Two cols</span><div class="content-form-element">'.
                                '<span class="annonce">'.esc_html__('Don\'t nest this shortcode element inside other. They must be added separately', 'basic_shortcode_elements' ).'</span>'.
                                '<div class="col1-of-two">'.
                                '<label for="title-two-cols">'.__('Title (One column of two)', 'basic_shortcode_elements' ).' </label><input type="text" name="title-two-cols" id="title-two-cols" class="title_element" value="" />'.'<span id="content_title_top"><input type="checkbox" name="title_on_top" value="top"><label for="title_on_top">'.__('Title on top', 'basic_shortcode_elements' ).'</label></span>'.
                                '<label for="subtitle-two-cols">'.__('Subtitle', 'basic_shortcode_elements' ).'</label><input type="text" name="subtitle-two-cols" id="sutitle-two-cols" class="subtitle_element" value="" />'.
                                '<div id="to_include_padding_in_block">'.
                                    '<span>'.__('Include padding in block?', 'basic_shortcode_elements' ).'</span>'.
                                    '<input type="radio" name="include-padding-two-cols" value="simple" id="with-padding" ><label for="with-padding">'.__('Yes', 'basic_shortcode_elements' ).'</label>'.
                                    '<input type="radio" name="include-padding-two-cols" value="" id="without-padding" checked><label for="without-padding">'.__('No', 'basic_shortcode_elements' ).'</label>'.
                                '</div>'.
                                '<div id="radio-align-two-cols">'.
                                    '<span>'.__('Align text to', 'basic_shortcode_elements' ).'</span><input type="radio" name="align-text-two-cols" id="align-center" value="center" checked><label for="align-center">'.__('Center', 'basic_shortcode_elements' ).'</label>'.
                                    '<input type="radio" name="align-text-two-cols" value="left"  id="align-left" ><label for="align-left">'.__('Left', 'basic_shortcode_elements' ).'</label>'.
                                    '<input type="radio" name="align-text-two-cols" value="right"  id="align-right"><label for="align-right">'.__('Right', 'basic_shortcode_elements' ).'</label>'.
                                '</div>'.
                                '</div>'.

                                '<div class="col1-of-two">'.
                                '<label for="title-two-cols2">'.__('Title (Second column of two)', 'basic_shortcode_elements' ).' </label><input type="text" name="title-two-cols2" id="title-two-cols2" class="title_element" value="" />'.'<span id="content_title_top2"><input type="checkbox" name="title_on_top2" value="top"><label for="title_on_top2">'.__('Title on top', 'basic_shortcode_elements' ).'</label></span>'.
                                '<label for="subtitle-two-cols2">'.__('Subtitle', 'basic_shortcode_elements' ).'</label><input type="text" name="subtitle-two-cols2" id="sutitle-two-cols2" class="subtitle_element" value="" />'.
                                '<div id="to_include_padding_in_block2">'.
                                    '<span>'.__('Include padding in block?', 'basic_shortcode_elements' ).'</span>'.
                                    '<input type="radio" name="include-padding-two-cols2" value="simple" id="with-padding2" ><label for="with-padding2">'.__('Yes', 'basic_shortcode_elements' ).'</label>'.
                                    '<input type="radio" name="include-padding-two-cols2" value="" id="without-padding2" checked><label for="without-padding2">'.__('No', 'basic_shortcode_elements' ).'</label>'.
                                '</div>'.
                                '<div id="radio-align-two-cols2">'.
                                    '<span>Align text to</span><input type="radio" name="align-text-two-cols2" id="align-center2" value="center" checked><label for="align-center2">'.__('Center', 'basic_shortcode_elements' ).'</label>'.
                                    '<input type="radio" name="align-text-two-cols2" value="left"  id="align-left" ><label for="align-left2">'.__('Left', 'basic_shortcode_elements' ).'</label>'.
                                    '<input type="radio" name="align-text-two-cols2" value="right"  id="align-right"><label for="align-right2">'.__('Right', 'basic_shortcode_elements' ).'</label>'.
                                '</div>'.
                                '</div>'.
                            '</div></div>';
        
        break;

        case 'parallax-image':

                $form_part = '<div class="selected-shortcode-option noshow" id="parallax-image-option">'.
                                '<span class="title-option">Parallax image</span><div class="content-form-element">'.
                                '<span class="annonce">'.esc_html__('Don\'t nest this shortcode element inside other. They must be added separately', 'basic_shortcode_elements' ).'</span>'.
                                '<label for="title-parallax-image">'.__('Title', 'basic_shortcode_elements' ).'</label><input type="text" name="title-parallax-image" id="title-parallax-image" class="title_element" value="" />'.
                                '<label for="subtitle-parallax-image">'.__('Subtitle', 'basic_shortcode_elements' ).'</label><input type="text" name="subtitle-parallax-image" id="subtitle-parallax-image" class="subtitle_element" value="" />'.
                                '<button id="select-image-parallax">'.__('Select parallax image', 'basic_shortcode_elements' ).'</button>'.
                                '<input type="hidden" name="meta-image" id="meta-image"  value="" />'.
                                '<img class="meta-image-preview"  />'.
                             '</div></div>';        
        break;
        
       case 'table':

                $form_part = '<div class="selected-shortcode-option noshow" id="table-option">'.
                             '<span class="title-option">Table</span><div class="content-form-element">'.
                             '<span class="annonce">'.esc_html__('Don\'t nest this shortcode element inside other. They must be added separately', 'basic_shortcode_elements' ).'</span>'.
                             '<label for="title-table">'.__('Title', 'basic_shortcode_elements' ).'</label><input type="text" name="title-table" id="title-table" class="title_element" value="" />'.
                             '<label for="subtitle-table">'.__('Subtitle', 'basic_shortcode_elements' ).'</label><input type="text" name="subtitle-table" id="subtitle-table" class="subtitle_element" value="" />'.
                             '<div id="table-cols">'.
                                    '<input type="radio" name="num-table-cols" id="onecol" value="1" ><label for="onecol">'.__('1 col', 'basic_shortcode_elements' ).'</label>'.
                                    '<input type="radio" name="num-table-cols" value="2"  id="twocols" checked><label for="twocols">'.__('2 cols', 'basic_shortcode_elements' ).'</label>'.                                   
                             
                             '</div>'.

                             '<div class="row-table">'.
                                '<div class="AddRowtable" title="Add row table"></div>'.
                                '<div class="content-cols">'.
                                '<div class="col1"><label for="row1-textcol1">'.__('Text col1', 'basic_shortcode_elements' ).'</label><input type="text" id="row1-textcol1" name="row1-textcol1" value="Enter here your content" /><label>'.__('Description col1', 'basic_shortcode_elements' ).'</label><textarea class="descriptioncol" id="row1-descriptioncol1" ></textarea></div>'.
                                '<div class="col2"><label for="row1-textcol2">'.__('Text col2', 'basic_shortcode_elements' ).'</label><input type="text" id="row1-textcol2" name="row1-textcol2" value="Enter here your content" /><label>'.__('Description col2', 'basic_shortcode_elements' ).'</label><textarea class="descriptioncol" id="row1-descriptioncol2" ></textarea></div>'.
                                '</div>'.
                             '</div>'.
                             '</div></div>';
        
        break;

        case 'last-posts':

                $form_part = '<div class="selected-shortcode-option noshow" id="last-posts-option">'.
                             '<span class="title-option">Last posts</span><div class="content-form-element">'.
                             '<span class="annonce">'.esc_html__('Don\'t nest this shortcode element inside other. They must be added separately', 'basic_shortcode_elements' ).'</span>'.
                             '<label for="title-last-posts">'.__('Title', 'basic_shortcode_elements' ).'</label><input type="text" name="title-last-posts" id="title-last-posts" class="title_element" value="" />'.
                             '<label for="subtitle-last-posts">'.__('Subtitle', 'basic_shortcode_elements' ).'</label><input type="text" name="subtitle-last-posts" id="subtitle-last-posts" class="subtitle_element" value="" />'.
                             '<div id="posts-number">'.
                                    '<span>'.__('Posts number', 'basic_shortcode_elements' ).'</span>'.
                                    '<input type="radio" name="num-posts" id="three-posts" value="3" ><label for="three-posts">'.__('3 posts', 'basic_shortcode_elements' ).'</label>'.
                                    '<input type="radio" name="num-posts" value="4"  id="four-posts" checked><label for="four-posts">'.__('4 posts', 'basic_shortcode_elements' ).'</label>'.                                   
                             
                             '</div>'.
                             '<div id="share-with-media"><span>'.__('Share with media', 'basic_shortcode_elements' ).'</span>'.
                             '<input type="checkbox" name="whatsapp" id="whatsapp" value="whatsapp"><label for="whatsapp">Whatsapp</label></span>'. 
                             '<input type="checkbox" name="twitter" value="twitter"><label for="twitter">Twitter</label></span>'. 
                             '<input type="checkbox" name="facebook" value="facebook"><label for="facebook">Facebook</label></span>'.  
                             '<input type="checkbox" name="googleplus" value="googleplus"><label for="googleplus">Google+</label></span>'.  
                             '<input type="checkbox" name="pinterest" value="pinterest"><label for="pinterest">Pinterest</label></span>'.  
                             '<span class="note-below">whatsapp just for small resolutions</span>'.
                             '</div>'.
                                           
                            '</div></div>';
        
        break;
        
        case 'button':

        
        $color_link = get_theme_mod( 'link_color2' ); 
        

                $form_part = '<div class="selected-shortcode-option noshow" id="button-option">'.
                             '<span class="title-option"></span><div class="content-form-element">'.

                             '<input type="button" id="add_link"  value="'.__('Add link button', 'basic_shortcode_elements' ).'" />'.
                             '<input type="text" id="url_link_button" value="" />'.
                             '<label for="button_name">'.__('Button name', 'basic_shortcode_elements' ).'</label><input type="text" name="button_name" id="button_name" value="" />'.
                                                          
                             '<div id="style_color_button">'.
                             '<span class="literal">'.__('Choose your button color', 'basic_shortcode_elements' ).'</span>'.
                                    '<div class="blockbt">'.
                                    '<input type="radio" name="color_button" id="predefined_color" value="1" checked><label for="predefined_color">'.__('Predefined color', 'basic_shortcode_elements' ).'</label>'.
                                    '<a href="#"  class="buttonstyle2" style="background:'.$color_link.'; pointer-events: none; " >button name</a>'.
                                    '</div>'.
                                    '<div class="blockbt">'.
                                    '<input type="radio" name="color_button" value="2"  id="light_color" ><label for="light_color">'.__('Light color', 'basic_shortcode_elements' ).'</label>'.
                                    '<a href="#"  class="buttonstyle1" style="pointer-events: none; " >button name</a>'.
                                    '</div>'.
                                    '<div class="blockbt content-button-color">'.
                                    '<input type="radio" name="color_button" value="3"  id="other_color" ><label for="other_color">'.__('Other color', 'basic_shortcode_elements' ).'</label>'.                                      
                                    '<input type="text" id="bt_invoke_color_picker" class="button-color" name="" id="" value="#000000" size="30"  />'.                                                                            
                                    '</div>'.                                                              
                                    
                             '</div>'.
                             '<div id="radio-align-button">'.
                                            '<span>'.__('Align button to', 'basic_shortcode_elements' ).'</span><input type="radio" name="align-button" id="align-bt-center" value="Center" checked><label for="align-bt-center">'.__('Center', 'basic_shortcode_elements' ).'</label>'.
                                            '<input type="radio" name="align-button" value="Left"  id="align-bt-left" ><label for="align-bt-left">'.__('Left', 'basic_shortcode_elements' ).'</label>'.
                                            '<input type="radio" name="align-button" value="Right"  id="align-bt-right"><label for="align-bt-right">'.__('Right', 'basic_shortcode_elements' ).'</label>'.
                             '</div>'.

                            '</div></div>';        
        break; 

        case 'space-separation-60' :

         $form_part =   '<div class="selected-shortcode-option noshow" id="space-separation-60-option">'.
                            '<span class="title-option">Space separation 60</span><div class="content-form-element">'.
                             '<span class="annonce centerText">'.esc_html__('Don\'t nest this shortcode element inside other. They must be added separately', 'basic_shortcode_elements' ).'</span>'.
                            '<div class="ask-confirm-option">'.__('Do you want to insert vertical space of 60? Insert or cancel it', 'basic_shortcode_elements' ).' </div>'.
                            '</div>'.
                        '</div>';                            

        break;

        case 'space-separation-80' :

         $form_part =   '<div class="selected-shortcode-option noshow" id="space-separation-80-option">'.
                            '<span class="title-option">Space separation 80</span><div class="content-form-element">'.
                             '<span class="annonce centerText">'.esc_html__('Don\'t nest this shortcode element inside other. They must be added separately', 'basic_shortcode_elements' ).'</span>'.
                            '<div class="ask-confirm-option">'.__('Do you want to insert vertical space of 80? Insert or cancel it', 'basic_shortcode_elements' ).' </div>'.
                            '</div>'.
                        '</div>';                            

        break;

        default:
            # code...
            break;

    }
return  $form_part; 
}

// SHORTCODES
//[onecol]
function basic_shes_one_cols_to_show( $atts, $content = null ) {

    $title1 = '';
    $cad = '';
       
    $a = shortcode_atts( array(
        'text' => 'center',  
        'cursive' => '',             
        'title' => '',
        'subtitle' => ''
    ), $atts );

     if ( $a['title'] ) $title1 = "<h2 class='title1'>{$a['title']}</h2>";
     
     if( $a['subtitle']  )  $title1 =  $title1."<span class='subtitle'>{$a['subtitle']}</span>";

     $cad = "<div class='basic_shortcode_element col span_4_of_4  {$a['text']}_text'>";

     if( $a['cursive'] ) $cad = "<div class='basic_shortcode_element col span_4_of_4  {$a['text']}_text {$a['cursive']}'>";

    $cad = $cad.$title1. $content ." </div>"; 

    return $cad; 
}
add_shortcode( 'onecol', 'basic_shes_one_cols_to_show' );


//[section]
function basic_shes_add_section( $atts, $content = null ) {
   

    return "<div class='basic_shortcode_element-section group'>";
}
add_shortcode( 'section', 'basic_shes_add_section' );

//[close-section]
function basic_shes_close_section( $atts, $content = null ) {
   
    return "</div>";
}
add_shortcode( 'close-section', 'basic_shes_close_section' );

//[twocols]
function basic_shes_two_cols_to_show( $atts, $content = null ) {
    $a = shortcode_atts( array(
        'text' => 'center',          
        'subtitle' => '',
        'title' => '',
        'padding_text' => '',
        'title_position' => ''

    ), $atts );

    $title1 ='';

    $clases = '';

    if ( $a['title'] ) $title1 = "<h2 class='title2'>{$a['title']}</h2>";

    if( $a['subtitle']  )  $title1 =  $title1."<span class='subtitle2'>{$a['subtitle']}</span>";

    if( $a['padding_text']  ) $clases = $a['padding_text'];
    if( $a['title_position']  ) $clases = $clases.' '.$a['title_position'];


    return "<div class='basic_shortcode_element col span_2_of_4 {$a['text']}_text ".$clases."'>".$title1. $content ." </div>"; 
}
add_shortcode( 'twocols', 'basic_shes_two_cols_to_show' );


//[parallaxImage]
function basic_shes_show_parallax_image( $atts ) {
    $urltheme = get_template_directory_uri().'/images/IMG_2178f.png';
    $a = shortcode_atts( array(
               
        'image' => $urltheme,
        'title' => '',
        'subtitle' => ''

    ), $atts );

    $custom_style = '';
   
    if( $a['image'] != $urltheme ){
     
        $custom_style =  '
    
        background: transparent url("'.$a['image'].'") no-repeat fixed 100%;
        background-size: cover;
        
        ';         
                      
    } 
    
        
    return "<div class='basic_shortcode_element-section group'><div class='basic_shortcode_element col span_4_of_4'><div class='basic_shortcode_element-parallax-img1' style=' ".$custom_style."' ><div class='parralax-subtitle1'>{$a['title']}<span class='parralax-subtitle2'>{$a['subtitle']}</span></div></div> </div></div>";
}
add_shortcode( 'parallaxImage', 'basic_shes_show_parallax_image' );

//[table]
function basic_shes_show_table( $atts, $content = null ) {
   
    $title1 = '';

    $a = shortcode_atts( array(
        'cols' => 2 ,
        'title' => '',
        'subtitle' => ''
       
    ), $atts );

    $content_result =  str_replace('[col]',"<div class='cols_{$a["cols"]}' >", $content);
    $content_result2 =  str_replace("[/col]","</div>", $content_result );

    $result3 =  str_replace("[description]",'<div class="describedishe">', $content_result2 );
    $result3 =  str_replace("[/description]",'</div>', $result3 );

    if ( $a['title'] ) $title1 = "<h2 class='title-table'>{$a['title']}</h2>";

    if( $a['subtitle']  )  $title1 =  $title1."<span class='subtitle-table'>{$a['subtitle']}</span>";

    return $title1."<div class='basic_shortcode_element col span_4_of_4  table_prices'>". $result3 ." </div>"; 
}
add_shortcode( 'table', 'basic_shes_show_table' );

//[lastPosts]
function basic_shes_show_last_posts($atts){

    // Get current page URL 
    $theShareButtonURL = urlencode(get_permalink());    

    $a = shortcode_atts( array(

        'title' => '',
        'subtitle' => '',
        'numposts' => 4,
        'category' => '',// category name
        'twitter' => '',
        'facebook'=> '',
        'linkedin'=> '',
        'googleplus'=> '',
        'pinterest'=> '',
        'whatsapp'=> ''
        //'instagram'=> ''


        ), $atts);

    if (  $a['numposts'] == 4 )   $addclasses = 'style1_4 span_1_of_4_without_white';
    else $addclasses = 'style1_3 span_1_of_3_without_white';

    $args = array(
        'numberposts' => $a['numposts'],
        'offset' => 0,
        'category' => 0,
        'category_name' => $a['category'],
        'orderby' => 'post_date',
        'order' => 'DESC',
        'include' => '',
        'exclude' => '',
        'meta_key' => '',
        'meta_value' =>'',
        'post_type' => 'post',
        'post_status' => 'publish',
        'suppress_filters' => true
    );

    $theme_name_icons = plugin_dir_url( __FILE__ ).'admin/icons/';
   
    $posts = get_posts( $args );   
    $allposts = '';

    if ( $a['title'] ) $allposts = '<h2 class="titlestyle2">'.$a['title'].'</h2>';

    if ( $a['subtitle'] ) $allposts = $allposts.'<div class="subtitlestyle2">'.$a['subtitle'].'</div>';

    foreach ($posts as $post) {
        
        if($post) {

            $post_id = $post->ID;
        
            $theShareButtonURL =  get_permalink($post_id);

            // Get current page title
            $theShareButtonTitle = str_replace( ' ', '%20', $post->post_title);


            // Get Post Thumbnail for pinterest
            $theShareButtonThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
     
           
            $twitterURL = 'https://twitter.com/intent/tweet?text='.$theShareButtonTitle.'&amp;url='.$theShareButtonURL.'&amp;via=restautheme';
            $facebookURL = 'https://www.facebook.com/sharer.php?u='.$theShareButtonURL.'&t='.$theShareButtonTitle; 
            $googleURL = 'https://plus.google.com/share?url='.$theShareButtonURL;
           
            $whatsappURL = 'whatsapp://send?text='.$theShareButtonTitle . ' ' . $theShareButtonURL;
            $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$theShareButtonURL.'&amp;title='.$theShareButtonTitle;
     
           
            $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$theShareButtonURL.'&amp;media='.$theShareButtonThumbnail[0].'&amp;description='.$theShareButtonTitle;

            if(has_post_thumbnail($post_id)){
                              
                $allposts = $allposts.'<div class="'.$addclasses.'"><img src="'.get_the_post_thumbnail_url( $post_id,'large' ).'" class="toScale" />';
                $allposts = $allposts.'<span class="transparent2"><a href="' . get_permalink($post_id) . '" class="titleLastPost">'.$post->post_title.'</a>';
                $allposts = $allposts.'<span class="shareme">';

                // if exist option add it
                if( strtolower (str_replace(' ', '', $a['twitter']) ) == 'yes')                    
                   $allposts = $allposts.'<a href="'.$twitterURL.'" class="shareButton"><img src="'.$theme_name_icons.'twitter-white.png" /></a>';

                
                
                if ( strtolower (str_replace(' ', '', $a['pinterest']) ) == 'yes' ) 
                    $allposts = $allposts.'<a href="'.$pinterestURL.'" class="shareButton"><img src="'.$theme_name_icons.'pinterest-white.png" /></a>';
                
                if ( strtolower (str_replace(' ', '', $a['facebook']) ) == 'yes' ) 
                    $allposts = $allposts.'<a href="'.$facebookURL.'" class="shareButton"><img src="'.$theme_name_icons.'facebook-white.png" /></a>';
                
                if ( strtolower (str_replace(' ', '', $a['googleplus']) ) == 'yes' ) 
                    $allposts = $allposts.'<a href="'.$googleURL.'" class="shareButton"><img src="'.$theme_name_icons.'google-plus-white.png" /></a>';
                
                if ( strtolower (str_replace(' ', '', $a['whatsapp']) ) == 'yes' ) 
                                        
                $allposts = $allposts.'<a href="whatsapp://send?text='.$theShareButtonTitle .' ' .$theShareButtonURL.'" class="shareButton shareButton-whatsapp" data-action="share/whatsapp/share"><img src="'.$theme_name_icons.'whatsapp-white.png" /></a>';
                      
                $allposts = $allposts.'</span></span></div>';// close shareme, transparent2 and post module div                 
                
            }
        }
    }
    
    wp_reset_query();// to restore global variables and post data to the original main query

   
return "<div class='basic_shortcode_element-lastposts_module section group'>".$allposts."</div> ";
}

add_shortcode('lastPosts', 'basic_shes_show_last_posts');

// add vertical space separation
//[separate60 ]
function basic_shes_show_separate60(){
   
return "<div class='basic_shortcode_element-separate60'></div>";
}

add_shortcode('separate60', 'basic_shes_show_separate60');


//[separate80 ]
function basic_shes_show_separate80(){
   
return "<div class='basic_shortcode_element-separate80'></div>";
}

add_shortcode('separate80', 'basic_shes_show_separate80');



?>
