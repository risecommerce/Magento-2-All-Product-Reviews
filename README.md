# Risecommerce All Product Reviews Extension

The [Risecommerce All Product Reviews page](https://risecommerce.com/store/magento2-all-product-reviews-as-testomonials.html) extension enables the store admin to display all product reviews on a single page via a widget. This feature helps showcase customer testimonials efficiently, improving trust and boosting conversions.

For more details about this extension, visit the [Risecommerce All Product Reviews page](https://risecommerce.com/store/magento2-all-product-reviews-as-testomonials.html).

If you're looking to enhance your Magento store further, consider hiring a [dedicated Magento developer](https://risecommerce.com/hire-dedicated-magento-developer.html).

For support or inquiries, please visit our [contact page](https://risecommerce.com/contact).

## Supported Versions
- Magento 2.3.x
- Magento 2.4.x

## Installation Instructions

### Method I: Manual Installation

1. Download the archive file.
2. Unzip the files.
3. Create the following directory: `[Magento_Root]/app/code/Risecommerce/AllProductReviews`.
4. Move the unzipped files into the directory `[Magento_Root]/app/code/Risecommerce/AllProductReviews`.

### Method II: Installation Using Composer

Run the following command:

composer require risecommerce/magento-2-all-product-reviews-extension:1.0.1

#Enable Extension:
- php bin/magento module:enable Risecommerce_AllProductReviews
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush

#Disable Extension:
- php bin/magento module:disable Risecommerce_AllProductReviews
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush

