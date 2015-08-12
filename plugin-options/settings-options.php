<?php

$settings = array(

	'settings'  => array(

		'general-options' => array(
			'title' => __( 'General Options', 'yith-wccos' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'yith-wccos-general-options'
		),

		'general-options-end' => array(
			'type'      => 'sectionend',
			'id'        => 'yith-wccos-general-options'
		)

	)
);

return apply_filters( 'yith_wccos_panel_settings_options', $settings );