<div style="width: 100%;">
    <p><strong>Check Number: <span class="blue-font font18">{{ $checkNumber }}</span></strong></p>

</div>
<br><br>
<p><strong>Total Check Amount: <span class="green-font font18 dollar-amount">{{ $totalCheckAmount }}</span> </strong></p>

<table width="100%"  border="0" cellpadding="2" cellspacing="0" class="reduce-input reduce-width jailRecords">
    <tr style="font-weight: bold"> 
        <td>Posted Date</td>
        <td>Date of Rec</td>
        <td>Def Last</td>
        <td>Def First</td>
        <td><br /></td>
        <td>Index No</td>
        <td>Index Yr</td>
        <td>Court</td>
        <td>Bail Amt</td> 
        <td>Surety Last</td>
        <td>Surety First</td>
        <td>Surety Address</td> 
        <td>City</td>
        <td>State</td>
        <td>Zip</td>
        <td>Phone</td>
        <td><br /></td>
    </tr>

    @foreach($jailRecords as $key => $value)
        <tr class="<?php echo $value->duplicate; ?>">
            <td height="20"> <?php echo date("M/d/Y", strtotime($value->j_date_1)); ?> </td>
            <td height="20" width="90">
                <input type="text" name="daterec[<?php echo $value->j_id; ?>]" size="25" class="form-control form-control-sm"  value="<?php echo date('m/d/Y', strtotime($value->j_date_2)); ?>">
            </td>
            <td height="20" width="10">  {{ $value->j_def_last_name }} </td>
            <td height="20">  {{ $value->j_def_first_name }} </td>
            <td height="20">  {{ $value->j_def_suffix }} </td>
            <td height="20" width="60">
                <input name="index_no[<?php echo $value->j_id; ?>]" type="text" size="25" class="form-control form-control-sm"  value="<?php echo $value->index_number; ?>">
            </td>
            <td height="20" width="25">
                <input name="index_year[<?php echo $value->j_id; ?>]" size="3" class="form-control form-control-sm" value="<?php echo $value->index_year; ?>">
            </td>
            <td height="20" width="120">
                <?php $court_no = "court_no[{$value->j_id}]"; ?>
                {!! Form::select($court_no, $courtList, $value->j_court_number, array('class' => 'form-control form-control-sm')) !!}
            </td>
            <td height="20" class="dollar-amount">  {{ $value->bail_amount }} </td>
            <td height="20">  {{ $value->j_surety_last_name }} </td>
            <td height="20">  {{ $value->j_surety_first_name }} </td>
            <td height="20">  {{ $value->j_surety_address }} </td>
            <td height="20">  {{ $value->j_surety_city }} </td>
            <td height="20">  {{ $value->j_surety_state }} </td>
            <td height="20">  {{ $value->j_surety_zip }} </td>
            <td height="20" class="phone">  {{ $value->j_surety_phone }} </td>
        </tr>
    @endforeach
</table>
