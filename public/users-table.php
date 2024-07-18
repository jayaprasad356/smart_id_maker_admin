<section class="content-header">
    <h1>Users /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>

    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-user.php"><i class="fa fa-plus-square"></i> Add New User</a>
    </ol>

</section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
                <!-- Left col -->
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                                <div class="row">
                                        <div class="form-group col-md-3">
                                            <a href="export-verified-user.php" class="btn btn-primary"><i class="fa fa-download"></i> Export verified users</a>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <a href="export-unverified-user.php" class="btn btn-primary"><i class="fa fa-download"></i> Export unverified users</a>
                                        </div>      
                                </div>
                                <div class="col-md-2">
                                <h4 class="box-title">Joined Date </h4>
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo (isset($_GET['date'])) ? $_GET['date'] : "" ?>"></input>
                        </div>
                        </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=users" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","csv"]' data-export-options='{
                            "fileName": "yellow app-users-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                   <th data-field="operate">Action</th>
                                   <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mobile" data-sortable="true">Phone Number</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="refer_code" data-sortable="true">Refer Code</th>
                                    <th data-field="referred_by" data-sortable="true">Refered By</th>
                                    <th data-field="balance" data-sortable="true">Balance</th>
                                    <th data-field="withdrawal" data-sortable="true">Withdrawal</th>
                                    <th data-field="history" data-sortable="true">History</th>
                                    <th data-field="earn" data-sortable="true">Earn</th>
                                    <th data-field="today_codes" data-sortable="true">Today Codes</th>
                                    <th data-field="total_referrals" data-sortable="true">Total Referrals</th>
                                    <th data-field="total_codes" data-sortable="true">Total Codes</th>
                                    <th data-field="code_generate" data-sortable="true">Code Generate</th>
                                    <th data-field="withdrawal_status" data-sortable="true">Withdrawal Status</th>
                                    <th data-field="salary_advance_balance" data-sortable="true">Salary Advance Balance</th>
                                    <th data-field="ongoing_sa_balance" data-sortable="true">Ongoing SA Balance</th>
                                    <th data-field="sa_refer_count" data-sortable="true">SA Refer Count</th>
                                    <th data-field="email" data-sortable="true">Email</th>
                                    <th data-field="city" data-sortable="true">City</th>
                                    <th data-field="device_id" data-sortable="true">Device Id</th>
                                    <th data-field="password" data-sortable="true">Password</th>
                                    <th data-field="dob" data-sortable="true">Date of Birth</th>
                                    

                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="separator"> </div>
        </div>
        <!-- /.row (main row) -->
    </section>

<script>
      $('#date').on('change', function() {
            id = $('#date').val();
            $('#users_table').bootstrapTable('refresh');
        });
   

    function queryParams(p) {
        return {
            "date": $('#date').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>

