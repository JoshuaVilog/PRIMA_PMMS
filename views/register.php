
<body class="no-skin">
    <?php include "partials/navbar.php";?>

    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try{ace.settings.loadState('main-container')}catch(e){}
        </script>

        <?php include "partials/sidebar.php";?>
        <div class="main-content">
            <div class="main-content-inner">
                <div class="page-content">
                    <div class="page-header">
                        <h1>Register</h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 pricing-box">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">FORM</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>
                                                        <strong>MOLD CODE:</strong>
                                                    </label>
                                                    <select id="selectMoldCode" class="form-control"></select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <strong>CONTROL #:</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="txtControlNo">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <strong>TYPE:</strong>
                                                    </label>
                                                    <select id="selectType" class="form-control"></select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <strong>ISSUED DATE:</strong>
                                                    </label>
                                                    <input type="date" class="form-control" id="txtIssuedDate">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <strong>ISSUED TIME:</strong>
                                                    </label>
                                                    <input type="time" class="form-control" id="txtIssuedTime">
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <strong>REMARKS:</strong>
                                                    </label>
                                                    <textarea id="txtRemarks" class="form-control" rows="5"></textarea>
                                                </div>
                                                <input type="hidden" id="hiddenID">
                                                <hr>
                                                <input type="hidden" id="hiddenID">
                                                <button class="btn btn-primary" id="btnAdd">Submit</button>
                                                <button class="btn btn-primary" id="btnUpdate" style="display: none;">Save</button>
                                                <button class="btn btn-default" id="btnCancel" style="display: none;">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 pricing-box">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">LIST</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div id="table-records"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "partials/footer.php";?>
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div>
    <!-- JavaScript -->
    <script src="/<?php echo $rootFolder; ?>/script/Register.js?v=<?php echo $generateRandomNumber; ?>"></script>
    <script>
        let register = new Register();

        //DISPLAY RECORDS
        register.DisplayRecords("#table-records");
        resetForm();

        $("#btnOpenModalAdd").click(function(){
            
            $("#modalAdd").modal("show");

        });
        $("#btnAdd").click(function(){

            register.moldCode = $("#selectMoldCode");
            register.controlNo = $("#txtControlNo");
            register.type = $("#selectType");
            register.issuedDate = $("#txtIssuedDate");
            register.issuedTime = $("#txtIssuedTime");
            register.remarks = $("#txtRemarks");
            register.table = "#table-records";

            register.InsertRecord(register, function(response){
                if(response == true){
                    resetForm();
                }
            });

        });
        $("#table-records").on("click", ".btnEditRecord", function(){
            let id = $(this).val();

            register.id = id;
            register.moldCode = $("#selectMoldCode");
            register.controlNo = $("#txtControlNo");
            register.type = $("#selectType");
            register.issuedDate = $("#txtIssuedDate");
            register.issuedTime = $("#txtIssuedTime");
            register.remarks = $("#txtRemarks");
            register.table = "#table-records";
            register.hiddenID = $("#hiddenID");
            register.btnAdd = $("#btnAdd");
            register.btnCancel = $("#btnCancel");
            register.btnUpdate = $("#btnUpdate");

            register.SetRecord(register);
        });
        
        $("#btnUpdate").click(function(){

            register.moldCode = $("#selectMoldCode");
            register.controlNo = $("#txtControlNo");
            register.type = $("#selectType");
            register.issuedDate = $("#txtIssuedDate");
            register.issuedTime = $("#txtIssuedTime");
            register.remarks = $("#txtRemarks");
            register.id = $("#hiddenID");
            register.modal = $("#modalEdit");
            register.table = "#table-records";
            register.btnAdd = $("#btnAdd");
            register.btnCancel = $("#btnCancel");
            register.btnUpdate = $("#btnUpdate");

            $("#btnAdd").show();
            $("#btnUpdate").hide();
            $("#btnCancel").hide();

            register.UpdateRecord(register, function(response){
                if(response == true){
                    resetForm();
                }
            });
        });
        $("#table-records").on("click", ".btnRemoveRecord", function(){
            let id = $(this).val();

            record.table = "#table-records";
            record.id = id;
            
            record.RemoveRecord(record);

        });
        $("#btnCancel").click(function(){

            $("#btnAdd").show();
            $("#btnUpdate").hide();
            $("#btnCancel").hide();
            resetForm();

        });

        function resetForm(){
            $("#txtIssuedDate").val(main.GetCurrentDate());
            $("#txtIssuedTime").val(main.GetCurrentTime());
            register.PopulateMoldCode($("#selectMoldCode"));
            register.PopulateType($("#selectType"));
            $("#txtControlNo").val("");
            $("#txtRemarks").val("");
            $("#hiddenID").val("");

        }


    </script>

