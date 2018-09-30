
$(document ).ready(function() {

    var previous;
    $('#delete_brand_btn').click(function (e) {
        var rs_confirm = confirm("Etes-vous sur de vouloir supprimer ?");
        if (rs_confirm != true) {
            e.preventDefault();
        }
    });
    $('.change-brand').on('focus', function () {
        // Store the current value on focus and on change
        previous = this.value ? this.value : 0;
        console.log(previous);
    }).change(function() {
        $('.list-product-' + previous).addClass('display-none');
        $('.list-product-' + this.value).removeClass('display-none');
        $('#delete_brand_btn').attr('href', '/admin/brands/delete-brand/?brand-id=' + $(this).val());
        $('#edit_brand_btn').attr('href', '/admin/brands/edit-brand/?brand-id=' + $(this).val());
        previous = this.value;
    });

    $('body').on('click', '.delete-brand', function(){


        var rs_confirm = confirm("Etes-vous sur de vouloir supprimer ?");
        if (rs_confirm == true) {

            var th = $(this);
            var keyBrand = $(this).data('brand');
            var keyProduct = $(this).data('product');
            $.ajax({
                type: "GET",
                url:'/admin/brands/delete-product/' + keyBrand + '/' + keyProduct,
                success: function (data) {
                    th.closest('tr').fadeOut();
                },
                error: function (data) {
                }
            });
        }
    });

    $('#check_valid_product_btn').on('click', function(){
        var brand_id = $('.change-brand').val();

        $('table tr.list-product-' + brand_id).each(function(){
            var this_row = $(this);
            var product_code = $(this).data('product-code');
            $.ajax({
                url: "/admin/brands/check-valid-product/" + product_code,
                dataType: 'json',
                type: 'GET'
            }).success(function(data){
                if (data == 0)
                    this_row.find('.error').html('X');
            });
        });
    });

    $('.add_description_btn').on('click', function(e){
        e.preventDefault();
        $('.descriptions').append($('.description_template').html());
    });

    $('body').on('click', '.remove_description_btn', function(e){
        e.preventDefault();

        $(this).parent().remove();
    });



    //Init Tiny MCE
    tinymce.init({
        selector: 'textarea',
        height: 500,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ],

        convert_urls : false,
    });

});
