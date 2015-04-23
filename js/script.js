$(document).ready(function(){
    $('.parallax').parallax();
});

/** Important variables */
    var graph = {
        size:undefined,
        nodes:[],
        edges:[]
    };

    var pageVisu = $('#visualisation');
    var pageSssp = $('#sssp');
    var pageSpaningTree = $('#spaningTree');

/** Utility */
    function contains(array, id) {
        for(var i=0;i<array.length;i++) {
            return (array[i][0].id === id)
        }
        return false;
    }
    function newGraph(){
        graph = {
            nodes:[],
            edges:[]
        };
    }

/** Listeners */
    $("#btnGeneration").click(function(){
        generation();
    });
    $("#btnSssp").click(function(){
        sssp();
    });
    $("#btnSpaningTree").click(function(){
        spaningTree();
    });

/** Features */
    function generation(){
        // Clean out the old graph
        newGraph();
        var data = {
            numberOfNodes: $('#numberOfNodes').val(),
            complexity: $('#complexity').val()
        };

        $.ajax({
            type: "POST",
            url: "php/graphCreation.php",
            data: data,
            success: function(data){
                var result = $.parseJSON(data);

                graph.size = result.size;

                // Import the nodes
                for(i=0; i < result.nodes.length; i++) {
                    var newNode = result.nodes[i];
                    graph.nodes.push({
                        id: newNode.id
                    });
                }

                // Import de edges
                for(i=0; i < result.edges.length; i++) {
                    var newEdge = result.edges[i];
                    graph.edges.push({
                        value: newEdge.weight,
                        from: newEdge.nodes[0],
                        to: newEdge.nodes[1]
                    });
                }
                if (!pageVisu.is(":visible")) {
                    pageVisu.toggle();
                }
                $(document.body).animate({
                    'scrollTop':   $('#visualisation').offset().top
                }, 1000);
                visuGraph();
            },
            error: function(){
                alert("ko");
            }
        });
    };

    function sssp(){
        $.ajax({
            type: "POST",
            url: "php/sssp.php",
            data: {graph:JSON.stringify(graph)},
            success: function(data){
                var result = $.parseJSON(data);

                console.log(data);

                if (!pageSssp.is(":visible")) {
                    pageSssp.toggle();
                }
                $(document.body).animate({
                    'scrollTop':   $('#sssp').offset().top
                }, 1000);
            },
            error: function(){
                alert("ko");
            }
        });
    };

    function spaningTree(){
        $.ajax({
            type: "POST",
            url: "php/spaningTree.php",
            data: JSON.stringify(graph),
            success: function(data){
                var result = $.parseJSON(data);

                if (!pageSpaningTree.is(":visible")) {
                    pageSpaningTree.toggle();
                }
                $(document.body).animate({
                    'scrollTop':   $('#spaningTree').offset().top
                }, 1000);

            },
            error: function(){
                alert("ko");
            }
        });
    };

    function visuGraph() {
        var data = graph;
        var container = document.getElementById("graph");
        var options = {
            width: '900px',
            height: '500px',
            tooltip: {
                delay: 300,
                fontColor: "black",
                fontSize: 14, // px
                fontFace: "verdana",
                color: {
                    border: "#666",
                    background: "#FFFFC6"
                }
            }
            //,dataManipulation: {
            //    enabled: true,
            //    initiallyVisible: false
            //}
        };

        var graphe = new vis.Network(container, data, options);
    }