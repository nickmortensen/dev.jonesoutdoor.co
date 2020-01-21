<?php
/**
 * Template part for displaying the custom search form
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;


?>


<form action="/" method="get">
	<label for="search">
		<a class="material-icons text-white align-bottom text-2xl">search</a>
	</label>
	<input class="align-baseline" type="text" name="s" id="search" value="<?php the_search_query(); ?>" />
</form>

