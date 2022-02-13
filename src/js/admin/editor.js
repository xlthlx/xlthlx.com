/* globals wp */
wp.domReady(() => {
  /**
   * Manage block registration.
   */
  const restrictedBlocks = [
    'core/archives',
    //'core/audio',
    'core/button',
    'core/buttons',
    'core/calendar',
    'core/categories',
    // 'core/classic',
    // 'core/code',
    'core/column',
    'core/columns',
    'core/cover',
    // 'core/embed',
    // 'core/file',
    'core/freeform',
    // 'core/gallery',
    'core/group',
    // 'core/heading',
    // 'core/html',
    // 'core/image',
    // 'core/legacy-widget',
    'core/latest-comments',
    'core/latest-posts',
    'core/loginout',
    // 'core/list',
    'core/media-text',
    'core/missing',
    'core/more',
    'core/navigation',
    'core/navigation-link',
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
    'core/social-link',
    'core/social-links',
    // 'core/spacer',
    // 'core/subhead',
    // 'core/table',
    'core/tag-cloud',
    'core/term-description',
    'core/text-columns',
    'core/verse',
    // 'core/video',
    // 'core/widget-area'
  ]

  /**
   * Remove blocks included in blacklist.
   */
  for (let i = 0, len = restrictedBlocks.length; i < len; i++) {
    wp.blocks.unregisterBlockType(restrictedBlocks[i])
  };

  /**
   * Manage embed variations.
   */
  const allowedEmbedBlocks = [
    'youtube'
  ]

  /**
   * Unregister blocks not included in whitelist.
   */
  wp.blocks.getBlockVariations('core/embed').forEach(function (blockVariation) {
    if (allowedEmbedBlocks.indexOf(blockVariation.name) === -1) {
      wp.blocks.unregisterBlockVariation('core/embed', blockVariation.name)
    }
  })

  /**
   * Manage block style variations.
   */
  wp.blocks.registerBlockStyle('core/heading', {
    name: 'heading-underline',
    label: 'With underline',
    isDefault: false
  })

  //wp.blocks.unregisterBlockStyle('core/image', ['rounded'])
  //wp.blocks.unregisterBlockStyle('core/quote', ['large'])
  //wp.blocks.unregisterBlockStyle('core/table', ['stripes'])
})
