
<section class="content-header">
    <h1>Outsource Plan /<small><a href="reports.php"><i class="fa fa-home"></i> Home</a></small></h1>
            <ol class="breadcrumb">
                <a class="btn btn-block btn-default" href="add-outsource_plan.php"><i class="fa fa-plus-square"></i> Add New Outsource Plan</a>
</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
            
                
                    <div  class="box-body table-responsive">
                    <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=outsource_plan" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","csv"]' data-export-options='{
                            "fileName": "users-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                        <thead>
                                <tr>
                                    <th  data-field="operate" data-events="actionEvents">Action</th>
                                    <th  data-field="id" data-sortable="true">ID</th>
                                    <th  data-field="name" data-sortable="true">Name</th>
                                    <th  data-field="demo_video" data-sortable="true">Demo Video</th>
                                    <th  data-field="monthly_codes" data-sortable="true">Monthly Codes</th>
                                    <th  data-field="monthly_earnings" data-sortable="true">Monthly Earnings</th>
                                    <th  data-field="yearly_earnings" data-sortable="true">Yearly Earnings</th>
                                    <th  data-field="sync_cost" data-sortable="true">Sync Cost</th>
                                    <th  data-field="invite_bonus" data-sortable="true">Invite Bonus</th>
                                    <th  data-field="per_code_cost" data-sortable="true">Per Code Cost</th>
                                    <th  data-field="price" data-sortable="true">Price</th>
                                    <th  data-field="type" data-sortable="true">Type</th>
                                    <th  data-field="num_sync" data-sortable="true">Num Sync</th>
                                    <th  data-field="min_refers" data-sortable="true">Min Refers</th>
                                    <th  data-field="refund" data-sortable="true">Refund</th>
                                    <th  data-field="refer_refund_amount" data-sortable="true">Refer Refund Amount</th>
                                    <th data-field="image">Image</th>
                                    <th  data-field="description" data-sortable="true">Description</th>
                                    <th  data-field="sub_description" data-sortable="true">Sub Description</th>
                                    <th  data-field="active_link" data-sortable="true">Active Link</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="separator"> </div>
        </div>
    </section>

<script>

    $('#seller_id').on('change', function() {
        $('#products_table').bootstrapTable('refresh');
    });
    $('#community').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#status').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#trail_completed').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#date').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#referred_by').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#plan').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    function queryParams(p) {
        return {
            "date": $('#date').val(),
            "seller_id": $('#seller_id').val(),
            "community": $('#community').val(),
            "status": $('#status').val(),
            "trail_completed": $('#trail_completed').val(),
            "referred_by": $('#referred_by').val(),
            "plan": $('#plan').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
    
</script>
