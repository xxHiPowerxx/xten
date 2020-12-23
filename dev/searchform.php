<?php
/**
 * Template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage XTen
 */

?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="text" class="form-control field search-field " name="s" title="Search" aria-label="Search" placeholder="<?php esc_attr_e( 'Search', 'xten' ); ?>" onfocus="this.placeholder = ''"

		onblur="this.placeholder = 'Search'" value="<?php the_search_query(); ?>">
		<div class="input-group-append">
			<button type="submit" role="button" aria-label="Search Button" class="btn submit btn-theme-style fas fa-search" name="submit"></button>
		</div>
	</div>
</form>
