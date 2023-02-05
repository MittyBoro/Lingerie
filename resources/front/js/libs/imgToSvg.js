import getCached from './cached';

export default async (parent) => {

    let elements = Array.from( parent.querySelectorAll('img.to-svg') );

    // иначе дублируется загрузка
    for await (const image of elements) {

        await getCached(image.src)
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
    }

}
