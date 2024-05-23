var Report = Class.create({
    initialize: function(options) {
        console.log('Report initialized');
        this.containerId = options.containerId;
        this.url = options.url;
        this.saveUrl = options.saveUrl;
        this.formKey = options.formKey;
        
        // Ensure these elements exist and are correctly referenced
        this.sellerSelect = $('seller');
        this.loadReportButton = $('load-report');
        this.productGrid = $('product-grid');
        this.selectAllCheckbox = $('select-all-products');
        this.assignButton = $('assign-to-seller');
        
        this.bindEvents();
    },

    bindEvents: function() {
        var self = this;

        if (this.loadReportButton) {
            this.loadReportButton.observe('click', function() {
                self.loadReport();
            });
        }
        
        if (this.selectAllCheckbox) {
            this.selectAllCheckbox.observe('click', function() {
                self.selectAllProducts(this.checked);
            });
        }

        if (this.assignButton) {
            this.assignButton.observe('click', function() {
                self.assignToSeller();
            });
        }
    },

    loadReport: function() {
        var sellerId = this.sellerSelect.value;
        if (sellerId) {
            new Ajax.Request(this.url, {
                method: 'get',
                parameters: { seller_id: sellerId },
                onSuccess: function(transport) {
                    var response = transport.responseText;
                    this.productGrid.update(response);
                }.bind(this),
                onFailure: function() {
                    alert('Failed to load report.');
                }
            });
        } else {
            alert('Please select a seller.');
        }
    },

    selectAllProducts: function(checked) {
        $$('#product-grid input.product-checkbox').each(function(element) {
            element.checked = checked;
        });
    },

    assignToSeller: function() {
        var selectedProducts = $$('#product-grid input.product-checkbox:checked').pluck('value');
        var sellerId = this.sellerSelect.value;

        if (selectedProducts.length > 0 && sellerId) {
            new Ajax.Request(this.saveUrl, {
                method: 'post',
                parameters: {
                    seller_id: sellerId,
                    products: selectedProducts.join(','),
                    form_key: this.formKey
                },
                onSuccess: function(transport) {
                    var response = transport.responseText.evalJSON();
                    alert(response.message);
                },
                onFailure: function() {
                    alert('Failed to assign products to seller.');
                }
            });
        } else {
            alert('Please select a seller and at least one product.');
        }
    }
});

// document.observe('dom:loaded', function() {
//     var report = new Report({
//         containerId: 'report-container',
//         url: '<?php echo $this->getUrl('yourmodule/adminhtml_product/loadReport'); ?>',
//         saveUrl: '<?php echo $this->getUrl('yourmodule/adminhtml_product/assignToSeller'); ?>',
//         formKey: '<?php echo Mage::getSingleton('core/session')->getFormKey(); ?>'
//     });
// });
