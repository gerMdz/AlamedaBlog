import '../styles/app.scss';
import $ from 'jquery';
import 'bootstrap';

$(document).ready(function(){
    $.ajax({
        url: `/${GLOBAL_VAR_LOCALE}/tags/activas`,
        type: 'GET',
        success: function(response) {
            // Aquí procesas los datos desde la api

            response.forEach(function(tag) {
                // Aquí insertas los tags en el html
                $("#tags").append(`
                    <li><a href='/${GLOBAL_VAR_LOCALE}/blog/index?tag=${tag}'>
                        <i class="fa fa-tag"></i> ${tag}
                    </a></li>`
                );
            });
        },
        error: function (error) {
            // Aquí manejas cualquier error que pueda ocurrir durante la solicitud
            console.log('Error: ' + error);
        }
    });
});