window.addEventListener('load', function () {
    var loader = document.getElementById('page-loader');
    loader.style.display = 'none';
});

// window.addEventListener('beforeunload', function() {
//     var loader = document.getElementById('page-loader');
//     loader.style.display = 'block';
// });

function getDomainOnly (url) {
    return new URL(url).origin;
}
