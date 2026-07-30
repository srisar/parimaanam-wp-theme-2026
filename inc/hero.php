<?php
/**
 * Homepage hero slot resolution.
 *
 * Lives here rather than in the pattern because patterns are included on
 * every render, and a bare function declaration in one would fatal the second
 * time it ran.
 *
 * @package Parimaanam_2026
 */

/**
 * The sticky posts eligible to be featured, newest first.
 *
 * Only the first three matter — the hero has three slots — so the rest are
 * dropped here rather than being carried through the arithmetic below.
 *
 * @return int[] Post IDs, at most three.
 */
function parimaanam_2026_hero_featured_ids() {
	$parimaanam_sticky = array_map( 'intval', (array) get_option( 'sticky_posts' ) );

	return array_slice( array_filter( $parimaanam_sticky ), 0, 3 );
}

/**
 * Query attributes for one featured slot, as a JSON string for block markup.
 *
 * Core cannot restrict a Query block to given post IDs: the `include` key it
 * accepts belongs to `taxQuery`, and `post__in` is set only by `sticky` set to
 * `only`. Position is therefore the only lever available, so each slot is
 * addressed by counting.
 *
 * The first `$featured` slots count through the sticky posts. The rest count
 * through the non-sticky posts from the top, which is what fills a slot the
 * editor has not chosen and keeps the hero from rendering a hole.
 *
 * @param int $index    Slot position, 0 to 2.
 * @param int $featured How many sticky posts are being featured.
 * @return string JSON encoded query attributes.
 */
function parimaanam_2026_hero_slot_query( $index, $featured ) {
	$parimaanam_query = array(
		'perPage'  => 1,
		'pages'    => 0,
		'postType' => 'post',
		'order'    => 'desc',
		'orderBy'  => 'date',
		'inherit'  => false,
	);

	if ( $index < $featured ) {
		$parimaanam_query['sticky'] = 'only';
		$parimaanam_query['offset'] = $index;
	} else {
		$parimaanam_query['sticky'] = 'exclude';
		$parimaanam_query['offset'] = $index - $featured;
	}

	return wp_json_encode( $parimaanam_query );
}

/**
 * Query attributes for the recent row beneath the featured slots.
 *
 * `offset` steps over exactly the posts the filler slots consumed, so nothing
 * appears twice on the page.
 *
 * `sticky` is `ignore` rather than `exclude` deliberately. `exclude` bars every
 * sticky post from the row, so an editor who marked five would find the fourth
 * and fifth gone from the homepage altogether. `ignore` only stops them being
 * hoisted, and `exclude` below removes the three already featured above.
 *
 * @param int[] $featured_ids The featured post IDs.
 * @return string JSON encoded query attributes.
 */
function parimaanam_2026_hero_recent_query( $featured_ids ) {
	return wp_json_encode(
		array(
			'perPage'  => 3,
			'pages'    => 0,
			'offset'   => max( 0, 3 - count( $featured_ids ) ),
			'postType' => 'post',
			'order'    => 'desc',
			'orderBy'  => 'date',
			'sticky'   => 'ignore',
			'exclude'  => $featured_ids,
			'inherit'  => false,
		)
	);
}
