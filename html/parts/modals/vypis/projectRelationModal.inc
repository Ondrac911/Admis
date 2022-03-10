<div id="projectRelationModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="../submits/editRealtions.php" id="relationForm" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editace relací projektu</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="projectId">
                    <?php print_r(relationSelects())?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zavřít</button>
                    <input class="btn btn-success" type="submit" value="Uložit">
                </div>
            </form>
        </div>
    </div>
</div>