<?php
// Field Array
$font_setting_meta_fields = array(
	array(
		'label' => __('Watermark text', 'mnbaa_watermark'),
		'desc' => __('Watermark text', 'mnbaa_watermark'),
		'type' => 'text',
		'name' => 'watermark_title'
				
	),
	array(
		'label'=> __('Image sizes', 'mnbaa_watermark'),
		'desc'  => '',
		'name'    => 'img_sizes[]',
		'type'  => 'checkbox'
		),
    array(
        'label' => __('Font type','mnbaa_watermark'),
        'desc' => __('Type of font.','mnbaa_watermark'),
        'type' => 'select',
        'name' => 'txt_type',
		'options' => array (
            'one' => array (
                'label' => 'ARIAL',
                'value' => 'ARIAL.TTF'
            ),
            'two' => array (
                'label' => 'TAHOMA',
                'value' => 'TAHOMA.TTF'
            ),
            'three' => array (
                'label' => 'VERDANA',
                'value' => 'VERDANA.TTF'
            ),
            'fourth' => array (
                'label' => 'courier',
                'value' => 'COURBI.TTF'
            ),
            'fifth' => array (
                'label' => 'SYMBOL',
                'value' => 'SYMBOL.TTF'
            ),
            'sixth' => array (
                'label' => 'ANDLOSI',
                'value' => 'ANDLSO.TTF'
            )
        )
    ),array(
        'type' => 'hidden',
        'name' => 'rgb'
    ),
    array(
        'label' => __('Font size','mnbaa_watermark'),
        'desc' => __('Size of font.', 'mnbaa_watermark'),
        'type' => 'select',
        'name' => 'txt_size',
		'options' => array (
            'one' => array (
                'label' => '8',
                'value' => '8'
            ),
            'two' => array (
                'label' => '9',
                'value' => '9'
            ),
            'three' => array (
                'label' => '10',
                'value' => '10'
            ),
            'fourth' => array (
                'label' => '11',
                'value' => '11'
            ),
            'fifth' => array (
                'label' => '12',
                'value' => '12'
            ),
            'sixth' => array (
                'label' => '14',
                'value' => '14'
            ),
            'seventh' => array (
                'label' => '16',
                'value' => '16'
            ),
            'eighth' => array (
                'label' => '18',
                'value' => '18'
            ),
            'ninth' => array (
                'label' => '20',
                'value' => '20'
            ),
            'tenth' => array (
                'label' => '22',
                'value' => '22'
            ),
            'eleventh' => array (
                'label' => '24',
                'value' => '24'
            ),
            'twelfth' => array (
                'label' => '26',
                'value' => '26'
            ),
            'thirteenth' => array (
                'label' => '28',
                'value' => '28'
            ),
            'fourteenth' => array (
                'label' => '36',
                'value' => '36'
            ),
            'fifteenth' => array (
                'label' => '48',
                'value' => '48'
            ),
            'sixeenth' => array (
                'label' => '72',
                'value' => '72'
            )
        )
        
    )
    
);

$position_setting_meta_fields = array(
	array(
			'label' => __('Rotation', 'mnbaa_watermark'),
			'desc' => __('Enter the value of the angle of rotation', 'mnbaa_watermark'),
			'type' => 'text',
			'name' => 'rotation'
			
		),
    array(
        'label' => __('Transparency', 'mnbaa_watermark'),
        'desc' => '',
        'type' => 'select',
        'name' => 'opicity',
    ),
    array(
        'label' => __('Position', 'mnbaa_watermark'),
        'desc' => __('Position of watermark', 'mnbaa_watermark'),
        'type' => 'select',
        'name' => 'position',
		'options' => array (
            'one' => array (
                'label' => __('top', 'mnbaa_watermark'),
                'value' => 'top'
            ),
            'two' => array (
                'label' =>  __('bottom', 'mnbaa_watermark'),
                'value' => 'bottom'
            )
        )
    ),array(
			'label' => __('The Horizontal distance', 'mnbaa_watermark'),
			'desc' => '',
			'type' => 'text',
			'name' => 'destance_x'
			
	),array(
			'label' => __('The vertical distance', 'mnbaa_watermark'),
			'desc' => '',
			'type' => 'text',
			'name' => 'padding'
			
		)
);

$background_setting_meta_fields = array(
    array(
        'label' => __('Use background', 'mnbaa_watermark'),
        'desc' => __('Add background behidn your text', 'mnbaa_watermark'),
        'type' => 'select',
        'name' => 'background',
		'options' => array (
            'one' => array (
                'label' => __('yes', 'mnbaa_watermark'),
                'value' => 'yes'
            ),
            'two' => array (
                'label' => __('no', 'mnbaa_watermark'),
                'value' => 'no'
            )
        )
        
    ),array(
        'type' => 'hidden',
        'name' => 'rgb_bg'
    ),array(
			'label' => __('The Horizontal distance', 'mnbaa_watermark'),
			'desc' => '',
			'type' => 'text',
			'name' => 'bg_destance_x'
			
	),array(
			'label' => __('The vertical distance', 'mnbaa_watermark'),
			'desc' => '',
			'type' => 'text',
			'name' => 'bg_padding'
			
		)
);

$img_upload_setting_meta_fields = array(
	array(
		'label'  => __('Image', 'mnbaa_watermark'),
		'desc'  => 'A description for the field.',
		'name'    => 'image',
		'type'  => 'image'
	)
	,array(
			'label' => __('Image Rotation', 'mnbaa_watermark'),
			'desc' => __('Enter the value of the angle of rotation', 'mnbaa_watermark'),
			'type' => 'text',
			'name' => 'img_rotation'
			
		),
    array(
        'label' => __('Image Transparency', 'mnbaa_watermark'),
        'desc' => '',
        'type' => 'select',
        'name' => 'img_opicity',
    ),
    array(
        'label' => __('Image Position', 'mnbaa_watermark'),
        'desc' => __('Position of watermark', 'mnbaa_watermark'),
        'type' => 'select',
        'name' => 'img_position',
		'options' => array (
            'one' => array (
                'label' => __('top', 'mnbaa_watermark'),
                'value' => 'top'
            ),
            'two' => array (
                'label' =>  __('bottom', 'mnbaa_watermark'),
                'value' => 'bottom'
            )
        )
    ),
    array(
        'label' => __('Image Size', 'mnbaa_watermark'),
        'desc' => __('Image size', 'mnbaa_watermark'),
        'type' => 'select',
        'name' => 'img_size',
		'options' => array (
            'one' => array (
                'label' => '1/4',
                'value' => '4'
            ),
            'two' => array (
                'label' =>  '1/3',
                'value' => '3'
            ),
            'three' => array (
                'label' =>  '1/2',
                'value' => '2'
            ),
            'fourth' => array (
                'label' =>  __('Full Size', 'mnbaa_watermark'),
                'value' => '1'
            )
        )
    ),array(
			'label' => __('The Horizontal distance', 'mnbaa_watermark'),
			'desc' => '',
			'type' => 'text',
			'name' => 'img_destance_x'
			
	),array(
			'label' => __('The vertical distance', 'mnbaa_watermark'),
			'desc' => '',
			'type' => 'text',
			'name' => 'img_padding'
			
		)
);


?>