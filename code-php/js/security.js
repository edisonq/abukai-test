(function($) {
    "use strict"; // Start of use strict

    let country = prompt("Please input country for security purpose", "country");

    if (country == null || country == "") {
        window.location.href = BASEURLL;
    } else {
        var form_data = {
            "email": emailGet,
            "country": country
        };
        $.ajax({
            url: BASEURLL+"php/security.php", 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            processData: false,
            data: $.param(form_data),
            type: 'post',
            success: function(php_script_response){
                // alert(php_script_response['errorCode']); // display response from the PHP script, if any
                console.log(php_script_response)
                location.reload();
            }, error: function(e) {
                alert('Now Allowed please input correct country')
            }
          });
    }
})($); // End of use strict