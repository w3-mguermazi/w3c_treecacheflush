/*
 * Custom context menu item for TYPO3 page tree
 */
import AjaxRequest from '@typo3/core/ajax/ajax-request.js';
import Notification from '@typo3/backend/notification.js';

class FlushTreeCacheAction {
    flushTreeCache(table, uid, additionalData) {
        if (table === 'pages') {
            new AjaxRequest(TYPO3.settings.ajaxUrls['w3c_treecacheflush_flush'] + '&uid=' + uid)
                .get()
                .then(() => {
                    Notification.success(additionalData['labelSuccess']);
                })
                .catch(() => {
                    Notification.error(additionalData['labelError']);
                });
        }
    }
}

// Export comme dans impexp
export default new FlushTreeCacheAction();
