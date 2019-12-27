function get_id_map_idx(list) {
    let id_map_idx = {};
    for (let i = 1, len = list.length; i < len; i++) {
        id_map_idx[list[i].node_id] = i;
    }
    return id_map_idx;
}

function process_pre(li) {

    function merge_by_type(i) {
        let tmp_map_type_to_id = {};
        for (let j = 0, pre_len = li[i].node_pre.length; j < pre_len; j++) {
            let tmp_id = name_map_id_prun[li[i].node_pre[j].pre];
            let tmp_type = li[i].node_pre[j].type;
            // console.log(tmp_type);
            if (tmp_map_type_to_id[tmp_type] == null) {
                tmp_map_type_to_id[tmp_type] = [tmp_id];
            } else {
                tmp_map_type_to_id[tmp_type].push(tmp_id);
            }
        }
        return {tmp_map_type_to_id};
    }

    function create_nodes_after_merge(i, tmp_map_type_to_id) {
        li[i].node_son = [];
        // console.log(tmp_map_type_to_id);
        for (key in tmp_map_type_to_id) {
            let new_son = [];
            let new_node_s_son = tmp_map_type_to_id[key];
            // console.log("sons",new_node_s_son);
            for (let tmp_son_id in new_node_s_son) {
                new_son.push({"node_id": new_node_s_son[tmp_son_id]});
            }
            //   FIXME：这个地方可能有bug,
            let new_node = {"node_name": '' + '', "node_type": 0, "node_son": new_son, "node_id": max_id};
            // console.log("as",new_son);
            li[i].node_son.push({"node_id": max_id});
            max_id += 1;
            li.push(new_node);
        }
    }

    console.log('赶紧来', li);
    let name_map_id_prun = {};
    for (let i = 1, len = li.length; i < len; i++) {
        name_map_id_prun[li[i].node_name] = li[i].node_id;
    }

    // 找到最大的ID
    let max_id = 0;
    for (let i = 1, len = li.length; i < len; i++) {
        if (li[i].node_id > max_id) {
            max_id = li[i].node_id;
        }
    }
    // console.log(max_id, 'max_id')
    max_id = max_id + 1;

    let former_len = li.length;
    // console.log(li,'now, test')
    for (let i = 0; i < former_len; i++) {
        // TODO: 给不同的节点不同的颜色，直接使用type作为关键词
        // FIXME：pre没有完成，检查一下
        if (li[i].node_pre != null && li[i].node_pre.length > 0) {
            // "node_pre": [{"main": "CS307", "pre": "CS201", "type": "1"},
            //     {"main": "CS307", "pre": "CS202","type": "1" },
            //     {"main": "CS307", "pre": "CS208", "type": "2"}]

            // "node_son": [{"node_id": 76, "node_name": "( \"HUM\", 4 )"}
            console.log('have pre');
            // 收集不同的 type的【】
            let {tmp_map_type_to_id} = merge_by_type(i);
            // 把这些【】 转换成node，再加入到原来的list中
            create_nodes_after_merge(i, tmp_map_type_to_id);
            //  删除掉这个 l[i].node_pre
            // li[i].node_pre = [];
        }
    }
    console.log('new li', li);
    return li;
}

function cut_redundant_link(l_) {
    let id_map_idx = get_id_map_idx(l_);
    for (let i = 1, len_i = l_.length; i < len_i; i++) {
        let father = l_[i];
        if (father.node_son != null) {
            let rem_candidate = [];
            for (let j = 0, len_j = father.node_son.length; j < len_j; j++) {
                let son_id = father.node_son[j].node_id;
                let son = l_[id_map_idx[son_id]];
                if (son != null && son.node_son != null) {
                    for (let k = 0; k < son.node_son.length; k++) {
                        // 测试是否在son_lst中
                        let test_gradson_id = son.node_son[k].node_id;
                        for (let p = 0; p < father.node_son.length; p++) {
                            if (father.node_son[p].node_id == test_gradson_id) {
                                rem_candidate.push(p);
                            }
                        }
                    }
                }
            }
            rem_candidate = [...new Set(rem_candidate)];
            // console.log("rem_", rem_candidate);
            rem_candidate.sort();
            console.log("i", i, rem_candidate);
            for (let x = rem_candidate.length - 1; x >= 0; x--) {
                l_[i].node_son.splice(rem_candidate[x], 1);
            }
        }
    }
    return l_;
}


function data_transform2(l3) {
    console.log('before', l3);
//    l3 = process_pre(l3);
//    console.log("process_pre ", l3, 'finished process_pre');

    l3 = cut_redundant_link(l3);
// console.log("cut_redundant_link");
    console.log('after cut', l3);

// '<nodes ID="8888" LABEL="Who am I?" COLORVALUE="green" COLORLABEL="unspecified" SIZEVALUE="2000" ' +
//     'INFOSTRING="This is a good question. Think about it." />'

    let type_to_importance_tran2 = {2: 5, 0: 4, 1: 3, 3: 2, 4: 1};
    let head = '<data>';
    let tail = '</data>';
    let nodes_str = '';
    let link_str = '';
    for (let i = 1, len = l3.length; i < len; i++) {
        let n = l3[i].node_name + ' ';
        let node_name = n.split(' ').join('');
        node_name = node_name.split('&&').join('and');
        node_name = node_name.split('||').join('or');
        node_name = node_name.split('"').join('');
        if (l3[i].node_name.length > 20) {
            node_name = '';
            console.log('为什么啊')
        }
        nodes_str += '<nodes ID="' + l3[i].node_id + '" LABEL="' + node_name +
            '" COLORVALUE="' + (type_to_importance_tran2[l3[i].node_type] * 4) + '" COLORLABEL="' + l3[i].node_type + '" SIZEVALUE="' + (1200 + type_to_importance_tran2[l3[i].node_type] * 100) + '" ';
        if (l3[i].information != null) {
            let info = l3[i].information; // 不用替换
            nodes_str += ' INFOSTRING="' + info + '" ';
        }
        nodes_str += ' /> ';
    }

// '<links FROMID="7839" TOID="7839" STYLE="dotted" COLOR="blue" INFOSTRING="This lue." />' +
//     '<links FROMID="7698" TOID="7839" STYLE="dashed" />' +

    for (let i = 1, len = l3.length; i < len; i++) {
        if (l3[i].node_son != null) {
            // console.log("gggg");
            // console.log(l[i].node_son);
            for (let j = 0, son_len = l3[i].node_son.length; j < son_len; j++) {
                let tmp = '<links FROMID="' + l3[i].node_id + '" TOID="' + l3[i].node_son[j].node_id + '" STYLE="solid" />';
                link_str += tmp;
                // console.log(tmp);
            }
        }
    }
    // let cnt = 0;
    // for(let i=0, len=l.length; i<len;i++){
    //     if(l[i].node_type==3)
    // }
    console.log('link', link_str);
    console.log('llllllll');
    let data2 = head + nodes_str + link_str;
    data2 += tail;
    return data2;
}

// let data2= data_transform2(l);