// ==========================================
// HOME PAGE MAIN JAVASCRIPT
// ==========================================

$(document).ready(function() {
    // Ambil data dari window object
    const exchangeData = window.exchangeData;
    const productMap = window.productMap;
    const blockchainMap = window.blockchainMap;
    const routeTransactionCreate = window.routeTransactionCreate;

    // ==========================================
    // SELECT2 FORMATTING FUNCTIONS
    // ==========================================
    function formatProduct(option) {
        if (!option.id) return option.text;
        const imgUrl = $(option.element).data('img');
        const productName = $(option.element).data('name');
        const productCode = $(option.element).data('code');
        return $(
            '<div class="product-option">' +
                '<img src="' + (imgUrl || 'https://via.placeholder.com/30') + '" class="product-option-img" onerror="this.src=\'https://via.placeholder.com/30\'">' +
                '<span class="product-option-name">' + productName + '</span>' +
                '<span class="product-option-code">(' + productCode + ')</span>' +
            '</div>'
        );
    }

    function formatProductSelection(option) {
        if (!option.id) return option.text;
        const imgUrl = $(option.element).data('img');
        const productName = $(option.element).data('name');
        const productCode = $(option.element).data('code');
        return $(
            '<div style="display: flex; align-items: center;">' +
                '<img src="' + (imgUrl || 'https://via.placeholder.com/24') + '" style="width: 24px; height: 24px; border-radius: 6px; margin-right: 10px;" onerror="this.src=\'https://via.placeholder.com/24\'">' +
                '<span>' + productName + ' (' + productCode + ')</span>' +
            '</div>'
        );
    }

    function formatBlockchainOption(option) {
        if (!option.id) return option.text;
        const imgUrl = $(option.element).data('img');
        const blockchainName = $(option.element).data('name');
        if (!imgUrl) return blockchainName;
        return $(
            '<div class="blockchain-option">' +
                '<img src="' + imgUrl + '" class="blockchain-option-img" onerror="this.src=\'https://via.placeholder.com/25\'">' +
                '<span>' + blockchainName + '</span>' +
            '</div>'
        );
    }

    function formatBlockchainSelection(option) {
        if (!option.id) return option.text;
        const imgUrl = $(option.element).data('img');
        const blockchainName = $(option.element).data('name');
        if (!imgUrl) return blockchainName;
        return $(
            '<div style="display: flex; align-items: center;">' +
                '<img src="' + imgUrl + '" style="width: 20px; height: 20px; border-radius: 4px; margin-right: 8px;" onerror="this.src=\'https://via.placeholder.com/20\'">' +
                '<span>' + blockchainName + '</span>' +
            '</div>'
        );
    }

    // Initialize Select2
    $('#fromCurrency').select2({
        templateResult: formatProduct,
        templateSelection: formatProductSelection,
        placeholder: "-- Select Product --",
        width: '100%'
    });

    $('#toCurrency').select2({
        templateResult: formatProduct,
        templateSelection: formatProductSelection,
        placeholder: "-- Select To --",
        width: '100%'
    });

    $('#fromBlockchain').select2({
        templateResult: formatBlockchainOption,
        templateSelection: formatBlockchainSelection,
        placeholder: "-- Select Blockchain --",
        width: '100%'
    });

    $('#toBlockchain').select2({
        templateResult: formatBlockchainOption,
        templateSelection: formatBlockchainSelection,
        placeholder: "-- Select Blockchain --",
        width: '100%'
    });

    // ==========================================
    // BLOCKCHAIN DROPDOWN
    // ==========================================
    function loadBlockchainDropdown(productName, containerId, selectId) {
        const container = document.getElementById(containerId);
        const select = $(selectId);
        let isCrypto = false;
        
        for (const [code, product] of Object.entries(productMap)) {
            if (product.product_name === productName) {
                isCrypto = (product.category === 'Crypto');
                break;
            }
        }
        
        if (isCrypto && blockchainMap[productName] && blockchainMap[productName].length > 0) {
            container.style.display = 'block';
            select.empty().append('<option value="">-- Select Blockchain --</option>');
            
            blockchainMap[productName].forEach(blockchain => {
                const imgUrl = blockchain.blockchain_img ? '/img/blockchain/' + blockchain.blockchain_img : null;
                const option = new Option(blockchain.blockchain, blockchain.blockchain, false, false);
                $(option).data('img', imgUrl);
                $(option).data('name', blockchain.blockchain);
                $(option).data('fee', blockchain.blockchain_fee);
                $(option).data('code', blockchain.blockchain_code);
                select.append(option);
            });
            select.trigger('change');
        } else {
            container.style.display = 'none';
            select.empty();
            select.trigger('change');
        }
    }

    // ==========================================
    // TO DROPDOWN UPDATE
    // ==========================================
    function updateToDropdown(selectedFromCode) {
        const toSelect = $('#toCurrency');
        toSelect.empty().append('<option value="">-- Select To --</option>');
        
        if (!selectedFromCode) {
            toSelect.prop('disabled', true);
            toSelect.trigger('change');
            $('#result').html('0.00 USD');
            $('#warningMessage').html('');
            $('#exchangeRate').html('-');
            return;
        }
        
        const availablePairs = [];
        exchangeData.forEach(exchange => {
            const [fromCode, toCode] = exchange.exc_code.split('-');
            if (fromCode === selectedFromCode) {
                availablePairs.push({
                    exc_code: exchange.exc_code,
                    toCode: toCode,
                    rate: exchange.rate,
                    fee: exchange.fee,
                    feeType: exchange.fee_type,
                    min: exchange.min
                });
            }
        });
        
        if (availablePairs.length === 0) {
            toSelect.prop('disabled', true);
            toSelect.trigger('change');
            $('#result').html('0.00 USD');
            $('#warningMessage').html('No exchange rate available for this product');
            $('#exchangeRate').html('-');
            return;
        }
        
        toSelect.prop('disabled', false);
        
        availablePairs.forEach(pair => {
            const product = productMap[pair.toCode];
            if (product) {
                const option = new Option(product.product_name, pair.exc_code, false, false);
                $(option).data('img', product.img);
                $(option).data('name', product.product_name);
                $(option).data('code', product.product_code);
                $(option).data('category', product.category);
                $(option).data('rate', pair.rate);
                $(option).data('fee', pair.fee);
                $(option).data('fee-type', pair.feeType);
                $(option).data('min', pair.min);
                toSelect.append(option);
            }
        });
        toSelect.trigger('change');
    }

    // ==========================================
    // CALCULATION
    // ==========================================
    function calculateConversion() {
        const amount = parseFloat($('#amount').val()) || 0;
        const fromSelect = document.getElementById('fromCurrency');
        const toSelect = document.getElementById('toCurrency');
        
        const fromCode = fromSelect.value;
        const toValue = toSelect.value;
        
        if (!fromCode || !toValue) {
            $('#result').html('0.00 USD');
            $('#warningMessage').html('');
            $('#exchangeRate').html('-');
            return;
        }
        
        const selectedOption = toSelect.options[toSelect.selectedIndex];
        const fromSelectedOption = fromSelect.options[fromSelect.selectedIndex];
        const fromProductName = fromSelectedOption ? $(fromSelectedOption).data('name') || '' : '';
        const rate = parseFloat($(selectedOption).data('rate')) || 0;
        const exchangeFee = parseFloat($(selectedOption).data('fee')) || 0;
        const feeType = $(selectedOption).data('fee-type');
        const minAmount = parseFloat($(selectedOption).data('min')) || 0;
        const toProductName = $(selectedOption).data('name') || '';
        const toCategory = $(selectedOption).data('category') || '';
        
        const toBlockchainSelect = document.getElementById('toBlockchain');
        const selectedBlockchain = toBlockchainSelect ? toBlockchainSelect.options[toBlockchainSelect.selectedIndex] : null;
        const blockchainFee = selectedBlockchain ? parseFloat($(selectedBlockchain).data('fee')) || 0 : 0;
        
        $('#exchangeRate').html(`1 ${fromProductName} = ${rate.toFixed(2)} ${toProductName}`);
        
        let result = amount * rate;
        let feeAmount = 0;
        let feeText = '';
        const resultValue = amount * rate;
        let isFlatFee = false;
        let flatFeeAmount = 0;
        
        if (toProductName === 'Neteller' && resultValue < 17) {
            isFlatFee = true;
            flatFeeAmount = 0.60;
            feeText = `$${flatFeeAmount.toFixed(2)} (minimal fee)`;
        } else if (toProductName === 'Skrill' && resultValue < 40) {
            isFlatFee = true;
            flatFeeAmount = 0.60;
            feeText = `$${flatFeeAmount.toFixed(2)} (minimal fee)`;
        } else if (toProductName === 'Payoneer' && resultValue < 400) {
            isFlatFee = true;
            flatFeeAmount = 4.00;
            feeText = `$${flatFeeAmount.toFixed(2)} (minimal fee)`;
        }
        
        if (isFlatFee) {
            feeAmount = flatFeeAmount;
        } else {
            let exchangeFeeAmount = 0;
            if (feeType === 'Percentage') {
                exchangeFeeAmount = (result * exchangeFee) / 100;
                feeText = `${exchangeFee}%`;
            } else {
                exchangeFeeAmount = exchangeFee;
                feeText = `$${exchangeFee.toFixed(2)}`;
            }
            if (toCategory === 'Crypto' && blockchainFee > 0) {
                feeAmount = exchangeFeeAmount + blockchainFee;
                feeText = feeText + ` + $${blockchainFee.toFixed(2)} blockchain fee`;
            } else {
                feeAmount = exchangeFeeAmount;
            }
        }
        
        let finalAmount = result - feeAmount;
        if (finalAmount < 0) finalAmount = 0;
        
        $('#result').html(`${finalAmount.toFixed(2)} ${toProductName}`);
        
        if (finalAmount < minAmount) {
            $('#warningMessage').html(`⚠️ Minimum received amount is $${minAmount.toFixed(2)} (Fee: ${feeText})`);
        } else {
            $('#warningMessage').html(`Fee: ${feeText}`);
        }
        
        window.isMinimumMet = (finalAmount >= minAmount);
        window.currentTransactionData = {
            amount: amount,
            fromProductCode: fromCode,
            fromProductName: fromProductName,
            toExcCode: toValue,
            toProductName: toProductName,
            toCategory: toCategory,
            fromBlockchain: $('#fromBlockchain').val(),
            toBlockchain: $('#toBlockchain').val(),
            rate: rate,
            feeAmount: feeAmount,
            feeText: feeText,
            finalAmount: finalAmount,
            minAmount: minAmount
        };
    }

    // ==========================================
    // AUTO-FILL FUNCTION
    // ==========================================
    function autoFillFromExchangeRate() {
        const urlParams = new URLSearchParams(window.location.search);
        let fromProduct = urlParams.get('from');
        let toProduct = urlParams.get('to');
        
        if (!fromProduct || !toProduct) {
            fromProduct = localStorage.getItem('exchange_from');
            toProduct = localStorage.getItem('exchange_to');
            if (fromProduct && toProduct) {
                localStorage.removeItem('exchange_from');
                localStorage.removeItem('exchange_to');
            }
        }
        
        if (fromProduct && toProduct) {
            let fromCode = null;
            $('#fromCurrency option').each(function() {
                if ($(this).data('name') === fromProduct) {
                    fromCode = $(this).val();
                    return false;
                }
            });
            if (fromCode) {
                $('#fromCurrency').val(fromCode).trigger('change');
                setTimeout(() => {
                    $('#toCurrency option').each(function() {
                        if ($(this).data('name') === toProduct) {
                            $(this).prop('selected', true);
                            $('#toCurrency').trigger('change');
                            return false;
                        }
                    });
                }, 500);
            }
        }
    }

    // ==========================================
    // EVENT LISTENERS
    // ==========================================
    $('#amount').on('input', calculateConversion);
    
    $('#fromCurrency').on('change', function() {
        const productName = $(this).find('option:selected').data('name');
        const productCode = $(this).val();
        if (productName) {
            loadBlockchainDropdown(productName, 'fromBlockchainContainer', '#fromBlockchain');
        } else {
            $('#fromBlockchainContainer').hide();
        }
        updateToDropdown(productCode);
    });
    
    $('#toCurrency').on('change', function() {
        const productName = $(this).find('option:selected').data('name');
        if (productName) {
            loadBlockchainDropdown(productName, 'toBlockchainContainer', '#toBlockchain');
        } else {
            $('#toBlockchainContainer').hide();
        }
        calculateConversion();
    });
    
    $('#toBlockchain').on('change', calculateConversion);
    
    $('#btnExchangeNow').on('click', function() {
        if (window.isMinimumMet === false) {
            alert('⚠️ Minimum received amount is not met. Please increase the amount.');
            return;
        }
        const data = window.currentTransactionData;
        if (!data || !data.toExcCode) {
            alert('Please complete the exchange form first');
            return;
        }
        
        const fromCategory = $('#fromCurrency').find(':selected').data('category');
        const toCategory = $('#toCurrency').find(':selected').data('category');
        const fromBlockchain = $('#fromBlockchain').val();
        const toBlockchain = $('#toBlockchain').val();
        
        if (fromCategory === 'Crypto' && (!fromBlockchain || fromBlockchain === '')) {
            alert('Please select Blockchain Network (From) for ' + data.fromProductName);
            return;
        }
        if (toCategory === 'Crypto' && (!toBlockchain || toBlockchain === '')) {
            alert('Please select Blockchain Network (To) for ' + data.toProductName);
            return;
        }
        
        const form = $('<form method="GET" action="' + routeTransactionCreate + '"></form>');
        const formData = {
            amount: data.amount,
            from_product_code: data.fromProductCode,
            to_exc_code: data.toExcCode,
            from_blockchain: data.fromBlockchain,
            to_blockchain: data.toBlockchain,
            rate: data.rate,
            fee_amount: data.feeAmount,
            fee_text: data.feeText,
            final_amount: data.finalAmount
        };
        $.each(formData, function(key, value) {
            form.append('<input type="hidden" name="' + key + '" value="' + value + '">');
        });
        $('body').append(form);
        form.submit();
    });
    
    setTimeout(function() {
        if ($('#fromCurrency').val()) {
            updateToDropdown($('#fromCurrency').val());
        }
    }, 100);
    
    setTimeout(autoFillFromExchangeRate, 1000);
});