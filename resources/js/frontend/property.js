function hasExtension(imgVal) {
    exts = [".png", ".PNG", ".jpg",".JPG", ".jpeg", ".JPEG",  ".pjpeg",".gif", ".GIF", ".pdf", ".PDF", ".tif", ".tiff", ".TIF", ".TIFF", ".bmp", ".BMP", ".eps", ".EPS", ".raw", ".cr2", " .nef", ".orf", ".sr2"];
    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(imgVal);
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var imgObject = $(input);
            imgObject.parent().find('.tmpImage').remove();
            imgObject.parent().find('.testtmp').remove();
            if (hasExtension(imgObject.val())) {
                imgObject.parent().append('<img class="tmpImage" src="' + e.target.result + '" />');
                imgObject.parent().append('<img class="testtmp" src="' + e.target.result + '" />');
                $('.errorEdit').hide();
                imgObject.parent().find('label.error').remove();
            } else {
                imgObject.parent().append('<span class="tmpImage text text-danger">Image file is not valid</span>');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).on('change', '.files', function () {
    readURL(this);
});
$(document).on('click', '.file-upload__input', function () {
    $(this).parent().find('.files').trigger('click');
});
$(document).on('click', '.more-button', function (e) {
    $(this).next('.warningText').remove();
    totalImages = $('#stored-photos img').length + $('.new-img-area').length;
    if (totalImages == imagesLimit) {
        $(this).after('<span class="warningText text text-danger">You can upload only ' + imagesLimit + ' images</span>');
    } else {
        var value = parseInt($(".more-option:last").attr('data-value'));
        var copynumber = value + 1;
        var duplic_div = $('#more_image').html();
        html1 = _.template(duplic_div);
        $('.image-holder-col').append(html1({copynum: copynumber}));
        copynumber++;

        $('.delete-image').on('click', function (event) {
            $(this).parent('.new-img-area').remove();
        });
    }
});

$(document).ready(function () {
    // for detecting chrome browser of mac
    if (navigator.userAgent.indexOf('Mac OS X') != -1) {
        if (/chrome/.test(navigator.userAgent.toLowerCase())) { $('body').addClass('mac-chrome'); }
    } else if (navigator.appVersion.indexOf("Win") !=-1) {
        console.log('windows');
        if( navigator.userAgent.toLowerCase().indexOf('firefox') > -1 ){
            $('body').addClass('win-mozilla');
        }
    } else {
        $("body").addClass("pc");
    }
    
    $('select').select2({
        placeholder: "Please select any option"
    });

    $('#home_type').change(function () {
        $('#home_type-error').hide();
    });
    $('#beds').change(function () {
        $('#beds-error').hide();
    });
    $('#baths').change(function () {
        $('#baths-error').hide();
    });
    $('#lotsize').change(function () {
        $('#lotsize-error').hide();
    });
    $('#school_district').change(function () {
        $('#school_district-error').hide();
    });

    $("form").submit(function (e) {
        if ($('.for_agree').length > 0) {
            if ($('.for_agree').is(':checked')) {
                $('#agree-error').hide();
            } else {
                $('#agree-error').css("display", "block");
                e.preventDefault();
            }
        }
    });

    $('#agree_label').mouseup(function () {
        if ($('.for_agree').prop("checked") == true) {
            $('#agree-error').css("display", "block");
        } else if ($('.for_agree').prop("checked") == false) {
            $('#agree-error').hide();
        }
    });

    var myarray = [];
    $('.photo-store-btn').click(function () {
        myarray.push($(this).attr("data-image-id"));
        $(".property-hidden").val(myarray);
        $(this).parent('.photo_holder').remove();
    });
    $('#postal_code').keyup(function(){
        $('#county').val('').trigger('change');
        $('#state').val('');
        $('#city').val('');
        $('#county').find('option').not(':first').remove();
    });
});

google.maps.event.addDomListener(window, 'load', function () {

    if ($('#postal_code').length > 0) {
        var place_loc = document.getElementById('postal_code');
        var options = {
            componentRestrictions: { 'country': 'us' },
            'types': ['geocode']
        };
        var stateName = null;
        var countyName = null;
        var places = new google.maps.places.Autocomplete(place_loc, options);

        //    places.setComponentRestrictions({'country': ['us']});

        google.maps.event.addListener(places, 'place_changed', function () {
            $('#county').val('');
//            $('#postal_code').val('');
            $('#zip_code').val('');
            $('#state').val('');
            $('#city').val('');
            $('#townhouse').val('');
            var place = places.getPlace();
            var address = place.formatted_address;
            var street_address='';
            var route_address='';
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            var mesg = "Address: " + address;
            mesg += "\nLatitude: " + latitude;
            mesg += "\nLongitude: " + longitude;
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            $('body').append("<div id='tmpDiv'>" + place.adr_address + "</div>");
            $('#street_address').val($('#tmpDiv').find('span.street-address').text());
            $('#tmpDiv').remove();
            var address_components = place.address_components;
            $.each(address_components, function (index, component, e) {
                var types = component.types;
                $.each(types, function (index, type) {
                      if (type == 'locality') {
                    $('#city').val(component.long_name);
//                    $('#city_disabled').val(component.long_name);
                }
                    if (type == "administrative_area_level_1") {
                        $('#state').val(component.long_name);
                        stateName = component.long_name;
                        $('#state_short').val(component.short_name);
                    }
                    if (type == 'postal_code') {
                        var test = $('#zip_code').val(component.long_name);
                        
                    }
                    if (type == 'administrative_area_level_2') {
                        countyName = component.long_name;
                        //                        $('#county').val(component.long_name);
                    }
                    if (type == 'route') {
                        route_address+= component.long_name;
                    }
                    
                    if (type == 'street_number') {
                        street_address+= component.long_name;
                    }
                    if(route_address!='' && street_address!=''){
                        document.getElementById('street_address').value = street_address +" "+ route_address;
                    }
                    else if(street_address!=''){
                        document.getElementById('street_address').value = street_address;
                    }
                    else if(route_address!=''){
                        document.getElementById('street_address').value = route_address;
                    }
                    
                });
            });
            
            
            if($('#zip_code').val()===""){
                  $(".custom_zipcode").show();
//                  $("#custom_zip").removeAttr('disabled');
                  $('.old_zipcode').hide();
//                  $("#zip_code").attr('disabled','disabled');
            }
            else{
                $(".custom_zipcode").hide();
//                $("#custom_zip").attr('disabled','disabled');
                $('.old_zipcode').show();
//                $("#zip_code").removeAttr('disabled');
            }
            
             
            if($('#city').val()===""){
                  $(".custom_city").show();
//                  $("#custom_city").removeAttr('disabled');
                  $('.old_city').hide();
//                  $("#city").attr('disabled','disabled');
            }
            else{
                $(".custom_city").hide();
//                $("#city").removeAttr('disabled');
//                $("#custom_city").attr('disabled','disabled');
                $('.old_city').show();
            }
            
            // if county empty then remove class disable code
            if ($("#county").val() === "") {
                $("#county").removeClass("not-allow");
            } else if ($("#county").val() !== "") {
                $("#county").addClass("not-allow");
            }
          

            var schoolDistrict = $('#district-route-name').attr('data-district_route_name');
            $.ajax({
                type: "get",
                url: schoolDistrict,
                data: {
                    state: stateName
                },
                success: function success(response) {
                    $('#school_district').children('option').not(':first').remove();
                    $('#school_district').append(response.schoolDistrict);
                }
            });
            
            var getCounties = $('#county').attr('data-get_counties');
            $.ajax({
                type: "get",
                url: getCounties,
                data: {
                    state: stateName,
                    county: countyName
                },
                success: function success(response) {
                    $('#county').prop('disabled', false);
                    $('#county').children('option').remove();
                    $('#county').append($('<option value>Select County</option>'));
                    $.each(response.counties, function (i, item) {
                        $('#county').append($('<option>', {
                            value: item,
                            text: i
                        }));
                    });
                }
            });
            if($('#zip_code').val()===""){
           var getZipcode = $('#custom_zip').attr('data-get_counties');
            $.ajax({
                type: "get",
                url: getZipcode,
                data: {
                    state: stateName,
                },
                success: function success(response) {
                    $("#zip_code").prop('disabled',true);
                    $('#custom_zip').prop('disabled', false);
                    $('#custom_zip').children('option').remove();
                    $('#custom_zip').append($('<option value>Select Zipcode</option>'));
                    $.each(response.zipcodes, function (i, item) {
                        $('#custom_zip').append($('<option>', {
                            value: i,
                            text: i
                        }));
                    });
                }
            });
        }
          if($('#city').val()===""){
                var getCity = $('#custom_city').attr('data-get_counties');
            $.ajax({
                type: "get",
                url: getCity,
                data: {
                    state: stateName,
                },
                success: function success(response) {
                    $("#city").prop('disabled',true);
                    $('#custom_city').prop('disabled', false);
                    $('#custom_city').children('option').remove();
                    $('#custom_city').append($('<option value>Select City</option>'));
                    $.each(response.cities, function (i, item) {
                        $('#custom_city').append($('<option>', {
                            value: item,
                            text: i
                        }));
                    });
                }
            });
        }
        });
    }
});

