/**
 * @param {HTMLElement} element
 */
export const createLoader = () => {
    const loader = document.createElement('div');
    loader.classList.add('app-loader');
    loader.innerHTML = '<div class="spin"></div>';
    document.body.appendChild(loader)
};

export const removeLoader = () => {
    const loader = document.querySelector('.app-loader');
    document.body.removeChild(loader);
}

export const enableInput = (...elements) => {
    elements.forEach(element => {
        element.removeAttr('disabled')
        element.attr('required', 'required')
    })
}

export const disableInput = (...elements) => {
    elements.forEach(element => {
        element.attr('disabled', 'disabled')
        element.removeAttr('required')
    })
}
