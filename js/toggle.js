jQuery(document).ready(function($) {
    // Hide the second location section by default
  
  if ($('#show_second_location').is(':checked')) {
      $('#practice-info-settings-2').show();
  } else {
      $('#practice-info-settings-2').hide();
  }
  
    // Toggle visibility when the checkbox is clicked
    $('#show_second_location').on('change', function() {
        if ($(this).is(':checked')) {
            $('#practice-info-settings-2').show();
        } else {
            $('#practice-info-settings-2').hide();
        }
    });
  });