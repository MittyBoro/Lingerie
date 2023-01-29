
export default (key, callback) => {
    if ('caches' in window) {
        caches.match(key).then(function(response) {
            if (response) {
                return response;
            }
            return callback();
        })
    } else {
        return callback();
    }
}
