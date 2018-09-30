(function($) {

"use strict";

//  i Check plugin
$('.i-check, .i-radio').iCheck({
    checkboxClass: 'i-check',
    radioClass: 'i-radio'
});

// price slider
$("#price-slider").ionRangeSlider({
    min: 130,
    max: 575,
    type: 'double',
    prefix: "$",
    prettify: false,
    hasGrid: false
});

$('#jqzoom').jqzoom({
    zoomType: 'standard',
    lens: true,
    preloadImages: false,
    alwaysOn: false,
    zoomWidth: 460,
    zoomHeight: 460,
    // xOffset:390,
    yOffset: 0,
    position: 'left'
});
$(".comment-show").click(function(e){
    e.preventDefault();
    $(".comment-marche").fadeToggle('slow');
});
var save_attr = "";
$(".a_product img").hover(function(){
    var attr = $(this).attr("alt");
    if(save_attr == ""){
        save_attr = attr;
        $("#"+attr).show();
    }else{
        if(save_attr != attr){
             $(".product-detail-more").hide();
             save_attr = attr;
            $("#"+attr).show();
        }
    }
    
});

$('.form-group-cc-number input').payment('formatCardNumber');
$('.form-group-cc-date input').payment('formatCardExpiry');
$('.form-group-cc-cvc input').payment('formatCardCVC');

// Register account on payment
$('#create-account-checkbox').on('ifChecked', function() {
    $('#create-account').removeClass('hide');
});

$('#create-account-checkbox').on('ifUnchecked', function() {
    $('#create-account').addClass('hide');
});

$('#shipping-address-checkbox').on('ifChecked', function() {
    $('#shipping-address').removeClass('hide');
});

$('#shipping-address-checkbox').on('ifUnchecked', function() {
    $('#shipping-address').addClass('hide');
});



$('.owl-carousel').each(function(){
  $(this).owlCarousel();
});

var mainSlider=$('#mainSlider').owlCarousel({
        "items":1,
        "loop":true,
        "autoplay":true,
        "autoplayTimeout":5000,
        "nav":true,
        // URLhashListener:true,
        autoplayHoverPause:false,
        // startPosition: 'URLHash'
    });

// Lighbox gallery
$('#popup-gallery').each(function() {
    $(this).magnificPopup({
        delegate: 'a.popup-gallery-image',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});
/******* SEARCH AUTOCOMPLETE **********/
//search appliance autocomplete
/*$("#search-autocomplete").on('click', function() {
	window.location.href ='recherche?serial='+ $('#suggest-list-ref').val() +'&manufacturer='
})*/
if ( $( ".search-form #serial" ).length ) {
	var loader = $('#loader-page')
	$( ".search-form #serial" ).autocomplete({  
			minLength: 2,
			delay: 700, // this is in milliseconds
			json: true,
			source: function( request, response ) {  
				$.ajax({  
					url: "./send-search-request-to-aswo/",  
					dataType: "json",  
					data: {  
							term: request.term  
					}, 
					close : function (event, ui) {
							if (!$("ul.ui-autocomplete").is(":visible")) {
									$("ul.ui-autocomplete").show();
							}
					}, 
					//http://127.0.0.1:8000/pieces-detachees/samsung/appareil-photo-numerique/200/58123/
					//58123geraeteid
					success: function( data ) { 
						var dataAwso = []
						$('head').append(data.suggests.css)
						console.log(data.requestinfo)
						for(var key in data.suggests) {
							//catégorie
							if(key === 'geraetetreffer') {
									for(var keyGeraetetreffer in data.suggests['geraetetreffer']) {
										dataAwso.push(
											{
												label: '<div>'+ data.suggests['geraetetreffer'][keyGeraetetreffer]['geraetebezeichnung'] +'</div>',
												value: data.suggests['geraetetreffer'][keyGeraetetreffer]['geraeteid'],
												type: 'geraetetreffer'
											}
										)
									}
							}
							if(key === 'geraetearten') {
									for(var keyGeraetearten in data.suggests['geraetearten']) {
											dataAwso.push({label: data.suggests['geraetearten'][keyGeraetearten]['geraeteart'], value: data.suggests['geraetearten'][keyGeraetearten]['warensort']})
									}
							}
							if(key === 'vgruppentreffer') {
									for(var keyVgruppentreffer in data.suggests['vgruppentreffer']) {
											dataAwso.push({label: data.suggests['vgruppentreffer'][keyVgruppentreffer]['vgruppenname'], value: data.suggests['vgruppentreffer'][keyVgruppentreffer]['vgruppenid']})
									}
							}
							// Fiche produits
							if(key === 'artikeltreffer') {
									for(var keyArtikeltreffer in data.suggests['artikeltreffer']) {
										dataAwso.push(
											{
												label: data.suggests['artikeltreffer'][keyArtikeltreffer]['artikelbezeichnung'], 
												value: data.suggests['artikeltreffer'][keyArtikeltreffer]['artikelnummer'],
												type: 'artikeltreffer'
											}
										)
									}
							}
					  }
						//console.log(dataAwso)
						response( $.map( dataAwso, function( result ) {  
							//console.log(data)
							return {  
									label: result.label,  
									value: result.value,
									type: result.type  
							} 
						}));  
			    } 
	      });  
		},
		select: function( event, ui ) {
			loader.show()
			var hostName = window.location.hostname
			if(ui.item.type === 'artikeltreffer') {
				window.location.href ='./telecommande/lg/'+ ui.item.value +'/composants-electriques/3000000000/details';
			}
			if(ui.item.type === 'geraetetreffer') {
				window.location.href = './recherche/'+ ui.item.value;
			}
		}  
	}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {  
			//console.log(item)
			return $( "<li></li>" )  
					.data( "item.autocomplete", item )  
					.append( item.label )  
					.appendTo( ul );  
	}; 
}

/******* END SEARCH AUTOCOMPLETE **********/
// Lighbox image
$('.popup-image').magnificPopup({
    type: 'image'
});

// Lighbox text
$('.popup-text').magnificPopup({
    removalDelay: 500,
    closeBtnInside: true,
    callbacks: {
        beforeOpen: function() {
            this.st.mainClass = this.st.el.attr('data-effect');
        }
    },
    midClick: true
});



$(".product-page-qty-plus").on('click', function() {
    var currentVal = parseInt($(this).prev(".product-page-qty-input").val(), 10);

    if (!currentVal || currentVal === "" || currentVal == "NaN") currentVal = 0;

    $(this).prev(".product-page-qty-input").val(currentVal + 1);
});

$(".product-page-qty-minus").on('click', function() {
    var currentVal = parseInt($(this).next(".product-page-qty-input").val(), 10);
    if (currentVal == "NaN") currentVal = 1;
    if (currentVal > 1) {
        $(this).next(".product-page-qty-input").val(currentVal - 1);
    }
});

$(".nav-justified a").click(function(e){
    $(".nav-justified .active").toggleClass("active");
    $(this).addClass('active');
    e.preventDefault();
    // $('#mainSlider').trigger('owl.jumpTo', $(this).attr('data-page'));
    mainSlider.trigger('to.owl.carousel', [$(this).attr('data-page'), 500, true]);
    // mainSlider.goTo()
});

$('.show_pop_up_PV, .hide_pop_up_PV').on('click', function() {
    $('.pop_up_PV').slideToggle();
    return false;
});

$('.back-top').on('click', function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
});

var hight_parent = $('.dropdown.yamm-fw .dropdown-menu').height();
$(".dropdown.yamm-fw > ul >li").hover(function(){
        $(this).closest('.dropdown-menu').removeAttr('style');
        var hight_child = $(this).children('.dropdown-menu-category-section').height();
        var hight_sub_child = $(this).find('.dropdown-menu-category-section ul li:first-child > ul').outerHeight();
        $(this).find('.dropdown-menu-category-section ul li:first-child').addClass('f-active');
        if (hight_sub_child) {
            if (hight_sub_child>hight_child) hight_child = hight_sub_child;
        }
        hight_parent = $(this).closest('.dropdown-menu').height();
        if (hight_child > hight_parent) {
            $(this).closest('.dropdown-menu').height(hight_child);
        }
    }, function(){
        $(this).closest('.dropdown-menu').removeAttr('style');
});

$(".dropdown.yamm-fw .sub-menu-lv2 >li").hover(function(){
        $(this).closest('.dropdown-menu').removeAttr('style');
        $(this).siblings().removeClass('f-active');
        var hight_child = $(this).children('.sub-menu-lv3').outerHeight();
        hight_parent = $(this).closest('.dropdown-menu').height();
        if (hight_child > hight_parent) {
            $(this).closest('.dropdown-menu').height(hight_child);
        }
    }, function(){
        $(this).closest('.dropdown-menu').removeAttr('style');
        $(this).parent().children('li:first-child').addClass('f-active');
        var hight_sub_child = $(this).parent().children('li:first-child').children('ul').outerHeight();
        console.log(hight_sub_child);
        hight_parent = $(this).closest('.dropdown-menu-category-section-inner').height();
         if (hight_sub_child) {
            if (hight_sub_child>hight_parent) hight_parent = hight_sub_child;
        }
        $(this).closest('.dropdown-menu').height(hight_parent);
});

$('#search-pv').on('keyup', function(){

    var search_text = $(this).val().toLowerCase();

    $('.compatibility-tab-pv-list li').each(function(){
        $(this).show();
    });

    $('.compatibility-tab-pv-list li').each(function(){
        var cur_text_1 = $(this).find('.spare__final_product_list__final_product_type_name').html();
        var cur_text_2 = $(this).find('.manufacturer').html();
        var cur_text_3 = $(this).find('.spare__final_product_list__final_product_name').html();
        var cur_text = cur_text_1 + cur_text_2 + cur_text_3;

        if (cur_text.toLowerCase().indexOf(search_text) < 0)
            $(this).hide();
    });
});

})(jQuery);

var productList = document.querySelectorAll('.best_seller_PV_content .product_list .call_external_system');

if(productList.length > 0){
    var total = productList.length;
    var x, pImg, pLink;

    for(x=0;x<total;x++){
        pImg = productList[x].querySelector('span.item_visual img') ? productList[x].querySelector('span.item_visual img').getAttribute('src') : null;
        pLink = productList[x].querySelector('span.item_visual').getAttribute('data-link');

        if(pLink){
            productList[x].querySelector('span.item_visual').addEventListener('click',function(){
                document.location.href = this.getAttribute('data-link');
            });
            productList[x].addEventListener('click',function(){
                document.location.href = this.querySelector('span.item_visual').getAttribute('data-link');
            });
        }

        if(pImg){
            productList[x].querySelector('span.item_visual').style.background = 'url("'+pImg+'") no-repeat center center/contain';
        }
    }
}

var cart = document.querySelectorAll('.cart .cart-products ul');

if(cart.length > 0){
    var total = cart.length;
    var x, qty;

    for(x=0;x<total;x++){
        
    }
}

var cartPromo = document.querySelector('.cart .cart-details a');

if(cartPromo){
    var showPromo = false;
    var promoBtn = cartPromo.parentNode.querySelector('button');

    cartPromo.addEventListener('click',function(e){
        e.preventDefault();
        this.parentNode.querySelector('fieldset').style.display = showPromo ? 'none' : 'block';
        showPromo = !showPromo;
    });

    promoBtn.addEventListener('click',function(e){
        e.preventDefault();

        this.parentNode.querySelector('p').style.display = 'block';
        setTimeout(function(){
            promoBtn.parentNode.querySelector('p').style.display = 'none';
        },4000);

        return false;
    });
}

var chartShipping = document.querySelectorAll('.cart .cart-shipping ul li input[type="radio"]');

if(chartShipping.length > 0){
    var total = chartShipping.length;
    var x, cRedirect;

    for(x=0;x<total;x++){
        chartShipping[x].addEventListener('change',function(){
            cRedirect = this.getAttribute('data-redirect') ? this.getAttribute('data-redirect') : 2 ;
            document.location = '/panier/shipping?id=' + this.value + '&redirect=' + cRedirect;
        });
    }
}

var  ajaxShipping = document.querySelectorAll('.checkout .row .shipping .shipping-select ul li input');

if(ajaxShipping.length > 0){
    var total = ajaxShipping.length;
    var countrySelect = 0;
    var shippingType = ajaxShipping[0].checked ? 1 : 2;
    var x, cRedirect,cShipping,cTotal;

    for(x=0;x<total;x++){
        ajaxShipping[x].addEventListener('change',function(){
            shippingType = this.value;

            this.parentNode.parentNode.querySelectorAll('li')[0].className = this.value == 1 ? 'active' : '';
            this.parentNode.parentNode.querySelectorAll('li')[1].className = this.value == 2 ? 'active' : '';
            
            cTotal = parseFloat(this.ownerDocument.querySelectorAll('.checkout .row .totals ul li')[2].getAttribute('data-value'));    

            totals[1].querySelector('span').innerText = countrySelect == 0 ? this.parentNode.getAttribute('data-value') + '€' : (parseFloat(this.parentNode.getAttribute('data-value')) + 2).toFixed(2) + '€';
            totals[2].querySelector('span').innerText = countrySelect == 0 ? (parseFloat(this.parentNode.getAttribute('data-value')) + cTotal).toFixed(2) + '€' : (parseFloat(this.parentNode.getAttribute('data-value')) + 2 + cTotal).toFixed(2) + '€';

            httpRequest('GET','','/panier/shipping?id='+shippingType,function(){

            });
               
        });
    }
}

var shippingAddress = document.querySelector('.checkout .row .billing ul li input[type="checkbox"]');

if(shippingAddress){
    shippingAddress.addEventListener('change',function(){
        this.parentNode.parentNode.parentNode.querySelector('ul.shipping-address').style.display = this.checked ? 'none' : 'block';
        this.ownerDocument.querySelector('.checkout .row .shipping').style.minHeight = this.ownerDocument.querySelector('.checkout .row .billing').offsetHeight + 'px';
    });
}

var countryShipping = document.querySelector('.checkout .row .billing ul li select');
var totals = document.querySelectorAll('.checkout .row .totals ul li');

if(countryShipping && totals.length > 0){


    countryShipping.addEventListener('change',function(){
        countrySelect = this.selectedIndex;
        
        ajaxShipping[0].parentNode.querySelector('span').innerText = countrySelect == 0 ? parseFloat(ajaxShipping[0].parentNode.getAttribute('data-value')).toFixed(2) : (parseFloat(ajaxShipping[0].parentNode.getAttribute('data-value')) + 2).toFixed(2);
        ajaxShipping[1].parentNode.querySelector('span').innerText = countrySelect == 0 ? parseFloat(ajaxShipping[1].parentNode.getAttribute('data-value')).toFixed(2) : (parseFloat(ajaxShipping[1].parentNode.getAttribute('data-value')) + 2).toFixed(2);
        
        totals[1].querySelector('span').innerText = countrySelect == 0 ? parseFloat(ajaxShipping[shippingType-1].parentNode.getAttribute('data-value')).toFixed(2) + '€' : (parseFloat(ajaxShipping[shippingType-1].parentNode.getAttribute('data-value')) + 2).toFixed(2) + '€';
        totals[2].querySelector('span').innerText = countrySelect == 0 ? (parseFloat(totals[2].getAttribute('data-value')) + parseFloat(ajaxShipping[shippingType-1].parentNode.getAttribute('data-value'))).toFixed(2) + '€' : (parseFloat(totals[2].getAttribute('data-value')) + parseFloat(ajaxShipping[shippingType-1].parentNode.getAttribute('data-value')) + 2).toFixed(2) + '€';
    });
}

var paymentSelect = document.querySelectorAll('.checkout .row .shipping .payment input[type="radio"]');

if(paymentSelect.length > 0){
    var total = paymentSelect.length;
    var x;

    for(x=0;x<total;x++){
        paymentSelect[x].addEventListener('change',function(){
            this.parentNode.parentNode.parentNode.querySelector('strong em').innerText = this.parentNode.querySelector('label').innerText;
            paymentSelect[2].parentNode.querySelector('div').style.display = this == paymentSelect[2] ? 'block' : 'none';
            paymentSelect[3].parentNode.querySelector('div').style.display = this == paymentSelect[3] ? 'block' : 'none';
        });
    }
}

var promo = document.querySelector('.checkout .row .promo');

if(promo){
    var promoSelect = promo.querySelector('input');
    var promoBtn = promo.querySelector('fieldset button');

    promoSelect.addEventListener('change',function(){
        this.parentNode.querySelector('fieldset').style.display = this.checked ? 'block' : 'none' ;
    });

    promoBtn.addEventListener('click',function(e){
        e.preventDefault();
        this.parentNode.querySelector('p').style.display = 'block';
        setTimeout(function(){
            promoBtn.parentNode.querySelector('p').style.display = 'none';
        },4000);
    });
}

var checkoutBtn = document.querySelector('.checkout .row .order button');

if(checkoutBtn){
    var billingInfo = document.querySelector('.checkout .row .billing ul').querySelectorAll('li input[type="text"]');
    var shippingInfo = document.querySelector('.checkout .row .billing ul:last-child').querySelectorAll('li input[type="text"]');


    checkoutBtn.addEventListener('click',function(e){
        e.preventDefault();

        var total = billingInfo.length;
        var total2 = shippingInfo.length;
        var valid = true;
        var x;

        for(x=0;x<total;x++){
            if(billingInfo[x].value == '' && billingInfo[x].required){
                billingInfo[x].parentNode.className = 'error';
                
                if(valid){
                    valid = !valid;
                }
            }else if(billingInfo[x].name != 'billing2'){
                billingInfo[x].parentNode.className = '';
            }
        }

        if(shippingAddress.checked){
            var y;

            for(y=0;y<total2;y++){
                if(shippingInfo[y].value == '' && shippingInfo[y].required){
                    shippingInfo[y].parentNode.className = 'error';
                    if(valid){
                        valid = !valid;
                    }
                }else{
                    shippingInfo[y].parentNode.className = '';
                }
            }
        }

        if(valid){
            var conditions = this.ownerDocument.querySelector('input[name="conditions"]');
            console.log(conditions.checked);
            if(conditions.checked){
                this.ownerDocument.querySelector('form[name="checkout"]').submit();  
                conditions.parentNode.querySelector('span').style.display = 'none';
            }else{

                conditions.parentNode.querySelector('span').style.display = 'block';
            }
        }
        return false;
    });
}

var checkoutQty = document.querySelectorAll('.checkout .row .products ul li select');

if(checkoutQty.length > 0){
    var total = checkoutQty.length;
    var x, cId;

    for(x=0;x<total;x++){
        checkoutQty[x].addEventListener('change',function(){
           cId = this.parentNode.parentNode.querySelector('input[name="id"]');
           
           if(cId){
                document.location = '/panier/reactualiser?rowId='+cId.value+'&qty='+this.value+'&redirect=2';
           } 
        });
    }
}

var searchCategories = document.querySelectorAll('.search_categories_content ul li a');

if(searchCategories.length > 0){
    var total = searchCategories.length;
    var url = document.location.href;
    var x;

    for(x=0;x<total;x++){
        if(searchCategories[x].getAttribute('href') == url){
            searchCategories[x].parentNode.className = 'active';
            searchCategories[x].parentNode.parentNode.insertBefore(searchCategories[x].parentNode,searchCategories[0].parentNode);
        }
    }
}

var moreLink = document.querySelector('.row.white a');

if(moreLink){
    var moreStatus = false;

    moreLink.addEventListener('click',function(e){
        e.preventDefault();
        this.parentNode.parentNode.querySelector('p.more-content').style.display = moreStatus ? '' : 'block';
        this.querySelector('span').innerText = moreStatus ? 'Voir plus' : 'Cacher';
        this.querySelector('i').className = moreStatus ? 'fa fa-angle-down' : 'fa fa-angle-up';
        moreStatus = !moreStatus;
    });
}

var brands = document.querySelectorAll('.brands .brand-slider .brand');

if(brands.length > 0){
    resizeBrands(brands);
}

var reference = document.querySelector('.reference');

if(reference){
    var refThumbs = reference.querySelectorAll('.reference .row div');
    var ref = reference.querySelectorAll('.reference-dynamic .ref');
    var refTitle = document.querySelector('.reference-text strong');

    if(ref.length == refThumbs.length){
        var refPosition = 0;
        var x, rId, rTitle;

        for(x=0;x<refThumbs.length;x++){
            refThumbs[x].addEventListener('mouseover',function(){
                rId = this.getAttribute('data-index');
                rTitle = this.getAttribute('data-title');

                if(rTitle){
                    refTitle.innerText = rTitle;
                }
                
                if(rId){
                    Array.from(ref).forEach(function(currentValue, index){
                        //console.log(index);
                        currentValue.style.display = rId == index ? 'block' : '';
                        
                    });
                }
            });
        }

        ref[refPosition].style.display = 'block';
    }
}

var searchBtn = document.querySelector('.search-main a');

if(searchBtn){
    var searchHidden = document.querySelector('.search-hidden');
    var showSearch = false;

    searchBtn.addEventListener('click',function(e){
        e.preventDefault();
        this.querySelector('i').className = showSearch ? 'fa fa-plus' : 'fa fa-minus';
        searchHidden.style.display = showSearch ? 'none' : 'block';
        showSearch = !showSearch;
    });
}

var contact = document.querySelector('.contact .form');

if(contact){
    var form = contact.querySelector('form');

    if(form){
        form.addEventListener('submit',function(e){
            e.preventDefault();

            var reference = this.querySelector('input[name="reference"]');
            var brand = this.querySelector('input[name="brand"]');
            var type = this.querySelector('input[name="type"]');
            var message = this.querySelector('textarea[name="message"]');
            var email = this.querySelector('input[name="email"]');
            var phone = this.querySelector('input[name="phone"]');
            var dataString = '';
            var valid = true;

            if(reference.value == ''){
                reference.className = 'error';
                valid = false;
            }else{
                dataString += 'reference='+ reference.value
            }

            if(brand.value == ''){
                brand.className = 'error';
                valid = false;
            }else{
                dataString += '&brand='+ brand.value
            }

            if(type.value == ''){
                type.className = 'error';
                valid = false;
            }else{
                dataString += '&type='+ type.value
            }

            if(message.value == ''){
                message.className = 'error';
                valid = false;
            }else{
                dataString += '&message='+ message.value
            }

            if(email.value == ''){
                email.className = 'error';
                valid = false;
            }else{
                dataString += '&email='+ email.value
            }

            if(phone.value == ''){
                phone.className = 'error';
                valid = false;
            }else{
                dataString += '&phone='+ phone.value
            }

            if(valid){
                var response = grecaptcha.getResponse();

                dataString += '&_token=' + this.querySelector('input[name="_token"]').value;
                
                if(response.length == 0){
                    this.querySelector('p.error').style.display = 'block';
                }else{
                    httpRequest('post',dataString,'/contact/process',function(r){
                        var response = JSON.parse(r) ? JSON.parse(r) : null;

                        if(response && response.success){
                            form.parentNode.querySelector('p').style.display = 'none';
                            form.style.display = 'none';
                            form.parentNode.querySelector('.form-success').style.display = 'block';
                        }else{
                            alert('There was an error, please contact us!');
                        }
                    });
                    this.querySelector('p.error').style.display = 'none';
                }
            }


            return false;
        });
    }
}

var brandProducts = document.querySelectorAll('.reference-brandProd .brandProd');

if(brandProducts.length > 0){
    var total = brandProducts.length;
    var minHeight = 0;
    var x, bImg;

    for(x=0;x<total;x++){
        bImg = brandProducts[x].querySelector('div img');

        if(bImg){
            brandProducts[x].querySelector('div').style.background = 'url("'+bImg.getAttribute('src')+'") no-repeat center center/contain';
        }

        if(brandProducts[x].offsetHeight > minHeight){
            minHeight = brandProducts[x].offsetHeight;
        }
    }

    for(x=0;x<total;x++){
        brandProducts[x].style.minHeight = minHeight + 'px';
    }

}


function validateContactField(_element){
   _element.className = _element.value == '' ? 'error' : '';
}

function resizeBrands(_brands){
    var total = _brands.length;
    var parentWidth = _brands[0].parentNode.parentNode.offsetWidth;
    var thumbWidth = window.innerWidth > 600 ? parentWidth / 7 : parentWidth / 3;
    var containerWidth = (thumbWidth * total);
    var bPosition = 0;
    var x;

    _brands[0].parentNode.style.width = containerWidth + 'px';

    for(x=0;x<total;x++){
        _brands[x].style.width = thumbWidth+'px';
    }

    var dotsContainer = _brands[0].ownerDocument.querySelector('.brand-dots ul');
    
    if(dotsContainer){
        var dots = Math.ceil(containerWidth / parentWidth);
        var y;
        //console.log(dots);
        for(y=0;y<(dots);y++){
            var dot = document.createElement('li');

            dot.className = y == 0 ? 'active' : '';

            dot.addEventListener('click',function(){
                var li = this;

                Array.from(this.parentNode.children).forEach(function(currentValue, index, arra){
                    currentValue.className = '';
                    
                    if(li == li.parentNode.children[index]){
                        bPosition = index;
                        _brands[0].parentNode.style.marginLeft = '-' + (parentWidth * index) + 'px';
                    }
                });

                clearInterval(autoSlide);

                autoSlide = setInterval(function(){
                    document.querySelectorAll('.brand-dots ul li')[bPosition].className = '';
                    bPosition = bPosition + 1 < (dots) ? bPosition + 1 : 0;
                    document.querySelectorAll('.brand-dots ul li')[bPosition].className = 'active';
                    _brands[0].parentNode.style.marginLeft = bPosition > 0 ? '-' + (parentWidth * bPosition) + 'px' : 0;
                },4000);

                this.className = 'active';
            });

            dotsContainer.appendChild(dot);
        }

        if(total > 0){
            var autoSlide = setInterval(function(){
                document.querySelectorAll('.brand-dots ul li')[bPosition].className = '';
                bPosition = bPosition + 1 < (dots) ? bPosition + 1 : 0;
                document.querySelectorAll('.brand-dots ul li')[bPosition].className = 'active';
                _brands[0].parentNode.style.marginLeft = bPosition > 0 ? '-' + (parentWidth * bPosition) + 'px' : 0;
                
            },4000);
        }

    }

}

function validateField(_e){
   _e.parentNode.className = _e.value == '' ? 'error' : '';
}

function httpRequest(_t,_d,_e,_c){
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function(){
        if(xhttp.readyState == 4 && xhttp.status == 200){
            _c(xhttp.response);
        }
    };
  
    xhttp.open(_t,_e,true);
    
    if(_t=='post'){
        xhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    };

    xhttp.send(_d);
}