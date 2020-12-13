import $ from 'jquery'
import axios from '../axios'
import {bindFormPlugins, createButtonLoader, removeButtonLoader, removeFadeOut} from "../functions/dom";

export default class Content {

    handleSubmit = (button) => {
        const url = button.getAttribute('data-url')
        const $modal = $(button.getAttribute('data-target'))
        const $modalContent = $modal.find('.modal-body')

        const handleSubmitRequest = ($modalContent, $modal, url) => {
            const form = $modalContent.find('form')[0]
            const submitButton = $modalContent.find('button[type="submit"]')[0]
            bindFormPlugins(form);

            submitButton.addEventListener('click', async (e) => {
                try {
                    e.preventDefault()
                    createButtonLoader(submitButton)
                    const response = await axios.post(url, new FormData(form))

                    if (response.status === 201 || response.status === 202) {
                        $modal.modal('hide')
                        $modal.modal('dispose')
                        window.location.reload()
                        return;
                    }

                    $modal.modal('handleUpdate')
                    $modalContent.html(response.data.html)
                    handleSubmitRequest($modalContent);
                } catch (e) {
                    console.error("Erreur lors de la création/édition =>", {e})
                    removeButtonLoader(submitButton, 'Envoyer')
                }
            })
        }

        $modal.on('shown.bs.modal', async () => {
            const response = await axios.get(url)
            $modalContent.html(response.data.html)
            handleSubmitRequest($modalContent, $modal, url)
        })
    }

    init = (buttons) => buttons.forEach(button => this.handleSubmit(button))

    delete(buttons) {
        buttons.forEach(button => {
            const [url, _token] = [
                button.getAttribute('data-url'),
                button.getAttribute('data-token')
            ];

            button.addEventListener('click', async () => {
                let confirm = window.confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');

                if (confirm) {
                    createButtonLoader(button, '')
                    try {
                        const response = await axios.delete(url, {data: {_token}})
                        response.status === 202 ?
                            removeFadeOut(button.closest('tr')) :
                            removeButtonLoader(button, 'D')
                    } catch (e) {
                        console.error("Erreur lors de la suppression =>", {e});
                        removeButtonLoader(button, 'D')
                    }
                }
            })
        });
    }
}
