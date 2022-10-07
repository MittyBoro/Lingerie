
let iconImageHref = '/assets/front/img/map-point.png';

import isVisible from './libs/isVisible.js';


export default function mapStart()
{

    if ( !isVisible('#map') )
        return;


    let element = document.createElement('script');
    element.src = 'https://api-maps.yandex.ru/2.1.78/?lang=ru_RU&apikey=96e6c98f-0d65-4e46-a2fe-e42faab3160a';
    document.body.appendChild(element);
    element.onload = () => {
        yMapStart();
    }


    function yMapStart() {
        let iconImageHref = '/assets/images/svg/location.svg';

        ymaps.ready(() =>
        {
            let center = [55.158, 61.382];
            let zoom = 12;
            let myMap = new ymaps.Map("map", {
                center: center,
                zoom: zoom,
                controls: ['fullscreenControl']
            });

            addAddresses(myMap, config.mainAddress, iconImageHref);
            // addAddresses(myMap, ADDRESSES, iconImageHref);
        });



    }

    async function addAddresses(myMap, addresses, iconImageHref) {

        let myCollection = new ymaps.GeoObjectCollection();

        let idCoords = {};

        await Promise.all( addresses.map(async (address) => {
            let id = 0
            if (typeof address === 'object')     {
                id = address.id;
                address = address.address;
            }

            let coords = localStorage.getItem(address);

            if ( !coords ) {
                await ymaps.geocode(address) .then( (res) => {
                    let firstGeoObject = res.geoObjects.get(0);
                    coords = firstGeoObject.geometry.getCoordinates();
                    localStorage.setItem(address, coords);
                });
            } else {
                coords = coords.split(',')
            }

            let Mark = new ymaps.Placemark(coords,
                {
                    balloonContent: address
                },
                {
                    iconLayout: 'default#image',
                    iconImageHref: iconImageHref,
                    iconImageSize: [60, 60],
                    iconImageOffset: [-30, -60],
                    id: id,
                }
            );

            idCoords[id] = coords;
            myCollection.add(Mark);
        }))

        document.addEventListener('locationClick', el => {
            let coords = idCoords[el.detail.id]
            if (coords)
                myMap.setCenter(coords, 13);
        });

        myCollection.events.add('click', function (e) {
            let event = new CustomEvent('mapClick', {bubbles: true, detail: { id: e.get('target').options.get('id') }});
            document.dispatchEvent(event);
        });

        myMap.geoObjects.add( myCollection );
        myMap.setBounds( myCollection.getBounds(), { checkZoomRange: true, zoomMargin: [25, 0] } );


    }




}
