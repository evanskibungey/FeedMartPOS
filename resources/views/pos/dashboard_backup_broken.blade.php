d-active');
                paymentNote.textContent = 'M-Pesa payment (Coming soon - will use Cash for now)';
            }
        }

        function proceedToCheckout() {
            if (cart.length === 0) return;
            
            const receiptNumber = 'RCP-' + Date.now().toString().slice(-8);
            const currentDate = new Date().toLocaleString('en-KE', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const subtotal = cart.reduce((sum, item) => sum + item.total, 0);
            const tax = subtotal * 0.16;
            const total = subtotal + tax;
            
            document.getElementById('receiptNumber').textContent = receiptNumber;
            document.getElementById('receiptDate').textContent = currentDate;
            document.getElementById('receiptPaymentMethod').textContent = selectedPaymentMethod === 'mpesa' ? 'CASH (M-Pesa Coming Soon)' : selectedPaymentMethod.toUpperCase();
            
            const receiptItems = document.getElementById('receiptItems');
            receiptItems.innerHTML = cart.map(item => `
                <tr>
                    <td class="py-2">${item.name}</td>
                    <td class="py-2 text-center">${item.quantity}</td>
                    <td class="py-2 text-right">${item.price.toFixed(2)}</td>
                    <td class="py-2 text-right font-semibold">${item.total.toFixed(2)}</td>
                </tr>
            `).join('');
            
            document.getElementById('receiptSubtotal').textContent = `KES ${subtotal.toFixed(2)}`;
            document.getElementById('receiptTax').textContent = `KES ${tax.toFixed(2)}`;
            document.getElementById('receiptTotal').textContent = `KES ${total.toFixed(2)}`;
            
            document.getElementById('receiptModal').classList.remove('hidden');
        }

        function printReceipt() {
            window.print();
        }

        function newSale() {
            cart = [];
            updateCart();
            document.getElementById('receiptModal').classList.add('hidden');
            
            selectedPaymentMethod = 'cash';
            document.getElementById('mpesaBtn').classList.remove('payment-method-active');
            document.getElementById('cashBtn').classList.add('payment-method-active');
            document.getElementById('paymentNote').textContent = 'Default: Cash selected';
            
            alert('Sale completed! Ready for next customer.');
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCart();
            selectPaymentMethod('cash');
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'F9') {
                e.preventDefault();
                if (cart.length > 0) {
                    proceedToCheckout();
                }
            }
            if (e.key === 'Escape') {
                document.getElementById('receiptModal').classList.add('hidden');
            }
            if (e.ctrlKey && e.key === 'p') {
                if (!document.getElementById('receiptModal').classList.contains('hidden')) {
                    e.preventDefault();
                    printReceipt();
                }
            }
        });
    </script>
</x-pos-app-layout>
