   <div class="center-block mt50 mw800">
          <h1 class="error-title">401</h1>
          <h2 class="error-subtitle">You don't have access to this area of the site.</h2>
        </div>
        <div class="mid-section">
          <div class="mid-content clearfix">
            <img src="<?php echo $logo['src']; ?>" class="<?php echo $logo['class']; ?>" alt="<?php echo $logo['title']; ?>">
          </div>
        </div>

        <a href="<?php echo site_url(); ?>" id="return-arrow">
          <i class="fa fa-arrow-left fa-3x text-primary"></i>
          <span> Return
            <br> to <?php echo $site_name; ?></span>
        </a>