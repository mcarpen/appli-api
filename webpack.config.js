var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enablePostCssLoader()
    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .addEntry('app', './assets/js/app.js')
    .createSharedEntry('vendor', [
        'jquery',
        'bootstrap'
    ])
    .autoProvidejQuery()
;

// If using a CDN for assets, uncomment following code.
//if (Encore.isProduction()) {
//    Encore.setPublicPath('https://my-cool-app.com.global.prod.fastly.net');
//
//    // guarantee that the keys in manifest.json are *still* prefixed with build/
//    // (e.g. "build/dashboard.js": "https://my-cool-app.com.global.prod.fastly.net/dashboard.js")
//    Encore.setManifestKeyPrefix('build/');
//}

module.exports = Encore.getWebpackConfig();
