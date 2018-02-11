var Cryptography = class Cryptography {

  constructor(mapping) {
    this.mapping = mapping;
    this.operators = ['-', '+'];
    this.allowedChars = mapping.concat(this.operators);
  }

  getMapping() {
    return this.mapping;
  }

  getAllowedChars() {
    return this.allowedChars;
  }

  parseEquation(eq) {
    eq = eq.replace(/\s+/g, ''); // Remove whitespace
    eq = eq.toUpperCase();
    eq = eq.trim();

    function parse(str, allowedChars) {
      var c = str.charAt(0);
      var i = allowedChars.indexOf(c);

      if(c == '+'){
        return parseInt(0 + (parse(str.substr(1), allowedChars)));
      }
      else if(c == '-') {
        return parseInt(-1 * (parse(str.substr(1), allowedChars)));
      }
      else if(i >= 0) {
        return parseInt(i  + (parse(str.substr(1), allowedChars))).toString();
      }
      else if(!c){
        return 0;
      }
      else {
        throw new Error(c + " is not an allowed character");
      }
    }
    var n = parse(eq, this.allowedChars);

    var answer = '';

    if(n == 0) return this.mapping[n];

    while(n > 0) {

      answer = this.mapping[n % 10] + answer;
      n = parseInt(n / 10);
    }

    return answer;
  }
}
