
document.addEventListener('setCartCount', el => {
    document.querySelector('.cart-count').innerText = el.detail.count || 0;
})
