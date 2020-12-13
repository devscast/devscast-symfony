export const createLoader = () => {
    const loader = document.createElement('div');
    loader.classList.add('app-loader');
    loader.innerHTML = '<div class="spin"></div>';
    document.body.appendChild(loader)
};

/**
 * @param {HTMLElement} element
 * @param {number} speed
 */
export const removeFadeOut = (element, speed = 300) => {
    const seconds = speed / 1000;
    element.style.transition = `opacity ${seconds}s ease`;
    element.style.opacity = 0;
    setTimeout(() => element.parentNode.removeChild(element), speed);
}

/**
 * @param {HTMLElement} element
 * @param {string} loadingText
 */
export const createSectionLoader = (element, loadingText = 'chargement...') => {
    const loader = document.createElement('div');
    loader.innerHTML = `
        <div class="text-center">
           <div class="spinner-border text-primary"></div>
           <div>${loadingText}</div>
        </div>`
    element.innerHTML = loader;
}

/**
 * @param {HTMLButtonElement} button
 * @param {string} loadingText
 */
export const createButtonLoader = (button, loadingText = 'chargement...') => {
    button.setAttribute('disabled', 'disabled')
    button.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        ${loadingText}
    `
}

/**
 * le formulaire présent dans la boite modal vient du backend
 * le comportement javascript n'y est donc pas attaché, cette fonction permet
 * de rattacher les différent comportement.
 * @param {HTMLFormElement} form
 */
export const bindFormPlugins = (form) => {
    const search = form.querySelectorAll("input[data-autocomplete]");
    const datepicker = form.querySelectorAll("input.datepicker");
    const places = form.querySelectorAll('input[data-places]');

    if (search.length > 0) {
        import('../modules/Autocomplete')
            .then(m => (new m.default(search)))
            .catch(e => console.error({e}))
    }

    if (datepicker.length > 0) {
        import('../modules/Datepicker')
            .then(m => (new m.default(datepicker)))
            .catch(e => console.error({e}))
    }

    if (places.length > 0) {
        import('../modules/Map')
            .then(module => (new module.default().places(places)))
            .catch(e => console.error({e}))
    }
}

/**
 * @param {HTMLButtonElement} button
 * @param {string} text
 */
export const removeButtonLoader = (button, text) => {
    button.removeAttribute('disabled')
    button.innerHTML = text
}

export const removeLoader = () => {
    const loader = document.querySelector('.app-loader');
    document.body.removeChild(loader);
}

/**
 * @param {HTMLInputElement} elements
 */
export const enableInput = (...elements) => {
    elements.forEach(element => {
        element.removeAttribute('disabled')
        element.setAttribute('required', 'required')
    })
}

/**
 * @param {HTMLInputElement} elements
 */
export const disableInput = (...elements) => {
    elements.forEach(element => {
        element.setAttribute('disabled', 'disabled')
        element.removeAttribute('required')
    })
}
