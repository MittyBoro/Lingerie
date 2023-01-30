
document.addEventListener('setCartCount', e => {
    document.querySelector('.cart-count').innerText = e.detail.count || 0;
})
