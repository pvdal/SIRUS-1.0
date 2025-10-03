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
            context.searchTerm = '';
            context.statusFilter = {};
            context.registerPeriod = {};
            addFilters.forEach(filter => {
                context[filter] = {};
            })
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
