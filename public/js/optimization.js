var taskFunctions = {
    a: function(x) {

      return 100 * ( Math.sin( x / 30 ) + Math.pow( ( x / 300 ), 2 ) );
    },

    b: function(x) {
      return 40 * ( Math.sin( x / 30 ) ) + 100 * ( Math.cos( x / 60 ) ) + ( x / 5);
    },

    c: function(x) {

      return -1 * ( Math.pow( (150 - x) , 2 ) / 150 );
    },

    d: function(x) {
      return 150 - ( (1 / 150) * (Math.pow(150 - x, 2)) ) + (100 * Math.cos( x / 20));
      return 150 - ( ( Math.pow(150 - x), 2 ) / 150 ) + ( 100 * Math.cos( x / 20 ) );
    },

    e: function(x) {
      return 10 + (x/3) - (150 * Math.pow( Math.E, -(Math.pow((x - 245) / 30, 2))));
    },

    f: function(x) {
      return 300 + (100 * Math.cos( x / 50 ));
    },
};
