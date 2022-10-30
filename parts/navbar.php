<?php global $site_url,$site_name,$site_desc,$lang,$post; ?>
<nav class="navbar navbar-expand-lg bg-dark">
	<div class="container-fluid">

		<h1 id="logo" class="display-2 font-italic text-start m-0 ps-3 py-1 d-flex align-items-center col text-decoration-none">
			<a title="<?php echo $site_desc; ?>" class="text-white text-decoration-none shadows"
			   href="<?php echo $site_url; ?>"><?php echo $site_name; ?></a>
		</h1>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="navbarPrimary" aria-controls="navbarPrimary" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarPrimary">
			<div class="col d-flex flex-wrap align-items-center justify-content-center py-3" id="navbarPrimary">
				<ul class="nav col-auto mb-2 justify-content-center">
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

			</div>
			<div class="col d-flex flex-wrap align-items-end justify-content-end text-end">

				<a href="<?php echo $site_url; ?>mode/" title="Dark mode" id="btn-toggle" class="btn btn-outline-secondary lang pink-hover">
					<svg class="dark-mode" aria-label="Dark mode" role="img" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
						<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
					</svg>
				</a>

				<?php get_template_part( 'parts/search-form' ); ?>
			</div>
		</div>
	</div>
</nav>
