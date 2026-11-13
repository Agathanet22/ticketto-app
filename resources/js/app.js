

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

    // resources/js/app.js
    import './bootstrap'; // Ini akan mengimpor konfigurasi Bootstrap dari file bootstrap.js
    import $ from 'jquery'; // Impor jQuery
    window.$ = window.jQuery = $; // Jadikan jQuery global

    import 'bootstrap/dist/js/bootstrap.bundle'; // Impor Bootstrap JavaScript Bundle