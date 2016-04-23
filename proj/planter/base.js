              var clock = new THREE.Clock();
			var container, stats;
			var camera, scene, renderer;
			var projector, plane, cube;
			var mouse2D, mouse3D, raycaster,
			rollOveredFace, isShiftDown = false,
			theta = 45 * 0.5, isCtrlDown = false;
            var controls;
			var rollOverMesh, rollOverMaterial;
			var voxelPosition = new THREE.Vector3(), tmpVec = new THREE.Vector3(), normalMatrix = new THREE.Matrix3();
			var cubeGeo, cubeMaterial,line,materials;
			var i, intersector;
			var end,start;
			var cube_count=0;
			var min_con;
			function system()
			{
			
				  
				  var bal = new XMLHttpRequest();
				  var url = mruser+".JSON";
				  //var vars = "data="+dataUri+"&username="+mruser;
				  
				  bal.open("GET",url,true);
				   // bal.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				  bal.onreadystatechange = function()
				  {
				    if(bal.readyState ==4 && bal.status ==200)
					  
					  {
									 
					  var voxels = JSON.parse(bal.response);  
					  var children	= scene.children.slice(0);

				for( var i = 0; i < children.length; i++ ) {

					if( children[i] instanceof THREE.Mesh === false ) continue;
					if( children[i].geometry instanceof THREE.CubeGeometry === false ) continue;
					if( children[i] === rollOverMesh ) continue;

					scene.__removeObject( children[i] );
					
				}	
					   for(i=0;i<voxels.length;i++)
					    {
						  var voxel = voxels[i];
                     	var count_div = parent.window.document.getElementById('counter');
						cube_count=voxel.t;
						count_div.innerHTML = voxel.t;
						 var price_div = parent.window.document.getElementById('price');
						 price_div.innerHTML = "$"+8*cube_count;
					var meshi = new THREE.Mesh(cubeGeo,cubeMaterial);
					meshi.position.x = voxel.x;
					meshi.position.y = voxel.y;
					meshi.position.z = voxel.z;
					meshi.matrixAutoUpdate = true;
					meshi.updateMatrix();
					meshi.name="voxel";
					scene.add(meshi);
					
					console.log(voxels.length);
						
						}
					  //document.getElementById('clean').onclick = clean();
				  }
				 
			}
			 bal.send();
			
			}
			
			init();
			animate();
			var addmode=true,delmode=false;
		    doc_arr=[];
			var dada=false;var biccu = [];
			if(parent.window.location.search==="?user=" ||parent.window.location.search==="")
			    parent.window.location.pathname="/saimon/proj/planter/index.php";
				else 
			 {
			  var mruser = window.atob(parent.window.location.search.slice(parent.window.location.search.indexOf('=')+1));
	          //document.getElementById('hidden').value = mruser;
	           alert("welcome mr." + mruser);
			   }
			   
			function init() {
					
				container = document.createElement( 'section' );
				document.body.appendChild( container ).setAttribute("id","focal");
				var min_con = container.appendChild(document.createElement( 'div' ));
				min_con.setAttribute("class","panzoom");
				;
				/*var info = document.createElement( 'div' );
				info.style.position = 'absolute';
				info.style.top = '10px';
				info.style.width = '100%';
				info.style.textAlign = 'center';
				info.innerHTML = '<a href="http://threejs.org" target="_blank">three.js</a> - voxel painter - webgl<br><strong>click</strong>: add voxel, <strong>control + click</strong>: remove voxel, <strong>shift + click</strong>: rotate';
				container.appendChild( info );*/

				camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 10000 );
				camera.position.y = 800;

				scene = new THREE.Scene();

				// roll-over helpers

				rollOverGeo = new THREE.CubeGeometry( 50, 50, 50 );
				rollOverMaterial = new THREE.MeshBasicMaterial( { color: 0xff0000, opacity: 0.5, transparent: true,wireframeLinewidth:4,} );
				rollOverMesh = new THREE.Mesh( rollOverGeo, rollOverMaterial );
				scene.add( rollOverMesh );
				
				rollOverMesh.position.y = 25;
				
				// cubes
			
				cubeGeo = new THREE.CubeGeometry( 50, 50, 50 );
				texture = new THREE.ImageUtils.loadTexture('outline.png');
			
               var material1 = new THREE.MeshPhongMaterial( { map: THREE.ImageUtils.loadTexture('1.png') } );
    var material2 = new THREE.MeshPhongMaterial( { map: THREE.ImageUtils.loadTexture('1.png') ,overdraw:1} );
    var material3 = new THREE.MeshPhongMaterial( { map: THREE.ImageUtils.loadTexture('green.png'),overdraw:1} );
    var material4 = new THREE.MeshPhongMaterial( { map: THREE.ImageUtils.loadTexture('1.png') ,overdraw:1} );
    var material5 = new THREE.MeshPhongMaterial( { map: THREE.ImageUtils.loadTexture('1.png'),overdraw: 1 } );
    var material6 = new THREE.MeshPhongMaterial( { map: THREE.ImageUtils.loadTexture('1.png') ,overdraw: 1} );
 
    materials = [material1, material2, material3, material4, material5, material6];
					
						   	cubeMaterial = new THREE.MeshFaceMaterial(materials);
						
				    cubeGeo.colorsNeedUpdate = true
				// picking

				projector = new THREE.Projector();

				// grid

				var size = 1500, step = 50;

				var geometry = new THREE.Geometry();

				for ( var i = - size; i <= size; i += step ) {

					geometry.vertices.push( new THREE.Vector3( - size, 0, i ) );
					geometry.vertices.push( new THREE.Vector3(   size, 0, i ) );

					geometry.vertices.push( new THREE.Vector3( i, 0, - size ) );
					geometry.vertices.push( new THREE.Vector3( i, 0,   size ) );

				}

				var material = new THREE.LineBasicMaterial( { color: 0x000000, opacity: 0.2 } );
			
				 line = new THREE.Line( geometry, material );
				line.type = THREE.LinePieces;
				scene.add( line );

				plane = new THREE.Mesh( new THREE.PlaneGeometry( 3000, 3000 ), new THREE.MeshBasicMaterial() );
				plane.rotation.x = - Math.PI / 2;
				plane.visible = false;
				scene.add( plane );

				mouse2D = new THREE.Vector3( 0, 10000, 0.5 );

				// Lights

				var ambientLight = new THREE.AmbientLight( 0x606060 );
				scene.add( ambientLight );

				var directionalLight = new THREE.DirectionalLight( 0xffffff );
				directionalLight.position.set( 1, 0.75, 0.5 ).normalize();
				scene.add( directionalLight );
				  if ( ! Detector.webgl ) 
				renderer = new THREE.CanvasRenderer( { antialias: true , preserveDrawingBuffer:true} );
				else
				renderer = new THREE.WebGLRenderer({antialias:true, preserveDrawingBuffer: true});
				
				renderer.setSize( window.innerWidth, window.innerHeight );
                 renderer.setClearColor(0xaeaeae);
				 
				min_con.appendChild( renderer.domElement );
                   var can = renderer.domElement;
				
				can.addEventListener( 'mousemove', onDocumentMouseMove, false );
				can.addEventListener( 'mousedown', onDocumentMouseDown, false );
				can.addEventListener( 'mouseup', onDocumentMouseup, false );
				//document.addEventListener( 'keydown', onDocumentKeyDown, false );
				//document.addEventListener( 'keyup', onDocumentKeyUp, false );
				//can.addEventListener( 'touchstart', touchstart, false );
				can.addEventListener( 'touchstart', ontouchstart, false );
				can.addEventListener( 'touchmove', ontouchmove, false );
				can.addEventListener( 'touchend', onDocumenttouchend, false );
				//
				
				window.addEventListener( 'resize', onWindowResize, false );
				//controls = new THREE.TrackballControls(camera);
				//
				camera.position.x = 2688.3407695722935;
				camera.position.z = 49.729562684110974;
				controls = new THREE.OrbitControls( camera ,can );
				  controls.rotateSpeed = .2950;
				  controls.zoomSpeed = .645;
				  controls.panSpeed = 2;
				  controls.noZoom =false;
				  controls.noPan = true;
				  controls.staticMoving = false;
				  controls.dynamicDampingFactor = 0.3;
				  
				   renderer.domElement.setAttribute("class","panzoom");
				

			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

			}

			function getRealIntersector( intersects ) {

				for( i = 0; i < intersects.length; i++ ) {

					intersector = intersects[ i ];

					if ( intersector.object != rollOverMesh ) {

						return intersector;

					}

				}

				return null;

			}
				
			function setVoxelPosition( intersector ) {
              

					

				
				normalMatrix.getNormalMatrix( intersector.object.matrixWorld );
				if(intersector.face !==null)
				tmpVec.copy( intersector.face.normal );
				tmpVec.applyMatrix3( normalMatrix ).normalize();

				voxelPosition.addVectors( intersector.point, tmpVec );

				voxelPosition.x = Math.floor( voxelPosition.x / 50 ) * 50 + 25;
				voxelPosition.y = Math.floor( voxelPosition.y / 50 ) * 50 + 25;
				voxelPosition.z = Math.floor( voxelPosition.z / 50 ) * 50 + 25;
              
			}

			function onDocumentMouseMove( event ) {

				event.preventDefault();
				
				mouse2D.x = ( event.clientX / window.innerWidth ) * 2 - 1;
				mouse2D.y = - ( event.clientY / window.innerHeight ) * 2 + 1;
			    //controls.target.x = event.clientX;
				//controls.target.y = mouse2D.y;
				//camera.translateX(event.clientX);
				
			}
                
					function ontouchmove( event ) {

				event.preventDefault();

				mouse2D.x = ( event.touches[ 0 ].pageX / window.innerWidth ) * 2 - 1;
				mouse2D.y = - ( event.touches[ 0 ].pageY / window.innerHeight ) * 2 + 1;
				//console.log("touch started at:"+mouse2D.x);

			}

				
			function onDocumentMouseDown( event ) {
              
				event.preventDefault();
				event.stopPropagation();
				 start = event.timeStamp;
				


					}
					function ontouchstart( event ) {
              
				event.preventDefault();
				event.stopPropagation();
				 start = event.timeStamp;
			


					}
				
				
			
			function onDocumentMouseup( event ) {
				event.stopPropagation();
				event.preventDefault();
                  end =  event.timeStamp;
				  var intersects = raycaster.intersectObjects( scene.children );
				  if(end-start<500)
				  {
				  
					
					
				if ( intersects.length > 0 ) {

					
						
					// delete cube
						
						   
						
					
                    //add cube on 1st layer  
					   if(rollOverMesh.position.y<=25)
					  {
					    //console.log(intersects);
						intersector = getRealIntersector( intersects );
						setVoxelPosition( intersector );
						var count_div = parent.window.document.getElementById('counter');
						var voxel = new THREE.Mesh( cubeGeo, cubeMaterial );
						voxel.position.copy( voxelPosition );
						voxel.matrixAutoUpdate = true;
						voxel.updateMatrix();
						scene.add( voxel );
						voxel.name = 'voxel';
						//var help = new THREE.EdgesHelper(voxel,0xfeb74c);
						//scene.add(help);
						cube_count+=1;
						count_div.innerHTML = cube_count;
						 var price_div = parent.window.document.getElementById('price');
						price_div.innerHTML = "$"+cube_count*8;
						}
						
						//add cube on top
						
						else if(rollOverMesh.position.y>25 )
					{
					   
					   
						if(intersector.faceIndex==5 ||intersector.faceIndex==4)
					   {
					   
						//intersector.object.name = "hastopcube";
					    intersector = getRealIntersector( intersects );
						console.log(intersector);
						setVoxelPosition( intersector );
						var count_div = parent.window.document.getElementById('counter');
						var voxel = new THREE.Mesh( cubeGeo, cubeMaterial );
						voxel.position.copy( voxelPosition );
						voxel.matrixAutoUpdate = true;
						voxel.updateMatrix();
						voxel.name = 'voxel';
						scene.add( voxel );
						cube_count+=1;
						//voxel.name = "upper";
						
						count_div.innerHTML = cube_count;
						 var price_div = parent.window.document.getElementById('price');
						price_div.innerHTML = "$"+cube_count*8;
					   }
					}
				  
				  
				    }
				  }
				//var intersects = raycaster.intersectObjects( scene.children );
					
				if ( intersects.length > 0 ) {

					intersector = getRealIntersector( intersects );
						
					// delete cube
                         console.log(end-start);
					if ( end-start>900  ) {
                          
						if ( intersector.object != plane && intersector.object != line ) {
                              
								
							  	if(intersector.faceIndex==5 ||intersector.faceIndex==4)
								{
								tmpVec.copy( intersector.face.normal );
								tmpVec.applyMatrix3( normalMatrix ).normalize();
								rollOverMesh.position.addVectors( intersector.point, tmpVec );
							    scene.remove( intersector.object );
								 var count_div = parent.window.document.getElementById('counter');
						   
						cube_count-=1;
						count_div.innerHTML = cube_count;
						 var price_div = parent.window.document.getElementById('price');
						price_div.innerHTML = "$"+cube_count*8;
								}
							
							
		                  
						}
						}

					// create cube

					} 
				}
			
				
				
				
			function onDocumentKeyDown( event ) {

				switch( event.keyCode ) {

					case 16: isShiftDown = true; break;
					case 17: isCtrlDown = true; break;

				}

			}

			function onDocumentKeyUp( event ) {

				switch ( event.keyCode ) {

					case 16: isShiftDown = false; break;
					case 17: isCtrlDown = false; break;

				}

			}
				/*function touchstart(event)
				{
				  if(event)
				  {
				   start = new Date().getMilliseconds();
				   console.log(start);
				  }
				}*/
				function onDocumenttouchend( event ) {

				event.preventDefault();
				event.stopPropagation();
                  end =  event.timeStamp;
				  if(end-start<500)
				  {
				  var intersects = raycaster.intersectObjects( scene.children );
					
					
				if ( intersects.length > 0 ) {

					
						
					// delete cube
						
						   
						
					
                    //add cube on 1st layer  
					   if(rollOverMesh.position.y<=25)
					  {
						intersector = getRealIntersector( intersects );
						setVoxelPosition( intersector );
						var count_div = parent.window.document.getElementById('counter');
						var voxel = new THREE.Mesh( cubeGeo, cubeMaterial );
						voxel.name = 'voxel';
						voxel.position.copy( voxelPosition );
						voxel.matrixAutoUpdate = true;
						voxel.updateMatrix();
						scene.add( voxel );
						//var help = new THREE.EdgesHelper(voxel,0xfeb74c);
						//scene.add(help);
						cube_count+=1;
						count_div.innerHTML = cube_count;
						 var price_div = parent.window.document.getElementById('price');
						price_div.innerHTML = "$"+cube_count*8;
						}
						
						//add cube on top
						
						else if(rollOverMesh.position.y>25 )
					{
					   
					   
						if(intersector.faceIndex==5 ||intersector.faceIndex==4)
					   {
					   
					   intersector = getRealIntersector( intersects );
						setVoxelPosition( intersector );
						var count_div = parent.window.document.getElementById('counter');
						var voxel = new THREE.Mesh( cubeGeo, cubeMaterial );
						voxel.position.copy( voxelPosition );
						voxel.name = 'voxel';
						doc_arr.push(voxel.position);
						voxel.matrixAutoUpdate = true;
						voxel.updateMatrix();
						scene.add( voxel );
						cube_count+=1;
						count_div.innerHTML = cube_count;
						  console.log(doc_arr.length+"is current length");
						 var price_div = parent.window.document.getElementById('price');
						price_div.innerHTML = "$"+cube_count*8;
					   }
					  
					}
				  
				  
				  }
				  }
				var intersects = raycaster.intersectObjects( scene.children );
					
				if ( intersects.length > 0 ) {

					intersector = getRealIntersector( intersects );
						
					// delete cube
                         console.log(end-start);
					if ( end-start>900  ) {
                          
						if ( intersector.object != plane && intersector.object != line ) {
							
								
							  	if(intersector.faceIndex==5 ||intersector.faceIndex==4)
							  scene.remove( intersector.object );
							
							
		                   var count_div = parent.window.document.getElementById('counter');
						
						cube_count-=1;
						count_div.innerHTML = cube_count;
						 var price_div = parent.window.document.getElementById('price');
						price_div.innerHTML = "$"+cube_count*8;
						}

					// create cube

					} 
				}
			
				
				}
				
				
					
			//

			function animate() {

				requestAnimationFrame( animate );
				controls.update();
				//controls.object.lookAt(traker1,rollOverMesh.position.y,rollOverMesh.position.z);
				//controls.target.set(traker1,rollOverMesh.position.y,rollOverMesh.position.z);
				//dollyStart.set( traker1, event.clientY );
				//if(controls.isZooming)
				
				
				camera.lookAt(rollOverMesh.position);
				
				
				camera.updateProjectionMatrix();
				render();
				//stats.update();

			}

			function render() {

				/*if ( isShiftDown ) {

					theta += mouse2D.x * 1.5;

				}*/
				//controls.target  = rollOverMesh.position;
				//controls.reset();
				raycaster = projector.pickingRay( mouse2D.clone(), camera );

				var intersects = raycaster.intersectObjects( scene.children );

				if ( intersects.length > 0 ) {

					intersector = getRealIntersector( intersects );
					if ( intersector ) {

						setVoxelPosition( intersector );
						rollOverMesh.position = voxelPosition;
						//var help_roll = new THREE.EdgesHelper(rollOverMesh,0xff0000);
						//scene.add(help_roll);
					}
					controls.update();
                  
				}

				//camera.position.x = 1400 * Math.sin( THREE.Math.degToRad( theta ) );
				//camera.position.z = 1400 * Math.cos( THREE.Math.degToRad( theta ) );
               
				camera.lookAt( scene.position );
            
				  scene.updateMatrix();
				  //controls.target(controls.reset());
				renderer.render( scene, camera );

			}
                 
			
			 
			 function saveJSON() {

				var children	= scene.children;
				var voxels	= [];

				for( var i = 0; i < children.length; i++ ) {
					var child	= children[i];

					if( child instanceof THREE.Mesh === false )			continue;
					if( child.geometry instanceof THREE.CubeGeometry === false )	continue;
					if( child === rollOverMesh )					continue;

					voxels.push({
						x	: (child.position.x) ,
						y	: (child.position.y),
						z	: (child.position.z),
						t   :  cube_count
					});
					
				}
				
				// open a window with the json
				var dataUri	= JSON.stringify(voxels);
				
				//indow.open( dataUri, 'mywindow' );
                  console.log(dataUri);
				  
				  var bal = new XMLHttpRequest();
				  var url = "processor.php";
				  var vars = "data="+dataUri+"&username="+mruser;
				  
				  bal.open("POST",url,true);
				    bal.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				  bal.onreadystatechange = function()
				  {
				    if(bal.readyState ==4 && bal.status ==200)
					
					   parent.window.document.getElementById('save').innerHTML = 'save';
				  }
				   parent.window.document.getElementById('save').innerHTML = 'saving..';
				  bal.send(vars);
			}
			
			
			
			//zoom 786
			var mvMatrix = camera.matrixWorldInverse.multiply(scene.matrixWorld);
			var pMatrix =  camera.projectionMatrix;
			
			var eye = new THREE.Vector3();
			var pvMatrix = new THREE.Matrix4();
			var pvMatrixInverse = new THREE.Matrix4();
			
			
			var mvMatrixIdentity =  mvMatrix.identity();
			
			mvMatrix.makeTranslation(eye);
			pMatrix.multiplyMatrices(mvMatrix,pvMatrix);
			
			
			renderer.domElement.addEventListener('mousedown',zoom,false);
			function zoom(e)
			{
			  var world1 = new THREE.Vector4() ;
			  var world2 = new THREE.Vector4();
			  var direction = new THREE.Vector3();
			  
			  var mw = event.srcElement.clientWidth;
			  var mh = event.srcElement.clientHeight;
			  
			  var x = (event.offsetX - mw/2)/(mw/2);
			  var y = -(event.offsetY - mh/2)/(mh/2);
			  
			  console.log(world1.applyMatrix4(camera.projectionMatrix));
			 // world1.applyMatrix4(1/world1[3]);
			  world2.applyMatrix4(pvMatrix);
			  //camera.applyMatrix(pMatrix);
			 camera.updateProjectionMatrix();
			// console.log( world2.applyMatrix4(pvMatrix));
			  //world2.scale(1/world2[3]);
			  //var temp = new THREE.Vector3();
			  //temp.subVectors(world2,world);
			  //temp.sub(dir);
			 // dir.scale(.3);
			 // eye.sub(dir);
			 render();
			 
			  
			}
			
			
				 function clean()
			 {
			 var children	= scene.children;
			 
				//var voxels	= [];
			  for( var i = 0; i < children.length; i++ ) {

					if( children[i] instanceof THREE.Mesh === false ) continue;
					if( children[i].geometry instanceof THREE.CubeGeometry === false ) continue;
					if( children[i] === rollOverMesh ) continue;
                    {
					
					scene.__removeObject( children[i] );
					children.splice(i,1);
					biccu.push(children[i]);
                    }
				var count_div = parent.window.document.getElementById('counter');
				//scene.children.splice(i,1);
				 var price_div = parent.window.document.getElementById('price');
				// cube_count =biccu.length;
				if(biccu.length<cube_count)
						count_div.innerHTML = cube_count-biccu.length;
						else
						count_div.innerHTML = biccu.length-cube_count;
						
						price_div.innerHTML = "$"+parseInt(count_div.textContent)*8;
						
					
						
						var bal = new XMLHttpRequest();
						var posts = "userfile="+mruser;
						bal.open("POST","blanker.php",true);
						 bal.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						bal.readystatechange = function()
						  {
						   if(bal.readyState ==4 && status ==200)
						   ;
						  }
						bal.send(posts);
						}
				   console.log(biccu.length);
				   if(confirm("are you sure to clear the scene?"))
				   {
				   count_div.innerHTML = "0";
					price_div.innerHTML = "$"+"0";
				    parent.document.getElementById('if').contentWindow.location.reload();
				   }
				    
					        
				}
				
				var par_save = parent.window.document.getElementById('save');
				par_save.onclick = function(){
				saveJSON();
				}
				var par_clear = parent.window.document.getElementById('clear');
				par_clear.onclick = function(){
				clean();
				}