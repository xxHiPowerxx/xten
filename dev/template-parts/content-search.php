<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package xten
 */

$allsearch = new WP_Query( "s=$s&showposts=-1" );
$key       = esc_html( $s, 1 );
?>

<article id="post-<?php the_ID(); ?>" class="search-result">
	<a class="anchor-search-result" href="<?php the_permalink(); ?>" rel="bookmark">
		<header class="entry-header">
			<h5 class="entry-title"><?php search_term( get_the_title(), $key ); ?></h5>
		</header><!-- .entry-header -->
		<br />
		<span class="page-url">
			<?php echo esc_url( get_permalink() ); ?>
		</span>
	</a>
	<?php
	if ( get_the_excerpt() ) :
		?>
		<div class="entry-summary">
			<?php search_term( get_the_excerpt(), $key ); ?>
		</div><!-- .entry-summary -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
