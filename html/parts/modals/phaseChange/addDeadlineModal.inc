<!-- Modal for Adding Deadline Types -->
<div class="modal fade" id="addDeadlineModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addDeadlineTitle">Přidat termín</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="deadlineTypesBox">Vyberte typ termínu:</label>
                    <select id="deadlineTypesBox" class="selectpicker" data-style='select-with-transition'>
                        <?php echo createHtmlSelectOptions(selectAllDeadlineTypes($_GET['idProject']), 'idDeadlineType', 'name'); ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zavřít</button>
                <button type="button" id="addDeadlineType" class="btn btn-success">Přidat</button>
            </div>
        </div>
    </div>
</div>