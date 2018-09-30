<?php

/**
 * @package  standardtemplatehooks
 * @version  1.0
 * @since    1.0
 * @license  http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

/**
 * Define the version of THA/STANDARD_TEMPLATE_HOOKS support, in case that becomes useful down the road.
 */
define( 'THA_HOOKS_VERSION', '1.0-draft' );
define( 'STANDARD_TEMPLATE_HOOKS_VERSION', '1.0' );

/**
 * Definition of WP_THEME_HOOK_SLUG
 *
 * For a standardized way to hook into functions a constant is used that defines the slug prefix for the hooks.
 */
if( !defined( 'WP_THEME_HOOK_SLUG' ) ) {
	define( 'WP_THEME_HOOK_SLUG', get_template() );
}

/**
 * Themes and Plugins can check for
 * - tha_hooks using current_theme_supports( 'tha_hooks', $hook )
 * - standard_template_hooks using current_theme_supports( 'standard_template_hooks', $hook )
 * to determine whether a theme declares itself to support this specific hook type.
 *
 * Example:
 * <code>
 * 		// Declare support for all hook types
 * 		add_theme_support( 'standard_template_hooks', array( 'all' ) );
 * 		add_theme_support( 'tha_hooks', array( 'all' ) );
 *
 * 		// Declare support for certain hook types only
 * 		add_theme_support( 'standard_template_hooks', array( 'header', 'content', 'footer' ) );
 * 		add_theme_support( 'tha_hooks', array( 'header', 'content', 'footer' ) );
 * </code>
 */
$hooks = array(

	/**
	 * As a Theme developer, use the 'all' parameter, to declare support for all
	 * hook types.
	 * Please make sure you then actually reference all the hooks in this file,
	 * Plugin developers depend on it!
	 */
	'all',

	/**
	 * Themes can also choose to only support certain hook types.
	 * Please make sure you then actually reference all the hooks in this type
	 * family.
	 *
	 * When the 'all' parameter was set, specific hook types do not need to be
	 * added explicitly.
	 */
	'html',
	'body',
	'head',
	'header',
	'content',
	'post',
	'entry',
	'comments',
	'sidebars',
	'sidebar',
	'footer',

	/**
	 * If/when WordPress Core implements similar methodology, Themes and Plugins
	 * will be able to check whether the version of THA/standard_template_hooks supplied by the theme
	 * supports Core hooks.
	 */
	//'core',
);

add_theme_support( 'standard_template_hooks', $hooks );
add_theme_support( 'tha_hooks', $hooks );
add_theme_support( WP_THEME_HOOK_SLUG . '_theme_hooks', array(
	'header',
	'main',
	'loop',
	'article',
	'article_header',
	'article_content',
	'article_footer',
	'comments_section',
	'sidebar',
	'footer',
) );

/**
 * Determines, whether the specific hook type is actually supported.
 *
 * Plugin developers should always check for the support of a <strong>specific</strong>
 * hook type before hooking a callback function to a hook of this type.
 *
 * Example:
 * <code>
 * 		if ( current_theme_supports( 'standard_template_hooks', 'header' ) )
 * 	  		add_action( 'head_top', 'prefix_header_top' );
 * </code>
 *
 * @param bool $bool true
 * @param array $args The hook type being checked
 * @param array $registered All registered hook types
 *
 * @return bool
 */
function standard_template_hooks_current_theme_supports( $bool, $args, $registered ) {
	return in_array( $args[0], $registered[0] ) || in_array( 'all', $registered[0] );
}
add_filter( 'current_theme_supports_standard_template_hooks', 'standard_template_hooks_current_theme_supports', 10, 3 );
add_filter( 'current_theme_supports-tha_hooks', 'standard_template_hooks_current_theme_supports', 10, 3 );

/**
 * Fire the wp_doctype hook
 *
 * Intended to be immediately before HTML <html> tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_doctype' hook.
 *
 * HTML <html> hook
 * Special case, useful for <DOCTYPE>, etc.
 * $tha_supports[] = 'html';
 * $standard_template_hooks_supports[] = 'html;
 */
function wp_doctype() {
	// Original WordPress standard theme hooks without prefix
	// @link https://core.trac.wordpress.org/ticket/21506#comment:62
	do_action( 'doctype' );

	// Original WordPress Hook idea
	do_action( 'wp_doctype' );

	// Standard Hooks for Themes
	// https://codex.wordpress.org/User_talk:Dcole07
	do_action( 'theme_doctype' );

	// WP Theme Standardization Panel Hook
	do_action( WP_THEME_HOOK_SLUG . '_doctype' );

	// Theme Hook Alliance
	do_action( 'tha_html_before' );
}


/**
 * Body releated hooks
 */

/**
 * Fire the wp_body_top hook
 *
 * Intended to be immediately inside opening HTML <body> hook
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_body_top' hook.
 *
 * HTML <body> hooks
 * $tha_supports[] = 'body';
 * $standard_template_hooks_supports[] = 'body';
 */
function wp_body_top() {
	do_action( 'body_top' );
	do_action( 'wp_body_top' );
	do_action( 'theme_body_top' );
	do_action( WP_THEME_HOOK_SLUG . '_body_top' );
	do_action( 'tha_body_top' );
}

/**
 * Fire the wp_body_bottom hook
 *
 * Intended to be immediately inside closing HTML </body> tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_body_bottom' hook.
 */
function wp_body_bottom() {
	do_action( 'body_bottom' );
	do_action( 'wp_body_bottom' );
	do_action( 'theme_body_bottom' );
	do_action( WP_THEME_HOOK_SLUG . '_body_bottom' );
	do_action( 'tha_body_bottom' );
}

/**
 * Head releated hooks
 */

/**
 * Fire the wp_head_top hook
 *
 * Intended to be immediately after opening HTML head container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_head_top' hook.
 *
 * HTML <head> hooks
 * $tha_supports[] = 'head';
 * $standard_template_hooks_supports[] = 'head';
 */
function wp_head_top() {
	do_action( 'head_top' );
	do_action( 'wp_head_top' );
	do_action( 'theme_head' );
	do_action( 'theme_head_top' );
	do_action( WP_THEME_HOOK_SLUG . '_head_top' );
	do_action( 'tha_head_top' );
}

/**
 * Fire the wp_head_bottom hook
 *
 * Intended to be immediately before closing HTML head container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_head_top' hook.
 */
function wp_head_bottom() {
	do_action( 'head_bottom' );
	do_action( 'wp_head_bottom' );
	do_action( 'theme_head_bottom' );
	do_action( WP_THEME_HOOK_SLUG . '_head_bottom' );
	do_action( 'tha_head_bottom' );
}

/**
 * Header releated hooks
 */

/**
 * Fire the wp_header_before hook
 *
 * Intended to be immediately before opening HTML header container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_header_before' hook.
 *
 * Semantic <header> hooks
 * $tha_supports[] = 'header';
 * $standard_template_hooks_supports[] = 'header';
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'header';
 */
function wp_header_before() {
	do_action( 'header_before' );
	do_action( 'wp_header_before' );
	do_action( 'theme_before_header' );
	do_action( WP_THEME_HOOK_SLUG . '_before_header' );
	do_action( 'tha_header_before' );
}

/**
 * Fire the wp_header_top hook
 *
 * Intended to be immediately inside opening HTML header container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_header_top' hook.
 */
function wp_header_top() {
	do_action( 'header_top' );
	do_action( 'wp_header_top' );
	do_action( 'theme_header_top' );
	do_action( WP_THEME_HOOK_SLUG . '_header_top' );
	do_action( 'tha_header_top' );
}

/**
 * Fire the wp_header_bottom hook
 *
 * Intended to be immediately inside closing HTML header container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_header_bottom' hook.
 */
function wp_header_bottom() {
	do_action( 'header_bottom' );
	do_action( 'wp_header_bottom' );
	do_action( 'theme_header_bottom' );
	do_action( WP_THEME_HOOK_SLUG . '_header_bottom' );
	do_action( 'tha_header_bottom' );
}

/**
 * Fire the wp_header_before hook
 *
 * Intended to be immediately after closing HTML header container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_header_before' hook.
 */
function wp_header_after() {
	do_action( 'header_after' );
	do_action( 'wp_header_after' );
	do_action( 'theme_after_header' );
	do_action( WP_THEME_HOOK_SLUG . '_header_after' );
	do_action( WP_THEME_HOOK_SLUG . '_after_header' );
	do_action( 'tha_header_after' );
}

/**
 * Content releated hooks
 */

/**
 * Fire the wp_content_before hook
 *
 * Intended to be immediately before opening HTML main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_content_before' hook.
 *
 * Semantic <content> hooks
 * $tha_supports[] = 'content';
 * $standard_template_hooks_supports[] = 'content';
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'main';
 */
function wp_content_before() {
	do_action( 'content_before' );
	do_action( 'wp_content_before' );
	do_action( 'theme_before_content' );
	do_action( WP_THEME_HOOK_SLUG . '_content_before' );
	do_action( WP_THEME_HOOK_SLUG . '_before_main' );
	do_action( 'tha_content_before' );
}

/**
 * Fire the wp_content_top hook
 *
 * Intended to be immediately inside opening HTML main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_content_top' hook.
 */
function wp_content_top() {
	do_action( 'content_top' );
	do_action( 'wp_content_top' );
	do_action( 'theme_content' );
	do_action( 'theme_content_top' );
	do_action( WP_THEME_HOOK_SLUG . '_content_top' );
	do_action( 'tha_content_top' );
}

/**
 * Fire the wp_content_bottom hook
 *
 * Intended to be immediately inside closing HTML main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_content_bottom' hook.
 */
function wp_content_bottom() {
	do_action( 'content_bottom' );
	do_action( 'wp_content_bottom' );
	do_action( 'theme_content_bottom' );
	do_action( WP_THEME_HOOK_SLUG . '_content_bottom' );
	do_action( 'tha_content_bottom' );
}

/**
 * Fire the wp_content_after hook
 *
 * Intended to be immediately after closing HTML main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_content_after' hook.
 */
function wp_content_after() {
	do_action( 'content_after' );
	do_action( 'wp_content_after' );
	do_action( 'theme_after_content' );
	do_action( WP_THEME_HOOK_SLUG . '_content_after' );
	do_action( WP_THEME_HOOK_SLUG . '_after_main' );
	do_action( 'tha_content_after' );
}

/**
 * Fire the wp_loop_before hook
 *
 * Intended to be immediately before opening HTML loop while tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_loop_before' hook.
 *
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'loop';
 */
function wp_loop_before() {
	do_action( 'loop_before' );
	do_action( 'wp_loop_before' );
	do_action( 'theme_before_loop' );
	do_action( WP_THEME_HOOK_SLUG . '_loop_before' );
	do_action( WP_THEME_HOOK_SLUG . '_before_loop' );
	do_action( 'tha_content_while_before' );
}

/**
 * Fire the wp_loop_after hook
 *
 * Intended to be immediately after closing HTML loop while tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_loop_after' hook.
 */
function wp_loop_after() {
	do_action( 'loop_after' );
	do_action( 'wp_loop_after' );
	do_action( 'theme_after_loop' );
	do_action( WP_THEME_HOOK_SLUG . '_loop_after' );
	do_action( WP_THEME_HOOK_SLUG . '_after_loop' );
	do_action( 'tha_content_while_after' );
}

/**
 * Post releated hooks
 */

/**
 * Fire the wp_post_before hook
 *
 * Intended to be immediately before opening HTML post container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_before' hook.
 *
 * Semantic <entry> hooks
 * $tha_supports[] = 'entry';
 * $standard_template_hooks_supports[] = 'post';
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'article';
 */
function wp_post_before() {
	do_action( 'post_before' );
	do_action( 'wp_post_before' );
	do_action( 'theme_before_entry' );
	do_action( WP_THEME_HOOK_SLUG . '_post_before' );
	do_action( WP_THEME_HOOK_SLUG . '_before_article' );
	do_action( 'tha_entry_before' );
}

/**
 * Fire the wp_post_top hook
 *
 * Intended to be immediately inside opening HTML post container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_top' hook.
 *
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'article_header';
 */
function wp_post_top() {
	do_action( 'post_top' );
	do_action( 'wp_post_top' );
	do_action( 'theme_post_top' );
	do_action( WP_THEME_HOOK_SLUG . '_post_top' );
	do_action( WP_THEME_HOOK_SLUG . '_before_article_header' );
	do_action( 'tha_entry_top' );
}

/**
 * Fire the wp_post_top hook
 *
 * Intended to be immediately after closing HTML post header container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_top' hook.
 */
function wp_post_header_after() {
	do_action( 'post_header_after' );
	do_action( 'wp_post_header_after' );
	do_action( 'theme_after_post_header' );
	do_action( WP_THEME_HOOK_SLUG . '_post_header_after' );
	do_action( WP_THEME_HOOK_SLUG . '_after_article_header' );
}

/**
 * Fire the wp_post_content_before hook
 *
 * Intended to be immediately before opening HTML post main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_content_before' hook.
 *
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'article_content';
 */
function wp_post_content_before() {
	do_action( 'post_content_before' );
	do_action( 'wp_post_content_before' );
	do_action( 'theme_before_post_content' );
	do_action( WP_THEME_HOOK_SLUG . '_post_content_before' );
	do_action( WP_THEME_HOOK_SLUG . '_before_article_content' );
	do_action( 'tha_entry_content_before' );
}

/**
 * Fire the wp_post_content_after hook
 *
 * Intended to be immediately after closing HTML post main content container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_content_after' hook.
 */
function wp_post_content_after() {
	do_action( 'post_content_after' );
	do_action( 'wp_post_content_after' );
	do_action( 'theme_after_post_content' );
	do_action( WP_THEME_HOOK_SLUG . '_post_content_after' );
	do_action( WP_THEME_HOOK_SLUG . '_after_article_content' );
	do_action( 'tha_entry_content_after' );
}

/**
 * Fire the wp_post_top hook
 *
 * Intended to be immediately before opening HTML post footer container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_top' hook.
 *
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'article_footer';
 */
function wp_post_footer_before() {
	do_action( 'post_footer_before' );
	do_action( 'wp_post_footer_before' );
	do_action( 'theme_before_post_footer' );
	do_action( WP_THEME_HOOK_SLUG . '_post_footer_before' );
	do_action( WP_THEME_HOOK_SLUG . '_before_article_footer' );
}

/**
 * Fire the wp_post_bottom hook
 *
 * Intended to be immediately inside closing HTML post container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_bottom' hook.
 */
function wp_post_bottom() {
	do_action( 'post_bottom' );
	do_action( 'wp_post_bottom' );
	do_action( 'theme_post_bottom' );
	do_action( WP_THEME_HOOK_SLUG . '_post_bottom' );
	do_action( WP_THEME_HOOK_SLUG . '_after_article_footer' );
	do_action( 'tha_entry_bottom' );
}

/**
 * Fire the wp_post_after hook
 *
 * Intended to be immediately after closing HTML post container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_post_after' hook.
 */
function wp_post_after() {
	do_action( 'post_after' );
	do_action( 'wp_post_after' );
	do_action( 'theme_after_post' );
	do_action( WP_THEME_HOOK_SLUG . '_post_after' );
	do_action( WP_THEME_HOOK_SLUG . '_after_article' );
	do_action( 'tha_entry_after' );
}

/**
 * Comments releated hooks
 */

/**
 * Fire the wp_comments_before hook
 *
 * Intended to be immediately before the comments template
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_comments_before' hook.
 *
 * Comments block hooks
 * $tha_supports[] = 'comments';
 * $standard_template_hooks_supports[] = 'comments';
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'comments_section';
 */
function wp_comments_before() {
	do_action( 'comments_before' );
	do_action( 'wp_comments_before' );
	do_action( 'theme_before_comments' );
	do_action( WP_THEME_HOOK_SLUG . '_comments_before' );
	do_action( WP_THEME_HOOK_SLUG . '_before_comments_section' );
	do_action( 'tha_comments_before' );
}

/**
 * Fire the wp_comments_after hook
 *
 * Intended to be immediately after the comments template
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_comments_after' hook.
 */
function wp_comments_after() {
	do_action( 'comments_after' );
	do_action( 'wp_comments_after' );
	do_action( 'theme_after_comments' );
	do_action( WP_THEME_HOOK_SLUG . '_comments_after' );
	do_action( WP_THEME_HOOK_SLUG . '_after_comments_section' );
	do_action( 'tha_comments_after' );
}

/**
 * Sidebar releated hooks
 */

/**
 * Fire the wp_sidebar_before hook
 *
 * Intended to be immediately before opening sidebar container tag.
 *
 * This is a semantic template hook intended to apply to an HTML
 * sidebar/column, and not to all dynamic sidebars/widget areas.
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_sidebar_before' hook.
 *
 * Semantic <sidebar> hooks
 * $tha_supports[] = 'sidebar';
 * $standard_template_hooks_supports[] = 'sidebar';
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'sidebar';
 */
function wp_sidebars_before() {
	do_action( 'sidebars_before' );
	do_action( 'wp_sidebars_before' );
	do_action( 'theme_before_sidebars' );
	do_action( WP_THEME_HOOK_SLUG . '_sidebars_before' );
    do_action( WP_THEME_HOOK_SLUG . '_before_sidebar' );
	do_action( 'tha_sidebars_before' );
}

/**
 * Fire the wp_sidebar_top hook
 *
 * Intended to be immediately inside opening sidebar container tag.
 *
 * This is a semantic template hook intended to apply to an HTML
 * sidebar/column, and not to all dynamic sidebars/widget areas.
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_sidebar_top' hook.
 */
function wp_sidebar_top() {
	do_action( 'sidebar_top' );
	do_action( 'wp_sidebar_top' );
	do_action( 'theme_sidebar_top' );
	do_action( WP_THEME_HOOK_SLUG . '_sidebar_top' );
	do_action( 'tha_sidebar_top' );
}

/**
 * Fire the wp_sidebar_bottom hook
 *
 * Intended to be immediately inside closing sidebar container tag.
 *
 * This is a semantic template hook intended to apply to an HTML
 * sidebar/column, and not to all dynamic sidebars/widget areas.
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_sidebar_bottom' hook.
 */
function wp_sidebar_bottom() {
	do_action( 'sidebar_bottom' );
	do_action( 'wp_sidebar_bottom' );
	do_action( 'theme_sidebar_bottom' );
	do_action( WP_THEME_HOOK_SLUG . '_sidebar_bottom' );
	do_action( 'tha_sidebar_bottom' );
}

/**
 * Fire the wp_sidebars_after hook
 *
 * Intended to be immediately after closing sidebar container tag.
 *
 * This is a semantic template hook intended to apply to an HTML
 * sidebar/column, and not to all dynamic sidebars/widget areas.
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_sidebars_after' hook.
 */
function wp_sidebars_after() {
	do_action( 'sidebars_after' );
	do_action( 'wp_sidebars_after' );
	do_action( 'theme_after_sidebars' );
	do_action( WP_THEME_HOOK_SLUG . '_sidebars_after' );
    do_action( WP_THEME_HOOK_SLUG . '_after_sidebar' );
	do_action( 'tha_sidebars_after' );
}

/**
 * Footer releated hooks
 */

/**
 * Fire the wp_footer_before hook
 *
 * Intended to be immediately before opening HTML footer container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_footer_before' hook.
 *
 * Semantic <footer> hooks
 * $tha_supports[] = 'footer';
 * $standard_template_hooks_supports[] = 'footer';
 * ${WP_THEME_HOOK_SLUG . '_theme_hooks_supports'}[] = 'footer';
 */
function wp_footer_before() {
	do_action( 'footer_before' );
	do_action( 'wp_footer_before' );
	do_action( 'theme_before_footer' );
	do_action( WP_THEME_HOOK_SLUG . '_footer_before' );
	do_action( WP_THEME_HOOK_SLUG . '_before_footer' );
	do_action( 'tha_footer_before' );
}

/**
 * Fire the wp_footer_top hook
 *
 * Intended to be immediately inside opening HTML footer container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_footer_top' hook.
 */
function wp_footer_top() {
	do_action( 'footer_top' );
	do_action( 'wp_footer_top' );
	do_action( 'theme_footer' );
	do_action( 'theme_footer_top' );
	do_action( WP_THEME_HOOK_SLUG . '_footer_top' );
	do_action( 'tha_footer_top' );
}

/**
 * Fire the wp_footer_bottom hook
 *
 * Intended to be immediately inside closing HTML footer container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_footer_bottom' hook.
 */
function wp_footer_bottom() {
	do_action( 'footer_bottom' );
	do_action( 'wp_footer_bottom' );
	do_action( 'theme_footer_bottom' );
	do_action( WP_THEME_HOOK_SLUG . '_footer_bottom' );
	do_action( 'tha_footer_bottom' );
}

/**
 * Fire the wp_footer_after hook
 *
 * Intended to be immediately after closing HTML footer container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_footer_after' hook.
 */
function wp_footer_after() {
	do_action( 'footer_after' );
	do_action( 'wp_footer_after' );
	do_action( 'theme_after_footer' );
	do_action( WP_THEME_HOOK_SLUG . '_footer_after' );
	do_action( WP_THEME_HOOK_SLUG . '_after_footer' );
	do_action( 'tha_footer_after' );
}

/**
 * Fire the wp_footer_after hook
 *
 * Intended to be immediately before closing HTML body container tag
 *
 * @since 3.6.0
 * @uses do_action() Calls 'wp_footer_after' hook.
 */
function wp_body_bottom() {
	do_action( 'body_bottom' );
	do_action( 'wp_body_bottom' );
	do_action( 'theme_bottom_body' );
	do_action( WP_THEME_HOOK_SLUG . '_body_bottom' );
	do_action( WP_THEME_HOOK_SLUG . '_bottom_body' );
	do_action( 'tha_body_bottom' );
}
