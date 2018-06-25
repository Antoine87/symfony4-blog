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
    .addEntry('js/sb-admin', './assets/js/sb-admin/sb-admin.js')
    .addEntry('js/sb-admin-charts', './assets/js/sb-admin/sb-admin-charts.js')
    .addEntry('js/sb-admin-datatables', './assets/js/sb-admin/sb-admin-datatables.js')
    .addEntry('js/admin', './assets/js/admin.js')

    .addStyleEntry('css/app', './assets/scss/app.scss')
    .addStyleEntry('css/clean-blog', './assets/scss/startbootstrap/clean-blog.scss')
    .addStyleEntry('css/blog', './assets/scss/startbootstrap/blog.scss')
    .addStyleEntry('css/sb-admin', './assets/scss/startbootstrap/sb-admin.scss')
    .addStyleEntry('css/admin', './assets/scss/admin.scss')

    .enableSassLoader()

    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
