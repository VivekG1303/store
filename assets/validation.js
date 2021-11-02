//Category Registration Form
$(document).ready(function() {
    $("#category-registration").validate({
        errorClass: 'error',
        rules: {
            category_name: "required",
            category_description: "required"
        },
        highlight: function(element, error) {
            $(element).removeClass(error);
        }
    });
    
    $(".category-register-button").on('click', function(){
        $("#category-registration").submit();
        return false;
    });
});

//Category Update Form
$(document).ready(function() {
    $("#category-detail-update").validate({
        errorClass: 'error',
        rules: {
            category_name: "required",
            category_description: "required"
        },
        highlight: function(element, error) {
            $(element).removeClass(error);
        }
    });
    
    $(".category-update-button").on('click', function(){
        $("#category-detail-update").submit();
        return false;
    });
});

//Product Registration Form
$(document).ready(function() {
    $("#product-registration").validate({
        errorClass: 'error',
        rules: {
            product_name: "required",
            product_category: "required",
            product_sku: "required",
            product_description: "required",
            product_price: {
                required: true,
                digits:true
            },
            product_quantity: {
                required: true,
                digits:true
            }
        },
        messages: {
            product_price: "Only digits are allowed",
            product_quantity: "Only digits are allowed"
        },
        highlight: function(element, error) {
            $(element).removeClass(error);
        }
    });
    
    $(".product-register-button").on('click', function(){
        $("#product-registration").submit();
        return false;
    });
});

//Product Update Form
$(document).ready(function() {
    $("#product-detail-update").validate({
        errorClass: 'error',
        rules: {
            product_name: "required",
            product_category: "required",
            product_sku: "required",
            product_description: "required",
            product_price: {
                required: true,
                digits:true
            },
            product_quantity: {
                required: true,
                digits:true
            }
        },
        messages: {
            product_price: "Only digits are allowed",
            product_quantity: "Only digits are allowed"
        },
        highlight: function(element, error) {
            $(element).removeClass(error);
        }
    });
    
    $(".product-update-button").on('click', function(){
        $("#product-detail-update").submit();
        return false;
    });
});