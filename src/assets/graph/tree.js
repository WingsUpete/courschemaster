// tree.js
// TODO:目前点击文字一下文字会bold，但是再点击不能恢复
// TODO：把文字的位置上移，移到球上面，不然会被线穿过，很难看

let type_to_importance_tree = {2:4, 0:3, 1:2, 3:1};

var margin = {top: 20, right: 120, bottom: 20, left:100},
    width = 1950 - margin.right - margin.left,  // width 改成了 1950，然后深度就突破了4层
    // height也从800 改成了1200，这样的话如果分支很多，页面也不会显得很拥挤
    // 缺点是这样一开始没有很多分支时显得很空旷，很丑
    // 所以这个要平衡
    // 最好的办法当然是动态设置，可是不知道难不难、难不难、花不花时间
    height = 2400 - margin.top - margin.bottom;

// 如果属性是 _children，则一旦点击就会伸出所有的子节点的子节点的……直到遇到子节点的属性名字叫children而非__children

// 由于目前的link是由source和target共同构成的，而且二者间没有直接联系，所以要么直接在tree_data中写明y值，要么写明父节点是什么
//或者从d.y的算法上下手

var i = 0,
    duration = 750,
    root;

var tree = d3.layout.tree()
    .size([height, width]);

var diagonal = d3.svg.diagonal()
    .projection(function(d) { return [d.y, d.x]; });

var svg = d3.select("#tree").append("svg")
    .attr("width", width + margin.right + margin.left)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

// root = treeData[0];
root.x0 = height / 2;
root.y0 = 0;

update(root);

d3.select(self.frameElement).style("height", "100px");   // 从800px改成1600px，没有任何作用，哪怕注释掉也不影响

function update(source) {

    // Compute the new tree layout.
    var nodes = tree.nodes(root).reverse(),
        links = tree.links(nodes);   //link应该是表示edge

    // Normalize for fixed-depth.
    nodes.forEach(function(d) {
        d.y = d.depth * 150;

        // if(d.short !=null){
        //     d.y = d.depth * 30;
        // }
    });   // 从180 改成 360，改的是所有的link的长度

    // Update the nodes鈥�
    var node = svg.selectAll("g.node")
        .data(nodes, function(d) { return d.id || (d.id = ++i); });

    // Enter any new nodes at the parent's previous position.
    var nodeEnter = node.enter().append("g")
        .attr("class", "node")
        .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
        .on("click", click);

    nodeEnter.append("circle")   // circle应该是表示节点的圆圈
        .attr("r", 1e-6)
        .style("fill", function(d) { });

    nodeEnter.append("text")
        .attr("x", function(d) { return d.children || d._children ? -13 : 13; })
        .attr("dy", ".1045em")   // 把这个从.35em 变成.55em，调整的只是文字相当于节点的高度
        .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
        .text(function(d) { return d.name; })
        .style("fill-opacity", 1e-6)  // 从1e-6改成 1e-5会如何呢？会缩放页面，10的就比5的大得多
        .attr("class", function(d) {
            if (d.url != null) { return 'hyper'; }
        })
        .on("click", function (d) {
            $('.hyper').attr('style', 'font-weight:normal');
            d3.select(this).attr('style', 'font-weight:bold');
            if (d.url != null) {
                //  window.location=d.url;
                $('#vid').remove();

                $('#vid-container').append( $('<embed>')
                    .attr('id', 'vid')
                    .attr('src', d.url + "?version=3&amp;hl=en_US&amp;rel=0&amp;autohide=1&amp;autoplay=1")
                    .attr('wmode',"transparent")
                    .attr('type',"application/x-shockwave-flash")
                    .attr('width',"100%")
                    .attr('height',"100%")
                    .attr('allowfullscreen',"true")
                    .attr('title',d.name)
                )
            }
        })
    ;

    // Transition nodes to their new position.
    var nodeUpdate = node.transition()
        .duration(duration)
        .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

    nodeUpdate.select("circle")
        .attr("r", 10)
        // .attr("r", 4+type_to_importance_tree[ d.node_type])      //  从10 改成5球变小了，改的是radius，即半径
        .style("fill", function(d) {
            if (d._children) return "#ccff99";
            if (d.node_type ==2) {
                return "#147ffa";}
            if (d.node_type ==0) return "#23baf0";
            if (d.node_type ==1) return "rgba(46,231,255,0.88)";
            if (d.node_type ==3) return "rgba(72,186,223,0.8)";
            // if (d.node_type ==4) return "#dad7f0";
            return "#fff";
        });  // 这个是原来设置节点颜色的

    nodeUpdate.select("text")
        .style("fill-opacity", 1);

    // Transition exiting nodes to the parent's new position.
    var nodeExit = node.exit().transition()
        .duration(duration)
        .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
        .remove();

    nodeExit.select("circle")
        .attr("r", 1e-6);

    nodeExit.select("text")
        .style("fill-opacity", 1e-6);

    // Update the links鈥�
    var link = svg.selectAll("path.link")
        .data(links, function(d) { return d.target.id; });

    // Enter any new links at the parent's previous position.
    link.enter().insert("path", "g")
        .attr("class", "link")
        .attr("d", function(d) {
            var o = {x: source.x0, y: source.y0};
            return diagonal({source: o, target: o});
        });

    // Transition links to their new position.
    link.transition()
        .duration(duration)
        .attr("d", diagonal);

    // Transition exiting nodes to the parent's new position.
    link.exit().transition()
        .duration(duration)
        .attr("d", function(d) {
            var o = {x: source.x, y: source.y};
            return diagonal({source: o, target: o});
        })
        .remove();

    // Stash the old positions for transition.
    nodes.forEach(function(d) {
        d.x0 = d.x;
        d.y0 = d.y;
    });
}

// Toggle children on click.
function click(d) {
    if (d.children) {
        d._children = d.children;
        d.children = null;
    } else {
        d.children = d._children;
        d._children = null;
    }
    update(d);
}



