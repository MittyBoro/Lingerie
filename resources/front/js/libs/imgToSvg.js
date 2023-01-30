import cacheMethod from './cacheMethod';

export default (parent) => {
    parent.querySelectorAll('img.to-svg').forEach(image => {
        cacheMethod(image.src, () => {
            fetch(image.src)
            .then(res => res.text())
            .then(data => {
                const parser = new DOMParser();
                const svg = parser.parseFromString(data, 'image/svg+xml').querySelector('svg');

                if (image.id) svg.id = image.id;
                if (image.className) svg.classList = image.classList;

                Object.keys(image.dataset).forEach(function(key) {
                    svg.dataset[key] = image.dataset[key];
                });

                image.parentNode.replaceChild(svg, image);
            })
            .catch(error => console.error(error))
        })
    })
}
