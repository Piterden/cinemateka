<template>
  <div :id="'event-'+eventId">
    <seance-item
      v-for="seance in eventSeances"
      :seance="seance"
    ></seance-item>
    <div class="row">
      <div class="col-md-12">
        <button type="button"
          class="btn btn-default"
          @click.prevent="showModal = true"
        ><i class="fa fa-cloud-upload"></i>
          Добавить сеанс
        </button>
      </div>
    </div>
    <modal
      :show.sync="showModal"
      :seance.sync="activeSeance"
    >
      <div slot="header">Добавить сеанс</div>
      <div slot="body">
        <form id="addSeanceForm" @submit.prevent="saveSeance">
          <input name="_method" type="hidden" :value="activeSeance ? 'PUT' : 'POST'">
          <input name="_token" type="hidden" :value.sync="token">
          <input v-if="activeSeance" name="id" type="hidden" :value="activeSeance.id">
          <div class="form-group col-md-6">
            <label>Дата</label>
            <input class="form-control" type="text" name="start_time" :value="sDate">
          </div>
          <div class="form-group col-md-6">
            <label>Событие</label>
            <dropdown-admin
              :input-name="'event_id'"
              :value="eventId"
              :list="$root.events"
              :disabled="'disabled'"
            ></dropdown-admin>
          </div>
          <div class="form-group col-md-6">
            <label>Программа</label>
            <dropdown-admin
              :input-name="'program_id'"
              :value="activeSeance && activeSeance.program_id"
              :list="$root.programs"
            ></dropdown-admin>
          </div>
          <div class="form-group col-md-6">
            <label>Площадка</label>
            <dropdown-admin
              :input-name="'place_id'"
              :value="activeSeance && activeSeance.place_id"
              :list="$root.places"
            ></dropdown-admin>
          </div>
          <div class="form-group col-md-6">
            <label>Инфо о спикере</label>
            <textarea class="form-control"
              type="text"
              name="speaker_info"
            >{{ activeSeance && activeSeance.speaker_info || '' }}</textarea>
          </div>
          <div class="form-group col-md-6">
            <label>Описание</label>
            <textarea class="form-control"
              type="text"
              name="description"
            >{{ activeSeance && activeSeance.description || '' }}</textarea>
          </div>
          <div class="form-group col-md-6">
            <label>Цена</label>
            <input class="form-control" type="text" name="price"
              :value="activeSeance && activeSeance.price"
            >
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
/* global $ PNotify */
import moment from 'moment'
moment.locale('ru')

export default {

  data() {
    return {
      showModal: false
    }
  },

  props: ['eventId', 'fieldName', 'token', 'activeSeance'],

  computed: {
    eventSeances() {
      return this.eventId && this.$root.getSeancesByEventId(this.eventId)
    },
    sDate() {
      return this.activeSeance
        ? moment(this.activeSeance.start_time).format('D MMMM YYYY в hh:mm')
        : moment().format('D MMMM YYYY в hh:mm')
    }
  },

  methods: {
    saveSeance() {
      let obj = this.getFormFields('addSeanceForm')
      obj.start_time = moment(obj.start_time, 'D MMMM YYYY в hh:mm')
        .format('YYYY-MM-DD HH:mm:ss')
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
    getFormFields(selector) {
      let obj = {},
        fields = $(document.getElementById(selector)).serializeArray()
      fields.forEach((f) => {
        obj[f.name] = f.value
      })
      return obj
    },
    afterAddSeance(resp) {
      this.$root.seances.push(resp.data)
      this.showModal = false
      this.$root.fireNotify('Сеанс добавлен', 'Вы успешно добавили сеанс', 'success')
    },
    afterUpdateSeance(resp) {
      let i = this.$root.seances.findIndex((s) => { return s.id == resp.data.id })
      this.$root.seances.$set(i, resp.data)
      this.showModal = false
      this.$root.fireNotify('Сеанс обновлен', 'Вы успешно обновили сеанс', 'success')
    },
    showError() {
      this.$root.fireNotify('Ошибка!!!', 'Что-то пошло не так!', 'error')
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
          return moment(this.seance.start_time).format('D MMMM YYYY в hh:mm')
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
          this.$parent.activeSeance = this.seance
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
                    _method: 'DELETE',
                    _token: _this.$parent.token
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
</style>
