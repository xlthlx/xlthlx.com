// Ruffle configuration.
window.RufflePlayer = window.RufflePlayer || {}
window.RufflePlayer.config = {
  'allowScriptAccess': true,
  'autoplay': 'off',
  'wmode': 'transparent',
  'letterbox': 'off',
  'warnOnUnsupportedContent': false,
  'scale': 'noborder',
  'quality': 'best',
  'splashScreen': false,
  'openUrlMode': 'confirm',
}
window.addEventListener('load', () => {
  const ruffle = window.RufflePlayer.newest()
  const player = ruffle.createPlayer()
  const container = document.getElementById(player_id)
  container.appendChild(player)

  player.load(player_file)
})