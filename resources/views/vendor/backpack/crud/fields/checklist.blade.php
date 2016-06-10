<!-- select2 -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
    <?php $entity_model = $crud->getModel();?>
   
    <div class="row">
        @foreach ($field['model']::all() as $connected_entity_entry)
            <div class="col-sm-4">
                <div class="checkbox">
                  <label>
                    <input type="checkbox"
                        @foreach ($field as $attribute => $value)
                            @if (is_string($attribute) && $attribute != 'value')
                              @if ($attribute=='name')
                                {{ $attribute }}="{{ $value }}[]"
                              @else
                                {{ $attribute }}="{{ $value }}"
                              @endif
                            @endif
                        @endforeach
                         value="{{ $connected_entity_entry->id }}"

                         @if( ( old( $field["name"] ) && in_array($connected_entity_entry->id, old( $field["name"])) ) || (isset($field['value']) && in_array($connected_entity_entry->id, $field['value']->lists('id', 'id')->toArray())))
                             checked = "checked"
                        @endif > {{ $connected_entity_entry->{$field['attribute']} }}
                  </label>
                </div>
            </div>
        @endforeach
    </div>
  </div>