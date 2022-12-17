<?php
/**
 * Class ReviewSave
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_AllProductReviews
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\AllProductReviews\Observer;

use Magento\Framework\Event\ObserverInterface;

class ReviewSave implements ObserverInterface
{
    /**
     * Constructor
     *
     * @param \Magento\Framework\App\ResourceConnection $resource resource
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->_resource = $resource;
    }

    /**
     * Observer Action
     *
     * @param \Magento\Framework\Event\Observer $observer observer
     *
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $review = $observer->getEvent()->getDataObject();
        $connection = $this->_resource;

        $tableName = $connection->getTableName('review_detail');
        $detail = [
            'position' => $review->getPosition() ? $review->getPosition() : 1,
        ];

        $select = $connection->getConnection()
            ->select()
            ->from($tableName)
            ->where('review_id = :review_id');
        $detailId = $connection->getConnection()
            ->fetchOne($select, [':review_id' => $review->getId()]);

        if ($detailId) {
            $condition = ["detail_id = ?" => $detailId];
            $connection->getConnection()->update($tableName, $detail, $condition);
        } else {
            $detail['store_id'] = $review->getStoreId();
            $detail['customer_id'] = $review->getCustomerId();
            $detail['review_id'] = $review->getId();
            $connection->getConnection()->insert($tableName, $detail);
        }
    }
}
