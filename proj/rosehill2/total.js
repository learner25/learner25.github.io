var scene,camera,renderer,material,mesh,clock,controls,keyboard,cube,holder,flag=false,effect,count=0,container, planeMesh,body,cube2,geo2,width=7,cube3,test,effect;
 var startime,quaternion ;
 var origin,direction,near,far;
 origin = new THREE.Vector3();
 direction = new THREE.Vector3();
 var scale = 1000;
  var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;
			var mouseX,mouseY;
			function onload()
			
			{
			    container = document.createElement('div');
    document.body.appendChild(container);
 camera = new THREE.PerspectiveCamera(50, window.innerWidth*.9 / window.innerHeight*.9,1,10000);
    //camera = new THREE.PerspectiveCamera( 50, 1, 1, 5000 );
camera.position.set(148.13071548449582,23.712216733341002,147.47525088321572);
camera.rotation.set(-0.09756442421174907,0.8055137559555768,0.04408746385394859);

//camera.updateProjectionMatrix();
   
   
    
    scene = new THREE.Scene();
	clock = new THREE.Clock();
	controls = new THREE.FirstPersonControls(camera);
	
				controls.movementSpeed = 60.007;
                 controls.lookSpeed = .05930;
				controls.activeLook = true;
     var holder = new THREE.Object3D();
	 holder.position.set(0,0,0);
	
  
    
    var groundMaterial = new THREE.MeshPhongMaterial({
        color: 0x0e0e0e,map:new THREE.ImageUtils.loadTexture('Google_Earth_Snapshot_1.jpg')
    });
    plane = new THREE.Mesh(new THREE.PlaneGeometry(922,825), groundMaterial);
    plane.rotation.x = -Math.PI / 2;
    plane.receiveShadow = true;
	plane.dynamic = true;
    plane.scale.set(.5,.5,.5);
    //holder.add(plane);
     plane.position.set(0,4.5,0);
    // LIGHTS
    scene.add(new THREE.AmbientLight(0xFFFFFF));

    var light;

   light = new THREE.DirectionalLight(0xFFFfff, 1.75);
    light.position.set(10, 200, 50);
    

    //light.castShadow = true;
   // light.shadowCameraVisible = true;

   /* light.shadowMapWidth = 1024;
    light.shadowMapHeight = 1024;
    
    

    light.shadowCameraLeft = -200;
    light.shadowCameraRight = 200;
    light.shadowCameraTop = 300;
    light.shadowCameraBottom =-400;

    light.shadowCameraFar = 1000;
    light.shadowDarkness = 2.9;*/
    //scene.fog = new THREE.FogExp2( 0xefd1b5, 0.0125 );
    scene.add(light);
    
   var fixer = new THREE.CubeGeometry(13,7,21);
   var fix_mesh = new THREE.Mesh(fixer,new THREE.MeshBasicMaterial({map:new THREE.ImageUtils.loadTexture('fix-1.JPG'),opacity:1.92,transparent:true,combine:THREE.MixOperation}));
   fix_mesh.position.set(18.44,1.52,218.79);
  fix_mesh.scale.set(.5,1,.5);
   scene.add(fix_mesh);
   
    var fixer2 = new THREE.CubeGeometry(13,7,21);
   var fix_mesh2 = new THREE.Mesh(fixer,new THREE.MeshBasicMaterial({map:new THREE.ImageUtils.loadTexture('fix-1.JPG'),opacity:.92,transparent:true,combine:THREE.AddOperation}));
   fix_mesh2.position.set(-129.68,2.75,-168.58);
  fix_mesh2.scale.set(.5,1,.5);
   scene.add(fix_mesh2);

	
	var loader2 = new THREE.JSONLoader();
	loader2.load("reduced.js",function(geometry,material){
	  mesh= new THREE.Mesh( geometry, new THREE.MeshFaceMaterial(material));
	  material.opacity = .43;
	  material.transparent = true;
	  material.combine = THREE.MixOperation;
      mesh.scale.set( 22.75,22.75,22.75 );
      mesh.position.set(0,0,0);
	  //mesh.rotation.set(0,-Math.PI/6,0);
	  scene.add(mesh);
	// holder.add(mesh);
	 // controls.target.set(120,-4,-388);
	   //controls.target = holder.position;
	// console.log(controls.radius);
//vector = new THREE.Vector3( mesh.position.x, mesh.position.y, mesh.position.z );
//mesh.position.applyQuaternion( quaternion );
mesh.castShadow = true;		
mesh.recieveShadow = true;
 animate();
 //console.log(mesh);
  });
	
	
  
   
    webglRenderer = new THREE.WebGLRenderer({antialiasing:false,stencil:false});
    webglRenderer.setSize(window.innerWidth, window.innerHeight);
    webglRenderer.domElement.style.position = "relative";
    webglRenderer.shadowMapEnabled = true;
    webglRenderer.shadowMapSoft = false;
    webglRenderer.physicallyBasedShading
    container.appendChild(webglRenderer.domElement);
    window.addEventListener('resize', onWindowResize, false);
	//animate();
	
	
	scene.add(holder);
}

function onWindowResize() {
    windowHalfX = window.innerWidth / 2;
    windowHalfY = window.innerHeight / 2;
 
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();

    webglRenderer.setSize(window.innerWidth, window.innerHeight);
}

function animate() {
     
    var timer = Date.now() * 0.0002;
    //camera.position.x = Math.cos(timer) * 1000;
    //camera.position.z = Math.sin(timer) * 1000;
	controls.update(clock.getDelta());
	if(camera.position.y<=mesh.position.y+7.00)
	   {
	   var step=0;
	   while(step<=7)
	   {
	   camera.position.y = mesh.position.y+step;
	    step++;
		}
	   }
	   
    requestAnimationFrame(animate);
	//mesh.rotation.y+=.03;
	
	var get_id = document.getElementById('description');
	get_id.innerHTML = 'x: '+ camera.position.x+ '<br>' + 'y: '+ camera.position.y + '<br>'+'z: '+ camera.position.z+ '<br>'+'x-rot: '+camera.rotation.x+ '<br>'+'y-rot: '+camera.rotation.y+ '<br>'+'z-rot: '+camera.rotation.z;
	
	
	
    render();
}

function render() {
        
	     
        webglRenderer.render(scene, camera);
}