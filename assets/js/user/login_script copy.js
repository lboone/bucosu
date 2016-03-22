  jQuery(document).ready(function() {

    "use strict";

    // Init Theme Core    
    Core.init();

    // Init Demo JS     
    Demo.init();

    // Inline Admin-Form example 
    $.magnificPopup.open({
      removalDelay: 500, //delay removal by X to allow out-animation,
      src: '#modal-form',
      type: 'inline',
      mainClass: 'mfp-flipInX',
      midClick: true
    });
  });