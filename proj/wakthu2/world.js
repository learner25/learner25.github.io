var world = function()
{
	
	
			loader.options.convertUpAxis = true;
			loader.load( 'models/janina.dae', function ( collada ) {

				dae = collada.scene;
                camera.position.set(1,10,32);
				dae.traverse( function ( child ) {
                    console.log(child);
                   
                           
					if ( child instanceof THREE.SkinnedMesh ) {
                        
						var animation = new THREE.Animation( child, child.geometry.animation );
                       // console.log(child);
						animation.play();
                        
					}
                    if ( child instanceof THREE.Mesh ) {
                        
                            var name = null;
                        console.log('the materials for '+name +' is :');
                         console.log(child.geometry);
                         child.castShadow = true;
                         child.receiveShadow = true;
                       
                        child.name = "world"
                         objects.push(child);
                        child.position.y = -.013;
                        
                        ;
                    }
                    if ( child instanceof THREE.DirectionalLight ) {
                        
                        child.intensity = child.intensity*.4;
                    }
                    dae.children[1].children[0].material = new THREE.MeshPhongMaterial();
                     dae.children[1].children[0].material.map = new THREE.ImageUtils.loadTexture('models/mymap.png');
                    dae.children[1].children[0].material.bumpMap = new THREE.ImageUtils.loadTexture('models/mymapb.jpg');
                    dae.children[1].children[0].material.lightMap = new THREE.ImageUtils.loadTexture('models/lightmp.jpg');
                      dae.children[1].children[0].material.specularMap = new THREE.ImageUtils.loadTexture('models/lightmp.jpg');
                      dae.children[1].children[0].geometry.computeVertexNormals();
                       dae.children[1].children[0].geometry.computeFaceNormals();
                     
				} );
                    dae.scale.set(130,30,130);
                    scene.add(dae)
            });
}