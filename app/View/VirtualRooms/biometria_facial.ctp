<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Index View
 *
*/ ?>
<style>
#camera {
  width: 100%;
  height: 350px;
  margin: 0 auto;
  text-align: center;
}
</style>
<div class="container">
  <div class="page-section">
    <div class="row">
      <div class="col-md-12">
        <div class="container">
          <div class="col-md-3 col-xs-12"></div>
          <div class="col-md-6 col-xs-12">
            <div class="text-center">
              <div id="camera_info"></div>
              <div id="camera"></div><br>
              <button id="take_snapshot_avatar" class="btn btn-success btn-sm">Fotografar</button>
            </div>
          </div>
          <div class="col-md-3 col-xs-12"></div>
        </div><!-- /container -->
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          <div class="container">
            <div id="imagelist"></div>
          </div>
      </div>
    </div>
  </div>
</div>
