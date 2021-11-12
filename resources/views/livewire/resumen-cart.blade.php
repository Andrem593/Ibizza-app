<div class="ec-sb-block-content">
    <div class="ec-cart-summary-bottom">
        <div class="ec-cart-summary">
            <div>
                <span class="text-left">Total de Productos</span>
                <span class="text-right">{{ Cart::count() }}</span>
            </div>
            <div>
                <span class="text-left">Sub-Total</span>
                <span class="text-right">${{ Cart::subtotal() }}</span>
            </div>
            <div>
                <span class="text-left">IVA (12%)</span>
                <span class="text-right">${{ Cart::tax() }}</span>
            </div>
            <div class="ec-cart-summary-total">
                <span class="text-left">Ganancia Estimada</span>
                <span class="text-right">${{ number_format(Cart::total() * 0.4, 2) }}</span>
            </div>
            <div class="ec-cart-summary-total">
                <span class="text-left">Total Pagar</span>
                <span class="text-right">${{ Cart::total() }}</span>
            </div>
        </div>

    </div>
</div>
