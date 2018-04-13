var Memory = class Memory {

  constructor(tests) {
    this.tests = tests;
    this.index = 0;
    //this.practiceIndex = 0;
    this.groupIndex = 0;
    this.testIndex = 0;
    //this.currentTask = 'practice';
    this.responses = {};
  }

  begin() {
    $(".memory").hide();
    $(`#memory_${this.index}_${this.testIndex}`).show();
  }

  advance() {
    $(`#memory_${this.index}_${this.testIndex}`).hide();
    this.testIndex++;
    $(`#memory_${this.index}_${this.testIndex}`).show();

    this.checkPosition();
  }

  advanceImageTest(key) {
    $(`#memory_${this.index}_${this.testIndex}`).hide();
    this.testIndex++;
    $(`#memory_${this.index}_${this.testIndex}`).show();

    this.checkPosition();
  }

  checkPosition() {
    if(this.currentTask == 'practice') {
      
    }
  }

}
