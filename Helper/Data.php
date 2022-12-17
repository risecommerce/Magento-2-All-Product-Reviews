<?php
/**
 * Class Data
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_AllProductReviews
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\AllProductReviews\Helper;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;

class Data extends AbstractHelper
{

     /**
      * Encryptor
      *
      * @var \Magento\Framework\Encryption\EncryptorInterface
      */
    protected $encryptor;

    /**
     * Constructor
     *
     * @param Context            $context   context
     * @param EncryptorInterface $encryptor encryptor
     */
    public function __construct(
        Context $context,
        EncryptorInterface $encryptor
    ) {
        parent::__construct($context);
        $this->encryptor = $encryptor;
    }

    /**
     * Return no. of review to display
     *
     * @param string $scope scope
     *
     * @return mixed
     */
    public function getNoOfReview($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'risecommerce_all_product_reviews/general/No_of_Review',
            $scope
        );
    }

    /**
     * Return display total or not
     *
     * @param string $scope scope
     *
     * @return bool
     */
    public function isDisplayTotal($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'risecommerce_all_product_reviews/general/displayTotal',
            $scope
        );
    }

    /**
     * Return show title of review or not
     *
     * @param string $scope scope
     *
     * @return bool
     */
    public function showTitle($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'risecommerce_all_product_reviews/general/showTitle',
            $scope
        );

    }

    /**
     * Return show title of rating or not
     *
     * @param string $scope scope
     *
     * @return bool
     */
    public function showRating($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'risecommerce_all_product_reviews/general/showRating',
            $scope
        );

    }

    /**
     * Return show name of reviewer or not
     *
     * @param string $scope scope
     *
     * @return bool
     */
    public function showName($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'risecommerce_all_product_reviews/general/showName',
            $scope
        );

    }

    /**
     * Return show date of review or not
     *
     * @param string $scope scope
     *
     * @return bool
     */
    public function showDate($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'risecommerce_all_product_reviews/general/showDate',
            $scope
        );

    }

    /**
     * Return show image of review or not
     *
     * @param string $scope scope
     *
     * @return bool
     */
    public function showImage($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'risecommerce_all_product_reviews/general/showImage',
            $scope
        );

    }

    /**
     * Return sort reviews by position or not
     *
     * @param string $scope scope
     *
     * @return bool
     */
    public function getSortByPosition($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'risecommerce_all_product_reviews/general/sortByPosition',
            $scope
        );

    }
}
