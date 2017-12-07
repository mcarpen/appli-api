var $ = require('jquery');

require('../scss/app.scss');
//require('bootstrap-sass');

// or you can include specific pieces
require('bootstrap/js/src/tooltip');
require('bootstrap/js/src/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});