$(document).ready(function(){
	var $modal = $("#manageCustomProviderModal");
	var $modalBody = $("#manageCustomProviderModal .modal-body");
	$("#manageCustomSourceBtn").click(function(event){
		$.get(Routing.generate('_customprovider_manage_modal'),function(response){
			if(response.success==true){
				$modalBody.html(response.data.modalContent);
				$("#manageCustomProviderModal").modal('toggle');
			}
		},'json');
		
	});
	
	
	$modal.on('click','.customProviderItem',function(event){
		$modal.find('li').removeClass('active');
		$(this).closest('li').addClass('active');
		$.get(Routing.generate('_customprovider_edit',{'id':$(this).data('id')}),function(response){
			if(response.success==true){
				var formContainer=$modalBody.find('div#customProviderInfoForm')
				formContainer.html(response.data.formHtml);
				//$("#manageCustomProviderModal").modal('toggle');
			}
		},'json');
	});
	
	$modalBody.on('click','#createCustomProviderInfoBtn',function(event){
		$.get(Routing.generate('_customprovider_create'),function(response){
			if(response.success==true){
				var formContainer=$modalBody.find('div#customProviderInfoForm')
				formContainer.html(response.data.formHtml);
				//$("#manageCustomProviderModal").modal('toggle');
			}
		},'json');
		
		return false;
		
	});
	
	$modalBody.on('click','.removeCustomProviderInfoBtn',function(event){
		$.get($(this).attr('href'),function(response){
			if(response.success==true){
				$modalBody.find("#customProviderInfoList a[data-id='"+response.data.id+"']").parent().remove();
				$modalBody.find("#customProviderInfoForm").empty();
				$modal.addClass('refreshOnClose');
			}
		},'json');
		
		return false;
		
	});
	
	$modalBody.on('click','.testCustomProviderBtn',function(event){
		
		var formData = $(this).closest('form').serialize();
		$.post(Routing.generate('_customprovider_test'),formData,function(response){
			$modalBody.children('.testCustomProviderResult').empty();
			if(response.success==true){
				$modalBody.find('.testCustomProviderResult').html('<div class="alert alert-success">'+response.data.message+'</div>');
			}else{
				$modalBody.find('.testCustomProviderResult').html('<div class="alert alert-danger">'+response.data.message+'</div>');
			}
			
		},'json');
		return false;
	});
	
	$modalBody.on('submit','form',function(event){
		var formData = $(this).closest('form').serialize();
		var currentForm = $(this);
		$.post($(this).attr('action'),formData,function(response){
			currentForm.find('.formMessage').empty();
			if(response.success==true){
				$modal.addClass('refreshOnClose');
				currentForm.find('.formMessage').html('<div class="col-sm-12 center alert alert-success">Saved !</div>')
				if(response.data.formType=='create'){
					$modalBody.find("#customProviderInfoList").append(response.data.newItem);
				    
				}
		
			}else{
				var formContainer=$modalBody.find('div#customProviderInfoForm')
				formContainer.html(response.data.formHtml);
			}
		},'json');
		
		return false;
	});
});