import autoComplete from "@tarekraafat/autocomplete.js/src/models/autoComplete"
import axios from "../axios"

export default class Autocomplete {
    constructor(inputs) {
        inputs.forEach(input => {
            const url = input.getAttribute('data-url');
            new autoComplete({
                data: {
                    src: async () => {
                        if (input.value.length >= 3) {
                            const response = await axios.get(`${url}${encodeURI(input.value)}`)
                            return response.data.results;
                        }
                    },
                    key: ["text"],
                    cache: false
                },
                selector: '[data-autocomplete]',
                threshold: 3,
                debounce: 500,
                searchEngine: "strict",
                maxResults: 15,
                highlight: false,
                resultsList: {
                    render: true,
                    container: source => {
                        source.style.display = 'block';
                        source.setAttribute("class", "tt-menu")
                    },
                    element: "div"
                },
                resultItem: {
                    content: (data, source) => {
                        source.setAttribute('class', 'tt-suggestion')
                        source.innerHTML = data.match
                    },
                    element: "div"
                },
                noResults: () => {
                    const result = document.createElement("div")
                    result.setAttribute("class", "tt-suggestion")
                    result.setAttribute("tabindex", "1")
                    result.innerHTML = "Aucun Résultat"
                    document.querySelector(".tt-menu").appendChild(result)
                },
                onSelection: feedback => {
                    input.blur()
                    input.value = feedback.selection.value.id
                }
            });
        })
    }
}
