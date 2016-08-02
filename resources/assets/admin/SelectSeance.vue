<template>
  <div :id="'event-'+eventId">
    <seance-item
      v-for="seance in eventSeances"
      :seance="seance"
    ></seance-item>
    <div class="row">
      <div class="col-md-12">
        <button type="button"
          class="btn btn-default{{ disabledClass }}"
          @click.prevent="onAddSeance()"
        ><i class="fa fa-cloud-upload"></i>
          Добавить сеанс
        </button>
        <p class="bg-warning" v-if="disabledClass">
          Необходимо сохранить событие перед добавлением сеанса!
        </p>
      </div>
    </div>
    <modal
      :show.sync="showModal"
      :seance.sync="activeSeance"
    >
      <div slot="header"></div>
      <div slot="body">
        <form id="addSeanceForm" @submit.prevent="saveSeance">
          <input name="_method" type="hidden" :value="activeSeance.id ? 'PUT' : 'POST'">
          <input name="_token" type="hidden" :value.sync="token">
          <input v-if="activeSeance.id" name="id" type="hidden" :value="activeSeance.id">
          <div class="form-group col-md-12 event-name">
            <!-- <label>Событие</label> -->
            <dropdown-admin
              :input-name="'event_id'"
              :value="eventId"
              :list="$root.events"
              :disabled="'disabled'"
            ></dropdown-admin>
          </div>
          <div class="form-group col-md-5">
            <label>Дата</label>
            <date-picker
              :time.sync="starttime"
              :option="timeoption"
              :input-name="'start_time'"
            ></date-picker>
          </div>
          <div class="form-group col-md-5">
            <label>Место</label>
            <dropdown-admin
              :input-name="'place_id'"
              :value="activeSeance.id && activeSeance.place_id"
              :list="$root.places"
            ></dropdown-admin>
          </div>
          <div class="form-group col-md-2">
            <label>Цена</label>
            <input class="form-control" type="text" name="price"
              :value="activeSeance.id && activeSeance.price"
            >
          </div>
          <div class="form-group col-md-12">
            <label>Программа</label>
            <dropdown-admin
              :input-name="'program_id'"
              :value="activeSeance.id && activeSeance.program_id"
              :list="$root.programs"
            ></dropdown-admin>
          </div>
          <div class="form-group col-md-12">
            <label>Инфо о спикере</label>
            <textarea class="form-control"
              id="speaker_info_{{ activeSeance.id }}"
              name="speaker_info_{{ activeSeance.id }}"
            >
              {{ activeSeance.speaker_info || '' }}
            </textarea>
          </div>
          <div class="form-group col-md-6" v-if="0">
            <label>Описание</label>
            <textarea class="form-control"
              type="text"
              name="description"
            >{{ activeSeance && activeSeance.description || '' }}</textarea>
          </div>
          <div class="form-group col-md-12">
            <button class="modal-default-button" @click.prevent="showModal = false">
              Отмена
            </button>
            <button class="modal-primary-button">
              Сохранить
            </button>
          </div>
        </form>
      </div>
      <div slot="footer"></div>
    </modal>
  </div>
</template>
<script>

/* global $ PNotify CKEDITOR */

import moment from 'moment'
moment.locale('ru')

export default {

  data() {
    return {
      showModal: false,
      activeSeance: { event_id: this.eventId, id: 0 },
      starttime: moment().format('D MMMM YYYY в H:mm'),
      timeoption: {
        type: 'min',
        week: moment.weekdaysShort(),
        month: moment.months(),
        format: 'D MMMM YYYY в H:mm',
        inputStyle: {
          'display': 'block',
          'padding': '7px 12px',
          'line-height': '1.3',
          'font-size': '14px',
          'font-family': 'Lato, Helvetica, sans-serif',
          'border': '1px solid #ccc',
          'box-shadow': 'none',
          'border-radius': '0',
          'color': 'rgb(95, 95, 95)',
          'width': '100%'
        },
        color: {
          header: '#ccc',
          headerText: '#f00'
        },
        buttons: {
          ok: 'Выбрать',
          cancel: 'Отменить'
        },
        overlayOpacity: 0.5, // 0.5 as default
        dismissible: true // as true as default
      }
    }
  },

  props: ['eventId', 'fieldName', 'token'],

  computed: {
    eventSeances() {
      return this.eventId && this.$root.getSeancesByEventId(this.eventId)
    },
    sDate() {
      return this.activeSeance.id
        ? moment(this.activeSeance.start_time).format('D MMMM YYYY в H:mm')
        : moment().format('D MMMM YYYY в H:mm')
    },
    disabledClass() {
      return window.location.href.endsWith('create') ? ' disabled' : ''
    }
  },

  methods: {
    /**
     * Сохраняет сеанс
     */
    saveSeance() {
      let obj = this.getFormFields('addSeanceForm')
      obj.start_time = moment(obj.start_time, 'D MMMM YYYY в H:mm')
        .format('YYYY-MM-DD HH:mm:ss')
      obj.speaker_info = this.cke.getData()
      if (obj.id) {
        // Update
        this.$http.put('/rest/seance/' + obj.id, obj)
        .then(this.afterUpdateSeance, this.showError)
      } else {
        // Create
        this.$http.post('/rest/seance', obj)
        .then(this.afterAddSeance, this.showError)
      }
    },

    /**
     * Получает поля формы по id
     * @param  {String} id      id формы
     * @return {Object}
     */
    getFormFields(id) {
      let obj = {},
        fields = $(document.getElementById(id)).serializeArray()
      fields.forEach((f) => {
        obj[f.name] = f.value
      })
      return obj
    },

    /**
     * После добавления сеанса
     * @param  {Object} resp  Ответ сервера
     */
    afterAddSeance(resp) {
      this.$root.seances.push(resp.data)
      this.showModal = false
      this.$root.fireNotify('Сеанс добавлен', 'Вы успешно добавили сеанс', 'success')
    },

    /**
     * После редактирования сеанса
     * @param  {Object} resp  Ответ сервера
     */
    afterUpdateSeance(resp) {
      let i = this.$root.seances.findIndex((s) => { return s.id == resp.data.id })
      this.$root.seances.$set(i, resp.data)
      this.showModal = false
      this.$root.fireNotify('Сеанс обновлен', 'Вы успешно обновили сеанс', 'success')
    },

    /**
     * Нажатие на "Добавить сеанс"
     */
    onAddSeance() {
      this.activeSeance = { event_id: this.eventId }
      this.showModal = true
    },

    /**
     * Показывает уведомление об ошибке
     * @param  {Object} resp
     * @return {[type]}     [description]
     */
    showError(resp) {
      this.$root.fireNotify('Ошибка!!!', 'Что-то пошло не так! ' + resp.status, 'error')
    }
  },

  watch: {
    showModal(nv) {
      if (nv) {
        this.cke = CKEDITOR.replace('speaker_info_' + this.activeSeance.id )
      } else {
        this.cke && this.cke.destroy()
      }
    }
  },

  components: {
    'seance-item': {
      template: ' <div class="seanceItem" v-if="seance">' +
                '   <div class="infoBlock">' +
                '     {{ startTime }}<br>' +
                '     {{ placeName }}' +
                '     <b>{{ price }}</b> <i class="fa fa-rub"></i>' +
                '   </div>' +
                '   <div class="actionsBlock">' +
                '     <i class="fa fa-edit" @click="editSeance"></i>' +
                '     <i class="fa fa-times" @click="deleteSeance"></i>' +
                '   </div>' +
                ' </div>',
      props: ['seance'],
      computed: {
        startTime() {
          return moment(this.seance.start_time).format('D MMMM YYYY в H:mm')
        },
        placeName() {
          let pl = this.$root.getById(this.$root.places, this.seance.place_id)
          return pl && pl.title
        },
        price() {
          return this.seance.price
        }
      },
      methods: {
        editSeance() {
          let fDate = moment(this.seance.start_time).format('D MMMM YYYY в H:mm')
          this.$parent.activeSeance = this.seance
          this.$parent.starttime = fDate
          this.$parent.showModal = true
        },
        deleteSeance() {
          let _this = this
          new PNotify({
            title: 'Удаление сеанса',
            text: 'Вы действительно хотите удалить сеанс?',
            type: 'notice',
            confirm: {
              confirm: true,
              buttons: [{
                text: 'Да',
                promptTrigger: true,
                click(notice, value) {
                  _this.$http.delete('/rest/seance/' + _this.seance.id, {
                    params: {
                      _method: 'DELETE',
                      _token: document.querySelector('[name="csrf-token"]').content
                    }
                  }).then(() => {
                    _this.$destroy(true)
                  }, _this.showError)
                  notice.remove()
                  notice.get().trigger('pnotify.confirm', [notice, value])
                }
              },{
                text: 'Отмена',
                click(notice) {
                  notice.remove()
                  notice.get().trigger('pnotify.cancel', notice)
                }
              }]
            }
          })
        }
      }
    }
  }
}
</script>
<style lang="sass">
.seanceItem {
  font-size: 18px;
  display: inline-block;
  border: 1px solid #673AB7;
  margin: 4px;
  .infoBlock {
    float: left;
    padding: 2px 6px;
    width: calc(100% - 24px);
    display: inline-block;
  }
  .actionsBlock {
    float: left;
    width: 24px;
    display: inline-block;
    cursor: pointer;
    padding: 2px 0 0 0;
    .fa-times {
      font-size: 22px;
      color: #F44336;
    }
    .fa-edit {
      font-size: 20px;
      color: #4CAF50;
    }
  }
}
.modal-header {
  display: none;
}
#addSeanceForm {
  .event-name {
    .dropdown {
      border: none;
      label {
        text-transform: none;
        .drop-ttl {
          padding: 0;
        }
      }
    }
  }
  .dropdown {
    margin: 0;
    width: 100%;
    ul {
      list-style-type: none;
      list-style-position: outside;
      padding: 0;
      width: calc(100% + 4px);
      li {
        padding: 5px 10px;
        margin: 0px;
      }
    }
    &> label {
      padding: 0;
      margin-bottom: 0;
    }
  }
}
</style>
