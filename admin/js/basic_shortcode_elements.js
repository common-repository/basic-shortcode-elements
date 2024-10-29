//basic_shortcodes_elements.js

(function($) {

var mode_active = null;


$(document).ready(function(){
		
    var element_active = null;
		  
    $('#insert-my-shortcode').click(open_shortcodes_window);
    $('.btclose').click(close_shortcodes_window);
    $('#bt-cancel').click(restore);

    $('.element-shortcode').click( get_selected_option_shortcode );  
    $('#insert-element-shortcode').click(insert_element_into_editor);

    $('.wp-editor-wrap .switch-tmce').click( function visual_clicked(){    mode_active = 'visual'; } );

    $('.wp-editor-wrap .switch-html').click( function text_clicked(){    mode_active = 'text'; } );

    if(window.tinyMCE) {     
        //at the beginning select/active visual mode
        if(!tinyMCE.activeEditor) $('.wp-editor-wrap .switch-tmce').trigger('click'); 
    }


   
   active_button_select_parallax();

   controls_table_cols();
   
   open_editor();

    // color picker
    $('#button').click(function(){        

        if('#bt_invoke_color_picker'){ $('#bt_invoke_color_picker').wpColorPicker(); }

    });

/**
* function to invoke wpLink modal to add a link
*/
function open_editor(){

   
    $('#add_link').click(function(event) {          
            wpLink.open(); //open the link popup
            $('#wp-link-update').addClass('insert_button_style');
    });


    $("#wp-link").on("click", ".insert_button_style", function(){

            var url_button = $('#wp-link-url').val();
            var name_button = $('#wp-link-text').val(); 
            if( url_button )   $('#url_link_button').val(url_button);
            if( name_button )   $('#button_name').val(name_button);

            //close link editor
            $('#wp-link-close').trigger("click");
    });


}
 

/**
* function to restore default values, elements status
*/
function restore(){ 

    var button_style = $('.insert_button_style'); 
    if( button_style ) button_style.removeClass('insert_button_style');

    if ( $('.content-shortcodes').hasClass('hideme') )    $('.content-shortcodes').removeClass('hideme');

    // hide all previously
    var all = $('.selected-shortcode-option');  
    var addedRows = $('.content-cols'); 
        
      
    for (var i=0;i<all.length; i++)
        if( $(all[i]).hasClass('noshow') == false )  $(all[i]).addClass('noshow'); 
       
    if( $('#buttons-form').hasClass('noshow') == false ) $('#buttons-form').addClass('noshow'); 

    $('#content-form input:text').val('');

    for(var j=1;j<addedRows.length;j++) addedRows[j].remove();

    
    $('input[name="align-text-full"][value="center"]').attr('checked', true);
   
    $('input[name="align-text-two-cols"][value="center"]').attr('checked', true);
    $('input[name="include-padding-two-cols"][value=""]').attr('checked', true);
    $('input[name="title_on_top"][value="top"]').attr('checked', false);

    $('input[name="align-text-two-cols2"][value="center"]').attr('checked', true);
    $('input[name="include-padding-two-cols2"][value=""]').attr('checked', true);
    $('input[name="title_on_top2"][value="top"]').attr('checked', false);

    $('input[name="num-table-cols"][value="2"]').attr('checked', true);
    $('.content-cols .col2').css('display','inline-block');
    $('.row-table .descriptioncol').val('');
    

}


/**
* function to get form values/build a differents shortcodes element for adding
*/
function get_form_values(id_element){

    var obj = {};
    var title = $('#'+id_element).find('.title_element').val();
    var subtitle = $('#'+id_element).find('.subtitle_element').val();   
    var shortcode_to_add = '';

    

    switch(id_element){

        case 'full-width-option':
        var align = $('input[name=align-text-full]:checked', '#radio-align-full').val();    
        var cursive = $('input[name=text_cursive]:checked', '#make_text_cursive').val();   
        if ( cursive ) cursive = 'cursive_text';
        else cursive = '';
        obj = {
                element: 'onecol',
                title: title,
                subtitle: subtitle,
                text: align,
                cursive: cursive
              };
        // build a shortcode to add in editor:
        shortcode_to_add = '['+obj['element']+' text="'+obj['text']+'" , cursive="'+obj['cursive']+'" , title="'+obj['title']+'" , subtitle="'+obj['subtitle']+'"]Enter here your content as: text, image, etc[/'+obj['element']+']';       
        break;

        case 'two-cols-option':

        var align = $('input[name=align-text-two-cols]:checked', '#radio-align-two-cols').val();
        var with_padding = $('input[name=include-padding-two-cols]:checked', '#to_include_padding_in_block').val();
        var title_position = $('input[name=title_on_top]:checked', '#content_title_top').val(); 

        var align2 = $('input[name=align-text-two-cols2]:checked', '#radio-align-two-cols2').val();
        var with_padding2 = $('input[name=include-padding-two-cols2]:checked', '#to_include_padding_in_block2').val();
        var title_position2 = $('input[name=title_on_top2]:checked', '#content_title_top2').val(); 

        if (title_position) title_position = 'top_title';
        else title_position = '';

        if (title_position2) title_position2 = 'top_title';
        else title_position2 = '';
        obj = {
                element: 'twocols',
                title: title,
                subtitle: subtitle,
                text: align,
                padding_text: with_padding,
                title_position: title_position
              };

        var title_col2 = $('#title-two-cols2').val();
        var subtitle_col2 = $('#sutitle-two-cols2').val();

        // build a shortcode to add in editor:
        shortcode_to_add = '['+obj['element']+' text="'+obj['text']+'" , title="'+obj['title']+'" , subtitle="'+obj['subtitle']+'" ';      
        if (with_padding && with_padding!= '' ) shortcode_to_add = shortcode_to_add+' , padding_text="'+obj['padding_text']+'" ';  
        if (title_position && title_position!= '' ) shortcode_to_add = shortcode_to_add+' , title_position="'+obj['title_position']+'"';

         shortcode_to_add =  shortcode_to_add+']Enter here your content as: text, image, etc[/'+obj['element']+']';

         // col2
         shortcode_to_add =  shortcode_to_add+'[twocols text="'+align2+'" , title="'+title_col2+'" , subtitle="'+subtitle_col2+'" ';

         if (with_padding2 && with_padding2!= '' ) shortcode_to_add = shortcode_to_add+' , padding_text="'+with_padding2+'" ';  
         if (title_position2 && title_position2!= '' ) shortcode_to_add = shortcode_to_add+' , title_position="'+title_position2+'"';

         shortcode_to_add =  shortcode_to_add+' ]Enter here your content as: text, image, etc [/twocols]';

         shortcode_to_add = '[section]'+shortcode_to_add+'[close-section]';
         


        break;

        case 'parallax-image-option':         

        var new_image = $('#meta-image').val();       
       
        obj = {
                element: 'parallaxImage',
                title: title,
                subtitle: subtitle,                
                
              };
        // build a shortcode to add in editor:
        shortcode_to_add = '['+obj['element']+' , title="'+obj['title']+'" , subtitle="'+obj['subtitle']+'" ';
        
        if( new_image )  shortcode_to_add = shortcode_to_add+' , image="'+new_image+'" ';
        
        shortcode_to_add = shortcode_to_add+' ][/'+obj['element']+']';       
        break;

        case 'table-option':
        var cols_active = $('input[name=num-table-cols]:checked', '#table-cols').val();
        var rows = $('.content-cols').length; 
        obj = {
                element: 'table',
                title: title,
                subtitle: subtitle,                
                
              };
              
        shortcode_to_add = '['+obj['element']+' cols="'+cols_active+'" , title="'+obj['title']+'" , subtitle="'+obj['subtitle']+'"]';

        for(var r=1; r<rows+1; r++){

            var id= $('#row'+r+'-textcol1').val();
            var description = $('#row'+r+'-descriptioncol1').val();
            if( cols_active == 1 )   shortcode_to_add = shortcode_to_add+'[col]'+id+' [description] '+description+' [/description] [/col]';
            
            else if( cols_active == 2 ){ 
                shortcode_to_add = shortcode_to_add+'[col]'+id+' [description] '+description+' [/description] [/col]';
                //second column
                id = $('#row'+r+'-textcol2').val();
                description = $('#row'+r+'-descriptioncol2').val();
                shortcode_to_add = shortcode_to_add+'[col]'+id+' [description] '+description+' [/description] [/col]';
            }
        }
        
        shortcode_to_add = shortcode_to_add+'[/'+obj['element']+']';    
                
        break;

        case 'last-posts-option':
        var num_posts = $('input[name=num-posts]:checked', '#posts-number').val();      
       
        obj = {
                element: 'lastPosts',
                title: title,
                subtitle: subtitle,                
                
              };

        shortcode_to_add = '['+obj['element']+' numposts="'+num_posts+'" , title="'+obj['title']+'" , subtitle="'+obj['subtitle']+'" ';

        $('#share-with-media input:checked').each(function() {
           
            shortcode_to_add = shortcode_to_add+' , '+$(this).val()+' ="yes" ';
        });
        shortcode_to_add = shortcode_to_add+']';

        break;
        
        case 'button-option':      
               
        var button_type = $('input[name=color_button]:checked', '#style_color_button').val();  
        var url_link = $('#url_link_button').val();
        var button_name = $('#button_name').val();
        var additional_background = '';
        var added_style = '';
        var align = $('input[name=align-button]:checked', '#radio-align-button').val();
        var classes = 'buttonstyle2';
        if( button_type == 2 )  classes = 'buttonstyle1';
        else if( button_type == 3 ){ classes = 'otherstyle-button'; 

            if( $('.button-color.wp-color-picker').val() && $('.button-color.wp-color-picker').val() != "#000000" )
            additional_background = $('.button-color.wp-color-picker').val();
        }

        obj = {
                element: 'button',
                name: 'button name',
                link: url_link,  
                align: align,
                background: '',            
                classes: ''
              };
        if( button_name )  obj['name'] = button_name;       

    if( additional_background )   added_style =  ' style="background: '+additional_background+'"';

    shortcode_to_add = '<a href="'+obj['link']+'" class="'+classes+' to'+align+'" '+added_style+'>'+obj['name']+' </a>'; 
           
        break;

        case 'space-separation-60-option':
          
        shortcode_to_add = "[separate60]";

        break;

        case 'space-separation-80-option':
        
        shortcode_to_add = "[separate80]";

        break;

    }

return shortcode_to_add;    
}


/**
* function to choose table cols/ add table rows
*/
function controls_table_cols(){

    var numcols = $('input[name=num-table-cols]:checked', '#table-cols').val();
    var index = 1;
   
   if( numcols == 1) $('.row-table .col2').css('display','none');
   else $('.row-table .col2').css('display','inline-block');

    $('input[name=num-table-cols]').click(function(){ 
        numcols = $('input[name=num-table-cols]:checked', '#table-cols').val();  
        if( numcols == 1) $('.row-table .col2').css('display','none');
        else $('.row-table .col2').css('display','inline-block');

    });

    $('.AddRowtable').click(function(){ 
        index++;  
        var display= 'display:inline-block';
        numcols = $('input[name=num-table-cols]:checked', '#table-cols').val(); 

        if( numcols == 1)  display = "display:none";
        
        $('.row-table').append('<div class="content-cols"><div class="col1"><label for="row'+index+'-textcol1">Text col1</label><input type="text" id="row'+index+'-textcol1" name="row'+index+'-textcol1" /><label>Description col1</label><textarea  class="descriptioncol" id="row'+index+'-descriptioncol1" ></textarea></div>'+
        '<div class="col2" style="'+display+'" ><label for="row'+index+'-textcol2">Text col2</label><input type="text" id="row'+index+'-textcol2" name="row'+index+'-textcol2" /><label>Description col2</label><textarea class="descriptioncol" id="row'+index+'-descriptioncol2" ></textarea></div></div>');
        
    });    
    
}


/**
* function to open media library
*/
function active_button_select_parallax(){

    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
    var media_attachment = '';
 
    // Runs when the image button is clicked.
    $('#select-image-parallax').click(function(e){ 
 
        //frame_library = true;
        // Prevents the default action from occuring.
        e.preventDefault();
 
        // If the frame already exists, re-open it.
       if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        // Sets up the media library frame       
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({

            title: 'Choose Image',
            button: {text: 'Choose Image Parallax'}, 
            library: { type: 'image' },
            multiple: false  // Set to true to allow multiple files to be selected
        });
 
        
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
            $('#meta-image').val(media_attachment.url);
            
            var urlCurrentImage = $('#meta-image').val();            
                       
            if ( urlCurrentImage.length ){
                $('.meta-image-preview').attr("src", urlCurrentImage);
                              
            }  


        });
 
        // Opens the media library frame.
        meta_image_frame.open();
       
    });

}

/**
* function to insert element shortcode into editor
*/
function insert_element_into_editor(){
   
    var shortcode_element_to_add = get_form_values(element_active);
   
    close_shortcodes_window();
    if( mode_active == 'visual'){

        /// proc VISUAL
        if(window.tinyMCE) {
            // First get the loaded TinyMCE version:
            var mceVersion = parseInt(tinyMCE.majorVersion);

          
            // Then later in your code where you want to insert your content:
            if(mceVersion >= 4){            
                           
                tinyMCE.execCommand('mceInsertContent',false,shortcode_element_to_add);

            }else{ 
               
                 tinymce.get("content").execCommand('mceInsertContent', false, shortcode_element_to_add);
            }
        }

        
    }
    else if(  mode_active == 'text' ){
        
        var content = $('.wp-editor-area').val();
        var cursorPos = $('.wp-editor-area').prop('selectionStart');
        
        var textBefore = content.substring(0, cursorPos);
        var textAfter = content.substring(cursorPos,content.length);

        $('.wp-editor-area').val(textBefore+shortcode_element_to_add+textAfter);

    }
    
}

/**
* function to open shortcodes window
*/
function open_shortcodes_window(){ 
   
    restore();
    window.addEventListener('click', function(e){   
            if (document.getElementById('myModalShortcodes').contains(e.target)|| document.getElementById('insert-my-shortcode').contains(e.target) || document.getElementsByClassName('media-modal-content')){
                // Clicked in box
            } else{
                // Clicked outside the box 
                if( $('#myModalShortcodes').hasClass('shortcodes-opened') ){                                           
                        //outside    
                        close_shortcodes_window();                                     
                }                
            }
    });
    
    $('#myModalShortcodes').after('<div class="myModalShortcodes-backdrop"></div>');
    $('#myModalShortcodes').css('display','block');
    $('#wp-content-wrap').css('z-index','9999');
    $('#myModalShortcodes').addClass('shortcodes-opened');

}

/**
* function to show selected shortcode form
*/
function get_selected_option_shortcode(){
       
    var id_element_to_show = $(this).attr('id')+'-option';
    element_active = id_element_to_show;

   
    //show the element sortcode form to insert in content area
    var elem = $('#'+id_element_to_show);
    if( $(elem) && $(elem).hasClass('noshow') ){
      
        // hide all previously
        var all = $('.selected-shortcode-option');     
               
        for (var i=0;i<all.length; i++){
            if( $(all[i]).hasClass('noshow') == false )  $(all[i]).addClass('noshow'); 
            
        }
                    
        $(elem).removeClass('noshow');  
        if( $('#buttons-form').hasClass('noshow') ) $('#buttons-form').removeClass('noshow'); 
        $('.content-shortcodes').addClass('hideme');
    }

}


/**
* function to close shortcodes window
*/
function close_shortcodes_window(){
    restore();    
    $( ".myModalShortcodes-backdrop" ).remove();
    $('#myModalShortcodes').css('display','none');
    $('#myModalShortcodes').removeClass('shortcodes-opened');
    $('#wp-content-wrap').css('z-index','auto');
}



});

})(jQuery);