/* globals wp */
wp.domReady(() => {
  /**
   * Block blacklist.
   */
  const restrictedBlocks = [
    'core/archives',
    // 'core/audio',
    'core/buttons',
    'core/calendar',
    'core/categories',
    // 'core/classic',
    // 'core/code',
    'core/columns',
    'core/cover',
    // 'core/embed',
    // 'core/file',
    // 'core/gallery',
    'core/group',
    // 'core/heading',
    // 'core/html',
    // 'core/image',
    'core/latest-comments',
    'core/latest-posts',
    'core/loginout',
    // 'core/list',
    'core/media-text',
    'core/more',
    'core/navigation',
    'core/nextpage',
    'core/page-list',
    // 'core/paragraph',
    'core/post-author',
    'core/post-comments',
    'core/post-content',
    'core/post-date',
    'core/post-excerpt',
    'core/post-featured-image',
    'core/post-navigation-link',
    'core/post-terms',
    'core/post-title',
    'core/preformatted',
    'core/pullquote',
    'core/query',
    'core/query-title',
    // 'core/quote',
    'core/rss',
    'core/search',
    // 'core/separator',
    // 'core/shortcode',
    'core/site-logo',
    'core/site-tagline',
    'core/site-title',
    'core/social-links',
    // 'core/spacer',
    // 'core/table',
    'core/tag-cloud',
    'core/template-part',
    'core/term-description',
    'core/text-columns',
    'core/verse',
    // 'core/video'
  ]

  /**
   * Remove blocks included in blacklist.
   */
  for (let i = 0, len = restrictedBlocks.length; i < len; i++) {
    wp.blocks.unregisterBlockType(restrictedBlocks[i])
  };

  /**
   * List whitelisted embed variations.
   */
  const allowedEmbedBlocks = [
    'spotify','twitter','vimeo','youtube'
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
