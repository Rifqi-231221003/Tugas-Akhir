// ==========================================
// EXCHANGE DETAIL CODE JAVASCRIPT WITH CUSTOM DROPDOWN
// ==========================================

$(document).ready(function() {
    console.log('Document ready - Starting with custom dropdown (CODE version)...');
    
    const blockchainMap = window.blockchainMap;
    const productMap = window.productMap;
    const routeTransactionCreate = window.routeTransactionCreate;
    
    const fromProductName = window.fromProductName;
    const toProductName = window.toProductName;
    const rate = window.rate;
    const exchangeFee = window.exchangeFee;
    const feeType = window.feeType;
    const minAmount = window.minAmount;
    const fromProductCode = window.fromProductCode;
    const toProductCode = window.toProductCode;

    let fromCategory = '';
    let toCategory = '';
    
    for (const [code, product] of Object.entries(productMap)) {
        if (product.product_name === fromProductName) {
            fromCategory = product.category;
        }
        if (product.product_name === toProductName) {
            toCategory = product.category;
        }
    }
    
    if (window.fromCategory !== undefined && window.fromCategory !== '') {
        fromCategory = window.fromCategory;
    }
    if (window.toCategory !== undefined && window.toCategory !== '') {
        toCategory = window.toCategory;
    }
    
    console.log('Categories:', {fromCategory, toCategory});

    // ==========================================
    // CUSTOM DROPDOWN FUNCTIONS
    // ==========================================
    
    function createCustomDropdown(containerId, selectId, options, selectedValue) {
        const $container = $('#' + containerId);
        $container.empty();
        
        const $selectDiv = $('<div class="custom-dropdown-select">');
        const $img = $('<img>').attr('src', '').css('display', 'none');
        const $text = $('<span>').text('-- Select Blockchain --');
        const $arrow = $('<i class="fas fa-chevron-down arrow">');
        
        $selectDiv.append($img, $text, $arrow);
        
        const $optionsDiv = $('<div class="custom-dropdown-options">');
        
        const $defaultOption = $('<div class="custom-dropdown-option" data-value="">');
        const $defaultImg = $('<img>').attr('src', '').css('display', 'none');
        const $defaultText = $('<span>').text('-- Select Blockchain --');
        $defaultOption.append($defaultImg, $defaultText);
        $optionsDiv.append($defaultOption);
        
        options.forEach(option => {
            const $option = $('<div class="custom-dropdown-option" data-value="' + option.value + '">');
            const $optionImg = $('<img>').attr('src', option.imgUrl).css('display', option.imgUrl ? 'block' : 'none');
            const $optionText = $('<span>').text(option.label);
            $option.append($optionImg, $optionText);
            $option.data('fee', option.fee);
            $option.data('code', option.code);
            $optionsDiv.append($option);
        });
        
        $container.append($selectDiv, $optionsDiv);
        
        $selectDiv.on('click', function(e) {
            e.stopPropagation();
            $('.custom-dropdown-options').not($optionsDiv).removeClass('show');
            $optionsDiv.toggleClass('show');
            $selectDiv.toggleClass('open');
        });
        
        $optionsDiv.find('.custom-dropdown-option').on('click', function(e) {
            e.stopPropagation();
            const value = $(this).data('value');
            const label = $(this).find('span').text();
            const imgUrl = $(this).find('img').attr('src');
            const fee = $(this).data('fee');
            const code = $(this).data('code');
            
            if (imgUrl && value) {
                $img.attr('src', imgUrl).show();
            } else {
                $img.hide();
            }
            $text.text(label);
            
            $('#' + selectId).val(value).trigger('change');
            
            const $selectedOption = $('#' + selectId + ' option[value="' + value + '"]');
            if ($selectedOption.length) {
                $selectedOption.data('fee', fee);
                $selectedOption.data('code', code);
            }
            
            $optionsDiv.removeClass('show');
            $selectDiv.removeClass('open');
            
            calculateConversion();
        });
        
        if (selectedValue && selectedValue !== '') {
            const selectedOption = options.find(opt => opt.value === selectedValue);
            if (selectedOption) {
                if (selectedOption.imgUrl) {
                    $img.attr('src', selectedOption.imgUrl).show();
                }
                $text.text(selectedOption.label);
                $('#' + selectId).val(selectedValue);
            }
        }
        
        $(document).on('click', function() {
            $optionsDiv.removeClass('show');
            $selectDiv.removeClass('open');
        });
    }
    
    function loadBlockchainDropdown(productName, containerId, selectId, dropdownId, category) {
        const container = document.getElementById(containerId);
        
        console.log('loadBlockchainDropdown -', productName, 'Category:', category);
        
        if (category === 'Crypto' && blockchainMap[productName] && blockchainMap[productName].length > 0) {
            console.log('Memuat blockchain untuk:', productName);
            container.style.display = 'block';
            
            const $select = $('#' + selectId);
            let previousVal = $select.val();
            
            $select.empty().append('<option value="">-- Select Blockchain --</option>');
            
            const options = [];
            blockchainMap[productName].forEach(blockchain => {
                const imgUrl = blockchain.blockchain_img ? '/img/blockchain/' + blockchain.blockchain_img : null;
                const option = new Option(blockchain.blockchain, blockchain.blockchain, false, false);
                $(option).data('fee', blockchain.blockchain_fee);
                $(option).data('code', blockchain.blockchain_code);
                $select.append(option);
                
                options.push({
                    value: blockchain.blockchain,
                    label: blockchain.blockchain,
                    imgUrl: imgUrl,
                    fee: blockchain.blockchain_fee,
                    code: blockchain.blockchain_code
                });
            });
            
            if (previousVal && previousVal !== '') {
                $select.val(previousVal);
            }
            
            createCustomDropdown(dropdownId, selectId, options, previousVal);
            
            $select.off('change').on('change', function() {
                calculateConversion();
            });
            
        } else {
            console.log('Tidak ada blockchain untuk:', productName);
            container.style.display = 'none';
            $('#' + selectId).empty();
            $('#' + dropdownId).empty();
        }
    }

    // ==========================================
    // CALCULATION
    // ==========================================
    function calculateConversion() {
        const amount = parseFloat($('#amount').val()) || 0;
        
        let result = amount * rate;
        let feeAmount = 0;
        let feeText = '';
        const resultValue = amount * rate;
        let isFlatFee = false;
        let flatFeeAmount = 0;
        
        const toBlockchainSelect = document.getElementById('toBlockchain');
        let blockchainFee = 0;
        if (toBlockchainSelect && toBlockchainSelect.selectedIndex > 0) {
            const selectedOption = toBlockchainSelect.options[toBlockchainSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                blockchainFee = parseFloat($(selectedOption).data('fee')) || 0;
            }
        }
        
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
            fromProductCode: fromProductCode,
            fromProductName: fromProductName,
            toProductCode: toProductCode,
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
    // EVENT LISTENERS
    // ==========================================
    $('#amount').on('input', calculateConversion);
    
    // ==========================================
    // EXCHANGE BUTTON - PAKAI GET METHOD
    // ==========================================
    $('#btnExchangeNow').on('click', function() {
        if (window.isMinimumMet === false) {
            alert('⚠️ Minimum received amount is not met. Please increase the amount.');
            return;
        }
        
        const data = window.currentTransactionData;
        if (!data || !data.fromProductCode) {
            alert('Please complete the exchange form first');
            return;
        }
        
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
        
        // Redirect dengan query string (GET method)
        const params = new URLSearchParams();
        params.append('amount', data.amount);
        params.append('from_product_code', data.fromProductCode);
        params.append('to_exc_code', data.fromProductCode + '-' + data.toProductCode);
        params.append('from_blockchain', fromBlockchain);
        params.append('to_blockchain', toBlockchain);
        params.append('rate', data.rate);
        params.append('fee_amount', data.feeAmount);
        params.append('fee_text', data.feeText);
        params.append('final_amount', data.finalAmount);
        
        const url = routeTransactionCreate + '?' + params.toString();
        window.location.href = url;
    });

    // ==========================================
    // TOGGLE BLOCKCHAIN ROW
    // ==========================================
    function toggleBlockchainRow() {
        const blockchainRow = document.getElementById('blockchainRow');
        const hasFromCrypto = (fromCategory === 'Crypto' && blockchainMap[fromProductName] && blockchainMap[fromProductName] && blockchainMap[fromProductName].length > 0);
        const hasToCrypto = (toCategory === 'Crypto' && blockchainMap[toProductName] && blockchainMap[toProductName] && blockchainMap[toProductName].length > 0);
        blockchainRow.style.display = (hasFromCrypto || hasToCrypto) ? 'flex' : 'none';
    }

    // ==========================================
    // INITIALIZE
    // ==========================================
    loadBlockchainDropdown(fromProductName, 'fromBlockchainContainer', 'fromBlockchain', 'fromBlockchainDropdown', fromCategory);
    loadBlockchainDropdown(toProductName, 'toBlockchainContainer', 'toBlockchain', 'toBlockchainDropdown', toCategory);
    toggleBlockchainRow();
    
    setTimeout(function() {
        calculateConversion();
    }, 200);
});