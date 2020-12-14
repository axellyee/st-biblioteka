import * as $ from 'jquery';
import 'datatables.net-bs4';

$(document).ready(function() {
    $('.dataTable').DataTable({
        "bLengthChange": false,
    });
} );