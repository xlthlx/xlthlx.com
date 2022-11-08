/* globals wp */
wp.domReady(() => {
	/**
	 * Block blacklist.
	 */
	const restrictedBlocks = [
		// 'core/paragraph',
		// 'core/image',
		// 'core/heading',
		// 'core/gallery',
		// 'core/list',
		// 'core/list-item',
		// 'core/quote',
		'core/archives',
		// 'core/audio',
		'core/button',
		'core/buttons',
		'core/calendar',
		'core/categories',
		// 'core/freeform',
		// 'core/code',
		'core/column',
		'core/columns',
		'core/cover',
		// 'core/embed',
		// 'core/file',
		// 'core/group',
		// 'core/html',
		'core/latest-comments',
		'core/latest-posts',
		'core/media-text',
		'core/missing',
		'core/more',
		'core/nextpage',
		'core/page-list',
		'core/pattern',
		// 'core/preformatted',
		// 'core/pullquote',
		'core/block',
		'core/rss',
		'core/search',
		// 'core/separator',
		// 'core/shortcode',
		'core/social-link',
		'core/social-links',
		// 'core/spacer',
		// 'core/table',
		'core/tag-cloud',
		'core/text-columns',
		'core/verse',
		// 'core/video',
		'core/navigation',
		'core/navigation-link',
		'core/navigation-submenu',
		'core/site-logo',
		'core/site-title',
		'core/site-tagline',
		'core/query',
		'core/template-part',
		'core/avatar',
		'core/post-title',
		'core/post-excerpt',
		'core/post-featured-image',
		'core/post-content',
		'core/post-author',
		'core/post-date',
		'core/post-terms',
		'core/post-navigation-link',
		'core/post-template',
		'core/query-pagination',
		'core/query-pagination-next',
		'core/query-pagination-numbers',
		'core/query-pagination-previous',
		'core/query-no-results',
		'core/read-more',
		'core/comments',
		'core/comment-author-name',
		'core/comment-content',
		'core/comment-date',
		'core/comment-edit-link',
		'core/comment-reply-link',
		'core/comment-template',
		'core/comments-title',
		'core/comments-pagination',
		'core/comments-pagination-next',
		'core/comments-pagination-numbers',
		'core/comments-pagination-previous',
		'core/post-comments-form',
		'core/home-link',
		'core/loginout',
		'core/term-description',
		'core/query-title',
		'core/post-author-biography',
	]

	/**
	 * Remove blocks included in blacklist.
	 */
	for (let i = 0, len = restrictedBlocks.length; i < len; i++) {
		wp.blocks.unregisterBlockType(restrictedBlocks[i])
	}
	;

	/**
	 * List whitelisted embed variations.
	 */
	const allowedEmbedBlocks = [
		'spotify', 'twitter', 'vimeo', 'youtube'
	]

	/**
	 * Unregister variation of embed blocks.
	 */
	wp.blocks.getBlockVariations('core/embed').forEach(function (blockVariation) {
		if (allowedEmbedBlocks.indexOf(blockVariation.name) === -1) {
			wp.blocks.unregisterBlockVariation('core/embed', blockVariation.name)
		}
	})

})
