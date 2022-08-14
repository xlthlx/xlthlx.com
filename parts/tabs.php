<?php global $lang,$post,$site_url; ?>
<div class="col-auto d-flex justify-content-end ms-auto">
	<a href="<?php echo $site_url; ?>mode/" title="Dark mode" id="btn-toggle" class="btn btn-outline-secondary lang pink-hover">
		<svg style="width:25px;height:25px;margin-top:-6px" aria-label="Dark mode" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 168.29 168.29">
			<path fill="currentColor" d="M159.81,127.909c-1.025-2.473-3.289-4.212-5.942-4.565c-24.423-3.241-45.44-19.364-54.848-42.078
	c-9.409-22.715-5.95-48.978,9.028-68.539c1.628-2.125,1.999-4.957,0.975-7.43c-1.024-2.473-3.289-4.212-5.942-4.565
	C99.416,0.247,95.69,0,92.005,0C80.957,0,70.152,2.155,59.889,6.406c-20.764,8.601-36.935,24.772-45.533,45.536
	c-8.597,20.761-8.595,43.628,0.004,64.39c13.074,31.563,43.595,51.957,77.756,51.957c0.001,0,0.001,0,0.001,0
	c11.051,0,21.872-2.161,32.164-6.424c13.644-5.652,25.592-14.825,34.553-26.528C160.462,133.213,160.834,130.382,159.81,127.909z
	 M118.541,148.008c-8.463,3.505-17.353,5.283-26.424,5.282c-28.073,0-53.155-16.76-63.899-42.698
	c-7.067-17.061-7.068-35.852-0.004-52.911C35.28,40.62,48.567,27.332,65.629,20.265c7.424-3.075,15.189-4.816,23.126-5.188
	c-11.761,22.021-13.291,48.521-3.595,71.93c9.694,23.405,29.509,41.059,53.392,48.315
	C132.687,140.647,125.916,144.953,118.541,148.008z"/>
		</svg>
	</a>
	<?php if ( 'en' === $lang ) { ?>
		<button title="English" type="button" class="btn btn-secondary pe-none lang active">EN</button>
		<a href="<?php echo get_url_trans(); ?>" title="Italiano"
		   class="btn btn-outline-secondary lang pink-hover" role="button">IT</a>
	<?php } else { ?>
		<a href="<?php echo get_url_trans(); ?>" title="English"
		   class="btn btn-outline-secondary lang pink-hover" role="button">EN</a>
		<button title="Italiano" type="button" class="btn btn-secondary pe-none lang active">IT</button>
	<?php } ?>
</div>
