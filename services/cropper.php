<div class="modal" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cropp your img</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <img id="modalImg"  height="400">
                </div>
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="color:white"></i></button>
                <button id="rotateImg" class="btn btn-primary"><i class="fa fa-arrows-alt" style="color:white"></i></button>
                <button id="croppImg" class="btn btn-success"><i class="fa fa-cut" style="color:white"></i></button>
            </div>
        </div>
    </div>
</div>