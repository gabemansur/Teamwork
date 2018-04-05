function instructionPaginator(callback) {
  var page_count =  1;
  $(".inst").hide();
  $("#instr_nav #back").hide();
  $("#inst_"+page_count).show();

  if(page_count > 1) $("#instr_nav #back").show();

  /*
    Handles click events for instruction navigation buttons
   */
  $('.instr_nav').click(function(event) {

    // Hide the previous instruction
    $("#inst_" + page_count).hide();

    var dir = $(this).attr('id'); // Direction the user is moving

    // Increment or decrement the page count, based on nav button clicked
    page_count = (dir == 'next') ? page_count += 1 : page_count -= 1;

    // If we've reached the end of instructions, go to redirect url


    if(page_count > $(".inst").length){

      if($(this).attr('type') == 'submit') {
        $('.instr_nav').hide();
        $("#waiting").show();
        $('form').submit();
      }
      else if(typeof(callback) === 'function') {
        callback();
      }
    }

    // Show the new instruction
    $("#inst_"+page_count).show();

    // Hide back button if we're at the start
    if(page_count <= 1){
      $("#instr_nav #back").hide();
    }

    else {
      $("#instr_nav #back").show();
    }

    event.preventDefault();
    return false;

  });

}
