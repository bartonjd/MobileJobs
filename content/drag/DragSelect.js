Ext.ns("Ext.ux");

Ext.ux.DragSelect = function(id, sGroup, config) {
    if (id) {
        this.init(id, sGroup, config);
    }
    this.proxyCls = this.proxyCls || 'x-view-selector'; 
    Ext.applyIf(this, config);
}
Ext.extend(Ext.ux.DragSelect, Ext.dd.DragDrop, {

							startDrag : function(x,y) {

								this.startXYPos = [x,y];
								try {
									this.proxy = Ext.get("selectDiv").setDisplayed('block');
									this.container = this.container ||  Ext.get(this.handleElId);
								}
								catch (ex){
									this.container = Ext.get(this.handleElId);
									this.proxy = this.container.createChild({cls:this.proxyCls, id:'selectDiv'});

								}
								if(typeof this.startDragfn== "function"){
									try {
									this.onDragfn(startXY, endXY);
									}
									catch(ex){}
								}
							},
							onDrag: function(e) {
								var eventXY = e.getXY();
								var x = Math.min(this.startXYPos[0], eventXY[0]);
								var y = Math.min(this.startXYPos[1], eventXY[1]);
								var w = Math.abs(this.startXYPos[0] - eventXY[0]);
								var h = Math.abs(this.startXYPos[1] - eventXY[1]);
								var t=y;var l=(x+w);var b=(y+h);var r=x;
								region = new Ext.lib.Region(t,l,b,r);
								this.proxy.setRegion(new Ext.lib.Region(t,l,b,r));
								if(typeof this.onDragfn== "function"){
									try {
									this.onDragfn(startXY, endXY);
									}
									catch(ex){}
								}
								
							},
							
							getDifference : function (xy1, xy2, abs){
								var diff = [0,0];
								if (xy1 == null || xy2 == null){
									try {
									xy1 = this.startXYPos;
									xy2 = this.endXYPos;
									}
									catch(ex){
										return false;
									}
								}
								if (!abs){
									diff[0] = Math.abs(xy1[0]-xy2[0]);
									diff[1] = Math.abs(xy1[1]-xy2[1]);
							    }
								else {
									diff[0] = xy1[0]-xy2[0];
									diff[1] = xy1[1]-xy2[1];
							   }
							   
							   return diff;
							},
							
							endDrag : function(e) {
								try {
									this.endXYPos =e.getXY();
									var distanceXY = this.container.getAnchorXY("tl");
									startXY = this.getDifference(this.startXYPos,distanceXY);
									endXY = this.getDifference(this.endXYPos,distanceXY);
	
									if(typeof this.endDragfn== "function"){
										this.endDragfn(startXY,endXY);
									}
								}
								catch(ex){}
								finally {
						        this.proxy.setDisplayed(false);
								}
						    }

						});
	
