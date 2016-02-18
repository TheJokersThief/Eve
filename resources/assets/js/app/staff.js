/*
		This is the JavaScript for the Staff page.
		It relies on Knockout.js which is imported on that page.
		So please, please, if you'd like to change this
		make sure I'm tagged in that commit.

		- @colm2
 */


$(document).ready(function(){
	if($('.staff-home-page').length){
		function TicketViewModel() {
			var self = this;

			self.tickets = ko.observableArray([]);

			self.markPrinted = function() {
				$.getJSON("staff/markPrinted/ " + this.id, function(data){
					if(data.success){
						Materialize.toast("Marked ticket as printed!", 1000);
					}else{
						Materialize.toast("Unknown error.", 1000);
					}
				});

				self.tickets.remove(this);
			};

			self.update = function(){
				$.getJSON("staff/toPrint", function(data){
					console.log(data);
					self.tickets(data);
				});
			};

			self.print = function(){
				var win = window.open("/staff/nameTag/" + this.id, '_blank');
				win.focus();
			};

			self.update();
		}
		
		ko.applyBindings(new TicketViewModel());
	}
});



