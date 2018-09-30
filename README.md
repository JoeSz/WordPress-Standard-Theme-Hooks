# WordPress Standard Theme Hooks

## Why you should use standard hooks? ##
> https://codex.wordpress.org/User_talk:Dcole07<br/>
* It makes it easier for plugin authors to insert features a wide variety of themes.
* Users will not need to dig through your code and insert function calls.
* Makes tutorials universal
* Without this solution, more themes will develop their own theme options,
when a common group plugins would work better.

## What? ##
Child theme authors and plugin developers need a consistent set of entry points to allow for easy customization and altering of functionality. Core WordPress offers a suite of [action hooks](http://codex.wordpress.org/Plugin_API/Action_Reference/) and [template tags](http://codex.wordpress.org/Template_tags) but does not cover many of the common use cases. The WordPress Standard Theme Hooks is born from multiple standardization projects.

I have combined the THA, Standard Hooks for Themes and WP Theme Standardization Panel hooks with the original WordPress Standard Template Hooks.

> "There shouldn't be multiple standards since that would be against its general purpose."

I agree, but the main goal here, theme developer start to use some kind of standardized hooks. Will see which wins :)

## How? ##
This could be solved more "elegant" or "clever" way, like in WP Theme Standardization Panel,
but according to WordPress Codex:
> In general, readability is more important than cleverness or brevity.<br/>
https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/#clever-code

## Which? ##

* Standard Template Hooks stub list.<br/>
_(based on the original WordPress Standard Template Hooks idea)<br/>_
https://core.trac.wordpress.org/ticket/21506<br/>
https://core.trac.wordpress.org/attachment/ticket/21506/general-template.php.template-hooks.patch

* [Theme Hook Alliance](https://github.com/zamoose/themehookalliance) hook stub list.<br/>
Theme Hook Alliance is a community-driven effort to agree on a set of third-party action hooks that THA themes pledge to implement in order to give that desired consistency.

* [WP Theme Standardization Panel](https://github.com/felixarntz/wp-theme-standardization-panel/) hook stub list.<br/>

* Standard Hooks for Themes<br/>
https://codex.wordpress.org/User_talk:Dcole07

## What about WordPress? ##
> As stated above, there have been attempts to have something along these lines added to WordPress Core in the past and, while they have generally been seen as good ideas, they have remained as such.

> Maintaining the guidelines of the WP Theme Standardization Panel, WordPress theme developers apply a unified
way of using action hooks in their theme. As soon as plugin developers start implementing the use of these
hooks, the WordPress infrastructure will be vastly improved because any plugin content can be added exactly
where it needs to be inserted, without using filters (which should actually only be used for modifying existing
content) or (even worse) output buffers.<br/>
https://github.com/felixarntz/wp-theme-standardization-panel/blob/master/wp_tsp.php

### When Core does it, Core wins ###
A small note: none of the proposed theme hooks are intended to replace or rewrite existing WordPress functionality. So, for instance, if a desired result can be obtained by filtering the output of e.g. `the_content()`, there is no need to create an entirely new hook. Therefore, any functions that duplicate work Core performs already should be rejected immediately.

## Conventions ##

Hooks should be suffixed based upon their placement within a block.
* Hooks immediately *preceding* a block should use `_before`.
* Hooks immediately *following* a block should use `_after`.
* Hooks placed at the very *beginning* of a block should use `_top`.
* Hooks placed at the very *end* of a block should use `_bottom`.


## Usage ##

1. Copy `wp-standard-template-hooks.php` to a directory inside of your theme; say, `include/`, for instance.
2. Include `wp-standard-template-hooks.php` via `<?php include( 'include/wp-standard-template-hooks.php' ); ?>` in your `functions.php` or similar.
3. Using `wp-standard-template-hooks-example-index.php` as a guide, *be sure to implement all of the hooks described in `wp-standard-template-hooks.php` in order to offer full compatibility*.
4. Check if the desired hook name you want to add your content to is part of this array. If so, you can use the WordPress Core function `add_action( $hook, $function_to_add, $priority, $accepted_args )`.

