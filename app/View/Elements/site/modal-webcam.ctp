<style>
#camera {
  width: 100%;
  height: 350px;
}
</style>
<div class="modal fade" style="display: block;" id="modalWebcam" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    		<h4 class="modal-title" id="modalCategoriaLabel">WEBCAM</h4>
    	</div>
    	<div class="modal-body">
			<div class="container">
		        <div class="col-md-6">
		            <div class="text-center">
		        		<div id="camera_info"></div>
		    			<div id="camera"></div><br>
		    			<button id="take_snapshots" class="btn btn-success btn-sm">Take Snapshots</button>
		      		</div>
		        </div>
		        <div class="col-md-6">
		            <table class="table table-bordered">
		            <thead>
		                <tr>
		                    <th>Image</th><th>Image Name</th>
		                </tr>
		            </thead>
		            <tbody id="imagelist">
		            
		            </tbody>
		        </table>
		        </div>
		    </div> <!-- /container -->
    	</div>
  	</div>
	</div>
</div>