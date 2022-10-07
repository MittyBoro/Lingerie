import Swal from 'sweetalert2'


const popupConfig = {
    showConfirmButton: false,
    showCloseButton: true,
    padding: '50px',
    didOpen: (sw) => {
        setTimeout(() => {
            const e = new CustomEvent('popup_opened', { detail: { element: sw } });
            document.dispatchEvent(e);
        }, 200)
    }
};

let popup1 = document.querySelector('.popup-1');
let popup2 = document.querySelector('.popup-2');

(async () => {

    if (!popup1)
        return;

    if (sessionStorage.getItem('showPopup'))
        return;
    sessionStorage.setItem('showPopup', true);

    await new Promise(resolve => setTimeout(resolve, 500))

    document.addEventListener('order_sent', function (e) {
        popup2 = '';
        fireSuccess();
    }, false);

    await Swal.fire({
        ...popupConfig,
        html: popup1.outerHTML,
    }).then((result) => {
        if (result.dismiss != 'backdrop' && result.dismiss != 'close')
            popup2 = ''
    })


    if (popup2) {
        Swal.fire({
            ...popupConfig,
            html: popup2.outerHTML,
        })
    }

})()

function fireSuccess() {
    Swal.fire({
        showConfirmButton: false,
        showCloseButton: true,
        padding: '50px',
        icon: 'success',
        title: 'Ваша заявка принята!',
    })
}
