let mix = require("laravel-mix");



mix.styles(
    [
        "resources/plugins/admin-lte/css/adminlte.min.css",
        "resources/plugins/datatables/media/css/jquery.dataTables.min.css",        
        "resources/plugins/fontawesome/css/all.min.css",
        "resources/plugins/sweetalert2/sweetalert2.min.css",
    ],
    "public/assets/css/app.min.css"
);


mix.autoload({
    jquery: ["$", "window.jQuery", "jQuery"],
});
mix.js( 
    [    
       
        "resources/plugins/sweetalert2/sweetalert2.min.js",
        "resources/plugins/admin-lte/js/adminlte.min.js",
        "resources/plugins/datatables/media/js/jquery.dataTables.min.js",
    ],
    "public/assets/js/app.min.js"
);
