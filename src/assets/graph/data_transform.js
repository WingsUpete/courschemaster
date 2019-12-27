// l = MatryonaTranslateClass.Matryona_to_Graph();
//
// console.log(l.length);

// 这个要放在最前面，给后面处理 pre 时使用
function data_transform(l_4) {
    let type_to_importance = {2: 4, 0: 3, 1: 2, 3: 1};

    let name_map_id = {};
    for (let i = 1, len = l_4.length; i < len; i++) {
        name_map_id[l_4[i].node_name] = l_4[i].node_id;
    }


    let max_id = 0;
    for (let i = 0, len = l_4.length; i < len; i++) {
        if (l_4[i].node_id > max_id) {
            max_id = l_4[i].node_id;
        }
    }
    max_id = max_id + 1;

    let former_len = l_4.length;

    // function merge_by_type(i) {
    //     let tmp_map_type_to_id = {};
    //     for (let j = 0, pre_len = l_4[i].node_pre.length; j < pre_len; j++) {
    //         let tmp_id = name_map_id[l_4[i].node_pre[j].pre];
    //         let tmp_type = l_4[i].node_pre[j].type;
    //         // console.log(tmp_type);
    //         if (tmp_map_type_to_id[tmp_type] == null) {
    //             tmp_map_type_to_id[tmp_type] = [tmp_id];
    //         } else {
    //             tmp_map_type_to_id[tmp_type].push(tmp_id);
    //         }
    //     }
    //     return {tmp_map_type_to_id};
    // }

    function create_nodes_after_merge(i, tmp_map_type_to_id) {
        l_4[i].node_son = [];
        // console.log(tmp_map_type_to_id);
        for (key in tmp_map_type_to_id) {
            let new_son = [];
            let new_node_s_son = tmp_map_type_to_id[key];
            // console.log("sons",new_node_s_son);
            for (let tmp_son_id in new_node_s_son) {
                new_son.push({"node_id": new_node_s_son[tmp_son_id]});
            }
            let new_node = {"node_name": ''+max_id, "node_type": 0, "node_son": new_son, "node_id": max_id};
            // console.log("as",new_son);
            l_4[i].node_son.push({"node_id": max_id});
            max_id += 1;
            l_4.push(new_node);
        }
    }

    // for (let i = 0; i < former_len; i++) {
    //     // TODO: 给不同的节点不同的颜色，直接使用type作为关键词
    //     // FIXME：pre没有完成，检查一下
    //     // console.log(l[i]);
    //     if (l_4[i].node_pre != null && l_4[i].node_pre.length > 0) {
    //         // "node_pre": [{"main": "CS307", "pre": "CS201", "type": "1"},
    //         //     {"main": "CS307", "pre": "CS202","type": "1" },
    //         //     {"main": "CS307", "pre": "CS208", "type": "2"}]
    //
    //         // "node_son": [{"node_id": 76, "node_name": "( \"HUM\", 4 )"}]
    //
    //         // 收集不同的 type的【】
    //         let {tmp_map_type_to_id} = merge_by_type(i);
    //         // 把这些【】 转换成node，再加入到原来的list中
    //         create_nodes_after_merge(i, tmp_map_type_to_id);
    //         //  删除掉这个 l[i].node_pre
    //         l_4[i].node_pre = [];
    //     }
    // }

//    console.log("new list")
//    console.log(l_4)
    let id_map_idx = {};
    for (let i = 1, len = l_4.length; i < len; i++) {
        id_map_idx[l_4[i].node_id] = i;
    }

    let root_id = 0;
    for (let i = 1, len = l_4.length; i < len; i++) {
        if (l_4[i].node_type == 2) {
            root_id = l_4[i].node_id;
            break;
        }
    }
    for (let i = 1, len = l_4.length; i < len; i++) {
        name_map_id[l_4[i].node_name] = l_4[i].node_id;
    }
    function dfs(id) {
        // console.log("hhhh");
        // console.log(id);
        // debugger;
        // console.log(id_map_idx[id]);
        let node = l_4[id_map_idx[id]];
        let tmp_map = {};
        if(node==null){
            return null;
        }
        // if(node.node_son==null || node.node_son.length==0){
        //     return node;
        // }
        tmp_map.name = node.node_name;
        tmp_map.node_type = node.node_type;
        tmp_map.children = [];
        if (node.node_son != null &&  node.node_son.length>0) {
            for (let i = 0, len = node.node_son.length; i < len; i++) {
                tmp_map.children.push(dfs(node.node_son[i].node_id));
                // console.log(node.node_son[i].node_id);
            }
        }
//        console.log('tmp',map);
        return tmp_map;
    }

    let treeData = [];
//	console.log(l_4);
//    console.log(root_id,'root_id');
    treeData.push(dfs(root_id));
//    console.log(l_4[id_map_idx[root_id]]);
//    console.log('treeData',treeData);
    return treeData;
}

//console.log('data',l);
//let treeData = data_transform(l);