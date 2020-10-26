(function($) {
	form_data = [];
    $.fn.orgChart = function(options) {
        var opts = $.extend({}, $.fn.orgChart.defaults, options);
        return new OrgChart($(this), opts);        
    }

    $.fn.orgChart.defaults = {
        data: [{id:1, name:'My Organization', parent: 0,set_id:0}],
        showControls: false,
        allowEdit: false,
        onAddNode: null,
        onDeleteNode: null,
        onClickNode: null,
        newNodeText: 'Add Child'
    };

    function OrgChart($container, opts){
		var my_arr =  [];
		data = opts.data;
        nodes = {};
        var rootNodes = [];
        this.opts = opts;
        this.$container = $container;
        var self = this;

        this.draw = function(){
			//console.log('draw');
            $container.empty().append(rootNodes[0].render(opts));
            $container.find('.node').click(function(){
                if(self.opts.onClickNode !== null){
                    self.opts.onClickNode(nodes[$(this).attr('node-id')]);
                }
            });

            if(opts.allowEdit){
                $container.find('.node h2').click(function(e){
                    var thisId = $(this).parent().attr('node-id');
                    self.startEdit(thisId);
                    e.stopPropagation();
                });
            }

            // add "add button" listener
            $container.find('.org-add-button').click(function(e){
               var this_set_id = $(this).attr('data_set_id');
                var thisId = $(this).parent().attr('node-id');
               /* if(this_set_id){
                    $(".sidebar").append('<input type="text" class="form-control sidebar_txt">');
                }*/
                if(self.opts.onAddNode !== null){
                    self.opts.onAddNode(nodes[thisId]);
                }
                else{
                    
                    self.newNode(thisId);
                }
              
				$('.org-chart-sec').mCustomScrollbar("update");				
				e.stopPropagation();
            });

            $container.find('.org-del-button').click(function(e){			 
                var thisId = $(this).parent().attr('node-id');
                var this_set_id = $(this).attr('data_set_id');
                var del_set_data_count = 0;
                var check_is_parent =0;
                var del_data;
                var user_data = '';
				$('.org-chart-sec').mCustomScrollbar("update");
            if(typeof used_nodes != "undefined" && used_nodes.length !=0){    
                used_nodes.forEach(function(item, i) {
                    if(item == thisId){
                        user_data = 1;                        
                    }
                });
            }    
                    $(".node").each(function(){
                        if($(this).attr('data-parent')== thisId){
                            
                            check_is_parent = 1;
                            return false;
                        }else{
                            
                        }

                        if($(this).attr('data_set_id')== this_set_id){
                        del_set_data_count++;
                        } 
                    });
                  if(user_data ==1){
                     //alert("This node data already used in Employee table");
					  $('#delete-node2').modal('show');
                  }  
                 if(del_set_data_count == 1 && check_is_parent==0  && user_data ==0){
                   
                    if(!$( "input[name="+this_set_id+"]").hasClass("root_node"))
                    {  
                        //$( "input[name="+this_set_id+"]").remove();
                    }else{
                     console.log("Root nood data can't be delete");
                         
                    }
                 }   
   
               if(check_is_parent == 0 && user_data ==''){
				   
				   
					if(thisId in nodes ){
						var del_node_name=nodes[thisId].data.name;
						if(del_node_name){
							$("#delete_node_persmision").modal("show").find('.modal-content .modal-body h4').html('<span>Are you sure </span>you want to delete ' + del_node_name + '?' );
						}else {
							$("#delete_node_persmision").modal("show").find('.modal-content .modal-body h4').html('<span>Are you sure </span>you want to delete this node?');
						}
					}
				  $("#org-delete-btn").attr('node_id',thisId);
				  $(document).on("click", "#org-delete-btn", function(){
					del_node_id = $(this).attr('node_id');				 
					 console.log('check', $(".node[data_set_id="+this_set_id+"]").length);
					 // if($(".node[data_set_id="+this_set_id+"]").length <= 1){
						 // $( "input[name="+this_set_id+"]").remove();
					 // }
					if(del_node_id in nodes ){
						if(self.opts.onDeleteNode !== null ){
							self.opts.onDeleteNode(nodes[del_node_id]);
							 $("#delete_node_persmision").modal("hide");
						}
						else{
							self.deleteNode(del_node_id, this_set_id);
							$("#delete_node_persmision").modal("hide");
						}
					}
				  });
				
               }else{
                   if(user_data != 1){
						//alert("Permission Denied! Kindly remove the child nodes and try again.")
						$('#delete-node1').modal('show');
					}
			   }
                e.stopPropagation();
                del_set_data_count = 0;
                check_is_parent =0;
           /*}else{
                $(".statis_msg").show();
				$(".status_msg").text("You can't deleted uesd nodes");
           } 
            });*/
              }); 
        }
        
        this.startEdit = function(id){
            
            var inputElement = $('<input class="org-input" name="org_access" maxlength="40" data-node_id='+nodes[id].data.id+' type="text" value="'+nodes[id].data.name+'"/>');
            $container.find('div[node-id='+id+'] h2').replaceWith(inputElement);

            var commitChange = function(){
                var h2Element = $('<h2>'+nodes[id].data.name+'</h2>');
                if(opts.allowEdit){
                    h2Element.click(function(){
                        self.startEdit(id);
                    })
                }
                inputElement.replaceWith(h2Element);
            }  
            inputElement.focus();
            inputElement.keyup(function(event){
                if(event.which == 13){
                    commitChange();
                }
                else{
                    nodes[id].data.name = inputElement.val();
                }
			});
			
			setTimeout(function(){
				inputElement.focus();
				inputElement.blur(function(event){
					commitChange();
				})
			},300)
        }

        this.newNode = function(parentId){
             var setnodeid = '';
             var setrootid = '';
             var get_val ='';
             var nextId = Object.keys(nodes).length;
             var data_set_count =0;
              
            $(".node").each(function(){
                if($(this).attr('node-id')== 1){
                    setnodeid = 1;
                }

            if($(this).attr('node-id') != 1 && $(this).attr('node-id') == parentId){
                get_val = parseInt($(this).attr('data_set_id')) + 1;
                setnodeid = get_val;
            }
         
            });

             $(".node").each(function(){
            if($(this).attr('data_set_id')== setnodeid && $(this).attr('node-id') != 1 )
            {
                data_set_count++;
            }
             });

            if(data_set_count == 0){
				if(setnodeid >= 6){
					//$("#orgChartContainer").mCustomScrollbar('scrollTo', "bottom"); 
				}
				console.log(sidebar_data)
				var disabled = (accessPermissions.edit || accessPermissions.add) ? '' : 'disabled';
                $(".sidebar").append('<input '+disabled+'  type="text" name="'+setnodeid+'"  maxlength="40" class="form-control side_bar_data sidebar_txt_'+setnodeid+'">');
            }
			$('.cen-border').remove();
			$('<span class="cen-border"></span>').insertBefore('input.side_bar_data');
            

            while(nextId in nodes){
                nextId++;
            }
         
            self.addNode({id: nextId,name: '',parent: parentId ,set_id: setnodeid});
            data_set_count = 0;
        }
		/*Custom code*/
		$('<span class="cen-border"></span>').insertBefore('input.side_bar_data');
		
		this.addNode = function(data){
		
            var newNode = new Node(data);
            
            nodes[data.id] = newNode;
            nodes[data.parent].addChild(newNode);
            var get_arr  = nodes[data.parent].children.length;
        
            self.draw();
            self.startEdit(data.id);
        }


        this.deleteNode = function(id, set_id){

       /* $.ajax({
                method: "POST",
                url: 'check_node',
                data: {node_id: id},		
         }).done(function(responce) {
              console.log(responce);
     
        if(responce ==0){*/
		console.log("set_id", set_id, id);
        form_data = form_data.filter(function( obj ) {
            return obj.id !== id;
        }); 
		console.log(form_data);
        for(var i=0;i<nodes[id].children.length;i++){
				
                self.deleteNode(nodes[id].children[i].data.id);
               
            }
        /*}else{
            alert("Can't Delete the node");
        }  
		});*/  	
            nodes[nodes[id].data.parent].removeChild(id);
			form_data.id;
		
            delete nodes[id];
			
			//Delete Sidebar
			set_filter_form_data = form_data.filter(function( obj ) {
				return obj.set_id == set_id;
			}); 
			if(set_filter_form_data.length == 0){ 
				$( "input[name="+set_id+"]").prev('span').remove();
				$( "input[name="+set_id+"]").remove();
			}
		    self.draw();
			
        };
        this.getData = function(){
            var outData = [];
            for(var i in nodes){
                outData.push(nodes[i].data);
            }
            return outData;
        }

        // constructor
        for(var i in data){
            var node = new Node(data[i]);
            nodes[data[i].id] = node;
        }

        // generate parent child tree
        for(var i in nodes){
            if(nodes[i].data.parent == 0){
                rootNodes.push(nodes[i]);
            }
            else{
                nodes[nodes[i].data.parent].addChild(nodes[i]);
            }
        }

		
        // draw org chart
        $container.addClass('orgChart');
        self.draw();		
    }

    function Node(data){
    
        this.data = data;
        this.children = [];
		form_data.push(data);
        var self = this;

        this.addChild = function(childNode){
           
            this.children.push(childNode);
			
			
        }

        this.removeChild = function(id){
		
			
            for(var i=0;i<self.children.length;i++){
				
			if(self.children[i].data.id == id  ){
				    self.children.splice(i,1);
                    return;
                }
            }
        }

        this.render = function(opts){
            var childLength = self.children.length,
                mainTable;

            mainTable = "<table cellpadding='0' cellspacing='0' border='0'>";
            var nodeColspan = childLength>0?2*childLength:2;
            mainTable += "<tr><td colspan='"+nodeColspan+"'>"+self.formatNode(opts)+"</td></tr>";

            if(childLength > 0){
                var downLineTable = "<table cellpadding='0' cellspacing='0' border='0'><tr class='lines x'><td class='line left half'></td><td class='line right half'></td></table>";
                mainTable += "<tr class='lines'><td colspan='"+childLength*2+"'>"+downLineTable+'</td></tr>';

                var linesCols = '';
                for(var i=0;i<childLength;i++){
                    if(childLength==1){
                        linesCols += "<td class='line left half'></td>";    // keep vertical lines aligned if there's only 1 child
                    }
                    else if(i==0){
                        linesCols += "<td class='line left'></td>";     // the first cell doesn't have a line in the top
                    }
                    else{
                        linesCols += "<td class='line left top'></td>";
                    }

                    if(childLength==1){
                        linesCols += "<td class='line right half'></td>";
                    }
                    else if(i==childLength-1){
                        linesCols += "<td class='line right'></td>";
                    }
                    else{
                        linesCols += "<td class='line right top'></td>";
                    }
                }
                mainTable += "<tr class='lines v'>"+linesCols+"</tr>";

                mainTable += "<tr>";
                for(var i in self.children){
                    mainTable += "<td colspan='2'>"+self.children[i].render(opts)+"</td>";
                }
                mainTable += "</tr>";
            }
            mainTable += '</table>';
            return mainTable;
        }

        this.formatNode = function(opts){		
            var nameString = '',
                descString = '';
			var	render_set_id = this.data.set_id;				
			var disabled = '';
			if(typeof formData != "undefined" && formData.length !=0){    
                formData.forEach(function(item, i) {
					if(item.set_id == render_set_id){
						if(accessPermissions.add && accessPermissions.edit && accessPermissions.delete){
							disabled = "";
						}else if(accessPermissions.add && !accessPermissions.edit && !accessPermissions.delete){
							disabled = "disabled";
						}else if(!accessPermissions.add && !accessPermissions.edit && accessPermissions.delete){
							disabled = "disabled";
						}
                    }
                });
            }   			
			
            if(typeof data.name !== 'undefined'){
                nameString = '<h2 class="'+disabled+'">'+self.data.name+'</h2>';
            }
            if(typeof data.description !== 'undefined'){
                descString = '<p>'+self.data.description+'</p>';
            }
            if(opts.showControls){
				if(accessPermissions.add && accessPermissions.delete){
					var buttonsHtml = "<div class='org-add-button'  data_set_id ='"+this.data.set_id+"' data-parent='"+this.data.parent+"'>"+opts.newNodeText+"</div><div class='org-del-button'  data_set_id ='"+this.data.set_id+"'></div>";
				}else if(accessPermissions.add){
					var buttonsHtml = "<div class='org-add-button org-btn-center'  data_set_id ='"+this.data.set_id+"' data-parent='"+this.data.parent+"'>"+opts.newNodeText+"</div>";
				}else if(accessPermissions.delete){
					var buttonsHtml = "<div class='org-del-button org-btn-center'  data_set_id ='"+this.data.set_id+"'></div>";
				}else{
					buttonsHtml = '';
				}
            }
            else{
                buttonsHtml = '';
            }
            
            return "<div class='node' data-parent='"+this.data.parent+"' data_set_id ='"+this.data.set_id+"' data-parent='"+this.data.parent+"' node-id='"+this.data.id+"'>"+nameString+descString+buttonsHtml+"</div>";
        }
		
			
    }
	

})(jQuery);



