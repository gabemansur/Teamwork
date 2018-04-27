var Memory = class Memory {

  constructor(tests, callback) {
    this.tests = tests;
    this.blockIndex = 0;
    this.testIndex = 0;
    this.callback = callback;

    this.navTargetPosition = 0;
    this.autoNavInterval;
    this.popupTimeout;
  }

  begin() {
    $(".memory").hide();
    $(`#memory_${this.testIndex}_${this.blockIndex}`).show();
    this.initializeBlock();
  }

  advance() {

    $(`#memory_${this.testIndex}_${this.blockIndex}`).hide();
    this.blockIndex++;
    this.checkPosition();
    $(`#memory_${this.testIndex}_${this.blockIndex}`).show();
  }

  advanceImageTest(val) {
    console.log(`Saving ${val} to response_${this.testIndex}_${this.blockIndex}`);
    $(`#response_${this.testIndex}_${this.blockIndex}`).val(val)
    $(`#memory_${this.testIndex}_${this.blockIndex}`).hide();
    this.blockIndex++;
    this.checkPosition();
    $(`#memory_${this.testIndex}_${this.blockIndex}`).show();

  }

  navTarget(dir) {

    if(!dir) dir = 'next';
    $('.target-' + this.navTargetPosition).hide();
    // Increment or decrement the page count, based on nav button clicked
    this.navTargetPosition = (dir == 'next') ? this.navTargetPosition += 1 : this.navTargetPosition -= 1;

    if(this.navTargetPosition == 0) {
      $('.target-nav-back').hide();
      $('.target-nav-next').show();
    }
    else if(this.navTargetPosition == tests[this.testIndex].blocks[this.blockIndex].targets.length - 1) {
      $('.target-nav-next').hide();
      $('.target-nav-back').show();
    }

    else {
      $('.target-nav-back').show();
      $('.target-nav-next').show();
    }

    $('.target-' + this.navTargetPosition).show();

  }

  autoNavTarget() {

    $('.target-' + this.navTargetPosition).hide();
    this.navTargetPosition++;

    //  If there are no other targets
    if(this.navTargetPosition > this.tests[this.testIndex].blocks[this.blockIndex].targets.length) {
      clearInterval(this.autoNavInterval);
      this.advance();
    }
    else {
      $('.target-' + this.navTargetPosition).show();
    }
  }

  checkPosition() {
    if(this.blockIndex > this.tests[this.testIndex].blocks.length - 1) {
      if(this.testIndex + 1 > this.tests.length - 1) {
        // Do callback to redirect?
        this.callback();
        return;
      }
      else {
        this.testIndex++;
        this.blockIndex = 0;
      }
    }
    this.initializeBlock();
  }

  initializeBlock() {

    if(this.tests[this.testIndex].blocks[this.blockIndex].popup_text) {
      $("#popup-text").html(this.tests[this.testIndex].blocks[this.blockIndex].popup_text);
      this.popupTimeout = setTimeout(function(){
        $("#popup").modal();
      }, this.tests[this.testIndex].blocks[this.blockIndex].popup_display_time * 1000);
    }

    if(this.tests[this.testIndex].blocks[this.blockIndex].type == 'review') {
      this.navTargetPosition = 0;
      $('.target-nav-back').hide();
      $('.target').hide();
      $('.target-' + this.navTargetPosition).show();

      // If there is a review time per target, advance the target after that time?
      if(this.tests[this.testIndex].blocks[this.blockIndex].review_time_each) {
        this.autoNavInterval = setInterval(this.autoNavTarget.bind(this), tests[this.testIndex].blocks[this.blockIndex].review_time_each * 1000);
      }

      // If there is a review time set, advance after that time
      if(this.tests[this.testIndex].blocks[this.blockIndex].review_time) {
        var timer = $("#timer_"+this.testIndex+"_"+this.blockIndex);

        timer.html(tests[this.testIndex].blocks[this.blockIndex].review_time);
        setInterval(function(){
          var time = parseInt(timer.html()) - 1;
          timer.html(time);
        }, 1000)
        setTimeout(this.advance.bind(this), tests[this.testIndex].blocks[this.blockIndex].review_time * 1000);
      }

    }
  }

  getTaskType() {
    return this.tests[this.testIndex].task_type;
  }

  hasPopup() {
    if(this.tests[this.testIndex].blocks[this.blockIndex].popup_text) {
      clearTimeout(this.popupTimeout);
      $("#popup").modal();
      return true;
    }
    else return false;
  }

}
