/**
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * ==================================================================
 *
 * !!!!!!!! Only EcmaScript5 inside !!!!!!!!!
 * Расширение объекта Array
 *
 * ==================================================================
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */
/* eslint {semi: [1,'always']} */

/**
 * Возвращает минимальное значение массива
 * @method min        Применяется к любому массиву JS
 * @return {Mixed}
 */
Array.prototype.min = function() {
  return Math.min.apply(null, this);
};

/**
 * Удаляет повторения из массива
 * @method getUnique  Применяется к любому массиву JS
 * @return {Array}
 */
Array.prototype.getUnique = function() {
  var u = {},
    a = [];
  for(var i = 0, l = this.length; i < l; ++i) {
    if(u.hasOwnProperty(this[i])) {
      continue;
    }
    a.push(this[i]);
    u[this[i]] = 1;
  }
  return a;
};

/**
 * Делает из массива вида:
 * [ [a, b, c], [d, e, f], [g, h, j] ]
 * Вот такой:
 * [ a, b, c, d, e, f, g, h, j ]
 * @method getUnique  Применяется к любому массиву JS
 * @return {Array}
 */
Array.prototype.collapse = function() {
  var a = [];
  for(var i = 0, l = this.length; i < l; ++i) {
    if(
      this[i] !== undefined &&
      this[i].hasOwnProperty('length') &&
      this[i].length > 0
    ) {
      this[i].forEach(function(el) {
        a.push(el);
      });
    }
  }
  return a;
};

export default {
  Array
};

