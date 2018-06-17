var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    .enableVersioning(Encore.isProduction())

    .createSharedEntry('js/common', ['jquery', './assets/js/common.js'])
    .addEntry('js/app', './assets/js/app.js')

    .addStyleEntry('css/app', './assets/scss/app.scss')
    .addStyleEntry('css/clean-blog', './assets/scss/startbootstrap/clean-blog.scss')

    .enableSassLoader()

    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
