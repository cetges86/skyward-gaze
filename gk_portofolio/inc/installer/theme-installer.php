<?php
global $pagenow;

if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
	wp_redirect(admin_url("admin.php?page=fw-extensions")); // Your admin page URL
}

function gk_portfolio_admin_menu( $data ) {
	if ( defined( 'WP_ENV' ) && 'development' === WP_ENV ) {
		$content_callback = $data['content_callback'];
	} else {
		$content_callback = 'gk_portfolio_intro';
	}
	add_menu_page(
		__( 'GK Portfolio', 'gk-portfolio' ),
		__( 'GK Portfolio', 'gk-portfolio' ),
		'manage_options',
		$data['slug'],
		$content_callback,
		get_template_directory_uri() . '/images/gk-logo/favicon.gif',
		'59.5'
	);
}
add_action( 'fw_backend_add_custom_extensions_menu', 'gk_portfolio_admin_menu' );

function gk_portfolio_admin_menu_style() {
	echo '<style type="text/css">#adminmenu .toplevel_page_fw-extensions .wp-menu-image img{padding-top:7px} .toplevel_page_fw-extensions > .wp-menu-image:before{display:none}</style>';
}
add_action( 'admin_head', 'gk_portfolio_admin_menu_style' );

function gk_portfolio_intro() {
	if ( isset( $_GET['tab'] ) ) $current = $_GET['tab']; else $current = 'getting-started';
	$tabs = array( 'getting-started' => __( 'Getting Started', 'gk-portfolio' ), 'changelogs' => __( 'Changelogs', 'gk-portfolio' ) );
	$current_theme = wp_get_theme(); ?>
	<div class="wrap about-wrap gk">
		<div class="about-us">
			<div class="left gk-info">
				<h1><?php printf( __( 'Welcome to %1s', 'gk-portfolio' ), $current_theme->get( 'Name' ) ); ?></h1>
				<p class="about-text"><?php _e( 'Thank you for purchasing our WordPress theme. If you have any question about this theme, please submit to our <a href="https://www.gavick.com/forums">Forum</a>.', 'portfolio' ); ?></p>
			</div>
			<div class="right gk-logo">
				<img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" width="120" height="120" alt="portfolio screenshot">
				<ul class="text-center">
					<li>By <a href="https://www.gavick.com" target="blank">Gavick</a></li>
						<li>Version <?php echo $current_theme->get( 'Version' );?></li>
					</ul>
			</div>
		</div>
		<h2 class="nav-tab-wrapper" id="gk-tabs">
		<?php foreach( $tabs as $tab => $name ){
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='admin.php?page=fw-extensions&tab=$tab#top#$tab'>$name</a>";
		} ?>
		</h2>

		<?php switch ( $current ) { case 'getting-started' : ?>
		<div id="getting-started" class="active  content-info left">
			<p class="about-description"><?php printf( __( 'Use the tips below to get started using %s. You will be up and running in no time!', 'gk-portfolio' ), $current_theme->get( 'Name' ) ); ?></p>
			
			<div class="portfolio-box portfolio-install-demo">
				<h2><?php _e( 'Install Demo Content', 'gk-portfolio' ); ?></h2>
				<p class="desc"><?php _e( 'Installing demo content makes your site look exactly like our demo site. It deletes the content you are currently having on your website. However, we have created a backup of your current content in (<a href="tools.php?page=fw-backups">Tools > Backup</a>). You can restore the backup here at any time.', 'gk-portfolio' ); ?></p>
				<p><a href="admin.php?page=fw-backups-demo-content" target="_blank" class="gk-btn button button-primary"><?php _e( 'Go to install demo', 'gk-portfolio' ); ?></a></p>
			</div>

		</div>
		<div class="right-sidebar sidebar-note">
			<strong style="color:#d13631;">NOTE*:</strong>
			<div class="content-note">
				<p><?php _e('
					Install plugins and then install demo content.<br>
					Please do not update extensions of Unyson because we have customized the Backup extension for the install demo option. If you have any issue or question about the Install demo option, you can submit to our <a href="https://www.designwall.com/question/">Q&A section</a>'); ?>
				</p>
			</div> 
		</div>
		<?php break; case 'changelogs' : ?>
		<div id="changelogs" class="active">
		<?php
		$file = file_exists( get_template_directory() . '/changelogs.txt' ) ? get_template_directory() . '/changelogs.txt' : false;
		if ( !$file ) {
			$readme = '<p>' . __( 'No valid changelog was found.', 'gkqa' ) . '</p>';
		} else {
			$readme = file_get_contents( $file );
			$readme = nl2br( esc_html( $readme ) );
			$readme = preg_replace( '/`(.*?)`/', '<code>\\1</code>', $readme );
			$readme = preg_replace( '/[\040]\*\*(.*?)\*\*/', ' <strong>\\1</strong>', $readme );
			$readme = preg_replace( '/[\040]\*(.*?)\*/', ' <em>\\1</em>', $readme );
			$readme = preg_replace( '/= (.*?) =/', '<h3>\\1</h3>', $readme );
			$readme = preg_replace( '/\[(.*?)\]\((.*?)\)/', '<a href="\\2">\\1</a>', $readme );
		}
		echo '<p>'. $readme . '</p>';
		?>
		</div>
		<?php break; } ?>
	</div>
	<?php
}