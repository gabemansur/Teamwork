var taskFunctions = {
    a1: function(x) {

      return 100 * ( Math.sin( x / 30 ) + Math.pow( ( x / 300 ), 2 ) );
    },

    a2: function(x) {
      return (-10 + 100 * ( Math.sin( x / 50 ) + (Math.pow(x, 2) / 500)));
    },

    1: function(x) {
      return 40 * ( Math.sin( x / 15 ) ) + 100 * ( Math.cos( x / 60 ) ) + ( x / 10);
    },

    2: function(x) {

      return 150 - ( Math.pow( (150 - x) , 2 ) / 150 ) + 100 * ( Math.cos( x / 20 ) );
    },

    3: function(x) {
      return 10 + (x/3) - (150 * Math.pow( Math.E, -(Math.pow((x - 245) / 15, 2))));
    },

    4: function(x) {
      return 40 * ( Math.sin( (x - 20) / 15 ) ) + 100 * ( Math.cos( (x - 20) / 15 ) ) + ( x / 3);
    },

    5: function(x) {
      return 10 - (x/3) - (50 * Math.pow( Math.E, -(Math.pow((x - 50) / 15, 2)))) + (150 * Math.pow( Math.E, -(Math.pow((x - 245) / 15, 2))));
    },

    6: function(x) {
      return 100 + (50 * Math.pow( Math.E, -(Math.pow((x - 50) / 15, 2)))) + (100 * Math.pow( Math.E, -(Math.pow((x - 150) / 15, 2)))) + (150 * Math.pow( Math.E, -(Math.pow((x - 275) / 15, 2))));
    },

    7: function(x) {
      return -50 - (x/5) + (40 * Math.pow( Math.E, -(Math.pow((x - 270) / 30, 2))))
    },

    8: function(x) {
      return (x/4) + (100 * Math.pow( Math.E, -(Math.pow((x - 50) / 15, 2)))) + (50 * Math.pow( Math.E, -(Math.pow((x - 150) / 10, 2))))
      - (50 * Math.pow( Math.E, -(Math.pow((x - 250) / 30, 2)))) - (50 * Math.pow( Math.E, -(Math.pow((x - 300) / 15, 2))));
    },
};
