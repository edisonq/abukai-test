(function($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });
  
  // code for the form
  $(document).ready(function(){
    $('#reset-button').click(function(){
        // $('#country').prop('selectedIndex',0);
        $('#error-area-customer').html('');
    })


    // start
    $("#save-form" ).on( "click", function handler() 
    {
      var formData = $('.form-customer').serialize();

      $('#save-form').off('click');
      $('#save-form').html('saving');     
      $('#save-form').attr('disabled','disabled');
      $('#reset-button').attr('disabled','disabled');
      $('#firstname').attr('disabled','disabled');
      $('#lastname').attr('disabled','disabled');
      $('#email').attr('disabled','disabled');
      $('#city').attr('disabled','disabled');
      $('#country').attr('disabled','disabled');
      $('#upload-picture').attr('disabled','disabled');

      $.ajax({
        url: BASEURLL+"php/customer.php",
        type: "POST",
        data: formData,
        dataType: "JSON",
        success: function (data) {
          console.log('success')
          if (data.errorStatus == false) {
            window.location.href = BASEURLL+"?email="+$('#email').val();
          }
          else   {
          //   $('.alert').alert('close');
          //   $('#show-modal-change .modal-body').prepend('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+data.errorMessage+'</div>');
          //   $('.alert').fadeOut(5000);
          //   $('#show-modal-change .modal-footer #insertallergynow').html('Continue Saving');
          }
            
        },
        error: function(e) {
          console.log(e.responseJSON)
          $('#error-area-customer').html('<div class="alert alert-danger" role="alert">'+e.responseJSON.errorMessage+'</div>');
          $('#save-form').removeAttr('disabled');
          $('#save-form').on( "click", handler);          
          $('#save-form').html('Save');
          $('#reset-button').removeAttr('disabled');
          $('#firstname').removeAttr('disabled');
          $('#lastname').removeAttr('disabled');
          $('#email').removeAttr('disabled');
          $('#city').removeAttr('disabled');
          $('#country').removeAttr('disabled');
          $('#upload-picture').removeAttr('disabled');
        },
      });
    });

    // upload picture
    $('#upload-picture-now').on('click', function handler() {
        var file_data = $('#testing-file').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        $('#upload-picture-now').html('uploading, please wait');
        $('#upload-picture-now').off('click');
        $('#upload-cancel').attr('disabled','disabled');
        $('#upload-picture-now').attr('disabled','disabled');
        // alert(form_data);                             
        $.ajax({
            url: BASEURLL+"php/upload.php", 
            dataType: 'JSON',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){
                // alert(php_script_response['errorCode']); // display response from the PHP script, if any
                if (php_script_response.errorCode === 0) {
                  // location.reload(true)
                  $('#profile-picture').html('<img src="uploaded-pictures/'+php_script_response.newFileName+'" alt="Customer Picture" class="profile-picture" />')
                  $('#uploaded-image').html('<input type="hidden" name="uploaded-image" id="uploaded-image" value="'+php_script_response.newFileName+'" />')
                  $('#uploadModal').modal('toggle')
                } else if (php_script_response.errorCode === 1 || php_script_response.errorCode === 2) {
                  $('#error-area-upload').html('<div class="alert alert-danger" role="alert">File too large</div>');
                } else if (php_script_response.errorCode === 4) {
                  $('#error-area-upload').html('<div class="alert alert-danger" role="alert">No file selected</div>');
                } else if (php_script_response.errorCode === 111 || php_script_response.errorCode === 222) {
                  $('#error-area-upload').html('<div class="alert alert-danger" role="alert">'+php_script_response.message+'</div>');
                } else {
                  $('#error-area-upload').html('<div class="alert alert-danger" role="alert">'+php_script_response.message+' <br>Error: '+php_script_response.errorCode+'</div>');
                }
                $('#upload-picture-now').html('Upload');
                $('#upload-picture-now').on( "click", handler);
                $('#upload-cancel').removeAttr('disabled');
                $('#upload-picture-now').removeAttr('disabled');        
            }
          });
    });
  
});

})($); // End of use strict

