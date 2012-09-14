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
		
	var MasterView = Backbone.View.extend({
		"tagName"	: "div",
		"className"	: "content",
		"icon" : '<i class="icon-plus-sign" />',
		"addlink" : '<a href="#" class="add_form_collection_link"><%= icon %> <%= label %></a>',

		"initialize": function () {
			
			var $this = this;
			
			var add_link = $(this.createAddLink()).on("click", function() { $this.addForm($this) });
			this.$el.append(add_link);
        },
        "createAddLink" : function(){
        	return _.template(this.addlink, {"icon" : this.icon, "label" : this.options.label});
        },
        "addForm" : function($this) {
        	
        	var prototype  = $this.$el.attr('data-prototype');

		    var form = $(prototype.replace(/__name__/g, $this.$el.children('.content').length));
		    
		    
		    if(typeof form[1] !== undefined)
		   	{
		    	var script = $(form[1]);
		    	
		    	$.globalEval(script.html());
		   	}
		    
		    var view = new FormCollectionView({"el" : form});
		    
		    $this.$el.prepend(view.render().el);
		    
		    Loader.call();
		    
		    return view;
        }
	});
	

	var FormCollectionView = Backbone.View.extend({
		
		"template" : '<a class="pull-right remove-form" href="#"><%= icon %> <%=label%></a>',
		
		"icon" : '<i class="icon-remove"></i> ',
		
		"events" : {
			"click a.remove-form" : "destroy"
		},
		"render" : function(){
			
			var $this = this;
			
			var template = _.template(this.template, {"icon" : this.icon, "label" : ExposeTranslation.get('delete')});
			
			var tmpl = $(template).on("click", function(){
				$this.destroy($this);
			});
			
			this.$el.prepend(tmpl);
				
			return this;
		},
		"destroy" : function($this) {

			$this.$el.remove();
			
			return this;
		}
	});
	
	$.fn.formCollection = function(options) {
		
		var view = new MasterView($.extend({"el" : this}, options));
	
		return view;
	};

})(window.jQuery, Backbone, _);