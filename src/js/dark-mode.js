// Dark mode
const btn = document.querySelector('#btn-toggle')
const currentTheme = localStorage.getItem('theme')
const svg_light = '<svg fill="var(--theme-text-color)" width="32" height="26" aria-label="Light mode" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M18 27h-4a2 2 0 0 1-2-2v-3.84a10 10 0 0 1-6-9.47A10.14 10.14 0 0 1 15.69 2 10 10 0 0 1 26 12a10 10 0 0 1-6 9.16V25a2 2 0 0 1-2 2ZM15.75 4A8.12 8.12 0 0 0 8 11.75a8 8 0 0 0 5.33 7.79 1 1 0 0 1 .67.94V25h4v-4.52a1 1 0 0 1 .67-.94A8 8 0 0 0 15.75 4Z"/><path d="M15 24v-4.52a9 9 0 0 1-6-8.76c.09-3 1.71-4.93 4.52-6.32C9.49 4.47 7.12 8 7 11.72a9 9 0 0 0 6 8.76V25a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1h-3a1 1 0 0 1-1-1Zm4 6h-6a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2Z"/><path d="M20.85 11.47A1 1 0 0 0 20 11h-1.13l1-1.45a1 1 0 0 0 .05-1A1 1 0 0 0 19 8h-4a1 1 0 0 0-.89.55l-3 6A1 1 0 0 0 12 16h3v4a1 1 0 0 0 .77 1 .91.91 0 0 0 .23 0 1 1 0 0 0 .89-.55l4-8a1 1 0 0 0-.04-.98ZM5 6a1 1 0 0 1-.71-.29l-2-2a1 1 0 0 1 1.42-1.42l2 2a1 1 0 0 1 0 1.42A1 1 0 0 1 5 6Zm-1 7H3a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2Zm-1 8a1 1 0 0 1-.71-.29 1 1 0 0 1 0-1.42l2-2a1 1 0 0 1 1.42 1.42l-2 2A1 1 0 0 1 3 21ZM27 6a1 1 0 0 1-.71-.29 1 1 0 0 1 0-1.42l2-2a1 1 0 1 1 1.42 1.42l-2 2A1 1 0 0 1 27 6Zm2 7h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2Zm0 8a1 1 0 0 1-.71-.29l-2-2a1 1 0 0 1 1.42-1.42l2 2a1 1 0 0 1 0 1.42A1 1 0 0 1 29 21Z"/></svg>'
const svg_dark = '<svg fill="var(--theme-text-color)" width="32" height="26" aria-label="Dark mode" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M18 27h-4a2 2 0 0 1-2-2v-3.84a10 10 0 0 1-6-9.47A10.14 10.14 0 0 1 15.69 2 10 10 0 0 1 20 21.16V25a2 2 0 0 1-2 2ZM15.75 4A8.12 8.12 0 0 0 8 11.75a8 8 0 0 0 5.33 7.79 1 1 0 0 1 .67.94V25h4v-4.52a1 1 0 0 1 .67-.94 8 8 0 0 0 2.9-13.28A7.85 7.85 0 0 0 15.75 4ZM19 30h-6a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2Z"/><path d="M15 24v-4.52a9 9 0 0 1-6-8.76c.09-3 1.71-4.93 4.52-6.32C9.49 4.47 7.12 8 7 11.72a9 9 0 0 0 6 8.76V25a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1h-3a1 1 0 0 1-1-1Z"/></svg>'

document.body.classList.add('dark-theme')
btn.innerHTML = svg_light
btn.title = 'Light mode'

if (currentTheme === 'light') {
  document.body.classList.remove('dark-theme')
  btn.innerHTML = svg_dark
  btn.title = 'Dark mode'
}

btn.addEventListener('click', function (e) {
  e.preventDefault()

  document.body.classList.toggle('dark-theme')
  let theme = 'light'
  btn.innerHTML = svg_dark
  btn.title = 'Dark mode'

  if (document.body.classList.contains('dark-theme')) {
    theme = 'dark'
    btn.innerHTML = svg_light
    btn.title = 'Light mode'
  }

  localStorage.setItem('theme', theme)
})
