class Register extends Main{

    constructor(){
        super()
        this.table1 = null;

    }

    DisplayRecords(tableElem){
        let self = this;

        $.ajax({
            url: "php/controllers/Register/Records.php",
            method: "POST",
            data: {},
            datatype: "json",
            success: function(response){

                // console.log(response);

                self.table1 = new Tabulator(tableElem, {
                    data: response.data,
                    pagination: "local",
                    paginationSize: 10,
                    paginationSizeSelector: [10, 25, 50, 100],
                    page: 1,
                    ajaxURL: "your_data_endpoint_here.json",
                    layout: "fitDataFill",
                    columns: [
                        {title: "ID", field: "RID", headerFilter: "input", visible: false,},
                        // {title: "JOB ORDER", field: "JOB_ORDER", headerFilter: "input"},
                        {title: "MOLD CODE", field: "MOLD_CODE", headerFilter: "input"},
                        {title: "CONTROL#", field: "CONTROL_NO", headerFilter: "input"},
                        {title: "TYPE", field: "TYPE", headerFilter: "input"},
                        {title: "ISSUED DATE", field: "ISSUED_DATE", headerFilter: "input"},
                        {title: "ISSUED TIME", field: "ISSUED_TIME", headerFilter: "input"},
                        {title: "CREATED AT", field: "CREATED_AT", headerFilter: "input"},
                        {title: "ACTION", field:"RID", hozAlign: "left", headerSort: false, frozen:true, formatter:function(cell){
                            let id = cell.getValue();
                            let edit = '<button class="btn btn-primary btn-minier btnEditRecord" value="'+id+'">Edit</button>';
                            let remove = '<button class="btn btn-danger btn-minier btnRemoveRecord" value="'+id+'">Remove</button>';

                            return edit;
                        }},
                    ],
                });
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    PopulateMoldCode(selectElem, selectedCode){
        let list = JSON.parse(localStorage.getItem(this.lsMoldList));
        var options = '<option value="">-Select-</option>';
    
        for (var i = 0; i < list.length; i++) {
            let selected = "";

            if(selectedCode != undefined && selectedCode == list[i].MOLD_CTRL){
                selected = "selected";
            }

            options += '<option value="' + list[i].MOLD_CTRL + '" '+selected+'>' + list[i].MOLD_CTRL + ' | ' + list[i].ITEM_CODE + ' | ' + list[i].ITEM_NAME + '</option>';
        }
        
        
        selectElem.html(options);

        selectElem.select2({
            placeholder: 'Select Mold',
            
        });

    }
    PopulateType(selectElem, selectedID){
        let list = JSON.parse(localStorage.getItem(this.lsTypeList));
        var options = '<option value="">-Select-</option>';
    
        for (var i = 0; i < list.length; i++) {
            let selected = "";

            if(selectedID != undefined && selectedID == list[i].RID){
                selected = "selected";
            }

            options += '<option value="' + list[i].RID + '" '+selected+'>' + list[i].TYPE_DESC + '</option>';
        }
        
        selectElem.html(options);

        selectElem.select2({
            placeholder: 'Select Type',
            
        });
    }
    InsertRecord(record, callback){
        let self = this;
        
        if(record.moldCode.val() == "" || record.controlNo.val() == "" || record.type.val() == "" || record.issuedDate.val() == "" || record.issuedTime.val() == ""){
            Swal.fire({
                title: 'Incomplete Form.',
                text: 'Please complete the form.',
                icon: 'warning'
            })
        } else {
            $.ajax({
                url: "php/controllers/Register/InsertRecord.php",
                method: "POST",
                data: {
                    moldCode: record.moldCode.val(),
                    controlNo: record.controlNo.val(),
                    type: record.type.val(),
                    issuedDate: record.issuedDate.val(),
                    issuedTime: record.issuedTime.val(),
                    remarks: record.remarks.val(),

                },
                success: function(response){
                    response = JSON.parse(response);
                    console.log(response);

                    if(response.status == "duplicate"){

                        Swal.fire({
                            title: 'Duplicate.',
                            text: 'Please input an unique description.',
                            icon: 'warning'
                        })
                    } else if(response.status == "success"){
    
                        Swal.fire({
                            title: 'Record added successfully!',
                            text: '',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Proceed!',
                            timer: 2000,
                            willClose: () => {
                                self.DisplayRecords(record.table);
                            },
                        })

                        callback(true);
                    }
                    
                },
                error: function(err){
                    console.log("Error:"+JSON.stringify(err));
                },
            });

            //REFRESH RECORD
            this.DisplayRecords(record.table);
            
        }
    }
    SetRecord(record){
        let self = this;

        $.ajax({
            url: "php/controllers/Register/GetRecord.php",
            method: "POST",
            data: {
                id: record.id,
            },
            datatype: "json",
            success: function(data){
                console.log(data);

                self.PopulateMoldCode(record.moldCode, data.MOLD_CODE);
                record.controlNo.val(data.CONTROL_NO);
                self.PopulateType(record.type, data.TYPE);
                record.issuedDate.val(data.ISSUED_DATE);
                record.issuedTime.val(data.ISSUED_TIME);
                record.remarks.val(data.REMARKS);
                record.hiddenID.val(record.id);

                if(record.btnAdd != undefined || record.btnCancel != undefined || record.btnUpdate != undefined){
                    record.btnAdd.hide();
                    record.btnCancel.show();
                    record.btnUpdate.show();
                }
                
            },
            error: function(err){
                console.log("Error:"+JSON.stringify(err));
            },
        });
    }
    UpdateRecord(record, callback){
        let self = this;
        
        if(record.moldCode.val() == "" || record.controlNo.val() == "" || record.type.val() == "" || record.issuedDate.val() == "" || record.issuedTime.val() == ""){
            Swal.fire({
                title: 'Incomplete Form.',
                text: 'Please complete the form.',
                icon: 'warning'
            })
        } else {
            $.ajax({
                url: "php/controllers/Register/UpdateRecord.php",
                method: "POST",
                data: {
                    moldCode: record.moldCode.val(),
                    controlNo: record.controlNo.val(),
                    type: record.type.val(),
                    issuedDate: record.issuedDate.val(),
                    issuedTime: record.issuedTime.val(),
                    remarks: record.remarks.val(),
                    id: record.id.val(),
                },
                success: function(response){
                    response = JSON.parse(response);
                    console.log(response);

                    if(response.status == "duplicate"){

                        Swal.fire({
                            title: 'Duplicate.',
                            text: 'Please input an unique description.',
                            icon: 'warning'
                        })
                    } else if(response.status == "success"){

                        if(record.btnAdd != undefined || record.btnCancel != undefined || record.btnUpdate != undefined){
                            record.btnAdd.show();
                            record.btnCancel.hide();
                            record.btnUpdate.hide();
                        }

                        Swal.fire({
                            title: 'Record updated successfully!',
                            text: '',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Proceed!',
                            timer: 2000,
                            willClose: () => {
                                self.DisplayRecords(record.table);
                                callback(true)
                            },
                        })
                    }
                    
                },
                error: function(err){
                    console.log("Error:"+JSON.stringify(err));
                },
            });

            //REFRESH RECORD
            this.DisplayRecords(record.table);
        }
    }


}