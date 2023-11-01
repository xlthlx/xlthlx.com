/**
 * Register all the block variations.
 */
wp.domReady(() => {

  /**
   * SWF Player.
   */
  wp.blocks.registerBlockVariation(
    'core/file',
    {
      name: 'xlt/swf-player',
      title: 'SWF Player',
      description: 'Player for ShockWave Flash animations',
      category: 'media',
      icon: 'controls-play',
      isDefault: false,
      example: '',
      namespace: 'xlt/swf-player',
      isActive: [ 'displayPreview', 'showDownloadButton' ],
      attributes: {
        displayPreview: false,
        showDownloadButton: false,
      },
    },
  );

});
