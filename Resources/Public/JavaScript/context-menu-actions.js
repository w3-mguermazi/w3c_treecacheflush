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
                    Notification.success('Cache cleared successfully');
                })
                .catch(() => {
                    Notification.error('Failed to clear cache');
                });
        }
    }
}

// Export comme dans impexp
export default new FlushTreeCacheAction();
