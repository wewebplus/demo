jQuery(document).ready(function() {
  var FullPath = $('#ajaxFrm input[name=PathURL]').val();
  var thisdata = 0;
  $("#treegrid").fancytree({
    extensions: ["table","dnd", "edit"],
    table: {
      indentation: 20,      // indent 20px per node level
      nodeColumnIdx: 1,     // render the node title into the 2nd column
      checkboxColumnIdx: 0  // render the checkboxes into the 1st column
    },
    source: {
      // url: "http://localhost/disaster2021/upload/fronthomecontent/resultsmenu-backend.json"
      url: FullPath+'fronthomecontent/group-ajax-loadtree-json.php'
    },
    dnd: {
      autoExpandMS: 400,
      focusOnClick: true,
      preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
      preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
      dragStart: function(node, data) {
        /** This function MUST be defined to enable dragging for the tree.
         *  Return false to cancel dragging of node.
         */
        //  console.log(node.data.ID);
         thisdata = node.data.ID;
        return true;
      },
      dragEnter: function(node, data) {
        /** data.otherNode may be null for non-fancytree droppables.
         *  Return false to disallow dropping on node. In this case
         *  dragOver and dragLeave are not called.
         *  Return 'over', 'before, or 'after' to force a hitMode.
         *  Return ['before', 'after'] to restrict available hitModes.
         *  Any other return value will calc the hitMode from the cursor position.
         */
        // Prevent dropping a parent below another parent (only sort
        // nodes under the same parent)
        /*           if(node.parent !== data.otherNode.parent){
              return false;
            }
            // Don't allow dropping *over* a node (would create a child)
            return ["before", "after"];
  */
        return true;
      },
      dragDrop: function(node, data) {
        /** This function MUST be defined to enable dropping of items on
         *  the tree.
         */
        // console.log("save To...", node.data.ID);
        // console.log("save...", data.hitMode);
        data.otherNode.moveTo(node, data.hitMode);
        UpdatePositionParent(thisdata,data);
      },
      dragStop: function(node, data) {
        var neworder=new Array();
        var i=0;
        var all_drop_data = node.getParent();
        all_drop_data.visit(function(all_drop_data){
          neworder[i]=all_drop_data.key;
          i++;
        });
        // console.log(neworder);
        UpdateOrder(neworder);
      }
    },
    renderColumns: function(event, data) {
      var node = data.node,$tdList = $(node.tr).find(">td");
      // if(node.children){
      //   console.log(node.children);
      // }else{
      //   console.log("xxx");
      // }
      var htmlaction = '';
      htmlaction += '<div class="divaction">';
        htmlaction += '<a href="javascript:void(0)" rev="" rel="'+node.key+'" class="relateicon" onclick="EditTreeMenu(this)"><i class="fas fa-pen-square"></i></a>'
        htmlaction += '<a href="javascript:void(0)" rev="" rel="'+node.key+'" class="relateicon" onclick="DeleteTreeMenu(this)"><i class="fas fa-trash-alt"></i></a>';
      htmlaction += '</div>';
      // (index #0 is rendered by fancytree by adding the checkbox)
      $tdList.eq(0).text(node.getIndexHier());
      // (index #2 is rendered by fancytree)
      $tdList.eq(2).html(htmlaction);
    }
  });
});
function submitFrmSearch(t){
  loadpageajax(1);
  return false;
}
