<?php
/**
 * Search field in main menu.
 *
 * @link https://tailwindtoolbox.com/search.
 * Will have company name and tagline on left.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<!-- <nav id="header" class="fixed w-full"> -->

	<!--Nav-->
	<div class="relative w-full z-10 fixed top-0 bg-gray-200 border-b border-grey-light reef-gradient">
		<div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-4">

			<!-- logo + Sitename + search icon -->
			<div class="pl-4 flex items-center">

				<!-- could do a logo here -->

				<!-- <svg class="h-5 pr-3 fill-current text-teal-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
					<path d="M17.94 11H13V9h4.94A8 8 0 0 0 11 2.06V7H9V2.06A8 8 0 0 0 2.06 9H7v2H2.06A8 8 0 0 0 9 17.94V13h2v4.94A8 8 0 0 0 17.94 11zM10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20z"/>
				</svg> -->

				<!-- end logo -->

				<!-- site name and tagline -->
				<a
				class="text-white text-base no-underline hover:no-underline font-extrabold text-xl"
				href="#"
				> Jones Outdoor</a>



			</div><!-- END logo + Sitename + search icon -->





			<!-- this would be hamburgerized menu thata ppears on small screens-->


			<div class="pr-4">

				<button
				id="nav-toggle"
				class="block lg:hidden flex items-center px-3 py-2 border rounded text-grey border-grey-dark hover:text-black hover:border-purple appearance-none focus:outline-none"
				>
					<svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<title>Menu</title>
						<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
					</svg>
				</button>
			</div>

			<!-- END hamburger-->


		<!-- link items -->
		<div
		class="w-full flex-grow lg:flex lg:flex-1 lg:content-center lg:justify-end lg:w-auto hidden lg:block mt-2 lg:mt-0 z-20"
		id="nav-content">

			<ul class="list-reset lg:flex justify-end items-center">
				<li class="mr-3 py-2 lg:py-0">
					<a class="inline-block py-2 px-4 text-black font-bold no-underline" href="#">Active</a>
				</li>
				<li class="mr-3 py-2 lg:py-0">
					<a class="inline-block text-grey-dark no-underline hover:text-black hover:underline py-2 px-4" href="#">link</a>
				</li>
				<li class="mr-3 py-2 lg:py-0">
					<a class="inline-block text-grey-dark no-underline hover:text-black hover:underline py-2 px-4" href="#">link</a>
				</li>
			</ul>

				<!-- search icon -->
				<div
				id="search-toggle"
				class="search-icon cursor-pointer pl-6"
				>
					<svg class="fill-current pointer-events-none text-grey-darkest w-4 h-4 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
						<path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
					</svg>
				</div><!-- end search icon -->

		</div><!-- END link items -->

		</div>
	</div>

	<!--Search-->
	<div
	class="relative w-full hidden bg-white shadow-xl"
	id="search-content"
	>
		<div class="container mx-auto py-4 text-black">
			<input
			id="searchfield"
			type="search"
			placeholder="Search..."
			autofocus="autofocus"
			class="w-full text-grey-800 transition focus:outline-none focus:border-transparent p-2 appearance-none leading-normal text-xl lg:text-2xl">
		</div>

	</div>
	<!--END Search-->

<!-- </nav> -->



	<!-- <div class="pt-24 container mx-auto">
		<div class="bg-white border p-6 rounded shadow h-64">
			Click the
			<svg class="fill-current pointer-events-none text-grey-darkest w-4 h-4 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
				<path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
			</svg> to show the search field.
		</div>
	</div> -->


<!--
<script>

const searchMenuDiv = document.getElementById( 'search-content' );
const searchMenu    = document.getElementById( 'search-toggle' );

const navMenuDiv    = document.getElementById( 'nav-content' );
const navMenu       = document.getElementById( 'nav-toggle' );

// const searchfield   = document.getElementById( 'searchfield' );



const check = e => {
	let target = ( e && e.target ) || ( event && eventSrcElement );

	// User Menu.
	if ( ! checkParent( target, searchMenuDiv ) ) {
		// click NOT on the menu.
		if ( checkParent( target, searchMenu ) ) {
			// Click on the link.
			if ( searchMenuDiv.classlist.contains( 'hidden' ) ) {
				searchMenuDiv.classlist.remove( 'hidden' );
				searchfield.focus();
			} else {
				searchMenuDiv.classlist.add( 'hidden' );
			}
		} else {
			// click gell both outside link and outside menu - so hide the menu.
			searchMenuDiv.classlist.add( 'hidden' );
		}
	}

	// Navigation menu.
	if ( ! checkParent( target, navMenuDiv ) ) {
		// click NOT on the menu.
		if ( checkParent( target, navMenu ) ) {
			// Click on the link.
			if ( navMenuDiv.classlist.contains( 'hidden' ) ) {
				navMenuDiv.classlist.remove( 'hidden' );
				searchfield.focus();
			} else {
				navMenuDiv.classlist.add( 'hidden' );
			}
		} else {
			// click gell both outside link and outside menu - so hide the menu.
			navMenuDiv.classlist.add( 'hidden' );
		}
	}

};

const checkParent = ( targeted, element ) => {
	while ( targeted.parentNode ) {
		if ( targeted === element ) {
			return true;
		}
		targeted = targeted.parentNode;
	}
	return false;
};
document.onclick = check();
</script>
-->

<script>
/*Toggle dropdown list*/
/*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

var searchMenuDiv = document.getElementById("search-content");
var searchMenu = document.getElementById("search-toggle");

var navMenuDiv = document.getElementById("nav-content");
var navMenu = document.getElementById("nav-toggle");

document.onclick = check;

function check(e) {
	var target = (e && e.target) || (event && event.srcElement);

	//User Menu
	if (!checkParent(target, searchMenuDiv)) {
		// click NOT on the menu
		if (checkParent(target, searchMenu)) {
			// click on the link
			if (searchMenuDiv.classList.contains("hidden")) {
				searchMenuDiv.classList.remove("hidden");
				searchfield.focus();
			} else {
				searchMenuDiv.classList.add("hidden");
			}
		} else {
			// click both outside link and outside menu, hide menu
			searchMenuDiv.classList.add("hidden");
		}
	}

	//Nav Menu
	if (!checkParent(target, navMenuDiv)) {
		// click NOT on the menu
		if (checkParent(target, navMenu)) {
			// click on the link
			if (navMenuDiv.classList.contains("hidden")) {
				navMenuDiv.classList.remove("hidden");
			} else {
				navMenuDiv.classList.add("hidden");
			}
		} else {
			// click both outside link and outside menu, hide menu
			navMenuDiv.classList.add("hidden");
		}
	}

}

function checkParent(t, elm) {
	while (t.parentNode) {
		if (t == elm) {
			return true;
		}
		t = t.parentNode;
	}
	return false;
}
</script>
