$(document).ready(function() {

    if ($('.product-card .qty')) {
        $('.product-card .qty').change(function() {
            var priceSelector = $(this).parent().parent().find('.price');
            var oldPrice = priceSelector.data('price');
            var newPrice = oldPrice * $(this).val();

            priceSelector.find('span').html(newPrice.toFixed(2));

            var weightSelector = $(this).parent().parent().find('.weight');
            var oldWeight = weightSelector.data('weight');
            var newWeight = oldWeight * $(this).val();

            weightSelector.find('span').html(newWeight.toFixed(1));

            $(this).parent().find('.hidden-weight').val(newWeight.toFixed(1));
            $(this).parent().find('.hidden-price').val(newPrice.toFixed(2));
        });
    }

});
