export function clearComponentData(context, type, formFields = [], addFilters = []) {
    switch (type){
        case 'store':
            formFields.forEach(field => {
                if (Array.isArray(context[field]))  {
                    context[field] = [];
                } else if(typeof context[field] === 'boolean')  {
                    context[field] = false;
                } else {
                    context[field] = '';
                }
            })
            context.errors = {};
            context.showBanner = false;
            break;
        case 'filters':
            if('searchTerm' in context) context.searchTerm = '';
            if('statusFilter' in context) context.statusFilter = {};
            if ('registerPeriod' in context) context.registerPeriod = {};
            addFilters.forEach(filter => {
                resetAddFilters (context, filter);
            });
            break;
        case 'warning':
            context.warningType = '';
            context.warningContent = '';
            break;
        default:
            context.clearFields('store');
            context.clearFields('filters');
            context.clearFields('warning')
            break;
    }
}

function resetAddFilters(context, key) {
    if (!(key in context)) return;

    const value = context[key];

    if (Array.isArray(value)) {
        context[key] = [];
        return;
    }

    if (typeof value === 'boolean') {
        context[key] = false;
        return;
    }

    if (typeof value === 'object' && value !== null) {
        Object.keys(value).forEach(key => {
            value[key] = '';
        });
        return;
    }

    context[key] = '';
}
