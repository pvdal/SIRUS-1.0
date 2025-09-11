export function formatDateTime(label, datetime, compare = null) {
    // Se datetime for nulo ou o igual compare, retorna string vazia
    // O correto é passar create_at como segundo argumento quando usar esse helper para updated_at, assim apenas o created_at receberá valor real
    if (!datetime || (compare && datetime === compare)) return '';

    const date = new Date(datetime);
    return `${label}: ${date.toLocaleDateString('pt-BR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    })} às ${date.toLocaleTimeString('pt-BR', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    })
    }`;
}
