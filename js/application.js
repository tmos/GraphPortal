/** Initialisation and configuration */
App = Ember.Application.create({
    LOG_TRANSITIONS: true
});
App.ApplicationStore = DS.Store.extend();
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
			var store = this.store;
			data = {
				numberOfNodes: $('#numberOfNodes').value,
				complexity: $('#complexity').value
			};

			$.ajax({
				type: "POST",
				url: url,
				data: data,
				success: function(data){
					var result = $.parseJSON(data);
					
					// Create the graph
					var currentGraph = store.createRecord('graph', {
						id:1
					});
					
					// Create the nodes
					for (var i = 1; i <= result.nodes.length; i++) {
						var newNode = store.createRecord('node',{
							id:i,
							graph:currentGraph
						});
						// Push the node in the graph's list
						currentGraph.get('nodes').then(function(nodes){
							nodes.pushObject(newNode);
						});

					};
					
					// Create the links
					for (var i = 0; i < result.edges.length; i++) {
						var edge = result.edges[i];
						var newLink = store.createRecord('link', {
							id:i+1,
							weight: edge.weight,
							graph:currentGraph
						});
						// Push the nodes in the link's list
						for (var j = 0; j < 2; j++) {
							
							var theNode = store.find('node', edge.nodes[j]);
							
							newLink.get('nodes').then(function(nodeList){
								nodeList.addObject(theNode);
							});
							
						};
						// Push the link in the graph's list
						currentGraph.get('links').then(function(links){
							links.addObject(newLink);
						});
					};
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
	nodes: DS.hasMany('node', {async:true, inverse:'graph'}),
	links: DS.hasMany('link', {async:true, inverse:'graph'})
});

App.Node = DS.Model.extend({
	graph: DS.belongsTo('graph', {async:true, inverse:'nodes'})
});

App.Link = DS.Model.extend({
	weight: DS.attr('number'),
	nodes: DS.hasMany('node', {async:true, inverse:null}),
	graph: DS.belongsTo('graph', {async:true, inverse:'links'})
});

App.Graph.FIXTURES = [
	// {
	// 	id: 1,
	// 	nodes: [1,2,3,4],
	// 	links: [1,2,3,4]
	// }
];

App.Node.FIXTURES = [
	// { id: 1, graph: 1 },
	// { id: 2, graph: 1 },
	// { id: 3, graph: 1 },
	// { id: 4, graph: 1 }
];

App.Link.FIXTURES = [
	// { id: 1, nodes: [1,3], weight: 1, graph: 1 },
	// { id: 2, nodes: [1,2], weight: 2, graph: 1 },
	// { id: 3, nodes: [2,3], weight: 7, graph: 1 },
	// { id: 4, nodes: [4,3], weight: 3, graph: 1 }
];