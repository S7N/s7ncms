	var mootabs = new Class({
 
		initialize: function(element, options) {
			this.options = Object.extend({
				width:				300,
				height:				200,
				changeTransition:	Fx.Transitions.bounceOut
			}, options || {});
 
 			if($(element)) {
				this.el = $(element);
				this.id = element;
				this.tabPanels = $$('#' + this.id + ' ul.mootabs_title');
				this.tabPanel = this.tabPanels[0];
	 
				this.panels = $$('#' + this.id + ' div.mootabs_panel');
	 
				this.panels.each(function(panel) {
					panel.setStyle('display', 'none');
				}.bind(this));
				
				this.panels[0].setStyle('display', 'block');
	 
				this.tabs = $$('#' + this.id + ' ul li a');		
	 
				this.tabs.each(function(tab) {
	 
					var linkName = tab.getProperty('href').split('#')[1];
					tab.setProperty('rel', linkName );
					tab.href = 'javascript:void(0);';
	 
					tab.addEvent('click', function() {
						this.activate(tab);
					}.bind(this));
				}.bind(this));
			}
		},
 
		activate: function(tab) {
 
			var linkName = tab.getProperty('rel');
			this.tabs.each(function(tab) {
				tab.removeClass('active');
			});
 
			tab.addClass('active');		
 
			$$('#' + this.id + ' div.mootabs_panel').each(function(panel) {
				panel.removeClass('active');
				panel.setStyle('display', 'none');
			});		
 
			$(linkName).addClass('active');
			$(linkName).setStyle('display', 'block');
		}		
	});
 	
 	window.addEvent('domready', function() {
		var myTabs = new mootabs('myTabs');
	});