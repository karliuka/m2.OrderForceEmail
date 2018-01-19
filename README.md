# Magento2 Order Force Email

Extension send order confirmation emails when an order is placed and paid with online payment methods (paypal, authorize etc). 

### Configuration page
<img alt="Magento2 Order Force Email" src="https://karliuka.github.io/m2/order-force-email/config.png" style="width:100%"/>

## Install with Composer as you go

1. Go to Magento2 root folder

2. Enter following commands to install module:

    ```bash
    composer require faonni/module-order-force-email
    ```
   Wait while dependencies are updated.

3. Enter following commands to enable module:

    ```bash
	php bin/magento setup:upgrade
	php bin/magento setup:di:compile
	php bin/magento setup:static-content:deploy  (optional)
