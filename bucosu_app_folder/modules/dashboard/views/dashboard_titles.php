        
<div class="row mb10">
<?php foreach ($dashboard_title_data as $value): ?>
    <div class="col-sm-6 col-md-3">
      <div class="panel <?php echo $value['color']; ?> light of-h mb10">
        <div class="pn pl20 p5">
          <div class="icon-bg">
            <i class="fa <?php echo $value['icon']; ?>"></i>
          </div>
          <h2 class="mt15 lh15">
            <b><?php echo $value['data']; ?></b>
          </h2>
          <h5 class="text-muted"><?php echo $value['title']; ?></h5>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>


<?php echo $dashboard_panels ;?>


<!--

          <div class="col-sm-6 col-md-3">
            <div class="panel bg-primary light of-h mb10">
              <div class="pn pl20 p5">
                <div class="icon-bg">
                  <i class="fa fa-building"></i>
                </div>
                <h2 class="mt15 lh15">
                  <b>19</b>
                </h2>
                <h5 class="text-muted">Total Schools</h5>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="panel bg-alert light of-h mb10">
              <div class="pn pl20 p5">
                <div class="icon-bg">
                  <i class="fa fa-check-square-o"></i>
                </div>
                <h2 class="mt15 lh15">
                  <b>45 %</b>
                </h2>
                <h5 class="text-muted">BCS Complete</h5>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="panel bg-success light of-h mb10">
              <div class="pn pl20 p5">
                <div class="icon-bg">
                  <i class="fa fa-dollar"></i>
                </div>
                <h2 class="mt15 lh15">
                  <b>$630,000</b>
                </h2>
                <h5 class="text-muted">Estimated Cost</h5>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="panel bg-danger light of-h mb10">
              <div class="pn pl20 p5">
                <div class="icon-bg">
                  <i class="fa fa-warning"></i>
                </div>
                <h2 class="mt15 lh15">
                  <b>8</b>
                </h2>
                <h5 class="text-muted">Critical Items</h5>
              </div>
            </div>
          </div>
-->