$(document).ready(function() {

    $('#data-table').DataTable({ "bSort" : false } );

});

var edit = {};
$(document).ready(function() {

//Category Functionality
    //Category Update
    $('.category-update').on('click', function() {

        // Edit ID
        edit.editid = $(this).data('id');

        // View id
        var viewid = $(this).data('id');

        var actionid = 'category_details';
            
            // AJAX Request
            $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { id:viewid, action:actionid },
            dataType: 'json',
            success: function(categoryImage){
                    $("#categoryImage").html("<img src='http://localhost/store/upload/category_image/"+categoryImage.category_image+"' alt='"+categoryImage.category_image+"'>");
                    $("#categoryName").val(categoryImage.category_name);
                    $("#categoryDescription").val(categoryImage.category_description);
                }
            });    

            $("#category-detail-update").on('submit', function(){
                
                var editid = edit.editid;

                var currentImage = $('#categoryImage img').attr('alt');

                var formData = new FormData(this);

                formData.append( 'id', editid);
                formData.append( 'current_image', currentImage);

                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/store/insert.php',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response) {
                        if (response == 1) {
                            window.location.reload();
                        }  
                    }

                });
            });
    });

    // Category Delete
    $('.category-delete').on('click', function() {
        var el = this;

        var deleteid = $(this).data('id');

        var action = 'category_delete';

        if (confirm('Are you sure ?') == true) {
            // AJAX Request
            $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { id:deleteid, action:action },
            success: function(response){
    
                if(response == 1){
            // Remove row from HTML Table
            $(el).closest('tr').css('background','tomato');
            $(el).closest('tr').fadeOut(800,function(){
                $(this).remove();
            });
                }
    
            }
            });
        }

    });

//Product Functionality
    //Product Update
    $('.product-update').on('click', function() {

        edit.editid = $(this).data('id');
        var viewid = $(this).data('id');
        var actionid = 'product_details';
            
            // AJAX Request
            $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { id:viewid, action:actionid },
            dataType: 'json',
            success: function(response){
                $("#productVideo").html('<input type="hidden" name="current_video" val="'+response.detail.product_video+'">');
                $("#productVideo").html('<video width="400" controls><source src="http://localhost/store/upload/product_video/'+response.detail.product_video+'" type="video/mp4"></video>');
                $('#productName').val(response.detail.product_name);
                //$('#productCategory').val(response.detail.product_category);
                $('#productSKU').val(response.detail.product_sku);
                $('#productDescription').val(response.detail.product_description);
                $('#productPrice').val(response.detail.product_price);
                $('#productQuantity').val(response.detail.product_quantity);
                $('.'+response.detail.product_status + '').prop('checked', true);
                var str = response.detail.product_category;
                const values = str.split(',');
                for(var i =0; i<values.length; i++) {
                    $('#category-checkbox input[type=checkbox][value='+ values[i] +']').prop('checked', true);
                }
                var html = [];
                for( var i =0; i<response.image.length; i++) {
                    html.push("<img src='http://localhost/store/upload/product_image/"+response.image[i]+"' alt='"+response.image[i]+"' id='"+response.detail.product_id+"'><span title='"+response.image[i]+"' id='"+response.detail.product_id+"' class='product-image-remove'>X</span>");
                }
                $("#productImage").html(html.join(''));
                }
            });
            
            $("#productImage").on('click', 'span', function(){
                var el= this;
                var editid = edit.editid;
                var action = 'single_image_delete';
                var image = $(this).attr('title');

                if (confirm('Are you sure ?') == true) {
                    $.ajax({
                        type: 'POST',
                        url: 'http://localhost/store/insert.php',
                        data: { id:editid , action:action, image:image},
                        dataType: 'json',
                        success: function() {
                           // Remove row from HTML Table
                            $(el).prev('img').remove();
                            $(el).remove();
                        }

                    });
                }

            });

            $("#product-detail-update").on('submit', function(e){
                e.preventDefault();
                
                var editid = edit.editid;

                var formData = new FormData(this);

                formData.append( 'id', editid);

                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/store/insert.php',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response) {
                        if (response == 1) {
                            window.location.reload(); 
                        }
                    }

                });
            });
    });

    //Product Delete
    $('.product-delete').on('click', function() {
        var el = this;
        var deleteid = $(this).data('id');
        var action = 'product_delete';

        if (confirm('Are you sure ?') == true) {
            // AJAX Request
            $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { id:deleteid, action:action },
            success: function(response){
    
                if(response == 1){
            // Remove row from HTML Table
            $(el).closest('tr').css('background','tomato');
            $(el).closest('tr').fadeOut(800,function(){
                $(this).remove();
            });
                }
    
            }
            });
        }
    });

    //Product Search
    $('.product-search').on('click', function() {

        var name = $('#product-search').val();

        var action = 'product_search';

        $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: {action:action, name:name},
            dataType: 'json',
            success: function(response) {
                console.log(response.cid);
                if(response.pid != null) {
                    window.location.href="single_product.php?pid="+response.pid;
                }
                if(response.cid != null) {
                    window.location.href="single_category.php?id="+response.cid;
                }
            }
        }); 

    });

//Carousel Functionality
    //Caroyusel Update
    $('.carousel-update').on('click', function() {
        edit.editid = $(this).data('id');
        var viewid = $(this).data('id');
        var actionid = 'carousel_details';
            
            // AJAX Request
            $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { id:viewid, action:actionid },
            dataType: 'json',
            success: function(carosuel){
                    $("#carouselImage").html("<img src='http://localhost/store/upload/carousel_image/"+carosuel.carousel_image+"' alt='"+carosuel.carousel_image+"'>");
                    $("#carouselLink").val(carosuel.carousel_link);
                }
            });    

            $("#carousel-detail-update").on('submit', function(){
                
                var editid = edit.editid;

                var currentImage = $('#carouselImage img').attr('alt');

                var formData = new FormData(this);

                formData.append( 'id', editid);
                formData.append( 'current_image', currentImage);

                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/store/insert.php',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response) {
                        if (response == 1) {
                            window.location.reload();
                        }  
                    }

                });
            });
    });

    //Carousel Delete
    $('.carousel-delete').on('click', function() {
        var el = this;
        var deleteid = $(this).data('id');
        var action = 'carousel_delete';

        if (confirm('Are you sure ?') == true) {
            // AJAX Request
            $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { id:deleteid, action:action },
            success: function(response){
    
                if(response == 1){
            // Remove row from HTML Table
            $(el).closest('tr').css('background','tomato');
            $(el).closest('tr').fadeOut(800,function(){
                $(this).remove();
            });
                }
    
            }
            });
        }

    });

//Frontend Functionality
    //Cart quantity Check
    $('#product-cart-quantity').on('change paste keyup', function() {

        var value = $(this).val();

        var id = $('#qtyCheck').val();

        var action = 'product_quantity_check';

        $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { value:value, id:id, action:action },
            success: function(response){
                if (response == 5) {
                    $('.warning-message').text("You have entered more value then availability!");
                    $('.warning').attr("disabled", true);
                } else {
                    $('.warning-message').text('');
                    $('.warning').attr("disabled", false);
                }
            }
        });
    });

    $('.product-cart-quantity1').on('change paste keyup', function() {

        var value = $(this).val();

        var id = $('#qtyCheck').val();

        var action = 'product_quantity_check';

        $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { value:value, id:id, action:action },
            success: function(response){
                if (response == 5) {
                    $('.warning-message1').text("You have entered more value then availability!");
                    $('.remove-link').removeAttr("href");
                    $('.warning-disable').attr("disabled", true);
                } else {
                    $('.warning-message1').text('');
                    $('.remove-link').attr("href", "product_cart.php");
                    $('.warning-disable').attr("disabled", false);
                }
            }
        });
    });

    //Cart Warning
    $('.add-to-cart').on('click', function() {
        var value = $('#product-cart-quantity').val();

        var id = $('#qtyCheck').val();

        var action = 'add_to_cart';
        $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { value:value, id:id, action:action },
            success: function(response){
            }
        });
    });

    //Cart single item delete
    $('.deleteitem').on('click', function() {

        var id = $(this).attr('id');
        var action = 'delete_from_cart';
        $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { id:id, action:action }
        });
    });

    //Cart item quantity update
    $('.update-item').on('click', function() {

        var id = $(this).parent().siblings('.update-quantity').children('#qtyCheck').val();
        var value = $(this).parent().siblings('.update-quantity').children('#product-cart-quantity1').val();
        var action = 'update_cart_item';
        $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { value:value, id:id, action:action }
        });   

    });

    //Clear cart
    $('.clear-cart').on('click', function() {
        var action = 'clear_cart';
        $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: {action:action},
            success: function(response) {
                if(response == 1) {
                    window.location.reload();
                }
            }
        }); 
    });

//Coupen Functionality
    //Coupen update
    $('.coupen-update').on('click', function() {
        edit.editid = $(this).data('id');
        var viewid = $(this).data('id');
        var actionid = 'coupen_details';
            
            // AJAX Request
            $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { id:viewid, action:actionid },
            dataType: 'json',
            success: function(coupen){
                    $("#coupenName").val(coupen.coupen_name);
                    $("#coupenDiscount").val(coupen.coupen_discount);
                }
            });    

            $("#coupen-detail-update").on('submit', function(){
                
                var editid = edit.editid
                var formData = new FormData(this);
                formData.append( 'id', editid);

                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/store/insert.php',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response) {
                        if (response == 1) {
                            window.location.reload();
                        }  
                    }

                });
            });
    });

    //Coupen Delete
    $('.coupen-delete').on('click', function() {
        var el = this;
        var deleteid = $(this).data('id');
        var action = 'coupen_delete';

        if (confirm('Are you sure ?') == true) {
            // AJAX Request
            $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: { id:deleteid, action:action },
            success: function(response){
    
                if(response == 1){
            // Remove row from HTML Table
            $(el).closest('tr').css('background','tomato');
            $(el).closest('tr').fadeOut(800,function(){
                $(this).remove();
            });
                }
    
            }
            });
        }

    });

    //Coupen Apply
    $('.coupen').on('click', function() {
        var id = $(this).data('id');
        var action = 'apply_coupen';

        $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: {id:id, action:action},
            success: function(response) {
                window.location.reload();
            }
        });
    });

    //Coupen Remove
    $('.remove').on('click', function() {
        var action = 'remove_coupen';

        $.ajax({
            url: 'http://localhost/store/insert.php',
            type: 'POST',
            data: {action:action},
            success: function() {
                window.location.reload();
            }
        });
    });

    $('.pagination-1').on('click', function() {

        var page = $(this).data('id');
        var id = $('#hidden-id').val();
        var order = $('#order').val();

        window.location.href = 'single_category.php?id='+ id +'&page=' + page +'&order=' + order;

    });

    $('#order').on('change', function() {
        var page = $('#hidden-page-id').val();
        var id = $('#hidden-id').val();
        var order = $('#order').val();

        window.location = 'single_category.php?id='+ id +'&page=' + page +'&order=' + order;

        $("order").val(order);

    });

});

