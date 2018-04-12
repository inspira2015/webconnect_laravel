<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <form name="bails" id="manual-bail-entry" method="post" action="{{ route('editbailmaster') }}" >
    {{ csrf_field() }}
    <input type="hidden" id="m_id" name="m_id" value="{{ old('m_id', $bailMaster->m_id) }}">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="exampleModalLabel">Edit Bail Master Info</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="m_def_first_name">Defendant First Name</label>
              <input type="text" class="form-control" id="m_def_first_name" name="m_def_first_name" value="{{ old('m_def_first_name',  $bailMaster->m_def_first_name) }}"  required>
            </div>
            <div class="form-group">
              <label for="m_def_last_name">Defendant Last Name</label>
              <input type="text" class="form-control" id="m_def_last_name" name="m_def_last_name" value="{{ old('m_def_last_name', $bailMaster->m_def_last_name) }}" required>
            </div>
            <div class="row">
              <div class="col-xs-8 col-sm-6">
                <label for="m_index_number">Indx Number: </label>
                <input type="text" class="form-control" id="m_index_number" name="m_index_number" placeholder="" value="{{ old('m_index_number', $bailMaster->m_index_number) }}" required>
                <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;">
                </div>
              </div>
              <div class="col-xs-4 col-sm-6">
                <label for="m_index_year">Index Year:</label>
                <input type="text" class="form-control" maxlength="2" id="m_index_year" name="m_index_year" placeholder="" value="{{ old('m_index_year', $bailMaster->m_index_year) }}" required>
             </div>
            </div>
            <div class="form-group">
             <label for="exampleAccount">Date Posted:</label>
             <input type="text" class="form-control" required id="m_posted_date" name="m_posted_date" value="{{ old('m_posted_date') }}" placeholder="MM/DD/YYY">
            </div>
            <div class="form-group">
             <label for="m_surety_first_name">Surety First Name</label>
             <input type="text" class="form-control" id="m_surety_first_name" name="m_surety_first_name" value="{{ old('m_surety_first_name', $bailMaster->m_surety_first_name) }}" required>
            </div>
            <div class="form-group">
             <label for="m_surety_last_name">Surety Last Name</label>
             <input type="text" class="form-control" id="m_surety_last_name" name="m_surety_last_name" value="{{ old('m_surety_last_name', $bailMaster->m_surety_last_name) }}" required>
            </div>
            <div class="form-group">
             <label for="m_surety_address">Address</label>
             <input type="text" class="form-control" id="m_surety_address" name="m_surety_address"  value="{{ old('m_surety_address', $bailMaster->m_surety_address) }}" required>
            </div>
            <div class="row">
              <div class="col-xs-8 col-sm-6">
                <label for="m_surety_city">City</label>
                <input type="text" class="form-control" id="m_surety_city" name="m_surety_city" value="{{ old('m_surety_city', $bailMaster->m_surety_city) }}" required>
              </div>
              <div class="col-xs-4 col-sm-6">
                <label for="m_surety_state">State</label>
                {!! Form::select('m_surety_state', $stateList, $bailMaster->m_surety_state, array('class' => 'form-control')) !!}
              </div>
            </div>
            <div class="form-group">
              <label for="m_surety_zip">Zip Code</label>
              <input type="text" class="form-control" id="m_surety_zip" name="m_surety_zip" value="{{ old('m_surety_zip', $bailMaster->m_surety_zip) }}" required>
            </div>
          </div>
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="type" id="update-info" class="btn btn-primary">Save Changes</button>
         </div>
        </div>
      </div>
    </form>
  </div>