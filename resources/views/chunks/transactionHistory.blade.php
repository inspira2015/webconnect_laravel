<hr class="my-4">
<div style="width: 100%; text-align: left;">
    <h2>Transaction History</h2>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Date of Record</th>
            <th scope="col">Transaction</th>
            <th scope="col">Document</th>
            <th scope="col">Transaction Amount </th>
            <th scope="col">Check Number</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bailMaster->BailTransactions as  $key => $item)
            <tr>    
                <th scope="row">{{ $item->t_created_at }}</th>
                <th scope="row">{{ $item->t_type }}</th>
                <th scope="row">{{ $item->t_numis_doc_id }}</th>
                <th scope="row">{{ $item->t_amount }}</th>
                <th scope="row">{{ $item->t_check_number }}</th>
            </tr>
        @endforeach
    </tbody>
</table>