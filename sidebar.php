<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

<div id="sidebar">
<?php if ( !function_exists('register_sidebar')
        || !dynamic_sidebar() ) : ?>
 <div class="title">About</div>
 <p>This is my blog.</p>
 <div class="title">Links</div>
 <ul>
  <li><a href="http://example.com">Example</a></li>
 </ul>
<?php endif; ?>
</div>