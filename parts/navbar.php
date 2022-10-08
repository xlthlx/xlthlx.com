<?php global $site_url,$site_name,$site_desc; ?>
<nav id="primary-nav" class="navbar navbar-dark bg-primary">
	<div class="container-fluid min-container">
		<h1 id="logo" class="display-2 font-italic text-start m-0 ps-3 py-1">
			<a title="<?php echo $site_desc; ?>" class="text-white text-decoration-none shadows"
			   href="<?php echo $site_url; ?>"><?php echo $site_name; ?></a>
		</h1>

		<?php get_template_part( 'parts/tabs' ); ?>

		<button id="navbar-toggler" class="navbar-toggler text-white border-0 shadow-none pe-3"
				type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-expanded="false"
				aria-controls="menuOffcanvas" aria-label="{{ _e( 'Toggle navigation') }}">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="offcanvas offcanvas-end bg-dark" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
			<div class="offcanvas-header pb-0 white-text">
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
				</button>
			</div>
			<div class="offcanvas-body pb-5rem px-5">
				<ul class="navbar-nav me-auto mb-2 mb-xl-0">

					<?php
					$menu_items = xlt_get_menu_items( 'primary' );
					foreach ( $menu_items as $menu_item ) { 
						?>
						<?php if ( isset( $menu_item['submenu'] ) ) { ?>
							<li class="nav-item dropdown pink<?php echo $menu_item['classes']; ?>">
								<a class="nav-link dropdown-toggle pink show"<?php echo $menu_item['target']; ?>
								   href="<?php echo $menu_item['url']; ?>"
								   id="<?php echo sanitize_title( $menu_item['title'] ); ?>" data-bs-toggle="dropdown"
								   aria-expanded="true"><?php echo $menu_item['title']; ?></a>
								<ul class="dropdown-menu bg-dark border-0 rounded-0 show"
									aria-labelledby="<?php echo sanitize_title( $menu_item['title'] ); ?>">
									<?php foreach ( $menu_item['submenu'] as $menu_subitem ) { ?>
										<li class="white">
											<a class="dropdown-item white"<?php echo $menu_subitem['target']; ?>
											   href="<?php echo $menu_subitem['url']; ?>">
												<?php echo $menu_subitem['title']; ?>
											</a>
										</li>
									<?php } ?>
								</ul>
							</li>
						<?php } else { ?>
							<li class="nav-item white-text<?php echo $menu_item['classes']; ?>">
								<a class="nav-link white-text"<?php echo $menu_item['target']; ?>
								   href="<?php echo $menu_item['url']; ?>">
									<?php echo $menu_item['title']; ?>
								</a>
							</li>
						<?php } ?>
					<?php } ?>
				</ul>
				<div class="my-3">
					<?php get_template_part( 'parts/search-form' ); ?>
				</div>
			</div>
		</div>
	</div>
</nav>

