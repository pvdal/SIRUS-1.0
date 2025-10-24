export function paperViewer(context, url) {
    context.showGroupCards = false;
    context.isLoadingPdf = true;
    context.paperUrl = `${window.appUrl}/pdfjs/web/viewer.html?file=${window.appUrl}/${url}`;
    context.showGroupPaper = true;
    context.$dispatch('toggle-paper', true);
    context.$dispatch('toggle-nav-bar', false);
    context.$nextTick(() => {
        setTimeout(() => {
            context.paperUrl = `${window.appUrl}/pdfjs/web/viewer.html?file=${window.appUrl}/${url}`;
            context.showGroupPaper = true;
            context.$dispatch('toggle-paper', true);
        }, 5);
    });
}
