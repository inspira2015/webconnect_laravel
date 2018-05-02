<div class="form-row mt-4">
  <div style="width: 100%; text-align: left;">
    <h2>Defendant Data</h2>
  </div>
  <div class="col-sm-3 pb-3">
    <label for="m_def_first_name">Defendant First Name</label>
    <input type="text" class="form-control" id="m_def_first_name" name="m_def_first_name" value="{{ old('m_def_first_name',  $bailMaster->m_def_first_name) }}"  disabled>
  </div>
  <div class="col-sm-3 pb-3">
    <label for="m_def_last_name">Defendant Last Name</label>
    <input type="text" class="form-control" id="m_def_last_name" name="m_def_last_name" value="{{ old('m_def_last_name', $bailMaster->m_def_last_name) }}" disabled>
  </div>
  <div class="col-sm-1 pb-3">
    <label for="m_index_number">Indx Number: </label>
    <input type="text" class="form-control" id="m_index_number" name="m_index_number" placeholder="" value="{{ old('m_index_number', $bailMaster->m_index_number) }}" disabled>
    <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;"></div>
  </div>
  <div class="col-sm-1 pb-3">
    <label for="m_index_year">Index Year:</label>
    <input type="text" class="form-control" maxlength="2" id="m_index_year" name="m_index_year" placeholder="" value="{{ old('m_index_year', $bailMaster->m_index_year) }}" disabled>
  </div>
  <div class="col-sm-2 pb-3">
    <label for="exampleAccount">Date Posted:</label>
    <input type="text" class="form-control" disabled id="m_posted_date2" name="m_posted_date2" placeholder="MM/DD/YYY">
  </div>
  <div class="col-sm-2 pb-3">
    <label for="m_court_number">Court Number: </label>
    {!! Form::select('m_court_number', $courtList, $bailMaster->m_court_number, array('class' => 'form-control',
    'disabled' => 'disabled')) !!}
  </div>
  <hr class="my-5">
  <div style="width: 100%; text-align: left;">
    <h2>Surety Data</h2>
  </div>
  <div class="col-sm-3 pb-3">
    <label for="m_surety_first_name">Surety First Name</label>
    <input type="text" class="form-control" id="m_surety_first_name" name="m_surety_first_name" value="{{ old('m_surety_first_name', $bailMaster->m_surety_first_name) }}" disabled>
  </div>
  <div class="col-sm-3 pb-3">
    <label for="m_surety_last_name">Surety Last Name</label>
    <input type="text" class="form-control" id="m_surety_last_name" name="m_surety_last_name" value="{{ old('m_surety_last_name', $bailMaster->m_surety_last_name) }}" disabled>
  </div>
  <div class="col-sm-4 pb-3">
    <label for="m_surety_address">Address</label>
    <input type="text" class="form-control" id="m_surety_address" name="m_surety_address"  value="{{ old('m_surety_address', $bailMaster->m_surety_address) }}" disabled>
  </div>
  <div class="col-sm-2 pb-3">
    <label for="m_surety_city">City</label>
    <input type="text" class="form-control" id="m_surety_city" name="m_surety_city" value="{{ old('m_surety_city', $bailMaster->m_surety_city) }}" disabled>
  </div>
  <div class="col-sm-2 pb-3">
    <label for="m_surety_state">State</label>
    {!! Form::select('m_surety_state', $stateList, $stConfig['us_state_id'], array('class' => 'form-control',
              'disabled' => 'disabled', 'id' => 'm_surety_state__show')) !!}
  </div>
  <div class="col-sm-2 pb-3 outside-state-show">
    <label for="non_us_state">State Outside US:</label>
    <input type="text" class="form-control"  id="non_us_state_show" name="non_us_state_show" value="" disabled>
  </div>
  <div class="col-sm-2 pb-3 ">
    <label for="m_surety_zip">Zip Code</label>
    <input type="text" class="form-control" id="m_surety_zip" name="m_surety_zip" value="{{ old('m_surety_zip', $bailMaster->m_surety_zip) }}" disabled>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
      var state_id__show         = "{{ $stConfig['us_state_id'] }}";
      var state_outside_us__show = "{{ $stConfig['non_us_state_string'] }}";
      var outside_length__show = state_outside_us__show.length;

      if (outside_length__show > 0) {
        $('.outside-state-show').show();
        $('#m_surety_state__show').val(state_id__show);
        $('#non_us_state_show').val(state_outside_us__show);
      } else {
        $('.outside-state-show').hide();
      }


    });

</script>