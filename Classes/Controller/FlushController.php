<?php
namespace W3code\W3cTreecacheflush\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Type\Bitmask\Permission;

class FlushController
{
    /**
     * @var DataHandler
     */
    protected $dataHandler;

    public function __construct()
    {
        $this->dataHandler = GeneralUtility::makeInstance(DataHandler::class);
    }

    public function flushAction(ServerRequestInterface $request): ResponseInterface
    {
        //$uid = (int)($request->getAttribute('routeArguments')['uid'] ?? 0);
        $queryParams = $request->getQueryParams();
        $uid = isset($queryParams['uid']) ? (int)$queryParams['uid'] : 0;
        
        if ($uid <= 0) {
            return new JsonResponse(['error' => 'Invalid page id'], 400);
        }

        $uidsToFlush = $this->getRecursivePageUids($uid);
        $this->dataHandler->start([], []);
        $permissionClause = $this->getBackendUserAuthentication()->getPagePermsClause(Permission::PAGE_SHOW);
        foreach ($uidsToFlush as $id) {
            $pageRow = BackendUtility::readPageAccess($id, $permissionClause);
            if ($id !== 0 && $this->getBackendUserAuthentication()->doesUserHaveAccess($pageRow, Permission::PAGE_SHOW)) {
                $this->dataHandler->clear_cacheCmd($id);
            }
            
        }

        return new JsonResponse(['status' => 'ok']);
    }

    protected function getRecursivePageUids(int $parentUid): array
    {
        $uids = [$parentUid];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $rows = $queryBuilder
            ->select('uid')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($parentUid)),
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->executeQuery()
            ->fetchAllAssociative();

        foreach ($rows as $row) {
            $uids = array_merge($uids, $this->getRecursivePageUids((int)$row['uid']));
        }

        return $uids;
    }

    protected function getBackendUserAuthentication(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
