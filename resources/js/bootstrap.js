import axios from 'axios';
window.axios = axios;

// Header padrão para indicar requisição AJAX
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Dynamic token da sessão armazenado no localStorage
const dynamicToken = localStorage.getItem('dynamic_token');
if (dynamicToken) {
    window.axios.defaults.headers.common['X-Dynamic-Session-Token'] = dynamicToken;
}
