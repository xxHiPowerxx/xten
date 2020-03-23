<?php
/**
 * New XTen Header used in Standard Header (header-standard.php).
 *
 * @package xten
 */

$standard_header_selection = $GLOBALS['internet_or_xtenline'];
$icon_fa_svg_chevron_down = '<svg focusable="false" xmlns="http://www.w3.org/2000/svg" class="fa-svg-chevron-down" style="width:.875em;height:1em;" viewBox="0 0 448 512"><path fill="currentColor" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg>';
?>

<div class="xten-header">
	<div class="mobile-navigation">
		<button id="<?php echo $is_mobile_gobal_nav ? 'mobile-nav-close' : 'mobile-nav-open' ?>" class="mobile-toggler" type="button" data-toggle="collapse" aria-controls="mobile-sidebar" aria-expanded="false" aria-label="Toggle navigation" tabindex="0">
			<?php
			if ( $is_mobile_gobal_nav ) :
			?>
			<div class="label">CLOSE</div>
			<div class="mobile-toggler-icon">
				<i class="fas fa-times"></i>
			</div>
			<?php
			else :
			?>
			<div class="label">MENU</div>
			<div class="mobile-toggler-icon">
				<i class="fas fa-bars"></i>
			</div>
			<?php
			endif;
			?>
		</button>
	</div>

	<?php
	if ( $is_mobile_gobal_nav ) :
		?>
			<button class="btn mobile-xten-nav-trigger mobile-nav-trigger" type="button" data-toggle="collapse" data-target="#mobile-xten-navigation" aria-expanded="false" aria-controls="mobile-xten-navigation">
				<div><span>xten MENU</span></div> <i class="fa fa-chevron-down"></i>
			</button>
			<div class="collapse" id="mobile-xten-navigation">
		<?php
	endif;
	?>
		<div class="xten-header-inner">
			<nav class="xten-header-nav">
				<?php if ( 'standard_intranet_header' === $standard_header_selection ) : ?>
					<a class="xten-header-item" href="http://xtenline.xxhipowerxx.github.io/xten/main/" target="_blank" title="XTen Website">XTenline</a>
				<?php else : ?>
					<a class="xten-header-item" href="http://xxhipowerxx.github.io/xten" target="_blank" title="XTen Website">xten Home</a>
				<?php endif; ?>
				<a class="xten-header-item" href="http://xxhipowerxx.github.io/xten/cao-vision/Home.aspx" target="_blank" title="XTenwide Vision">Vision</a>
				<a class="xten-header-item" href="http://xxhipowerxx.github.io/xten/main/Pages/visiting.aspx" target="_blank" title="Visiting XTen">Visiting</a>
				<a class="xten-header-item" href="http://xxhipowerxx.github.io/xten/main/Pages/living.aspx" target="_blank" title="Living in XTen">Living</a>
				<a class="xten-header-item" href="http://xxhipowerxx.github.io/xten/main/Pages/working.aspx" target="_blank" title="Working in XTen">Working</a>
				<a class="xten-header-item" href="http://xxhipowerxx.github.io/xten/main/Pages/Services.aspx" target="_blank" title="Services A-Z">Services A-Z</a>
				<a class="xten-header-item" href="http://xxhipowerxx.github.io/xten/main/Pages/departments.aspx" target="_blank" title="XTen Contact Directory">Directory</a>
				<a class="xten-header-item" href="https://service.govdelivery.com/accounts/CASANBE/subscriber/new?preferences=true" target="_blank" title="E-Subscriptions">E-Subscriptions</a>
				<?php
				if ( ! $is_mobile_gobal_nav ) :
				?>
					<div class="xten-header-item xten-header-translate desktop-translate">
						<div id='google_translate_element'></div>
					</div>
				<?php
				endif; // end XTen Collapse
				?>

			</nav>
		</div>
	<?php
	if ( $is_mobile_gobal_nav ) :
	?>
		</div>
	<?php
	endif; // end XTen Collapse
	?>
</div>

<?php wp_enqueue_script( 'xten-header-js' ); ?>
<?php
