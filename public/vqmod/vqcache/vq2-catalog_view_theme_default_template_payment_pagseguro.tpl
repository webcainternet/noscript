<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=payment/pagseguro/confirm',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},
		success: function() {
			
				
                    PagSeguroLightbox({
                     code: '<?php echo substr($url,59); ?>'
                     }, {
                     success : function(transactionCode) {
                     	 location.href='index.php?route=checkout/success';
                     },
                     abort : function() {
                     alert("Pagamento incompleto!, efetue o Pedido Novamente e conclua o Pagamento.");
                     }
                     });
                    if (!PagSeguroLightbox){
                     location.href='<?php echo $url; ?>';
                    }
				
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script>
