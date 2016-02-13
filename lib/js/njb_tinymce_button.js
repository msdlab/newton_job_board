jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.njb_plugin', {
        init : function(ed, url) {
                // Register command for when button is clicked
                ed.addCommand('njb_insert_shortcode', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();

                    /**if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[shortcode]'+selected+'[/shortcode]';
                    }else{**/
                        content =  '[newton-job-board]';
                    //}

                    tinymce.execCommand('mceInsertContent', false, content);
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('njb_button', {title : 'Insert Newton Job Board', cmd : 'njb_insert_shortcode', icon: 'megaphone' });
        },   
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('njb_button', tinymce.plugins.njb_plugin);
});