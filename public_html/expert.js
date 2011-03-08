$(function() {
	
	var Availability = Backbone.Model.extend({
		defaults: {
			day: null,
			from: '09:00:00',
			through: '17:00:00',
			allday: false,
			checked: false
		}
	});
	var Specialty = Backbone.Model.extend({});
	var Expert = Backbone.Model.extend({
		idAttribute: 'phone_number',
		url: function() {
			return 'experts?' + $.param({id: this.get('phone_number')});
		},
		fetch: function() {
			return this.set({
				id: 1,
				phone_number: '12125551212',
				first_name: 'Amit',
				last_name: 'Snyderman',
				availability: new AvailabilityList([{
					day: 0,
					from: null,
					through: null,
					allday: true,
					checked: true
				}, {
					day: 3,
					from: '09:00:00',
					through: '17:00:00',
					checked: true
				}, {
					day: 5,
					from: '09:00:00',
					through: '17:00:00',
					checked: true
				}]),
				specialties: new SpecialtyList([{
					id: 1,
					name: 'Python',
					topic: 'Code',
					checked: true
				}])
			});
		}
	});
	
	var AvailabilityList = Backbone.Collection.extend({
		model: Availability,
		url: 'availability',
		
		initialize: function() {
	      _.bindAll(this, 'getByDay');
	    },
		
		getByDay: function() {
			var by_day = [];
			this.forEach(function(item) {
				by_day.push(item.get('day'), item);
			});
			
			return _.range(1, 7, 1).map(function(item) {
				if (by_day[item] != null && !_.isNumber(by_day[item]))
					return by_day[item];
				return new Availability({day: item});
			});
		}
	});
	
	var SpecialtyList = Backbone.Collection.extend({
		model: Specialty,
		url: 'specialties',
		fetch: function() {
			return this.add([{
				id: 1,
				name: 'Python',
				topic: 'Code',
				checked: false
			}, {
				id: 2,
				name: 'HTML/CSS',
				topic: 'Code',
				checked: false
			}]);
		}
	});
	
	
	var expert = new Expert();
	var specialties = new SpecialtyList();
	
	var ExpertView = Backbone.View.extend({
		template: _.template($('#info-template').html()),
	
		events: {},
		
		render: function() {
			$(this.el).html(this.template(this.model.toJSON()));
		}
	});
	
	var AvailabilityView = Backbone.View.extend({
		template: _.template($('#availability-template').html()),
		
		events: {},
		
		render: function() {
			var self = this;
			var rows = this.model.get('availability').getByDay().map(function(item) {
				return self.template(item.toJSON());
			});
				
			$(this.el).html(rows.join('\n'));
		}
	});
	
	var SpecialtiesView = Backbone.View.extend({
		template: _.template($('#specialty-template').html()),
		
		events: {},
		
		render: function() {
			var self = this;
			var user_specialties = this.model.get('specialties');
			var rows = specialties.fetch().map(function(item) {
				if (user_specialties.get(item.get('id')))
					return self.template(user_specialties.get(item.get('id')).toJSON());
				return self.template(item.toJSON());
			});
				
			$(this.el).html(rows.join('\n'));
		}
	});

	// The Application
	// ---------------

	var AppView = Backbone.View.extend({

		el: $("#expert"),
		
		initialize: function() {
			this.el.find('section.login').siblings().hide();
		},

		events: {
			'click #login': 'login',
			'click #save': 'save'
		},

		login: function() {
			expert = new Expert({'phone_number': $('#phone_number').val()});
			expert.fetch();
			
			this.el.addClass('logged_in');
			this.el.find('section.login').siblings().show();
			
			new ExpertView({model: expert, el: '#info'}).render();
			new AvailabilityView({model: expert, el: '#availability'}).render();
			new SpecialtiesView({model: expert, el: '#specialties'}).render();
		},
		
		save: function() {
			alert('saving!');
		}
	});

	window.app = new AppView;
});