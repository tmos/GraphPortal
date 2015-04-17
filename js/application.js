/** Initialisation and configuration */
var App = Ember.Application.create({
    LOG_TRANSITIONS: true
});

App.ApplicationAdapter = DS.FixtureAdapter.extend();

/** Routers */
App.Router.map(function() {
    this.route('accueil');
    this.route('generation');
    this.route('sssp');
    this.route('spaningtree');
});

/** Controllers */
App.GenerationController = Ember.Controller.extend({
	actions: {
		generation: function(){
			var url = "php/graphCreation.php";

			data = {
				numberOfNodes: $('#numberOfNodes').value,
				complexity: $('#complexity').value
			};

			$.ajax({
				type: "POST",
				url: url,
				data: data,
				success: function(){
					alert("ok");
				},
				error: function(){
					alert("ko");
				}
			});
		}
	}
});
App.SsspController = Ember.Controller.extend({
	actions: {
		sssp: function(){
			var url = "php/sssp.php";
		}
	}
});
App.SpaningtreeController = Ember.Controller.extend({
	actions: {
		spaningtree: function(){
			var url = "php/spaningTree.php";
			
		}
	}
});

/** Routes */
App.IndexRoute = Ember.Route.extend({
	model: function() {
		return this.store.findAll('graph');
	}
});

/** Models */
App.Graph = DS.Model.extend({
	nodes: DS.hasMany('node', {async:true}),
	links: DS.hasMany('link', {async:true})
});

App.Link = DS.Model.extend({
	nodes: DS.hasMany('node', {async:true}),
	weight: DS.attr('number'),
	graph: DS.belongsTo('graph')
});
	
App.Node = DS.Model.extend({
	links: DS.hasMany('link'),
	graph: DS.belongsTo('graph')
});


App.Graph.FIXTURES = [
	{
		id: 1,
		nodes: [1,2,3,4],
		links: [1,2,3,4]
	}
];

App.Node.FIXTURES = [
	{ id: 1, links: [1,2], graph: 1 },
	{ id: 2, links: [3,2], graph: 1 },
	{ id: 3, links: [4,3,1], graph: 1 },
	{ id: 4, links: [4], graph: 1 }
];

App.Link.FIXTURES = [
	{ id: 1, nodes: [1,3], weight: 1, graph: 1 },
	{ id: 2, nodes: [1,2], weight: 2, graph: 1 },
	{ id: 3, nodes: [2,3], weight: 7, graph: 1 },
	{ id: 4, nodes: [4,3], weight: 3, graph: 1 }
];