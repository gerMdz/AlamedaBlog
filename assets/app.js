import './styles/app.scss';

// loads the Bootstrap jQuery plugins
// import 'bootstrap-sass/assets/javascripts/bootstrap/transition.js';
import 'bootstrap/js/dist/alert';
import 'bootstrap/js/dist/collapse';
import 'bootstrap/js/dist/dropdown';
import 'bootstrap/js/dist/modal';
// import 'jquery'
// const $ = require('jquery');
import $ from 'jquery';
require('bootstrap');
// loads the code syntax highlighting library
import './js/highlight.js';

// start the Stimulus application
import './stimulus-bridge';

$(document).ready(function() {
    console.log('wpack-hello')
});
