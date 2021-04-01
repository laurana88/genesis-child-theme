<?php
/*
 Custom Front Page header
 */


	do_action( 'genesis_doctype' );
	do_action( 'genesis_title' );
	do_action( 'genesis_meta' );

wp_head(); // We need this for plugins.
?>
</head>


<?php
genesis_markup( array(
	'open'   => '<body %s>',
	'context' => 'body',
) );
do_action( 'genesis_before' );

genesis_markup( array(
	'open'   => '<div %s>',
	'context' => 'site-container',
) );

do_action( 'genesis_before_header' );
do_action( 'genesis_header' );
do_action( 'genesis_after_header' );

genesis_markup( array(
	'open'   => '<div %s>',
	'context' => 'site-inner',
) );
genesis_structural_wrap( 'site-inner' );
