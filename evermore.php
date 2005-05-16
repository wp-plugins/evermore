<?php
/*
Plugin Name: Evermore
Plugin URI: http://www.thunderguy.com/semicolon/
Description: Make all posts behave as if there is a "&lt;!--more--&gt;" after the first paragraph.
Version: 0.1
Author: Bennett McElwee
Author URI: http://www.thunderguy.com/semicolon/
*/ 

/*	==================================================
	
*/

// Add the "more" link immediately after reading from the database
add_filter('the_posts', 'tguy_em_addmoreall');

/*	Add a "more" link immediately after reading posts from the database.
*/
function tguy_em_addmoreall($posts) {
	$count = count($posts);
	for ($i = 0; $i < $count; ++$i) {
		$posts[$i]->post_content = tguy_em_addmore($posts[$i]->post_content);
	}
	return $posts;
}

/*	Add a "more" comment between the first and second paragraphs, unless
	there is already a "<!--more-->" (we don't add an extra one) or
	a "<!--nevermore-->" (user has disabled evermore for this post).
*/
function tguy_em_addmore($post_content) {
	// Only continue if content has no "more" and no "nevermore"
	if ((false === strpos($post_content, '<!--more-->'))
	&&  (false === strpos($post_content, '<!--nevermore-->'))) {
		// Get the first paragraph including all surrounding whitespace
		 if (preg_match('!^(\s*.*?(?:</(?:p|pre|blockquote|div)>|(?:\r\n|\r|\n){2})\s*)\S!', $post_content, $matches)) {
			$firstPara = $matches[1];
			return $firstPara . '<!--more-->' . substr($post_content, strlen($firstPara));
		}
	}
	return $post_content;
}


/*	==================================================
	Template functions
*/


?>