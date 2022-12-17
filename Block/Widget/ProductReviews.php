<?php
/**
 * Class ProductReviews
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_AllProductReviews
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\AllProductReviews\Block\Widget;

class ProductReviews extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{

    /**
     * RatingFactory
     *
     * @var \Magento\Review\Model\RatingFactory
     */
    protected $ratingFactory;

    /**
     * ProductFactory
     *
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * ReviewFactory
     *
     * @var \Magento\Review\Model\ResourceModel\Review\CollectionFactory
     */
    protected $reviewFactory;

    /**
     * ProductRepository
     *
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;

    /**
     * Data Helper
     *
     * @var \Risecommerce\AllProductReviews\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * ProductReviews constructor.
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Review\Model\RatingFactory $ratingFactory
     * @param \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewFactory
     * @param \Magento\Review\Model\ReviewFactory $reviewFactorySec
     * @param \Risecommerce\AllProductReviews\Helper\Data $helper
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Review\Model\RatingFactory $ratingFactory,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewFactory,
        \Magento\Review\Model\ReviewFactory $reviewFactorySec,
        \Risecommerce\AllProductReviews\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = array()
    ) {
            parent::__construct($context, $data);
            $this->helper = $helper;
            $this->_storeManager = $storeManager;
            $this->productFactory = $productFactory;
            $this->ratingFactory = $ratingFactory;
            $this->reviewFactory = $reviewFactory;
            $this->_reviewFactorySec = $reviewFactorySec;
            $this->productRepository = $productRepository;
            $this->imageHelper = $imageHelper;
            $this->_resource = $resource;
    }

    /**
     * Return Reviews collection
     *
     * @return \Magento\Review\Model\ResourceModel\Review\CollectionFactory
     */
    public function getReviewCollection()
    {
        $collection = $this->reviewFactory->create()
            ->addStatusFilter(
                \Magento\Review\Model\Review::STATUS_APPROVED
            );

        $ratingPptionVoteTabelName   = $this->_resource->getTableName('rating_option_vote');

        $collection->getSelect()->joinInner(
            $ratingPptionVoteTabelName,
            'main_table.review_id = '.$ratingPptionVoteTabelName.'.review_id',
            array('review_value' => ''.$ratingPptionVoteTabelName.'.percent')
        )->group('main_table.review_id');
        
        $collection->setOrder('review_value', 'DESC');
        if ($this->helper->getSortByPosition()) {
            $collection->setOrder('position', 'DESC');
        } else {
            $collection->setOrder('review_id', 'DESC');
        }

        if ($this->getNoOfReview() < count($collection)) {
            $collection->setPageSize($this->getNoOfReview());
            $collection->clear();
        }
        return $collection;
    }

    /**
     * Return total rating of reviews
     *
     * @return int
     */
    public function getTotalRating()
    {
        $reviewCollection = $this->getReviewCollection();
        $totalRating = 0;
        $totalReviews = $this->getDisplayNoReview();
        $count = 0;
        foreach ($reviewCollection as $review) {
            if ($count >= $totalReviews ) {
                break;
            }
            $ratingSummary = $review['review_value'];
            $totalRating = $ratingSummary + $totalRating;
            $count++;
        }

        return $totalRating;

    }

    /**
     * Return no. reviews
     *
     * @return int
     */
    public function getDisplayNoReview()
    {
        $reviewCollection = $this->getReviewCollection();
        if (count($reviewCollection) < $this->getNoOfReview()) {
            $totalReviews = count($reviewCollection);
        } else {
            $totalReviews = $this->getNoOfReview();
        }

         return $totalReviews;

    }

    /**
     * Return average rating
     *
     * @return float
     */
    public function getAvgRating()
    {
        $totalReviews = $this->getDisplayNoReview();
        $totalRating = $this->getTotalRating();
        $avg = ($totalReviews?($totalRating / $totalReviews):0);
        $avgRating = number_format(((float)$avg/20), 1, '.', '');
        return $avgRating;
    }

    /**
     * Return image path of product
     *
     * @param int $id id
     *
     * @return string|void
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getImagePathFromSku($id)
    {
        $product = $this->productRepository->getById($id);

        if ($product) {
            $mediaurl = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            );
            $image_url = $this->imageHelper->init($product, 'product_base_image')->getUrl();
            return $image_url;
        } else {
            return;
        }
    }

    /**
     * Return product url
     *
     * @param int $id id
     *
     * @return string
     */
    public function getProductImageUrl($id)
    {
        $product = $this->productRepository->getById($id);
        return $product->getProductUrl();
    }

    /**
     * Return product deatil review section url
     *
     * @param int $id id
     *
     * @return string
     */
    public function getProductReviewUrl($id)
    {
        $product = $this->productRepository->getById($id);
        $productReview = $product->getProductUrl();
        return $productReview . "#reviews";
    }

    /**
     * Return No. of review to display
     *
     * @return mixed
     */
    public function getNoOfReview()
    {
        return $this->helper->getNoOfReview();
    }

    /**
     * Return is display total or not
     *
     * @return bool
     */
    public function isDisplayTotal()
    {
        return $this->helper->isDisplayTotal();
    }

    /**
     * Return show review title or not
     *
     * @return bool
     */
    public function showTitle()
    {
        return $this->helper->showTitle();
    }

    /**
     * Return show review rating or not
     *
     * @return bool
     */
    public function showRating()
    {
        return $this->helper->showRating();
    }

    /**
     * Return show reviewer name or not
     *
     * @return bool
     */
    public function showName()
    {
        return $this->helper->showName();
    }

    /**
     * Return show review image or not
     *
     * @return bool
     */
    public function showImage()
    {
        return $this->helper->showImage();
    }

    /**
     * Return show review date or not
     *
     * @return bool
     */
    public function showDate()
    {
        return $this->helper->showDate();
    }

}

