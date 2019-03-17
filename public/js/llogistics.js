$(document).ready(function() {
    $('input[data-number="number"]').on('keyup', function (e) {
        this.value = this.value.replace(/[^0-9]/, '')
    });

    $('[data-datepicker]').datepicker({
        format : 'dd/mm/yyyy'
    });

    $('input[name="departed"]').on('change', function () {
        var value = $(this).val();
        var arrived = $('input[name="arrived"]');
        var arrivedDate = arrived.val();

        arrived.datepicker('setStartDate', value);
        if(arrivedDate < value){
            arrived.val('');
        }
    });

    if($('[data-datepicker]').data('value') != undefined) {
        $('[data-datepicker]').datepicker('setDate', $('[data-datepicker]').data('value'));
    } else if($('[data-datepicker]').data('set-default')) {
        $('[data-datepicker]').datepicker('setDate', new Date());
    }

    $('#addCostsButton').on('click', function () {
        if($('.costsList').html().trim().length > 0) {
            $('.costsListHidden').find('.costsSeparator').show();
        }

        let cost = $('.costsListHidden').html(),
            costID = $('.costsListHidden').data('count');
        $('.costsListHidden').data('count', costID + 1);

        $('.noCostsTitle').hide();
        cost = cost.replace(/costsID/g, costID);
        $('.costsList').show().append(cost);

        deleteCost();
    });

    let deleteCost = function () {
        $('.delete-cost').on('click', function () {
            let id = $(this).data('id');

            $.get($(this).data('url'));

            $('div.costItem[data-id="' + id +'"]').remove();

            if($('.costsList').html().trim().length == 0) {
                $('.noCostsTitle').hide().show();
            }

            $('.costItem').first().find('.costsSeparator').hide();
        });
    };

    deleteCost();

    $('select[name="driver"]').change(function () {
        $.get('/ajaxGetDriverTruck/' + $(this).val(), function (response) {
            $('select[name="truck"]').val(response).multiselect('refresh');
            $.get('/ajaxGetTruckTrailer/' + $('select[name="truck"]').val(), function (response) {
                $('select[name="trailer"]').val(response).multiselect('refresh');
            });

        });
    });

    $('select[name="truck"]').change(function () {
        $.get('/ajaxGetTruckTrailer/' + $(this).val(), function (response) {
            $('select[name="trailer"]').val(response).multiselect('refresh');
        });
    });
});