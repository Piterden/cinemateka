var $vm = new Vue({

  el: 'body',

  data() {
    return {
      title: '',
      file: '',
      imagesJson: {}
    };
  },

  computed: {
    slug() {
      return this.toTranslit(this.title);
    }
  },

  methods: {
    toTranslit(rus) {
      var translit = { "а": "a", "б": "b", "в": "v", "г": "g", "д": "d", "е": "e", "ё": "yo", "ж": "zh", "з": "z", "и": "i", "й": "j", "к": "k", "л": "l", "м": "m", "н": "n", "о": "o", "п": "p", "р": "r", "с": "s", "т": "t", "у": "u", "ф": "f", "х": "h", "ц": "c", "ч": "ch", "ш": "sh", "щ": "shh", "ъ": "'", "ы": "y", "ь": "._", "э": "e-", "ю": "yu", "я": "ya", " ": "-" };
      return rus.toLowerCase().split('').map(function(lt) {
        return translit[lt] || lt;
      }).join('');
    }
  }

});
