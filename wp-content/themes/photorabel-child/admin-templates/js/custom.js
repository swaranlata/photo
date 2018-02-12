$(document).ready(function(){
    $(document).on('click','.removeCrnt',function(){
      $('.loading_image').show();  
      var url= $(this).attr('data-att-href');
      $(this).parent().parent().remove();
        window.location.href=url;  
    });
    $('.alert-success').delay(1000).fadeOut();
    jQuery('#example').DataTable();
    
    
    
    
    
    
    
});