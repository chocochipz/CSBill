// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());


// place any jQuery/helper plugins in here, instead of separate, slower script files.

/*
 * Form Collection
 */
(function($, Backbone, _){
	
	var FormCollectionModel = Backbone.Model.extend({
		"label" : ExposeTranslation.get('add_new'),
		"initialize": function() {
			
			if (!this.get("label"))
			{
				this.set({"label": this.label});
			}
		}
	});

	var FormCollectionView = Backbone.View.extend({
		
		"id" : (Math.random() * (10 * 100)),
		"icon" : function () {
			return $('<i />').addClass('icon-plus-sign');
		},
		"addlink" : function(){
			return $('<a />').attr('href', '#').attr('id', this.id).addClass("add_form_collection_link").html(this.icon()).append(' ' + this.model.get("label"));
		},
		"initialize" : function(){
			this.model.set({'label' : this.options.label});
			
			var el = this.el;
			var l = this.addlink().on('click', function(e){
				e.preventDefault();
				
				var add = new AddView({"el" : el})
			});
			
			$(this.el).append(l);
		}
	});
	
	var AddView = Backbone.View.extend({
		"initialize" : function(){
			
			var el = $(this.el);

			var prototype = el.attr('data-prototype');

		    var form = $(prototype.replace(/__name__/g, el.children('.content').length));
		    
		    $form = $('<div />').addClass('content');
		    
		    for(var i = 0; i < form.length; i ++)
		    {
		    	$form.append(form[i]);
		    }

		    $(this.el).find('.add_form_collection_link').before($form);
		    
		    Loader.call();
			
			var del = new DeleteView({"el" : $form});
			
			return del;
		}
	});
	
	var DeleteView = Backbone.View.extend({
		"template" : '<a class="pull-right" href="#"> <%=label%></a>',
		"icon" : '<i class="icon-remove"></i> ',
		"initialize" : function(){
			
			var template = $(_.template(this.template, {"label" : this.icon + ExposeTranslation.get('delete')})).on('click', this.destroy);
			
			$(this.el).prepend(template);
		},
		"destroy" : function(){
			$(this.el).remove();
		}
	});

	$.fn.formCollection = function(options) {

		var view = new FormCollectionView($.extend({"model": new FormCollectionModel, "el" : this}, options));
	
		return view;
	};

})(window.jQuery, Backbone, _);