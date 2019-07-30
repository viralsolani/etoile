<?php
/**
 * Font Icon
 * Shortcode which creates a font icon
 */
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !class_exists( 'av_font_icon' ) )
{
    class av_font_icon extends aviaShortcodeTemplate
    {
        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button()
        {
            $this->config['name']       = 'Font Icon';
            $this->config['order']      = 100;
            $this->config['shortcode']  = 'av_font_icon';
            $this->config['inline']     = true;
            $this->config['html_renderer']  = false;
            $this->config['tinyMCE']    = array('tiny_only'=>true, 'templateInsert'=>'[av_font_icon color="{{color}}" font="{{font}}" icon="{{icon}}" size="{{size}}" position="{{position}}" link="{{link}}" linktarget="{{linktarget}}"]');
        }

        /**
         * Popup Elements
         *
         * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
         * opens a modal window that allows to edit the element properties
         *
         * @return void
         */
        function popup_elements()
        {
            $this->elements = array(

                array(
                    "name"  => __("Font Icon",'avia_framework' ),
                    "desc"  => __("Select an Icon below",'avia_framework' ),
                    "id"    => "icon",
                    "type"  => "iconfont",
                    "std"   => ""),


                array(
                    "name" 	=> __("Title Link?", 'avia_framework' ),
                    "desc" 	=> __("Where should your title link to?", 'avia_framework' ),
                    "id" 	=> "link",
                    "type" 	=> "linkpicker",
                    "fetchTMPL"	=> true,
                    "std"	=> "",
                    "subtype" => array(
                        __('No Link', 'avia_framework' ) =>'',
                        __('Set Manually', 'avia_framework' ) =>'manually',
                        __('Single Entry', 'avia_framework' ) =>'single',
                        __('Taxonomy Overview Page',  'avia_framework' )=>'taxonomy',
                    ),
                    "std" 	=> ""),

                array(
                    "name" 	=> __("Open in new window", 'avia_framework' ),
                    "desc" 	=> __("Do you want to open the link in a new window", 'avia_framework' ),
                    "id" 	=> "linktarget",
                    "required" 	=> array('link', 'not', ''),
                    "type" 	=> "select",
                    "std" 	=> "",
                    "subtype" => AviaHtmlHelper::linking_options()),   


                array(
                    "name"  => __("Icon Color", 'avia_framework' ),
                    "desc"  => __("Here you can set the  color of the icon. Enter no value if you want to use the standard font color.", 'avia_framework' ),
                    "id"    => "color",
                    "type"  => "colorpicker"),

                array(
                    "name"  => __("Icon Size", 'avia_framework' ),
                    "desc"  => __("Enter the font size in px, em or %", 'avia_framework' ),
                    "id"    => "size",
                    "type"  => "input",
                    "std"	=> "40px"
                    ),
                    
                array(	
					"name" 	=> __("Icon Position", 'avia_framework' ),
					"desc" 	=> __("Choose the alignment of your icon here", 'avia_framework' ),
					"id" 	=> "position",
					"type" 	=> "select",
					"std" 	=> "left",
					"subtype" => array(
						__('Align Left',   'avia_framework' ) =>'left',
						__('Align Center',  'avia_framework' ) =>'center',
						__('Align Right',   'avia_framework' ) =>'right',
					)),	
					
				);
        }


        /**
         * Frontend Shortcode Handler
         *
         * @param array $atts array of attributes
         * @param string $content text within enclosing form of shortcode element
         * @param string $shortcodename the shortcode found, when == callback name
         * @return string $output returns the modified html string
         */
        function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
        {
            //this is a fix that solves the false paragraph removal by wordpress if the dropcaps shortcode is used at the beginning of the content of single posts/pages
            global $post, $avia_add_p;

            $add_p = "";
            $custom_class = !empty($meta['custom_class']) ? $meta['custom_class'] : "";
            if(isset($post->post_content) && strpos($post->post_content, '[av_font_icon') === 0 && $avia_add_p == false && is_singular())
            {
                $add_p = "<p>";
                $avia_add_p = true;
            }

            extract(shortcode_atts(array(
                'icon'     => '',
                'font'     => '',
                'color'    => '',
                'size'     => '',
                'use_link' => 'no',
                'position' => 'left',
                'link' =>'',
                'linktarget' => 'no',
                'font' => ''
            ), $atts));

            $display_char = av_icon($icon, $font);

            $color = !empty($color) ? "color:{$color};" : '';

            if(!empty($size) && is_numeric($size)) $size .= 'px';
            $size = !empty($size) ? "font-size:{$size};line-height:{$size};" : '';

            $blank = (strpos($linktarget, '_blank') !== false || $linktarget == 'yes') ? ' target="_blank" ' : "";
            $blank .= strpos($linktarget, 'nofollow') !== false ? ' rel="nofollow" ' : "";
            $link = aviaHelper::get_url($link);
            if(!empty($link))
            {
                $display_char = "<a href='$link' $blank $display_char> </a>";
                $output  = $add_p.'<span class="'.$shortcodename.' '.$custom_class.' avia-icon-pos-'.$position.'" style="'.$color.$size.'">'.$display_char;
            }
            else
            {
            	//this is the actual shortcode
            	$output  = $add_p.'<span class="'.$shortcodename.' '.$custom_class.' avia-icon-pos-'.$position.'" style="'.$color.$size.'" '.$display_char.'>';
            }

            $output .= '</span>';


            return $output;
        }

    }
}
