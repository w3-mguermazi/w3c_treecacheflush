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
                    Notification.success(TYPO3.lang['w3c_treecacheflush.cache_cleared_successfully']);
                })
                .catch(() => {
                    Notification.error(TYPO3.lang['w3c_treecacheflush.cache_clear_failed']);
                });
        }
    }
}

// Export comme dans impexp
export default new FlushTreeCacheAction();
