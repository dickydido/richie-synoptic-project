$(document).ready(function(){$(".product-card .qty")&&$(".product-card .qty").change(function(){var t=$(this).parent().parent().find(".price"),i=t.data("price")*$(this).val();t.find("span").html(i.toFixed(2));var a=$(this).parent().parent().find(".weight"),d=a.data("weight")*$(this).val();a.find("span").html(d.toFixed(1)),$(this).parent().find(".hidden-weight").val(d.toFixed(1)),$(this).parent().find(".hidden-price").val(i.toFixed(2))})});