$(document).ready(function () {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


    if($('#users-table').length){
	    $("#users-table").DataTable({
            bPaginate: false,
            bLengthChange: false,
            bFilter: true,
            bInfo: false,
            bAutoWidth: false,
	    	//iDisplayLength: 100,
            columnDefs: [ {
                "targets": [0],
                "orderable": false
            } ],
            order: [[ 1, 'desc' ]],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Поиск"
            },
            /*responsive: {
                details: false
            },*/
	    });
    }

    $('.dropdown-color-status>li>a').on('click',function (e) {
        e.preventDefault();
        $(this).parent().parent().prev().removeClass('bg-box-blue bg-box-green bg-box-black bg-box-red');
        $(this).parent().parent().prev().addClass($(this).attr('class'));
    });

    //$('.btn-change-item-status').addClass($('.admin-navigate-bar>li.active').data('class'));

});