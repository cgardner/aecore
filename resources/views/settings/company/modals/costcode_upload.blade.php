<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Upload Cost Codes</h4>
</div>
<!-- Add collaborator form -->
{!! Form::open(array('url' => 'settings/company/costcodes/upload', 'method' => 'post', 'class' => 'form-horizontal no-margin', 'files'=>'true')) !!}
    <div class="modal-body">
        <div class="form-group no-margin">
            <div class="col-sm-12">
                <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
                <h4>Step 1 - Create a Plaintext File</h4>
                <p>a. Create a plaintext file using an editor such as Notepad.
                    <br>b. Enter your cost codes and descriptions separated by a space.
                    <br>c. Each cost code should be on a new line.
                    <br>d. Save your document as a .txt file.
                </p>
                <p>Example of properly formatted file:</p>
                <img src="{!! asset('/css/img/help/cost_codes.png') !!}" alt="Cost Code Sample"/>
                <p class="light">
                    Note: Cost codes with dashes, such as 2327-0990-01, are acceptable.<br>
                    <strong>Cost codes with spaces will not upload properly.</strong>
                </p>
                <br/>
                <h4>Step 2 - Upload File</h4>
                <p>Select the .txt file you created:</p>
                <input name="uploadedfile" type="file" style="border:none;"/>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="margin:0;">
        <button type="submit" class="btn btn-success" title="Upload cost codes.">Upload</button>
        <button type="button" class="btn btn-default btn-spacer-left" data-dismiss="modal">Cancel</button>
    </div>
{!! Form::close() !!}