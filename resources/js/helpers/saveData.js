export async function saveData({
                                   url,
                                   payload,
                                   contexto,
                                   campoLista = null,
                                   callbackSucesso = null,
                                   clearFields = true,
                                   method = 'post',
                                   formatResponse = null,
                               }) {
    if (contexto.saving) return;

    contexto.errors = {};
    contexto.saving = true;

    try {
        // Pega o prefixo do <meta name="request-prefix" content="api">, se existir
        const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';

        // Verifica se a URL é absoluta (ex: https://api.site.com/endpoint)
        const isAbsoluteUrl = /^https?:\/\//i.test(url);
        // Se for absoluta, usa diretamente. Se não, adiciona o prefixo se necessário
        const finalUrl = isAbsoluteUrl ? url : `/${requestPrefix}${url}`.replace(/\/{2,}/g, '/');

        const response = await axios({
            method,
            url: finalUrl,
            data: payload,
        });

        let novo = response.data?.data ?? response.data;

        // Só continua se o status for 2xx e existir um id ou campo esperado
        if (!(response.status >= 200 && response.status < 300) || !novo?.id) {
            // código para quando NÃO é 2xx ou novo.id não existe
            return;
        }

        if (clearFields) contexto.clearFields?.('store');

        if (response.data.success && response.data.message) {
            contexto.showMessage('success', response.data.message);
        } else {
            contexto.showMessage('success', 'Salvo com sucesso!');
        }

        if (typeof formatResponse === 'function') {
            novo = formatResponse(novo);
        }

        if (campoLista && Array.isArray(contexto[campoLista])) {
            const novoComOrigin = { ...novo, origin: 'new' };
            contexto[campoLista].unshift(novoComOrigin);
            if (contexto[campoLista].length > 10) contexto[campoLista].pop();
        }


        if (callbackSucesso) callbackSucesso(response.data);

        contexto.empty.result = false;

        // Retorna o objeto salvo para uso na view
        return novo;

    } catch (error) {
        if (error.response?.status === 422) {
            const errorsRaw = error.response.data.errors;
            const errorsNormalized = {};
            const membersErrors = [];

            for (const key in errorsRaw) {
                if (key.startsWith('members.')) {
                    membersErrors.push(...errorsRaw[key]);
                } else {
                    errorsNormalized[key] = errorsRaw[key];
                }
            }

            if (membersErrors.length > 0) {
                errorsNormalized.members = membersErrors;
            }
            const message = (error.response?.data?.success === false && error.response?.data?.message)
                || 'Verifique os dados informados!';

            contexto.errors = errorsNormalized;
            contexto.showMessage('warning', message);
        } else if(error.response?.status === 413) {
            contexto.showMessage('warning', 'O arquivo enviado é muito grande. O limite permitido é 5MB.');
        } else if(error.response?.status === 403) {
            const message = ( error.response?.data?.message)
                || 'Você não tem autorização para executar essa ação!';

            window.dispatchEvent(new CustomEvent('banner-message', {
                detail: {
                    style: 'danger',
                    message: message,
                }
            }));
        } else if(error.response?.status === 404) {
            const message = (error.response?.data?.success === false && error.response?.data?.message)
                || 'Erro inesperado ao salvar!';

            if(error.response?.data?.success === false) {
                contexto.showMessage('warning', message);
            } else {
                contexto.showMessage('danger', message);
            }
        } else {
            contexto.showMessage('danger', 'Erro inesperado ao salvar!');
            //console.error(error);
        }
        // throw error;
    } finally {
        contexto.saving = false;
    }
}
