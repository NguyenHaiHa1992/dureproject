angular.module('app').directive('ampautocomplete', function($timeout, $http, BASE_URL) {
    return {
    	restrict: "A",
		scope: { ngModel: '=', uiOption: '=', uiName: '=', uiId: '=', ngDisabled: '=', searchField: '=', uiModellabel: '='},
		link: function(scope, iElement, iAttrs){
			var PAGER_COUNT = 10;
			var th = $(iElement);
			var container_div = th.parent();
			var source = th.attr('data-source');
			var element_id = th.attr('id');
			var placeholder = th.attr('placeholder');
			var searchField = scope.searchField;

			// Hide input box
			th.hide();
			th.after( '<div class="chosen-container chosen-container-single" style="width: 100%;" title="" id="' + element_id + '_ampautocomplete"><a class="chosen-single chosen-default" tabindex="-1"><span>'+ placeholder +'</span><div><b></b></div></a><div class="chosen-drop"><div class="chosen-search"><input type="text" autocomplete="off" class="ui-autocomplete-input"></div><ul class="chosen-results"></ul></div></div>' );

			var parent_id = element_id + '_ampautocomplete';
			var parent = $('#' + parent_id);

			container_div.on('click', '.chosen-default', function(){
				if(!scope.ngDisabled){
					parent.addClass('chosen-container-active chosen-with-drop');
				}
			});

			if(source != undefined){
				$('input[type="text"]' , parent).autocomplete({
				    minLength: 0,
				    source: function( request, response ) {
						var information_post = {
							//scope.searchField: request.term,
							limitnum: PAGER_COUNT,
							limitstart: 0,
						};

						information_post[scope.searchField] = request.term;

						$http.post(BASE_URL + source, information_post)
					    .success(function(data) {
						    if(data.success) {
								var result_html = '';
								$.each(data[scope.uiOption], function(i,v){
									result_html = result_html + '<li class="active-result" style="" data-id="' + v[scope.uiId] + '">' + v[scope.uiName] + '</li>';
								});
								$('.chosen-results', parent).html(result_html);

								// Update pagination
								var pagination = '';
								var limitstart = 0;

								pagination = '<ul class="chosen-pagination">';

								for(var i = 0; limitstart + PAGER_COUNT < data.totalresults; i++){
									limitstart = i * PAGER_COUNT;
									var current_class = '';
									if(i == 0)
										current_class = 'current';

									var pagination = pagination + '<a href="#" class="chosen-pagination-item ' + current_class + '" data-limitstart="' + limitstart + '">' + (i + 1)  + '</a>';
								}
								pagination = pagination + '</ul>';

								if($('.chosen-drop-footer', parent).length == 0)
									$('.chosen-drop', parent).append('<div class="chosen-drop-footer"></div>');
								$('.chosen-drop-footer', parent).html(pagination);
						    }
						    else{
						    	swal({
						    		title: '',
						    		text: data.message,
						    		type: 'error',
						    		html: true
						    	});
						    }
						})
						.error(function(data, status, headers, config) {
				    		$state.go('404');	
				  		});
				    }
				}).focus(function(){
					if (this.value == "")
						$(this).autocomplete("search");
				})
			}

			// Select result
			container_div.on('click', '.active-result', function(){
				var parent_id = element_id + '_ampautocomplete';
				var parent = $('#' + parent_id);
				var id = $(this).attr('data-id');
				var name = $(this).text();

				// Update model value
				scope.$apply(function() {
					scope.ngModel = id;
			   	});
				parent.removeClass('chosen-container-active').removeClass('chosen-with-drop');
				$('.chosen-default span', container_div).text(name);
			})

			// Pagination
			$('.chosen-container', container_div).on('click', '.chosen-pagination-item', function(e){
				e.preventDefault();

				if(!$(this).hasClass('current')){
					var limitstart = $(this).attr('data-limitstart');
					var chosen = $(this).parents('.chosen-container');
					var term = $('input[type="text"]' , chosen).val();
					var chosen_id = chosen.attr('id');
					var select_id = chosen_id.slice(0, -7);
					var select = $('#' + select_id);

					var information_post = {
						//material_code: term,
						limitnum: PAGER_COUNT,
						limitstart: parseInt(limitstart),
					};

					information_post[scope.searchField] = term;

					$http.post(BASE_URL + source, information_post)
				    .success(function(data) {
					    if(data.success) {
							var result_html = '';
							$.each(data[scope.uiOption], function(i,v){
								result_html = result_html + '<li class="active-result" style="" data-id="' + v[scope.uiId] + '">' + v[scope.uiName] + '</li>';
							});
							$('.chosen-results', parent).html(result_html);

							// Update pagination
							var pagination = '';
							var init_limitstart = 0;
							var current_class = '';

							pagination = '<ul class="chosen-pagination">More: ';
							for(var i = 0; init_limitstart + PAGER_COUNT < data.totalresults; i++){
								init_limitstart = i * PAGER_COUNT;

								if(init_limitstart == limitstart){
									current_class = 'current';
								}
								else{
									current_class = '';
								}

								var pagination = pagination + '<a href="#" class="chosen-pagination-item ' + current_class + '" data-limitstart="' + init_limitstart + '">' + (i + 1) + '</a>';
							}

							pagination = pagination + '</ul>';

							if($('.chosen-drop-footer', parent).length == 0)
								$('.chosen-drop', parent).append('<div class="chosen-drop-footer"></div>');
							$('.chosen-drop-footer', parent).html(pagination);
					    }
					    else{
					    	swal({
					    		title: '',
					    		text: data.message,
					    		type: 'error',
					    		html: true
					    	});
					    }
					})
					.error(function(data, status, headers, config) {
			    		$state.go('404');	
			  		});
				}
			})

			// Close when click outside
			$('body').on('click', function (e) {
				var parent = $('#' + parent_id);

			    if (!parent.is(e.target) // if the target of the click isn't the container...
			        && parent.has(e.target).length === 0) // ... nor a descendant of the container
			    {
			         parent.removeClass('chosen-container-active').removeClass('chosen-with-drop');
			    }
			});

			// Reload when changing ngModel
			scope.$watch(function () {
				return scope.ngModel;
			}, function(newValue) {
				if(newValue != '' && newValue != undefined){
					$('.chosen-results', parent).html('');
					$('.chosen-drop-footer', parent).html('');
					$('.chosen-default span', container_div).text(scope.uiModellabel);
					$('.chosen-search input', parent).val('');
				}
				else{
					$('.chosen-results', parent).html('');
					$('.chosen-drop-footer', parent).html('');
					$('.chosen-default span', container_div).text(placeholder);			
					$('.chosen-search input', parent).val('');
				}
			});
		}
	}
});