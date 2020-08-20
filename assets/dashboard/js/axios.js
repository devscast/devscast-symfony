// Axios setup
import axios from 'axios';

const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
window.axios = axios;
window.axios.defaults = {
    timeout: 2500,
    headers: {
        common: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    }
}

if (csrf_token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf_token;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

export default window.axios;
