<?php
/**
 * Template part for displaying the header navigation menu -- uses tailwind.css.
 *
 * @link https://tailwindcss.com/components/navigation/#
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

if ( ! wp_rig()->is_customized_navigation_menu_active() ) {
	return;
}
?>
<!-- hamburger menu is inserted for small screens by javascript -->
<div class="block lg:hidden">
	<div class="menu-wrapper">
		<div class="hamburger-menu"></div>
	</div>
</div>

<!-- actual links -->
<div
id="nav-content"
class="w-full flex-grow lg:flex lg:flex-1 lg:content-center lg:justify-end lg:w-auto sm:h-fill toggle-hidden hidden pt-14 lg:pt-0">
	<div class="text-sm lg:flex-grow">

		<a
		href="/"
		class="block mt-4 lg:inline-block lg:mt-0 mt-12 text-white hover:text-white lg:mr-8 no-underline"
		data-sectiontitle="staffmembers"
		>Staff</a>

		<a
		href="/page-2.html"
		class="block mt-4 lg:inline-block lg:mt-0 mt-12 text-white hover:text-white lg:mr-8 no-underline"
		data-sectiontitle="locations"
		>Locations</a>

		<a
		href="/page-3.html"
		class="block mt-4 lg:inline-block lg:mt-0 mt-12 text-white hover:text-white lg:mr-8 no-underline"
		data-sectiontitle="connect"
		>Connect</a>

		<a
		href="/page-4.html"
		class="block mt-4 lg:inline-block lg:mt-0 mt-12 text-white hover:text-white no-underline lg:pb-0 pb-12 lg:mr-8"
		data-sectiontitle="artwork"
		>Artwork</a>

		<input class="w-full h-8 px-3 rounded mb-8 focus:outline-none focus:shadow-outline text-xl px-8 shadow-lg" type="search" placeholder="Search...">
	</div>

	<!-- <div class="container mx-auto py-8">
	</div> -->
<div>

<!-- eventually the search function -->
