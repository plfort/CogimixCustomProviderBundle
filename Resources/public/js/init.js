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
	$modalBody.on('submit','form',function(evnet){
		var formData = $(this).serialize();
		$.post($(this).attr('action'),formData,function(response){
			if(response.success==true){
				$modalBody.find('div#customProviderInfoForm').before('<div class="span3 center alert alert-success">Saved !</div>')

				if(response.data.formType=='create'){
					$modalBody.find("#customProviderInfoList").append(response.data.newItem);
				    
				}
				//$("#manageCustomProviderModal").modal('toggle');
			}else{
				var formContainer=$modalBody.find('div#customProviderInfoForm')
				formContainer.html(response.data.formHtml);
			}
		},'json');
		console.log('submit form customProvider')
		return false;
	});
});