<style lang="css">
</style>

<template lang="html">
  <div class="dropdown">
    <input id="{{ inputId }}" type="checkbox"
      :checked="checked" />
    <label for="{{ inputId }}"
      @click="handleSelectClick">
      <div v-if="isMonth" class="drop-ttl month">{{ textValue }}</div>
      <div v-else class="drop-ttl no-month">{{ value }}</div>
      <ul>
        <li v-for="item in list"
          @click="handleOptionClick(item)">
          {{ item }}
        </li>
      </ul>
    </label>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // dataReady: false
    };
  },
  props: {
    inputId: {
      type: String,
      default() {
        return '';
      }
    },
    value: {
      default() {
        return 'Выбрать';
      }
    },
    list: {
      type: Array,
      default() {
        return [];
      }
    },
    checked: {
      type: String,
      default() {
        return 'disabled';
      }
    }
  },

  methods: {
    /**
     * Клик по закрытому элементу
     */
    handleSelectClick() {
      // console.log(this);
    },

    /**
     * Клик по элементу открытого списка
     * @param  {String} value Значение нажатого элемента
     */
    handleOptionClick(value) {
      // console.log('fire');
      if (this.isMonth) {
        this.$set('textValue', value);
        this.$set('value', this.list.indexOf(value));
      }
      this.$set('value', value);
    }
  },
  computed: {
    textValue: {
      get() {
        if (!this.isMonth) {
          return this.value;
        }
        if (typeof this.value === 'string') {
          this.$set('value', this.list.indexOf(this.value));
        }
        return this.list[this.value];
      },
      set(v) {
        this.$set('value', this.list.indexOf(v));
        // this.$log(this);
        //  this.list.indexOf(v) || 0;
      }
    },
    isMonth() {
      return this.inputId === 'month';
    }
  },
  ready() {},
  attached() {},
  components: {}
}
</script>
