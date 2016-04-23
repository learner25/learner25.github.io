<!DOCTYPE html>
<html lang="en">
	<head>
		<title>three.js webgl - interactive - voxel painter</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<style>
			body {
				font-family: Monospace;
				background:url('bg.jpg');
				background-size:100% 100%;
				margin: 0px;
				overflow: hidden;
			}

			#oldie { background-color: #ddd !important }
		</style>
	</head>
	<body>

		<script src="build/three.min.js"></script>

		<script src="js/Detector.js"></script>
		<script src="js/renderers/CSS3DRenderer.js"></script>
		<script src="js/libs/stats.min.js"></script>
		<script src="js/libs/stats.min.js"></script>
		<script src="gesture/hammer.js-1.0.9/hammer.js"></script>
		

		<script>

			if ( ! Detector.webgl ) Detector.addGetWebGLMessage();

			var container, stats;
			var camera, scene, renderer;
			var projector, plane, cube;
			var mouse2D, mouse3D, raycaster,
			rollOveredFace, isShiftDown = false,
			theta = 45 * 0.5, isCtrlDown = false;

			var rollOverMesh, rollOverMaterial;
			var voxelPosition = new THREE.Vector3(), tmpVec = new THREE.Vector3(), normalMatrix = new THREE.Matrix3();
			var cubeGeo, cubeMaterial;
			var i, intersector;
             	var targetRotation = 0;
			var targetRotationOnMouseDown = 0;
             var group = new THREE.Object3D();
			var mouseX = 0;
			var mouseXOnMouseDown = 0;
			var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;

			init();
			animate();

			function init() {

				container = document.createElement( 'div' );
				document.body.appendChild( container );
               
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
				rollOverMaterial = new THREE.MeshBasicMaterial( { color: 0xff0000, opacity: 0.5, transparent: true } );
				rollOverMesh = new THREE.Mesh( rollOverGeo, rollOverMaterial );
				group.add( rollOverMesh );

				// cubes

				cubeGeo = new THREE.CubeGeometry( 50, 50, 50 );
				cubeMaterial = new THREE.MeshLambertMaterial( { color: 0xfeb74c, ambient: 0x00ff80, shading: THREE.SmoothShading } );
				cubeMaterial.ambient = cubeMaterial.color;

				// picking

				projector = new THREE.Projector();

				// grid

				var size = 500, step = 50;

				var geometry = new THREE.Geometry();

				for ( var i = - size; i <= size; i += step ) {

					geometry.vertices.push( new THREE.Vector3( - size, 0, i ) );
					geometry.vertices.push( new THREE.Vector3(   size, 0, i ) );

					geometry.vertices.push( new THREE.Vector3( i, 0, - size ) );
					geometry.vertices.push( new THREE.Vector3( i, 0,   size ) );

				}

				var material = new THREE.LineBasicMaterial( { color: 0xffffff, opacity: 0.4 ,emission:0xffffff} );

				var line = new THREE.Line( geometry, material );
				line.type = THREE.LinePieces;
				group.add( line );

				plane = new THREE.Mesh( new THREE.PlaneGeometry( 1000, 1000 ), new THREE.MeshBasicMaterial() );
				plane.rotation.x = - Math.PI / 2;
				plane.visible = false;
				group.add( plane );

				mouse2D = new THREE.Vector3( 0, 10000, 0.5 );

				// Lights

				var ambientLight = new THREE.AmbientLight( 0x606060 );
				group.add( ambientLight );

				var directionalLight = new THREE.DirectionalLight( 0xffffff );
				directionalLight.position.set( 1, 0.75, 0.5 );
				group.add( directionalLight );
                
				
				scene.add(group);
				
				renderer = new THREE.WebGLRenderer( { antialias: true, preserveDrawingBuffer: true } );
				renderer.setSize( window.innerWidth, window.innerHeight );

				container.appendChild( renderer.domElement );
				renderer.domElement.setAttribute("id","gocanvas");

				// stats = new Stats();
				// stats.domElement.style.position = 'absolute';
				// stats.domElement.style.top = '0px';
				// container.appendChild( stats.domElement );

				document.addEventListener( 'mousemove', onDocumentMouseMove, false );
				document.addEventListener( 'mousedown', onDocumentMouseDown, false );
				document.addEventListener( 'keydown', onDocumentKeyDown, false );
				document.addEventListener( 'keyup', onDocumentKeyUp, false );
				//document.addEventListener( 'touchstart', onDocumentTouchStart, false );
				//document.addEventListener( 'touchmove', onDocumentTouchMove, false );
				//

				window.addEventListener( 'resize', onWindowResize, false );
                 //touch detection
				  var element = document.getElementById('gocanvas');
				 var event = Hammer(element).on("touch",function(event){
			         mouseXOnMouseDown = event.gesture.touches[ 0 ].pageX - windowHalfX;
					targetRotationOnMouseDown = targetRotation;
					});
				 
				  var element = document.getElementById('gocanvas');
				 var event2 = Hammer(element).on("hold",function(event){
			       ;
				 });
				 
				 var event = Hammer(element).on("swipe",function(event){
			        mouseX = event.gesture.touches[ 0 ].pageX - windowHalfX;
					targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.009;

				 });
				
					 

				 
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

				tmpVec.copy( intersector.face.normal );
				tmpVec.applyMatrix3( normalMatrix ).normalize();

				voxelPosition.addVectors( intersector.point, tmpVec );

				voxelPosition.x = Math.floor( voxelPosition.x / 50 ) * 50 + 25;
				voxelPosition.y = Math.floor( voxelPosition.y / 1000000 ) * 50 + 25;
				voxelPosition.z = Math.floor( voxelPosition.z / 50 ) * 50 + 25;

			}

			function onDocumentMouseMove( event ) {

				event.preventDefault();

				mouse2D.x = ( event.clientX / window.innerWidth ) * 2 - 1;
				mouse2D.y = - ( event.clientY / window.innerHeight ) * 2 + 1;

			}

			function onDocumentMouseDown( event ) {

				event.preventDefault();

				var intersects = raycaster.intersectObjects( group.children );

				if ( intersects.length > 0 ) {

					intersector = getRealIntersector( intersects );

					// delete cube

					if ( isCtrlDown ) {

						if ( intersector.object != plane ) {

							group.remove( intersector.object );

						}

					// create cube

					} else {

						intersector = getRealIntersector( intersects );
						setVoxelPosition( intersector );

						var voxel = new THREE.Mesh( cubeGeo, cubeMaterial );
						voxel.position.copy( voxelPosition );
						voxel.matrixAutoUpdate = false;
						voxel.updateMatrix();
						group.add( voxel );

					}

				}
			}

			function onDocumentKeyDown( event ) {

				switch( event.keyCode ) {

					case 82: isShiftDown = true; break;
					case 17: isCtrlDown = true; break;

				}

			}

			function onDocumentKeyUp( event ) {

				switch ( event.keyCode ) {

					case 82: isShiftDown = false; break;
					case 17: isCtrlDown = false; break;

				}

			}

			//

			/*function onDocumentTouchStart( event ) {

				if ( event.touches.length == 1 ) {

					event.preventDefault();

					mouseXOnMouseDown = event.touches[ 0 ].pageX - windowHalfX;
					targetRotationOnMouseDown = targetRotation;

				}

			}

			function onDocumentTouchMove( event ) {

				if ( event.touches.length == 1 ) {

					event.preventDefault();

					mouseX = event.touches[ 0 ].pageX - windowHalfX;
					targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.009;

				}

			}*/
			
			
			function animate() {

				requestAnimationFrame( animate );
                group.rotation.y += ( targetRotation - group.rotation.y ) * 0.009;
				render();
				stats.update();

			}

			function render() {

				

				raycaster = projector.pickingRay( mouse2D.clone(), camera );

				var intersects = raycaster.intersectObjects( group.children );

				if ( intersects.length > 0 ) {

					intersector = getRealIntersector( intersects );
					if ( intersector ) {

						setVoxelPosition( intersector );
						rollOverMesh.position = voxelPosition;

					}

				}
                  
				camera.position.x = 1400 * Math.sin( THREE.Math.degToRad( theta ) );
				camera.position.z = 1400 * Math.cos( THREE.Math.degToRad( -1*theta ) );

				camera.lookAt( scene.position );

				renderer.render( scene, camera );

			}

		</script>

	</body>
</html>
