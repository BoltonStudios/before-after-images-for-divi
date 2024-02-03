<?php

/**
 * The Module Class that extends the Divi Builder
 *
 * This defines all of the server-side logic of the module.
 *
 * @since      1.0.0
 * @package    Before_After_Images_For_Divi
 * @subpackage Before_After_Images_For_Divi/includes
 * @author     Aaron Bolton <aaron@boltonstudios.com>
 */

// Imports
require_once( 'helpers.php' );

// If the 'Before_After_Images_For_Divi_Module' has not been declared...
if ( ! class_exists( 'Before_After_Images_For_Divi_Module' ) ) {

    // Define the class.
    class Before_After_Images_For_Divi_Module extends ET_Builder_Module {

        /**
         * The identifier for this module.
         *
         * @since 1.0.0
         *
         * @var string      Do not change this property value. Changing this value will break current installations.
         */
        public $slug = 'baie_before_after_image';

        /**
         * The module's level of compatibility with the Divi Visual Builder.
         *
         * @since 1.0.0
         *
         * @var string      off (default), partial, or on
         */
        public $vb_support = 'on';

        /**
         * Credits that appear at the bottom of the module settings modal.
         *
         * @since 1.0.0
         *
         * @var array 
         */
        protected $module_credits = array(
            'module_uri' => 'https://www.boltonstudios.com/',
            'author'     => 'Bolton Studios LLC',
            'author_uri' => 'https://www.boltonstudios.com/',
        );
        
        /**
         * The list of available image sizes.
         * 
         * @since 1.3.0
         * 
         * @var array $image_size_list
         */
        private $image_size_list;

        // Define the functions that run when the application creates a new Before_After_Images_For_Divi_Module object.
        public function init() {

            // Initialize variables.
            $settings_modal_toggles = array(
                'general'  => array(
                    'toggles' => array(
                        'main_content' => esc_html__( 'Before + After Images', 'before-after-images-for-divi' )
                    ),
                ),
                'advanced' => array(
                    'toggles' => array(
                        'alignment'  => esc_html__( 'Alignment', 'before-after-images-for-divi' ),
                        'width'      => array(
                            'title'    => esc_html__( 'Sizing', 'before-after-images-for-divi' ),
                            'priority' => 65,
                        ),
                    ),
                ),
                'custom_css' => array(
                    'toggles' => array(
                        'animation' => array(
                            'title'    => esc_html__( 'Animation', 'before-after-images-for-divi' ),
                            'priority' => 90,
                        ),
                        'attributes' => array(
                            'title'    => esc_html__( 'Attributes', 'before-after-images-for-divi' ),
                            'priority' => 95,
                        ),
                    ),
                ),
            );
            $advanced_fields = array(
                'margin_padding' => array(
                    'css' => array(
                        'important' => array( 'custom_margin' ),
                    ),
                ),
                'borders' => array(
                    'default' => array(
                        'css' => array(
                            'main' => array(
                                'border_radii'  => "%%order_class%% .et_pb_image_wrap",
                                'border_styles' => "%%order_class%% .et_pb_image_wrap",
                            ),
                        ),
                    ),
                ),
                'box_shadow' => array(
                    'default' => array(
                        'css' => array(
                            'main'         => '%%order_class%% .et_pb_image_wrap',
                            'custom_style' => true,
                        ),
                    ),
                ),
                'max_width' => array(
                    'options' => array(
                        'max_width' => array(
                            'depends_show_if' => 'off',
                        ),
                    ),
                ),
                'fonts'                 => false,
                'text'                  => false,
                'button'                => false,
            );
            
            // Update the object's inherited property values.
            $this->name = esc_html__( 'Before + After Images', 'before-after-images-for-divi' );
            $this->icon = '&';
            $this->settings_modal_toggles = $settings_modal_toggles;
            $this->advanced_fields = $advanced_fields;
            $this->image_size_list = get_image_dimensions();
        }
        
        /** 
         * Module settings are defined in the get_fields() method.
         * 
         * @return  array   $fields
         * */ 
        public function get_fields() {
            
            $fields = array(
                'src_before' => array(
                    'label'           => esc_html__( 'Before Image', 'before-after-images-for-divi' ),
                    'type'               => 'upload',
                    'option_category'    => 'basic_option',
                    'upload_button_text' => esc_attr__( 'Upload an image', 'before-after-images-for-divi' ),
                    'choose_text'        => esc_attr__( 'Choose an Image', 'before-after-images-for-divi' ),
                    'update_text'        => esc_attr__( 'Set As Image', 'before-after-images-for-divi' ),
                    'hide_metadata'      => true,
                    'affects'            => array(
                        'alt',
                        'title_text',
                        'size'
                    ),
                    'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'before-after-images-for-divi' ),
                    'toggle_slug'        => 'main_content',
                ),
                'label_before' => array(
                    'label'           => esc_html__( 'Before Label', 'before-after-images-for-divi' ),
                    'type'            => 'text',
                    'option_category' => 'basic_option',
                    'default' => 'Before',
                    'description'     => esc_html__( 'Set the label for the before image. The default label is "Before".' ),
                    'toggle_slug'     => 'main_content',
                ),
                'src_after' => array(
                    'label'           => esc_html__( 'After Image', 'before-after-images-for-divi' ),
                    'type'               => 'upload',
                    'option_category'    => 'basic_option',
                    'upload_button_text' => esc_attr__( 'Upload an image', 'before-after-images-for-divi' ),
                    'choose_text'        => esc_attr__( 'Choose an Image', 'before-after-images-for-divi' ),
                    'update_text'        => esc_attr__( 'Set As Image', 'before-after-images-for-divi' ),
                    'hide_metadata'      => true,
                    'affects'            => array(
                        'alt',
                        'title_text',
                        'size'
                    ),
                    'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'before-after-images-for-divi' ),
                    'toggle_slug'        => 'main_content',
                ),
                'label_after' => array(
                    'label'           => esc_html__( 'After Label', 'before-after-images-for-divi' ),
                    'type'            => 'text',
                    'option_category' => 'basic_option',
                    'default' => 'After',
                    'description'     => esc_html__( 'Set the label for the after image. The default label is "After".' ),
                    'toggle_slug'     => 'main_content',
                ),
                'alt' => array(
                    'label'           => esc_html__( 'Image Alternative Text', 'before-after-images-for-divi' ),
                    'type'            => 'text',
                    'option_category' => 'basic_option',
                    'depends_show_if' => 'on',
                    'depends_on'      => array(
                        'src',
                    ),
                    'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'before-after-images-for-divi' ),
                    'tab_slug'        => 'custom_css',
                    'toggle_slug'     => 'attributes',
                ),
                'title_text' => array(
                    'label'           => esc_html__( 'Image Title Text', 'before-after-images-for-divi' ),
                    'type'            => 'text',
                    'option_category' => 'basic_option',
                    'depends_show_if' => 'on',
                    'depends_on'      => array(
                        'src',
                    ),
                    'description'     => esc_html__( 'This defines the HTML Title text.', 'before-after-images-for-divi' ),
                    'tab_slug'        => 'custom_css',
                    'toggle_slug'     => 'attributes',
                ),
                'size' => array(
                    'label' => esc_html__( 'Image Size', 'before-after-images-for-divi' ),
                    'type' => 'select',
                    'depends_show_if' => 'on',
                    'depends_on' => array(
                        'src_before',
                        'src_after'
                    ),
                    'option_category' => 'basic_option',
                    'options' =>  $this->image_size_list, 'before-after-images-for-divi',
                    'description' => esc_html__( 'This defines the size of the image.' ),
                    'tab_slug' => 'custom_css',
                    'toggle_slug' => 'attributes'
                ),
                'slider_offset' => array(
                    'label' => esc_html__( 'Slider Offset', 'before-after-images-for-divi' ),
                    'type' => 'range',
                    'option_category' => 'basic_option',
                    'options'           => array(
                        'min'      => esc_html__( '0%', 'before-after-images-for-divi' ),
                        'max'     => esc_html__( '100%', 'before-after-images-for-divi' ),
                        'step'     => esc_html__( '10%', 'before-after-images-for-divi' ),
                    ),
                    'default_on_front' => '50%',
                    'description' => esc_html__( 'This defines how much of the before image is visible when the page loads.', 'before-after-images-for-divi' ),
                    'tab_slug' => 'custom_css',
                    'toggle_slug' => 'attributes'
                ),
                'show_bottom_space' => array(
                    'label'             => esc_html__( 'Show Space Below The Image', 'before-after-images-for-divi' ),
                    'type'              => 'yes_no_button',
                    'option_category'   => 'layout',
                    'options'           => array(
                        'on'      => esc_html__( 'Yes', 'before-after-images-for-divi' ),
                        'off'     => esc_html__( 'No', 'before-after-images-for-divi' ),
                    ),
                    'default_on_front' => 'on',
                    'tab_slug'          => 'advanced',
                    'toggle_slug'       => 'margin_padding',
                    'description'       => esc_html__( 'Here you can choose whether or not the image should have a space below it.', 'before-after-images-for-divi' ),
                ),
                'align' => array(
                    'label'           => esc_html__( 'Image Alignment', 'before-after-images-for-divi' ),
                    'type'            => 'text_align',
                    'option_category' => 'layout',
                    'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
                    'default_on_front' => 'left',
                    'tab_slug'        => 'advanced',
                    'toggle_slug'     => 'alignment',
                    'description'     => esc_html__( 'Here you can choose the image alignment.', 'before-after-images-for-divi' ),
                    'options_icon'    => 'module_align',
                ),
                'force_fullwidth' => array(
                    'label'             => esc_html__( 'Force Fullwidth', 'before-after-images-for-divi' ),
                    'type'              => 'yes_no_button',
                    'option_category'   => 'layout',
                    'options'           => array(
                        'off' => esc_html__( 'No', 'before-after-images-for-divi' ),
                        'on'  => esc_html__( 'Yes', 'before-after-images-for-divi' ),
                    ),
                    'default_on_front' => 'off',
                    'tab_slug'    => 'advanced',
                    'toggle_slug' => 'width',
                    'affects' => array(
                        'max_width',
                    ),
                ),
                'always_center_on_mobile' => array(
                    'label'             => esc_html__( 'Always Center Image On Mobile', 'before-after-images-for-divi' ),
                    'type'              => 'yes_no_button',
                    'option_category'   => 'layout',
                    'options'           => array(
                        'on'  => esc_html__( 'Yes', 'before-after-images-for-divi' ),
                        'off' => esc_html__( 'No', 'before-after-images-for-divi' ),
                    ),
                    'default_on_front' => 'on',
                    'tab_slug'          => 'advanced',
                    'toggle_slug'       => 'alignment',
                ),
            );
            return $fields;
        }
        
        /**
         * 
         * @return mixed|string|void 
         */
        private function get_alignment() {

            $alignment = isset( $this->props['align'] ) ? $this->props['align'] : '';
            return et_pb_get_alignment( $alignment );
        }
        
        /** 
         * Render the module on the front end.
         * The following code contains lines of derivative code from Divi Builder, a plugin which is licensed GPLv2.
         * Original Copyright Elegant Themes <http://elegantthemes.com> and contributors.
         * 
         * @param   array   $attributes
         * @param   mixed|string|void|null   $content
         * @param   string  $render_slug
         * */ 
        public function render( $attributes, $content = null, $render_slug ) {
            
            // Set defalt values.
            $is_src_svg = false;
            $max_width = 0;
            $max_height = 0;
            $images_output = '';

            // Get selected image source URL's and construct the HTML output for the images.
            $src_before = isset( $attributes['src_before'] ) ? $attributes['src_before'] : '';
            $src_after = isset( $attributes['src_after'] ) ? $attributes['src_after'] : '';
            $src_pair = array( $src_before, $src_after );
            $images = get_images( $src_pair, $attributes );

            foreach( $images as $image){
                
                // Concatenate string of image output
                $images_output .= $image['output'];

                // Set max width to the width of the smallest image.
                $max_width = $image[ 'size_width' ];
                if( $image[ 'size_width' ] < $max_width ){
                    $max_width = $image[ 'size_width' ];
                }

                // Set max height to the height of the smallest image.
                $max_height = $image[ 'size_height' ];
                if( $image[ 'size_height' ] < $max_height ){
                    $max_height = $image[ 'size_height' ];
                }

                // Set this vaule to true if either image is an SVG.
                if( $image[ 'is_svg' ] ){
                    $is_src_svg = true;
                };
            };
            // Get standard Divi Image properties.
            $show_bottom_space          = $this->props['show_bottom_space'];
            $align                      = $this->get_alignment();
            $align_tablet               = $this->get_alignment( 'tablet' );
            $align_phone                = $this->get_alignment( 'phone' );
            $force_fullwidth            = $this->props['force_fullwidth'];
            $always_center_on_mobile    = $this->props['always_center_on_mobile'];
            $animation_style            = $this->props['animation_style'];
            $video_background           = $this->video_background();
            $parallax_image_background  = $this->get_parallax_image_background();

            // Run standard Divi Image fields logic.
            if ( 'on' === $force_fullwidth ) {
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%%',
                    'declaration' => 'max-width: 100% !important;',
                ) );

                ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .et_pb_image_wrap, %%order_class%% img',
                    'declaration' => 'width: 100%;',
                ) );
            }

            if ( ! $this->_is_field_default( 'align', $align ) ) {
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%%',
                    'declaration' => sprintf(
                        'text-align: %1$s;',
                        esc_html( $align )
                    ),
                ) );
            }

            if ( 'center' !== $align ) {
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%%',
                    'declaration' => sprintf(
                        'margin-%1$s: 0;',
                        esc_html( $align )
                    ),
                ) );
            }

            // Set display block for svg image to avoid disappearing svg image
            if ( $is_src_svg ) {
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% .et_pb_image_wrap',
                    'declaration' => 'display: block;',
                ) );
            }

            // Responsive Image Alignment.
            // Set CSS properties and values for the image alignment.
            // 1. Text Align is necessary, just set it from current image alignment value.
            // 2. Margin {Side} is optional. Used to pull the image to right/left side.
            // 3. Margin Left and Right are optional. Used by Center to reset custom margin of point 2.
            $align_values = array(
                'desktop' => array(
                    'text-align'      => esc_html( $align ),
                    "margin-{$align}" => ! empty( $align ) && 'center' !== $align ? '0' : '',
                ),
                'tablet'  => array(
                    'text-align'             => esc_html( $align_tablet ),
                    'margin-left'            => 'left' !== $align_tablet ? 'auto' : '',
                    'margin-right'           => 'left' !== $align_tablet ? 'auto' : '',
                    "margin-{$align_tablet}" => ! empty( $align_tablet ) && 'center' !== $align_tablet ? '0' : '',
                ),
                'phone'   => array(
                    'text-align'            => esc_html( $align_phone ),
                    'margin-left'           => 'left' !== $align_phone ? 'auto' : '',
                    'margin-right'          => 'left' !== $align_phone ? 'auto' : '',
                    "margin-{$align_phone}" => ! empty( $align_phone ) && 'center' !== $align_phone ? '0' : '',
                ),
            );
            et_pb_responsive_options()->generate_responsive_css( $align_values, '%%order_class%%', '', $render_slug, '', 'alignment' );

            // Module classnames
            if( isset( $attributes['size'] ) ){

                switch( $attributes['size'] ){
                    case "selectasize." :
                        $this->add_classname( 'no-size-selected' );
                    break;
                    case "fullsize." :
                        $this->add_classname( 'full-size-selected' );
                    break;
                    default :
                        $this->add_classname( 'size-selected-'. $max_width .'x' . $max_height );
                    break;
                }
            }
            if ( ! in_array( $animation_style, array( '', 'none' ) ) ) {
                $this->add_classname( 'et-waypoint' );
            }

            if ( 'on' !== $show_bottom_space ) {
                $this->add_classname( 'et_pb_image_sticky' );
            }

            if ( 'on' === $always_center_on_mobile ) {
                $this->add_classname( 'et_always_center_on_mobile' );
            }
            
            // Module inline styles
            $inline_css = 'max-width: '. $max_width . 'px;';
            
            switch( $align ){
                case( "center" ):
                    $inline_css .= 'margin-left: auto; margin-right: auto;';
                    break;
                case("right"):
                    $inline_css .= 'margin-left: auto; margin-right: 0;';
                    break;
                default:
                    break;
            }
            $inline_styles = 'style="'. $inline_css .'"';

            // Put it all together and return the output.
            $output = sprintf(
                '<div%3$s class="%2$s et_pb_image_wrap twentytwenty-container" %6$s>
                    %5$s
                    %4$s
                    %1$s
                </div>
                ',
                $images_output,
                $this->module_classname( $render_slug ),
                $this->module_id(),
                $video_background,
                $parallax_image_background,
                $inline_styles
            );
            return $output;
        }   
    }
}

// Create a new Before_After_Images_For_Divi_Module object.
new Before_After_Images_For_Divi_Module;
