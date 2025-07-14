<?php
date_default_timezone_set( 'America/Costa_Rica' ); ?>
<div class="top-bar">
	<div class="container">
		<div class="row row-content">
			<div class="col-auto col-sm-auto cent-y">
				<div class="top-bar__date-wrp">
					<ul>
						<li><?php echo sp_get_current_date(); ?></li>
						<li><?php echo date( 'g:i A' ); ?></li>
					</ul>
				</div>
			</div>
			<div class="col-auto col-sm-auto d-none d-sm-block">
				<div class="top-bar__icons-wrp">
					<button class="js-search-button-open search-button">
						<div class="icon icon-search"></div>
					</button>
					<div class="social-icons top-bar__social-wrp">
						<?php get_template_part( 'template-parts/social', 'icons', array( 'icon-suffix' => '' ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="search-form-wrp" aria-expanded="false">
	<div class="inner-wrap">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php get_template_part( 'template-parts/searchform' ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
