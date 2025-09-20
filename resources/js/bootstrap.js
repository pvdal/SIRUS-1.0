import axios from 'axios';
window.axios = axios;

// Header padrão para indicar requisição AJAX
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios.defaults.baseURL="http://localhost:8000";

// Captura o tabId exposto na meta tag do html
window.tabId = document.querySelector('meta[name="tabId"]')?.content || '';
sessionStorage.setItem('tabId', window.tabId);

// Captura o token dinâmico exposto na meta tag no html
window.dynamicToken = document.querySelector('meta[name="dynamic-token"]')?.content || '';
sessionStorage.setItem('dynamic_token', window.dynamicToken);

// Dynamic ‘token’ da sessão armazenado no localStorage
const dynamicToken = sessionStorage.getItem('dynamic_token');
if (dynamicToken) {
    window.axios.defaults.headers.common['X-Dynamic-Session-Token'] = dynamicToken;
}

// ID da atual guia aberta no navegador
const tabId = sessionStorage.getItem('tabId');
if (tabId) {
    window.axios.defaults.headers.common['X-tabId'] = tabId;
}

// Axios response interceptor para atualizar token
axios.interceptors.response.use(
    response => {
        const token = response.headers['x-dynamic-session-token'];
        if (token) {
            window.axios.defaults.headers.common['X-Dynamic-Session-Token'] = token;
            sessionStorage.setItem('dynamic_token', token);
        }
        return response;
    },
    error => {
        if(error.response) {
            const token = error.response.headers['x-dynamic-session-token'];
            if (token) {
                window.axios.defaults.headers.common['X-Dynamic-Session-Token'] = token;
                sessionStorage.setItem('dynamic_token', token);
            }
        }
        return Promise.reject(error);
    },
);
