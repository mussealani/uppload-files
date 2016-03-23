var storage = (function() {


    function write(key, value) {
        var json = JSON.stringify(value);
        return localStorage.setItem(key, json);
    };

    function read(key) {
        var results = localStorage.getItem(key);
        return JSON.parse(results);
    };

    function remove(key) {
        return localStorage.removeItem(key);
    };

    return {
        localStorage: localStorage,
        write: write,
        read: read,
        remove: remove
    }

})();
