<?php
if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_608d844a68c7a',
			'title'                 => __( 'Intranet', 'sme' ),
			'fields'                => array(
				array(
					'key'               => 'field_608d84b00fe96',
					'label'             => __( 'Fichiers Protégés', 'sme' ),
					'name'              => 'intranet_protected_files',
					'type'              => 'repeater',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'collapsed'         => '',
					'min'               => 0,
					'max'               => 0,
					'layout'            => 'table',
					'button_label'      => '',
					'sub_fields'        => array(
						array(
							'key'               => 'field_608d8bb03054e',
							'label'             => __( 'Fichiers', 'sme' ),
							'name'              => 'fichiers',
							'type'              => 'file',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'return_format'     => 'array',
							'library'           => 'all',
							'min_size'          => '',
							'max_size'          => '',
							'mime_types'        => '',
						),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'intranet',
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
		)
	);

endif;
