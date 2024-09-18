import './styles/admin.scss';
import '@eonasdan/tempus-dominus';
import 'typeahead.js';
import $ from 'jquery';
import 'select2';
import 'select2/dist/css/select2.min.css';
import 'select2-bootstrap-theme/dist/select2-bootstrap.min.css';

$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap'
    });

    $('.select2-tags').select2({
        tags: true,
        theme: 'classic'
    });
});

// Handling the modal confirmation message.
$(document).on('submit', 'form[data-confirmation]', function (event) {
    const $form = $(this),
        $confirm = $('#confirmationModal');

    if ($confirm.data('result') !== 'yes') {
        //cancel submit event
        event.preventDefault();

        $confirm
            .off('click', '#btnYes')
            .on('click', '#btnYes', function () {
                $confirm.data('result', 'yes');
                $form.find('input[type="submit"]').attr('disabled', 'disabled');
                $form.submit();
            })
            .modal('show');
    }
});
