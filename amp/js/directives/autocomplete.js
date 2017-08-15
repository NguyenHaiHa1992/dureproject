angular.module('app').directive('autoComplete', function($timeout, $http, BASE_URL) {
    return {
		   restrict: "A",
		   scope: { uiItems: '=' ,  uiItem: '=' ,  ngModel: '=', uiObject: '=', uiOther: '=',  uiOther1: '='},
		   link: function(scope, iElement, iAttrs){
		   		if(scope.uiItem == 'part_code'){
		   			$(iElement).autocomplete({
		   				source: function( request, response ) {
		   					$http.post(BASE_URL + '/part/getAll', {part_code: request.term, limitnum: 10, limitstart: 0})
		   					.success(function(data) {
		   						var tmp_response= [];
		   						$.each(data.parts, function(key, part){
		   							tmp_response.push({label: part.part_code, uiObject: part});
		   						});
		   						response(tmp_response);
		   					})
		   				},
		   				select: function( event, ui) {
							scope.$apply(function() {
			   					scope.uiObject = ui.item.uiObject;
			   					scope.uiOther = ui.item.uiObject.id;
			   					scope.uiOther1 = ui.item.uiObject.price;
							});
		   				},
		   				delay: 200,
		   				minLength: 0
		   			}).focus(function() {
		   				setTimeout(function(){
		   					if(iElement.val() == '')
		   						$(iElement).autocomplete("search", "");
		   				}, 200);
					});

		   		}

		   		else if(scope.uiItem == 'material_code'){
		   			$(iElement).autocomplete({
		   				source: function( request, response ) {
		   					$http.post(BASE_URL + '/material/getAll', {material_code: request.term, limitnum: 10, limitstart: 0})
		   					.success(function(data) {
		   						var tmp_response= [];
		   						$.each(data.materials, function(key, material){
		   							tmp_response.push({label: material.material_code, uiObject: material});
		   						});
		   						response(tmp_response);
		   					})
		   				},
		   				select: function( event, ui) {
							scope.$apply(function() {
			   					scope.uiObject = ui.item.uiObject;
							});
		   				},
		   				delay: 200,
		   				minLength: 0
		   			}).focus(function() {
		   				setTimeout(function(){
		   					if(iElement.val() == '')
		   						$(iElement).autocomplete("search", "");
		   				}, 200);
					});
		   		}

		   		else if(scope.uiItem == 'po_code_header'){
		   			$(iElement).autocomplete({
		   				source: function( request, response ) {
		   					$http.post(BASE_URL + '/purchaseOrder/getAll', {po_code: request.term, limitnum: 10, limitstart: 0})
		   					.success(function(data) {
		   						var tmp_response= [];
		   						$.each(data.purchase_orders, function(key, purchase_order){
		   							tmp_response.push({label: purchase_order.po_code, uiObject: purchase_order});
		   						});
		   						response(tmp_response);
		   					});
		   				},
		   				select: function( event, ui) {
		   					scope.uiObject = ui.item.uiObject;
		   				},
		   				minLength: 0
		   			});
		   		}

		   		else if(scope.uiItem == 'po_code'){
					$(iElement).autocomplete({
		   				source: function( request, response ) {
		   					$http.post(BASE_URL + '/purchaseOrder/getAll', {po_code: request.term, limitnum: 10, limitstart: 0})
		   					.success(function(data) {
		   						var tmp_response= [];
		   						$.each(data.purchase_orders, function(key, purchase_order){
		   							tmp_response.push({label: purchase_order.po_code, uiObject: purchase_order});
		   						});
		   						response(tmp_response);
		   					})
		   				},
		   				select: function( event, ui) {
							scope.$apply(function() {
			   					scope.uiObject = ui.item.uiObject;
			   					scope.ngModel = ui.item.label;
							});
		   				},
		   				delay: 200,
		   				minLength: 0
		   			}).focus(function() {
		   				setTimeout(function(){
		   					if(iElement.val() == '')
		   						$(iElement).autocomplete("search", "");
		   				}, 200);
					});
		   		}

				else if(scope.uiItem == 'po_code_sidebar'){
					$(iElement).autocomplete({
		   				source: function( request, response ) {
		   					$http.post(BASE_URL + '/purchaseOrder/getAll', {po_code: request.term, limitnum: 10, limitstart: 0})
		   					.success(function(data) {
		   						var tmp_response= [];
		   						$.each(data.purchase_orders, function(key, purchase_order){
		   							tmp_response.push({label: purchase_order.po_code, uiObject: purchase_order});
		   						});
		   						response(tmp_response);
		   					})
		   				},
		   				select: function( event, ui) {
							scope.$apply(function() {
			   					scope.uiObject = ui.item.uiObject;
			   					scope.ngModel = ui.item.label;
							});
		   				},
		   				delay: 200,
		   				minLength: 0
		   			}).focus(function() {
		   				setTimeout(function(){
		   					if(iElement.val() == '')
		   						$(iElement).autocomplete("search", "");
		   				}, 200);
					});
		   		}

		   		else if(scope.uiItem == 'client_name'){
		   			$(iElement).autocomplete({
		   				source: function( request, response ) {
		   					$http.post(BASE_URL + '/client/getAll', {name: request.term, limitnum: 10, limitstart: 0})
		   					.success(function(data) {
		   						var tmp_response= [];
		   						$.each(data.clients, function(key, client){
		   							tmp_response.push({label: client.name, uiObject: client});
		   						});
		   						response(tmp_response);
		   					})
		   				},
		   				select: function( event, ui) {
							scope.$apply(function() {
			   					scope.uiObject = ui.item.uiObject;
							});
		   				},
		   				delay: 200,
		   				minLength: 0
		   			}).focus(function() {
		   				setTimeout(function(){
		   					if(iElement.val() == '')
		   						$(iElement).autocomplete("search", "");
		   				}, 200);
					});
		   		}

		   		else{

		   		}
		     }
		  };
});