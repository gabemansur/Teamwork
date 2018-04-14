var Memory = class Memory {

  constructor(tests) {
    this.tests = tests;
    this.blockIndex = 0;
    this.testIndex = 0;
    this.callback = null;

    this.navTargetPosition = 0;

  }

  begin() {
    $(".memory").hide();
    $(`#memory_${this.testIndex}_${this.blockIndex}`).show();
  }

  advance() {

    $(`#memory_${this.testIndex}_${this.blockIndex}`).hide();
    this.blockIndex++;
    this.checkPosition();
    $(`#memory_${this.testIndex}_${this.blockIndex}`).show();
  }

  advanceImageTest(val) {
    $(`#response_${this.testIndex}_${this.blockIndex}`).val(val)
    $(`#memory_${this.testIndex}_${this.blockIndex}`).hide();
    this.blockIndex++;
    this.checkPosition();
    $(`#memory_${this.testIndex}_${this.blockIndex}`).show();

    this.checkPosition();
  }

  navTarget(dir) {
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

  checkPosition() {
    if(this.blockIndex > this.tests[this.testIndex].blocks.length - 1) {
      if(this.testIndex + 1 > this.tests.length - 1) {
        // Do callback to redirect?
        console.log('END OF TESTS');
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

    if(this.tests[this.testIndex].blocks[this.blockIndex].type == 'review') {
      this.navTargetPosition = 0;
      $('.target-nav-back').hide();
      $('.target').hide();
      $('.target-' + this.navTargetPosition).show();
      if(this.tests[this.testIndex].blocks[this.blockIndex].review_time) {
        setTimeout(this.advance.bind(this), tests[this.testIndex].blocks[this.blockIndex].review_time * 1000);
      }
    }
  }

}
