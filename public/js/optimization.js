var taskFunctions = {
    a: function(x) {

      return 100 * ( Math.sin( x / 30 ) + Math.pow( ( x / 300 ), 2 ) );
    },

    b: function(x) {
      return 40 * ( Math.sin( x / 30 ) ) + 100 * ( Math.cos( x / 60 ) ) + ( x / 5);
    }
};
