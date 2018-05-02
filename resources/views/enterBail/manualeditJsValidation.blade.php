<script>
  var state_id         = "{{ $stConfig['us_state_id'] }}";
  var state_outside_us = "{{ $stConfig['non_us_state_string'] }}";
  $(document).ready(stateSelector(state_id, state_outside_us));

  $(document).ready(function() {
    var src = "{{ route('validateindexyear') }}";
    var old_posted_date = '{{ old('m_posted_date', $m_posted_date) }}';
    var old_date_of_record = '{{ old('date_of_record') }}';
    var date_of_record = new Date();
    var posted_date = new Date();

  if (old_posted_date) {
   posted_date = old_posted_date;
  }

  if (old_date_of_record) {
   date_of_record = old_date_of_record;
  }

  var date_input = $('input[name="m_posted_date"]'); //our date input has the name "date"
  var container = $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
  var options = {
   format: 'mm/dd/yyyy',
   container: container,
   //todayHighlight: true,
   autoclose: true,
   forceParse: false,

  };

  date_input.datepicker(options).datepicker("setDate", posted_date);
  var date_input = $('input[name="date_of_record"]'); //our date input has the name "date"
  var container = $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
  var options = {
   format: 'mm/dd/yyyy',
   container: container,
   //todayHighlight: true,
   autoclose: true,
   setDate: 0,
  };
  date_input.datepicker(options).datepicker("setDate", date_of_record);
 });

 $( "#manual-bail-entry" ).validate({
  /*debug: true,*/
  success: function(label,element) {
    label.hide();
  },

  rules: {
   t_numis_doc_id: {
    required: true,
    number: true
   },
   m_receipt_amount: {
    required: true,
    number: true
   },
   m_index_year: {
    required: true
   },
  }
 });
</script>
