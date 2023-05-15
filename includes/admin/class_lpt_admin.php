<?php

defined('ABSPATH') ?: exit();

if (!class_exists('LPT_Placeholder_Content_Admin')) :

    class LPT_Placeholder_Content_Admin {

        /**
         * Constructor
         */
        public function __construct() {

            if (function_exists('acf_add_local_field_group')) :

                acf_add_local_field_group(array(
                    'key'    => 'group_64100efb13aa8',
                    'title'  => 'Landing page content placeholders and tracking ids',
                    'fields' => array(
                        array(
                            'key'               => 'field_641017145535f',
                            'label'             => 'Placeholder set',
                            'name'              => 'placeholder_set',
                            'type'              => 'repeater',
                            'instructions'      => 'Add your placeholder and rotating content sets using the inputs below',
                            'required'          => 0,
                            'conditional_logic' => 0,
                            'wrapper'           => array(
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ),
                            'collapsed'    => '',
                            'min'          => 1,
                            'max'          => 0,
                            'layout'       => 'block',
                            'button_label' => 'Add Placeholder Content Set',
                            'sub_fields'   => array(
                                array(
                                    'key'               => 'field_6410174055360',
                                    'label'             => 'Placeholder',
                                    'name'              => 'placeholder',
                                    'type'              => 'text',
                                    'instructions'      => 'For example, {content_1}',
                                    'required'          => 0,
                                    'conditional_logic' => 0,
                                    'wrapper'           => array(
                                        'width' => '20',
                                        'class' => '',
                                        'id'    => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder'   => '',
                                    'prepend'       => '',
                                    'append'        => '',
                                    'maxlength'     => '',
                                    'translations'  => 'translate',
                                ),
                                array(
                                    'key'               => 'field_6410176955361',
                                    'label'             => 'Content set',
                                    'name'              => 'content_set',
                                    'type'              => 'repeater',
                                    'instructions'      => 'The sets of content you would like to rotate, along with their tracking IDs',
                                    'required'          => 0,
                                    'conditional_logic' => 0,
                                    'wrapper'           => array(
                                        'width' => '80',
                                        'class' => '',
                                        'id'    => '',
                                    ),
                                    'collapsed'    => '',
                                    'min'          => 1,
                                    'max'          => 0,
                                    'layout'       => 'block',
                                    'button_label' => 'Add content & tracking ID',
                                    'sub_fields'   => array(
                                        array(
                                            'key'               => 'field_6410179c55362',
                                            'label'             => 'Content',
                                            'name'              => 'content',
                                            'type'              => 'textarea',
                                            'instructions'      => 'Add your content here',
                                            'required'          => 0,
                                            'conditional_logic' => 0,
                                            'wrapper'           => array(
                                                'width' => '',
                                                'class' => '',
                                                'id'    => '',
                                            ),
                                            'default_value' => '',
                                            'placeholder'   => '',
                                            'maxlength'     => '',
                                            'rows'          => '',
                                            'new_lines'     => '',
                                            'translations'  => 'translate',
                                        ),
                                        array(
                                            'key'               => 'field_641017be55363',
                                            'label'             => 'Tracking ID',
                                            'name'              => 'tracking_id',
                                            'type'              => 'text',
                                            'instructions'      => 'The tracking ID which will be appended to the landing page URL for this content, e.g. var_1',
                                            'required'          => 0,
                                            'conditional_logic' => 0,
                                            'wrapper'           => array(
                                                'width' => '',
                                                'class' => '',
                                                'id'    => '',
                                            ),
                                            'default_value' => '',
                                            'placeholder'   => '',
                                            'prepend'       => '',
                                            'append'        => '',
                                            'maxlength'     => '',
                                            'translations'  => 'translate',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'location' => array(
                        array(
                            array(
                                'param'    => 'post_type',
                                'operator' => '==',
                                'value'    => 'landing',
                            ),
                            
                        ),
                    ),
                    'menu_order'            => 0,
                    'position'              => 'normal',
                    'style'                 => 'default',
                    'label_placement'       => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen'        => '',
                    'active'                => true,
                    'description'           => '',
                ));

            endif;
        }
    }

endif;

new LPT_Placeholder_Content_Admin();
