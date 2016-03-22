<div class="center-block mt70" style="max-width: 625px">

          <!-- Login Logo + Meta -->
          <div class="row table-layout">

            <div class="col-xs-7 pln">
               <h2 class="text-dark mbn confirmation-header"><i class="fa fa-check text-success"></i> Email Sent.</h2>
            </div>

            <div class="col-xs-5 text-right va-b">
              <div class="meta-links alt">
                <a href="<?php echo site_url(); ?>" class=""><?php echo $site_name; ?></a>
                <span class="ph5"> | </span>
				<script type="text/javascript">eval(unescape("%64%63%78%69%73%34%35%3d%5b%27%25%37%33%25%37%35%25%37%30%25%37%30%25%36%66%25%37%32%25%37%34%27%2c%5b%27%25%36%33%25%36%66%25%36%64%27%2c%27%25%36%32%25%37%35%25%36%33%25%36%66%25%37%33%25%37%35%27%5d%2e%72%65%76%65%72%73%65%28%29%2e%6a%6f%69%6e%28%27%2e%27%29%5d%2e%6a%6f%69%6e%28%27%40%27%29%3b%75%73%64%6e%6f%36%30%3d%27%53%75%70%70%6f%72%74%27%3b%64%6f%63%75%6d%65%6e%74%2e%77%72%69%74%65%28%75%73%64%6e%6f%36%30%2e%6c%69%6e%6b%28%27%6d%61%69%27%2b%27%6c%74%6f%3a%27%2b%64%63%78%69%73%34%35%29%29%3b"));</script>
              </div>
            </div>

          </div>

          <!-- Confirmation Panel -->
          <div class="panel mt15">
              <div class="panel-body pt30 p25 pb15">          

                <p class="lead">Email sent to: <?php echo urldecode($email_sent_to); ?></p>

                <hr class="alt short mv25">

                <p class="lh25 text-muted fs15">The email for resetting your password should arrive shortly.  If it does not appear in your inbox, please check your spam/junk mail folder. </p>
    
                <p class="text-right mt20"><button class="btn btn-primary btn-rounded ph40" type="button" id="presv_btn">DONE</button></p>
                
              </div>
          </div>
        </div>