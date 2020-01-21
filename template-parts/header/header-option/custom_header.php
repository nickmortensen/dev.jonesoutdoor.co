<?php
/**
 * Template part for displaying the custom header media
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$src              = wp_get_attachment_image_src( 103, 'large', false );
$svg              = get_template_directory_uri() . '/assets/images/header_bg_mask.svg';
$header_gradients = [ 'bloodymary', 'steelgray', 'horizon', 'rosewater', 'aubergine', 'aquamarine', 'sunrise', 'purple', 'seaweed', 'mirage', 'reef', 'stellar' ];
$quantity         = count( $header_gradients ) - 1;

?>
<style>
.frontpage-header-background {
	background: no-repeat bottom url('<?= esc_url( $svg ); ?>'),  radial-gradient(circle at 12.26% 75.15%, #ff512f, transparent 100%), radial-gradient(circle at 87.6% 61.19%, #dd2476, transparent 100%), radial-gradient(circle at 50% 50%, #8590e3, #8590e3 100%);
}
</style>

<div class="site w-screen flex flex-col flex-no-wrap items-center justify-center align-middle">
	<!-- <?php //wp_rig()->display_contact_form(); ?> -->




	<section id="frontpage-header" class="w-full flex flex-col frontpage-header-background mb-16">
		<!-- Header features a logo, a gradient background, an svg mast and a billboard image -->
		<header class="w-full xl:px-0 px-2 pb-4">
			<div class="mx-auto flex justify-around flex-wrap mt-4 mb-4 px-8">
				<!-- the familiar hamburger menu icon only appears on small screens -->
				<i class="ion-android-menu text-5xl text-white md:hidden"></i>
				<!-- logo plus company name -->
				<div class="hidden md:flex w-1/3">
					<svg version="1.1" id="isologo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 399.998 399.997" style="enable-background:new 0 0 399.998 399.997;" xml:space="preserve"> <path fill="white" d="M292.41,236.617l-42.814-27.769c5.495-15.665,4.255-33.162-3.707-48.011l35.117-31.373 c19.292,12.035,45.001,9.686,61.771-7.085c19.521-19.52,19.521-51.171,0-70.692c-19.522-19.521-51.175-19.521-70.694,0 c-15.378,15.378-18.632,38.274-9.788,56.848l-35.121,31.378c-16.812-11.635-38.258-13.669-56.688-6.078l-40.5-55.733 c14.528-19.074,13.095-46.421-4.331-63.849c-19.004-19.004-49.816-19.004-68.821,0c-19.005,19.005-19.005,49.818,0,68.822 c13.646,13.646,33.374,17.491,50.451,11.545l40.505,55.738c-20.002,23.461-18.936,58.729,3.242,80.906 c0.426,0.426,0.864,0.825,1.303,1.237l-39.242,68.874c-16.31-3.857-34.179,0.564-46.899,13.286 c-19.521,19.522-19.521,51.175,0,70.694c19.521,19.521,51.173,19.521,70.693,0c19.317-19.315,19.508-50.503,0.593-70.069 l39.239-68.867c19.705,5.658,41.737,0.978,57.573-14.033l42.855,27.79c-2.736,12.706,0.821,26.498,10.696,36.372 c15.469,15.469,40.544,15.469,56.012,0c15.468-15.466,15.468-40.543,0-56.011C329.831,226.518,307.908,225.209,292.41,236.617z M83.129,338.906c-0.951,1.078-1.846,2.096-2.724,2.973c-1.094,1.093-2.589,2.425-4.444,2.998 c-2.33,0.719-4.711,0.086-6.536-1.739c-4.772-4.771-2.947-13.799,4.246-20.989c7.195-7.195,16.219-9.021,20.993-4.247 c1.824,1.822,2.457,4.205,1.737,6.536c-0.572,1.855-1.904,3.354-2.997,4.444c-0.878,0.876-1.896,1.771-2.975,2.722 c-1.245,1.096-2.535,2.229-3.805,3.497C85.355,336.37,84.224,337.66,83.129,338.906z M279.56,59.17 c7.193-7.193,16.219-9.02,20.991-4.247c1.823,1.823,2.458,4.205,1.737,6.537c-0.572,1.856-1.905,3.354-2.997,4.446 c-0.876,0.875-1.894,1.77-2.974,2.72c-1.246,1.097-2.534,2.229-3.805,3.498c-1.271,1.271-2.403,2.562-3.5,3.808 c-0.948,1.076-1.846,2.097-2.72,2.973c-1.093,1.093-2.591,2.425-4.446,2.998c-2.332,0.719-4.712,0.086-6.536-1.739 C270.541,75.391,272.366,66.362,279.56,59.17z M73.322,37.854c-0.928,1.05-1.799,2.042-2.648,2.895 c-1.063,1.063-2.521,2.358-4.329,2.919c-2.269,0.698-4.587,0.083-6.364-1.691c-4.646-4.647-2.866-13.436,4.138-20.438 c7.003-7.004,15.788-8.782,20.436-4.135c1.776,1.776,2.395,4.095,1.692,6.363c-0.561,1.807-1.854,3.265-2.918,4.326 c-0.854,0.854-1.846,1.727-2.896,2.648c-1.213,1.066-2.469,2.17-3.704,3.406C75.492,35.384,74.387,36.642,73.322,37.854z M159.967,155.76c8.593-8.594,19.371-10.774,25.073-5.073c2.18,2.181,2.937,5.024,2.078,7.81 c-0.688,2.218-2.277,4.005-3.583,5.312c-1.047,1.047-2.265,2.112-3.553,3.248c-1.486,1.311-3.026,2.662-4.544,4.179 c-1.518,1.519-2.87,3.058-4.178,4.547c-1.136,1.287-2.205,2.505-3.251,3.55c-1.306,1.31-3.093,2.896-5.311,3.582 c-2.784,0.859-5.628,0.104-7.811-2.077C149.189,175.132,151.374,164.354,159.967,155.76z M299.11,262.103 c-0.868,0.866-2.056,1.923-3.524,2.376c-1.846,0.569-3.729,0.068-5.178-1.377c-3.783-3.781-2.338-10.933,3.365-16.633 c5.697-5.7,12.849-7.146,16.632-3.362c1.443,1.443,1.945,3.33,1.376,5.179c-0.453,1.471-1.51,2.656-2.375,3.521 c-0.694,0.692-1.5,1.402-2.355,2.155c-0.984,0.866-2.008,1.766-3.013,2.771c-1.007,1.006-1.907,2.026-2.771,3.016 C300.512,260.604,299.802,261.409,299.11,262.103z"/> </svg>
					<a href="/" class="text-lg text-white ml-1 font-bold">Jones Outdoor</a>

				</div>

				<!-- menu items -->
				<nav role="navigation" class="w-screen flex flex-col md:flex-row md:w-2/3 justify-end">

					<?php
						$menu_items = [ 'locations', 'people' ];
						foreach ( $menu_items as $item ) {
							//phpcs:disable
							echo '<a class="md:border md:rounded-full menu-link mr-2" href="#' . $item . '" title="click to scroll down to the ' . $item . 's section">' . $item . '</a>';
							//phpcs:enable
						}
					?>
<!-- only show this buton on my local copy of the site -->
<?php if ( 'development' === ENVIRONMENT ) : ?>
					<!-- just a heads up on what screen we are on - not for production -->
					<a id="show-width-button" class="border border-white menu-link mr-2 rounded-full bg-blue-700" href="#width">SIZING</a>
					<!-- END just a heads up on what screen we are on - not for production -->
					<script type="text/javascript">
						const showWidthButton = document.getElementById( 'show-width-button' );
						showWidthButton.innerText = window.innerWidth;
						window.addEventListener( 'resize', () => {
							let data = window.innerWidth;
							let content = `xl > 1279: <strong class="underline"><em> ${data}</em></strong>`;
							if ( data < 640 ) {
								content = `xs < 640: <strong class="underline"><em> ${data}</em></strong>`;
							} else if ( ( 641 < data ) && ( 768 > data ) ) {
								content = `sm > 639: <strong class="underline"><em> ${data}</em></strong>`;
							} else if ( ( 767 < data ) && ( 1024 > data) ) {
								content = `md > 767: <strong class="underline"><em> ${data}</em></strong>`;
							} else if ( ( 1023 < data ) && ( 1280 > data ) ) {
								content = `lg > 1023:<strong class="underline"><em> ${data}</em></strong>`;
							}
							const showWidthButton = document.getElementById( 'show-width-button' );
							showWidthButton.innerHTML = content;
						}, true );

					</script>
<?php endif; ?>
				</nav>
			</div>
		</header><!-- end header contains logo, company name and a learn more button -->

		<!-- hero section headline, call to action, subscribe + graphic -->
		<div class="w-full">
			<div class="mx-auto flex flex-col flex-col-reverse md:flex-row sm:items-center xl:pb-16 xl:px-0 px-4 ">

				<div class="w-full md:w-1/2 text-white flex flex-col justify-start content-center md:pl-8 h-32">
					<h2 class="md:font-hairline text-xl text-white">Jones Outdoor
					<?php if ( 'development' === ENVIRONMENT ) echo 'dev'; ?>

					</h2>
					<h2 class="md:font-hairline text-base mb-2">Digital and Static Billboards in Wisconsin.</h2>
					<!-- medium and larger screens will show a button that clicking on makes a form appear at the top of the page -->
					<button
					id="show-contact-form"
					title="toggle a contact form by clicking"
					class="hidden w-1/2 md:block btn">
					<i class="material-icons align-bottom">email</i>
					<span id="cta">connect</span>
					</button>

				</div>


				<script type="text/javascript">

					/**
					 * When we click the button to toggle the form at the top of the page, we also want to set the focus to the first item - the "What is your name question";
					 */
					let topForm                   = document.getElementById( 'frontpage-form' );
					const showFormButton          = document.getElementById( 'show-contact-form' );


					const toggleTopForm = ( e, current ) => {
						e.preventDefault();
						const icon = current.getElementsByTagName( 'i' )[0];
						const cta  = current.querySelector( '#cta' );
						let open   = 'form__open';
						let close  = 'form__close';
						if ( topForm.classList.contains( open ) ) {
							topForm.classList.replace( open, close );
							setTimeout( () => {
								icon.innerText = 'email';
								cta.innerText = 'connect'
							}, 600 );

						} else {
							topForm.classList.replace( close, open );
							setTimeout( () => {
								icon.innerText = 'close';
								cta.innerText = 'close'
							}, 800 );
							if (document.querySelectorAll('#theInputField')[0].dataset.fieldname == 'inquiryPersonName' ) {
								document.querySelectorAll('#theInputField')[0].focus();
						}
					}
						// current.innerHTML == 'Connect' ? showFormButton.innerHTML = 'close' : showFormButton.innerHTML = 'connect';
					};

					showFormButton.addEventListener( 'click', function( e ) {
						toggleTopForm( e, this );
					}, false );
				</script>

				<!-- RIGHT SIDE BILLBOARD GRAPHIC -->
				<div class="w-full md:w-1/2">
					<h3 id="windowWidth" class="text-white"></h3>
					<img src="<?= esc_url( $src[0] ); ?>" />
				</div>
			</div>
		</div>
		<!-- end hero section -->
	</section><!-- end section#frontpage-header -->


cd /Applications/"Visual Studio Code.app"/Contents/Resources/app/bin/code
