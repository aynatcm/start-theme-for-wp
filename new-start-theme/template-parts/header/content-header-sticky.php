<section id="header-sticky-content" class="site-header-sticky" tabindex="-1">

	<div class="container">
		<div class="row cent-y">
			<div class="col position-static">
				<div class="site-header-sticky__menu-wrp">
					<div class="site-header-sticky__menu">

						<button id="site-nav-btn-menu--sticky-menu" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="icon icon-menu"><span class="visually-hidden"><?php esc_html_e( 'Menu', 'news-theme' ); ?></span></span></button>

					</div>
					<div class="site-header-sticky__branding cent-y">

						<p class="site-title">
							<?php sp_the_header_logo(); ?>
						</p>

					</div>
				</div>

			</div>

			<?php if ( is_category() ) : ?>
				<div class="col col-title">
					<div class="site-header-sticky__page-title"><?php echo single_cat_title(); ?></div>
				</div>
			<?php endif; ?>

			<div class="col-auto col-sm">
				<div class="site-header-sticky-icons">
					<button class="js-search-button-open search-button">
						<div class="icon icon-search"></div>
					</button>
				</div>
			</div>
		</div>
	</div>

</section><!-- #masthead -->

<div class="site-header-sticky site-header-sticky--only-menu">

	<div class="site-header-sticky__menu">

		<?php
		/*
			——— Wrapper menu mobile
		*/
		?>
		<div id="site-navigation--sticky-menu" class="main-navigation effect--leftIn">
			<div class="sticky-menu-content">
				<div class="sticky-menu-content__header">
					<img class="site-header__logo" src="<?php echo sp_get_asset( 'logo.svg' ); ?>" alt="">
					<button id="site-nav-btn-close--sticky-menu" class="menu-toggle menu-toggle__close"><span class="icon icon-close"><span class="visually-hidden"><?php esc_html_e( 'Close Menu', 'news-theme' ); ?></span></span></button>
				</div>
				<nav>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'show_toggles'   => true,
						)
					);
					?>
				</nav>
				<div class="sticky-menu-content__footer">
					<p class="sticky-menu-content__title">Vea nuestro contenido más reciente</p>

					<?php

					if ( $post_menu = get_field( 'widget_menu', 'option' ) ) {

						$options = array(
							'id'               => $post_menu,
							'hide_term'        => true,
							'hide_description' => true,
							'hide_meta'        => true,
							'class_title'      => 'trim-text-2 fs-3',
							'class_img'        => 'height-3',

						);

						get_template_part( 'template-parts/blocks/card', null, $options );
					}
					?>
				</div>
			</div>
		</div><!-- #site-navigation -->
	</div>

</div>
