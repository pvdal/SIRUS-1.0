export function paperViewer(context, url) {
    context.showGroupCards = false;
    context.isLoadingPdf = true;
    context.paperUrl = url;
    context.showGroupPaper = true;
    context.$dispatch('toggle-paper', true);
    context.$nextTick(() => {
        setTimeout(() => {
            context.paperUrl = url;
            context.showGroupPaper = true;
            context.$dispatch('toggle-paper', true);
        }, 10);
    });
}
