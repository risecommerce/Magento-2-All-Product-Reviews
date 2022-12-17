<?php
/**
 * Class Form
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_AllProductReviews
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\AllProductReviews\Plugin\Review\Block\Adminhtml\Add;


class Form extends \Magento\Review\Block\Adminhtml\Add\Form
{
    /**
     * Add position field to the review edit form
     *
     * @param \Magento\Review\Block\Adminhtml\Add\Form $object object
     * @param \Magento\Framework\Data\Form             $form   form
     * 
     * @return \Magento\Framework\Data\Form
     */
    public function beforeSetForm(
        \Magento\Review\Block\Adminhtml\Add\Form $object, 
        $form
    ) {

        $fieldset = $form->getElement('add_review_form');

        $fieldset->addField(
            'position',
            'text',
            ['label' => __('Position'), 'required' => false, 'name' => 'position']
        );

        return [$form];
    }
}
