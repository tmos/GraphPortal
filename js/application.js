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
					
					// Create the edges
					for (var i = 1; i <= result.edges.length; i++) {
						console.log("new edge");
						// The json edge
						var edge = result.edges[i-1];

						// The new edge record
						var newEdge = store.createRecord('edge', {
							id:i,
							weight: edge.weight,
							graph:currentGraph
						});

						// Push the nodes in the edge's list
						for (var j = 0; j < 2; j++) {
							// Create the nodes of the edge
							var idCurrentEdge = edge.nodes[j];
							var currentNode;
							if (store.hasRecordForId('node', idCurrentEdge)) {
								// If the node as already been created
								currentNode = store.getById('node', idCurrentEdge);
							} else {
								// If the node doesn't exists yet
								currentNode = store.createRecord('node',{
									id: idCurrentEdge,
									graph: currentGraph
								});
							}

							// Push the node in the edge's list
							newEdge.get('nodes').addObject(currentNode);

							// Push the node in the graph's list
							currentGraph.get('nodes').then(function(graphNodeList){
								graphNodeList.addObject(currentNode);
							});
						};

						// Push the edge in the graph's list
						currentGraph.get('edges').then(function(graphEdgeList){
							graphEdgeList.addObject(newEdge);
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
	edges: DS.hasMany('edge', {async:true, inverse:'graph'})
});

App.Node = DS.Model.extend({
	graph: DS.belongsTo('graph', {async:true, inverse:'nodes'})
});

App.Edge = DS.Model.extend({
	weight: DS.attr('number'),
	nodes: DS.hasMany('node', {async:true, inverse:null}),
	graph: DS.belongsTo('graph', {async:true, inverse:'edges'})
});

App.Graph.FIXTURES = [
	// {
	// 	id: 1,
	// 	nodes: [1,2,3,4],
	// 	edges: [1,2,3,4]
	// }
];

App.Node.FIXTURES = [
	// { id: 1, graph: 1 },
	// { id: 2, graph: 1 },
	// { id: 3, graph: 1 },
	// { id: 4, graph: 1 }
];

App.Edge.FIXTURES = [
	// { id: 1, nodes: [1,3], weight: 1, graph: 1 },
	// { id: 2, nodes: [1,2], weight: 2, graph: 1 },
	// { id: 3, nodes: [2,3], weight: 7, graph: 1 },
	// { id: 4, nodes: [4,3], weight: 3, graph: 1 }
];