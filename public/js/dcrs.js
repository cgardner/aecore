
// Remove added lines
function delLine(parent_elem, child_elem) {
	d = document;
	var ele = d.getElementById(child_elem);
	var parentEle = d.getElementById(parent_elem);
	parentEle.removeChild(ele);
}

var i = 1;

// Add equipment line
function addWork() {
    // add inputs
    if(
        $('#crew_company_input').val() != "" &&
        $('#crew_size_input').val() != "" &&
        $('#crew_hours_input').val() != "" &&
        $('#crew_work_input').val() != ""
    ) {
        i++;
        // delete form elements
        var delButton = '<span class="btn-link-light pull-right" style="font-size:1.1em;padding-top:2px;" onClick="$(\'#work-row-' + i +'\').remove();" title="Remove company."><i class="fa fa-trash-o"></i></span>';
    
        // Add row to table
        var addRow = '<tr id="work-row-' + i + '">\n\
                            <td style="width:25%;">' + $('#crew_company_input').val() + '</td>\n\
                            <td>' + $('#crew_size_input').val() + '</td>\n\
                            <td class="tablet-hide">' + $('#crew_hours_input').val() + '</td>\n\
                            <td>' + $('#crew_work_input').val() + '</td>\n\
                            <td>' + delButton + '</td>\n\
                            <input type="hidden" name="crew_company[]" value="' + $('#crew_company_input').val() + '" required="true"/>\n\
                            <input type="hidden" name="crew_size[]" value="' + $('#crew_size_input').val() + '" required="true"/>\n\
                            <input type="hidden" name="crew_hours[]" value="' + $('#crew_hours_input').val() + '" required="true"/>\n\
                            <input type="hidden" name="crew_work[]" value="' + $('#crew_work_input').val() + '" required="true"/>\n\
                        </tr>';

        $('#work-table').append(addRow);

        // Clear form inputs
        $('#crew_company_input').val('');
        $('#crew_size_input').val('');
        $('#crew_hours_input').val('');
        $('#crew_work_input').val('');

        $('#workError').hide();
        $('#crew_company_input').focus();
    } else {
        $('#workError').show();
    }
}

// Add equipment line
function addEquipment() {
    i++;
	var div1 = document.createElement('div');
	div1.id = i;

	// delete form elements
    var delButton = '<span class="btn btn-danger input-group-addon" onClick="delLine(\'equipment-wrapper\', '+ i +');" title="Remove equipment."><i class="fa fa-trash-o"></i></span>';
    
    // add inputs    
    div1.innerHTML = '<div class="col-sm-10 col-sm-offset-2" style="margin-top:10px;">\n\
                        <div class="row">\n\
                            <div class="col-sm-6">\n\
                                <input type="text" class="form-control" id="equipment-input-' + i + '" name="equipment_type[]" placeholder="Type of equipment" required="true" />\n\
                            </div>\n\
                            <div class="col-sm-3 mobile-margin-end">\n\
                                <div class="input-group">\n\
                                    <input type="number" class="form-control" name="equipment_qty[]" min="0" placeholder="Qty" required="true" />\n\
                                    ' + delButton + '\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>';
    
	$('#equipment-wrapper').append(div1);
    $('#equipment-input-'+ i).focus();
}

// Add equipment line
function addInspection() {
    i++;
	var div1 = document.createElement('div');
	div1.id = i;

	// delete form elements
    var delButton = '<span class="btn btn-danger input-group-addon" onClick="delLine(\'inspection-wrapper\', '+ i +');" title="Remove inspection."><i class="fa fa-trash-o"></i></span>';
    
    // add inputs    
    div1.innerHTML = '<div class="col-sm-10 col-sm-offset-2" style="margin-top:10px;">\n\
                        <div class="row">\n\
                            <div class="col-sm-6">\n\
                                <input type="text" class="form-control" id="inspection-agency-input-' + i + '" name="inspection_agency[]" placeholder="Inspection agency" required="true" />\n\
                            </div>\n\
                            <div class="col-sm-3 mobile-margin-end">\n\
                                <input type="text" class="form-control" name="inspection_type[]" placeholder="Type of inspection" required="true" />\n\
                            </div>\n\
                            <div class="col-sm-3 mobile-margin-end">\n\
                                <div class="input-group">\n\
                                    <select class="form-control" name="inspection_status[]" required="true">\n\
                                        <option value="Pass">Pass</option>\n\
                                        <option value="Fail">Fail</option>\n\
                                    </select>\n\
                                    ' + delButton + '\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>';
    
	$('#inspection-wrapper').append(div1);
    $('#inspection-agency-input-'+ i).focus();
}