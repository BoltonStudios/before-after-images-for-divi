<?php

class BAIE_HelloWorld extends ET_Builder_Module {

	public $slug       = 'baie_hello_world';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.boltonstudios.com/before-after-images-for-divi/',
		'author'     => 'Bolton Studios LLC',
		'author_uri' => 'https://www.boltonstudios.com/',
	);

	public function init() {
		$this->name = esc_html__( 'Hello World', 'baie-before-after-images-for-divi' );
	}

	public function get_fields() {
		return array(
			'content' => array(
				'label'           => esc_html__( 'Content', 'baie-before-after-images-for-divi' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'baie-before-after-images-for-divi' ),
				'toggle_slug'     => 'main_content',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		return sprintf( '<h1>%1$s</h1>', $this->props['content'] );
	}
}

new BAIE_HelloWorld;
