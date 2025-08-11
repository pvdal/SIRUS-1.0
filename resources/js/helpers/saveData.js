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
        const requestPrefix = document.querySelector('meta[name="request-prefix"]')?.content || '';

        const response = await axios({
            method,
            url: `/${requestPrefix}${url}`,
            data: payload,
        });

        if (clearFields) contexto.clearFields?.('store');
        if (response.data.success && response.data.message) {
            contexto.showMessage('success', response.data.message);
        } else {
            contexto.showMessage('success', 'Salvo com sucesso!');
        }

        let novo = response.data?.data ?? response.data;

        if(typeof formatResponse === 'function'){
            novo = formatResponse(novo);
        }

        if (campoLista && Array.isArray(contexto[campoLista])) {
            // console.log('Antes do unshift:', contexto[campoLista]);
            const novoComOrigin = { ...novo, origin: 'new' };
            contexto[campoLista].unshift(novoComOrigin);
            // console.log('Depois do unshift:', contexto[campoLista]);
            if (contexto[campoLista].length > 10) contexto[campoLista].pop();
        }

        if (callbackSucesso) callbackSucesso(response.data);

        contexto.empty = false;

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
                // Coloca todos os erros de members em uma única chave
                errorsNormalized.members = membersErrors;
            }

            contexto.errors = errorsNormalized;
            contexto.showMessage('warning', 'Verifique os dados informados!');
        } else {
            contexto.showMessage('danger', 'Erro inesperado ao salvar.');
            console.error(error);
        }
    }
    finally {
        contexto.saving = false;
    }
}
