<?php global $site_url,$site_name,$site_desc; ?>
<nav id="primary-nav" class="navbar navbar-dark bg-primary">
	<div class="container-fluid min-container">
		<h1 id="logo" class="display-2 font-italic text-start m-0 ps-3 py-1">
			<a title="<?php echo $site_desc; ?>" class="text-white text-decoration-none shadows"
			   href="<?php echo $site_url; ?>"><?php echo $site_name; ?></a>
		</h1>

		<nav class="navbar navbar-expand-lg">
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarToggler">
				<?php get_template_part( 'parts/tabs' ); ?>
				<ul class="navbar-nav me-auto mb-2 mb-lg-0 pe-4">
					<?php
					$menu_items = xlt_get_menu_items( 'primary' );
					foreach ( $menu_items as $menu_item ) {
						?>
						<?php if ( isset( $menu_item['submenu'] ) ) { ?>
							<li class="nav-item dropdown<?php echo $menu_item['classes']; ?>">
								<a class="nav-link dropdown-toggle"<?php echo $menu_item['target']; ?>
								   href="<?php echo $menu_item['url']; ?>"
								   id="<?php echo sanitize_title( $menu_item['title'] ); ?>" data-bs-toggle="dropdown"
								   aria-expanded="true"><?php echo $menu_item['title']; ?></a>
								<ul class="dropdown-menu bg-dark border-0 rounded-0"
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
		</nav>
	</div>
</nav>

