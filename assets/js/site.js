$(document).ready(function() {

    // Update price and weight of product live when qty is changed.
    if ($('.product-card .qty')) {
        $('.product-card .qty').change(function() {

            // Prevent qty number being less than 1.
            if ($(this).val() < 1) {
                $(this).val(1);
            }

            var priceSelector = $(this).parent().parent().find('.price');
            var oldPrice = priceSelector.data('price');
            var newPrice = oldPrice * $(this).val();

            priceSelector.find('span').html(newPrice.toFixed(2)); // Updates price

            var weightSelector = $(this).parent().parent().find('.weight');
            var oldWeight = weightSelector.data('weight');
            var newWeight = oldWeight * $(this).val();

            weightSelector.find('span').html(newWeight.toFixed(1)); // Updates Weight

            // Update hidden input fields as well, so values are carried through to basket.
            $(this).parent().find('.hidden-weight').val(newWeight.toFixed(1));
            $(this).parent().find('.hidden-price').val(newPrice.toFixed(2));
        });
    }

    // redirect to same page, minus any query strings.
    if ($('.redirect').length != 0) {
        window.location.href = $(location).attr("href").split('?')[0];
    }

    // Show alert when checkout button clicked.
    $('.checkout').click(function() {
        alert("Checkout doesn't exist yet.");
    });

    $('form input:submit').click(function() {
        if ($(this).parent().find('textarea').val() != '') {
            $(this).parent().find('textarea').val()
        }
    });

    // Displays error message & prevents form submission when field is empty.
    $('form').submit(function() {
        if ($(this).find('textarea').val() == '' && $(this).find('input:checkbox').not(":checked").length != 0) {
            $(this).find('.message-error').removeClass('hidden');

            return false;
        } else if (!$(this).find('.message-error').hasClass('hidden')) {
            $(this).find('.message-error').addClass('hidden');
        }
    });

});
