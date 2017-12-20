(function ($) {
    $(document).ready(function() {



        var $wrapper = $('.js-task-form-wrapper');


        $wrapper.on('click', '.js-remove-task', function(e) {
            e.preventDefault();
            $(this).closest('.js-task-form-item')
                .fadeOut()
                .remove();
        });


        $wrapper.on('click', '.js-task-item-add', function(e) {
            e.preventDefault();
            // Get the data-prototype explained earlier
            var prototype = $wrapper.data('prototype');
            // get the new index
            var index = $wrapper.data('index');
            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            var newForm = prototype.replace(/__name__/g, index);
            // increase the index with one for the next item
            $wrapper.data('index', index + 1);
            // Display the form in the page before the "new" link
            $(this).before(newForm);
        });


        $('.budgetfield').change(function (e) {

            e.preventDefault();
            var $total= 0;

            var $budgetrequested = parseFloat($('#app_bundle_pidform_budgetrequested').val());
            if (!$.isNumeric($budgetrequested))
            {
                $budgetrequested =  parseFloat($('#app_bundle_pidform_budgetrequested').attr('placeholder'));
            };


            var $budgetallocated = parseFloat($('#app_bundle_pidform_budgetallocated').val());
            if (!$.isNumeric($budgetallocated))
            {
                $budgetallocated =  parseFloat($('#app_bundle_pidform_budgetallocated').attr('placeholder'));
            };

            var $budgetspent = parseFloat($('#app_bundle_pidform_budgetspent').val());
            if (!$.isNumeric($budgetspent))
            {
                $budgetspent =  parseFloat($('#app_bundle_pidform_budgetspent').attr('placeholder'));
            };





            $total = $budgetrequested - $budgetallocated - $budgetspent;
            $('#app_bundle_pidform_remainingamount').val($total);




        });





    });
})(jQuery);