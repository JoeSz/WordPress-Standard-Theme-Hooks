<?php wp_doctype(); ?><html>
<head>
	<?php wp_head_top(); ?>
	<title><?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); 	?>" type="text/css" media="all" />
	<?php wp_head_bottom(); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_top(); ?>
	<?php wp_header_before(); ?>
	<div id="header">
		<?php wp_header_top(); ?>
		<h1><?php bloginfo( 'name' ); ?></h1>
		<p class="dscription"><?php bloginfo( 'description' ); ?></p>
		<?php wp_header_bottom(); ?>
	</div><!-- #header -->
	<?php wp_header_after(); ?>

	<?php wp_content_before(); ?>
	<div id="content">
		<?php wp_content_top(); ?>

		<!-- This roughly encapsulates The Loop portion of the layout -->
		<?php if ( have_posts() ) : ?>

			<?php wp_loop_before(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wp_post_before(); ?>
				<!-- Post Entry Begin -->
				<article <?php post_class( 'entry' ); ?>>
					<?php wp_post_top(); ?>
					<header>
						<h2><?php the_title(); ?></h2>
					</header>
					<?php wp_post_header_after(); ?>
					<div class="itemtext">
						<?php wp_post_content_before(); ?>
						<?php the_content(); ?>
						<?php wp_post_content_after(); ?>
					</div><!-- .itemtext -->
					<?php wp_post_footer_before(); ?>
					<footer>
					</footer>
					<?php wp_post_bottom(); ?>
				</article>
				<!-- Post Entry End -->
				<?php wp_post_after(); ?>

			<?php endwhile; ?>

			<?php wp_loop_after(); ?>

		<?php endif; ?>
		<!-- Close The Loop -->

		<?php wp_comments_before(); ?>
		<!-- Post Comments Begin -->
		<?php comments_template(); ?>
		<!-- post Comments End -->
		<?php wp_comments_after(); ?>

		<?php wp_content_bottom(); ?>
	</div><!-- #content -->
	<?php wp_content_after(); ?>

	<?php wp_sidebars_before(); ?>
	<div id="sidebar">
		<?php wp_sidebar_top(); ?>
		<?php dynamic_sidebar( 'sidebar' ); ?>
		<?php wp_sidebar_bottom(); ?>
	</div><!-- #sidebar-->
	<?php wp_sidebars_after(); ?>

	<?php wp_footer_before(); ?>
	<div id="footer">
		<?php wp_footer_top(); ?>

		<h3>Footer</h3>
		<p>This is some sample footer text.</p>

		<?php wp_footer_bottom(); ?>
	</div><!-- #footer -->
	<?php wp_footer_after(); ?>
	<?php wp_body_bottom(); ?>
	<?php wp_footer(); ?>
</body>
</html>
