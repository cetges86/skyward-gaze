<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'Backup & Demo Content', 'fw' );
$manifest['description'] = __(
	'This extension lets you create an automated backup schedule,'
	.' import demo content or even create a demo content archive for migration purposes.',
	'fw'
);
$manifest['version'] = '2.0.25';
$manifest['display'] = false;
$manifest['standalone'] = true;
$manifest['requirements'] = array(
	'framework' => array(
		'min_version' => '2.6.16',
	),
);

$manifest['github_update'] = 'ThemeFuse/Unyson-Backups-Extension';
