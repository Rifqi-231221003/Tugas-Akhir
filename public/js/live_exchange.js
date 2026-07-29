// ==========================================
// LIVE EXCHANGE ACTIVITY JAVASCRIPT
// ==========================================

$(document).ready(function() {
    const exchangeData = window.exchangeData;
    const liveNames = window.liveNames;
    const availableProducts = window.availableProducts;

    // Build exchange rate list
    const exchangeRateList = [];
    if (exchangeData && exchangeData.length > 0) {
        exchangeData.forEach(exchange => {
            const [fromCode, toCode] = exchange.exc_code.split('-');
            const fromProduct = availableProducts.find(p => p.code === fromCode);
            const toProduct = availableProducts.find(p => p.code === toCode);
            if (fromProduct && toProduct) {
                exchangeRateList.push({
                    fromName: fromProduct.name,
                    toName: toProduct.name,
                    toCategory: toProduct.category,
                    rate: parseFloat(exchange.rate),
                    fee: parseFloat(exchange.fee),
                    feeType: exchange.fee_type
                });
            }
        });
    }

    const blockchainFees = [2.0, 3.0, 10.0];
    
    // ========== TIMESTAMP TRACKING FOR REALISTIC SEQUENTIAL TIME ==========
    let lastTimestamp = null;
    let initialBaseTime = null;
    
    function getRealisticTimestamp() {
        const now = new Date();
        
        if (!lastTimestamp) {
            // First batch of transactions: set base time between 30-90 minutes ago
            const minutesAgo = Math.floor(Math.random() * 60) + 30; // 30-90 menit lalu
            now.setMinutes(now.getMinutes() - minutesAgo);
            now.setSeconds(0);
            now.setMilliseconds(0);
            initialBaseTime = new Date(now);
            lastTimestamp = new Date(now);
        } else {
            // Subsequent transactions: add 10-30 minutes from last transaction
            const minutesLater = Math.floor(Math.random() * 20) + 10; // 10-30 menit kemudian
            now.setTime(lastTimestamp.getTime() + (minutesLater * 60 * 1000));
            now.setSeconds(0);
            now.setMilliseconds(0);
            lastTimestamp = new Date(now);
        }
        
        return new Date(now);
    }
    
    // Reset timestamp tracker when doing full update
    function resetTimestampTracker() {
        lastTimestamp = null;
        initialBaseTime = null;
    }
    
    function formatTimeOnly(date) {
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
    }
    
    function getRandomBlockchainFee() {
        return blockchainFees[Math.floor(Math.random() * blockchainFees.length)];
    }
    
    function getRandomExchangeRate() {
        if (exchangeRateList.length === 0) return null;
        return exchangeRateList[Math.floor(Math.random() * exchangeRateList.length)];
    }
    
    function getRandomName() {
        if (!liveNames || liveNames.length === 0) return 'User';
        return liveNames[Math.floor(Math.random() * liveNames.length)];
    }
    
    function calculateFinalAmount(amount, rateData) {
        const result = amount * rateData.rate;
        let feeAmount = 0;
        
        let isFlatFee = false;
        let flatFeeAmount = 0;
        
        if (rateData.toName === 'Neteller' && result < 17) {
            isFlatFee = true;
            flatFeeAmount = 0.60;
        } else if (rateData.toName === 'Skrill' && result < 40) {
            isFlatFee = true;
            flatFeeAmount = 0.60;
        } else if (rateData.toName === 'Payoneer' && result < 400) {
            isFlatFee = true;
            flatFeeAmount = 4.00;
        }
        
        if (isFlatFee) {
            feeAmount = flatFeeAmount;
        } else {
            let exchangeFeeAmount = 0;
            if (rateData.feeType === 'Percentage') {
                exchangeFeeAmount = (result * rateData.fee) / 100;
            } else {
                exchangeFeeAmount = rateData.fee;
            }
            if (rateData.toCategory === 'Crypto') {
                feeAmount = exchangeFeeAmount + getRandomBlockchainFee();
            } else {
                feeAmount = exchangeFeeAmount;
            }
        }
        
        let finalAmount = result - feeAmount;
        if (finalAmount < 0) finalAmount = 0;
        return finalAmount;
    }
    
    function generateTransaction() {
        const rateData = getRandomExchangeRate();
        if (!rateData) return null;
        
        const amount = parseFloat((Math.random() * 490 + 10).toFixed(2));
        const finalAmount = calculateFinalAmount(amount, rateData);
        const timestamp = getRealisticTimestamp();
        
        return {
            id: Math.random().toString(36).substr(2, 9),
            name: getRandomName(),
            fromProduct: rateData.fromName,
            toProduct: rateData.toName,
            amount: amount,
            finalAmount: finalAmount.toFixed(2),
            timestamp: timestamp.getTime(),
            timeStr: formatTimeOnly(timestamp)
        };
    }
    
    function generateTransactions(count) {
        // Reset timestamp tracker for fresh batch
        resetTimestampTracker();
        
        const transactions = [];
        const usedIds = new Set();
        
        for (let i = 0; i < count; i++) {
            let transaction;
            let attempts = 0;
            do {
                transaction = generateTransaction();
                attempts++;
                if (attempts > 20) break;
            } while (transaction && usedIds.has(transaction.id));
            
            if (transaction && !usedIds.has(transaction.id)) {
                usedIds.add(transaction.id);
                transactions.push(transaction);
            }
        }
        
        transactions.sort((a, b) => b.timestamp - a.timestamp);
        return transactions;
    }
    
    let currentTransactions = [];
    
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }
    
    function renderLiveExchange() {
        const container = document.getElementById('liveExchangeList');
        if (!container) return;
        
        if (currentTransactions.length === 0) {
            container.innerHTML = '<div class="text-center text-muted py-2"><i class="fas fa-spinner fa-spin"></i> Loading exchange activities...</div>';
            return;
        }
        
        const sortedTransactions = [...currentTransactions].sort((a, b) => b.timestamp - a.timestamp);
        
        let html = '';
        sortedTransactions.forEach(transaction => {
            html += `
                <div class="live-exchange-item">
                    <div class="live-exchange-user">
                        <div class="live-exchange-avatar">
                            ${escapeHtml(transaction.name.charAt(0))}
                        </div>
                        <span class="live-exchange-name">${escapeHtml(transaction.name)}</span>
                    </div>
                    <div class="live-exchange-detail">
                        exchanged ${transaction.amount.toFixed(2)} ${escapeHtml(transaction.fromProduct)} → ${transaction.finalAmount} ${escapeHtml(transaction.toProduct)}
                    </div>
                    <div class="live-exchange-amount">
                        <i class="fas fa-arrow-right me-1"></i> $${transaction.finalAmount}
                    </div>
                    <div class="live-exchange-time">
                        ${transaction.timeStr}
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }
    
    function saveToLocalStorage() {
        if (currentTransactions.length > 0) {
            localStorage.setItem('liveTransactions', JSON.stringify(currentTransactions));
            localStorage.setItem('liveTransactionsTimestamp', Date.now());
            // Also save the last timestamp state for continuity
            if (lastTimestamp) {
                localStorage.setItem('liveTransactionsLastTimestamp', lastTimestamp.getTime());
            }
        }
    }
    
    function loadFromLocalStorage() {
        const saved = localStorage.getItem('liveTransactions');
        const savedTime = localStorage.getItem('liveTransactionsTimestamp');
        const savedLastTimestamp = localStorage.getItem('liveTransactionsLastTimestamp');
        
        if (saved && savedTime) {
            const elapsed = Date.now() - parseInt(savedTime);
            if (elapsed < 60 * 60 * 1000) {
                currentTransactions = JSON.parse(saved);
                // Restore the last timestamp for continuity
                if (savedLastTimestamp) {
                    lastTimestamp = new Date(parseInt(savedLastTimestamp));
                }
                renderLiveExchange();
                return true;
            }
        }
        return false;
    }
    
    function updateLiveExchange() {
        currentTransactions = generateTransactions(7);
        renderLiveExchange();
        saveToLocalStorage();
    }
    
    function addNewTransaction() {
        // Add 1-2 new transactions
        const transactionsToAdd = Math.floor(Math.random() * 2) + 1;
        
        for (let i = 0; i < transactionsToAdd; i++) {
            const newTransaction = generateTransaction();
            if (newTransaction) {
                currentTransactions.unshift(newTransaction);
                if (currentTransactions.length > 7) {
                    currentTransactions.pop();
                }
            }
        }
        
        // Sort by timestamp (newest first)
        currentTransactions.sort((a, b) => b.timestamp - a.timestamp);
        renderLiveExchange();
        saveToLocalStorage();
    }
    
    // Initialize
    if (!loadFromLocalStorage()) {
        updateLiveExchange();
    }
    
    // Full update every 60-120 minutes (less frequent, just for refreshing data)
    const updateInterval = Math.floor(Math.random() * (7200000 - 3600000 + 1) + 3600000);
    setInterval(updateLiveExchange, updateInterval);
    
    // Add new transaction every 10-20 minutes (this ensures minimum 10 minute gap between transactions)
    const newTransactionInterval = Math.floor(Math.random() * (1200000 - 600000 + 1) + 600000);
    setInterval(addNewTransaction, newTransactionInterval);
    
    // Refresh when tab becomes active
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            const savedTime = localStorage.getItem('liveTransactionsTimestamp');
            if (savedTime) {
                const elapsed = Date.now() - parseInt(savedTime);
                if (elapsed >= 60 * 60 * 1000) {
                    updateLiveExchange();
                } else {
                    loadFromLocalStorage();
                }
            } else {
                updateLiveExchange();
            }
        }
    });
});