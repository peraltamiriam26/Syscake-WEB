/*
require('./bootstrap');
import '../css/app.css'; 
import "flyonui/flyonui";

window.addEventListener('load', () => {
    // Destroy and reinit variables
    const togglesPassword = document.querySelectorAll('#toggle-password-to-destroy [data-toggle-password]')
    const destroyBtn = document.querySelector('#destroy-btn')
    const reinitBtn = document.querySelector('#reinit-btn')

    destroyBtn.addEventListener('click', () => {
      togglesPassword.forEach(el => {
        const { element } = HSTogglePassword.getInstance(el, true)

        element.destroy()
      })

      destroyBtn.setAttribute('disabled', 'disabled')
      reinitBtn.removeAttribute('disabled')
    })

    reinitBtn.addEventListener('click', () => {
      HSTogglePassword.autoInit()

      reinitBtn.setAttribute('disabled', 'disabled')
      destroyBtn.removeAttribute('disabled')
    })
  })*/